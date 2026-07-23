@extends('layouts.admin.app')
@section('title', 'Email Settings')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0"><i class="fas fa-envelope me-2 text-warning"></i>Email Settings</h1>
    <a href="{{ route('admin.settings.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Settings</a>
</div>

<div class="card shadow-sm">
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.settings.general') }}">General</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.settings.theme') }}">Theme</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.settings.seo') }}">SEO</a></li>
            <li class="nav-item"><a class="nav-link active" href="{{ route('admin.settings.email') }}">Email</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.settings.payment') }}">Payment</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.settings.social') }}">Social</a></li>
        </ul>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            <input type="hidden" name="group" value="email">

            <h5 class="fw-bold mb-3">SMTP Configuration</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Mail Driver</label>
                    <select name="mail_driver" class="form-select">
                        <option value="smtp" {{ ($settings['mail_driver'] ?? 'smtp') === 'smtp' ? 'selected' : '' }}>SMTP</option>
                        <option value="mailgun" {{ ($settings['mail_driver'] ?? '') === 'mailgun' ? 'selected' : '' }}>Mailgun</option>
                        <option value="sendgrid" {{ ($settings['mail_driver'] ?? '') === 'sendgrid' ? 'selected' : '' }}>SendGrid</option>
                        <option value="log" {{ ($settings['mail_driver'] ?? '') === 'log' ? 'selected' : '' }}>Log (Testing)</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">SMTP Host</label>
                    <input type="text" name="mail_host" class="form-control"
                        value="{{ $settings['mail_host'] ?? 'smtp.gmail.com' }}" placeholder="smtp.gmail.com">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">SMTP Port</label>
                    <input type="number" name="mail_port" class="form-control"
                        value="{{ $settings['mail_port'] ?? '587' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">SMTP Encryption</label>
                    <select name="mail_encryption" class="form-select">
                        <option value="tls" {{ ($settings['mail_encryption'] ?? 'tls') === 'tls' ? 'selected' : '' }}>TLS</option>
                        <option value="ssl" {{ ($settings['mail_encryption'] ?? '') === 'ssl' ? 'selected' : '' }}>SSL</option>
                        <option value="" {{ ($settings['mail_encryption'] ?? '') === '' ? 'selected' : '' }}>None</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">SMTP Username</label>
                    <input type="text" name="mail_username" class="form-control" value="{{ $settings['mail_username'] ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">SMTP Password</label>
                    <input type="password" name="mail_password" class="form-control" placeholder="Leave blank to keep current">
                </div>
            </div>

            <h5 class="fw-bold mb-3">Sender Information</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">From Email</label>
                    <input type="email" name="mail_from_address" class="form-control"
                        value="{{ $settings['mail_from_address'] ?? 'noreply@plantableeco.com' }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">From Name</label>
                    <input type="text" name="mail_from_name" class="form-control"
                        value="{{ $settings['mail_from_name'] ?? 'Plantable Eco Products' }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Reply-To Email</label>
                    <input type="email" name="mail_reply_to" class="form-control"
                        value="{{ $settings['mail_reply_to'] ?? '' }}" placeholder="support@yourdomain.com">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Admin Notification Email</label>
                    <input type="email" name="admin_email" class="form-control"
                        value="{{ $settings['admin_email'] ?? '' }}" placeholder="admin@yourdomain.com">
                    <small class="text-muted">Receives order & inquiry notifications</small>
                </div>
            </div>

            <h5 class="fw-bold mb-3">Contact Form Emails</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Contact Email (Primary) <span class="text-danger">*</span></label>
                    <input type="email" name="contact_email" class="form-control" required
                        value="{{ $settings['contact_email'] ?? 'info@plantableeco.com' }}" placeholder="info@yourdomain.com">
                    <small class="text-muted">Primary recipient of contact form submissions</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Contact Email CC (Optional)</label>
                    <input type="email" name="contact_email_cc" class="form-control"
                        value="{{ $settings['contact_email_cc'] ?? '' }}" placeholder="sales@yourdomain.com">
                    <small class="text-muted">Carbon copy recipient for contact form emails</small>
                </div>
            </div>

            <h5 class="fw-bold mb-3">Email Notifications</h5>
            <div class="row g-3">
                @foreach([
                    'notify_new_order' => 'New Order',
                    'notify_new_inquiry' => 'New Inquiry',
                    'notify_new_newsletter' => 'New Newsletter Subscriber',
                    'notify_low_stock' => 'Low Stock Alert',
                ] as $key => $label)
                <div class="col-md-3">
                    <div class="form-check form-switch">
                        <input type="checkbox" name="{{ $key }}" class="form-check-input" id="{{ $key }}" value="1"
                            {{ ($settings[$key] ?? '1') === '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="{{ $key }}">{{ $label }}</label>
                    </div>
                </div>
                @endforeach
            </div>

            <hr class="my-4">
            <button type="submit" class="btn btn-warning"><i class="fas fa-save me-1"></i> Save Email Settings</button>
        </form>
    </div>
</div>
@endsection
