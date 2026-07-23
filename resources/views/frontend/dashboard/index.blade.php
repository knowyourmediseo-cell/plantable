@extends('layouts.frontend.app')
@section('title', 'My Dashboard')

@section('content')
<section class="py-5" style="background: #f8fdf8; min-height: 80vh;">
    <div class="container">
        <div class="row">
            {{-- Sidebar --}}
            <div class="col-lg-3 mb-4">
                @include('frontend.dashboard.sidebar')
            </div>

            {{-- Main Content --}}
            <div class="col-lg-9">
                <div class="mb-4">
                    <h2 class="fw-bold" style="color: #1B4332;">
                        <i class="fas fa-tachometer-alt me-2" style="color: #2E7D32;"></i>Dashboard
                    </h2>
                    <p class="text-muted">Welcome back, <strong>{{ $user->name }}</strong>!</p>
                </div>

                {{-- Stats Cards --}}
                <div class="row g-3 mb-4">
                    <div class="col-md-3 col-sm-6">
                        <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #2E7D32 !important;">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted mb-1 small">Total Orders</p>
                                        <h3 class="mb-0 fw-bold" style="color: #2E7D32;">{{ $stats['total_orders'] }}</h3>
                                    </div>
                                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                                         style="width: 50px; height: 50px; background: rgba(46,125,50,0.1);">
                                        <i class="fas fa-shopping-bag fa-lg" style="color: #2E7D32;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #FFA000 !important;">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted mb-1 small">Pending</p>
                                        <h3 class="mb-0 fw-bold" style="color: #FFA000;">{{ $stats['pending_orders'] }}</h3>
                                    </div>
                                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                                         style="width: 50px; height: 50px; background: rgba(255,160,0,0.1);">
                                        <i class="fas fa-clock fa-lg" style="color: #FFA000;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #66BB6A !important;">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted mb-1 small">Completed</p>
                                        <h3 class="mb-0 fw-bold" style="color: #66BB6A;">{{ $stats['completed_orders'] }}</h3>
                                    </div>
                                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                                         style="width: 50px; height: 50px; background: rgba(102,187,106,0.1);">
                                        <i class="fas fa-check-circle fa-lg" style="color: #66BB6A;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #1B4332 !important;">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted mb-1 small">Total Spent</p>
                                        <h3 class="mb-0 fw-bold" style="color: #1B4332;">₹{{ number_format($stats['total_spent'], 2) }}</h3>
                                    </div>
                                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                                         style="width: 50px; height: 50px; background: rgba(27,67,50,0.1);">
                                        <i class="fas fa-rupee-sign fa-lg" style="color: #1B4332;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Recent Orders --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-header border-0 bg-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold" style="color: #1B4332;">
                                <i class="fas fa-list me-2" style="color: #2E7D32;"></i>Recent Orders
                            </h5>
                            <a href="{{ route('frontend.dashboard.orders') }}" class="btn btn-sm text-white" 
                               style="background: #2E7D32;" onmouseover="this.style.background='#1B5E20'" 
                               onmouseout="this.style.background='#2E7D32'">
                                View All
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        @if($orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Order #</th>
                                        <th>Date</th>
                                        <th>Items</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders->take(5) as $order)
                                    <tr>
                                        <td class="fw-semibold">#{{ $order->order_number }}</td>
                                        <td>{{ $order->created_at->format('d M, Y') }}</td>
                                        <td>{{ $order->items->count() }} items</td>
                                        <td class="fw-bold" style="color: #2E7D32;">₹{{ number_format($order->total, 2) }}</td>
                                        <td>
                                            @php
                                                $statusColors = [
                                                    'pending' => 'warning',
                                                    'processing' => 'info',
                                                    'shipped' => 'primary',
                                                    'delivered' => 'success',
                                                    'completed' => 'success',
                                                    'cancelled' => 'danger'
                                                ];
                                                $badgeClass = $statusColors[$order->status] ?? 'secondary';
                                            @endphp
                                            <span class="badge bg-{{ $badgeClass }}">{{ ucfirst($order->status) }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('frontend.dashboard.order.details', $order->order_number) }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="text-center py-5">
                            <i class="fas fa-shopping-bag fa-3x text-muted mb-3 d-block"></i>
                            <p class="text-muted mb-3">No orders yet</p>
                            <a href="{{ route('frontend.products.index') }}" class="btn text-white" style="background: #2E7D32;">
                                Start Shopping
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
.btn-outline-primary {
    color: #2E7D32 !important;
    border-color: #2E7D32 !important;
}
.btn-outline-primary:hover {
    background-color: #2E7D32 !important;
    color: #fff !important;
}
</style>
@endpush
@endsection
