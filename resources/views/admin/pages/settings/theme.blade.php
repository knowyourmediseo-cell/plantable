@extends('layouts.admin.app')
@section('title', 'Theme Settings')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0"><i class="fas fa-palette me-2 text-success"></i>Theme Settings</h1>
    <a href="{{ route('admin.settings.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Settings</a>
</div>

<div class="card shadow-sm">
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.settings.general') }}">General</a></li>
            <li class="nav-item"><a class="nav-link active" href="{{ route('admin.settings.theme') }}">Theme</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.settings.seo') }}">SEO</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.settings.email') }}">Email</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.settings.payment') }}">Payment</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.settings.social') }}">Social</a></li>
        </ul>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            <input type="hidden" name="group" value="theme">

            <h5 class="fw-bold mb-3">Color Scheme</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Primary Color</label>
                    <div class="input-group">
                        <input type="color" name="primary_color" class="form-control form-control-color"
                            value="{{ $settings['primary_color'] ?? '#2E7D32' }}" style="max-width:60px;">
                        <input type="text" class="form-control" value="{{ $settings['primary_color'] ?? '#2E7D32' }}"
                            placeholder="#2E7D32" oninput="this.previousElementSibling.value=this.value">
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Secondary Color</label>
                    <div class="input-group">
                        <input type="color" name="secondary_color" class="form-control form-control-color"
                            value="{{ $settings['secondary_color'] ?? '#4CAF50' }}" style="max-width:60px;">
                        <input type="text" class="form-control" value="{{ $settings['secondary_color'] ?? '#4CAF50' }}"
                            placeholder="#4CAF50" oninput="this.previousElementSibling.value=this.value">
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Accent Color</label>
                    <div class="input-group">
                        <input type="color" name="accent_color" class="form-control form-control-color"
                            value="{{ $settings['accent_color'] ?? '#8BC34A' }}" style="max-width:60px;">
                        <input type="text" class="form-control" value="{{ $settings['accent_color'] ?? '#8BC34A' }}"
                            placeholder="#8BC34A" oninput="this.previousElementSibling.value=this.value">
                    </div>
                </div>
            </div>

            <h5 class="fw-bold mb-3">Typography</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Primary Font</label>
                    <select name="primary_font" class="form-select">
                        @foreach(['Poppins','Inter','Roboto','Lato','Open Sans','Montserrat','Nunito','Raleway'] as $font)
                        <option value="{{ $font }}" {{ ($settings['primary_font'] ?? 'Poppins') === $font ? 'selected' : '' }}>{{ $font }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Secondary Font</label>
                    <select name="secondary_font" class="form-select">
                        @foreach(['Inter','Poppins','Roboto','Lato','Open Sans','Merriweather','Georgia','Playfair Display'] as $font)
                        <option value="{{ $font }}" {{ ($settings['secondary_font'] ?? 'Inter') === $font ? 'selected' : '' }}>{{ $font }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <h5 class="fw-bold mb-3">Layout Options</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Products Per Page</label>
                    <select name="products_per_page" class="form-select">
                        @foreach([8,12,16,20,24,36] as $num)
                        <option value="{{ $num }}" {{ ($settings['products_per_page'] ?? 12) == $num ? 'selected' : '' }}>{{ $num }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Blogs Per Page</label>
                    <select name="blogs_per_page" class="form-select">
                        @foreach([6,9,12,15,18] as $num)
                        <option value="{{ $num }}" {{ ($settings['blogs_per_page'] ?? 9) == $num ? 'selected' : '' }}>{{ $num }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Default Grid Columns</label>
                    <select name="default_grid" class="form-select">
                        <option value="3" {{ ($settings['default_grid'] ?? '3') === '3' ? 'selected' : '' }}>3 Columns</option>
                        <option value="4" {{ ($settings['default_grid'] ?? '3') === '4' ? 'selected' : '' }}>4 Columns</option>
                        <option value="2" {{ ($settings['default_grid'] ?? '3') === '2' ? 'selected' : '' }}>2 Columns</option>
                    </select>
                </div>
            </div>

            <h5 class="fw-bold mb-3">Custom Code</h5>
            <div class="row g-3">
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Custom CSS</label>
                    <textarea name="custom_css" class="form-control" rows="5" placeholder="/* Custom CSS here */">{{ $settings['custom_css'] ?? '' }}</textarea>
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Custom JavaScript (Head)</label>
                    <textarea name="custom_js_head" class="form-control" rows="4" placeholder="Scripts to insert in &lt;head&gt;">{{ $settings['custom_js_head'] ?? '' }}</textarea>
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Custom JavaScript (Body)</label>
                    <textarea name="custom_js_body" class="form-control" rows="4" placeholder="Scripts to insert before &lt;/body&gt;">{{ $settings['custom_js_body'] ?? '' }}</textarea>
                </div>
            </div>

            <hr class="my-4">
            <button type="submit" class="btn btn-success"><i class="fas fa-save me-1"></i> Save Theme Settings</button>
        </form>
    </div>
</div>
@endsection
