<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'name' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $subscriber = NewsletterSubscriber::where('email', $request->email)->first();

        if ($subscriber) {
            if ($subscriber->status === 'subscribed') {
                return response()->json([
                    'success' => false,
                    'message' => 'This email is already subscribed to our newsletter.'
                ], 422);
            }

            $subscriber->update([
                'status' => 'subscribed',
                'subscribed_at' => now(),
                'unsubscribed_at' => null,
            ]);
        } else {
            $subscriber = NewsletterSubscriber::create([
                'email' => $request->email,
                'name' => $request->name,
                'status' => 'subscribed',
                'ip_address' => $request->ip(),
            ]);
        }

        // TODO: Send welcome email

        return response()->json([
            'success' => true,
            'message' => 'Successfully subscribed to our newsletter!'
        ]);
    }

    public function unsubscribe($token)
    {
        $subscriber = NewsletterSubscriber::where('token', $token)->firstOrFail();

        $subscriber->update([
            'status' => 'unsubscribed',
            'unsubscribed_at' => now(),
        ]);

        return view('frontend.pages.newsletter-unsubscribed');
    }
}
