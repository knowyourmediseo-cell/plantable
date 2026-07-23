@extends('layouts.frontend.app')

@section('title', 'Videos')
@section('meta_description', 'Watch our eco-friendly product videos and learn about sustainable living.')

@section('content')

{{-- Hero Section --}}
<section style="background: linear-gradient(135deg, #1B4332 0%, #2E7D32 60%, #388E3C 100%); padding: 80px 0 50px;">
    <div class="container text-center text-white">
        <div class="mb-3">
            <span style="background: rgba(255,255,255,0.15); border-radius: 50px; padding: 6px 20px; font-size: 0.85rem; letter-spacing: 1px; text-transform: uppercase;">
                <i class="fas fa-play-circle me-2"></i>Video Gallery
            </span>
        </div>
        <h1 class="display-5 fw-bold mb-3">Our Videos</h1>
        <p class="lead mb-4" style="opacity: 0.85; max-width: 550px; margin: 0 auto;">
            Watch how we craft eco-friendly plantable products and learn about sustainable living
        </p>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0" style="background: none;">
                <li class="breadcrumb-item">
                    <a href="{{ route('frontend.home') }}" class="text-white" style="opacity: 0.75; text-decoration: none;">
                        <i class="fas fa-home me-1"></i>Home
                    </a>
                </li>
                <li class="breadcrumb-item active text-white">Videos</li>
            </ol>
        </nav>
    </div>
</section>

{{-- Videos Grid --}}
<section class="py-5">
    <div class="container">
        @if($videos->count() > 0)
        <div class="row g-4">
            @foreach($videos as $video)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 16px; overflow: hidden; transition: transform 0.3s, box-shadow 0.3s;"
                     onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 16px 40px rgba(46,125,50,0.15)';"
                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='';">

                    {{-- Video Embed / Thumbnail --}}
                    <div style="position: relative; padding-top: 56.25%; background: #1B4332; overflow: hidden;">
                        @if($video->type === 'youtube' && $video->embed_url)
                            <iframe
                                src="{{ $video->embed_url }}"
                                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none;"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen
                                loading="lazy"
                                title="{{ $video->title }}">
                            </iframe>
                        @elseif($video->type === 'vimeo' && $video->embed_url)
                            <iframe
                                src="{{ $video->embed_url }}"
                                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none;"
                                allow="autoplay; fullscreen; picture-in-picture"
                                allowfullscreen
                                loading="lazy"
                                title="{{ $video->title }}">
                            </iframe>
                        @elseif($video->video_file)
                            <video
                                controls
                                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;"
                                poster="{{ $video->thumbnail_url }}">
                                <source src="{{ asset('storage/' . $video->video_file) }}">
                            </video>
                        @else
                            <div style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #1B4332, #2E7D32);">
                                @if($video->thumbnail)
                                    <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}"
                                         style="width: 100%; height: 100%; object-fit: cover; position: absolute; inset: 0;">
                                    <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-play-circle fa-4x text-white" style="opacity: 0.9;"></i>
                                    </div>
                                @else
                                    <i class="fas fa-play-circle fa-4x text-white" style="opacity: 0.6;"></i>
                                @endif
                            </div>
                        @endif

                        {{-- Duration Badge --}}
                        @if($video->duration)
                        <div style="position: absolute; bottom: 8px; right: 8px; background: rgba(0,0,0,0.75); color: #fff; font-size: 0.75rem; padding: 2px 8px; border-radius: 4px; z-index: 2;">
                            <i class="fas fa-clock me-1"></i>{{ $video->duration }}
                        </div>
                        @endif
                    </div>

                    {{-- Card Body --}}
                    <div class="card-body p-4">
                        @if($video->is_featured)
                        <span class="badge mb-2" style="background: #FFA000; color: #fff; font-size: 0.7rem;">
                            <i class="fas fa-star me-1"></i>Featured
                        </span>
                        @endif

                        <h5 class="fw-bold mb-2" style="color: #1B4332; line-height: 1.4;">{{ $video->title }}</h5>

                        @if($video->description)
                        <p class="text-muted mb-3" style="font-size: 0.9rem; line-height: 1.6;">
                            {{ Str::limit($video->description, 120) }}
                        </p>
                        @endif

                        <div class="d-flex align-items-center mt-auto" style="font-size: 0.8rem; color: #888;">
                            @if($video->views)
                            <span><i class="fas fa-eye me-1" style="color: #66BB6A;"></i>{{ number_format($video->views) }} views</span>
                            @endif
                            <span class="ms-auto text-capitalize">
                                <i class="fas fa-video me-1" style="color: #66BB6A;"></i>{{ $video->type ?? 'video' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-5 d-flex justify-content-center">
            {{ $videos->links() }}
        </div>

        @else
        {{-- Empty State --}}
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="fas fa-video fa-5x" style="color: #cce5cc;"></i>
            </div>
            <h4 class="fw-bold mb-2" style="color: #1B4332;">No Videos Yet</h4>
            <p class="text-muted mb-4">Check back soon — we're preparing some great content for you.</p>
            <a href="{{ route('frontend.home') }}" class="btn text-white px-4 py-2" style="background: #2E7D32; border-radius: 8px;">
                <i class="fas fa-home me-2"></i>Back to Home
            </a>
        </div>
        @endif
    </div>
</section>

@endsection
