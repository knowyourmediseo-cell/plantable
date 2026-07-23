@extends('layouts.frontend.app')

@section('title', 'Testimonials')
@section('meta_description', 'What our happy customers say about our eco-friendly plantable products.')

@section('content')

{{-- Hero Section --}}
<section style="background: linear-gradient(135deg, #1B4332 0%, #2E7D32 60%, #388E3C 100%); padding: 80px 0 50px;">
    <div class="container text-center text-white">
        <div class="mb-3">
            <span style="background: rgba(255,255,255,0.15); border-radius: 50px; padding: 6px 20px; font-size: 0.85rem; letter-spacing: 1px; text-transform: uppercase;">
                <i class="fas fa-star me-2"></i>Customer Reviews
            </span>
        </div>
        <h1 class="display-5 fw-bold mb-3">What Our Customers Say</h1>
        <p class="lead mb-4" style="opacity: 0.85; max-width: 550px; margin: 0 auto;">
            Real stories from people who chose eco-friendly plantable products
        </p>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0" style="background: none;">
                <li class="breadcrumb-item">
                    <a href="{{ route('frontend.home') }}" class="text-white" style="opacity: 0.75; text-decoration: none;">
                        <i class="fas fa-home me-1"></i>Home
                    </a>
                </li>
                <li class="breadcrumb-item active text-white">Testimonials</li>
            </ol>
        </nav>
    </div>
</section>

{{-- Testimonials Grid --}}
<section class="py-5" style="background: #f8fdf8;">
    <div class="container">
        @if($testimonials->count() > 0)
        <div class="row g-4">
            @foreach($testimonials as $testimonial)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100 p-4"
                     style="border-radius: 16px; transition: transform 0.3s, box-shadow 0.3s; border-left: 4px solid #2E7D32 !important;"
                     onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 16px 40px rgba(46,125,50,0.12)';"
                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='';">

                    {{-- Quote Icon --}}
                    <div class="mb-3">
                        <i class="fas fa-quote-left fa-2x" style="color: #66BB6A; opacity: 0.5;"></i>
                    </div>

                    {{-- Stars --}}
                    @if($testimonial->rating)
                    <div class="mb-3">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $testimonial->rating)
                                <i class="fas fa-star" style="color: #FFA000; font-size: 0.9rem;"></i>
                            @else
                                <i class="far fa-star" style="color: #FFA000; font-size: 0.9rem;"></i>
                            @endif
                        @endfor
                        <span class="ms-1 text-muted" style="font-size: 0.8rem;">({{ $testimonial->rating }}/5)</span>
                    </div>
                    @endif

                    {{-- Content --}}
                    <p class="mb-4" style="color: #444; line-height: 1.7; font-style: italic; font-size: 0.95rem;">
                        "{{ $testimonial->content }}"
                    </p>

                    {{-- Author --}}
                    <div class="d-flex align-items-center mt-auto pt-3" style="border-top: 1px solid #eee;">
                        {{-- Avatar --}}
                        <div class="me-3 flex-shrink-0">
                            @if($testimonial->image)
                                <img src="{{ $testimonial->image_url }}"
                                     alt="{{ $testimonial->name }}"
                                     class="rounded-circle"
                                     style="width: 52px; height: 52px; object-fit: cover; border: 3px solid #66BB6A;">
                            @else
                                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white"
                                     style="width: 52px; height: 52px; background: linear-gradient(135deg, #2E7D32, #66BB6A); font-size: 1.2rem; border: 3px solid #66BB6A;">
                                    {{ strtoupper(substr($testimonial->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div>
                            <div class="fw-bold" style="color: #1B4332;">{{ $testimonial->name }}</div>
                            @if($testimonial->designation || $testimonial->company)
                            <div style="font-size: 0.82rem; color: #777;">
                                @if($testimonial->designation){{ $testimonial->designation }}@endif
                                @if($testimonial->designation && $testimonial->company), @endif
                                @if($testimonial->company){{ $testimonial->company }}@endif
                            </div>
                            @endif
                        </div>
                        @if($testimonial->is_featured)
                        <div class="ms-auto">
                            <i class="fas fa-check-circle" style="color: #2E7D32;" title="Verified"></i>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-5 d-flex justify-content-center">
            {{ $testimonials->links() }}
        </div>

        @else
        {{-- Empty State --}}
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="fas fa-comments fa-5x" style="color: #cce5cc;"></i>
            </div>
            <h4 class="fw-bold mb-2" style="color: #1B4332;">No Testimonials Yet</h4>
            <p class="text-muted mb-4">Be the first to share your experience with our eco-friendly products.</p>
            <a href="{{ route('frontend.contact') }}" class="btn text-white px-4 py-2" style="background: #2E7D32; border-radius: 8px;">
                <i class="fas fa-envelope me-2"></i>Contact Us
            </a>
        </div>
        @endif
    </div>
</section>

{{-- CTA Section --}}
<section class="py-5 text-center text-white" style="background: linear-gradient(135deg, #1B4332, #2E7D32);">
    <div class="container">
        <h3 class="fw-bold mb-3">Loved our products?</h3>
        <p class="mb-4" style="opacity: 0.85; max-width: 450px; margin: 0 auto 1.5rem;">
            Share your experience and help others choose eco-friendly living.
        </p>
        <a href="{{ route('frontend.contact') }}" class="btn btn-lg text-white px-5 py-3 fw-semibold"
           style="background: #FFA000; border: none; border-radius: 10px;">
            <i class="fas fa-star me-2"></i>Share Your Story
        </a>
    </div>
</section>

@endsection
