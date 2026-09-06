<?php

namespace App\Http\Controllers\PublicSite;

use App\Http\Controllers\Controller;
use App\Mail\ContactInquiryReceived;
use App\Models\ContactInquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function create(): View
    {
        return view('public.contact');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'message' => ['required', 'string', 'max:10000'],
            'website' => ['nullable', 'string', 'max:0'],
        ]);

        unset($data['website']);
        $inquiry = ContactInquiry::create([
            ...$data,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        Mail::to(config('mail.contact_to'))->send(new ContactInquiryReceived($inquiry));

        return back()->with('success', 'Thank you. Your message has been sent.');
    }
}
