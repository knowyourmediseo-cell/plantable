<x-mail::message>
# New Contact Form Submission

You have received a new message from your website contact form.

**From:** {{ $inquiry['name'] }}  
**Email:** {{ $inquiry['email'] }}  
@if(!empty($inquiry['phone']))
**Phone:** {{ $inquiry['phone'] }}  
@endif
**Subject:** {{ $inquiry['subject'] }}

---

**Message:**

{{ $inquiry['message'] }}

---

<x-mail::button :url="config('app.url') . '/admin/inquiries'">
View in Admin Dashboard
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
