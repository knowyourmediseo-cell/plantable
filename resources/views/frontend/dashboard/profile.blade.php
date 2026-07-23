@extends('layouts.frontend.app')
@section('title', 'My Profile')

@section('content')
<section class="py-5" style="background: #f8fdf8; min-height: 80vh;">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 mb-4">
                @include('frontend.dashboard.sidebar')
            </div>

            <div class="col-lg-9">
                <div class="mb-4">
                    <h2 class="fw-bold" style="color: #1B4332;">
                        <i class="fas fa-user me-2" style="color: #2E7D32;"></i>My Profile
                    </h2>
                </div>

                @if(session('success'))
                <div class="alert border-0 d-flex align-items-center mb-4" style="background: #e8f5e9; border-left: 5px solid #2E7D32 !important;">
                    <i class="fas fa-check-circle me-3 fa-lg" style="color: #2E7D32;"></i>
                    <div style="color: #1B4332; font-weight: 500;">{{ session('success') }}</div>
                </div>
                @endif

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <form action="{{ route('frontend.dashboard.profile.update') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold" style="color: #1B4332;">Full Name *</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                           value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold" style="color: #1B4332;">Email</label>
                                    <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                                    <small class="text-muted">Email cannot be changed</small>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold" style="color: #1B4332;">Phone Number</label>
                                    <input type="tel" id="profile-phone" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                           value="{{ old('phone', $user->phone) }}" placeholder="98765 43210">
                                    @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn text-white px-4" style="background: #2E7D32;">
                                        <i class="fas fa-save me-2"></i>Update Profile
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
