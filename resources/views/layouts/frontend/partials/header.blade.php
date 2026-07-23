<header class="bg-white shadow-sm sticky top-0 z-40 transition-all duration-300" style="background-color: #ffffff !important;">
    <!-- Top Bar -->
    <div class="text-white py-2" style="background-color: #2E7D32;">
        <div class="container-custom">
            <div class="flex flex-wrap items-center justify-between text-sm">
                <div class="flex items-center space-x-4">
                    <a href="mailto:info@example.com" class="text-white transition" style="text-decoration: none; opacity: 0.9;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.9'">
                        <i class="fas fa-envelope mr-1"></i> info@example.com
                    </a>
                    <a href="tel:+1234567890" class="text-white transition" style="text-decoration: none; opacity: 0.9;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.9'">
                        <i class="fas fa-phone mr-1"></i> +1 234 567 890
                    </a>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="#" class="text-white transition" style="opacity: 0.9;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.9'"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-white transition" style="opacity: 0.9;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.9'"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-white transition" style="opacity: 0.9;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.9'"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-white transition" style="opacity: 0.9;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.9'"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <div class="container-custom py-4" style="background-color: #ffffff;">
        <div class="flex items-center justify-between">
            <!-- Logo -->
            <a href="{{ route('frontend.home') }}" class="flex items-center space-x-2">
                <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}" class="h-12">
            </a>

            <!-- Desktop Navigation -->
            <nav class="hidden lg:flex items-center space-x-8">
                @php
                    $headerMenu = \App\Models\Menu::where('location', 'header')->where('status', true)->first();
                    $menuItems = $headerMenu ? $headerMenu->items()->where('status', true)->orderBy('sort_order')->get() : collect();
                @endphp
                @foreach($menuItems as $item)
                    <a href="{{ $item->url }}" class="font-medium transition" style="color: #374151; text-decoration: none;" onmouseover="this.style.color='#2E7D32'" onmouseout="this.style.color='#374151'" @if($item->target == '_blank') target="_blank" @endif>
                        @if($item->icon)<i class="{{ $item->icon }} mr-1"></i>@endif
                        {{ $item->title }}
                    </a>
                @endforeach
            </nav>

            <!-- Right Section -->
            <div class="flex items-center space-x-4">
                <button class="transition" style="color: #374151; background: none; border: none;" onmouseover="this.style.color='#2E7D32'" onmouseout="this.style.color='#374151'">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>

                <a href="{{ route('frontend.cart.index') }}" class="transition relative" style="color: #374151; text-decoration: none;" onmouseover="this.style.color='#2E7D32'" onmouseout="this.style.color='#374151'">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    @php
                        $cart = \App\Models\Cart::getCurrentCart();
                        $cartCount = $cart->total_items ?? 0;
                    @endphp
                    <span class="cart-count absolute -top-2 -right-2 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center" style="background-color: #2E7D32; font-size: 11px;">{{ $cartCount }}</span>
                </a>

                <!-- User Account Dropdown -->
                @auth
                <div class="relative" style="display: inline-block;">
                    <button id="userDropdownBtn" class="transition flex items-center space-x-2" style="color: #374151; background: none; border: none; cursor: pointer;" onmouseover="this.style.color='#2E7D32'" onmouseout="this.style.color='#374151'">
                        <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #2E7D32, #66BB6A); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 14px;">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div id="userDropdown" style="display: none; position: absolute; right: 0; top: 100%; margin-top: 8px; background: white; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); min-width: 200px; z-index: 1000; border: 1px solid #e5e7eb;">
                        <div style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb;">
                            <div style="font-weight: 600; color: #1B4332; font-size: 14px;">{{ Auth::user()->name }}</div>
                            <div style="font-size: 12px; color: #6b7280;">{{ Auth::user()->email }}</div>
                        </div>
                        <a href="{{ route('frontend.dashboard') }}" style="display: flex; align-items: center; padding: 10px 16px; color: #374151; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='#f3f4f6'; this.style.color='#2E7D32'" onmouseout="this.style.background='transparent'; this.style.color='#374151'">
                            <i class="fas fa-tachometer-alt" style="width: 20px; margin-right: 10px;"></i>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('frontend.dashboard.orders') }}" style="display: flex; align-items: center; padding: 10px 16px; color: #374151; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='#f3f4f6'; this.style.color='#2E7D32'" onmouseout="this.style.background='transparent'; this.style.color='#374151'">
                            <i class="fas fa-shopping-bag" style="width: 20px; margin-right: 10px;"></i>
                            <span>My Orders</span>
                        </a>
                        <a href="{{ route('frontend.dashboard.profile') }}" style="display: flex; align-items: center; padding: 10px 16px; color: #374151; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='#f3f4f6'; this.style.color='#2E7D32'" onmouseout="this.style.background='transparent'; this.style.color='#374151'">
                            <i class="fas fa-user" style="width: 20px; margin-right: 10px;"></i>
                            <span>Profile</span>
                        </a>
                        <div style="border-top: 1px solid #e5e7eb; margin: 4px 0;"></div>
                        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" style="display: flex; align-items: center; width: 100%; padding: 10px 16px; color: #dc2626; text-decoration: none; background: none; border: none; cursor: pointer; transition: all 0.2s; text-align: left;" onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background='transparent'">
                                <i class="fas fa-sign-out-alt" style="width: 20px; margin-right: 10px;"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
                @else
                <a href="{{ route('login') }}" class="transition flex items-center space-x-1" style="color: #374151; text-decoration: none;" onmouseover="this.style.color='#2E7D32'" onmouseout="this.style.color='#374151'">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </a>
                @endauth

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" class="lg:hidden transition" style="color: #374151; background: none; border: none;" onmouseover="this.style.color='#2E7D32'" onmouseout="this.style.color='#374151'">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden lg:hidden" style="border-top: 1px solid #e5e7eb; background-color: #ffffff;">
        <div class="container-custom py-4">
            <nav class="flex flex-col space-y-4">
                @foreach($menuItems as $item)
                    <a href="{{ $item->url }}" class="font-medium transition" style="color: #374151; text-decoration: none;" onmouseover="this.style.color='#2E7D32'" onmouseout="this.style.color='#374151'" @if($item->target == '_blank') target="_blank" @endif>
                        @if($item->icon)<i class="{{ $item->icon }} mr-1"></i>@endif
                        {{ $item->title }}
                    </a>
                @endforeach
            </nav>
        </div>
    </div>

    <script>
    // Mobile menu toggle
    document.getElementById('mobile-menu-btn').addEventListener('click', function() {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    });

    // User dropdown toggle
    @auth
    const userDropdownBtn = document.getElementById('userDropdownBtn');
    const userDropdown = document.getElementById('userDropdown');
    
    if (userDropdownBtn && userDropdown) {
        userDropdownBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            userDropdown.style.display = userDropdown.style.display === 'none' ? 'block' : 'none';
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!userDropdownBtn.contains(e.target) && !userDropdown.contains(e.target)) {
                userDropdown.style.display = 'none';
            }
        });
    }
    @endauth
    </script>
</header>
