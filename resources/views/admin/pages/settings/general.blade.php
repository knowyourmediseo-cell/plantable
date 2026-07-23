@extends('layouts.admin.app')

@section('title', 'General Settings')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-sliders-h me-2"></i>General Settings</h5>
                    <a href="{{ route('admin.settings.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back to Settings
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="group" value="general">

                        <div class="row">
                            <!-- Site Information -->
                            <div class="col-12 mb-4">
                                <h6 class="text-primary border-bottom pb-2 mb-3">
                                    <i class="fas fa-info-circle me-2"></i>Site Information
                                </h6>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Site Name <span class="text-danger">*</span></label>
                                <input type="text" name="site_name" class="form-control" 
                                    value="{{ $settings['site_name'] ?? 'Plantable Eco' }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Site Tagline</label>
                                <input type="text" name="site_tagline" class="form-control" 
                                    value="{{ $settings['site_tagline'] ?? '' }}">
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">Site Description</label>
                                <textarea name="site_description" class="form-control" rows="3">{{ $settings['site_description'] ?? '' }}</textarea>
                            </div>

                            <!-- Logos Section -->
                            <div class="col-12 mb-4 mt-4">
                                <h6 class="text-primary border-bottom pb-2 mb-3">
                                    <i class="fas fa-image me-2"></i>Logos & Branding
                                </h6>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Main Logo (Desktop)</label>
                                <div class="image-upload-wrapper">
                                    <input type="file" name="site_logo" class="form-control image-upload-input" accept="image/*">
                                    <div class="image-preview-container mt-2">
                                        @if(!empty($settings['site_logo']))
                                            <img src="{{ asset('storage/' . $settings['site_logo']) }}" 
                                                class="img-thumbnail" style="max-height: 100px;">
                                        @endif
                                    </div>
                                </div>
                                <small class="text-muted">Recommended: 200x60px (PNG with transparency)</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Logo Dark Mode</label>
                                <div class="image-upload-wrapper">
                                    <input type="file" name="site_logo_dark" class="form-control image-upload-input" accept="image/*">
                                    <div class="image-preview-container mt-2">
                                        @if(!empty($settings['site_logo_dark']))
                                            <img src="{{ asset('storage/' . $settings['site_logo_dark']) }}" 
                                                class="img-thumbnail" style="max-height: 100px;">
                                        @endif
                                    </div>
                                </div>
                                <small class="text-muted">For dark theme/backgrounds</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Mobile Logo</label>
                                <div class="image-upload-wrapper">
                                    <input type="file" name="site_logo_mobile" class="form-control image-upload-input" accept="image/*">
                                    <div class="image-preview-container mt-2">
                                        @if(!empty($settings['site_logo_mobile']))
                                            <img src="{{ asset('storage/' . $settings['site_logo_mobile']) }}" 
                                                class="img-thumbnail" style="max-height: 80px;">
                                        @endif
                                    </div>
                                </div>
                                <small class="text-muted">Recommended: 120x40px (Compact for mobile)</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tablet Logo</label>
                                <div class="image-upload-wrapper">
                                    <input type="file" name="site_logo_tablet" class="form-control image-upload-input" accept="image/*">
                                    <div class="image-preview-container mt-2">
                                        @if(!empty($settings['site_logo_tablet']))
                                            <img src="{{ asset('storage/' . $settings['site_logo_tablet']) }}" 
                                                class="img-thumbnail" style="max-height: 90px;">
                                        @endif
                                    </div>
                                </div>
                                <small class="text-muted">Recommended: 160x50px (Optimized for tablets)</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Footer Logo</label>
                                <div class="image-upload-wrapper">
                                    <input type="file" name="footer_logo" class="form-control image-upload-input" accept="image/*">
                                    <div class="image-preview-container mt-2">
                                        @if(!empty($settings['footer_logo']))
                                            <img src="{{ asset('storage/' . $settings['footer_logo']) }}" 
                                                class="img-thumbnail" style="max-height: 100px;">
                                        @endif
                                    </div>
                                </div>
                                <small class="text-muted">Optional separate footer logo</small>
                            </div>

                            <!-- Favicons Section -->
                            <div class="col-12 mb-4 mt-4">
                                <h6 class="text-primary border-bottom pb-2 mb-3">
                                    <i class="fas fa-icons me-2"></i>Favicons
                                </h6>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Favicon 16x16</label>
                                <div class="image-upload-wrapper">
                                    <input type="file" name="site_favicon_16" class="form-control image-upload-input" accept="image/*">
                                    <div class="image-preview-container mt-2">
                                        @if(!empty($settings['site_favicon_16']))
                                            <img src="{{ asset('storage/' . $settings['site_favicon_16']) }}" 
                                                class="img-thumbnail" style="max-height: 50px;">
                                        @endif
                                    </div>
                                </div>
                                <small class="text-muted">16x16px (Browser tab icon)</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Favicon 32x32</label>
                                <div class="image-upload-wrapper">
                                    <input type="file" name="site_favicon_32" class="form-control image-upload-input" accept="image/*">
                                    <div class="image-preview-container mt-2">
                                        @if(!empty($settings['site_favicon_32']))
                                            <img src="{{ asset('storage/' . $settings['site_favicon_32']) }}" 
                                                class="img-thumbnail" style="max-height: 50px;">
                                        @endif
                                    </div>
                                </div>
                                <small class="text-muted">32x32px (Standard favicon)</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Apple Touch Icon</label>
                                <div class="image-upload-wrapper">
                                    <input type="file" name="site_favicon_180" class="form-control image-upload-input" accept="image/*">
                                    <div class="image-preview-container mt-2">
                                        @if(!empty($settings['site_favicon_180']))
                                            <img src="{{ asset('storage/' . $settings['site_favicon_180']) }}" 
                                                class="img-thumbnail" style="max-height: 80px;">
                                        @endif
                                    </div>
                                </div>
                                <small class="text-muted">180x180px (Apple devices)</small>
                            </div>

                            <!-- Contact Information -->
                            <div class="col-12 mb-4 mt-4">
                                <h6 class="text-primary border-bottom pb-2 mb-3">
                                    <i class="fas fa-address-book me-2"></i>Contact Information
                                </h6>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Contact Email</label>
                                <input type="email" name="contact_email" class="form-control" 
                                    value="{{ $settings['contact_email'] ?? '' }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Contact Phone</label>
                                <input type="text" name="contact_phone" class="form-control" 
                                    value="{{ $settings['contact_phone'] ?? '' }}">
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">Business Address</label>
                                <textarea name="contact_address" class="form-control" rows="2">{{ $settings['contact_address'] ?? '' }}</textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Business Hours</label>
                                <input type="text" name="business_hours" class="form-control" 
                                    value="{{ $settings['business_hours'] ?? '' }}" placeholder="Mon-Fri: 9AM - 6PM">
                            </div>

                            <!-- Regional Settings -->
                            <div class="col-12 mb-4 mt-4">
                                <h6 class="text-primary border-bottom pb-2 mb-3">
                                    <i class="fas fa-globe me-2"></i>Regional Settings
                                </h6>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Currency Symbol</label>
                                <input type="text" name="currency_symbol" class="form-control" 
                                    value="{{ $settings['currency_symbol'] ?? '₹' }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Currency Code</label>
                                <input type="text" name="currency_code" class="form-control" 
                                    value="{{ $settings['currency_code'] ?? 'INR' }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Timezone</label>
                                <input type="text" name="timezone" class="form-control" 
                                    value="{{ $settings['timezone'] ?? 'Asia/Kolkata' }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Date Format</label>
                                <input type="text" name="date_format" class="form-control" 
                                    value="{{ $settings['date_format'] ?? 'd/m/Y' }}" placeholder="d/m/Y">
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-save me-2"></i>Save Settings
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
