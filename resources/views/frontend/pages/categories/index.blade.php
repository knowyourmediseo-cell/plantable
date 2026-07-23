@extends('layouts.frontend.app')

@section('title', 'Categories — Plantable Pens & Pencils')

@push('styles')
<style>
.page-hero { background:linear-gradient(135deg,#1B4332 0%,#2E7D32 100%); padding:56px 0; }
.page-hero h1 { font-size:clamp(1.8rem,4vw,2.8rem);font-weight:800;color:#fff;margin-bottom:8px; }
.page-hero p  { color:rgba(255,255,255,.85);font-size:1.05rem; }

.cat-card-link { text-decoration:none;display:block;height:100%; }
.cat-card {
    background:#fff;border-radius:16px;overflow:hidden;
    border:1px solid rgba(46,125,50,.12);
    transition:transform .25s,box-shadow .25s;height:100%;display:flex;flex-direction:column;
}
.cat-card:hover { transform:translateY(-5px);box-shadow:0 14px 35px rgba(46,125,50,.14); }

/* Image box — full image shown, not cropped */
.cat-img-box {
    height:220px;background:#f8fdf8;
    display:flex;align-items:center;justify-content:center;
    overflow:hidden;flex-shrink:0;
}
.cat-img-box img {
    max-height:200px;max-width:90%;
    width:auto;height:auto;object-fit:contain;
    transition:transform .35s;
}
.cat-card:hover .cat-img-box img { transform:scale(1.07); }

.cat-card-body { padding:18px;flex:1; }
.cat-card-name { font-size:1.05rem;font-weight:700;color:#1B4332;margin-bottom:6px; }
.cat-card-desc { font-size:.82rem;color:#777;line-height:1.6; }
</style>
@endpush

@section('content')

<div class="page-hero">
    <div class="container">
        <nav aria-label="breadcrumb" style="margin-bottom:10px;">
            <ol class="breadcrumb mb-0" style="background:transparent;padding:0;">
                <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}" style="color:rgba(255,255,255,.7);text-decoration:none;">Home</a></li>
                <li class="breadcrumb-item active" style="color:#fff;">Categories</li>
            </ol>
        </nav>
        <h1>Product Categories</h1>
        <p>Browse our eco-friendly plantable product collections</p>
    </div>
</div>

<section style="padding:60px 0;background:#f8fdf8;">
    <div class="container">
        <div class="row g-4">
            @forelse($categories as $category)
            <div class="col-sm-6 col-lg-4 col-xl-3">
                <a href="{{ $category->url }}" class="cat-card-link">
                    <div class="cat-card">
                        <div class="cat-img-box">
                            <img src="{{ $category->image_url }}" alt="{{ $category->name }}">
                        </div>
                        <div class="cat-card-body">
                            <h3 class="cat-card-name">{{ $category->name }}</h3>
                            <p class="cat-card-desc">{{ Str::limit($category->short_description, 90) }}</p>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted">No categories found.</p>
            </div>
            @endforelse
        </div>
        @if($categories->hasPages())
        <div class="d-flex justify-content-center mt-5">{{ $categories->links() }}</div>
        @endif
    </div>
</section>

@endsection
