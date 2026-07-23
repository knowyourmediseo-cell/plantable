@extends('layouts.admin.app')
@section('title', 'Order #{{ $order->order_number }}')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Order #{{ $order->order_number }}</h1>
    <div>
        <a href="{{ route('admin.orders.invoice', $order) }}" class="btn btn-outline-secondary" target="_blank"><i class="fas fa-print me-1"></i> Invoice</a>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary ms-2"><i class="fas fa-arrow-left me-1"></i> Back</a>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header"><h6 class="mb-0">Order Items</h6></div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead class="table-light"><tr><th>Product</th><th>Price</th><th>Qty</th><th>Total</th></tr></thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product?->name ?? $item->product_name ?? 'N/A' }}</td>
                            <td>₹{{ number_format($item->price, 2) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>₹{{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <div class="row justify-content-end">
                    <div class="col-md-4">
                        <table class="table table-sm mb-0">
                            <tr><td>Subtotal</td><td class="text-end">₹{{ number_format($order->subtotal,2) }}</td></tr>
                            @if($order->discount > 0)<tr><td>Discount</td><td class="text-end text-danger">-₹{{ number_format($order->discount,2) }}</td></tr>@endif
                            @if($order->shipping_cost > 0)<tr><td>Shipping</td><td class="text-end">₹{{ number_format($order->shipping_cost,2) }}</td></tr>@endif
                            @if($order->tax > 0)<tr><td>Tax</td><td class="text-end">₹{{ number_format($order->tax,2) }}</td></tr>@endif
                            <tr class="fw-bold"><td>Total</td><td class="text-end">₹{{ number_format($order->total,2) }}</td></tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header"><h6 class="mb-0">Update Status</h6></div>
            <div class="card-body">
                <form action="{{ route('admin.orders.status.update', $order) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <select name="status" class="form-select">
                            @foreach(['pending','processing','shipped','delivered','cancelled','refunded'] as $s)
                            <option value="{{ $s }}" {{ $order->status==$s?'selected':'' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-save me-1"></i> Update</button>
                </form>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header"><h6 class="mb-0">Customer</h6></div>
            <div class="card-body">
                <p class="mb-1"><strong>{{ $order->customer_email }}</strong></p>
                <p class="mb-0 text-muted">{{ $order->customer_phone }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
