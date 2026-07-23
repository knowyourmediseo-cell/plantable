<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@19.5.7/build/css/intlTelInput.css">
    <style>
        body { background: #f0faf0; font-family: 'Inter', sans-serif; }
        .brand-card { border-top: 4px solid #2E7D32; border-radius: 12px; }
        .brand-btn { background: #2E7D32 !important; border-color: #2E7D32 !important; color: #fff !important; }
        .brand-btn:hover { background: #1B5E20 !important; border-color: #1B5E20 !important; }
        .brand-link { color: #2E7D32 !important; }
        .brand-link:hover { color: #1B5E20 !important; }
        .form-control:focus { border-color: #2E7D32; box-shadow: 0 0 0 0.2rem rgba(46,125,50,.2); }
        .brand-logo { color: #2E7D32; font-size: 1.5rem; font-weight: 700; text-decoration: none; }
        /* Phone input */
        .iti { display: block !important; width: 100% !important; }
        .iti__selected-country { display: flex !important; align-items: center !important; height: 100% !important; padding: 0 10px !important; background: #fff !important; border: none !important; border-right: 1px solid #dee2e6 !important; cursor: pointer !important; outline: none !important; gap: 6px !important; }
        .iti__selected-country:hover { background: #f8f9fa !important; }
        .iti__selected-dial-code { color: #1B4332 !important; font-weight: 500 !important; font-size: 14px !important; }
        .iti__arrow { border-top: 5px solid #2E7D32 !important; border-left: 4px solid transparent !important; border-right: 4px solid transparent !important; }
        .iti__arrow--up { border-top: none !important; border-bottom: 5px solid #2E7D32 !important; }
        .iti input[type="tel"] { padding-left: 90px !important; width: 100% !important; }
        .iti__dropdown-content { z-index: 999999 !important; background: white !important; border: 2px solid #c8e6c9 !important; border-radius: 10px !important; box-shadow: 0 8px 32px rgba(46,125,50,.18) !important; width: 360px !important; overflow: hidden !important; }
        .iti__search-input { width: 100% !important; padding: 12px 16px !important; border: none !important; border-bottom: 2px solid #e8f5e9 !important; font-size: 14px !important; outline: none !important; background: #f8fdf8 !important; box-sizing: border-box !important; }
        .iti__search-input:focus { border-bottom-color: #2E7D32 !important; background: #fff !important; }
        .iti__country-list { max-height: 250px !important; overflow-y: auto !important; list-style: none !important; padding: 4px 0 !important; margin: 0 !important; }
        .iti__country { display: flex !important; align-items: center !important; padding: 10px 16px !important; cursor: pointer !important; }
        .iti__country.iti__highlight, .iti__country:hover { background: #e8f5e9 !important; }
        .iti__country-name { margin-left: 10px !important; flex: 1 !important; color: #1B4332 !important; font-size: 14px !important; }
        .iti__dial-code { color: #2E7D32 !important; font-weight: 600 !important; font-size: 13px !important; margin-left: 8px !important; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-5 col-sm-8 col-11 py-5">
                <div class="text-center mb-4">
                    <a href="{{ route('frontend.home') }}" class="brand-logo d-inline-flex align-items-center gap-2">
                        <i class="fas fa-leaf"></i>
                        <span>{{ config('app.name') }}</span>
                    </a>
                </div>
                <div class="card shadow brand-card border-0">
                    <div class="card-body p-5">
                        <h3 class="text-center mb-1 fw-bold" style="color:#1B4332;">Create Account</h3>
                        <p class="text-center text-muted small mb-4">Join the eco-friendly movement</p>
                        @if($errors->any())
                            <div class="alert alert-danger py-2">
                                <ul class="mb-0 small">
                                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Full Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="fas fa-user" style="color:#2E7D32;"></i></span>
                                    <input type="text" name="name" class="form-control" required value="{{ old('name') }}" placeholder="John Doe">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="fas fa-envelope" style="color:#2E7D32;"></i></span>
                                    <input type="email" name="email" class="form-control" required value="{{ old('email') }}" placeholder="your@email.com">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Phone <span class="text-muted fw-normal">(Optional)</span></label>
                                <input type="tel" id="phone" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="98765 43210">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="fas fa-lock" style="color:#2E7D32;"></i></span>
                                    <input type="password" name="password" class="form-control" required placeholder="Min. 8 characters">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Confirm Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="fas fa-lock" style="color:#2E7D32;"></i></span>
                                    <input type="password" name="password_confirmation" class="form-control" required placeholder="Repeat password">
                                </div>
                            </div>
                            <button type="submit" class="btn brand-btn w-100 py-2 fw-bold">
                                <i class="fas fa-user-plus me-2"></i>Create Account
                            </button>
                        </form>
                        <hr class="my-4">
                        <p class="text-center mb-0 small">
                            Already have an account? <a href="{{ route('login') }}" class="brand-link fw-semibold">Login here</a>
                        </p>
                        <p class="text-center mt-2 mb-0 small">
                            <a href="{{ route('frontend.home') }}" class="text-muted"><i class="fas fa-arrow-left me-1"></i>Back to Website</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@19.5.7/build/js/intlTelInput.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var el = document.querySelector('#phone');
        if (el && typeof intlTelInput !== 'undefined') {
            intlTelInput(el, {
                initialCountry: 'in',
                preferredCountries: ['in', 'us', 'gb', 'ae', 'ca', 'au'],
                separateDialCode: true,
                countrySearch: true,
                formatOnDisplay: true,
                loadUtils: 'https://cdn.jsdelivr.net/npm/intl-tel-input@19.5.7/build/js/utils.js'
            });
        }
    });
    </script>
</body>
</html>
