@extends('layouts.frontend.app')

@section('title', $page->title ?? $page->meta_title)
@section('meta_description', $page->meta_description)
@section('meta_keywords', $page->meta_keywords)

@section('content')
@if($page->slug === 'about-us')
    {{-- About Us Specific Design --}}
    
    {{-- Hero Section --}}
    <section class="page-hero" style="background: linear-gradient(135deg, #2E7D32 0%, #66BB6A 100%); padding: 80px 0 60px;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center text-white">
                    <h1 class="display-4 fw-bold mb-3" data-aos="fade-up">{{ $page->title }}</h1>
                    <p class="lead mb-4" data-aos="fade-up" data-aos-delay="100">
                        {{ $page->excerpt ?? 'Leading the way in sustainable plantable promotional products' }}
                    </p>
                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center" data-aos="fade-up" data-aos-delay="200">
                        <a href="{{ route('frontend.products.index') }}" class="btn btn-light btn-lg px-4">
                            <i class="fas fa-leaf me-2"></i>Our Products
                        </a>
                        <a href="{{ route('frontend.contact') }}" class="btn btn-outline-light btn-lg px-4">
                            Get in Touch
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Stats Section --}}
    @if(isset($stats))
    <section class="stats-section py-5" style="background: #f8f9fa;">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-3 col-6" data-aos="fade-up">
                    <div class="text-center">
                        <div class="stat-icon mb-3">
                            <i class="fas fa-award fa-3x" style="color: #2E7D32;"></i>
                        </div>
                        <h3 class="fw-bold mb-1" style="color: #2E7D32;">{{ $stats['years_experience'] }}+</h3>
                        <p class="text-muted mb-0">Years Experience</p>
                    </div>
                </div>
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="text-center">
                        <div class="stat-icon mb-3">
                            <i class="fas fa-users fa-3x" style="color: #66BB6A;"></i>
                        </div>
                        <h3 class="fw-bold mb-1" style="color: #2E7D32;">{{ $stats['happy_clients'] }}+</h3>
                        <p class="text-muted mb-0">Happy Clients</p>
                    </div>
                </div>
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="text-center">
                        <div class="stat-icon mb-3">
                            <i class="fas fa-box fa-3x" style="color: #FFA000;"></i>
                        </div>
                        <h3 class="fw-bold mb-1" style="color: #2E7D32;">{{ number_format($stats['products_delivered']) }}+</h3>
                        <p class="text-muted mb-0">Products Delivered</p>
                    </div>
                </div>
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="text-center">
                        <div class="stat-icon mb-3">
                            <i class="fas fa-seedling fa-3x" style="color: #4CAF50;"></i>
                        </div>
                        <h3 class="fw-bold mb-1" style="color: #2E7D32;">{{ number_format($stats['trees_planted']) }}+</h3>
                        <p class="text-muted mb-0">Trees Planted</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- Main Content --}}
    <section class="content-section py-5" style="background:#fff;">
        <div class="container">
            <div class="row align-items-center g-5">
                <!-- Left: Text content -->
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="content-box">
                        {!! $page->content !!}
                    </div>
                </div>
                <!-- Right: Why Choose Us cards -->
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="row g-3">
                        @php
                        $features = [
                            ['icon'=>'fas fa-leaf',        'color'=>'#2E7D32', 'bg'=>'#e8f5e9', 'title'=>'100% Eco-Friendly Materials',       'desc'=>'Every product is crafted from sustainable, biodegradable materials.'],
                            ['icon'=>'fas fa-paint-brush', 'color'=>'#66BB6A', 'bg'=>'#f1f8e9', 'title'=>'Customizable Branding Options',     'desc'=>'Your logo, your colors — fully customized for your brand identity.'],
                            ['icon'=>'fas fa-shipping-fast','color'=>'#FFA000','bg'=>'#fff8e1', 'title'=>'Fast Production & Delivery',         'desc'=>'Quick turnaround with reliable delivery across India & globally.'],
                            ['icon'=>'fas fa-tags',        'color'=>'#8BC34A', 'bg'=>'#f9fbe7', 'title'=>'Competitive Bulk Pricing',          'desc'=>'The best eco rates for bulk orders — maximize your ROI.'],
                            ['icon'=>'fas fa-headset',     'color'=>'#2E7D32', 'bg'=>'#e8f5e9', 'title'=>'Exceptional Customer Service',      'desc'=>'Dedicated support from concept to delivery, every step.'],
                            ['icon'=>'fas fa-seedling',    'color'=>'#1B4332', 'bg'=>'#e8f5e9', 'title'=>'Seeds That Grow After Use',         'desc'=>'Our plantable products turn into beautiful plants — zero waste.'],
                        ];
                        @endphp
                        @foreach($features as $f)
                        <div class="col-sm-6">
                            <div class="p-3 rounded-3 h-100 d-flex align-items-start gap-3" style="background:{{ $f['bg'] }}; border:1px solid {{ $f['color'] }}22; transition:transform .2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
                                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:42px;height:42px; background:{{ $f['color'] }}22;">
                                    <i class="{{ $f['icon'] }}" style="color:{{ $f['color'] }};"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1" style="color:#1B4332; font-size:0.85rem;">{{ $f['title'] }}</h6>
                                    <p class="mb-0 text-muted" style="font-size:0.78rem;">{{ $f['desc'] }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Mission & Vision --}}
    <section class="mission-vision py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6" data-aos="fade-right">
                    <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #2E7D32 !important;">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-box me-3" style="background: rgba(46, 125, 50, 0.1); width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-bullseye fa-2x" style="color: #2E7D32;"></i>
                                </div>
                                <h3 class="mb-0 fw-bold">Our Mission</h3>
                            </div>
                            <p class="text-muted mb-0">
                                To revolutionize the promotional products industry by offering sustainable, plantable alternatives 
                                that leave a positive environmental impact. Every product we create contributes to a greener planet.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6" data-aos="fade-left">
                    <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #66BB6A !important;">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-box me-3" style="background: rgba(102, 187, 106, 0.1); width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-eye fa-2x" style="color: #66BB6A;"></i>
                                </div>
                                <h3 class="mb-0 fw-bold">Our Vision</h3>
                            </div>
                            <p class="text-muted mb-0">
                                To become the global leader in eco-friendly promotional products, inspiring businesses worldwide 
                                to adopt sustainable practices and create a lasting positive impact on our environment.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Values Section --}}
    <section class="values-section py-5">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="fw-bold mb-3" style="color: #2E7D32;">Our Core Values</h2>
                <p class="text-muted">The principles that guide everything we do</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="value-card text-center p-4">
                        <div class="icon-wrapper mb-3 mx-auto" style="width: 80px; height: 80px; background: rgba(46, 125, 50, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-leaf fa-2x" style="color: #2E7D32;"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Sustainability</h5>
                        <p class="text-muted small mb-0">Every product is designed with the environment in mind, ensuring minimal waste and maximum green impact.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="value-card text-center p-4">
                        <div class="icon-wrapper mb-3 mx-auto" style="width: 80px; height: 80px; background: rgba(102, 187, 106, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-star fa-2x" style="color: #66BB6A;"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Quality</h5>
                        <p class="text-muted small mb-0">We never compromise on quality. Premium materials and craftsmanship in every plantable product.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="value-card text-center p-4">
                        <div class="icon-wrapper mb-3 mx-auto" style="width: 80px; height: 80px; background: rgba(255, 160, 0, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-lightbulb fa-2x" style="color: #FFA000;"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Innovation</h5>
                        <p class="text-muted small mb-0">Constantly developing new eco-friendly products and sustainable solutions for modern businesses.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Testimonials Section — Admin-managed Swiper carousel --}}
    @if(isset($testimonials) && $testimonials->count() > 0)
    <section class="py-5" style="background:#f0faf0;">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="d-inline-block px-3 py-1 rounded-pill fw-semibold mb-3"
                      style="background:#e8f5e9; color:#2E7D32; font-size:0.85rem;">
                    <i class="fas fa-quote-left me-1"></i> Testimonials
                </span>
                <h2 class="fw-bold mb-2" style="color:#1B4332;">What Our Clients Say</h2>
                <p class="text-muted">Trusted by businesses worldwide</p>
                <div class="mx-auto mt-2" style="width:50px;height:4px;background:linear-gradient(90deg,#2E7D32,#66BB6A);border-radius:2px;"></div>
            </div>

            <!-- Carousel wrapper -->
            <div style="position:relative; padding:0 12px;">
                <div class="about-testimonials-swiper swiper" style="padding-bottom:52px;">
                    <div class="swiper-wrapper">
                        @foreach($testimonials as $testimonial)
                        <div class="swiper-slide" style="height:auto;">
                            <div class="card border-0 h-100 p-4"
                                 style="border-radius:16px;
                                        box-shadow:0 4px 20px rgba(46,125,50,0.10);
                                        border:1px solid rgba(46,125,50,0.10) !important;
                                        min-height:230px; display:flex; flex-direction:column;">
                                <!-- watermark quote -->
                                <div style="position:absolute;top:10px;right:14px;font-size:2.5rem;color:#2E7D32;opacity:0.07;">
                                    <i class="fas fa-quote-right"></i>
                                </div>
                                <!-- stars -->
                                <div class="mb-3">
                                    @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star" style="color:{{ $i <= $testimonial->rating ? '#FFA000' : '#e0e0e0' }};font-size:13px;"></i>
                                    @endfor
                                </div>
                                <!-- content -->
                                <p class="text-muted mb-4 fst-italic flex-grow-1" style="font-size:0.9rem;line-height:1.7;">
                                    "{{ $testimonial->content }}"
                                </p>
                                <!-- author -->
                                <div class="d-flex align-items-center mt-auto">
                                    @if($testimonial->image)
                                        <img src="{{ asset('storage/' . $testimonial->image) }}"
                                             alt="{{ $testimonial->name }}"
                                             class="rounded-circle me-3 flex-shrink-0"
                                             style="width:46px;height:46px;object-fit:cover;border:3px solid #e8f5e9;">
                                    @else
                                        <div class="rounded-circle me-3 flex-shrink-0 d-flex align-items-center justify-content-center text-white fw-bold"
                                             style="width:46px;height:46px;background:linear-gradient(135deg,#2E7D32,#66BB6A);font-size:1rem;">
                                            {{ strtoupper(substr($testimonial->name,0,1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <h6 class="mb-0 fw-bold" style="color:#1B4332;font-size:0.9rem;">{{ $testimonial->name }}</h6>
                                        @if($testimonial->designation || $testimonial->company)
                                        <small style="color:#66BB6A;">
                                            {{ $testimonial->designation }}@if($testimonial->designation && $testimonial->company), @endif{{ $testimonial->company }}
                                        </small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination about-t-dots" style="bottom:8px;"></div>
                </div>
                <button class="at-prev"><i class="fas fa-chevron-left" style="font-size:13px;"></i></button>
                <button class="at-next"><i class="fas fa-chevron-right" style="font-size:13px;"></i></button>
            </div>

        </div>
    </section>

    @push('styles')
    <style>
    .about-testimonials-swiper .swiper-pagination-bullet        { background:#2E7D32; opacity:.3; width:9px; height:9px; }
    .about-testimonials-swiper .swiper-pagination-bullet-active { background:#2E7D32; opacity:1; width:22px; border-radius:4px; }
    .at-prev, .at-next {
        position:absolute; top:50%; z-index:10;
        width:38px; height:38px; border-radius:50%;
        background:#2E7D32; color:#fff; border:none; cursor:pointer;
        display:flex; align-items:center; justify-content:center;
        box-shadow:0 2px 10px rgba(46,125,50,.3);
        transition:background .2s;
        transform:translateY(-60%);
    }
    .at-prev { left:0; }
    .at-next { right:0; }
    .at-prev:hover, .at-next:hover { background:#1B4332; }
    </style>
    @endpush

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof Swiper !== 'undefined' && document.querySelector('.about-testimonials-swiper')) {
            new Swiper('.about-testimonials-swiper', {
                slidesPerView: 1,
                spaceBetween: 20,
                loop: true,
                autoplay: { delay: 4000, disableOnInteraction: false, pauseOnMouseEnter: true },
                pagination: { el: '.about-t-dots', clickable: true },
                navigation:  { nextEl: '.at-next', prevEl: '.at-prev' },
                breakpoints: {
                    640:  { slidesPerView: 1 },
                    768:  { slidesPerView: 2 },
                    1024: { slidesPerView: 3 },
                },
            });
        }
    });
    </script>
    @endpush
    @endif

    {{-- CTA Section --}}
    <section class="cta-section py-5" style="background: linear-gradient(135deg, #2E7D32 0%, #66BB6A 100%);">
        <div class="container">
            <div class="row align-items-center g-3">
                <div class="col-lg-8 text-center text-lg-start text-white" data-aos="fade-right">
                    <h2 class="fw-bold mb-2">Ready to Go Green?</h2>
                    <p class="mb-0 opacity-75">Join hundreds of businesses making a positive environmental impact with plantable products.</p>
                </div>
                <div class="col-lg-4 text-center text-lg-end" data-aos="fade-left">
                    <a href="{{ route('frontend.contact') }}" class="btn btn-light btn-lg px-4">
                        <i class="fas fa-envelope me-2"></i>Contact Us Today
                    </a>
                </div>
            </div>
        </div>
    </section>

@else
    {{-- Default Page Layout --}}
    <section class="page-header py-5" style="background: linear-gradient(135deg, #2E7D32 0%, #66BB6A 100%);">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center text-white">
                    <h1 class="display-5 fw-bold mb-3">{{ $page->title }}</h1>
                    @if($page->excerpt)
                    <p class="lead">{{ $page->excerpt }}</p>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="page-content py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="content-wrapper">
                        {!! $page->content !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
@endsection

@push('styles')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<style>
.content-box, .content-wrapper {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #333;
}
.content-box h2, .content-wrapper h2 {
    color: #2E7D32;
    font-weight: 700;
    margin-top: 2rem;
    margin-bottom: 1rem;
}
.content-box h3, .content-wrapper h3 {
    color: #66BB6A;
    font-weight: 600;
    margin-top: 1.5rem;
    margin-bottom: 0.8rem;
}
.content-box p, .content-wrapper p {
    margin-bottom: 1.2rem;
}
.value-card {
    transition: transform 0.3s, box-shadow 0.3s;
}
.value-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    AOS.init({
        duration: 800,
        once: true,
        offset: 100
    });
});
</script>
@endpush
