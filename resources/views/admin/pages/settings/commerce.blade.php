@extends('layouts.admin.app')
@section('title', 'Commerce Settings')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1"><i class="fas fa-shopping-cart me-2 text-primary"></i>Commerce Settings</h1>
        <p class="text-muted mb-0">Manage currency, tax, shipping and pricing settings</p>
    </div>
    <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Back to Settings
    </a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="row">
    <div class="col-lg-8">
        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            <input type="hidden" name="group" value="commerce">

            <!-- Currency Settings -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-money-bill-wave me-2 text-success"></i>Currency Settings</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Currency Symbol</label>
                            <input type="text" name="currency_symbol" class="form-control" 
                                   value="{{ $data['currency_symbol'] }}" placeholder="₹">
                            <small class="text-muted">Examples: ₹, $, €, £, ¥</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Currency Code</label>
                            <input type="text" name="currency_code" class="form-control" 
                                   value="{{ $data['currency_code'] }}" placeholder="INR">
                            <small class="text-muted">ISO 4217 code (INR, USD, EUR, GBP)</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Currency Position</label>
                            <select name="currency_position" class="form-select">
                                <option value="before" {{ $data['currency_position'] == 'before' ? 'selected' : '' }}>Before Amount (₹100)</option>
                                <option value="after" {{ $data['currency_position'] == 'after' ? 'selected' : '' }}>After Amount (100 ₹)</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tax Settings -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-percent me-2 text-warning"></i>Tax Settings</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input type="checkbox" name="enable_tax" class="form-check-input" 
                                       id="enable_tax" value="1" {{ $data['enable_tax'] ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="enable_tax">Enable Tax Calculation</label>
                            </div>
                            <small class="text-muted d-block mt-1">Enable/disable tax on all products</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Default Tax Rate (%)</label>
                            <div class="input-group">
                                <input type="number" name="default_tax_rate" class="form-control" 
                                       value="{{ $data['default_tax_rate'] }}" min="0" max="100" step="0.01">
                                <span class="input-group-text">%</span>
                            </div>
                            <small class="text-muted">GST/VAT/Sales Tax rate (e.g., 18 for 18%)</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shipping Settings -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-shipping-fast me-2 text-info"></i>Shipping Settings</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input type="checkbox" name="enable_shipping" class="form-check-input" 
                                       id="enable_shipping" value="1" {{ $data['enable_shipping'] ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="enable_shipping">Enable Shipping Charges</label>
                            </div>
                            <small class="text-muted d-block mt-1">Enable/disable shipping charges</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Default Shipping Charge</label>
                            <div class="input-group">
                                <span class="input-group-text">{{ $data['currency_symbol'] }}</span>
                                <input type="number" name="default_shipping_charge" class="form-control" 
                                       value="{{ $data['default_shipping_charge'] }}" min="0" step="0.01">
                            </div>
                            <small class="text-muted">Flat shipping rate for all orders</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Free Shipping Threshold</label>
                            <div class="input-group">
                                <span class="input-group-text">{{ $data['currency_symbol'] }}</span>
                                <input type="number" name="free_shipping_threshold" class="form-control" 
                                       value="{{ $data['free_shipping_threshold'] }}" min="0" step="0.01">
                            </div>
                            <small class="text-muted">Free shipping for orders above this amount (0 = disabled)</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Save Button -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save me-2"></i>Save Commerce Settings
                    </button>
                    <button type="reset" class="btn btn-outline-secondary px-4 ms-2">
                        <i class="fas fa-undo me-2"></i>Reset
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Info Sidebar -->
    <div class="col-lg-4">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h6 class="fw-bold mb-3"><i class="fas fa-info-circle me-2 text-primary"></i>Currency Information</h6>
                <p class="small mb-2"><strong>Common Symbols:</strong></p>
                <ul class="small mb-0">
                    <li>₹ - Indian Rupee (INR)</li>
                    <li>$ - US Dollar (USD)</li>
                    <li>€ - Euro (EUR)</li>
                    <li>£ - British Pound (GBP)</li>
                    <li>¥ - Japanese Yen (JPY)</li>
                </ul>
            </div>
        </div>

        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h6 class="fw-bold mb-3"><i class="fas fa-calculator me-2 text-warning"></i>Tax Examples</h6>
                <ul class="small mb-0">
                    <li><strong>18%:</strong> India GST</li>
                    <li><strong>20%:</strong> UK VAT</li>
                    <li><strong>7-10%:</strong> US Sales Tax</li>
                    <li><strong>0%:</strong> No tax</li>
                </ul>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-3"><i class="fas fa-lightbulb me-2 text-info"></i>Tips</h6>
                <ul class="small mb-0">
                    <li>Tax is calculated on subtotal</li>
                    <li>Shipping is added after tax</li>
                    <li>Free shipping applies automatically</li>
                    <li>Settings affect all new orders</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
