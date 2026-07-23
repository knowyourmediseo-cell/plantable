@extends('layouts.frontend.app')

@section('title', 'Plantable Pens & Pencils — Eco-Friendly Writing Instruments')
@section('meta_description', 'Premium plantable pens & pencils made from recycled materials with embedded seeds. Write, plant, and grow!')

@push('styles')
<style>
/* =============================================
   HOME PAGE — Production Level CSS
   Brand: #2E7D32 (primary), #1B4332 (dark), #66BB6A (accent)
   ============================================= */

/* Swiper overrides */
:root { --swiper-theme-color:#2E7D32; }
.swiper-button-next,.swiper-button-prev{color:#2E7D32!important;background:#fff!important;width:40px!important;height:40px!important;border-radius:50%!important;box-shadow:0 2px 10px rgba(0,0,0,.15)!important;}
.swiper-button-next::after,.swiper-button-prev::after{font-size:14px!important;font-weight:900!important;}
.swiper-button-next:hover,.swiper-button-prev:hover{background:#2E7D32!important;color:#fff!important;}
.swiper-pagination-bullet{background:#2E7D32!important;opacity:.3!important;}
.swiper-pagination-bullet-active{background:#2E7D32!important;opacity:1!important;width:22px!important;border-radius:4px!important;}

/* Hero */
.hero-section { position:relative; height:620px; overflow:hidden; }
.hero-section img { width:100%; height:100%; object-fit:cover; }
.hero-overlay { position:absolute;inset:0;background:linear-gradient(135deg,rgba(27,67,50,.92) 0%,rgba(46,125,50,.7) 100%); }
.hero-content-wrap { position:absolute;inset:0;display:flex;align-items:center; }
.hero-badge { display:inline-block;padding:6px 16px;border-radius:30px;font-size:13px;font-weight:700;background:rgba(255,255,255,.15);color:#fff;border:1px solid rgba(255,255,255,.35);margin-bottom:20px;letter-spacing:.5px; }
.hero-title { font-size:clamp(2rem,5vw,3.8rem);font-weight:800;color:#fff;line-height:1.15;margin-bottom:16px; }
.hero-sub { font-size:1.1rem;color:rgba(255,255,255,.88);margin-bottom:32px;line-height:1.7; }
.btn-hero-primary { display:inline-flex;align-items:center;gap:8px;padding:14px 32px;background:#fff;color:#2E7D32;font-weight:700;border-radius:10px;text-decoration:none;border:none;font-size:15px;transition:all .25s; }
.btn-hero-primary:hover { background:#f0faf0;color:#1B5E20;transform:translateY(-2px);box-shadow:0 6px 20px rgba(0,0,0,.15); }
.btn-hero-outline { display:inline-flex;align-items:center;gap:8px;padding:14px 32px;background:transparent;color:#fff;font-weight:700;border-radius:10px;text-decoration:none;border:2px solid rgba(255,255,255,.7);font-size:15px;transition:all .25s; }
.btn-hero-outline:hover { background:rgba(255,255,255,.15);color:#fff;transform:translateY(-2px); }

/* Stats */
.stats-bar { background:#1B4332;padding:0; }
.stat-item { padding:28px 20px;text-align:center;border-right:1px solid rgba(255,255,255,.08); }
.stat-item:last-child{border-right:none;}
.stat-num { font-size:2.2rem;font-weight:800;color:#66BB6A;line-height:1; }
.stat-lbl { font-size:13px;color:rgba(255,255,255,.75);margin-top:6px;letter-spacing:.3px; }

/* Section headings */
.sec-badge { display:inline-block;padding:5px 18px;border-radius:30px;font-size:12px;font-weight:700;background:#e8f5e9;color:#2E7D32;letter-spacing:.5px;margin-bottom:12px;text-transform:uppercase; }
.sec-title { font-size:clamp(1.6rem,3.5vw,2.5rem);font-weight:800;color:#1B4332;margin-bottom:0; }
.sec-bar { width:50px;height:4px;background:linear-gradient(90deg,#2E7D32,#66BB6A);border-radius:4px;margin:14px auto 0; }

/* Feature cards */
.feature-card { background:#fff;border-radius:16px;padding:32px 24px;text-align:center;border:1px solid rgba(46,125,50,.1);transition:transform .25s,box-shadow .25s;height:100%; }
.feature-card:hover { transform:translateY(-5px);box-shadow:0 12px 30px rgba(46,125,50,.12); }
.feature-icon-wrap { width:68px;height:68px;border-radius:50%;background:rgba(46,125,50,.1);display:flex;align-items:center;justify-content:center;margin:0 auto 20px; }
.feature-icon-wrap i { font-size:1.6rem;color:#2E7D32; }
.feature-title { font-size:1rem;font-weight:700;color:#1B4332;margin-bottom:8px; }
.feature-text { font-size:.875rem;color:#666;line-height:1.65; }

/* Category showcase */
.cat-card { position:relative;border-radius:20px;overflow:hidden;height:340px;display:block;text-decoration:none; }
.cat-card img { width:100%;height:100%;object-fit:cover;transition:transform .5s ease; }
.cat-card:hover img { transform:scale(1.05); }
.cat-overlay { position:absolute;inset:0;background:linear-gradient(to top,rgba(27,67,50,.95) 0%,rgba(27,67,50,.4) 55%,transparent 100%); }
.cat-body { position:absolute;bottom:0;left:0;right:0;padding:28px; }
.cat-badge-sm { display:inline-block;padding:4px 14px;border-radius:20px;font-size:11px;font-weight:700;background:rgba(46,125,50,.85);color:#fff;margin-bottom:10px; }
.cat-title { font-size:1.5rem;font-weight:800;color:#fff;margin-bottom:6px; }
.cat-desc { font-size:.85rem;color:rgba(255,255,255,.8);margin-bottom:12px; }
.cat-link { display:inline-flex;align-items:center;gap:6px;font-size:.85rem;font-weight:700;color:#66BB6A; }
</style>
@endpush

@section('content')

{{-- ── HERO ─────────────────────────────────────────────────── --}}
<section class="hero-slider swiper" style="height:620px;">
    <div class="swiper-wrapper">
        @forelse($sliders as $slider)
        <div class="swiper-slide">
            <div class="hero-section">
                <img data-src="{{ $slider->image_url }}" alt="{{ $slider->title }}" class="lazyload" style="width:100%;height:100%;object-fit:cover;">
                <div class="hero-overlay"></div>
                <div class="hero-content-wrap">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-7 col-xl-6">
                                <span class="hero-badge"><i class="fas fa-seedling me-1"></i> Write · Plant · Grow</span>
                                <h1 class="hero-title">{{ $slider->title }}</h1>
                                @if($slider->subtitle)
                                <p class="hero-sub">{{ $slider->subtitle }}</p>
                                @endif
                                <div class="d-flex flex-wrap gap-3">
                                    <a href="{{ route('frontend.categories.show','plantable-pens') }}" class="btn-hero-primary">
                                        <i class="fas fa-pen"></i> Shop Pens
                                    </a>
                                    <a href="{{ route('frontend.categories.show','plantable-pencils') }}" class="btn-hero-outline">
                                        <i class="fas fa-pencil-alt"></i> Shop Pencils
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="swiper-slide">
            <div class="hero-section" style="background:linear-gradient(135deg,#1B4332,#2E7D32);">
                <div class="hero-overlay" style="background:rgba(0,0,0,.1);"></div>
                <div class="hero-content-wrap">
                    <div class="container text-center">
                        <span class="hero-badge"><i class="fas fa-seedling me-1"></i> Write · Plant · Grow</span>
                        <h1 class="hero-title" style="font-size:clamp(2rem,6vw,4rem);">Plantable Pens &amp; Pencils</h1>
                        <p class="hero-sub mx-auto" style="max-width:560px;">Eco-friendly writing instruments made from recycled materials with embedded seeds. Plant them when done &amp; watch life grow.</p>
                        <div class="d-flex flex-wrap justify-content-center gap-3">
                            <a href="{{ route('frontend.categories.show','plantable-pens') }}" class="btn-hero-primary">
                                <i class="fas fa-pen"></i> Shop Pens
                            </a>
                            <a href="{{ route('frontend.categories.show','plantable-pencils') }}" class="btn-hero-outline">
                                <i class="fas fa-pencil-alt"></i> Shop Pencils
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforelse
    </div>
    <div class="swiper-pagination" style="bottom:20px;"></div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
</section>

{{-- ── STATS BAR ────────────────────────────────────────────── --}}
<section class="stats-bar">
    <div class="container">
        <div class="row g-0">
            <div class="col-6 col-md-3"><div class="stat-item"><div class="stat-num">10K+</div><div class="stat-lbl">Happy Customers</div></div></div>
            <div class="col-6 col-md-3"><div class="stat-item"><div class="stat-num">100%</div><div class="stat-lbl">Biodegradable</div></div></div>
            <div class="col-6 col-md-3"><div class="stat-item"><div class="stat-num">50+</div><div class="stat-lbl">Seed Varieties</div></div></div>
            <div class="col-6 col-md-3"><div class="stat-item" style="border-right:none;"><div class="stat-num">5 ★</div><div class="stat-lbl">Customer Rating</div></div></div>
        </div>
    </div>
</section>

{{-- ── WHY CHOOSE US ───────────────────────────────────────── --}}
<section style="padding:80px 0;background:#f8fdf8;">
    <div class="container">
        <div class="text-center mb-5">
            <span class="sec-badge">Our Promise</span>
            <h2 class="sec-title">Why Choose Our Products?</h2>
            <div class="sec-bar"></div>
        </div>
        <div class="row g-4">
            <div class="col-sm-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon-wrap"><i class="fas fa-recycle"></i></div>
                    <h3 class="feature-title">Recycled Materials</h3>
                    <p class="feature-text">Made from recycled newspaper &amp; cardboard — zero virgin plastic, zero landfill waste.</p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon-wrap"><i class="fas fa-seedling"></i></div>
                    <h3 class="feature-title">Seed Embedded</h3>
                    <p class="feature-text">Every pen &amp; pencil has a seed capsule — plant it after use and watch it bloom.</p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon-wrap"><i class="fas fa-pen-nib"></i></div>
                    <h3 class="feature-title">Smooth Writing</h3>
                    <p class="feature-text">Eco-friendly water-based ink and HB graphite — zero compromise on performance.</p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon-wrap"><i class="fas fa-award"></i></div>
                    <h3 class="feature-title">Corporate Gifting</h3>
                    <p class="feature-text">Custom branding &amp; bulk orders for events, offices and promotional campaigns.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── SHOP BY CATEGORY ────────────────────────────────────── --}}
<section style="padding:80px 0;background:#fff;">
    <div class="container">
        <div class="text-center mb-5">
            <span class="sec-badge">Collections</span>
            <h2 class="sec-title">Shop By Category</h2>
            <div class="sec-bar"></div>
        </div>
        <div class="row g-4">
            @if($penCategory)
            <div class="col-md-6">
                <a href="{{ $penCategory->url }}" class="cat-card">
                    <img data-src="{{ $penCategory->image_url }}" alt="Plantable Pens" class="lazyload" style="width:100%;height:100%;object-fit:cover;">
                    <div class="cat-overlay"></div>
                    <div class="cat-body">
                        <span class="cat-badge-sm"><i class="fas fa-pen me-1"></i> Plantable Pens</span>
                        <h3 class="cat-title">Write &amp; Grow</h3>
                        <p class="cat-desc">Recycled cardboard pens with herb &amp; wildflower seed capsules. Smooth water-based ink.</p>
                        <span class="cat-link">Explore Pens <i class="fas fa-arrow-right"></i></span>
                    </div>
                </a>
            </div>
            @endif
            @if($pencilCategory)
            <div class="col-md-6">
                <a href="{{ $pencilCategory->url }}" class="cat-card">
                    <img data-src="{{ $pencilCategory->image_url }}" alt="Plantable Pencils" class="lazyload" style="width:100%;height:100%;object-fit:cover;">
                    <div class="cat-overlay"></div>
                    <div class="cat-body">
                        <span class="cat-badge-sm"><i class="fas fa-pencil-alt me-1"></i> Plantable Pencils</span>
                        <h3 class="cat-title">Sketch &amp; Grow</h3>
                        <p class="cat-desc">Recycled newspaper pencils with flower &amp; herb seed capsules. HB grade graphite.</p>
                        <span class="cat-link">Explore Pencils <i class="fas fa-arrow-right"></i></span>
                    </div>
                </a>
            </div>
            @endif
        </div>
    </div>
</section>

{{-- ── ALL PRODUCTS — Tabbed ───────────────────────────────── --}}
<section style="padding:80px 0;background:#f0faf0;" id="products-section">
    <div class="container">
        <div class="text-center mb-5">
            <span class="sec-badge">Our Range</span>
            <h2 class="sec-title">All Products</h2>
            <div class="sec-bar"></div>
        </div>

        {{-- Tab Buttons --}}
        <div class="d-flex justify-content-center gap-3 flex-wrap mb-5">
            <button class="prod-tab active" data-filter="all" onclick="filterProds('all',this)">
                <i class="fas fa-th-large me-1"></i> All Products
            </button>
            <button class="prod-tab" data-filter="pens" onclick="filterProds('pens',this)">
                <i class="fas fa-pen me-1"></i> Pens
            </button>
            <button class="prod-tab" data-filter="pencils" onclick="filterProds('pencils',this)">
                <i class="fas fa-pencil-alt me-1"></i> Pencils
            </button>
        </div>

        <div class="row g-4" id="prod-grid">
            {{-- PENS --}}
            @foreach($penProducts as $product)
            <div class="col-sm-6 col-lg-4 col-xl-3 prod-item" data-cat="pens">
                <div class="prd-card">
                    <div class="prd-img-wrap">
                        <img src="{{ $product->featured_image_url }}" alt="{{ $product->name }}" class="prd-img">
                        <div class="prd-badges">
                            @if($product->is_new)<span class="prd-badge prd-badge-new">NEW</span>@endif
                            @if($product->is_bestseller)<span class="prd-badge prd-badge-bs">BESTSELLER</span>@endif
                            @if($product->discount_percentage > 0)<span class="prd-badge prd-badge-sale">-{{ $product->discount_percentage }}%</span>@endif
                        </div>
                        <span class="prd-cat-tag"><i class="fas fa-pen" style="font-size:10px;"></i> Pen</span>
                    </div>
                    <div class="prd-body">
                        <p class="prd-seed"><i class="fas fa-seedling me-1"></i>{{ $product->seed_type ?? 'Herb Seeds' }}</p>
                        <h3 class="prd-name">{{ $product->name }}</h3>
                        <p class="prd-desc">{{ $product->short_description }}</p>
                        <div class="prd-price-row">
                            @if($product->sale_price)
                                <span class="prd-old">₹{{ number_format($product->price,0) }}</span>
                                <span class="prd-price">₹{{ number_format($product->sale_price,0) }}</span>
                            @else
                                <span class="prd-price">₹{{ number_format($product->price,0) }}</span>
                            @endif
                        </div>
                        <a href="{{ $product->url }}" class="prd-btn">
                            <i class="fas fa-eye me-1"></i> View Details
                        </a>
                    </div>
                </div>
            </div>
            @endforeach

            {{-- PENCILS --}}
            @foreach($pencilProducts as $product)
            <div class="col-sm-6 col-lg-4 col-xl-3 prod-item" data-cat="pencils">
                <div class="prd-card">
                    <div class="prd-img-wrap">
                        <img src="{{ $product->featured_image_url }}" alt="{{ $product->name }}" class="prd-img">
                        <div class="prd-badges">
                            @if($product->is_new)<span class="prd-badge prd-badge-new">NEW</span>@endif
                            @if($product->is_bestseller)<span class="prd-badge prd-badge-bs">BESTSELLER</span>@endif
                            @if($product->discount_percentage > 0)<span class="prd-badge prd-badge-sale">-{{ $product->discount_percentage }}%</span>@endif
                        </div>
                        <span class="prd-cat-tag"><i class="fas fa-pencil-alt" style="font-size:10px;"></i> Pencil</span>
                    </div>
                    <div class="prd-body">
                        <p class="prd-seed"><i class="fas fa-seedling me-1"></i>{{ $product->seed_type ?? 'Wildflower Seeds' }}</p>
                        <h3 class="prd-name">{{ $product->name }}</h3>
                        <p class="prd-desc">{{ $product->short_description }}</p>
                        <div class="prd-price-row">
                            @if($product->sale_price)
                                <span class="prd-old">₹{{ number_format($product->price,0) }}</span>
                                <span class="prd-price">₹{{ number_format($product->sale_price,0) }}</span>
                            @else
                                <span class="prd-price">₹{{ number_format($product->price,0) }}</span>
                            @endif
                        </div>
                        <a href="{{ $product->url }}" class="prd-btn">
                            <i class="fas fa-eye me-1"></i> View Details
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('frontend.products.index') }}" class="btn-green-lg">
                <i class="fas fa-shopping-bag me-2"></i> View All Products
            </a>
        </div>
    </div>
</section>

{{-- ── HOW IT WORKS ────────────────────────────────────────── --}}
<section style="padding:80px 0;background:#fff;">
    <div class="container">
        <div class="text-center mb-5">
            <span class="sec-badge">Simple Process</span>
            <h2 class="sec-title">How It Works</h2>
            <div class="sec-bar"></div>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="hiw-card">
                    <div class="hiw-step">1</div>
                    <div class="hiw-icon"><i class="fas fa-pen-nib"></i></div>
                    <h3 class="hiw-title">Write with It</h3>
                    <p class="hiw-text">Use your plantable pen or pencil just like any regular writing instrument — smooth, reliable, comfortable.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="hiw-card">
                    <div class="hiw-step">2</div>
                    <div class="hiw-icon"><i class="fas fa-hand-holding-heart"></i></div>
                    <h3 class="hiw-title">Don't Throw It</h3>
                    <p class="hiw-text">When it's too short to write, don't discard it. The seed capsule at the tip is ready to be planted.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="hiw-card">
                    <div class="hiw-step">3</div>
                    <div class="hiw-icon"><i class="fas fa-seedling"></i></div>
                    <h3 class="hiw-title">Plant &amp; Watch Grow</h3>
                    <p class="hiw-text">Push it into moist soil, water regularly — within 7–10 days watch herbs or wildflowers sprout!</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── SEED VARIETIES ──────────────────────────────────────── --}}
<section style="padding:80px 0;background:#f8fdf8;">
    <div class="container">
        <div class="text-center mb-5">
            <span class="sec-badge">Choose Your Growth</span>
            <h2 class="sec-title">Available Seed Varieties</h2>
            <div class="sec-bar"></div>
        </div>
        <div class="row g-3 justify-content-center">
            @php $seeds=[['fas fa-spa','Basil','Fresh culinary herb'],['fas fa-seedling','Wildflower','Beautiful blooms'],['fas fa-leaf','Mint','Refreshing herb'],['fas fa-circle','Marigold','Vibrant orange flower'],['fas fa-pepper-hot','Chili','Spice it up']]; @endphp
            @foreach($seeds as $s)
            <div class="col-6 col-md-4 col-lg-2">
                <div class="seed-card">
                    <div class="seed-icon"><i class="{{ $s[0] }}"></i></div>
                    <div class="seed-name">{{ $s[1] }}</div>
                    <div class="seed-desc">{{ $s[2] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── BESTSELLERS CAROUSEL ────────────────────────────────── --}}
@if($bestsellerProducts->count() > 0)
<section style="padding:80px 0;background:#fff;">
    <div class="container">
        <div class="text-center mb-5">
            <span class="sec-badge" style="background:#fff3e0;color:#E65100;">🏆 Bestsellers</span>
            <h2 class="sec-title">Most Popular Products</h2>
            <div class="sec-bar"></div>
        </div>
        <div class="bestseller-swiper swiper" style="padding-bottom:50px;">
            <div class="swiper-wrapper">
                @foreach($bestsellerProducts as $product)
                <div class="swiper-slide" style="height:auto;">
                    <div class="prd-card" style="height:100%;">
                        <div class="prd-img-wrap">
                            <img src="{{ $product->featured_image_url }}" alt="{{ $product->name }}" class="prd-img">
                            <span class="prd-badge prd-badge-bs" style="position:absolute;top:12px;left:12px;">BESTSELLER</span>
                        </div>
                        <div class="prd-body">
                            <p class="prd-seed">{{ $product->category->name ?? '' }}</p>
                            <h3 class="prd-name">{{ $product->name }}</h3>
                            <div class="prd-price-row">
                                @if($product->sale_price)
                                    <span class="prd-old">₹{{ number_format($product->price,0) }}</span>
                                    <span class="prd-price">₹{{ number_format($product->sale_price,0) }}</span>
                                @else
                                    <span class="prd-price">₹{{ number_format($product->price,0) }}</span>
                                @endif
                            </div>
                            <a href="{{ $product->url }}" class="prd-btn">View Details</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="swiper-pagination" style="bottom:0;"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
</section>
@endif

{{-- ── TESTIMONIALS ─────────────────────────────────────────── --}}
@if($testimonials->count() > 0)
<section style="padding:80px 0;background:linear-gradient(180deg,#f0faf0,#fff);">
    <div class="container">
        <div class="text-center mb-5">
            <span class="sec-badge"><i class="fas fa-quote-left me-1"></i> Testimonials</span>
            <h2 class="sec-title">What Our Customers Say</h2>
            <div class="sec-bar"></div>
        </div>
        <div style="position:relative;padding:0 14px;">
            <div class="testimonials-swiper swiper" style="padding-bottom:52px;">
                <div class="swiper-wrapper">
                    @foreach($testimonials as $t)
                    <div class="swiper-slide" style="height:auto;">
                        <div class="testi-card">
                            <div class="testi-stars">
                                @for($i=1;$i<=5;$i++)<i class="fas fa-star" style="color:{{ $i<=$t->rating?'#FFA000':'#ddd' }};font-size:13px;"></i>@endfor
                            </div>
                            <p class="testi-text">"{{ $t->content }}"</p>
                            <div class="testi-author">
                                <div class="testi-avatar">{{ strtoupper(substr($t->name,0,1)) }}</div>
                                <div>
                                    <div class="testi-name">{{ $t->name }}</div>
                                    @if($t->designation || $t->company)
                                    <div class="testi-role">{{ $t->designation }}@if($t->designation && $t->company), @endif{{ $t->company }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="swiper-pagination testi-dots" style="bottom:0;"></div>
            </div>
            <button class="t-arr t-arr-prev"><i class="fas fa-chevron-left" style="font-size:13px;"></i></button>
            <button class="t-arr t-arr-next"><i class="fas fa-chevron-right" style="font-size:13px;"></i></button>
        </div>
    </div>
</section>
@endif

{{-- ── FAQ ───────────────────────────────────────────────────── --}}
@if($faqs->count() > 0)
<section style="padding:80px 0;background:#f8fdf8;">
    <div class="container">
        <div class="text-center mb-5">
            <span class="sec-badge">FAQ</span>
            <h2 class="sec-title">Frequently Asked Questions</h2>
            <div class="sec-bar"></div>
        </div>
        <div style="max-width:740px;margin:0 auto;">
            @foreach($faqs as $faq)
            <div class="faq-item">
                <button class="faq-q" onclick="toggleFaq(this)">
                    <span>{{ $faq->question }}</span>
                    <i class="fas fa-plus faq-icon"></i>
                </button>
                <div class="faq-a">{{ $faq->answer }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ── CLIENTS ───────────────────────────────────────────────── --}}
@if($clients->count() > 0)
<section style="padding:60px 0;background:#fff;">
    <div class="container">
        <h2 class="text-center mb-4" style="font-size:1.4rem;font-weight:700;color:#1B4332;">Trusted By Leading Brands</h2>
        <div class="clients-slider swiper">
            <div class="swiper-wrapper align-items-center">
                @foreach($clients as $client)
                <div class="swiper-slide text-center">
                    <img data-src="{{ $client->logo_url }}" alt="{{ $client->name }}" class="lazyload" style="height:60px;width:auto;max-width:130px;margin:auto;object-fit:contain;opacity:.55;filter:grayscale(30%);transition:opacity .3s;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='.55'">
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

{{-- ── CTA ───────────────────────────────────────────────────── --}}
<section style="padding:80px 0;background:linear-gradient(135deg,#1B4332 0%,#2E7D32 55%,#388E3C 100%);">
    <div class="container text-center">
        <i class="fas fa-leaf" style="font-size:3.5rem;color:rgba(255,255,255,.2);display:block;margin-bottom:20px;"></i>
        <h2 style="font-size:clamp(1.8rem,4vw,2.8rem);font-weight:800;color:#fff;margin-bottom:14px;">Turn Every Write into a Plant</h2>
        <p style="font-size:1.1rem;color:rgba(255,255,255,.85);margin-bottom:36px;max-width:500px;margin-left:auto;margin-right:auto;">Order plantable pens &amp; pencils for yourself or your entire team. Minimum order: 50 units.</p>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            <a href="{{ route('frontend.products.index') }}" class="btn-hero-primary">
                <i class="fas fa-shopping-bag"></i> Shop Now
            </a>
            <a href="{{ route('frontend.contact') }}" class="btn-hero-outline">
                <i class="fas fa-envelope"></i> Bulk Inquiry
            </a>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
/* ── Product Cards ── */
.prd-card { background:#fff;border-radius:16px;overflow:hidden;border:1px solid rgba(46,125,50,.1);transition:transform .25s,box-shadow .25s;display:flex;flex-direction:column;height:100%; }
.prd-card:hover { transform:translateY(-5px);box-shadow:0 14px 35px rgba(46,125,50,.14); }
.prd-img-wrap { position:relative;background:#f8fdf8;height:220px;display:flex;align-items:center;justify-content:center;overflow:hidden;flex-shrink:0; }
.prd-img { max-height:200px;max-width:85%;width:auto;height:auto;object-fit:contain;transition:transform .35s; }
.prd-card:hover .prd-img { transform:scale(1.06); }
.prd-badges { position:absolute;top:10px;left:10px;display:flex;flex-direction:column;gap:4px; }
.prd-badge { padding:3px 9px;border-radius:20px;font-size:10px;font-weight:800;line-height:1.4;display:inline-block; }
.prd-badge-new  { background:#2E7D32;color:#fff; }
.prd-badge-bs   { background:#E65100;color:#fff; }
.prd-badge-sale { background:#C62828;color:#fff; }
.prd-cat-tag { position:absolute;top:10px;right:10px;background:#e8f5e9;color:#2E7D32;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700; }
.prd-body { padding:18px;flex:1;display:flex;flex-direction:column; }
.prd-seed { font-size:11px;font-weight:700;color:#66BB6A;margin-bottom:6px;letter-spacing:.3px; }
.prd-name { font-size:.95rem;font-weight:700;color:#1B4332;margin-bottom:6px;line-height:1.4;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden; }
.prd-desc { font-size:.8rem;color:#777;line-height:1.6;margin-bottom:10px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;flex:1; }
.prd-price-row { margin-bottom:14px; }
.prd-old { font-size:.85rem;color:#aaa;text-decoration:line-through;margin-right:6px; }
.prd-price { font-size:1.3rem;font-weight:800;color:#2E7D32; }
.prd-btn { display:block;width:100%;padding:11px 0;background:#2E7D32;color:#fff;border:none;border-radius:10px;font-weight:700;text-align:center;text-decoration:none;font-size:14px;transition:background .2s;cursor:pointer; }
.prd-btn:hover { background:#1B5E20;color:#fff; }

/* ── Tab Buttons ── */
.prod-tab { padding:10px 26px;border-radius:30px;font-weight:700;font-size:14px;cursor:pointer;border:2px solid #2E7D32;background:transparent;color:#2E7D32;transition:all .2s; }
.prod-tab.active,.prod-tab:hover { background:#2E7D32;color:#fff; }

/* ── Green button ── */
.btn-green-lg { display:inline-flex;align-items:center;gap:8px;padding:14px 36px;background:#2E7D32;color:#fff;font-weight:700;border-radius:10px;text-decoration:none;font-size:15px;transition:all .25s; }
.btn-green-lg:hover { background:#1B5E20;color:#fff;transform:translateY(-2px);box-shadow:0 6px 20px rgba(46,125,50,.3); }

/* ── How It Works ── */
.hiw-card { background:#fff;border-radius:18px;padding:36px 28px;text-align:center;border:1px solid rgba(46,125,50,.1);position:relative;overflow:visible;height:100%;transition:transform .25s,box-shadow .25s; }
.hiw-card:hover { transform:translateY(-5px);box-shadow:0 12px 30px rgba(46,125,50,.12); }
.hiw-step { width:44px;height:44px;border-radius:50%;background:linear-gradient(135deg,#2E7D32,#66BB6A);color:#fff;font-weight:800;font-size:1.1rem;display:flex;align-items:center;justify-content:center;margin:0 auto 16px; }
.hiw-icon { width:62px;height:62px;border-radius:50%;background:rgba(46,125,50,.1);display:flex;align-items:center;justify-content:center;margin:0 auto 18px; }
.hiw-icon i { font-size:1.5rem;color:#2E7D32; }
.hiw-title { font-size:1.05rem;font-weight:700;color:#1B4332;margin-bottom:10px; }
.hiw-text { font-size:.875rem;color:#666;line-height:1.7; }

/* ── Seed Cards ── */
.seed-card { background:#fff;border-radius:14px;padding:22px 12px;text-align:center;border:1.5px solid rgba(46,125,50,.15);transition:all .25s;height:100%;cursor:default; }
.seed-card:hover { border-color:#2E7D32;background:#f0faf0;transform:translateY(-3px);box-shadow:0 6px 16px rgba(46,125,50,.1); }
.seed-icon { width:52px;height:52px;border-radius:50%;background:rgba(46,125,50,.1);display:flex;align-items:center;justify-content:center;margin:0 auto 12px; }
.seed-icon i { font-size:1.2rem;color:#2E7D32; }
.seed-name { font-weight:700;font-size:.95rem;color:#1B4332;margin-bottom:4px; }
.seed-desc { font-size:.78rem;color:#888; }

/* ── Testimonials ── */
.testi-card { background:#fff;border-radius:16px;padding:26px;border:1px solid rgba(46,125,50,.1);box-shadow:0 4px 18px rgba(46,125,50,.07);height:100%;display:flex;flex-direction:column; }
.testi-stars { margin-bottom:12px; }
.testi-text { font-size:.875rem;color:#555;font-style:italic;line-height:1.75;flex:1;margin-bottom:18px; }
.testi-author { display:flex;align-items:center;gap:12px;margin-top:auto; }
.testi-avatar { width:44px;height:44px;border-radius:50%;background:linear-gradient(135deg,#2E7D32,#66BB6A);color:#fff;font-weight:700;font-size:1rem;display:flex;align-items:center;justify-content:center;flex-shrink:0; }
.testi-name { font-weight:700;font-size:.9rem;color:#1B4332; }
.testi-role { font-size:.78rem;color:#66BB6A; }
.testimonials-swiper .swiper-pagination-bullet { background:#2E7D32;opacity:.3; }
.testimonials-swiper .swiper-pagination-bullet-active { background:#2E7D32;opacity:1;width:22px;border-radius:4px; }
.t-arr { position:absolute;top:50%;transform:translateY(-50%);z-index:10;width:40px;height:40px;border-radius:50%;background:#2E7D32;color:#fff;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 10px rgba(46,125,50,.3);transition:background .2s; }
.t-arr-prev { left:-4px; }
.t-arr-next { right:-4px; }
.t-arr:hover { background:#1B4332; }

/* ── FAQ ── */
.faq-item { background:#fff;border-radius:12px;margin-bottom:10px;border:1px solid rgba(46,125,50,.15);overflow:hidden; }
.faq-q { width:100%;display:flex;align-items:center;justify-content:space-between;padding:18px 22px;background:transparent;border:none;cursor:pointer;font-weight:700;font-size:.95rem;color:#1B4332;text-align:left;gap:16px;transition:background .15s; }
.faq-q:hover { background:#f0faf0; }
.faq-icon { color:#2E7D32;flex-shrink:0;transition:transform .2s; }
.faq-a { display:none;padding:0 22px 18px;font-size:.875rem;color:#555;line-height:1.75; }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* Hero Slider */
    if (typeof Swiper !== 'undefined') {
        new Swiper('.hero-slider', {
            modules: [window.SwiperModules ? window.SwiperModules : []],
            loop: true,
            autoplay: { delay: 5000, disableOnInteraction: false },
            pagination: { el: '.hero-slider .swiper-pagination', clickable: true },
            navigation: { nextEl: '.hero-slider .swiper-button-next', prevEl: '.hero-slider .swiper-button-prev' },
            effect: 'fade',
        });
    }

    /* Bestsellers */
    if (typeof Swiper !== 'undefined' && document.querySelector('.bestseller-swiper')) {
        new Swiper('.bestseller-swiper', {
            loop: true,
            spaceBetween: 20,
            slidesPerView: 1,
            autoplay: { delay: 3000, disableOnInteraction: false },
            pagination: { el: '.bestseller-swiper .swiper-pagination', clickable: true },
            navigation: { nextEl: '.bestseller-swiper .swiper-button-next', prevEl: '.bestseller-swiper .swiper-button-prev' },
            breakpoints: { 480:{slidesPerView:2}, 768:{slidesPerView:3}, 1200:{slidesPerView:4} },
        });
    }

    /* Testimonials */
    if (typeof Swiper !== 'undefined' && document.querySelector('.testimonials-swiper')) {
        new Swiper('.testimonials-swiper', {
            loop: true, spaceBetween: 24,
            autoplay: { delay: 4500, disableOnInteraction: false, pauseOnMouseEnter: true },
            pagination: { el: '.testi-dots', clickable: true },
            navigation: { nextEl: '.t-arr-next', prevEl: '.t-arr-prev' },
            breakpoints: { 640:{slidesPerView:1}, 768:{slidesPerView:2}, 1024:{slidesPerView:3} },
        });
    }

    /* Clients */
    if (typeof Swiper !== 'undefined' && document.querySelector('.clients-slider')) {
        new Swiper('.clients-slider', {
            loop: true, spaceBetween: 30,
            autoplay: { delay: 2500, disableOnInteraction: false },
            breakpoints: { 480:{slidesPerView:3}, 768:{slidesPerView:4}, 1024:{slidesPerView:5} },
        });
    }
});

/* Product tab filter */
function filterProds(cat, btn) {
    document.querySelectorAll('.prod-tab').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    document.querySelectorAll('.prod-item').forEach(el => {
        el.style.display = (cat === 'all' || el.dataset.cat === cat) ? '' : 'none';
    });
}

/* FAQ accordion */
function toggleFaq(btn) {
    const ans = btn.nextElementSibling;
    const ico = btn.querySelector('.faq-icon');
    const open = ans.style.display === 'block';
    document.querySelectorAll('.faq-a').forEach(a => a.style.display = 'none');
    document.querySelectorAll('.faq-icon').forEach(i => { i.classList.replace('fa-minus','fa-plus'); i.style.transform=''; });
    document.querySelectorAll('.faq-q').forEach(q => q.style.background = '');
    if (!open) {
        ans.style.display = 'block';
        ico.classList.replace('fa-plus','fa-minus');
        ico.style.transform = 'rotate(0deg)';
        btn.style.background = '#f0faf0';
    }
}
</script>
@endpush
