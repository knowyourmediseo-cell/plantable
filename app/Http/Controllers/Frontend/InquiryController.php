<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InquiryController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:contact,product,bulk_order,quotation,custom_branding',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
            'product_id' => 'nullable|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $inquiry = Inquiry::create([
            'type' => $request->type,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'company' => $request->company,
            'subject' => $request->subject,
            'message' => $request->message,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'custom_requirements' => $request->custom_requirements,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // TODO: Send email notification to admin

        return response()->json([
            'success' => true,
            'message' => 'Your inquiry has been submitted successfully! We will contact you soon.',
            'inquiry_number' => $inquiry->inquiry_number
        ]);
    }

    public function track()
    {
        return view('frontend.pages.track-inquiry');
    }

    public function trackResult(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $inquiries = Inquiry::where('email', $request->email)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('frontend.pages.track-inquiry', compact('inquiries'));
    }
}
