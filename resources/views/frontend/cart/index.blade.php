@extends('layouts.frontend.app')

@section('title', 'Shopping Cart')

@section('content')
<section class="cart-section py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4">Shopping Cart</h2>
                
                @if($cart->items->count() > 0)
                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="card shadow-sm mb-4">
                            <div class="card-body">
                                <!-- Desktop Table View -->
                                <div class="table-responsive d-none d-md-block">
                                    <table class="table cart-table align-middle">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Subtotal</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($cart->items as $item)
                                            <tr class="cart-item" data-item-id="{{ $item->id }}" data-price="{{ $item->price }}">
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if($item->product->featured_image)
                                                        <img src="{{ asset('storage/' . $item->product->featured_image) }}" alt="{{ $item->product->name }}" class="img-thumbnail me-3" style="width: 80px; height: 80px; object-fit: cover;">
                                                        @endif
                                                        <div>
                                                            <h6 class="mb-1">{{ $item->product->name }}</h6>
                                                            <small class="text-muted">SKU: {{ $item->product->sku }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="item-price">{{ format_price($item->price) }}</td>
                                                <td>
                                                    <div class="input-group quantity-selector" style="width: 130px;">
                                                        <button class="btn btn-outline-secondary btn-sm btn-decrease" type="button">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                        <input type="number" class="form-control form-control-sm text-center item-quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock_quantity ?? 999 }}" readonly>
                                                        <button class="btn btn-outline-secondary btn-sm btn-increase" type="button">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                                <td class="item-subtotal fw-bold text-success">{{ format_price($item->subtotal) }}</td>
                                                <td>
                                                    <button class="btn btn-sm btn-danger btn-remove-item" title="Remove item">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Mobile Card View -->
                                <div class="d-md-none">
                                    @foreach($cart->items as $item)
                                    <div class="card mb-3 cart-item" data-item-id="{{ $item->id }}" data-price="{{ $item->price }}">
                                        <div class="card-body">
                                            <div class="row g-3">
                                                <div class="col-4">
                                                    @if($item->product->featured_image)
                                                    <img src="{{ asset('storage/' . $item->product->featured_image) }}" alt="{{ $item->product->name }}" class="img-fluid rounded" style="width: 100%; height: 100px; object-fit: cover;">
                                                    @endif
                                                </div>
                                                <div class="col-8">
                                                    <h6 class="mb-1">{{ $item->product->name }}</h6>
                                                    <small class="text-muted d-block mb-2">SKU: {{ $item->product->sku }}</small>
                                                    <p class="text-success fw-bold mb-2 item-price">{{ format_price($item->price) }}</p>
                                                    
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="input-group quantity-selector" style="width: 110px;">
                                                            <button class="btn btn-outline-secondary btn-sm btn-decrease" type="button">
                                                                <i class="fas fa-minus"></i>
                                                            </button>
                                                            <input type="number" class="form-control form-control-sm text-center item-quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock_quantity ?? 999 }}" readonly>
                                                            <button class="btn btn-outline-secondary btn-sm btn-increase" type="button">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                        </div>
                                                        <button class="btn btn-sm btn-danger btn-remove-item">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                    
                                                    <div class="mt-2">
                                                        <small class="text-muted">Subtotal:</small>
                                                        <strong class="item-subtotal text-success">{{ format_price($item->subtotal) }}</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex flex-column flex-sm-row justify-content-between gap-2">
                            <a href="{{ route('frontend.products.index') }}" class="btn" style="border:2px solid #2E7D32; color:#2E7D32;"
                               onmouseover="this.style.background='#2E7D32';this.style.color='#fff'" onmouseout="this.style.background='transparent';this.style.color='#2E7D32'">
                                <i class="fas fa-arrow-left me-2"></i>Continue Shopping
                            </a>
                            <button class="btn" id="clear-cart-btn" style="border:2px solid #dc3545; color:#dc3545;"
                               onmouseover="this.style.background='#dc3545';this.style.color='#fff'" onmouseout="this.style.background='transparent';this.style.color='#dc3545'">
                                <i class="fas fa-trash me-2"></i>Clear Cart
                            </button>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="card shadow-sm">
                            <div class="card-header py-3 text-white" style="background-color:#2E7D32;">
                                <h5 class="mb-0">Order Summary</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal</span>
                                    <span id="cart-subtotal">{{ format_price($cart->subtotal) }}</span>
                                </div>
                                @if($taxAmount > 0)
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Tax</span>
                                    <span id="cart-tax">{{ format_price($taxAmount) }}</span>
                                </div>
                                @endif
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Shipping</span>
                                    <span id="cart-shipping" class="{{ $shipping > 0 ? '' : 'text-success fw-semibold' }}">
                                        {{ $shipping > 0 ? format_price($shipping) : 'FREE' }}
                                    </span>
                                </div>
                                @if($cart->discount_amount > 0)
                                <div class="d-flex justify-content-between mb-2" style="color:#2E7D32;">
                                    <span>Discount</span>
                                    <span>-{{ format_price($cart->discount_amount) }}</span>
                                </div>
                                @endif
                                <hr>
                                <div class="d-flex justify-content-between mb-3">
                                    <strong>Total</strong>
                                    <strong id="cart-total" class="fs-5" style="color:#2E7D32;">{{ format_price($total) }}</strong>
                                </div>
                                
                                @auth
                                <a href="{{ route('frontend.checkout.index') }}" class="btn w-100 mb-2 py-3 fw-bold text-white" style="background:#2E7D32; border:none;"
                                    onmouseover="this.style.background='#1B5E20'" onmouseout="this.style.background='#2E7D32'">
                                    <i class="fas fa-lock me-2"></i>Proceed to Checkout
                                </a>
                                @else
                                <a href="{{ route('login') }}?redirect={{ urlencode(route('frontend.checkout.index')) }}"
                                   class="btn w-100 mb-2 py-3 fw-bold text-white" style="background:#2E7D32; border:none;"
                                   onmouseover="this.style.background='#1B5E20'" onmouseout="this.style.background='#2E7D32'">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login to Checkout
                                </a>
                                <p class="text-center small text-muted mt-2">Or <a href="{{ route('register') }}" style="color:#2E7D32;">create an account</a></p>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="text-center py-5">
                    <i class="fas fa-shopping-cart fa-5x text-muted mb-3"></i>
                    <h3>Your cart is empty</h3>
                    <p class="text-muted">Add some products to get started!</p>
                    <a href="{{ route('frontend.products.index') }}" class="btn mt-3 text-white" style="background:#2E7D32; border:none;"
                        onmouseover="this.style.background='#1B5E20'" onmouseout="this.style.background='#2E7D32'">
                        <i class="fas fa-shopping-bag me-2"></i>Shop Now
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<style>
.quantity-selector {
    max-width: 130px;
}
.quantity-selector .btn {
    padding: 0.25rem 0.5rem;
}
.quantity-selector input {
    border-left: none;
    border-right: none;
    pointer-events: none;
}
.cart-item {
    transition: all 0.3s ease;
}
.cart-item.removing {
    opacity: 0.4;
    pointer-events: none;
}
@media (max-width: 767.98px) {
    .quantity-selector {
        max-width: 110px;
    }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script>
$(document).ready(function() {

    // ── Quantity increase/decrease ──────────────────────────────────────────
    $('.btn-increase, .btn-decrease').on('click', function() {
        const row          = $(this).closest('.cart-item');
        const itemId       = row.data('item-id');
        const qtyInput     = row.find('.item-quantity');
        const price        = parseFloat(row.data('price'));
        let   quantity     = parseInt(qtyInput.val());
        const max          = parseInt(qtyInput.attr('max')) || 999;

        if ($(this).hasClass('btn-increase')) {
            if (quantity < max) { quantity++; }
            else { showToast('Maximum stock quantity reached', 'warning'); return; }
        } else {
            if (quantity > 1) { quantity--; }
            else { return; }
        }

        qtyInput.val(quantity);
        row.find('.item-subtotal').text('₹' + (price * quantity).toFixed(2));
        updateCartItem(itemId, quantity);
    });

    // ── Remove single item ──────────────────────────────────────────────────
    $('.btn-remove-item').on('click', function() {
        const row    = $(this).closest('.cart-item');
        const itemId = row.data('item-id');

        Swal.fire({
            title: 'Remove Item?',
            text: 'Are you sure you want to remove this item from the cart?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#2E7D32',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Remove',
            cancelButtonText: 'Cancel',
            borderRadius: '12px',
        }).then((result) => {
            if (result.isConfirmed) {
                row.addClass('removing');
                removeCartItem(itemId, row);
            }
        });
    });

    // ── Clear cart with SweetAlert2 ─────────────────────────────────────────
    $('#clear-cart-btn').on('click', function() {
        Swal.fire({
            title: 'Clear Entire Cart?',
            text: 'This will remove all items from your cart. This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#2E7D32',
            confirmButtonText: '<i class="fas fa-trash me-1"></i> Yes, Clear Cart',
            cancelButtonText: 'Cancel',
            background: '#fff',
            customClass: {
                popup: 'rounded-3',
            }
        }).then((result) => {
            if (result.isConfirmed) {
                clearCart();
            }
        });
    });

    // ── AJAX: update quantity ────────────────────────────────────────────────
    function updateCartItem(itemId, quantity) {
        $.ajax({
            url: '/cart/update/' + itemId,
            method: 'PATCH',
            data: { quantity: quantity, _token: '{{ csrf_token() }}' },
            success: function(res) {
                if (res.success) {
                    updateCartTotals(res.cart);
                    showToast('Cart updated', 'success');
                }
            },
            error: function(xhr) {
                showToast(xhr.responseJSON?.message || 'Error updating cart', 'error');
                location.reload();
            }
        });
    }

    // ── AJAX: remove item ────────────────────────────────────────────────────
    function removeCartItem(itemId, row) {
        $.ajax({
            url: '/cart/remove/' + itemId,
            method: 'DELETE',
            data: { _token: '{{ csrf_token() }}' },
            success: function(res) {
                if (res.success) {
                    row.fadeOut(300, function() {
                        $(this).remove();
                        if ($('.cart-item').length === 0) {
                            location.reload();
                        } else {
                            updateCartTotals(res.cart);
                            Swal.fire({
                                icon: 'success',
                                title: 'Removed!',
                                text: 'Item removed from cart.',
                                timer: 1500,
                                showConfirmButton: false,
                                confirmButtonColor: '#2E7D32',
                            });
                        }
                    });
                }
            },
            error: function() {
                row.removeClass('removing');
                showToast('Error removing item', 'error');
            }
        });
    }

    // ── AJAX: clear cart ─────────────────────────────────────────────────────
    function clearCart() {
        $.ajax({
            url: '/cart/clear',
            method: 'DELETE',
            data: { _token: '{{ csrf_token() }}' },
            success: function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Cart Cleared!',
                    text: 'All items have been removed.',
                    confirmButtonColor: '#2E7D32',
                    timer: 1800,
                    showConfirmButton: false,
                }).then(() => { location.reload(); });
            },
            error: function() {
                showToast('Error clearing cart', 'error');
            }
        });
    }

    // ── Update totals in DOM ─────────────────────────────────────────────────
    function updateCartTotals(cart) {
        $('#cart-subtotal').text(cart.subtotal);
        $('#cart-total').text(cart.total);
        $('.cart-count').text(cart.items_count);
    }

    // ── Toast helper ─────────────────────────────────────────────────────────
    function showToast(message, type) {
        if (window.Toast) {
            type === 'success' ? window.Toast.success(message) : window.Toast.error(message);
        }
    }
});
</script>
@endpush
@endsection
