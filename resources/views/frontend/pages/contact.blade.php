@extends('layouts.frontend.app')

@section('title', 'Contact Us')
@section('meta_description', 'Get in touch with Plantable Eco. We\'d love to hear from you about our eco-friendly plantable products.')

@section('content')

{{-- Hero Section --}}
<section style="background: linear-gradient(135deg, #1B4332 0%, #2E7D32 60%, #388E3C 100%); padding: 80px 0 50px;">
    <div class="container text-center text-white">
        <div class="mb-3">
            <span style="background: rgba(255,255,255,0.15); border-radius: 50px; padding: 6px 20px; font-size: 0.85rem; letter-spacing: 1px; text-transform: uppercase;">
                <i class="fas fa-envelope me-2"></i>Get In Touch
            </span>
        </div>
        <h1 class="display-5 fw-bold mb-3">Contact Us</h1>
        <p class="lead mb-4" style="opacity: 0.85; max-width: 520px; margin: 0 auto;">
            Have a question or want to place a bulk order? We're here to help you go green.
        </p>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0" style="background: none;">
                <li class="breadcrumb-item">
                    <a href="{{ route('frontend.home') }}" class="text-white" style="opacity: 0.75; text-decoration: none;">
                        <i class="fas fa-home me-1"></i>Home
                    </a>
                </li>
                <li class="breadcrumb-item active text-white">Contact Us</li>
            </ol>
        </nav>
    </div>
</section>

{{-- Flash Messages --}}
@if(session('success'))
<div class="container mt-4">
    <div class="alert border-0 d-flex align-items-center" role="alert"
         style="background: #e8f5e9; border-left: 5px solid #2E7D32 !important; border-radius: 10px;">
        <i class="fas fa-check-circle me-3 fa-lg" style="color: #2E7D32;"></i>
        <div style="color: #1B4332; font-weight: 500;">{{ session('success') }}</div>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
    </div>
</div>
@endif

@if(session('error'))
<div class="container mt-4">
    <div class="alert border-0 d-flex align-items-center" role="alert"
         style="background: #fce4e4; border-left: 5px solid #c62828 !important; border-radius: 10px;">
        <i class="fas fa-exclamation-circle me-3 fa-lg" style="color: #c62828;"></i>
        <div style="color: #b71c1c; font-weight: 500;">{{ session('error') }}</div>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
    </div>
</div>
@endif

{{-- Main Content --}}
<section class="py-5" style="background: #f8fdf8;">
    <div class="container">
        <div class="row g-5 align-items-start">

            {{-- LEFT: Contact Form --}}
            <div class="col-12 col-lg-7">
                <div class="card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden;">
                    <div class="card-header border-0 py-4 px-4 px-md-5" style="background: linear-gradient(135deg, #2E7D32, #1B4332);">
                        <h4 class="text-white fw-bold mb-1">
                            <i class="fas fa-paper-plane me-2"></i>Send Us a Message
                        </h4>
                        <p class="text-white mb-0" style="opacity: 0.8; font-size: 0.9rem;">
                            We'll get back to you within 24 hours
                        </p>
                    </div>
                    <div class="card-body p-4 p-md-5">

                        {{-- Validation Errors --}}
                        @if($errors->any())
                        <div class="alert border-0 mb-4" style="background: #fce4e4; border-left: 5px solid #c62828 !important; border-radius: 10px;">
                            <p class="fw-semibold mb-2" style="color: #b71c1c;">
                                <i class="fas fa-exclamation-triangle me-2"></i>Please fix the following errors:
                            </p>
                            <ul class="mb-0 ps-3" style="color: #c62828; font-size: 0.9rem;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form action="{{ route('frontend.contact.store') }}" method="POST" id="contactForm" novalidate>
                            @csrf

                            <div class="row g-3">
                                {{-- Name --}}
                                <div class="col-12 col-sm-6">
                                    <label for="name" class="form-label fw-semibold" style="color: #1B4332;">
                                        Full Name <span style="color: #c62828;">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text border-end-0"
                                              style="background: #f1f8e9; border-color: #c8e6c9; color: #2E7D32;">
                                            <i class="fas fa-user"></i>
                                        </span>
                                        <input type="text"
                                               class="form-control border-start-0 @error('name') is-invalid @enderror"
                                               id="name"
                                               name="name"
                                               value="{{ old('name') }}"
                                               placeholder="Your full name"
                                               required
                                               style="border-color: #c8e6c9; background: #fff;">
                                        @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Email --}}
                                <div class="col-12 col-sm-6">
                                    <label for="email" class="form-label fw-semibold" style="color: #1B4332;">
                                        Email Address <span style="color: #c62828;">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text border-end-0"
                                              style="background: #f1f8e9; border-color: #c8e6c9; color: #2E7D32;">
                                            <i class="fas fa-envelope"></i>
                                        </span>
                                        <input type="email"
                                               class="form-control border-start-0 @error('email') is-invalid @enderror"
                                               id="email"
                                               name="email"
                                               value="{{ old('email') }}"
                                               placeholder="your@email.com"
                                               required
                                               style="border-color: #c8e6c9; background: #fff;">
                                        @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Phone --}}
                                <div class="col-12 col-sm-6">
                                    <label for="contact-phone" class="form-label fw-semibold" style="color: #1B4332;">
                                        Phone Number
                                        <span class="text-muted fw-normal" style="font-size: 0.82rem;">(optional)</span>
                                    </label>
                                    <div style="display: flex; align-items: stretch; border: 1px solid #c8e6c9; border-radius: 6px; overflow: visible; background: #fff;">
                                        <span style="display: flex; align-items: center; padding: 0 12px; background: #f1f8e9; border-right: 1px solid #c8e6c9; border-radius: 5px 0 0 5px; flex-shrink: 0; color: #2E7D32;">
                                            <i class="fas fa-phone"></i>
                                        </span>
                                        <div style="flex: 1; position: relative; overflow: visible;">
                                            <input type="tel"
                                                   class="form-control @error('phone') is-invalid @enderror"
                                                   id="contact-phone"
                                                   name="phone"
                                                   value="{{ old('phone') }}"
                                                   placeholder="98765 43210"
                                                   style="border: none; border-radius: 0 5px 5px 0; background: #fff; box-shadow: none; width: 100%;">
                                        </div>
                                    </div>
                                    @error('phone')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Subject --}}
                                <div class="col-12 col-sm-6">
                                    <label for="subject" class="form-label fw-semibold" style="color: #1B4332;">
                                        Subject <span style="color: #c62828;">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text border-end-0"
                                              style="background: #f1f8e9; border-color: #c8e6c9; color: #2E7D32;">
                                            <i class="fas fa-tag"></i>
                                        </span>
                                        <input type="text"
                                               class="form-control border-start-0 @error('subject') is-invalid @enderror"
                                               id="subject"
                                               name="subject"
                                               value="{{ old('subject') }}"
                                               placeholder="How can we help?"
                                               required
                                               style="border-color: #c8e6c9; background: #fff;">
                                        @error('subject')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Message --}}
                                <div class="col-12">
                                    <label for="message" class="form-label fw-semibold" style="color: #1B4332;">
                                        Message <span style="color: #c62828;">*</span>
                                    </label>
                                    <textarea class="form-control @error('message') is-invalid @enderror"
                                              id="message"
                                              name="message"
                                              rows="5"
                                              placeholder="Tell us more about your query, order requirements, or feedback..."
                                              required
                                              style="border-color: #c8e6c9; background: #fff; resize: vertical;">{{ old('message') }}</textarea>
                                    @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Submit Button --}}
                                <div class="col-12">
                                    <button type="submit"
                                            class="btn btn-lg text-white fw-semibold px-5 py-3 w-100"
                                            id="submitBtn"
                                            style="background: linear-gradient(135deg, #2E7D32, #1B4332); border: none; border-radius: 12px; transition: all 0.3s; letter-spacing: 0.5px;">
                                        <i class="fas fa-paper-plane me-2"></i>Send Message
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            {{-- RIGHT: Contact Info --}}
            <div class="col-12 col-lg-5">

                {{-- Info Cards --}}
                <div class="mb-4">
                    <h5 class="fw-bold mb-4" style="color: #1B4332;">
                        <i class="fas fa-info-circle me-2" style="color: #66BB6A;"></i>Get In Touch
                    </h5>

                    {{-- Address Card --}}
                    <div class="d-flex align-items-start mb-4 p-4 rounded-3 shadow-sm"
                         style="background: #fff; border-left: 4px solid #2E7D32;">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                             style="width: 48px; height: 48px; background: linear-gradient(135deg, #2E7D32, #66BB6A);">
                            <i class="fas fa-map-marker-alt text-white"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1" style="color: #1B4332;">Our Address</h6>
                            <p class="text-muted mb-0" style="font-size: 0.9rem; line-height: 1.6;">
                                123 Green Street, Eco Park<br>
                                Mumbai, Maharashtra 400001<br>
                                India
                            </p>
                        </div>
                    </div>

                    {{-- Phone Card --}}
                    <div class="d-flex align-items-start mb-4 p-4 rounded-3 shadow-sm"
                         style="background: #fff; border-left: 4px solid #2E7D32;">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                             style="width: 48px; height: 48px; background: linear-gradient(135deg, #2E7D32, #66BB6A);">
                            <i class="fas fa-phone text-white"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1" style="color: #1B4332;">Phone</h6>
                            <a href="tel:+911234567890" class="d-block text-decoration-none mb-1"
                               style="color: #2E7D32; font-size: 0.9rem;">+91 1234 567 890</a>
                            <a href="tel:+919876543210" class="d-block text-decoration-none"
                               style="color: #2E7D32; font-size: 0.9rem;">+91 9876 543 210</a>
                        </div>
                    </div>

                    {{-- Email Card --}}
                    <div class="d-flex align-items-start mb-4 p-4 rounded-3 shadow-sm"
                         style="background: #fff; border-left: 4px solid #2E7D32;">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                             style="width: 48px; height: 48px; background: linear-gradient(135deg, #2E7D32, #66BB6A);">
                            <i class="fas fa-envelope text-white"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1" style="color: #1B4332;">Email</h6>
                            <a href="mailto:info@plantableeco.com" class="d-block text-decoration-none mb-1"
                               style="color: #2E7D32; font-size: 0.9rem;">info@plantableeco.com</a>
                            <a href="mailto:sales@plantableeco.com" class="d-block text-decoration-none"
                               style="color: #2E7D32; font-size: 0.9rem;">sales@plantableeco.com</a>
                        </div>
                    </div>

                    {{-- Hours Card --}}
                    <div class="d-flex align-items-start mb-4 p-4 rounded-3 shadow-sm"
                         style="background: #fff; border-left: 4px solid #FFA000;">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                             style="width: 48px; height: 48px; background: linear-gradient(135deg, #FFA000, #FFB300);">
                            <i class="fas fa-clock text-white"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1" style="color: #1B4332;">Business Hours</h6>
                            <p class="text-muted mb-0" style="font-size: 0.9rem; line-height: 1.7;">
                                Monday – Friday: 9:00 AM – 6:00 PM<br>
                                Saturday: 10:00 AM – 4:00 PM<br>
                                <span style="color: #c62828;">Sunday: Closed</span>
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Social Links --}}
                <div class="p-4 rounded-3 shadow-sm mb-4" style="background: #fff;">
                    <h6 class="fw-bold mb-3" style="color: #1B4332;">
                        <i class="fas fa-share-alt me-2" style="color: #66BB6A;"></i>Follow Us
                    </h6>
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="#" class="btn text-white d-flex align-items-center justify-content-center"
                           style="width: 42px; height: 42px; background: #1877f2; border-radius: 10px;"
                           aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="btn text-white d-flex align-items-center justify-content-center"
                           style="width: 42px; height: 42px; background: #1da1f2; border-radius: 10px;"
                           aria-label="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="btn text-white d-flex align-items-center justify-content-center"
                           style="width: 42px; height: 42px; background: linear-gradient(135deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888); border-radius: 10px;"
                           aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="btn text-white d-flex align-items-center justify-content-center"
                           style="width: 42px; height: 42px; background: #0077b5; border-radius: 10px;"
                           aria-label="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="btn text-white d-flex align-items-center justify-content-center"
                           style="width: 42px; height: 42px; background: #25d366; border-radius: 10px;"
                           aria-label="WhatsApp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>

                {{-- Map Placeholder --}}
                <div class="rounded-3 shadow-sm overflow-hidden" style="height: 220px;">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3771.9!2d72.8777!3d19.0760!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTnCsDA0JzMzLjYiTiA3MsKwNTInMzkuNyJF!5e0!3m2!1sen!2sin!4v1620000000000!5m2!1sen!2sin"
                        width="100%"
                        height="220"
                        style="border: 0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Plantable Eco Location">
                    </iframe>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
.form-control:focus,
.form-select:focus {
    border-color: #66BB6A !important;
    box-shadow: 0 0 0 0.2rem rgba(46, 125, 50, 0.2) !important;
    outline: none;
}
.input-group:focus-within .input-group-text {
    border-color: #66BB6A !important;
    background: #e8f5e9 !important;
}
#submitBtn:hover {
    background: linear-gradient(135deg, #388E3C, #2E7D32) !important;
    transform: translateY(-1px);
    box-shadow: 0 8px 24px rgba(46, 125, 50, 0.35);
}
#submitBtn:active {
    transform: translateY(0);
}
</style>
@endpush

@push('scripts')
<script>
document.getElementById('contactForm').addEventListener('submit', function(e) {
    const btn = document.getElementById('submitBtn');
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Sending...';
    btn.disabled = true;
});
</script>
@endpush
