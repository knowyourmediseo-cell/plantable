@extends('layouts.frontend.app')

@section('title', 'Frequently Asked Questions')
@section('meta_description', 'Find answers to commonly asked questions about our eco-friendly plantable products.')

@section('content')

{{-- Hero Section --}}
<section style="background: linear-gradient(135deg, #1B4332 0%, #2E7D32 60%, #388E3C 100%); padding: 80px 0 50px;">
    <div class="container text-center text-white">
        <div class="mb-3">
            <span style="background: rgba(255,255,255,0.15); border-radius: 50px; padding: 6px 20px; font-size: 0.85rem; letter-spacing: 1px; text-transform: uppercase;">
                <i class="fas fa-question-circle me-2"></i>FAQ
            </span>
        </div>
        <h1 class="display-5 fw-bold mb-3">Frequently Asked Questions</h1>
        <p class="lead mb-4" style="opacity: 0.85; max-width: 550px; margin: 0 auto;">
            Everything you need to know about our eco-friendly plantable products
        </p>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0" style="background: none;">
                <li class="breadcrumb-item">
                    <a href="{{ route('frontend.home') }}" class="text-white" style="opacity: 0.75; text-decoration: none;">
                        <i class="fas fa-home me-1"></i>Home
                    </a>
                </li>
                <li class="breadcrumb-item active text-white">FAQ</li>
            </ol>
        </nav>
    </div>
</section>

{{-- FAQ Content --}}
<section class="py-5" style="background: #f8fdf8;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-9">

                @if($faqs->count() > 0)

                    {{-- If there are categories, group them --}}
                    @php $catIndex = 0; @endphp
                    @foreach($faqs as $category => $items)
                    @php $catIndex++; @endphp

                    <div class="mb-5">
                        {{-- Category Header --}}
                        <div class="d-flex align-items-center mb-4">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                                 style="width: 44px; height: 44px; background: linear-gradient(135deg, #2E7D32, #66BB6A);">
                                <i class="fas fa-folder-open text-white" style="font-size: 1rem;"></i>
                            </div>
                            <h4 class="fw-bold mb-0" style="color: #1B4332;">
                                {{ $category ?? 'General Questions' }}
                            </h4>
                            <span class="ms-3 badge" style="background: #e8f5e9; color: #2E7D32; font-size: 0.75rem;">
                                {{ $items->count() }} {{ $items->count() === 1 ? 'question' : 'questions' }}
                            </span>
                        </div>

                        {{-- Accordion for this category --}}
                        <div class="accordion" id="faqAccordion{{ $catIndex }}">
                            @foreach($items as $index => $faq)
                            @php $faqId = 'faq-' . $catIndex . '-' . $index; @endphp
                            <div class="accordion-item border-0 mb-3 shadow-sm"
                                 style="border-radius: 12px !important; overflow: hidden;">
                                <h2 class="accordion-header" id="heading-{{ $faqId }}">
                                    <button class="accordion-button {{ $index > 0 || $catIndex > 1 ? 'collapsed' : '' }} fw-semibold"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapse-{{ $faqId }}"
                                            aria-expanded="{{ $index === 0 && $catIndex === 1 ? 'true' : 'false' }}"
                                            aria-controls="collapse-{{ $faqId }}"
                                            style="background: #fff; color: #1B4332; border: none; padding: 1.1rem 1.5rem; font-size: 0.97rem;">
                                        <i class="fas fa-leaf me-3" style="color: #66BB6A; font-size: 0.9rem;"></i>
                                        {{ $faq->question }}
                                    </button>
                                </h2>
                                <div id="collapse-{{ $faqId }}"
                                     class="accordion-collapse collapse {{ $index === 0 && $catIndex === 1 ? 'show' : '' }}"
                                     aria-labelledby="heading-{{ $faqId }}"
                                     data-bs-parent="#faqAccordion{{ $catIndex }}">
                                    <div class="accordion-body" style="background: #f9fdf9; padding: 1.2rem 1.5rem; color: #555; line-height: 1.7; font-size: 0.95rem; border-top: 2px solid #e8f5e9;">
                                        {!! nl2br(e($faq->answer)) !!}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach

                @else
                {{-- Empty State --}}
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-question-circle fa-5x" style="color: #cce5cc;"></i>
                    </div>
                    <h4 class="fw-bold mb-2" style="color: #1B4332;">No FAQs Available</h4>
                    <p class="text-muted mb-4">We're working on adding answers to common questions. Have a question?</p>
                    <a href="{{ route('frontend.contact') }}" class="btn text-white px-4 py-2" style="background: #2E7D32; border-radius: 8px;">
                        <i class="fas fa-envelope me-2"></i>Ask Us Directly
                    </a>
                </div>
                @endif

            </div>
        </div>
    </div>
</section>

{{-- Still have questions CTA --}}
<section class="py-5 text-center" style="background: #fff;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <i class="fas fa-headset fa-3x mb-3" style="color: #66BB6A;"></i>
                <h3 class="fw-bold mb-3" style="color: #1B4332;">Still have questions?</h3>
                <p class="text-muted mb-4">Can't find the answer you're looking for? Our friendly support team is here to help.</p>
                <a href="{{ route('frontend.contact') }}" class="btn btn-lg text-white px-5 py-3 fw-semibold"
                   style="background: #2E7D32; border: none; border-radius: 10px;">
                    <i class="fas fa-envelope me-2"></i>Contact Us
                </a>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
.accordion-button:not(.collapsed) {
    background: linear-gradient(135deg, #e8f5e9, #f1f8e9) !important;
    color: #1B4332 !important;
    box-shadow: none !important;
}
.accordion-button:focus {
    box-shadow: 0 0 0 0.2rem rgba(46, 125, 50, 0.25) !important;
}
.accordion-button::after {
    filter: none;
}
.accordion-button:not(.collapsed)::after {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%232E7D32'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
}
</style>
@endpush
