<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        $contacts = Contact::where('is_active', true)->get();
        $settings = Setting::all()->keyBy('key');

        return view('frontend.contact', compact('contacts', 'settings'));
    }

    public function send(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'message' => ['required', 'string'],
        ]);

        Contact::create([
            'type' => 'contact_message',
            'value' => $request->message,
            'label' => $request->name . ' | ' . $request->email . ($request->phone ? ' | ' . $request->phone : ''),
            'is_active' => false,
        ]);

        return redirect()->route('contact')->with('success', 'Your message has been sent successfully.');
    }
}
