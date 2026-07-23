@extends('layouts.admin.app')
@section('title', 'Edit Coupon')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0"><i class="fas fa-tag me-2 text-primary"></i>Edit Coupon: <code>{{ $coupon->code }}</code></h1>
    <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.coupons.update', $coupon) }}" method="POST">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Coupon Code <span class="text-danger">*</span></label>
                    <input type="text" name="code" class="form-control @error('code') is-invalid @enderror"
                        value="{{ old('code', $coupon->code) }}" required style="text-transform:uppercase;">
                    @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Description</label>
                    <input type="text" name="description" class="form-control" value="{{ old('description', $coupon->description) }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Discount Type <span class="text-danger">*</span></label>
                    <select name="type" class="form-select @error('type') is-invalid @enderror" required id="coupon-type">
                        <option value="fixed" {{ old('type', $coupon->type) === 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                        <option value="percentage" {{ old('type', $coupon->type) === 'percentage' ? 'selected' : '' }}>Percentage</option>
                    </select>
                    @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Discount Value <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text" id="value-prefix">{{ $coupon->type === 'percentage' ? '%' : '₹' }}</span>
                        <input type="number" name="value" class="form-control @error('value') is-invalid @enderror"
                            value="{{ old('value', $coupon->value) }}" min="0" step="0.01" required>
                        @error('value')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Maximum Discount</label>
                    <div class="input-group">
                        <span class="input-group-text">&#8377;</span>
                        <input type="number" name="maximum_discount" class="form-control" value="{{ old('maximum_discount', $coupon->maximum_discount) }}" min="0" step="0.01">
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Minimum Order Amount</label>
                    <div class="input-group">
                        <span class="input-group-text">&#8377;</span>
                        <input type="number" name="minimum_order_amount" class="form-control" value="{{ old('minimum_order_amount', $coupon->minimum_order_amount) }}" min="0" step="0.01">
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Usage Limit</label>
                    <input type="number" name="usage_limit" class="form-control" value="{{ old('usage_limit', $coupon->usage_limit) }}" min="0" placeholder="Unlimited">
                    <small class="text-muted">Currently used: <strong>{{ $coupon->used ?? 0 }}</strong></small>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Usage Limit Per User</label>
                    <input type="number" name="usage_limit_per_user" class="form-control" value="{{ old('usage_limit_per_user', $coupon->usage_limit_per_user) }}" min="0">
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Start Date</label>
                    <input type="date" name="start_date" class="form-control"
                        value="{{ old('start_date', $coupon->start_date?->format('Y-m-d')) }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">End Date</label>
                    <input type="date" name="end_date" class="form-control"
                        value="{{ old('end_date', $coupon->end_date?->format('Y-m-d')) }}">
                </div>

                <div class="col-md-4 d-flex align-items-end">
                    <div class="form-check form-switch">
                        <input type="hidden" name="status" value="0">
                        <input type="checkbox" name="status" class="form-check-input" id="status" value="1" {{ old('status', $coupon->status) ? 'checked' : '' }}>
                        <label class="form-check-label" for="status">Active</label>
                    </div>
                </div>
            </div>

            <hr class="my-4">
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Update Coupon</button>
                <a href="{{ route('admin.coupons.index') }}" class="btn btn-light">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script>
document.getElementById('coupon-type').addEventListener('change', function() {
    const prefix = document.getElementById('value-prefix');
    prefix.textContent = this.value === 'percentage' ? '%' : '₹';
});
</script>
@endpush
