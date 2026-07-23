@extends('layouts.frontend.app')
@section('title', 'Order Details - #'.$order->order_number)

@section('content')
<section class="py-5" style="background: #f8fdf8; min-height: 80vh;">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 mb-4">
                @include('frontend.dashboard.sidebar')
            </div>

            <div class="col-lg-9">
                <div class="mb-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold mb-1" style="color: #1B4332;">Order #{{ $order->order_number }}</h2>
                        <p class="text-muted mb-0">Placed on {{ $order->created_at->format('d M, Y \a\t h:i A') }}</p>
                    </div>
                    <a href="{{ route('frontend.dashboard.orders') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>

                {{-- Order Status --}}
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <h6 class="text-muted mb-1 small">Order Status</h6>
                                @php
                                    $statusColors = ['pending'=>'warning','processing'=>'info','shipped'=>'primary','delivered'=>'success','completed'=>'success','cancelled'=>'danger'];
                                    $badgeClass = $statusColors[$order->status] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $badgeClass }} px-3 py-2">{{ ucfirst($order->status) }}</span>
                            </div>
                            <div class="col-md-3">
                                <h6 class="text-muted mb-1 small">Payment Method</h6>
                                <span class="fw-semibold">{{ strtoupper($order->payment_method) }}</span>
                            </div>
                            <div class="col-md-3">
                                <h6 class="text-muted mb-1 small">Payment Status</h6>
                                <span class="badge {{ $order->payment_status === 'paid' ? 'bg-success' : 'bg-warning' }} px-3 py-2">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </div>
                            <div class="col-md-3">
                                <h6 class="text-muted mb-1 small">Order Total</h6>
                                <h5 class="mb-0 fw-bold" style="color: #2E7D32;">₹{{ number_format($order->total, 2) }}</h5>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Order Items --}}
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-bold" style="color: #1B4332;">Order Items</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($item->product && $item->product->featured_image)
                                                <img src="{{ asset('storage/'.$item->product->featured_image) }}" 
                                                     class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;" 
                                                     alt="{{ $item->product_name }}">
                                                @endif
                                                <div>
                                                    <div class="fw-semibold">{{ $item->product_name }}</div>
                                                    @if($item->product_sku)
                                                    <small class="text-muted">SKU: {{ $item->product_sku }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>₹{{ number_format($item->price, 2) }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td class="fw-bold" style="color: #2E7D32;">₹{{ number_format($item->subtotal, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        <div class="row">
                            <div class="col-md-6 offset-md-6">
                                <table class="table table-sm mb-0">
                                    <tr>
                                        <td class="border-0">Subtotal:</td>
                                        <td class="border-0 text-end">₹{{ number_format($order->subtotal, 2) }}</td>
                                    </tr>
                                    @if($order->discount > 0)
                                    <tr>
                                        <td class="border-0 text-success">Discount:</td>
                                        <td class="border-0 text-end text-success">-₹{{ number_format($order->discount, 2) }}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td class="border-0">Shipping:</td>
                                        <td class="border-0 text-end">₹{{ number_format($order->shipping_cost, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border-0">Tax:</td>
                                        <td class="border-0 text-end">₹{{ number_format($order->tax, 2) }}</td>
                                    </tr>
                                    <tr class="fw-bold" style="font-size: 1.1rem;">
                                        <td>Total:</td>
                                        <td class="text-end" style="color: #2E7D32;">₹{{ number_format($order->total, 2) }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Shipping Address --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-bold" style="color: #1B4332;">Shipping Address</h5>
                    </div>
                    <div class="card-body">
                        @php $address = is_array($order->shipping_address) ? $order->shipping_address : json_decode($order->shipping_address, true); @endphp
                        <p class="mb-0">
                            <strong>{{ $address['first_name'] ?? '' }} {{ $address['last_name'] ?? '' }}</strong><br>
                            {{ $address['address'] ?? '' }}<br>
                            {{ $address['city'] ?? '' }}, {{ $address['state'] ?? '' }} {{ $address['postal_code'] ?? '' }}<br>
                            {{ $address['country'] ?? '' }}<br>
                            Phone: {{ $order->customer_phone }}<br>
                            Email: {{ $order->customer_email }}
                        </p>
                    </div>
                </div>

                @if($order->notes)
                <div class="card border-0 shadow-sm mt-3">
                    <div class="card-body">
                        <h6 class="fw-bold mb-2" style="color: #1B4332;">Order Notes:</h6>
                        <p class="text-muted mb-0">{{ $order->notes }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
