<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\CategoryController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\InquiryController;
use App\Http\Controllers\Frontend\NewsletterController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\InquiryController as AdminInquiryController;
use App\Http\Controllers\Admin\NewsletterController as AdminNewsletterController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\EmailTemplateController;
use App\Http\Controllers\Admin\RedirectController;
use App\Http\Controllers\Admin\LocationController;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/

Route::name('frontend.')->group(function () {
    // Home
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Products - Must come before dynamic pages
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/product/{slug}', [ProductController::class, 'show'])->name('products.show');

    // Categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('categories.show');

    // Blogs
    Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
    Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blogs.show');

    // Pages
    Route::get('/gallery', [PageController::class, 'gallery'])->name('gallery');
    Route::get('/videos', [PageController::class, 'videos'])->name('videos');
    Route::get('/testimonials', [PageController::class, 'testimonials'])->name('testimonials');
    Route::get('/faq', [PageController::class, 'faq'])->name('faq');
    Route::get('/contact-us', [PageController::class, 'contact'])->name('contact');
    Route::get('/sitemap', [PageController::class, 'sitemap'])->name('sitemap');

    // Contact & Inquiry
    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
    
    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{item}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');

    // Checkout (auth required)
    Route::middleware('auth')->group(function () {
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
        Route::get('/checkout/success/{orderNumber}', [CheckoutController::class, 'success'])->name('checkout.success');
        
        // Customer Dashboard
        Route::get('/dashboard', [\App\Http\Controllers\Frontend\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/orders', [\App\Http\Controllers\Frontend\DashboardController::class, 'orders'])->name('dashboard.orders');
        Route::get('/dashboard/orders/{orderNumber}', [\App\Http\Controllers\Frontend\DashboardController::class, 'orderDetails'])->name('dashboard.order.details');
        Route::get('/dashboard/profile', [\App\Http\Controllers\Frontend\DashboardController::class, 'profile'])->name('dashboard.profile');
        Route::post('/dashboard/profile', [\App\Http\Controllers\Frontend\DashboardController::class, 'updateProfile'])->name('dashboard.profile.update');
    });

    // Inquiry & Newsletter (POST routes before dynamic slug)
    Route::post('/inquiry', [InquiryController::class, 'store'])->name('inquiry.store');
    Route::get('/track-inquiry', [InquiryController::class, 'track'])->name('inquiry.track');
    Route::post('/track-inquiry', [InquiryController::class, 'trackResult'])->name('inquiry.track.result');
    Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
    Route::get('/newsletter/unsubscribe/{token}', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');

    // Dynamic Pages - MUST BE LAST — excludes auth & reserved slugs
    Route::get('/{slug}', [PageController::class, 'show'])
        ->name('pages.show')
        ->where('slug', '^(?!login|register|logout|password|admin|api|checkout).*$');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Categories
    Route::resource('categories', AdminCategoryController::class);
    Route::post('categories/bulk-delete', [AdminCategoryController::class, 'bulkDelete'])->name('categories.bulk-delete');
    Route::post('categories/bulk-status', [AdminCategoryController::class, 'bulkStatus'])->name('categories.bulk-status');

    // Products
    Route::resource('products', AdminProductController::class);
    Route::post('products/bulk-delete', [AdminProductController::class, 'bulkDelete'])->name('products.bulk-delete');
    Route::post('products/bulk-status', [AdminProductController::class, 'bulkStatus'])->name('products.bulk-status');
    Route::post('products/{product}/images', [AdminProductController::class, 'uploadImages'])->name('products.images.upload');
    Route::delete('products/{product}/images/{image}', [AdminProductController::class, 'deleteImage'])->name('products.images.delete');
    Route::post('products/{product}/videos', [AdminProductController::class, 'uploadVideos'])->name('products.videos.upload');
    Route::delete('products/{product}/videos/{video}', [AdminProductController::class, 'deleteVideo'])->name('products.videos.delete');
    Route::post('products/{product}/downloads', [AdminProductController::class, 'uploadDownloads'])->name('products.downloads.upload');
    Route::delete('products/{product}/downloads/{download}', [AdminProductController::class, 'deleteDownload'])->name('products.downloads.delete');

    // Sliders
    Route::resource('sliders', SliderController::class);
    Route::post('sliders/bulk-delete', [SliderController::class, 'bulkDelete'])->name('sliders.bulk-delete');

    // Pages
    Route::resource('pages', AdminPageController::class);
    Route::post('pages/bulk-delete', [AdminPageController::class, 'bulkDelete'])->name('pages.bulk-delete');

    // Menus
    Route::resource('menus', MenuController::class);
    Route::post('menus/{menu}/items', [MenuController::class, 'storeItem'])->name('menus.items.store');
    Route::put('menus/{menu}/items/{item}', [MenuController::class, 'updateItem'])->name('menus.items.update');
    Route::delete('menus/{menu}/items/{item}', [MenuController::class, 'destroyItem'])->name('menus.items.destroy');
    Route::post('menus/{menu}/items/sort', [MenuController::class, 'sortItems'])->name('menus.items.sort');

    // Blogs
    Route::resource('blogs', AdminBlogController::class);
    Route::post('blogs/bulk-delete', [AdminBlogController::class, 'bulkDelete'])->name('blogs.bulk-delete');
    Route::resource('blog-categories', AdminBlogController::class);

    // Testimonials
    Route::resource('testimonials', TestimonialController::class);
    Route::post('testimonials/bulk-delete', [TestimonialController::class, 'bulkDelete'])->name('testimonials.bulk-delete');

    // Clients
    Route::resource('clients', ClientController::class);
    Route::post('clients/bulk-delete', [ClientController::class, 'bulkDelete'])->name('clients.bulk-delete');

    // FAQs
    Route::resource('faqs', FaqController::class);
    Route::post('faqs/bulk-delete', [FaqController::class, 'bulkDelete'])->name('faqs.bulk-delete');

    // Inquiries
    Route::resource('inquiries', AdminInquiryController::class);
    Route::post('inquiries/{inquiry}/notes', [AdminInquiryController::class, 'addNote'])->name('inquiries.notes.store');
    Route::post('inquiries/{inquiry}/status', [AdminInquiryController::class, 'updateStatus'])->name('inquiries.status.update');
    Route::post('inquiries/bulk-delete', [AdminInquiryController::class, 'bulkDelete'])->name('inquiries.bulk-delete');

    // Newsletter
    Route::get('newsletter', [AdminNewsletterController::class, 'index'])->name('newsletter.index');
    Route::delete('newsletter/{subscriber}', [AdminNewsletterController::class, 'destroy'])->name('newsletter.destroy');
    Route::post('newsletter/export', [AdminNewsletterController::class, 'export'])->name('newsletter.export');
    Route::post('newsletter/bulk-delete', [AdminNewsletterController::class, 'bulkDelete'])->name('newsletter.bulk-delete');

    // Gallery
    Route::resource('gallery', GalleryController::class);
    Route::post('gallery/bulk-delete', [GalleryController::class, 'bulkDelete'])->name('gallery.bulk-delete');

    // Videos
    Route::resource('videos', VideoController::class);
    Route::post('videos/bulk-delete', [VideoController::class, 'bulkDelete'])->name('videos.bulk-delete');

    // Orders
    Route::resource('orders', OrderController::class);
    Route::post('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status.update');
    Route::get('orders/{order}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');

    // Coupons
    Route::resource('coupons', CouponController::class);
    Route::post('coupons/bulk-delete', [CouponController::class, 'bulkDelete'])->name('coupons.bulk-delete');

    // Reviews
    Route::resource('reviews', ReviewController::class);
    Route::post('reviews/{review}/approve', [ReviewController::class, 'approve'])->name('reviews.approve');
    Route::post('reviews/{review}/reject', [ReviewController::class, 'reject'])->name('reviews.reject');
    Route::post('reviews/bulk-delete', [ReviewController::class, 'bulkDelete'])->name('reviews.bulk-delete');

    // Banners
    Route::resource('banners', BannerController::class);
    Route::post('banners/bulk-delete', [BannerController::class, 'bulkDelete'])->name('banners.bulk-delete');

    // Email Templates
    Route::resource('email-templates', EmailTemplateController::class);

    // Redirects
    Route::resource('redirects', RedirectController::class);
    Route::post('redirects/bulk-delete', [RedirectController::class, 'bulkDelete'])->name('redirects.bulk-delete');

    // Locations
    Route::get('locations/countries', [LocationController::class, 'countries'])->name('locations.countries');
    Route::get('locations/states/{country}', [LocationController::class, 'states'])->name('locations.states');
    Route::get('locations/cities/{state}', [LocationController::class, 'cities'])->name('locations.cities');

    // Users
    Route::resource('users', UserController::class);
    Route::post('users/bulk-delete', [UserController::class, 'bulkDelete'])->name('users.bulk-delete');

    // Settings
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
    Route::get('settings/general', [SettingController::class, 'general'])->name('settings.general');
    Route::get('settings/theme', [SettingController::class, 'theme'])->name('settings.theme');
    Route::get('settings/seo', [SettingController::class, 'seo'])->name('settings.seo');
    Route::get('settings/email', [SettingController::class, 'email'])->name('settings.email');
    Route::get('settings/payment', [SettingController::class, 'payment'])->name('settings.payment');
    Route::get('settings/social', [SettingController::class, 'social'])->name('settings.social');
    Route::get('settings/commerce', [SettingController::class, 'commerce'])->name('settings.commerce');
});

// Auth Routes
require __DIR__.'/auth.php';
