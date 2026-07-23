@extends('layouts.admin.app')
@section('title', 'Payment Settings')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0"><i class="fas fa-credit-card me-2 text-danger"></i>Payment Settings</h1>
    <a href="{{ route('admin.settings.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Settings</a>
</div>

<div class="card shadow-sm">
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.settings.general') }}">General</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.settings.theme') }}">Theme</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.settings.seo') }}">SEO</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.settings.email') }}">Email</a></li>
            <li class="nav-item"><a class="nav-link active" href="{{ route('admin.settings.payment') }}">Payment</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.settings.social') }}">Social</a></li>
        </ul>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            <input type="hidden" name="group" value="payment">

            <!-- Cash on Delivery -->
            <div class="card mb-4 border-success">
                <div class="card-header bg-success bg-opacity-10 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold"><i class="fas fa-money-bill-wave me-2 text-success"></i>Cash on Delivery (COD)</h6>
                    <div class="form-check form-switch mb-0">
                        <input type="checkbox" name="cod_enabled" class="form-check-input" id="cod_enabled" value="1"
                            {{ ($settings['cod_enabled'] ?? '1') === '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="cod_enabled">Enable</label>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">COD Extra Charge</label>
                            <div class="input-group">
                                <span class="input-group-text">&#8377;</span>
                                <input type="number" name="cod_extra_charge" class="form-control"
                                    value="{{ $settings['cod_extra_charge'] ?? '0' }}" min="0" step="0.01">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Razorpay -->
            <div class="card mb-4 border-primary">
                <div class="card-header bg-primary bg-opacity-10 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold"><i class="fas fa-bolt me-2 text-primary"></i>Razorpay</h6>
                    <div class="form-check form-switch mb-0">
                        <input type="checkbox" name="razorpay_enabled" class="form-check-input" id="razorpay_enabled" value="1"
                            {{ ($settings['razorpay_enabled'] ?? '0') === '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="razorpay_enabled">Enable</label>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Key ID</label>
                            <input type="text" name="razorpay_key_id" class="form-control"
                                value="{{ $settings['razorpay_key_id'] ?? '' }}" placeholder="rzp_live_...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Key Secret</label>
                            <input type="password" name="razorpay_key_secret" class="form-control" placeholder="Leave blank to keep current">
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input type="checkbox" name="razorpay_test_mode" class="form-check-input" id="razorpay_test" value="1"
                                    {{ ($settings['razorpay_test_mode'] ?? '1') === '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="razorpay_test">Test Mode</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stripe -->
            <div class="card mb-4 border-info">
                <div class="card-header bg-info bg-opacity-10 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold"><i class="fab fa-stripe me-2 text-info"></i>Stripe</h6>
                    <div class="form-check form-switch mb-0">
                        <input type="checkbox" name="stripe_enabled" class="form-check-input" id="stripe_enabled" value="1"
                            {{ ($settings['stripe_enabled'] ?? '0') === '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="stripe_enabled">Enable</label>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Publishable Key</label>
                            <input type="text" name="stripe_publishable_key" class="form-control"
                                value="{{ $settings['stripe_publishable_key'] ?? '' }}" placeholder="pk_live_...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Secret Key</label>
                            <input type="password" name="stripe_secret_key" class="form-control" placeholder="Leave blank to keep current">
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input type="checkbox" name="stripe_test_mode" class="form-check-input" id="stripe_test" value="1"
                                    {{ ($settings['stripe_test_mode'] ?? '1') === '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="stripe_test">Test Mode</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PayPal -->
            <div class="card mb-4 border-warning">
                <div class="card-header bg-warning bg-opacity-10 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold"><i class="fab fa-paypal me-2 text-warning"></i>PayPal</h6>
                    <div class="form-check form-switch mb-0">
                        <input type="checkbox" name="paypal_enabled" class="form-check-input" id="paypal_enabled" value="1"
                            {{ ($settings['paypal_enabled'] ?? '0') === '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="paypal_enabled">Enable</label>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Client ID</label>
                            <input type="text" name="paypal_client_id" class="form-control"
                                value="{{ $settings['paypal_client_id'] ?? '' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Client Secret</label>
                            <input type="password" name="paypal_client_secret" class="form-control" placeholder="Leave blank to keep current">
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input type="checkbox" name="paypal_sandbox" class="form-check-input" id="paypal_sandbox" value="1"
                                    {{ ($settings['paypal_sandbox'] ?? '1') === '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="paypal_sandbox">Sandbox Mode</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-4">
            <button type="submit" class="btn btn-danger"><i class="fas fa-save me-1"></i> Save Payment Settings</button>
        </form>
    </div>
</div>
@endsection
