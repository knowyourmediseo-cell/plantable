@extends('layouts.frontend.app')
@section('title', 'Track Your Inquiry')

@section('content')

<section style="background: linear-gradient(135deg, #1B4332 0%, #2E7D32 60%, #388E3C 100%); padding: 80px 0 50px;">
    <div class="container text-center text-white">
        <div class="mb-3">
            <span style="background: rgba(255,255,255,0.15); border-radius: 50px; padding: 6px 20px; font-size: 0.85rem; letter-spacing: 1px; text-transform: uppercase;">
                <i class="fas fa-search me-2"></i>Inquiry Tracking
            </span>
        </div>
        <h1 class="display-5 fw-bold mb-3">Track Your Inquiry</h1>
        <p class="lead mb-4" style="opacity: 0.85; max-width: 520px; margin: 0 auto;">
            Enter your inquiry reference number or email to check the status
        </p>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0" style="background: none;">
                <li class="breadcrumb-item">
                    <a href="{{ route('frontend.home') }}" class="text-white" style="opacity: 0.75; text-decoration: none;">
                        <i class="fas fa-home me-1"></i>Home
                    </a>
                </li>
                <li class="breadcrumb-item active text-white">Track Inquiry</li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-5" style="background: #f8fdf8;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-7 col-lg-6">

                @if(session('success'))
                <div class="alert border-0 mb-4 d-flex align-items-center" style="background:#e8f5e9; border-left:5px solid #2E7D32 !important; border-radius:10px;">
                    <i class="fas fa-check-circle me-3" style="color:#2E7D32; font-size:1.2rem;"></i>
                    <div style="color:#1B4332;">{{ session('success') }}</div>
                </div>
                @endif

                @if(session('error'))
                <div class="alert border-0 mb-4 d-flex align-items-center" style="background:#fce4e4; border-left:5px solid #c62828 !important; border-radius:10px;">
                    <i class="fas fa-exclamation-circle me-3" style="color:#c62828; font-size:1.2rem;"></i>
                    <div style="color:#b71c1c;">{{ session('error') }}</div>
                </div>
                @endif

                <div class="card border-0 shadow-sm" style="border-radius:20px; overflow:hidden;">
                    <div class="card-header border-0 py-4 px-5" style="background: linear-gradient(135deg, #2E7D32, #1B4332);">
                        <h5 class="text-white fw-bold mb-0">
                            <i class="fas fa-search me-2"></i>Check Inquiry Status
                        </h5>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('frontend.inquiry.track.result') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="form-label fw-semibold" style="color:#1B4332;">
                                    Email Address <span style="color:#c62828;">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text border-end-0" style="background:#f1f8e9; border-color:#c8e6c9; color:#2E7D32;">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email" name="email" class="form-control border-start-0 @error('email') is-invalid @enderror"
                                           value="{{ old('email') }}"
                                           placeholder="Enter your email address"
                                           required
                                           style="border-color:#c8e6c9;">
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <button type="submit" class="btn w-100 py-3 text-white fw-semibold"
                                    style="background: linear-gradient(135deg, #2E7D32, #1B4332); border:none; border-radius:10px;">
                                <i class="fas fa-search me-2"></i>Track My Inquiry
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Result --}}
                @if(isset($inquiries) && $inquiries->count() > 0)
                <div class="mt-4">
                    <h5 class="fw-bold mb-3" style="color:#1B4332;">Your Inquiries ({{ $inquiries->count() }})</h5>
                    @foreach($inquiries as $inquiry)
                    <div class="card border-0 shadow-sm mb-3" style="border-radius:12px; border-left:4px solid #2E7D32 !important;">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="fw-bold mb-0" style="color:#1B4332;">{{ $inquiry->subject }}</h6>
                                <span class="badge"
                                    style="background: {{ $inquiry->status === 'resolved' ? '#e8f5e9' : ($inquiry->status === 'in_progress' ? '#fff8e1' : '#fce4e4') }};
                                           color: {{ $inquiry->status === 'resolved' ? '#2E7D32' : ($inquiry->status === 'in_progress' ? '#FFA000' : '#c62828') }};
                                           font-size:0.75rem; text-transform:capitalize; border-radius:6px; padding:4px 10px;">
                                    {{ str_replace('_', ' ', $inquiry->status) }}
                                </span>
                            </div>
                            <p class="text-muted small mb-2">{{ Str::limit($inquiry->message, 100) }}</p>
                            <small style="color:#888;"><i class="fas fa-clock me-1" style="color:#66BB6A;"></i>{{ $inquiry->created_at->format('d M Y, h:i A') }}</small>
                        </div>
                    </div>
                    @endforeach
                </div>
                @elseif(isset($inquiries))
                <div class="text-center mt-4 p-4 rounded-3" style="background:#fff; border:2px dashed #c8e6c9;">
                    <i class="fas fa-inbox fa-3x mb-3" style="color:#c8e6c9;"></i>
                    <h6 class="fw-bold" style="color:#1B4332;">No Inquiries Found</h6>
                    <p class="text-muted small mb-0">No inquiries found for this email address.</p>
                </div>
                @endif

                <div class="text-center mt-4">
                    <p class="text-muted small">
                        Don't have an inquiry?
                        <a href="{{ route('frontend.contact') }}" style="color:#2E7D32;" class="fw-semibold text-decoration-none">
                            Contact Us
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.form-control:focus { border-color:#66BB6A !important; box-shadow:0 0 0 0.2rem rgba(46,125,50,.2) !important; }
.input-group:focus-within .input-group-text { border-color:#66BB6A !important; background:#e8f5e9 !important; }
</style>
@endpush
