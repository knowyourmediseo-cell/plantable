@extends('layouts.frontend.app')
@section('title', 'Gallery')
@section('content')

<section class="py-5" style="background:linear-gradient(135deg,#2E7D32,#1B4332); padding:60px 0 40px !important;">
    <div class="container text-center text-white">
        <h1 class="display-5 fw-bold mb-2">Our Gallery</h1>
        <p class="lead opacity-75">A glimpse of our eco-friendly plantable products</p>
        <nav aria-label="breadcrumb" class="mt-3">
            <ol class="breadcrumb justify-content-center" style="background:none;">
                <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}" class="text-white opacity-75">Home</a></li>
                <li class="breadcrumb-item active text-white">Gallery</li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-5">
    <div class="container">
        @if($galleries->count() > 0)
        <div class="row g-3">
            @foreach($galleries as $gallery)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card border-0 shadow-sm h-100" style="border-radius:12px; overflow:hidden; cursor:pointer;"
                     onclick="openLightbox('{{ asset('storage/'.$gallery->image) }}', '{{ $gallery->title }}')">
                    <img src="{{ asset('storage/'.$gallery->image) }}" alt="{{ $gallery->alt_text ?? $gallery->title }}"
                         style="width:100%; height:200px; object-fit:cover; transition:transform .3s;"
                         onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                    @if($gallery->title)
                    <div class="p-2 text-center">
                        <small class="fw-semibold" style="color:#1B4332;">{{ $gallery->title }}</small>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-4 d-flex justify-content-center">
            {{ $galleries->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-images fa-4x mb-3" style="color:#ccc;"></i>
            <h4 class="text-muted">No gallery items yet</h4>
        </div>
        @endif
    </div>
</section>

<!-- Lightbox -->
<div id="lightbox" onclick="closeLightbox()" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.92); z-index:9999; align-items:center; justify-content:center;">
    <div style="position:relative; max-width:90vw; max-height:90vh;">
        <img id="lightbox-img" src="" alt="" style="max-width:90vw; max-height:85vh; object-fit:contain; border-radius:8px;">
        <p id="lightbox-caption" class="text-white text-center mt-2"></p>
        <button onclick="closeLightbox()" style="position:absolute; top:-15px; right:-15px; background:#2E7D32; color:#fff; border:none; border-radius:50%; width:36px; height:36px; font-size:1.2rem; cursor:pointer;">&times;</button>
    </div>
</div>
@endsection
@push('scripts')
<script>
function openLightbox(src, title) {
    document.getElementById('lightbox-img').src = src;
    document.getElementById('lightbox-caption').textContent = title;
    document.getElementById('lightbox').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function closeLightbox() {
    document.getElementById('lightbox').style.display = 'none';
    document.body.style.overflow = '';
}
document.addEventListener('keydown', function(e){ if(e.key==='Escape') closeLightbox(); });
</script>
@endpush
