@extends('layouts.admin.app')
@section('title', 'SEO Settings')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0"><i class="fas fa-search me-2 text-info"></i>SEO Settings</h1>
    <a href="{{ route('admin.settings.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Settings</a>
</div>

<div class="card shadow-sm">
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.settings.general') }}">General</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.settings.theme') }}">Theme</a></li>
            <li class="nav-item"><a class="nav-link active" href="{{ route('admin.settings.seo') }}">SEO</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.settings.email') }}">Email</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.settings.payment') }}">Payment</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.settings.social') }}">Social</a></li>
        </ul>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            <input type="hidden" name="group" value="seo">

            <h5 class="fw-bold mb-3">Default Meta Tags</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Default Meta Title</label>
                    <input type="text" name="seo_meta_title" class="form-control"
                        value="{{ $settings['seo_meta_title'] ?? '' }}" maxlength="60">
                    <div class="d-flex justify-content-between">
                        <small class="text-muted">Recommended: 50-60 characters</small>
                        <small class="char-counter text-muted" id="title-count">0/60</small>
                    </div>
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Default Meta Description</label>
                    <textarea name="seo_meta_description" class="form-control" rows="3" maxlength="160">{{ $settings['seo_meta_description'] ?? '' }}</textarea>
                    <div class="d-flex justify-content-between">
                        <small class="text-muted">Recommended: 150-160 characters</small>
                        <small class="char-counter text-muted" id="desc-count">0/160</small>
                    </div>
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Default Meta Keywords</label>
                    <input type="text" name="seo_meta_keywords" class="form-control"
                        value="{{ $settings['seo_meta_keywords'] ?? '' }}" placeholder="keyword1, keyword2, keyword3">
                </div>
            </div>

            <h5 class="fw-bold mb-3">Analytics & Tracking</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Google Analytics ID</label>
                    <input type="text" name="google_analytics_id" class="form-control"
                        value="{{ $settings['google_analytics_id'] ?? '' }}" placeholder="G-XXXXXXXXXX or UA-XXXXXXXX-X">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Google Tag Manager ID</label>
                    <input type="text" name="google_tag_manager_id" class="form-control"
                        value="{{ $settings['google_tag_manager_id'] ?? '' }}" placeholder="GTM-XXXXXXX">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Facebook Pixel ID</label>
                    <input type="text" name="facebook_pixel_id" class="form-control"
                        value="{{ $settings['facebook_pixel_id'] ?? '' }}" placeholder="XXXXXXXXXXXXXXX">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Google Search Console Verification</label>
                    <input type="text" name="google_search_console" class="form-control"
                        value="{{ $settings['google_search_console'] ?? '' }}" placeholder="Meta content value">
                </div>
            </div>

            <h5 class="fw-bold mb-3">Open Graph (Social Sharing)</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Default OG Image</label>
                    <input type="text" name="og_default_image" class="form-control"
                        value="{{ $settings['og_default_image'] ?? '' }}" placeholder="https://...">
                    <small class="text-muted">Recommended: 1200x630px</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Twitter Card Type</label>
                    <select name="twitter_card_type" class="form-select">
                        <option value="summary" {{ ($settings['twitter_card_type'] ?? 'summary_large_image') === 'summary' ? 'selected' : '' }}>Summary</option>
                        <option value="summary_large_image" {{ ($settings['twitter_card_type'] ?? 'summary_large_image') === 'summary_large_image' ? 'selected' : '' }}>Summary Large Image</option>
                    </select>
                </div>
            </div>

            <h5 class="fw-bold mb-3">Robots & Indexing</h5>
            <div class="row g-3">
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Robots.txt Content</label>
                    <textarea name="robots_txt" class="form-control font-monospace" rows="6"
                        placeholder="User-agent: *&#10;Disallow: /admin&#10;Allow: /">{{ $settings['robots_txt'] ?? "User-agent: *\nDisallow: /admin\nAllow: /" }}</textarea>
                </div>
                <div class="col-md-6">
                    <div class="form-check form-switch">
                        <input type="checkbox" name="enable_sitemap" class="form-check-input" id="enable_sitemap" value="1"
                            {{ ($settings['enable_sitemap'] ?? '1') === '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="enable_sitemap">Enable Auto Sitemap Generation</label>
                    </div>
                </div>
            </div>

            <hr class="my-4">
            <button type="submit" class="btn btn-info"><i class="fas fa-save me-1"></i> Save SEO Settings</button>
        </form>
    </div>
</div>
@endsection
