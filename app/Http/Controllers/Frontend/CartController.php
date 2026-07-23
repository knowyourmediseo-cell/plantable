<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::getCurrentCart();
        $cart->load('items.product');
        
        // Get commerce settings for tax and shipping
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

        return view('frontend.cart.index', compact('cart', 'taxAmount', 'shipping', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        if ($product->stock_status === 'out_of_stock') {
            return response()->json([
                'success' => false,
                'message' => 'This product is out of stock'
            ], 400);
        }

        $cart = Cart::getCurrentCart();
        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        $price = $product->sale_price ?? $product->price;

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $request->quantity;
            
            if ($product->stock_quantity && $newQuantity > $product->stock_quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Not enough stock available'
                ], 400);
            }

            $cartItem->update([
                'quantity' => $newQuantity
            ]);
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $price
            ]);
        }

        $cart->load('items.product');

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully',
            'cart_count' => $cart->total_items,
            'cart' => [
                'subtotal' => format_price($cart->subtotal),
                'total' => format_price($cart->total),
                'items_count' => $cart->total_items
            ]
        ]);
    }

    public function update(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = Cart::getCurrentCart();
        $cartItem = $cart->items()->findOrFail($itemId);

        if ($cartItem->product->stock_quantity && $request->quantity > $cartItem->product->stock_quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Not enough stock available'
            ], 400);
        }

        $cartItem->update([
            'quantity' => $request->quantity
        ]);

        $cart->load('items.product');

        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully',
            'cart' => [
                'subtotal' => format_price($cart->subtotal),
                'total' => format_price($cart->total),
                'items_count' => $cart->total_items
            ]
        ]);
    }

    public function remove($itemId)
    {
        $cart = Cart::getCurrentCart();
        $cartItem = $cart->items()->findOrFail($itemId);
        $cartItem->delete();

        $cart->load('items.product');

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart',
            'cart' => [
                'subtotal' => format_price($cart->subtotal),
                'total' => format_price($cart->total),
                'items_count' => $cart->total_items
            ]
        ]);
    }

    public function clear()
    {
        $cart = Cart::getCurrentCart();
        $cart->items()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared successfully'
        ]);
    }

    public function count()
    {
        $cart = Cart::getCurrentCart();
        
        return response()->json([
            'count' => $cart->total_items
        ]);
    }
}
