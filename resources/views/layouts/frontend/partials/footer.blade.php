<footer style="background-color: #1B4332;" class="text-white">
    <!-- Main Footer -->
    <div class="container-custom section-padding">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- About Section -->
            <div>
                <h3 class="text-xl font-bold mb-4">About Us</h3>
                <p class="mb-4" style="color: #a7c4b5;">
                    We offer eco-friendly plantable products that promote sustainability and green living.
                </p>
                <div class="flex space-x-3">
                    <a href="#" class="w-10 h-10 rounded-full flex items-center justify-center transition" style="background: rgba(255,255,255,0.1);" onmouseover="this.style.background='#2E7D32'" onmouseout="this.style.background='rgba(255,255,255,0.1)'">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full flex items-center justify-center transition" style="background: rgba(255,255,255,0.1);" onmouseover="this.style.background='#2E7D32'" onmouseout="this.style.background='rgba(255,255,255,0.1)'">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full flex items-center justify-center transition" style="background: rgba(255,255,255,0.1);" onmouseover="this.style.background='#2E7D32'" onmouseout="this.style.background='rgba(255,255,255,0.1)'">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full flex items-center justify-center transition" style="background: rgba(255,255,255,0.1);" onmouseover="this.style.background='#2E7D32'" onmouseout="this.style.background='rgba(255,255,255,0.1)'">
                        <i class="fab fa-linkedin"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-xl font-bold mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    <li><a href="/about-us" class="footer-link transition">About Us</a></li>
                    <li><a href="{{ route('frontend.products.index') }}" class="footer-link transition">All Products</a></li>
                    <li><a href="{{ route('frontend.categories.show', 'plantable-pens') }}" class="footer-link transition">Plantable Pens</a></li>
                    <li><a href="{{ route('frontend.categories.show', 'plantable-pencils') }}" class="footer-link transition">Plantable Pencils</a></li>
                    <li><a href="{{ route('frontend.blogs.index') }}" class="footer-link transition">Blog</a></li>
                    <li><a href="{{ route('frontend.contact') }}" class="footer-link transition">Contact Us</a></li>
                </ul>
            </div>

            <!-- Customer Service -->
            <div>
                <h3 class="text-xl font-bold mb-4">Customer Service</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('frontend.faq') }}" class="footer-link transition">FAQ</a></li>
                    <li><a href="{{ route('frontend.inquiry.track') }}" class="footer-link transition">Track Inquiry</a></li>
                    <li><a href="#" class="footer-link transition">Shipping Policy</a></li>
                    <li><a href="#" class="footer-link transition">Return Policy</a></li>
                    <li><a href="#" class="footer-link transition">Privacy Policy</a></li>
                    <li><a href="#" class="footer-link transition">Terms & Conditions</a></li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div>
                <h3 class="text-xl font-bold mb-4">Newsletter</h3>
                <p class="mb-4" style="color: #a7c4b5;">Subscribe to get updates on new products and special offers.</p>
                <form id="newsletter-form" action="{{ route('frontend.newsletter.subscribe') }}" method="POST" class="space-y-3">
                    @csrf
                    <input type="email" name="email" placeholder="Your email address" class="w-full px-4 py-3 rounded-lg text-white placeholder-gray-400 focus:outline-none" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                    <button type="submit" class="w-full px-6 py-3 rounded-lg font-medium transition-all text-white" style="background-color: #2E7D32;" onmouseover="this.style.backgroundColor='#388E3C'" onmouseout="this.style.backgroundColor='#2E7D32'">
                        Subscribe
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bottom Footer -->
    <div style="border-top: 1px solid rgba(255,255,255,0.1);">
        <div class="container-custom py-6">
            <div class="flex flex-col md:flex-row items-center justify-between text-sm" style="color: #a7c4b5;">
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                <div class="flex items-center space-x-4 mt-4 md:mt-0">
                    <span>Payment Methods</span>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
.footer-link {
    color: #d4e8d4;
    text-decoration: none;
}
.footer-link:hover {
    color: #8BC34A;
    text-decoration: none;
}
</style>
