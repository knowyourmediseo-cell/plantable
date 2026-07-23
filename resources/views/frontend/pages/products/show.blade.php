@extends('layouts.frontend.app')

@section('title', $product->name . ' — Plantable Eco')

@push('styles')
<style>
/* ─── Product Detail Page ─────────────────────────── */
.page-hero { background:linear-gradient(135deg,#1B4332 0%,#2E7D32 100%); padding:40px 0; }
.page-hero .breadcrumb-item a { color:rgba(255,255,255,.7);text-decoration:none; }
.page-hero .breadcrumb-item.active { color:#fff; }
.page-hero .breadcrumb-item+.breadcrumb-item::before { color:rgba(255,255,255,.5); }

/* ─── Image Zoom (Amazon-style) ───────────────────── */

/* Outer row that holds image-col + zoom-result side by side */
.zoom-row {
    position: relative;
    display: flex;
    align-items: flex-start;
    gap: 0;
}

/* The image box — NO overflow:hidden so lens can be absolute inside */
.zoom-wrapper {
    position: relative;
    width: 100%;
    border-radius: 16px;
    background: #f8fdf8;
    border: 1px solid rgba(46,125,50,.15);
    cursor: crosshair;
    user-select: none;
    flex-shrink: 0;
}

/* Fixed-height image area */
.zoom-container {
    width: 100%;
    height: 440px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    border-radius: 16px;
    position: relative;
}

.zoom-container img#main-img {
    max-width: 88%;
    max-height: 420px;
    width: auto;
    height: auto;
    object-fit: contain;
    pointer-events: none;
    display: block;
    transition: opacity .15s;
}

/* Lens — positioned INSIDE zoom-wrapper (not zoom-container so it's not clipped) */
.zoom-lens {
    display: none;
    position: absolute;
    border: 2px solid #2E7D32;
    border-radius: 6px;
    background: rgba(46,125,50,.1);
    pointer-events: none;
    z-index: 10;
    width: 150px;
    height: 150px;
    box-shadow: 0 0 0 1px rgba(46,125,50,.3);
}

/* Zoom result — fixed positioned so it is NEVER clipped by parent overflow */
.zoom-result {
    display: none;
    position: fixed;
    width: 400px;
    height: 440px;
    border: 1.5px solid rgba(46,125,50,.25);
    border-radius: 16px;
    overflow: hidden;
    background: #fff;
    box-shadow: 0 10px 40px rgba(46,125,50,.2);
    z-index: 9999;
    background-repeat: no-repeat;
    pointer-events: none;
}

/* Zoom hint label */
.zoom-hint {
    position: absolute;
    bottom: 10px;
    left: 50%;
    transform: translateX(-50%);
    background: rgba(27,67,50,.75);
    color: #fff;
    font-size: 11px;
    padding: 4px 12px;
    border-radius: 20px;
    pointer-events: none;
    z-index: 6;
    white-space: nowrap;
    transition: opacity .3s;
}
.zoom-wrapper:hover .zoom-hint { opacity: 0; }

/* On mobile: hide side panel and lens */
@media(max-width:991.98px){
    .zoom-result { display:none !important; }
    .zoom-lens   { display:none !important; }
    .zoom-wrapper { cursor:default; }
    .zoom-hint { display:none; }
}

/* ─── Thumbnails ──────────────────────────────────── */
.thumb-strip { display:flex;gap:10px;flex-wrap:wrap;margin-top:14px; }
.thumb-item {
    width:76px;height:76px;border-radius:10px;overflow:hidden;
    border:2px solid transparent;cursor:pointer;
    background:#f8fdf8;display:flex;align-items:center;justify-content:center;
    transition:border-color .2s,box-shadow .2s;flex-shrink:0;
}
.thumb-item.active, .thumb-item:hover { border-color:#2E7D32;box-shadow:0 0 0 3px rgba(46,125,50,.15); }
.thumb-item img { max-width:68px;max-height:68px;width:auto;height:auto;object-fit:contain; }

/* ─── Product Info ────────────────────────────────── */
.product-info { padding-left:8px; }
.prod-category-tag { display:inline-block;padding:4px 14px;border-radius:20px;font-size:12px;font-weight:700;background:#e8f5e9;color:#2E7D32;margin-bottom:14px; }
.prod-title { font-size:clamp(1.4rem,3vw,2rem);font-weight:800;color:#1B4332;line-height:1.3;margin-bottom:10px; }
.prod-short-desc { font-size:.95rem;color:#666;line-height:1.75;margin-bottom:20px; }

/* Badges */
.status-badge { display:inline-flex;align-items:center;gap:6px;padding:5px 14px;border-radius:20px;font-size:12px;font-weight:700; }
.badge-instock  { background:#e8f5e9;color:#2E7D32; }
.badge-outstock { background:#ffebee;color:#c62828; }
.badge-backorder{ background:#fff8e1;color:#e65100; }

/* Price */
.price-block { padding:16px 20px;background:#f8fdf8;border-radius:12px;border:1px solid rgba(46,125,50,.15);margin:16px 0; }
.price-final { font-size:2rem;font-weight:800;color:#2E7D32;line-height:1; }
.price-original { font-size:1rem;color:#aaa;text-decoration:line-through;margin-left:10px; }
.price-save { display:inline-block;padding:3px 10px;background:#e8f5e9;color:#2E7D32;font-size:12px;font-weight:700;border-radius:20px;margin-left:10px; }

/* Quantity */
.qty-wrap { display:inline-flex;align-items:center;border:2px solid rgba(46,125,50,.3);border-radius:10px;overflow:hidden; }
.qty-btn { width:40px;height:42px;background:#f8fdf8;border:none;font-size:1.1rem;color:#2E7D32;font-weight:700;cursor:pointer;transition:background .15s; }
.qty-btn:hover { background:#e8f5e9; }
.qty-input { width:52px;height:42px;border:none;text-align:center;font-weight:700;font-size:1rem;color:#1B4332;outline:none; }

/* Add to cart */
.btn-add-cart {
    display:inline-flex;align-items:center;gap:10px;padding:14px 32px;
    background:#2E7D32;color:#fff;border:none;border-radius:12px;
    font-weight:700;font-size:1rem;cursor:pointer;transition:all .25s;
}
.btn-add-cart:hover { background:#1B5E20;transform:translateY(-2px);box-shadow:0 6px 20px rgba(46,125,50,.3); }
.btn-add-cart:disabled { background:#aaa;transform:none;box-shadow:none;cursor:not-allowed; }

/* Product meta table */
.meta-table tr td { padding:8px 12px;font-size:.88rem;border-bottom:1px solid #f0f0f0; }
.meta-table tr td:first-child { font-weight:700;color:#444;width:120px; }
.meta-table tr td:last-child { color:#555; }
.meta-table tr:last-child td { border-bottom:none; }

/* Social share */
.share-btn { display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:8px;font-size:14px;text-decoration:none;transition:all .2s; }

/* Tabs */
.prod-tabs .nav-link { color:#555;font-weight:600;border-radius:0;border:none;border-bottom:3px solid transparent;padding:12px 20px; }
.prod-tabs .nav-link.active { color:#2E7D32;border-bottom-color:#2E7D32;background:transparent; }
.prod-tabs .nav-link:hover:not(.active) { color:#2E7D32; }
.tab-content-box { border:1px solid rgba(46,125,50,.15);border-top:none;border-radius:0 0 12px 12px;padding:24px; }

/* Related products */
.rel-card {
    background:#fff;border-radius:16px;overflow:hidden;
    border:1px solid rgba(46,125,50,.12);
    transition:transform .25s,box-shadow .25s;
    display:flex;flex-direction:column;height:100%;
}
.rel-card:hover { transform:translateY(-5px);box-shadow:0 12px 32px rgba(46,125,50,.15); }
.rel-img-box {
    height:200px;background:#f8fdf8;
    display:flex;align-items:center;justify-content:center;
    overflow:hidden;flex-shrink:0;position:relative;
}
.rel-img-box img {
    max-height:185px;max-width:86%;
    width:auto;height:auto;object-fit:contain;
    transition:transform .35s;
}
.rel-card:hover .rel-img-box img { transform:scale(1.07); }
.rel-body { padding:16px;flex:1;display:flex;flex-direction:column; }
.rel-cat  { font-size:11px;font-weight:700;color:#66BB6A;margin-bottom:5px;letter-spacing:.3px; }
.rel-name {
    font-size:.9rem;font-weight:700;color:#1B4332;
    margin-bottom:8px;line-height:1.4;
    display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;
    flex:1;
}
.rel-price-row { margin-bottom:14px; }
.rel-price-old { font-size:.78rem;color:#bbb;text-decoration:line-through;margin-right:5px; }
.rel-price-val { font-size:1.1rem;font-weight:800;color:#2E7D32; }
/* Single full-width View Details button */
.rel-btn-view {
    display:block;width:100%;padding:11px 0;
    background:#2E7D32;color:#fff;border:none;border-radius:10px;
    font-weight:700;font-size:13px;text-align:center;text-decoration:none;
    cursor:pointer;transition:background .2s;
}
.rel-btn-view:hover { background:#1B5E20;color:#fff; }
/* Secondary outlined add-to-cart icon button */
.rel-btn-cart {
    position:absolute;bottom:10px;right:10px;
    width:36px;height:36px;border-radius:50%;
    background:#fff;border:2px solid #2E7D32;color:#2E7D32;
    display:flex;align-items:center;justify-content:center;
    font-size:14px;cursor:pointer;transition:all .2s;
    box-shadow:0 2px 8px rgba(46,125,50,.15);
}
.rel-btn-cart:hover { background:#2E7D32;color:#fff; }
</style>
@endpush

@section('content')

{{-- Hero breadcrumb --}}
<div class="page-hero">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0" style="background:transparent;padding:0;">
                <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('frontend.products.index') }}">Products</a></li>
                @if($product->category)
                <li class="breadcrumb-item"><a href="{{ route('frontend.categories.show', $product->category->slug) }}">{{ $product->category->name }}</a></li>
                @endif
                <li class="breadcrumb-item active">{{ Str::limit($product->name, 40) }}</li>
            </ol>
        </nav>
    </div>
</div>

{{-- Main Product Section --}}
<section style="padding:50px 0;background:#fff;">
<div class="container">
<div class="row g-5">

    {{-- ── LEFT: Images ───────────────────────────────── --}}
    <div class="col-lg-6">
        {{-- Zoom wrapper --}}
        <div class="zoom-wrapper" id="zoom-wrapper">
            <div class="zoom-container" id="zoom-container">
                <img id="main-img"
                     src="{{ $product->featured_image_url }}"
                     alt="{{ $product->name }}"
                     data-hires="{{ $product->featured_image_url }}">
            </div>
            {{-- Lens overlays the whole wrapper --}}
            <div class="zoom-lens" id="zoom-lens"></div>
            <span class="zoom-hint"><i class="fas fa-search-plus me-1"></i>Hover to zoom</span>
        </div>
        {{-- Result panel is OUTSIDE all overflow:hidden containers --}}
        <div class="zoom-result" id="zoom-result"></div>

        {{-- Thumbnails --}}
        @php $thumbs = []; @endphp
        @if($product->featured_image)
            @php $thumbs[] = $product->featured_image_url; @endphp
        @endif
        @foreach($product->images as $img)
            @php $thumbs[] = asset('storage/'.$img->image); @endphp
        @endforeach

        @if(count($thumbs) > 1)
        <div class="thumb-strip mt-3">
            @foreach($thumbs as $i => $thumb)
            <div class="thumb-item {{ $i===0?'active':'' }}" data-src="{{ $thumb }}">
                <img src="{{ $thumb }}" alt="thumb {{ $i+1 }}">
            </div>
            @endforeach
        </div>
        @endif
    </div>

    {{-- ── RIGHT: Product Info ─────────────────────────── --}}
    <div class="col-lg-6">
        <div class="product-info">
            @if($product->category)
            <span class="prod-category-tag">
                <i class="fas fa-tag me-1"></i>{{ $product->category->name }}
            </span>
            @endif

            <h1 class="prod-title">{{ $product->name }}</h1>

            {{-- Stock status --}}
            <div class="mb-3">
                @if($product->stock_status === 'in_stock')
                <span class="status-badge badge-instock"><i class="fas fa-check-circle"></i> In Stock</span>
                @elseif($product->stock_status === 'out_of_stock')
                <span class="status-badge badge-outstock"><i class="fas fa-times-circle"></i> Out of Stock</span>
                @else
                <span class="status-badge badge-backorder"><i class="fas fa-clock"></i> On Backorder</span>
                @endif
                @if($product->is_new)<span class="status-badge ms-2" style="background:#e8f5e9;color:#2E7D32;">NEW</span>@endif
                @if($product->is_bestseller)<span class="status-badge ms-2" style="background:#fff3e0;color:#E65100;">BESTSELLER</span>@endif
            </div>

            @if($product->short_description)
            <p class="prod-short-desc">{{ $product->short_description }}</p>
            @endif

            {{-- Price --}}
            <div class="price-block">
                @if($product->sale_price && $product->sale_price < $product->price)
                <div class="d-flex align-items-center flex-wrap gap-1">
                    <span class="price-final">₹{{ number_format($product->sale_price,0) }}</span>
                    <span class="price-original">₹{{ number_format($product->price,0) }}</span>
                    <span class="price-save">Save {{ $product->discount_percentage }}%</span>
                </div>
                @else
                <span class="price-final">₹{{ number_format($product->price,0) }}</span>
                @endif
                <div class="mt-2" style="font-size:12px;color:#888;">Inclusive of all taxes</div>
            </div>

            {{-- Add to Cart Form --}}
            <form id="add-to-cart-form" class="mb-4">
                @csrf
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <div>
                        <label class="d-block mb-1" style="font-size:13px;font-weight:600;color:#555;">Quantity</label>
                        <div class="qty-wrap">
                            <button type="button" class="qty-btn" id="qty-dec">−</button>
                            <input type="number" class="qty-input" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock_quantity ?? 999 }}" readonly>
                            <button type="button" class="qty-btn" id="qty-inc">+</button>
                        </div>
                    </div>
                    <div style="margin-top:22px;">
                        @if($product->stock_status !== 'out_of_stock')
                        <button type="submit" class="btn-add-cart" id="add-to-cart-btn">
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </button>
                        @else
                        <button type="button" class="btn-add-cart" disabled>
                            <i class="fas fa-times"></i> Out of Stock
                        </button>
                        @endif
                    </div>
                </div>
            </form>

            {{-- Meta --}}
            <div class="mb-4">
                <table class="meta-table w-100">
                    @if($product->sku)<tr><td>SKU</td><td>{{ $product->sku }}</td></tr>@endif
                    @if($product->seed_type)<tr><td>Seed Type</td><td><i class="fas fa-seedling me-1" style="color:#2E7D32;"></i>{{ $product->seed_type }}</td></tr>@endif
                    @if($product->material)<tr><td>Material</td><td>{{ $product->material }}</td></tr>@endif
                    @if($product->product_size)<tr><td>Size</td><td>{{ $product->product_size }}</td></tr>@endif
                    @if($product->moq)<tr><td>MOQ</td><td>{{ $product->moq }} units</td></tr>@endif
                </table>
            </div>

            {{-- Share --}}
            <div class="d-flex align-items-center gap-2">
                <span style="font-size:13px;color:#888;">Share:</span>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="share-btn" style="background:#1877F2;color:#fff;"><i class="fab fa-facebook-f"></i></a>
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($product->name) }}" target="_blank" class="share-btn" style="background:#1DA1F2;color:#fff;"><i class="fab fa-twitter"></i></a>
                <a href="https://wa.me/?text={{ urlencode($product->name.' '.url()->current()) }}" target="_blank" class="share-btn" style="background:#25D366;color:#fff;"><i class="fab fa-whatsapp"></i></a>
                <a href="https://pinterest.com/pin/create/button/?url={{ urlencode(url()->current()) }}" target="_blank" class="share-btn" style="background:#E60023;color:#fff;"><i class="fab fa-pinterest"></i></a>
            </div>
        </div>
    </div>
</div>

{{-- Description Tabs --}}
<div class="row mt-5">
    <div class="col-12">
        <ul class="nav prod-tabs border-bottom" style="border-color:rgba(46,125,50,.2)!important;">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-desc">Description</button>
            </li>
            @if($product->features)
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-feat">Features</button>
            </li>
            @endif
            @if($product->benefits)
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-bene">Benefits</button>
            </li>
            @endif
        </ul>
        <div class="tab-content tab-content-box">
            <div class="tab-pane fade show active" id="tab-desc" style="color:#555;line-height:1.85;font-size:.95rem;">
                {!! $product->description !!}
            </div>
            @if($product->features)
            <div class="tab-pane fade" id="tab-feat" style="color:#555;line-height:1.85;">
                {!! $product->features !!}
            </div>
            @endif
            @if($product->benefits)
            <div class="tab-pane fade" id="tab-bene" style="color:#555;line-height:1.85;">
                {!! $product->benefits !!}
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Related Products --}}
@if(isset($relatedProducts) && $relatedProducts->count() > 0)
<div class="mt-5 pt-4" style="border-top:1px solid rgba(46,125,50,.12);">
    <h3 style="font-size:1.4rem;font-weight:800;color:#1B4332;margin-bottom:24px;">
        <i class="fas fa-th me-2" style="color:#2E7D32;font-size:.8em;"></i>Related Products
    </h3>
    <div class="row g-4">
        @foreach($relatedProducts->take(4) as $rel)
        <div class="col-6 col-md-4 col-lg-3">
            <div class="rel-card">
                <div class="rel-img-box">
                    <img src="{{ $rel->featured_image_url }}" alt="{{ $rel->name }}">
                    {{-- Floating cart button on image --}}
                    <button class="rel-btn-cart quick-add" data-id="{{ $rel->id }}" title="Add to cart">
                        <i class="fas fa-cart-plus"></i>
                    </button>
                </div>
                <div class="rel-body">
                    <p class="rel-cat"><i class="fas fa-seedling me-1"></i>{{ $rel->category->name ?? '' }}</p>
                    <h4 class="rel-name">{{ $rel->name }}</h4>
                    <div class="rel-price-row">
                        @if($rel->sale_price)
                            <span class="rel-price-old">₹{{ number_format($rel->price,0) }}</span>
                            <span class="rel-price-val">₹{{ number_format($rel->sale_price,0) }}</span>
                        @else
                            <span class="rel-price-val">₹{{ number_format($rel->price,0) }}</span>
                        @endif
                    </div>
                    <a href="{{ route('frontend.products.show', $rel->slug) }}" class="rel-btn-view">
                        <i class="fas fa-eye me-1"></i> View Details
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

</div>
</section>

@endsection

@push('scripts')
<script>
/* ══════════════════════════════════════════════════
   AMAZON-STYLE IMAGE ZOOM  (fixed-position result)
   ══════════════════════════════════════════════════ */
(function() {
    var wrapper   = document.getElementById('zoom-wrapper');
    var container = document.getElementById('zoom-container');
    var mainImg   = document.getElementById('main-img');
    var lens      = document.getElementById('zoom-lens');
    var result    = document.getElementById('zoom-result');
    if (!wrapper || !mainImg || !result) return;

    var ZOOM_LEVEL = 2.8;   /* magnification factor — increase for more zoom */
    var LENS_W     = 150;
    var LENS_H     = 150;

    function isDesktop() { return window.innerWidth >= 992; }

    /* Position result panel next to wrapper using fixed coords */
    function positionResult() {
        var wr    = wrapper.getBoundingClientRect();
        var rW    = 420;
        var rH    = Math.min(440, window.innerHeight - 40);
        var left  = wr.right + 16;
        var top   = wr.top;

        /* If not enough space on right, place on left */
        if (left + rW > window.innerWidth - 10) {
            left = wr.left - rW - 16;
        }
        /* Keep vertically in viewport */
        if (top + rH > window.innerHeight - 10) {
            top = window.innerHeight - rH - 10;
        }
        top = Math.max(10, top);

        result.style.left   = left + 'px';
        result.style.top    = top  + 'px';
        result.style.width  = rW   + 'px';
        result.style.height = rH   + 'px';
    }

    function setResultBg(src) {
        result.style.backgroundImage = 'url("' + src + '")';
    }

    wrapper.addEventListener('mouseenter', function() {
        if (!isDesktop()) return;
        setResultBg(mainImg.src);
        positionResult();
        result.style.display = 'block';
        lens.style.display   = 'block';
    });

    wrapper.addEventListener('mouseleave', function() {
        result.style.display = 'none';
        lens.style.display   = 'none';
    });

    wrapper.addEventListener('mousemove', function(e) {
        if (!isDesktop()) return;

        var wrapRect = wrapper.getBoundingClientRect();
        var imgRect  = mainImg.getBoundingClientRect();
        var resW     = parseFloat(result.style.width)  || 420;
        var resH     = parseFloat(result.style.height) || 440;

        /* Cursor relative to wrapper */
        var cx = e.clientX - wrapRect.left;
        var cy = e.clientY - wrapRect.top;

        /* Clamp lens inside wrapper */
        var lx = Math.max(0, Math.min(cx - LENS_W/2, wrapRect.width  - LENS_W));
        var ly = Math.max(0, Math.min(cy - LENS_H/2, wrapRect.height - LENS_H));

        lens.style.left   = lx + 'px';
        lens.style.top    = ly + 'px';
        lens.style.width  = LENS_W + 'px';
        lens.style.height = LENS_H + 'px';

        /* Cursor relative to the actual image element */
        var ix = e.clientX - imgRect.left;
        var iy = e.clientY - imgRect.top;

        /* BG size = image-displayed-size × zoom */
        var bgW = imgRect.width  * ZOOM_LEVEL;
        var bgH = imgRect.height * ZOOM_LEVEL;

        /* BG position: centre of lens maps to cursor on zoomed image */
        var bx = ix * ZOOM_LEVEL - resW/2;
        var by = iy * ZOOM_LEVEL - resH/2;

        /* Clamp so bg doesn't go out of image bounds */
        bx = Math.max(0, Math.min(bx, bgW - resW));
        by = Math.max(0, Math.min(by, bgH - resH));

        result.style.backgroundSize     = bgW + 'px ' + bgH + 'px';
        result.style.backgroundPosition = '-' + bx + 'px -' + by + 'px';
    });

    /* Thumbnail click */
    document.querySelectorAll('.thumb-item').forEach(function(th) {
        th.addEventListener('click', function() {
            document.querySelectorAll('.thumb-item').forEach(function(t){ t.classList.remove('active'); });
            th.classList.add('active');
            mainImg.src = th.dataset.src;
            setResultBg(th.dataset.src);
        });
    });

    /* Re-position on scroll/resize */
    window.addEventListener('scroll',  positionResult, { passive:true });
    window.addEventListener('resize',  positionResult);
})();

/* ══════════════════════════════════════════════════
   QUANTITY CONTROLS
   ══════════════════════════════════════════════════ */
document.getElementById('qty-inc').addEventListener('click', function() {
    var inp = document.getElementById('quantity');
    var max = parseInt(inp.max) || 999;
    var val = parseInt(inp.value);
    if (val < max) inp.value = val + 1;
});
document.getElementById('qty-dec').addEventListener('click', function() {
    var inp = document.getElementById('quantity');
    var val = parseInt(inp.value);
    if (val > 1) inp.value = val - 1;
});

/* ══════════════════════════════════════════════════
   ADD TO CART — main product
   ══════════════════════════════════════════════════ */
document.getElementById('add-to-cart-form').addEventListener('submit', function(e) {
    e.preventDefault();
    var qty  = parseInt(document.getElementById('quantity').value);
    var btn  = document.getElementById('add-to-cart-btn');
    var orig = btn.innerHTML;
    if (qty < 1) { showMsg('Please select a valid quantity.', 'error'); return; }
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';

    fetch('{{ route("frontend.cart.add", $product) }}', {
        method: 'POST',
        headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN':'{{ csrf_token() }}', 'Accept':'application/json' },
        body: JSON.stringify({ quantity: qty })
    })
    .then(function(r) { return r.json(); })
    .then(function(data) {
        if (data.success) {
            btn.style.background = '#388E3C';
            btn.innerHTML = '<i class="fas fa-check"></i> Added to Cart!';
            var cc = document.querySelector('.cart-count');
            if (cc) cc.textContent = data.cart_count;
            showMsg(data.message, 'success');
            setTimeout(function() { btn.innerHTML = orig; btn.style.background = ''; btn.disabled = false; }, 2200);
        } else {
            btn.innerHTML = orig; btn.disabled = false;
            showMsg(data.message || 'Error adding to cart', 'error');
        }
    })
    .catch(function() { btn.innerHTML = orig; btn.disabled = false; showMsg('Error adding to cart', 'error'); });
});

/* ══════════════════════════════════════════════════
   QUICK ADD — related products floating cart btn
   ══════════════════════════════════════════════════ */
document.querySelectorAll('.quick-add').forEach(function(btn) {
    btn.addEventListener('click', function() {
        var id   = btn.dataset.id;
        var orig = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin" style="font-size:12px;"></i>';

        fetch('/cart/add/' + id, {
            method: 'POST',
            headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN':'{{ csrf_token() }}', 'Accept':'application/json' },
            body: JSON.stringify({ quantity: 1 })
        })
        .then(function(r) { return r.json(); })
        .then(function(d) {
            if (d.success) {
                btn.innerHTML = '<i class="fas fa-check" style="font-size:12px;"></i>';
                btn.style.background = '#2E7D32';
                btn.style.color = '#fff';
                var cc = document.querySelector('.cart-count');
                if (cc) cc.textContent = d.cart_count;
                showMsg('Added to cart', 'success');
                setTimeout(function() { btn.innerHTML = orig; btn.style.background = ''; btn.style.color = ''; btn.disabled = false; }, 2000);
            } else {
                btn.innerHTML = orig; btn.disabled = false;
            }
        })
        .catch(function() { btn.innerHTML = orig; btn.disabled = false; });
    });
});

function showMsg(msg, type) {
    if (window.Toast) { type === 'success' ? window.Toast.success(msg) : window.Toast.error(msg); }
}
</script>
@endpush
