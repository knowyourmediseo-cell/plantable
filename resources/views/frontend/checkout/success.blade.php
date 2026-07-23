@extends('layouts.frontend.app')

@section('title', 'Order Placed Successfully')

@section('content')
<section class="py-5" style="background: #f8f9fa; min-height: 70vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <!-- Success Banner -->
                <div class="card border-0 shadow-sm mb-4 text-center" style="border-top: 5px solid #2E7D32 !important;">
                    <div class="card-body py-5">
                        <div class="mb-4">
                            <div class="mx-auto d-flex align-items-center justify-content-center rounded-circle"
                                style="width:90px; height:90px; background: linear-gradient(135deg, #2E7D32, #66BB6A);">
                                <i class="fas fa-check fa-2x text-white"></i>
                            </div>
                        </div>
                        <h2 class="fw-bold mb-2" style="color:#1B4332;">Order Placed Successfully!</h2>
                        <p class="text-muted mb-3">Thank you for your order. We'll send you a confirmation email shortly.</p>
                        <div class="d-inline-block px-4 py-2 rounded-pill text-white fw-bold" style="background:#2E7D32; font-size:1.1rem;">
                            Order #{{ $order->order_number }}
                        </div>
                    </div>
                </div>

                <!-- Order Details -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header py-3" style="background:#2E7D32;">
                        <h5 class="mb-0 text-white"><i class="fas fa-clipboard-list me-2"></i>Order Details</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <small class="text-muted d-block">Order Number</small>
                                <strong>{{ $order->order_number }}</strong>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block">Order Date</small>
                                <strong>{{ $order->created_at->format('d M Y, h:i A') }}</strong>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block">Payment Method</small>
                                <strong class="text-capitalize">{{ str_replace('_', ' ', $order->payment_method) }}</strong>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block">Order Status</small>
                                <span class="badge" style="background:#8BC34A;">{{ ucfirst($order->status) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header py-3" style="background:#1B4332;">
                        <h5 class="mb-0 text-white"><i class="fas fa-shopping-bag me-2"></i>Items Ordered</h5>
                    </div>
                    <div class="card-body p-0">
                        @foreach($order->items as $item)
                        <div class="d-flex align-items-center gap-3 p-3 border-bottom">
                            @if($item->product && $item->product->featured_image)
                            <img src="{{ asset('storage/' . $item->product->featured_image) }}"
                                alt="{{ $item->product_name }}"
                                style="width:70px; height:70px; object-fit:cover; border-radius:8px;">
                            @else
                            <div style="width:70px; height:70px; background:#e8f5e9; border-radius:8px; display:flex; align-items:center; justify-content:center;">
                                <i class="fas fa-leaf fa-lg" style="color:#2E7D32;"></i>
                            </div>
                            @endif
                            <div class="flex-grow-1">
                                <p class="mb-0 fw-semibold">{{ $item->product_name }}</p>
                                <small class="text-muted">SKU: {{ $item->product_sku }} | Qty: {{ $item->quantity }}</small>
                            </div>
                            <div class="text-end">
                                <span class="fw-bold" style="color:#2E7D32;">{{ format_price($item->subtotal) }}</span>
                            </div>
                        </div>
                        @endforeach

                        <div class="p-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Subtotal</span>
                                <span>{{ format_price($order->subtotal) }}</span>
                            </div>
                            @if($order->tax > 0)
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Tax</span>
                                <span>{{ format_price($order->tax) }}</span>
                            </div>
                            @endif
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Shipping</span>
                                <span class="{{ $order->shipping_cost > 0 ? '' : 'text-success' }}">
                                    {{ $order->shipping_cost > 0 ? format_price($order->shipping_cost) : 'FREE' }}
                                </span>
                            </div>
                            @if($order->discount > 0)
                            <div class="d-flex justify-content-between mb-2 text-success">
                                <span>Discount</span>
                                <span>-{{ format_price($order->discount) }}</span>
                            </div>
                            @endif
                            <hr>
                            <div class="d-flex justify-content-between">
                                <strong class="fs-5">Total Paid</strong>
                                <strong class="fs-5" style="color:#2E7D32;">{{ format_price($order->total) }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shipping Address -->
                @if($order->shipping_address)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3"><i class="fas fa-map-marker-alt me-2" style="color:#2E7D32;"></i>Shipping Address</h6>
                        <p class="mb-0 text-muted">
                            {{ $order->shipping_address['first_name'] ?? '' }} {{ $order->shipping_address['last_name'] ?? '' }}<br>
                            {{ $order->shipping_address['address'] ?? '' }}<br>
                            {{ $order->shipping_address['city'] ?? '' }}, {{ $order->shipping_address['state'] ?? '' }} - {{ $order->shipping_address['postal_code'] ?? '' }}<br>
                            {{ $order->shipping_address['country'] ?? '' }}
                        </p>
                    </div>
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                    <a href="{{ route('frontend.home') }}" class="btn btn-lg px-5 text-white" style="background:#2E7D32; border:none;"
                        onmouseover="this.style.background='#1B5E20'" onmouseout="this.style.background='#2E7D32'">
                        <i class="fas fa-home me-2"></i>Back to Home
                    </a>
                    <a href="{{ route('frontend.products.index') }}" class="btn btn-lg px-5 btn-outline-success">
                        <i class="fas fa-shopping-bag me-2"></i>Continue Shopping
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
