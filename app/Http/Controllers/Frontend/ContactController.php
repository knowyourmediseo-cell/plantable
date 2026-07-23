<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        try {
            $inquiry = Inquiry::create([
                'type'       => 'contact',
                'name'       => $validated['name'],
                'email'      => $validated['email'],
                'phone'      => $validated['phone'] ?? null,
                'subject'    => $validated['subject'],
                'message'    => $validated['message'],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'status'     => 'new',
            ]);
            
            // Send email notification to admin
            try {
                $contactEmail = \App\Models\Setting::get('contact_email', 'info@plantableeco.com');
                $ccEmail = \App\Models\Setting::get('contact_email_cc');
                
                $mail = \Mail::to($contactEmail);
                
                if ($ccEmail) {
                    $mail->cc($ccEmail);
                }
                
                $mail->send(new \App\Mail\ContactFormMail($validated));
                
            } catch (\Exception $e) {
                \Log::error('Failed to send contact form email: ' . $e->getMessage());
            }
            
        } catch (\Throwable $e) {
            \Log::warning('Contact form could not save inquiry: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Thank you for reaching out! We\'ll get back to you within 24 hours.');
    }
}
