@extends('layouts.frontend.app')

@section('title', 'Checkout')

@section('content')
<section class="py-5" style="background: #f8f9fa; min-height: 70vh;">
    <div class="container">

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}" style="color:#2E7D32;">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('frontend.cart.index') }}" style="color:#2E7D32;">Cart</a></li>
                <li class="breadcrumb-item active">Checkout</li>
            </ol>
        </nav>

        <h2 class="fw-bold mb-4" style="color:#1B4332;">
            <i class="fas fa-lock me-2" style="color:#2E7D32;"></i>Secure Checkout
        </h2>

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <form action="{{ route('frontend.checkout.store') }}" method="POST" id="checkout-form">
            @csrf
            <div class="row g-4">

                <!-- Left: Billing Info -->
                <div class="col-lg-7">

                    <!-- Contact Info -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header py-3" style="background:#2E7D32;">
                            <h5 class="mb-0 text-white"><i class="fas fa-user me-2"></i>Contact Information</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">First Name <span class="text-danger">*</span></label>
                                    <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror"
                                        value="{{ old('first_name', $user->name ? explode(' ', $user->name)[0] : '') }}"
                                        placeholder="Enter first name" required>
                                    @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror"
                                        value="{{ old('last_name', $user->name && str_contains($user->name, ' ') ? explode(' ', $user->name, 2)[1] : '') }}"
                                        placeholder="Enter last name" required>
                                    @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', $user->email) }}"
                                        placeholder="your@email.com" required>
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Phone Number <span class="text-danger">*</span></label>
                                    <input type="tel" id="checkout-phone" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                        value="{{ old('phone', $user->phone) }}"
                                        placeholder="98765 43210" required>
                                    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header py-3" style="background:#2E7D32;">
                            <h5 class="mb-0 text-white"><i class="fas fa-map-marker-alt me-2"></i>Shipping Address</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Address <span class="text-danger">*</span></label>
                                    <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                                        value="{{ old('address') }}"
                                        placeholder="House No., Street, Area" required>
                                    @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">City <span class="text-danger">*</span></label>
                                    <input type="text" name="city" class="form-control @error('city') is-invalid @enderror"
                                        value="{{ old('city') }}"
                                        placeholder="City" required>
                                    @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">State <span class="text-danger">*</span></label>
                                    <input type="text" name="state" class="form-control @error('state') is-invalid @enderror"
                                        value="{{ old('state') }}"
                                        placeholder="State" required>
                                    @error('state')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Postal Code <span class="text-danger">*</span></label>
                                    <input type="text" name="postal_code" class="form-control @error('postal_code') is-invalid @enderror"
                                        value="{{ old('postal_code') }}"
                                        placeholder="400001" required>
                                    @error('postal_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Country <span class="text-danger">*</span></label>
                                    <select name="country" class="form-select @error('country') is-invalid @enderror" required>
                                        <option value="">Select Country</option>
                                        <option value="India" {{ old('country') == 'India' ? 'selected' : '' }}>India</option>
                                        <option value="United States" {{ old('country') == 'United States' ? 'selected' : '' }}>United States</option>
                                        <option value="United Kingdom" {{ old('country') == 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
                                        <option value="Canada" {{ old('country') == 'Canada' ? 'selected' : '' }}>Canada</option>
                                        <option value="Australia" {{ old('country') == 'Australia' ? 'selected' : '' }}>Australia</option>
                                        <option value="Germany" {{ old('country') == 'Germany' ? 'selected' : '' }}>Germany</option>
                                        <option value="France" {{ old('country') == 'France' ? 'selected' : '' }}>France</option>
                                    </select>
                                    @error('country')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header py-3" style="background:#2E7D32;">
                            <h5 class="mb-0 text-white"><i class="fas fa-credit-card me-2"></i>Payment Method</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="form-check payment-option p-3 rounded border mb-2" style="cursor:pointer;" id="pay-cod">
                                        <input class="form-check-input" type="radio" name="payment_method" value="cod" id="payment_cod"
                                            {{ old('payment_method', 'cod') == 'cod' ? 'checked' : '' }} required>
                                        <label class="form-check-label fw-semibold ms-2" for="payment_cod" style="cursor:pointer;">
                                            <i class="fas fa-money-bill-wave me-2 text-success"></i>Cash on Delivery (COD)
                                            <small class="d-block text-muted fw-normal">Pay when your order arrives</small>
                                        </label>
                                    </div>
                                    <div class="form-check payment-option p-3 rounded border mb-2" style="cursor:pointer;" id="pay-upi">
                                        <input class="form-check-input" type="radio" name="payment_method" value="upi" id="payment_upi"
                                            {{ old('payment_method') == 'upi' ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold ms-2" for="payment_upi" style="cursor:pointer;">
                                            <i class="fas fa-mobile-alt me-2" style="color:#2E7D32;"></i>UPI Payment
                                            <small class="d-block text-muted fw-normal">Pay via Google Pay, PhonePe, Paytm, etc.</small>
                                        </label>
                                    </div>
                                    <div class="form-check payment-option p-3 rounded border" style="cursor:pointer;" id="pay-bank">
                                        <input class="form-check-input" type="radio" name="payment_method" value="bank_transfer" id="payment_bank"
                                            {{ old('payment_method') == 'bank_transfer' ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold ms-2" for="payment_bank" style="cursor:pointer;">
                                            <i class="fas fa-university me-2" style="color:#2E7D32;"></i>Bank Transfer
                                            <small class="d-block text-muted fw-normal">Direct bank transfer / NEFT / IMPS</small>
                                        </label>
                                    </div>
                                    @error('payment_method')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Notes -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body p-4">
                            <label class="form-label fw-semibold">Order Notes (Optional)</label>
                            <textarea name="notes" class="form-control" rows="3"
                                placeholder="Special instructions for your order...">{{ old('notes') }}</textarea>
                        </div>
                    </div>

                </div>

                <!-- Right: Order Summary -->
                <div class="col-lg-5">
                    <div class="card shadow-sm border-0 position-sticky" style="top: 100px; z-index: 1;">
                        <div class="card-header py-3" style="background:#1B4332;">
                            <h5 class="mb-0 text-white"><i class="fas fa-shopping-bag me-2"></i>Order Summary</h5>
                        </div>
                        <div class="card-body p-0">
                            <!-- Cart Items -->
                            <div class="p-3" style="max-height: 350px; overflow-y: auto;">
                                @foreach($cart->items as $item)
                                <div class="d-flex align-items-center gap-3 py-2 border-bottom">
                                    @if($item->product->featured_image)
                                    <img src="{{ asset('storage/' . $item->product->featured_image) }}"
                                        alt="{{ $item->product->name }}"
                                        style="width:60px; height:60px; object-fit:cover; border-radius:8px;">
                                    @else
                                    <div style="width:60px; height:60px; background:#e8f5e9; border-radius:8px; display:flex; align-items:center; justify-content:center;">
                                        <i class="fas fa-leaf" style="color:#2E7D32;"></i>
                                    </div>
                                    @endif
                                    <div class="flex-grow-1">
                                        <p class="mb-0 fw-semibold small">{{ Str::limit($item->product->name, 40) }}</p>
                                        <small class="text-muted">Qty: {{ $item->quantity }}</small>
                                    </div>
                                    <div class="text-end">
                                        <span class="fw-bold" style="color:#2E7D32;">{{ format_price($item->subtotal) }}</span>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <!-- Totals -->
                            <div class="p-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Subtotal ({{ $cart->total_items }} items)</span>
                                    <span class="fw-semibold">{{ format_price($cart->subtotal) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Shipping</span>
                                    <span class="fw-semibold" style="color: {{ $shipping > 0 ? '#1B4332' : '#2E7D32' }};">
                                        {{ $shipping > 0 ? format_price($shipping) : 'FREE' }}
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Tax</span>
                                    <span class="fw-semibold">{{ format_price($taxAmount) }}</span>
                                </div>
                                @if($cart->discount_amount > 0)
                                <div class="d-flex justify-content-between mb-2 text-success">
                                    <span>Discount</span>
                                    <span>-{{ format_price($cart->discount_amount) }}</span>
                                </div>
                                @endif
                                <hr>
                                <div class="d-flex justify-content-between mb-4">
                                    <strong class="fs-5">Total</strong>
                                    <strong class="fs-5" style="color:#2E7D32;">{{ format_price($total) }}</strong>
                                </div>

                                <button type="submit" class="btn w-100 py-3 fw-bold fs-6 text-white" style="background:#2E7D32; border:none;" id="place-order-btn"
                                    onmouseover="this.style.background='#1B5E20'" onmouseout="this.style.background='#2E7D32'">
                                    <i class="fas fa-check-circle me-2"></i>Place Order
                                </button>

                                <div class="text-center mt-3">
                                    <a href="{{ route('frontend.cart.index') }}" class="text-muted small">
                                        <i class="fas fa-arrow-left me-1"></i>Back to Cart
                                    </a>
                                </div>

                                <div class="d-flex justify-content-center gap-3 mt-3">
                                    <small class="text-muted"><i class="fas fa-lock me-1" style="color:#2E7D32;"></i>Secure</small>
                                    <small class="text-muted"><i class="fas fa-shield-alt me-1" style="color:#2E7D32;"></i>Safe</small>
                                    <small class="text-muted"><i class="fas fa-truck me-1" style="color:#2E7D32;"></i>Fast Delivery</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</section>

@push('styles')
<style>
.payment-option {
    transition: all 0.2s ease;
    border-color: #dee2e6 !important;
}
.payment-option:has(input:checked) {
    border-color: #2E7D32 !important;
    background: #f0faf0;
}
.payment-option:hover {
    border-color: #2E7D32 !important;
    background: #f9fffe;
}
.form-control:focus, .form-select:focus {
    border-color: #2E7D32;
    box-shadow: 0 0 0 0.2rem rgba(46, 125, 50, 0.25);
}
/* Order Summary card stays below navbar dropdown */
.col-lg-5 .card.position-sticky {
    z-index: 1 !important;
}
/* Phone dropdown must show above all cards */
.iti__country-list {
    z-index: 999999 !important;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Payment option click
    $('.payment-option').on('click', function() {
        $(this).find('input[type="radio"]').prop('checked', true);
    });

    // Form submit loading state
    $('#checkout-form').on('submit', function() {
        const btn = $('#place-order-btn');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Placing Order...');
    });
});
</script>
@endpush
@endsection
