@extends('layouts.admin.app')

@section('title', 'Settings')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-cog me-2"></i>Site Settings</h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <!-- General Settings -->
                        <div class="col-md-4">
                            <a href="{{ route('admin.settings.general') }}" class="text-decoration-none">
                                <div class="card border-0 shadow-sm h-100 hover-lift">
                                    <div class="card-body text-center p-4">
                                        <div class="avatar avatar-xl bg-primary bg-opacity-10 text-primary rounded-circle mx-auto mb-3">
                                            <i class="fas fa-sliders-h fa-2x"></i>
                                        </div>
                                        <h5 class="mb-2">General Settings</h5>
                                        <p class="text-muted small mb-0">Site name, logo, favicon, contact information</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Theme Settings -->
                        <div class="col-md-4">
                            <a href="{{ route('admin.settings.theme') }}" class="text-decoration-none">
                                <div class="card border-0 shadow-sm h-100 hover-lift">
                                    <div class="card-body text-center p-4">
                                        <div class="avatar avatar-xl bg-success bg-opacity-10 text-success rounded-circle mx-auto mb-3">
                                            <i class="fas fa-palette fa-2x"></i>
                                        </div>
                                        <h5 class="mb-2">Theme Settings</h5>
                                        <p class="text-muted small mb-0">Colors, fonts, custom CSS/JS</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- SEO Settings -->
                        <div class="col-md-4">
                            <a href="{{ route('admin.settings.seo') }}" class="text-decoration-none">
                                <div class="card border-0 shadow-sm h-100 hover-lift">
                                    <div class="card-body text-center p-4">
                                        <div class="avatar avatar-xl bg-info bg-opacity-10 text-info rounded-circle mx-auto mb-3">
                                            <i class="fas fa-search fa-2x"></i>
                                        </div>
                                        <h5 class="mb-2">SEO Settings</h5>
                                        <p class="text-muted small mb-0">Meta tags, analytics, tracking codes</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Email Settings -->
                        <div class="col-md-4">
                            <a href="{{ route('admin.settings.email') }}" class="text-decoration-none">
                                <div class="card border-0 shadow-sm h-100 hover-lift">
                                    <div class="card-body text-center p-4">
                                        <div class="avatar avatar-xl bg-warning bg-opacity-10 text-warning rounded-circle mx-auto mb-3">
                                            <i class="fas fa-envelope fa-2x"></i>
                                        </div>
                                        <h5 class="mb-2">Email Settings</h5>
                                        <p class="text-muted small mb-0">SMTP configuration, email templates</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Payment Settings -->
                        <div class="col-md-4">
                            <a href="{{ route('admin.settings.payment') }}" class="text-decoration-none">
                                <div class="card border-0 shadow-sm h-100 hover-lift">
                                    <div class="card-body text-center p-4">
                                        <div class="avatar avatar-xl bg-danger bg-opacity-10 text-danger rounded-circle mx-auto mb-3">
                                            <i class="fas fa-credit-card fa-2x"></i>
                                        </div>
                                        <h5 class="mb-2">Payment Settings</h5>
                                        <p class="text-muted small mb-0">Payment gateways, currency settings</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Social Media Settings -->
                        <div class="col-md-4">
                            <a href="{{ route('admin.settings.social') }}" class="text-decoration-none">
                                <div class="card border-0 shadow-sm h-100 hover-lift">
                                    <div class="card-body text-center p-4">
                                        <div class="avatar avatar-xl bg-secondary bg-opacity-10 text-secondary rounded-circle mx-auto mb-3">
                                            <i class="fas fa-share-alt fa-2x"></i>
                                        </div>
                                        <h5 class="mb-2">Social Media Settings</h5>
                                        <p class="text-muted small mb-0">Social profiles, integration links</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Commerce Settings -->
                        <div class="col-md-4">
                            <a href="{{ route('admin.settings.commerce') }}" class="text-decoration-none">
                                <div class="card border-0 shadow-sm h-100 hover-lift">
                                    <div class="card-body text-center p-4">
                                        <div class="avatar avatar-xl bg-success bg-opacity-10 text-success rounded-circle mx-auto mb-3">
                                            <i class="fas fa-shopping-cart fa-2x"></i>
                                        </div>
                                        <h5 class="mb-2">Commerce Settings</h5>
                                        <p class="text-muted small mb-0">Currency, tax, shipping charges</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hover-lift {
    transition: transform 0.3s, box-shadow 0.3s;
}
.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
}
.avatar {
    width: 80px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
@endsection
