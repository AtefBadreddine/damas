<?php

namespace App\Http\Controllers\WhatsAppApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WhatsAppTemplateController extends Controller
{
    private $templateName = 'urban_october';

    public function index()
    {
        $template = null;
        $error = null;
        try {
            $template = $this->loadTemplate();
        } catch (\Exception $e) {
            $error = $e->getMessage();
        }

        return response()->view('admin.whatsapp_templates.index', [
            'template' => $template,
            'loadError' => $error,
            'contacts' => DB::table('whatsapp_contacts')->orderBy('name')->get(),
            'batchStorageKey' => 'wa-template-batch:' . (string) \Auth::id() . ':' .
                (string) config('whatsapp.phone_number_id') . ':' . $this->templateName,
        ])->header('Cache-Control', 'private, no-store');
    }

    public function send(Request $request)
    {
        // This project currently bypasses global CSRF checks: verify here explicitly.
        $csrf = $request->input('_token');
        $sessionCsrf = $request->session()->token();
        if (!is_string($csrf) || !is_string($sessionCsrf) || $sessionCsrf === '' ||
            !hash_equals($sessionCsrf, $csrf)) {
            return $this->reply('Session expired. Reload the page.', 403);
        }

        $key = $request->input('request_id');
        $contactId = filter_var($request->input('contact_id'), FILTER_VALIDATE_INT);
        if (!is_string($key) || !preg_match('/^[a-f0-9]{32}$/D', $key) || !$contactId || $contactId < 1) {
            return $this->reply('Select a contact and reload the page if necessary.', 422);
        }
        if ((string) $request->input('consent') !== '1') {
            return $this->reply('Confirm that this contact agreed to receive these messages.', 422);
        }

        // Check this before loading Meta: repeated requests never trigger another send.
        $existing = DB::table('whatsapp_messages')->where('template_request_id', $key)->first();
        if ($existing) {
            return $this->existingResult($existing);
        }

        $contact = DB::table('whatsapp_contacts')->where('id', $contactId)->first();
        if (!$contact || !preg_match('/^[1-9][0-9]{6,14}$/D', (string) $contact->phone)) {
            return $this->reply('The contact is missing or its phone number is invalid.', 422);
        }
        $expectedPhone = $request->input('expected_phone');
        if (!is_string($expectedPhone) || $expectedPhone !== (string) $contact->phone) {
            return $this->reply('This contact phone number changed since selection. Review the contact before sending.', 422);
        }

        try {
            $template = $this->loadTemplate();
            $fingerprint = $request->input('template_hash');
            if (!is_string($fingerprint) || !hash_equals($template['hash'], $fingerprint)) {
                return $this->reply('The template changed. Reload and check the new preview.', 409, ['stop_batch' => true]);
            }
            $values = $request->input('params', []);
            if (!is_array($values)) {
                return $this->reply('Invalid template values.', 422);
            }
            $components = [];
            $snapshot = [];
            foreach ($template['parts'] as $part) {
                $text = $part['text'];
                $parameters = [];
                $replacements = [];
                foreach ($part['fields'] as $field) {
                    $value = isset($values[$field['key']]) ? $values[$field['key']] : null;
                    if (!is_string($value) || trim($value) === '' || mb_strlen($value, 'UTF-8') > 1024 ||
                        preg_match('/[\r\n\t]/', $value)) {
                        return $this->reply('Fill every variable with a single line of text (up to 1024 characters).', 422);
                    }
                    $value = trim($value);
                    $parameters[] = ['type' => 'text', 'text' => $value];
                    $replacements['{{' . $field['position'] . '}}'] = $value;
                }
                $snapshot[] = strtr($text, $replacements);
                if ($parameters) {
                    $components[] = ['type' => $part['type'], 'parameters' => $parameters];
                }
            }
            foreach ($template['buttons'] as $index => $button) {
                $snapshot[] = '[' . $button['text'] . ']';
                if ($button['type'] === 'QUICK_REPLY') {
                    $components[] = [
                        'type' => 'button', 'sub_type' => 'quick_reply', 'index' => (string) $index,
                        'parameters' => [[
                            'type' => 'payload',
                            'payload' => $this->templateName . ':button:' . $index,
                        ]],
                    ];
                }
            }
            $phoneId = (string) config('whatsapp.phone_number_id');
            if (!preg_match('/^[0-9]+$/D', $phoneId)) {
                throw new \RuntimeException('Configure whatsapp.phone_number_id first.');
            }
            $outbound = [
                'messaging_product' => 'whatsapp', 'to' => (string) $contact->phone,
                'type' => 'template',
                'template' => ['name' => $this->templateName, 'language' => ['code' => $template['language']]],
            ];
            if ($components) {
                $outbound['template']['components'] = $components;
            }
            $encoded = json_encode($outbound, JSON_UNESCAPED_UNICODE);
            if ($encoded === false) {
                throw new \RuntimeException('Unable to encode template values.');
            }
        } catch (\Exception $e) {
            return $this->reply($e->getMessage(), 422, ['stop_batch' => true]);
        }

        $now = gmdate('Y-m-d H:i:s');
        try {
            // Persist BEFORE making the external request. The unique key also handles double clicks.
            $localId = DB::table('whatsapp_messages')->insertGetId([
                'template_request_id' => $key,
                'phone_number_id' => $phoneId,
                'contact_phone' => (string) $contact->phone,
                'meta_message_id' => null,
                'direction' => 'outgoing',
                'message_type' => 'template',
                'body' => '[Template: ' . $this->templateName . "]\n" . implode("\n\n", $snapshot),
                'status' => 'sending',
                'reply_to_meta_id' => null,
                'error_code' => null,
                'message_at' => $now, 'created_at' => $now, 'updated_at' => $now,
            ]);
        } catch (\Exception $e) {
            $existing = DB::table('whatsapp_messages')->where('template_request_id', $key)->first();
            if ($existing) {
                return $this->existingResult($existing);
            }
            \Log::error('Could not store outgoing template.', ['exception_class' => get_class($e)]);
            return $this->reply('Could not save the message. Nothing was sent. Check the SQL setup and Laravel log.', 500);
        }

        try {
            $result = $this->graph($phoneId . '/messages', $encoded);
        } catch (\Throwable $e) {
            $result = ['http' => 0, 'data' => null];
        }
        $data = $result['data'];
        $metaId = isset($data['messages'][0]['id']) && is_string($data['messages'][0]['id'])
            ? $data['messages'][0]['id'] : null;
        $accepted = $result['http'] >= 200 && $result['http'] < 300 && !empty($metaId);
        $rejected = !$accepted && $result['http'] >= 400 && $result['http'] < 500 &&
            $result['http'] !== 408 && isset($data['error']);
        $status = $accepted ? 'accepted' : ($rejected ? 'failed' : 'unknown');
        $code = isset($data['error']['code']) ? (int) $data['error']['code'] : null;
        try {
            DB::table('whatsapp_messages')->where('id', $localId)->update([
                'status' => $status, 'meta_message_id' => $accepted ? $metaId : null,
                'error_code' => $code, 'updated_at' => gmdate('Y-m-d H:i:s'),
            ]);
        } catch (\Exception $e) {
            \Log::error('Template result could not be saved.', [
                'local_message_id' => $localId, 'meta_message_id' => $metaId, 'status' => $status,
            ]);
            return $this->reply(
                ($accepted ? 'Meta accepted the template' : 'The sending outcome needs checking') .
                ', but its database status could not be saved. Do not resend.', 500,
                ['attempted' => true, 'status' => $status, 'local_id' => $localId]);
        }

        $message = $accepted ? 'Meta accepted the template. It is saved in the chat. Delivery is not yet confirmed.' :
            ($rejected ? 'Meta rejected the template. Error code: ' . $code . '.' :
                'Sending could not be confirmed. Check the recipient before attempting another send.');
        if (!$accepted) {
            \Log::warning('Template send result.', ['local_message_id' => $localId,
                'http_status' => $result['http'], 'meta_error_code' => $code, 'status' => $status]);
        }
        return $this->reply($message, $accepted ? 200 : ($rejected ? 422 : 502), [
            'attempted' => true, 'status' => $status, 'local_id' => $localId,
            // Pause on a shared API/account problem rather than failing every remaining contact.
            'stop_batch' => !$accepted && ($status === 'unknown' || $result['http'] === 429 ||
                in_array($code, [4, 10, 17, 32, 190, 200, 613, 80007, 130429, 131031, 131048], true)),
            'chat_url' => route('admin.whatsapp_chat', ['contact_id' => $contactId]),
        ]);
    }

    private function loadTemplate()
    {
        $waba = (string) config('whatsapp.business_account_id');
        if (!preg_match('/^[0-9]+$/D', $waba)) {
            throw new \RuntimeException('Add business_account_id to config/whatsapp.php and WHATSAPP_BUSINESS_ACCOUNT_ID to .env.');
        }
        $result = $this->graph($waba . '/message_templates?' . http_build_query([
            'name' => $this->templateName, 'limit' => 100,
            'fields' => 'id,name,language,status,components',
        ]));
        if ($result['http'] !== 200 || !isset($result['data']['data'])) {
            $code = isset($result['data']['error']['code']) ? (int) $result['data']['error']['code'] : 0;
            throw new \RuntimeException('Could not load the template from Meta. HTTP ' . $result['http'] .
                ', error code ' . $code . '. Check WABA ID and token access, including whatsapp_business_management.');
        }
        $matches = [];
        foreach ($result['data']['data'] as $row) {
            if ($row['name'] === $this->templateName && $row['status'] === 'APPROVED' &&
                ($row['language'] === 'ar' || strpos($row['language'], 'ar_') === 0)) {
                $matches[] = $row;
            }
        }
        if (count($matches) !== 1) {
            throw new \RuntimeException('Expected one approved Arabic capture_client_ar template in this WhatsApp account. Check its status and language in Meta.');
        }
        $row = $matches[0];
        $parts = [];
        $buttons = [];
        foreach ($row['components'] as $component) {
            $type = strtoupper($component['type']);
            if ($type === 'BUTTONS') {
                foreach ($component['buttons'] as $button) {
                    if (!in_array($button['type'], ['QUICK_REPLY', 'URL', 'PHONE_NUMBER'], true) ||
                        (isset($button['url']) && strpos($button['url'], '{{') !== false)) {
                        throw new \RuntimeException('This template has a button that needs additional setup. This sender supports quick replies and static website/phone buttons.');
                    }
                    $buttons[] = $button;
                }
                continue;
            }
            if (!in_array($type, ['HEADER', 'BODY', 'FOOTER'], true) ||
                ($type === 'HEADER' && (!isset($component['format']) || $component['format'] !== 'TEXT'))) {
                throw new \RuntimeException('This sender supports text templates. This template has a media or special component; its sending parameters need to be added first.');
            }
            $text = isset($component['text']) ? $component['text'] : '';
            preg_match_all('/\{\{([^{}]+)\}\}/', $text, $found);
            $positions = array_values(array_unique($found[1]));
            foreach ($positions as $position) {
                if (!ctype_digit($position) || (int) $position < 1 || $type === 'FOOTER') {
                    throw new \RuntimeException('This sender supports numbered text variables, such as {{1}}. This template uses another parameter format.');
                }
            }
            sort($positions, SORT_NUMERIC);
            $fields = [];
            foreach ($positions as $offset => $position) {
                if ((int) $position !== $offset + 1) {
                    throw new \RuntimeException('Template variable numbering is not consecutive.');
                }
                $fields[] = ['key' => strtolower($type) . '_' . $position, 'position' => $position];
            }
            $parts[] = ['type' => strtolower($type), 'text' => $text, 'fields' => $fields];
        }
        return ['name' => $row['name'], 'language' => $row['language'], 'parts' => $parts,
            'buttons' => $buttons, 'hash' => hash('sha256', json_encode($row))];
    }

    private function graph($path, $body = null)
    {
        $token = config('whatsapp.access_token');
        $version = config('whatsapp.api_version');
        if (!is_string($token) || $token === '' || !is_string($version) ||
            !preg_match('/^v[0-9]+\.[0-9]+$/D', $version)) {
            throw new \RuntimeException('Configure whatsapp.access_token and whatsapp.api_version first.');
        }
        $curl = curl_init('https://graph.facebook.com/' . $version . '/' . $path);
        if ($curl === false) {
            throw new \RuntimeException('Unable to initialize cURL.');
        }
        try {
            $options = [CURLOPT_RETURNTRANSFER => true, CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_TIMEOUT => 30, CURLOPT_SSL_VERIFYPEER => true, CURLOPT_SSL_VERIFYHOST => 2,
                CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . $token, 'Content-Type: application/json']];
            if ($body !== null) {
                $options[CURLOPT_POST] = true;
                $options[CURLOPT_POSTFIELDS] = $body;
            }
            if (!curl_setopt_array($curl, $options)) {
                throw new \RuntimeException('Unable to configure cURL.');
            }
            $raw = curl_exec($curl);
            $http = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);
            return ['http' => $http, 'data' => $raw === false ? null : json_decode($raw, true)];
        } finally {
            curl_close($curl);
        }
    }

    private function existingResult($row)
    {
        $accepted = in_array($row->status, ['accepted', 'sent', 'delivered', 'read'], true);
        return $this->reply($accepted ? 'This request was already accepted. No second message was sent.' :
            'This request already exists (' . $row->status . '). Check the chat and recipient; no second message was sent.',
            $accepted ? 200 : 409, ['attempted' => true, 'status' => $row->status, 'local_id' => $row->id]);
    }

    private function reply($message, $http, array $extra = [])
    {
        return response()->json(array_merge(['ok' => $http === 200, 'message' => $message], $extra), $http)
            ->header('Cache-Control', 'private, no-store');
    }
}
