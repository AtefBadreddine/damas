<?php
namespace App\Http\Controllers;
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
        try {
            DB::transaction(function () use ($rawBody, $payload) {
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
                            $exists = DB::table('whatsapp_messages')
                                ->where('phone_number_id', $phoneId)
                                ->where('meta_message_id', $metaId)
                                ->exists();
                            if ($exists) {
                                continue;
                            }
                            $type = isset($message['type']) ? (string) $message['type'] : 'unknown';
                            $body = null;
                            if ($type === 'text' && isset($message['text']['body'])) {
                                $body = $message['text']['body'];
                            } elseif (isset($message[$type]['caption'])) {
                                $body = $message[$type]['caption'];
                            } elseif ($type === 'button' && isset($message['button']['text'])) {
                                $body = $message['button']['text'];
                            } elseif ($type === 'interactive') {
                                if (isset($message['interactive']['button_reply']['title'])) {
                                    $body = $message['interactive']['button_reply']['title'];
                                } elseif (isset($message['interactive']['list_reply']['title'])) {
                                    $body = $message['interactive']['list_reply']['title'];
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
                                ]);
                            } catch (\Illuminate\Database\QueryException $exception) {
                                $driverCode = isset($exception->errorInfo[1])
                                    ? (int) $exception->errorInfo[1] : 0;
                                if ($driverCode !== 1062) {
                                    throw $exception;
                                }
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
        return response('EVENT_RECEIVED', 200)
            ->header('Content-Type', 'text/plain');
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