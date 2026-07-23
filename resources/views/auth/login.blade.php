<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f0faf0; font-family: 'Inter', sans-serif; }
        .brand-card { border-top: 4px solid #2E7D32; border-radius: 12px; }
        .brand-btn { background: #2E7D32 !important; border-color: #2E7D32 !important; color: #fff !important; }
        .brand-btn:hover { background: #1B5E20 !important; border-color: #1B5E20 !important; }
        .brand-link { color: #2E7D32 !important; }
        .brand-link:hover { color: #1B5E20 !important; }
        .form-control:focus { border-color: #2E7D32; box-shadow: 0 0 0 0.2rem rgba(46,125,50,.2); }
        .brand-logo { color: #2E7D32; font-size: 1.5rem; font-weight: 700; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-5 col-sm-8 col-11">

                <!-- Brand -->
                <div class="text-center mb-4">
                    <a href="{{ route('frontend.home') }}" class="brand-logo d-inline-flex align-items-center gap-2">
                        <i class="fas fa-leaf"></i>
                        <span>{{ config('app.name') }}</span>
                    </a>
                </div>

                <div class="card shadow brand-card border-0">
                    <div class="card-body p-5">
                        <h3 class="text-center mb-1 fw-bold" style="color:#1B4332;">Welcome Back</h3>
                        <p class="text-center text-muted small mb-4">Sign in to your account</p>

                        @if($errors->any())
                            <div class="alert alert-danger py-2"><i class="fas fa-exclamation-circle me-1"></i>{{ $errors->first() }}</div>
                        @endif
                        @if(session('status'))
                            <div class="alert alert-success py-2">{{ session('status') }}</div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="fas fa-envelope" style="color:#2E7D32;"></i></span>
                                    <input type="email" name="email" class="form-control" required autofocus value="{{ old('email') }}" placeholder="your@email.com">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="fas fa-lock" style="color:#2E7D32;"></i></span>
                                    <input type="password" name="password" class="form-control" required placeholder="••••••••">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input type="checkbox" name="remember" class="form-check-input" id="remember">
                                    <label class="form-check-label small" for="remember">Remember me</label>
                                </div>
                                <a href="{{ route('password.request') }}" class="brand-link small">Forgot password?</a>
                            </div>
                            <button type="submit" class="btn brand-btn w-100 py-2 fw-bold">
                                <i class="fas fa-sign-in-alt me-2"></i>Login
                            </button>
                        </form>

                        <hr class="my-4">
                        <p class="text-center mb-0 small">
                            Don't have an account?
                            <a href="{{ route('register') }}" class="brand-link fw-semibold">Create one</a>
                        </p>
                        <p class="text-center mt-2 mb-0 small">
                            <a href="{{ route('frontend.home') }}" class="text-muted">
                                <i class="fas fa-arrow-left me-1"></i>Back to Website
                            </a>
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
</html>
