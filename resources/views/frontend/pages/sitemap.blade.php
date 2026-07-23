@extends('layouts.frontend.app')

@section('title', 'Sitemap')
@section('meta_description', 'Browse all pages of Plantable Eco — your guide to our eco-friendly plantable products.')

@section('content')

{{-- Hero Section --}}
<section style="background: linear-gradient(135deg, #1B4332 0%, #2E7D32 60%, #388E3C 100%); padding: 60px 0 40px;">
    <div class="container text-center text-white">
        <h1 class="display-6 fw-bold mb-2">Sitemap</h1>
        <p class="lead mb-3" style="opacity: 0.85;">All the pages you need, in one place</p>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0" style="background: none;">
                <li class="breadcrumb-item">
                    <a href="{{ route('frontend.home') }}" class="text-white" style="opacity: 0.75; text-decoration: none;">
                        <i class="fas fa-home me-1"></i>Home
                    </a>
                </li>
                <li class="breadcrumb-item active text-white">Sitemap</li>
            </ol>
        </nav>
    </div>
</section>

{{-- Sitemap Content --}}
<section class="py-5">
    <div class="container">
        <div class="row g-4">

            {{-- Main Pages --}}
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 14px; overflow: hidden;">
                    <div class="card-header border-0 text-white fw-bold py-3 px-4" style="background: linear-gradient(135deg, #2E7D32, #1B4332);">
                        <i class="fas fa-file-alt me-2"></i>Main Pages
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item border-0 py-2 px-4">
                            <a href="{{ route('frontend.home') }}" class="text-decoration-none d-flex align-items-center"
                               style="color: #2E7D32;">
                                <i class="fas fa-chevron-right me-2" style="font-size: 0.75rem; color: #66BB6A;"></i>
                                Home
                            </a>
                        </li>
                        <li class="list-group-item border-0 py-2 px-4" style="background: #f8fdf8;">
                            <a href="{{ route('frontend.gallery') }}" class="text-decoration-none d-flex align-items-center"
                               style="color: #2E7D32;">
                                <i class="fas fa-chevron-right me-2" style="font-size: 0.75rem; color: #66BB6A;"></i>
                                Gallery
                            </a>
                        </li>
                        <li class="list-group-item border-0 py-2 px-4">
                            <a href="{{ route('frontend.videos') }}" class="text-decoration-none d-flex align-items-center"
                               style="color: #2E7D32;">
                                <i class="fas fa-chevron-right me-2" style="font-size: 0.75rem; color: #66BB6A;"></i>
                                Videos
                            </a>
                        </li>
                        <li class="list-group-item border-0 py-2 px-4" style="background: #f8fdf8;">
                            <a href="{{ route('frontend.testimonials') }}" class="text-decoration-none d-flex align-items-center"
                               style="color: #2E7D32;">
                                <i class="fas fa-chevron-right me-2" style="font-size: 0.75rem; color: #66BB6A;"></i>
                                Testimonials
                            </a>
                        </li>
                        <li class="list-group-item border-0 py-2 px-4">
                            <a href="{{ route('frontend.faq') }}" class="text-decoration-none d-flex align-items-center"
                               style="color: #2E7D32;">
                                <i class="fas fa-chevron-right me-2" style="font-size: 0.75rem; color: #66BB6A;"></i>
                                FAQ
                            </a>
                        </li>
                        <li class="list-group-item border-0 py-2 px-4" style="background: #f8fdf8;">
                            <a href="{{ route('frontend.contact') }}" class="text-decoration-none d-flex align-items-center"
                               style="color: #2E7D32;">
                                <i class="fas fa-chevron-right me-2" style="font-size: 0.75rem; color: #66BB6A;"></i>
                                Contact Us
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Products & Shop --}}
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 14px; overflow: hidden;">
                    <div class="card-header border-0 text-white fw-bold py-3 px-4" style="background: linear-gradient(135deg, #2E7D32, #1B4332);">
                        <i class="fas fa-shopping-bag me-2"></i>Shop
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item border-0 py-2 px-4">
                            <a href="{{ route('frontend.products.index') }}" class="text-decoration-none d-flex align-items-center"
                               style="color: #2E7D32;">
                                <i class="fas fa-chevron-right me-2" style="font-size: 0.75rem; color: #66BB6A;"></i>
                                All Products
                            </a>
                        </li>
                        <li class="list-group-item border-0 py-2 px-4" style="background: #f8fdf8;">
                            <a href="{{ route('frontend.categories.index') }}" class="text-decoration-none d-flex align-items-center"
                               style="color: #2E7D32;">
                                <i class="fas fa-chevron-right me-2" style="font-size: 0.75rem; color: #66BB6A;"></i>
                                Categories
                            </a>
                        </li>
                        <li class="list-group-item border-0 py-2 px-4">
                            <a href="{{ route('frontend.cart.index') }}" class="text-decoration-none d-flex align-items-center"
                               style="color: #2E7D32;">
                                <i class="fas fa-chevron-right me-2" style="font-size: 0.75rem; color: #66BB6A;"></i>
                                Shopping Cart
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Content --}}
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 14px; overflow: hidden;">
                    <div class="card-header border-0 text-white fw-bold py-3 px-4" style="background: linear-gradient(135deg, #2E7D32, #1B4332);">
                        <i class="fas fa-blog me-2"></i>Blog & Content
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item border-0 py-2 px-4">
                            <a href="{{ route('frontend.blogs.index') }}" class="text-decoration-none d-flex align-items-center"
                               style="color: #2E7D32;">
                                <i class="fas fa-chevron-right me-2" style="font-size: 0.75rem; color: #66BB6A;"></i>
                                Blog
                            </a>
                        </li>
                        <li class="list-group-item border-0 py-2 px-4" style="background: #f8fdf8;">
                            <a href="{{ route('frontend.inquiry.track') }}" class="text-decoration-none d-flex align-items-center"
                               style="color: #2E7D32;">
                                <i class="fas fa-chevron-right me-2" style="font-size: 0.75rem; color: #66BB6A;"></i>
                                Track Inquiry
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>

        {{-- Last Updated --}}
        <div class="text-center mt-5 text-muted" style="font-size: 0.85rem;">
            <i class="fas fa-sync-alt me-1" style="color: #66BB6A;"></i>
            Sitemap last updated: {{ now()->format('F d, Y') }}
        </div>
    </div>
</section>

@endsection
