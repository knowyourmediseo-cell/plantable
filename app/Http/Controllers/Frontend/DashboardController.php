<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)
            ->with('items.product')
            ->latest()
            ->paginate(10);

        $stats = [
            'total_orders' => Order::where('user_id', $user->id)->count(),
            'pending_orders' => Order::where('user_id', $user->id)->where('status', 'pending')->count(),
            'completed_orders' => Order::where('user_id', $user->id)->whereIn('status', ['completed', 'delivered'])->count(),
            'total_spent' => Order::where('user_id', $user->id)->sum('total') ?? 0,
        ];

        return view('frontend.dashboard.index', compact('user', 'orders', 'stats'));
    }

    public function orders()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)
            ->with('items.product')
            ->latest()
            ->paginate(15);

        return view('frontend.dashboard.orders', compact('user', 'orders'));
    }

    public function orderDetails($orderNumber)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->with('items.product')
            ->firstOrFail();

        return view('frontend.dashboard.order-details', compact('order'));
    }

    public function profile()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        return view('frontend.dashboard.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $user = Auth::user();
        $user->update($validated);

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}
