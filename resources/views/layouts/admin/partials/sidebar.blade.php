<aside class="sidebar" style="width: 260px; min-height: 100vh; position: fixed; top: 0; left: 0; bottom: 0; overflow-y: auto; z-index: 1000;">
    <div class="p-4">
        <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center text-white text-decoration-none mb-4">
            <i class="fas fa-leaf fs-4 me-2"></i>
            <span class="fs-5 fw-bold">Admin Panel</span>
        </a>

        <nav class="nav flex-column">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home me-2"></i> Dashboard
            </a>

            <div class="mt-3">
                <small class="text-white-50 text-uppercase px-3">Products</small>
            </div>
            <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="fas fa-folder me-2"></i> Categories
            </a>
            <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <i class="fas fa-box me-2"></i> Products
            </a>

            <div class="mt-3">
                <small class="text-white-50 text-uppercase px-3">Content</small>
            </div>
            <a href="{{ route('admin.pages.index') }}" class="nav-link {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
                <i class="fas fa-file-alt me-2"></i> Pages
            </a>
            <a href="{{ route('admin.blogs.index') }}" class="nav-link {{ request()->routeIs('admin.blogs.*') ? 'active' : '' }}">
                <i class="fas fa-blog me-2"></i> Blogs
            </a>
            <a href="{{ route('admin.sliders.index') }}" class="nav-link {{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}">
                <i class="fas fa-images me-2"></i> Sliders
            </a>
            <a href="{{ route('admin.banners.index') }}" class="nav-link {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">
                <i class="fas fa-ad me-2"></i> Banners
            </a>
            <a href="{{ route('admin.menus.index') }}" class="nav-link {{ request()->routeIs('admin.menus.*') ? 'active' : '' }}">
                <i class="fas fa-bars me-2"></i> Menus
            </a>

            <div class="mt-3">
                <small class="text-white-50 text-uppercase px-3">Media</small>
            </div>
            <a href="{{ route('admin.gallery.index') }}" class="nav-link {{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}">
                <i class="fas fa-photo-video me-2"></i> Gallery
            </a>
            <a href="{{ route('admin.videos.index') }}" class="nav-link {{ request()->routeIs('admin.videos.*') ? 'active' : '' }}">
                <i class="fas fa-video me-2"></i> Videos
            </a>

            <div class="mt-3">
                <small class="text-white-50 text-uppercase px-3">Engagement</small>
            </div>
            <a href="{{ route('admin.testimonials.index') }}" class="nav-link {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
                <i class="fas fa-quote-right me-2"></i> Testimonials
            </a>
            <a href="{{ route('admin.clients.index') }}" class="nav-link {{ request()->routeIs('admin.clients.*') ? 'active' : '' }}">
                <i class="fas fa-handshake me-2"></i> Clients
            </a>
            <a href="{{ route('admin.faqs.index') }}" class="nav-link {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}">
                <i class="fas fa-question-circle me-2"></i> FAQs
            </a>
            <a href="{{ route('admin.reviews.index') }}" class="nav-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                <i class="fas fa-star me-2"></i> Reviews
            </a>

            <div class="mt-3">
                <small class="text-white-50 text-uppercase px-3">E-commerce</small>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <i class="fas fa-shopping-cart me-2"></i> Orders
            </a>
            <a href="{{ route('admin.coupons.index') }}" class="nav-link {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">
                <i class="fas fa-tag me-2"></i> Coupons
            </a>

            <div class="mt-3">
                <small class="text-white-50 text-uppercase px-3">Communication</small>
            </div>
            <a href="{{ route('admin.inquiries.index') }}" class="nav-link {{ request()->routeIs('admin.inquiries.*') ? 'active' : '' }}">
                <i class="fas fa-envelope me-2"></i> Inquiries
            </a>
            <a href="{{ route('admin.newsletter.index') }}" class="nav-link {{ request()->routeIs('admin.newsletter.*') ? 'active' : '' }}">
                <i class="fas fa-paper-plane me-2"></i> Newsletter
            </a>
            <a href="{{ route('admin.email-templates.index') }}" class="nav-link {{ request()->routeIs('admin.email-templates.*') ? 'active' : '' }}">
                <i class="fas fa-envelope-open-text me-2"></i> Email Templates
            </a>

            <div class="mt-3">
                <small class="text-white-50 text-uppercase px-3">Users</small>
            </div>
            <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="fas fa-users me-2"></i> Users
            </a>

            <div class="mt-3">
                <small class="text-white-50 text-uppercase px-3">Settings</small>
            </div>
            <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <i class="fas fa-cog me-2"></i> Settings
            </a>
            <a href="{{ route('admin.redirects.index') }}" class="nav-link {{ request()->routeIs('admin.redirects.*') ? 'active' : '' }}">
                <i class="fas fa-exchange-alt me-2"></i> Redirects
            </a>
        </nav>
    </div>
</aside>
