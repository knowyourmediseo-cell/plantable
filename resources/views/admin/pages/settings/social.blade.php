@extends('layouts.admin.app')
@section('title', 'Social Settings')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0"><i class="fas fa-share-alt me-2 text-secondary"></i>Social Media Settings</h1>
    <a href="{{ route('admin.settings.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Settings</a>
</div>

<div class="card shadow-sm">
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.settings.general') }}">General</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.settings.theme') }}">Theme</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.settings.seo') }}">SEO</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.settings.email') }}">Email</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.settings.payment') }}">Payment</a></li>
            <li class="nav-item"><a class="nav-link active" href="{{ route('admin.settings.social') }}">Social</a></li>
        </ul>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            <input type="hidden" name="group" value="social">

            <div class="row g-3">
                @php
                    $socialPlatforms = [
                        'facebook_url'   => ['icon' => 'fab fa-facebook text-primary', 'label' => 'Facebook URL'],
                        'twitter_url'    => ['icon' => 'fab fa-twitter text-info', 'label' => 'Twitter / X URL'],
                        'instagram_url'  => ['icon' => 'fab fa-instagram text-danger', 'label' => 'Instagram URL'],
                        'linkedin_url'   => ['icon' => 'fab fa-linkedin text-primary', 'label' => 'LinkedIn URL'],
                        'youtube_url'    => ['icon' => 'fab fa-youtube text-danger', 'label' => 'YouTube URL'],
                        'pinterest_url'  => ['icon' => 'fab fa-pinterest text-danger', 'label' => 'Pinterest URL'],
                        'whatsapp_number' => ['icon' => 'fab fa-whatsapp text-success', 'label' => 'WhatsApp Number'],
                        'telegram_url'   => ['icon' => 'fab fa-telegram text-info', 'label' => 'Telegram URL'],
                    ];
                @endphp

                @foreach($socialPlatforms as $key => $platform)
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="{{ $platform['icon'] }} me-2"></i>{{ $platform['label'] }}
                    </label>
                    <input type="{{ $key === 'whatsapp_number' ? 'tel' : 'url' }}" name="{{ $key }}"
                        class="form-control"
                        value="{{ $settings[$key] ?? '' }}"
                        placeholder="{{ str_contains($key,'number') ? '+91 98765 43210' : 'https://' }}">
                </div>
                @endforeach

                <div class="col-12 mt-3">
                    <hr>
                    <h5 class="fw-bold mb-3">Social Sharing</h5>
                    <div class="row g-2">
                        @foreach(['enable_share_facebook'=>'Share on Facebook','enable_share_twitter'=>'Share on Twitter','enable_share_whatsapp'=>'Share on WhatsApp','enable_share_pinterest'=>'Share on Pinterest'] as $key => $label)
                        <div class="col-md-3">
                            <div class="form-check form-switch">
                                <input type="checkbox" name="{{ $key }}" class="form-check-input" id="{{ $key }}" value="1"
                                    {{ ($settings[$key] ?? '1') === '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="{{ $key }}">{{ $label }}</label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <hr class="my-4">
            <button type="submit" class="btn btn-secondary"><i class="fas fa-save me-1"></i> Save Social Settings</button>
        </form>
    </div>
</div>
@endsection
