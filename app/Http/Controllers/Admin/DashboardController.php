<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\Inquiry;
use App\Models\User;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Only active (pen & pencil) categories and products
        $activeCategories = Category::where('status', true)->withCount(['products' => function ($q) {
            $q->where('status', true);
        }])->get();

        $activeProducts = Product::where('status', true)->with('category')->latest()->get();

        $stats = [
            'active_categories' => $activeCategories->count(),
            'active_products'   => $activeProducts->count(),
            'total_orders'      => Order::count(),
            'pending_orders'    => Order::where('status', 'pending')->count(),
            'total_revenue'     => Order::where('payment_status', 'paid')->sum('total'),
            'monthly_revenue'   => Order::where('payment_status', 'paid')
                                        ->whereMonth('created_at', Carbon::now()->month)
                                        ->sum('total'),
            'total_customers'   => User::where('user_type', 'customer')->count(),
            'pending_inquiries' => Inquiry::where('status', 'pending')->count(),
            'newsletter_subscribers' => NewsletterSubscriber::where('status', 'subscribed')->count(),
        ];

        $recentOrders = Order::with('user')->latest()->take(10)->get();

        $recentInquiries = Inquiry::with('product')->latest()->take(8)->get();

        // Top products by views (active only)
        $topProducts = Product::where('status', true)
            ->withCount('reviews')
            ->orderBy('views', 'desc')
            ->take(10)
            ->get();

        $monthlySales = Order::where('payment_status', 'paid')
            ->whereYear('created_at', Carbon::now()->year)
            ->selectRaw('MONTH(created_at) as month, SUM(total) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.pages.dashboard', compact(
            'stats',
            'activeCategories',
            'activeProducts',
            'recentOrders',
            'recentInquiries',
            'topProducts',
            'monthlySales'
        ));
    }
}
