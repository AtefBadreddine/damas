<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class WhatsAppWebhookController extends Controller
{
    public function verify(Request $request)
    {
        $expected = config('whatsapp.verify_token');
        $mode = $request->query('hub_mode');
        $token = $request->query('hub_verify_token');
        $challenge = $request->query('hub_challenge');
        if (!is_string($expected) || $expected === '') {
            return response('Webhook verification is not configured.', 503);
        }
        if ($mode !== 'subscribe' ||
            !is_string($token) ||
            !hash_equals($expected, $token) ||
            !is_string($challenge) ||
            $challenge === '') {
            \Log::warning('WhatsApp webhook signature rejected');
            return response('Forbidden', 403);
        }
        return response($challenge, 200)
            ->header('Content-Type', 'text/plain')
            ->header('Cache-Control', 'no-store');
    }
    public function receive(Request $request)
    {
        $secret = config('whatsapp.app_secret');
        if (!is_string($secret) || $secret === '') {
            return response('Webhook receiver is not configured.', 503);
        }
        $rawBody = $request->getContent();
        $signature = $request->header('X-Hub-Signature-256');
        $expected = 'sha256=' . hash_hmac('sha256', $rawBody, $secret);
        if (!is_string($signature) || !hash_equals($expected, $signature)) {
            \Log::warning('WhatsApp webhook signature rejected');
            return response('Forbidden', 403);
        }
        $payload = json_decode($rawBody, true);
        if (json_last_error() !== JSON_ERROR_NONE ||
            !is_array($payload) ||
            !isset($payload['object']) ||
            $payload['object'] !== 'whatsapp_business_account') {
            return response('Invalid WhatsApp payload.', 400);
        }
        $autoReplyChecks = [];
        $autoReplyText = "
        يسعدنا ترتيب اجتماع اونلين معكم. لتجهيز خيارات مناسبة لكم، أرسل لنا:
•  هل تخطط للشراء قريباً؟
•  هل تحتاج شقة أم فيلا؟ كم غرفة ؟
•  متى الوقت المناسب للاجتماع اونلين؟
        ";
        $normalise = function ($text) {
            $text = preg_replace(
                '/[\x{200E}\x{200F}\x{061C}\x{FEFF}]/u',
                '',
                (string) $text
            );
        
            return trim(preg_replace('/[\s\p{Z}]+/u', ' ', $text));
        };
        try {
            DB::transaction(function () use (
                $rawBody,
                $payload,
                &$autoReplyChecks,
                $autoReplyText,
                $normalise
            ) {
                $now = gmdate('Y-m-d H:i:s');
                DB::table('webhooks')->insert([
                    'payload' => $rawBody,
                    'received_at' => $now,
                ]);
                $entries = isset($payload['entry']) && is_array($payload['entry'])
                    ? $payload['entry'] : [];
                foreach ($entries as $entry) {
                    $changes = isset($entry['changes']) && is_array($entry['changes'])
                        ? $entry['changes'] : [];
                    foreach ($changes as $change) {
                        if (!isset($change['field']) || $change['field'] !== 'messages') {
                            continue;
                        }
                        $value = isset($change['value']) ? $change['value'] : [];
                        $phoneId = isset($value['metadata']['phone_number_id'])
                            ? (string) $value['metadata']['phone_number_id'] : '';
                        if ($phoneId === '' ||
                            empty($value['messages']) ||
                            !is_array($value['messages'])) {
                            continue;
                        }
                        foreach ($value['messages'] as $message) {
                            if (empty($message['id']) || empty($message['from'])) {
                                continue;
                            }
                            $metaId = (string) $message['id'];
                            // Also check previously stored messages for an unsent automatic reply.
                            $autoReplyChecks[] = [
                                'phone_number_id' => $phoneId,
                                'contact_phone' => (string) $message['from'],
                                'incoming_meta_id' => $metaId,
                            ];
                            $exists = DB::table('whatsapp_messages')
                                ->where('phone_number_id', $phoneId)
                                ->where('meta_message_id', $metaId)
                                ->exists();
                            if ($exists) {
                                continue;
                            }
                            $type = isset($message['type']) ? (string) $message['type'] : 'unknown';
                            $buttonId = null;
                            if ($type === 'button' && isset($message['button']['payload'])) {
                                $buttonId = (string) $message['button']['payload'];
                            } elseif (
                                $type === 'interactive' &&
                                isset($message['interactive']['button_reply']['id'])
                            ) {
                                $buttonId = (string) $message['interactive']['button_reply']['id'];
                            } elseif (
                                $type === 'interactive' &&
                                isset($message['interactive']['list_reply']['id'])
                            ) {
                                $buttonId = (string) $message['interactive']['list_reply']['id'];
                            }
                            $mediaTypes = ['image', 'audio', 'video', 'document'];
                            $mediaId = null;
                            if (in_array($type, $mediaTypes, true) &&
                                isset($message[$type]['id'])) {
                                $mediaId = (string) $message[$type]['id'];
                            }
                            $mediaFilename = $type === 'document' &&
                                isset($message['document']['filename']) &&
                                is_string($message['document']['filename'])
                                    ? mb_substr($message['document']['filename'], 0, 255, 'UTF-8')
                                    : null;
                            $body = null;
                            if ($type === 'text' && isset($message['text']['body'])) {
                                $body = $message['text']['body'];
                            } elseif (isset($message[$type]['caption'])) {
                                $body = $message[$type]['caption'];
                            } elseif ($type === 'audio') {
                                $body = '[Voice message]';
                            } elseif ($type === 'document') {
                                $body = isset($message['document']['filename'])
                                    ? (string) $message['document']['filename']
                                    : '[Document]';
                            } elseif ($type === 'video') {
                                $body = '[Video]';
                            } elseif ($type === 'button') {
                                $body = isset($message['button']['text'])
                                    ? (string) $message['button']['text']
                                    : '[Button]';
                            } elseif ($type === 'interactive') {
                                if (isset($message['interactive']['button_reply']['title'])) {
                                    $body = $message['interactive']['button_reply']['title'];
                                } elseif (isset($message['interactive']['list_reply']['title'])) {
                                    $body = $message['interactive']['list_reply']['title'];
                                } else {
                                    $body = '[Interactive reply]';
                                }
                            }
                            $timestamp = isset($message['timestamp'])
                                ? (string) $message['timestamp'] : '';
                            $messageAt = ctype_digit($timestamp) && (int) $timestamp > 0
                                ? gmdate('Y-m-d H:i:s', (int) $timestamp) : $now;
                            try {
                                DB::table('whatsapp_messages')->insert([
                                    'phone_number_id' => $phoneId,
                                    'contact_phone' => (string) $message['from'],
                                    'meta_message_id' => $metaId,
                                    'direction' => 'incoming',
                                    'message_type' => $type,
                                    'body' => is_string($body) ? $body : null,
                                    'status' => 'received',
                                    'reply_to_meta_id' => isset($message['context']['id'])
                                        ? (string) $message['context']['id'] : null,
                                    'error_code' => null,
                                    'message_at' => $messageAt,
                                    'created_at' => $now,
                                    'updated_at' => $now,
                                    'media_id' => $mediaId,
                                    'media_filename' => $mediaFilename,
                                ]);
                            } catch (\Illuminate\Database\QueryException $exception) {
                                $driverCode = isset($exception->errorInfo[1])
                                    ? (int) $exception->errorInfo[1] : 0;
                            
                                if ($driverCode !== 1062) {
                                    throw $exception;
                                }
                            
                                // Another webhook request already inserted this incoming message.
                                continue;
                            }
                            
                            // Match text or reply titles, without matching media captions.
                            $isMeetingRequest =
                                in_array($type, ['text', 'button', 'interactive'], true) &&
                                $normalise($body) === $normalise('أريد اجتماع أونلاين');
                            
                            // Avoid automatically answering old messages delivered much later.
                            $isRecent =
                                ctype_digit($timestamp) &&
                                (int) $timestamp > time() - 86340;
                            
                            $isConfiguredNumber =
                                $phoneId === (string) config('whatsapp.phone_number_id');
                            
                            if ($isMeetingRequest && $isRecent && $isConfiguredNumber) {
                                // Saved in the same transaction as the incoming message.
                                DB::table('whatsapp_messages')->insert([
                                    'phone_number_id' => $phoneId,
                                    'contact_phone' => (string) $message['from'],
                                    'meta_message_id' => null,
                                    'direction' => 'outgoing',
                                    'message_type' => 'text',
                                    'body' => $autoReplyText,
                                    'status' => 'sending',
                                    'reply_to_meta_id' => $metaId,
                                    'error_code' => null,
                                    'message_at' => $now,
                                    'created_at' => $now,
                                    'updated_at' => $now,
                                    'media_id' => null,
                                    'media_filename' => null,
                                ]);
                            }
                        }
                    }
                }
            });
        } catch (\Exception $exception) {
            \Log::error('Failed to save WhatsApp webhook or message.', [
                'exception_class' => get_class($exception),
                'code' => (string) $exception->getCode(),
            ]);
            return response('Unable to save event.', 503);
        }
        // The database transaction has committed. API calls happen here.
        foreach ($autoReplyChecks as $check) {
            try {
                $this->sendMeetingAutoReply(
                    $check['phone_number_id'],
                    $check['contact_phone'],
                    $check['incoming_meta_id'],
                    $autoReplyText
                );
            } catch (\Throwable $exception) {
                \Log::error('WhatsApp automatic reply processing failed.', [
                    'incoming_meta_id' => $check['incoming_meta_id'],
                    'exception_class' => get_class($exception),
                ]);
            }
        }
        return response('EVENT_RECEIVED', 200)
            ->header('Content-Type', 'text/plain');
    }
    private function sendMeetingAutoReply(
        $phoneId,
        $to,
        $incomingMetaId,
        $replyText
    ) {
        $token = config('whatsapp.access_token');
        $version = config('whatsapp.api_version');
    
        if (
            !is_string($token) || $token === '' ||
            !is_string($version) ||
            !preg_match('/^v[0-9]+\.[0-9]+$/', $version) ||
            !preg_match('/^[0-9]+$/', $phoneId) ||
            $phoneId !== (string) config('whatsapp.phone_number_id')
        ) {
            \Log::warning('WhatsApp automatic reply configuration is invalid.');
            return;
        }
    
        $reply = DB::table('whatsapp_messages')
            ->where('phone_number_id', $phoneId)
            ->where('contact_phone', $to)
            ->where('direction', 'outgoing')
            ->where('reply_to_meta_id', $incomingMetaId)
            ->where('body', $replyText)
            ->where('status', 'sending')
            ->orderBy('id')
            ->first();
    
        if (!$reply) {
            return;
        }
    
        $incoming = DB::table('whatsapp_messages')
            ->where('phone_number_id', $phoneId)
            ->where('contact_phone', $to)
            ->where('direction', 'incoming')
            ->where('meta_message_id', $incomingMetaId)
            ->first();
    
        $incomingAt = $incoming
            ? strtotime($incoming->message_at . ' UTC')
            : false;
    
        if ($incomingAt === false || $incomingAt <= time() - 86340) {
            DB::table('whatsapp_messages')
                ->where('id', $reply->id)
                ->where('status', 'sending')
                ->update([
                    'status' => 'failed',
                    'updated_at' => gmdate('Y-m-d H:i:s'),
                ]);
    
            \Log::warning('WhatsApp automatic reply expired before sending.', [
                'local_message_id' => $reply->id,
            ]);
    
            return;
        }
    
        $json = json_encode([
            'messaging_product' => 'whatsapp',
            'to' => $to,
            'type' => 'text',
            'text' => [
                'preview_url' => false,
                'body' => $replyText,
            ],
        ], JSON_UNESCAPED_UNICODE);
    
        if ($json === false) {
            throw new \RuntimeException('Unable to encode automatic reply.');
        }
    
        // Atomically reserve this reply. Only one request can claim it.
        // Until Meta confirms acceptance, its sending outcome is unknown.
        $claimed = DB::table('whatsapp_messages')
            ->where('id', $reply->id)
            ->where('status', 'sending')
            ->update([
                'status' => 'unknown',
                'updated_at' => gmdate('Y-m-d H:i:s'),
            ]);
    
        if ($claimed !== 1) {
            return;
        }
    
        $curl = null;
        $rawResponse = false;
        $httpStatus = 0;
    
        try {
            $curl = curl_init(
                'https://graph.facebook.com/' .
                $version . '/' . $phoneId . '/messages'
            );
    
            if ($curl === false) {
                throw new \RuntimeException('Unable to initialize cURL.');
            }
    
            $configured = curl_setopt_array($curl, [
                CURLOPT_POST => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CONNECTTIMEOUT => 5,
                CURLOPT_TIMEOUT => 15,
                CURLOPT_SSL_VERIFYPEER => true,
                CURLOPT_SSL_VERIFYHOST => 2,
                CURLOPT_HTTPHEADER => [
                    'Authorization: Bearer ' . $token,
                    'Content-Type: application/json',
                ],
                CURLOPT_POSTFIELDS => $json,
            ]);
    
            if (!$configured) {
                throw new \RuntimeException('Unable to configure cURL.');
            }
    
            $rawResponse = curl_exec($curl);
            $httpStatus = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);
        } finally {
            if ($curl !== null && $curl !== false) {
                curl_close($curl);
            }
        }
    
        $result = is_string($rawResponse)
            ? json_decode($rawResponse, true)
            : null;
    
        $metaId = isset($result['messages'][0]['id']) &&
            is_string($result['messages'][0]['id'])
                ? $result['messages'][0]['id']
                : null;
    
        $accepted =
            $httpStatus >= 200 &&
            $httpStatus < 300 &&
            $metaId !== null &&
            $metaId !== '';
    
        $rejected =
            $httpStatus >= 400 &&
            $httpStatus < 500 &&
            $httpStatus !== 408 &&
            isset($result['error']) &&
            is_array($result['error']);
    
        $status = $accepted
            ? 'accepted'
            : ($rejected ? 'failed' : 'unknown');
    
        $errorCode = isset($result['error']['code']) &&
            is_numeric($result['error']['code'])
                ? (string) (int) $result['error']['code']
                : null;
    
        DB::table('whatsapp_messages')
            ->where('id', $reply->id)
            ->update([
                'status' => $status,
                'meta_message_id' => $accepted ? $metaId : null,
                'error_code' => $errorCode,
                'updated_at' => gmdate('Y-m-d H:i:s'),
            ]);
    
        if (!$accepted) {
            \Log::warning('WhatsApp automatic reply was not confirmed.', [
                'local_message_id' => $reply->id,
                'http_status' => $httpStatus,
                'status' => $status,
                'error_code' => $errorCode,
            ]);
        }
    }
    public function index()
    {
        $events = DB::table('webhooks')
            ->orderBy('id', 'desc')
            ->paginate(25);
        return response()
            ->view('admin.whatsapp_api.index', ['events' => $events])
            ->header('Cache-Control', 'private, no-store');
    }
    public function send(Request $request)
    {
        $sessionToken = $request->session()->token();
        $submittedToken = $request->input('_token');
        if (!is_string($sessionToken) || $sessionToken === '' ||
            !is_string($submittedToken) ||
            !hash_equals($sessionToken, $submittedToken)) {
            return response('Session verification failed. Reload the page.', 403);
        }
        $this->validate($request, [
            'to' => ['required', 'string', 'regex:/^[1-9][0-9]{6,14}$/'],
            'message' => 'required|string|max:4096',
        ]);
        $to = $request->input('to');
        $message = trim($request->input('message'));
        if ($message === '') {
            return redirect()->route('admin.whatsappapi')
                ->withErrors(['message' => 'Enter a message.'])
                ->withInput($request->only('to', 'message'));
        }
        $token = config('whatsapp.access_token');
        $phoneId = config('whatsapp.phone_number_id');
        $version = config('whatsapp.api_version');
        if (!is_string($token) || $token === '' ||
            !is_string($phoneId) || !preg_match('/^[0-9]+$/', $phoneId) ||
            !is_string($version) || !preg_match('/^v[0-9]+\.[0-9]+$/', $version)) {
            return redirect()->route('admin.whatsappapi')
                ->withErrors(['whatsapp' => 'WhatsApp sending configuration is missing or invalid.'])
                ->withInput($request->only('to', 'message'));
        }
        $payload = json_encode([
            'messaging_product' => 'whatsapp',
            'to' => $to,
            'type' => 'text',
            'text' => [
                'preview_url' => false,
                'body' => $message,
            ],
        ]);
        if ($payload === false) {
            return redirect()->route('admin.whatsappapi')
                ->withErrors(['whatsapp' => 'Unable to encode the message.'])
                ->withInput($request->only('to', 'message'));
        }
        $now = gmdate('Y-m-d H:i:s');
        try {
            $localId = DB::table('whatsapp_messages')->insertGetId([
                'phone_number_id' => $phoneId,
                'contact_phone' => $to,
                'meta_message_id' => null,
                'direction' => 'outgoing',
                'message_type' => 'text',
                'body' => $message,
                'status' => 'sending',
                'reply_to_meta_id' => null,
                'error_code' => null,
                'message_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        } catch (\Exception $exception) {
            \Log::error('Unable to store outgoing WhatsApp message.', [
                'exception_class' => get_class($exception),
                'code' => (string) $exception->getCode(),
            ]);
            return redirect()->route('admin.whatsappapi')
                ->withErrors(['whatsapp' => 'Could not save the message. Nothing was sent to Meta.'])
                ->withInput($request->only('to', 'message'));
        }
        $saveResult = function ($status, $metaId, $errorCode) use ($localId) {
            try {
                $updated = DB::table('whatsapp_messages')
                    ->where('id', $localId)
                    ->update([
                        'status' => $status,
                        'meta_message_id' => $metaId,
                        'error_code' => $errorCode,
                        'updated_at' => gmdate('Y-m-d H:i:s'),
                    ]);
                if ($updated !== 1) {
                    throw new \RuntimeException('Outgoing message row was not updated.');
                }
                return true;
            } catch (\Exception $exception) {
                \Log::error('Unable to update outgoing WhatsApp message result.', [
                    'local_message_id' => $localId,
                    'result_status' => $status,
                    'meta_message_id' => $metaId,
                    'exception_class' => get_class($exception),
                    'code' => (string) $exception->getCode(),
                ]);
                return false;
            }
        };
        $rawResponse = false;
        $httpStatus = 0;
        $curlError = 0;
        $curl = null;
        try {
            $curl = curl_init('https://graph.facebook.com/' . $version . '/' . $phoneId . '/messages');
            if ($curl === false) {
                throw new \RuntimeException('Unable to initialize cURL.');
            }
            $configured = curl_setopt_array($curl, [
                CURLOPT_POST => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_SSL_VERIFYPEER => true,
                CURLOPT_SSL_VERIFYHOST => 2,
                CURLOPT_HTTPHEADER => [
                    'Authorization: Bearer ' . $token,
                    'Content-Type: application/json',
                ],
                CURLOPT_POSTFIELDS => $payload,
            ]);
            if (!$configured) {
                throw new \RuntimeException('Unable to configure cURL.');
            }
            $rawResponse = curl_exec($curl);
            $httpStatus = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $curlError = curl_errno($curl);
        } catch (\Throwable $exception) {
            \Log::warning('WhatsApp sending request interrupted.', [
                'local_message_id' => $localId,
                'exception_class' => get_class($exception),
            ]);
        } finally {
            if (is_resource($curl)) {
                curl_close($curl);
            }
        }
        if ($rawResponse === false) {
            $saved = $saveResult('unknown', null, null);
            \Log::warning('WhatsApp sending outcome unknown.', [
                'local_message_id' => $localId,
                'curl_errno' => $curlError,
                'http_status' => $httpStatus,
            ]);
            return redirect()->route('admin.whatsappapi')->withErrors([
                'whatsapp' => 'Could not confirm sending. Check the recipient before retrying to avoid a duplicate.'
                    . ($saved ? '' : ' The database status also could not be updated.'),
            ]);
        }
        $result = json_decode($rawResponse, true);
        $metaId = isset($result['messages'][0]['id']) && is_string($result['messages'][0]['id'])
            ? $result['messages'][0]['id'] : null;
        if ($httpStatus >= 200 && $httpStatus < 300 && $metaId !== null && $metaId !== '') {
            if (!$saveResult('accepted', $metaId, null)) {
                return redirect()->route('admin.whatsappapi')->withErrors([
                    'whatsapp' => 'Meta accepted the message, but its database record could not be updated. Do not resend it.',
                ]);
            }
            return redirect()->route('admin.whatsappapi')->with(
                'whatsapp_success',
                'Meta accepted the message. It has been saved in the conversation.'
            );
        }
        $errorCode = isset($result['error']['code']) && is_numeric($result['error']['code'])
            ? (string) (int) $result['error']['code'] : null;
        $rejected = $httpStatus >= 400 &&
            $httpStatus < 500 &&
            $httpStatus !== 408 &&
            isset($result['error']) &&
            is_array($result['error']);
        $status = $rejected ? 'failed' : 'unknown';
        $saved = $saveResult($status, null, $errorCode);
        \Log::warning('WhatsApp sending was not accepted or could not be confirmed.', [
            'local_message_id' => $localId,
            'http_status' => $httpStatus,
            'meta_error_code' => $errorCode,
            'result_status' => $status,
        ]);
        $feedback = $rejected
            ? 'Meta rejected the message. HTTP ' . $httpStatus . ', error code ' . ($errorCode !== null ? $errorCode : 'unavailable') . '.'
            : 'Meta did not confirm acceptance. Check the recipient before retrying to avoid a duplicate.';
        if (!$saved) {
            $feedback .= ' The database status also could not be updated.';
        }
        return redirect()->route('admin.whatsappapi')->withErrors([
            'whatsapp' => $feedback,
        ]);
    }
}
?>
