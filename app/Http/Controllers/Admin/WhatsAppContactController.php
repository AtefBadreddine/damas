<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class WhatsAppContactController extends Controller
{
    public function index(Request $request)
    {
        $this->validate($request, [
            'q' => 'string|max:191',
        ]);
        $search = trim((string) $request->query('q', ''));
        $query = DB::table('whatsapp_contacts');
        if ($search !== '') {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }
        $contacts = $query->orderBy('id', 'desc')->paginate(25);
        $contacts->appends(['q' => $search]);
        return response()
            ->view('admin.whatsapp_contacts.index', [
                'contacts' => $contacts,
                'search' => $search,
            ])
            ->header('Cache-Control', 'private, no-store');
    }
    public function store(Request $request)
    {
        $sessionToken = $request->session()->token();
        $submittedToken = $request->input('_token');
        if (!is_string($sessionToken) || $sessionToken === '' ||
            !is_string($submittedToken) ||
            !hash_equals($sessionToken, $submittedToken)) {
            return response('Session verification failed. Reload the page.', 403);
        }
        $this->validate($request, [
            'name' => 'string|max:191',
            'phone' => 'required|string|max:50',
            'notes' => 'string|max:5000',
        ]);
        $phone = trim($request->input('phone'));
        if (!preg_match('/^\+?[0-9\s().-]+$/', $phone)) {
            return redirect()->route('admin.whatsapp_contacts')
                ->withErrors(['phone' => 'Enter a phone number using digits and an international country code.'])
                ->withInput($request->only('name', 'phone', 'notes'));
        }
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (substr($phone, 0, 2) === '00') {
            $phone = substr($phone, 2);
        }
        if (!preg_match('/^[1-9][0-9]{6,14}$/', $phone)) {
            return redirect()->route('admin.whatsapp_contacts')
                ->withErrors(['phone' => 'Use the full international number: 7–15 digits, including country code.'])
                ->withInput($request->only('name', 'phone', 'notes'));
        }
        if (DB::table('whatsapp_contacts')->where('phone', $phone)->exists()) {
            return redirect()->route('admin.whatsapp_contacts')
                ->withErrors(['phone' => 'This phone number is already saved.'])
                ->withInput($request->only('name', 'phone', 'notes'));
        }
        $name = trim((string) $request->input('name', ''));
        $notes = trim((string) $request->input('notes', ''));
        $now = gmdate('Y-m-d H:i:s');
        try {
            DB::table('whatsapp_contacts')->insert([
                'name' => $name === '' ? null : $name,
                'phone' => $phone,
                'notes' => $notes === '' ? null : $notes,
                'opted_in_at' => null,
                'opt_in_source' => null,
                'opted_out_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        } catch (\Illuminate\Database\QueryException $exception) {
            $duplicate = isset($exception->errorInfo[1]) &&
                (int) $exception->errorInfo[1] === 1062;
            if (!$duplicate) {
                \Log::error('Unable to save WhatsApp contact.');
            }
            return redirect()->route('admin.whatsapp_contacts')
                ->withErrors([
                    'phone' => $duplicate
                        ? 'This phone number is already saved.'
                        : 'Unable to save the contact. Please try again.',
                ])
                ->withInput($request->only('name', 'phone', 'notes'));
        }
        return redirect()->route('admin.whatsapp_contacts')
            ->with('contact_success', 'Contact added successfully.');
    }
}
?>