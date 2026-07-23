@extends('layouts.frontend.app')
@section('title', 'My Orders')

@section('content')
<section class="py-5" style="background: #f8fdf8; min-height: 80vh;">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 mb-4">
                @include('frontend.dashboard.sidebar')
            </div>

            <div class="col-lg-9">
                <div class="mb-4">
                    <h2 class="fw-bold" style="color: #1B4332;">
                        <i class="fas fa-shopping-bag me-2" style="color: #2E7D32;"></i>My Orders
                    </h2>
                </div>

                @if($orders->count() > 0)
                    @foreach($orders as $order)
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <h6 class="mb-1 text-muted small">Order Number</h6>
                                    <span class="fw-bold" style="color: #2E7D32;">#{{ $order->order_number }}</span>
                                </div>
                                <div class="col-md-2">
                                    <h6 class="mb-1 text-muted small">Date</h6>
                                    <span>{{ $order->created_at->format('d M, Y') }}</span>
                                </div>
                                <div class="col-md-2">
                                    <h6 class="mb-1 text-muted small">Items</h6>
                                    <span>{{ $order->items->count() }} items</span>
                                </div>
                                <div class="col-md-2">
                                    <h6 class="mb-1 text-muted small">Total</h6>
                                    <span class="fw-bold" style="color: #2E7D32;">₹{{ number_format($order->total, 2) }}</span>
                                </div>
                                <div class="col-md-2">
                                    <h6 class="mb-1 text-muted small">Status</h6>
                                    @php
                                        $statusColors = ['pending'=>'warning','processing'=>'info','shipped'=>'primary','delivered'=>'success','completed'=>'success','cancelled'=>'danger'];
                                        $badgeClass = $statusColors[$order->status] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $badgeClass }}">{{ ucfirst($order->status) }}</span>
                                </div>
                                <div class="col-md-2 text-end">
                                    <a href="{{ route('frontend.dashboard.order.details', $order->order_number) }}" 
                                       class="btn btn-sm text-white" style="background: #2E7D32;">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <div class="mt-4">
                        {{ $orders->links() }}
                    </div>
                @else
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-shopping-bag fa-4x text-muted mb-3 d-block"></i>
                        <h5 style="color: #1B4332;">No Orders Yet</h5>
                        <p class="text-muted mb-4">Start shopping and place your first order!</p>
                        <a href="{{ route('frontend.products.index') }}" class="btn text-white px-4" style="background: #2E7D32;">
                            Browse Products
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
