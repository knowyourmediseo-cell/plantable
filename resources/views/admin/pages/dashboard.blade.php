@extends('layouts.admin.app')

@section('title', 'Dashboard')

@push('styles')
<style>
/* ── Stat Cards ── */
.stat-card { border:none; border-radius:14px; transition:transform .2s,box-shadow .2s; }
.stat-card:hover { transform:translateY(-3px); box-shadow:0 8px 24px rgba(0,0,0,.1)!important; }
.stat-icon { width:56px;height:56px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.4rem;flex-shrink:0; }

/* ── Category Cards ── */
.cat-admin-card { border:1px solid rgba(46,125,50,.15);border-radius:14px;overflow:hidden;transition:transform .2s,box-shadow .2s; }
.cat-admin-card:hover { transform:translateY(-3px);box-shadow:0 8px 24px rgba(46,125,50,.12)!important; }
.cat-img-box { height:130px;background:#f8fdf8;display:flex;align-items:center;justify-content:center;overflow:hidden; }
.cat-img-box img { max-height:120px;max-width:88%;width:auto;height:auto;object-fit:contain;transition:transform .3s; }
.cat-admin-card:hover .cat-img-box img { transform:scale(1.06); }

/* ── Product Table ── */
.prod-thumb { width:52px;height:52px;background:#f8fdf8;border-radius:8px;border:1px solid rgba(46,125,50,.12);display:flex;align-items:center;justify-content:center;overflow:hidden;flex-shrink:0; }
.prod-thumb img { max-width:48px;max-height:48px;width:auto;height:auto;object-fit:contain; }
.badge-active   { background:#e8f5e9;color:#2E7D32;padding:4px 10px;border-radius:20px;font-size:11px;font-weight:700; }
.badge-inactive { background:#ffebee;color:#c62828;padding:4px 10px;border-radius:20px;font-size:11px;font-weight:700; }
.badge-new      { background:#e8f5e9;color:#2E7D32;padding:3px 8px;border-radius:20px;font-size:10px;font-weight:700; }
.badge-bs       { background:#fff3e0;color:#E65100;padding:3px 8px;border-radius:20px;font-size:10px;font-weight:700; }

/* Section header */
.sec-hdr { display:flex;align-items:center;justify-content:space-between;margin-bottom:20px; }
.sec-hdr h5 { font-weight:700;color:#1B4332;margin:0; }
.sec-hdr a  { font-size:13px;font-weight:600;color:#2E7D32;text-decoration:none; }
.sec-hdr a:hover { text-decoration:underline; }
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="fw-bold mb-1" style="color:#1B4332;">Dashboard</h4>
        <p class="text-muted mb-0" style="font-size:13px;">
            <i class="fas fa-seedling me-1" style="color:#2E7D32;"></i>
            Plantable Pens &amp; Pencils — Store Overview
        </p>
    </div>
    <div class="text-muted" style="font-size:13px;">
        <i class="fas fa-calendar-alt me-1"></i>{{ now()->format('D, d M Y') }}
    </div>
</div>

{{-- ── Row 1: Key Stats ── --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card stat-card shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3 p-3">
                <div class="stat-icon" style="background:#e8f5e9;">
                    <i class="fas fa-layer-group" style="color:#2E7D32;"></i>
                </div>
                <div>
                    <div class="text-muted" style="font-size:12px;font-weight:600;">Active Categories</div>
                    <div class="fw-bold" style="font-size:1.6rem;color:#1B4332;line-height:1.2;">{{ $stats['active_categories'] }}</div>
                    <div style="font-size:11px;color:#66BB6A;">Pens &amp; Pencils</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card stat-card shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3 p-3">
                <div class="stat-icon" style="background:#e8f5e9;">
                    <i class="fas fa-box" style="color:#2E7D32;"></i>
                </div>
                <div>
                    <div class="text-muted" style="font-size:12px;font-weight:600;">Active Products</div>
                    <div class="fw-bold" style="font-size:1.6rem;color:#1B4332;line-height:1.2;">{{ $stats['active_products'] }}</div>
                    <div style="font-size:11px;color:#66BB6A;">Live on store</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card stat-card shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3 p-3">
                <div class="stat-icon" style="background:#e3f2fd;">
                    <i class="fas fa-shopping-cart" style="color:#1565C0;"></i>
                </div>
                <div>
                    <div class="text-muted" style="font-size:12px;font-weight:600;">Total Orders</div>
                    <div class="fw-bold" style="font-size:1.6rem;color:#1B4332;line-height:1.2;">{{ $stats['total_orders'] }}</div>
                    <div style="font-size:11px;color:#E65100;">{{ $stats['pending_orders'] }} pending</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card stat-card shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3 p-3">
                <div class="stat-icon" style="background:#f3e5f5;">
                    <i class="fas fa-rupee-sign" style="color:#6A1B9A;"></i>
                </div>
                <div>
                    <div class="text-muted" style="font-size:12px;font-weight:600;">Total Revenue</div>
                    <div class="fw-bold" style="font-size:1.4rem;color:#1B4332;line-height:1.2;">₹{{ number_format($stats['total_revenue'],0) }}</div>
                    <div style="font-size:11px;color:#66BB6A;">₹{{ number_format($stats['monthly_revenue'],0) }} this month</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── Row 2: More stats ── --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm p-3 text-center">
            <div class="fw-bold" style="font-size:1.5rem;color:#1B4332;">{{ $stats['total_customers'] }}</div>
            <div class="text-muted" style="font-size:12px;">Customers</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm p-3 text-center">
            <div class="fw-bold" style="font-size:1.5rem;color:#E65100;">{{ $stats['pending_inquiries'] }}</div>
            <div class="text-muted" style="font-size:12px;">Pending Inquiries</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm p-3 text-center">
            <div class="fw-bold" style="font-size:1.5rem;color:#1B4332;">{{ $stats['newsletter_subscribers'] }}</div>
            <div class="text-muted" style="font-size:12px;">Newsletter Subscribers</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm p-3 text-center">
            <div class="fw-bold" style="font-size:1.5rem;color:#1565C0;">{{ $stats['total_orders'] > 0 ? number_format($stats['total_revenue'] / max($stats['total_orders'],1),0) : 0 }}</div>
            <div class="text-muted" style="font-size:12px;">Avg. Order Value (₹)</div>
        </div>
    </div>
</div>

{{-- ── Active Categories ── --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <div class="sec-hdr">
            <h5><i class="fas fa-layer-group me-2" style="color:#2E7D32;font-size:.85em;"></i>Active Categories</h5>
            <a href="{{ route('admin.categories.index') }}">Manage Categories →</a>
        </div>
        <div class="row g-3">
            @foreach($activeCategories as $cat)
            <div class="col-6 col-md-3">
                <div class="cat-admin-card card shadow-none">
                    <div class="cat-img-box">
                        <img src="{{ $cat->image_url }}" alt="{{ $cat->name }}">
                    </div>
                    <div class="p-3">
                        <div class="fw-bold" style="color:#1B4332;font-size:.95rem;">{{ $cat->name }}</div>
                        <div class="d-flex align-items-center justify-content-between mt-1">
                            <span style="font-size:12px;color:#666;">
                                <i class="fas fa-box me-1" style="color:#2E7D32;font-size:10px;"></i>
                                {{ $cat->products_count }} products
                            </span>
                            <span class="badge-active">Active</span>
                        </div>
                        <a href="{{ route('admin.categories.edit', $cat->id) }}"
                           class="btn btn-sm w-100 mt-2"
                           style="background:#e8f5e9;color:#2E7D32;border:none;font-size:12px;font-weight:600;border-radius:8px;">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- ── Active Products ── --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <div class="sec-hdr">
            <h5><i class="fas fa-box me-2" style="color:#2E7D32;font-size:.85em;"></i>Active Products</h5>
            <a href="{{ route('admin.products.index') }}">Manage Products →</a>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0" style="font-size:.875rem;">
                <thead>
                    <tr style="background:#f8fdf8;">
                        <th style="font-weight:700;color:#555;border:none;padding:10px 12px;">Product</th>
                        <th style="font-weight:700;color:#555;border:none;">Category</th>
                        <th style="font-weight:700;color:#555;border:none;">Price</th>
                        <th style="font-weight:700;color:#555;border:none;">Seed Type</th>
                        <th style="font-weight:700;color:#555;border:none;">Stock</th>
                        <th style="font-weight:700;color:#555;border:none;">Tags</th>
                        <th style="font-weight:700;color:#555;border:none;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($activeProducts as $product)
                    <tr style="border-bottom:1px solid #f0f0f0;">
                        <td style="padding:10px 12px;">
                            <div class="d-flex align-items-center gap-3">
                                <div class="prod-thumb">
                                    <img src="{{ $product->featured_image_url }}" alt="{{ $product->name }}">
                                </div>
                                <div>
                                    <div class="fw-bold" style="color:#1B4332;line-height:1.3;">{{ $product->name }}</div>
                                    <div class="text-muted" style="font-size:11px;">SKU: {{ $product->sku }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span style="font-size:12px;background:#e8f5e9;color:#2E7D32;padding:3px 10px;border-radius:20px;font-weight:600;">
                                {{ $product->category->name ?? '—' }}
                            </span>
                        </td>
                        <td>
                            @if($product->sale_price)
                                <div class="fw-bold" style="color:#2E7D32;">₹{{ number_format($product->sale_price,0) }}</div>
                                <div style="font-size:11px;color:#bbb;text-decoration:line-through;">₹{{ number_format($product->price,0) }}</div>
                            @else
                                <div class="fw-bold" style="color:#2E7D32;">₹{{ number_format($product->price,0) }}</div>
                            @endif
                        </td>
                        <td>
                            <span style="font-size:12px;color:#555;">
                                <i class="fas fa-seedling me-1" style="color:#2E7D32;font-size:10px;"></i>
                                {{ $product->seed_type ?? '—' }}
                            </span>
                        </td>
                        <td>
                            @if($product->stock_status === 'in_stock')
                                <span style="font-size:11px;background:#e8f5e9;color:#2E7D32;padding:3px 8px;border-radius:20px;font-weight:700;">In Stock</span>
                            @else
                                <span style="font-size:11px;background:#ffebee;color:#c62828;padding:3px 8px;border-radius:20px;font-weight:700;">{{ ucfirst(str_replace('_',' ',$product->stock_status)) }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1 flex-wrap">
                                @if($product->is_new)<span class="badge-new">NEW</span>@endif
                                @if($product->is_featured)<span class="badge-active">★ Featured</span>@endif
                                @if($product->is_bestseller)<span class="badge-bs">Bestseller</span>@endif
                            </div>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.products.edit', $product->id) }}"
                                   class="btn btn-sm"
                                   style="background:#e8f5e9;color:#2E7D32;border:none;border-radius:8px;font-size:12px;font-weight:600;padding:5px 12px;">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('frontend.products.show', $product->slug) }}" target="_blank"
                                   class="btn btn-sm"
                                   style="background:#e3f2fd;color:#1565C0;border:none;border-radius:8px;font-size:12px;font-weight:600;padding:5px 12px;">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ── Recent Orders + Inquiries ── --}}
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="sec-hdr">
                    <h5><i class="fas fa-shopping-cart me-2" style="color:#1565C0;font-size:.85em;"></i>Recent Orders</h5>
                    <a href="{{ route('admin.orders.index') }}">View All →</a>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0" style="font-size:.875rem;">
                        <thead>
                            <tr style="background:#f8f9fa;">
                                <th style="border:none;font-weight:700;color:#555;padding:10px 12px;">Order #</th>
                                <th style="border:none;font-weight:700;color:#555;">Customer</th>
                                <th style="border:none;font-weight:700;color:#555;">Total</th>
                                <th style="border:none;font-weight:700;color:#555;">Status</th>
                                <th style="border:none;font-weight:700;color:#555;">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                            <tr style="border-bottom:1px solid #f0f0f0;">
                                <td style="padding:10px 12px;">
                                    <a href="{{ route('admin.orders.show', $order->id) }}"
                                       style="font-weight:700;color:#2E7D32;text-decoration:none;">
                                        #{{ $order->order_number }}
                                    </a>
                                </td>
                                <td>{{ $order->user ? $order->user->name : ($order->customer_email ?? '—') }}</td>
                                <td class="fw-bold">₹{{ number_format($order->total,0) }}</td>
                                <td>
                                    @php
                                        $sBg = ['completed'=>'#e8f5e9','pending'=>'#fff3e0','cancelled'=>'#ffebee','processing'=>'#e3f2fd'];
                                        $sClr= ['completed'=>'#2E7D32','pending'=>'#E65100','cancelled'=>'#c62828','processing'=>'#1565C0'];
                                        $s   = $order->status ?? 'pending';
                                    @endphp
                                    <span style="font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;background:{{ $sBg[$s]??'#eee' }};color:{{ $sClr[$s]??'#333' }};">
                                        {{ ucfirst($s) }}
                                    </span>
                                </td>
                                <td class="text-muted">{{ $order->created_at->format('d M Y') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center text-muted py-4">No orders yet</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="sec-hdr">
                    <h5><i class="fas fa-envelope me-2" style="color:#E65100;font-size:.85em;"></i>Recent Inquiries</h5>
                    <a href="{{ route('admin.inquiries.index') }}">View All →</a>
                </div>
                @forelse($recentInquiries as $inquiry)
                <div class="d-flex gap-3 mb-3 pb-3" style="border-bottom:1px solid #f0f0f0;">
                    <div class="d-flex align-items-center justify-content-center flex-shrink-0 rounded-circle text-white fw-bold"
                         style="width:38px;height:38px;background:linear-gradient(135deg,#2E7D32,#66BB6A);font-size:.9rem;">
                        {{ strtoupper(substr($inquiry->name??'?',0,1)) }}
                    </div>
                    <div class="flex-grow-1 min-w-0">
                        <div class="fw-bold" style="color:#1B4332;font-size:.88rem;">{{ $inquiry->name }}</div>
                        <div class="text-muted text-truncate" style="font-size:.78rem;">{{ Str::limit($inquiry->message??'',55) }}</div>
                        <div class="text-muted" style="font-size:.72rem;">{{ $inquiry->created_at->diffForHumans() }}</div>
                    </div>
                    @if(($inquiry->status??'pending') === 'pending')
                    <span style="font-size:10px;font-weight:700;background:#fff3e0;color:#E65100;padding:2px 8px;border-radius:20px;height:fit-content;flex-shrink:0;">New</span>
                    @endif
                </div>
                @empty
                <div class="text-center text-muted py-4">
                    <i class="fas fa-inbox fa-2x mb-2 d-block" style="opacity:.3;"></i>No inquiries yet
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection
