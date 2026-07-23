<div class="card border-0 shadow-sm">
    <div class="card-body p-3">
        <div class="text-center mb-3 pb-3 border-bottom">
            <div class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center text-white fw-bold" 
                 style="width: 70px; height: 70px; background: linear-gradient(135deg, #2E7D32, #66BB6A); font-size: 28px;">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <h6 class="mb-0 fw-bold" style="color: #1B4332;">{{ Auth::user()->name }}</h6>
            <small class="text-muted">{{ Auth::user()->email }}</small>
        </div>
        <nav class="nav flex-column">
            <a href="{{ route('frontend.dashboard') }}" 
               class="nav-link {{ request()->routeIs('frontend.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </a>
            <a href="{{ route('frontend.dashboard.orders') }}" 
               class="nav-link {{ request()->routeIs('frontend.dashboard.orders*') ? 'active' : '' }}">
                <i class="fas fa-shopping-bag me-2"></i> My Orders
            </a>
            <a href="{{ route('frontend.dashboard.profile') }}" 
               class="nav-link {{ request()->routeIs('frontend.dashboard.profile') ? 'active' : '' }}">
                <i class="fas fa-user me-2"></i> Profile
            </a>
            <a href="{{ route('frontend.cart.index') }}" class="nav-link">
                <i class="fas fa-shopping-cart me-2"></i> Cart
            </a>
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="nav-link text-danger border-0 bg-transparent w-100 text-start">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </button>
            </form>
        </nav>
    </div>
</div>

<style>
.nav-link {
    color: #374151;
    padding: 0.7rem 1rem;
    border-radius: 8px;
    margin-bottom: 4px;
    transition: all 0.3s;
}
.nav-link:hover {
    background: rgba(46,125,50,0.1);
    color: #2E7D32;
}
.nav-link.active {
    background: linear-gradient(135deg, #2E7D32, #388E3C);
    color: #fff !important;
}
.nav-link i {
    width: 20px;
}
</style>
