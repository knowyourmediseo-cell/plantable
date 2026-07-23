<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        // Redirect to login if not authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to checkout');
        }

        $cart = Cart::getCurrentCart();
        $cart->load('items.product');

        if ($cart->items->isEmpty()) {
            return redirect()->route('frontend.cart.index')
                ->with('error', 'Your cart is empty. Please add products before checking out.');
        }

        $user = Auth::user();
        
        // Get commerce settings
        $taxRate = \App\Models\Setting::get('enable_tax') ? (float)\App\Models\Setting::get('default_tax_rate', 0) : 0;
        $shippingEnabled = \App\Models\Setting::get('enable_shipping', 1);
        $shippingCharge = (float)\App\Models\Setting::get('default_shipping_charge', 50);
        $freeShippingThreshold = (float)\App\Models\Setting::get('free_shipping_threshold', 1000);
        
        // Calculate tax
        $taxAmount = ($cart->subtotal * $taxRate) / 100;
        
        // Calculate shipping
        $shipping = 0;
        if ($shippingEnabled) {
            if ($freeShippingThreshold > 0 && $cart->subtotal >= $freeShippingThreshold) {
                $shipping = 0; // Free shipping
            } else {
                $shipping = $shippingCharge;
            }
        }
        
        $total = $cart->subtotal + $taxAmount + $shipping;
        
        return view('frontend.checkout.index', compact('cart', 'user', 'taxAmount', 'shipping', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name'    => 'required|string|max:100',
            'last_name'     => 'required|string|max:100',
            'email'         => 'required|email|max:255',
            'phone'         => 'required|string|max:20',
            'address'       => 'required|string|max:255',
            'city'          => 'required|string|max:100',
            'state'         => 'required|string|max:100',
            'postal_code'   => 'required|string|max:20',
            'country'       => 'required|string|max:100',
            'payment_method'=> 'required|in:cod,bank_transfer,upi',
            'notes'         => 'nullable|string|max:500',
        ]);

        $cart = Cart::getCurrentCart();
        $cart->load('items.product');

        if ($cart->items->isEmpty()) {
            return redirect()->route('frontend.cart.index')
                ->with('error', 'Your cart is empty.');
        }

        DB::beginTransaction();
        try {
            $billingAddress = [
                'first_name'  => $request->first_name,
                'last_name'   => $request->last_name,
                'address'     => $request->address,
                'city'        => $request->city,
                'state'       => $request->state,
                'postal_code' => $request->postal_code,
                'country'     => $request->country,
            ];

            // Get commerce settings
            $taxRate = \App\Models\Setting::get('enable_tax') ? (float)\App\Models\Setting::get('default_tax_rate', 0) : 0;
            $shippingEnabled = \App\Models\Setting::get('enable_shipping', 1);
            $shippingCharge = (float)\App\Models\Setting::get('default_shipping_charge', 50);
            $freeShippingThreshold = (float)\App\Models\Setting::get('free_shipping_threshold', 1000);
            
            // Calculate tax
            $taxAmount = ($cart->subtotal * $taxRate) / 100;
            
            // Calculate shipping
            $shipping = 0;
            if ($shippingEnabled) {
                if ($freeShippingThreshold > 0 && $cart->subtotal >= $freeShippingThreshold) {
                    $shipping = 0;
                } else {
                    $shipping = $shippingCharge;
                }
            }
            
            $total = $cart->subtotal + $taxAmount + $shipping;

            $order = Order::create([
                'user_id'          => Auth::id(),
                'customer_email'   => $request->email,
                'customer_phone'   => $request->phone,
                'subtotal'         => $cart->subtotal,
                'discount'         => $cart->discount_amount ?? 0,
                'tax'              => $taxAmount,
                'shipping_cost'    => $shipping,
                'total'            => $total,
                'payment_method'   => $request->payment_method,
                'payment_status'   => 'pending',
                'billing_address'  => $billingAddress,
                'shipping_address' => $billingAddress,
                'status'           => 'pending',
                'notes'            => $request->notes,
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $item->product_id,
                    'product_name' => $item->product->name,
                    'product_sku'  => $item->product->sku ?? '',
                    'price'        => $item->price,
                    'quantity'     => $item->quantity,
                    'subtotal'     => $item->subtotal,
                ]);
            }

            // Clear cart
            $cart->items()->delete();

            DB::commit();

            return redirect()->route('frontend.checkout.success', $order->order_number)
                ->with('success', 'Order placed successfully! Order Number: ' . $order->order_number);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Checkout error: ' . $e->getMessage());
            return back()->with('error', 'Something went wrong. Please try again.')->withInput();
        }
    }

    public function success($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->with('items.product')
            ->firstOrFail();

        return view('frontend.checkout.success', compact('order'));
    }
}
