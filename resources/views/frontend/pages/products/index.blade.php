@extends('layouts.frontend.app')

@section('title', 'Products — Plantable Pens & Pencils')

@push('styles')
<style>
.page-hero { background:linear-gradient(135deg,#1B4332 0%,#2E7D32 100%); padding:56px 0; }
.page-hero h1 { font-size:clamp(1.8rem,4vw,2.8rem);font-weight:800;color:#fff;margin-bottom:8px; }
.page-hero p  { color:rgba(255,255,255,.85);font-size:1.05rem; }

/* Product card — image always fully visible, not cropped */
.prod-card-wrap { height:100%; }
.prod-card {
    background:#fff;
    border-radius:16px;
    overflow:hidden;
    border:1px solid rgba(46,125,50,.12);
    transition:transform .25s,box-shadow .25s;
    display:flex;flex-direction:column;height:100%;
}
.prod-card:hover { transform:translateY(-5px);box-shadow:0 14px 35px rgba(46,125,50,.14); }

/* Fixed-height image box — image contained (not cropped) */
.prod-img-box {
    position:relative;
    background:#f8fdf8;
    height:230px;
    display:flex;align-items:center;justify-content:center;
    overflow:hidden;
    flex-shrink:0;
}
.prod-img-box img {
    max-height:210px;
    max-width:90%;
    width:auto;height:auto;
    object-fit:contain;
    transition:transform .35s ease;
}
.prod-card:hover .prod-img-box img { transform:scale(1.07); }

.prod-body { padding:18px;flex:1;display:flex;flex-direction:column; }
.prod-cat  { font-size:11px;font-weight:700;color:#66BB6A;letter-spacing:.3px;margin-bottom:6px; }
.prod-name { font-size:.95rem;font-weight:700;color:#1B4332;margin-bottom:6px;line-height:1.4;
             display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden; }
.prod-desc { font-size:.8rem;color:#888;line-height:1.6;margin-bottom:10px;
             display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;flex:1; }
.prod-price-row { margin-bottom:14px; }
.prod-old   { font-size:.82rem;color:#bbb;text-decoration:line-through;margin-right:6px; }
.prod-price { font-size:1.25rem;font-weight:800;color:#2E7D32; }
.prod-btn {
    display:block;width:100%;padding:11px 0;
    background:#2E7D32;color:#fff;border:none;border-radius:10px;
    font-weight:700;text-align:center;text-decoration:none;font-size:14px;
    transition:background .2s;
}
.prod-btn:hover { background:#1B5E20;color:#fff; }

/* badges */
.prd-badge { position:absolute;padding:3px 9px;border-radius:20px;font-size:10px;font-weight:800; }
.prd-badge-new  { top:10px;left:10px;background:#2E7D32;color:#fff; }
.prd-badge-bs   { top:10px;left:10px;background:#E65100;color:#fff; }
.prd-badge-sale { top:10px;right:10px;background:#C62828;color:#fff; }
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="page-hero">
    <div class="container">
        <nav aria-label="breadcrumb" style="margin-bottom:10px;">
            <ol class="breadcrumb mb-0" style="background:transparent;padding:0;">
                <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}" style="color:rgba(255,255,255,.7);text-decoration:none;">Home</a></li>
                <li class="breadcrumb-item active" style="color:#fff;">Products</li>
            </ol>
        </nav>
        <h1><i class="fas fa-seedling me-2" style="font-size:.7em;opacity:.8;"></i>Our Products</h1>
        <p>Eco-friendly plantable pens &amp; pencils — write today, grow tomorrow</p>
    </div>
</div>

{{-- Products Grid --}}
<section style="padding:60px 0;background:#f8fdf8;">
    <div class="container">
        <div class="row g-4">
            @forelse($products as $product)
            <div class="col-sm-6 col-lg-4 col-xl-3 prod-card-wrap">
                <div class="prod-card">
                    <div class="prod-img-box">
                        <img src="{{ $product->featured_image_url }}" alt="{{ $product->name }}">
                        @if($product->is_new)<span class="prd-badge prd-badge-new">NEW</span>@endif
                        @if($product->is_bestseller && !$product->is_new)<span class="prd-badge prd-badge-bs">BESTSELLER</span>@endif
                        @if($product->discount_percentage > 0)<span class="prd-badge prd-badge-sale">-{{ $product->discount_percentage }}%</span>@endif
                    </div>
                    <div class="prod-body">
                        <p class="prod-cat"><i class="fas fa-seedling me-1"></i>{{ $product->category->name ?? '' }}</p>
                        <h3 class="prod-name">{{ $product->name }}</h3>
                        <p class="prod-desc">{{ $product->short_description }}</p>
                        <div class="prod-price-row">
                            @if($product->sale_price)
                                <span class="prod-old">₹{{ number_format($product->price,0) }}</span>
                                <span class="prod-price">₹{{ number_format($product->sale_price,0) }}</span>
                            @else
                                <span class="prod-price">₹{{ number_format($product->final_price,0) }}</span>
                            @endif
                        </div>
                        <a href="{{ $product->url }}" class="prod-btn">
                            <i class="fas fa-eye me-1"></i> View Details
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-box-open fa-3x mb-3" style="color:#ccc;"></i>
                <p class="text-muted">No products found.</p>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($products->hasPages())
        <div class="d-flex justify-content-center mt-5">
            {{ $products->links() }}
        </div>
        @endif
    </div>
</section>

@endsection
