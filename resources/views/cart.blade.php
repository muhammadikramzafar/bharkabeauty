@extends('layouts.app')

@section('title', 'Shopping Bag — BharkaBeauty')

@section('content')

    <div class="container cart-layout">

        <div class="cart-main">
            <h1 class="cart-title">My Bag <span class="cart-count">({{ count($cartItems ?? []) }} items)</span></h1>

            @forelse($cartItems ?? [] as $item)
                <div class="cart-item">
                    <div class="cart-item-image">
                        <img src="{{ $item['image'] ?? 'https://images.unsplash.com/photo-1583241800698-e8ab01830a22?w=120&h=120&fit=crop' }}" alt="{{ $item['name'] ?? 'Product' }}" loading="lazy">
                    </div>
                    <div class="cart-item-details">
                        <p class="cart-item-brand">{{ $item['brand'] ?? 'Brand' }}</p>
                        <h3 class="cart-item-name">{{ $item['name'] ?? 'Product Name' }}</h3>
                        <div class="cart-item-qty">
                            <form method="POST" action="{{ route('cart.update') }}">
                                @csrf
                                <input type="hidden" name="item_id" value="{{ $item['id'] }}">
                                <button type="button" class="qty-btn" data-action="decrease">−</button>
                                <input type="number" name="quantity" value="{{ $item['quantity'] ?? 1 }}" min="1" class="qty-input">
                                <button type="button" class="qty-btn" data-action="increase">+</button>
                            </form>
                        </div>
                    </div>
                    <div class="cart-item-price">
                        <span class="price-current">PKR {{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1)) }}</span>
                        <form method="POST" action="{{ route('cart.remove') }}">
                            @csrf
                            <input type="hidden" name="item_id" value="{{ $item['id'] }}">
                            <button type="submit" class="cart-remove-btn" aria-label="Remove item">✕</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="cart-empty">
                    <p>Your bag is empty.</p>
                    <a href="{{ route('category.index') }}" class="btn btn-primary btn-md">Continue Shopping</a>
                </div>
            @endforelse

            @if(!empty($cartItems))
                <a href="{{ route('category.index') }}" class="cart-continue-link">← Continue Shopping</a>
            @endif
        </div>

        @if(!empty($cartItems))
            <aside class="cart-summary">
                <h2 class="cart-summary-title">Order Summary</h2>

                <div class="cart-summary-row">
                    <span>Subtotal</span>
                    <span>PKR {{ number_format($subtotal ?? 0) }}</span>
                </div>
                @if(isset($savings) && $savings > 0)
                    <div class="cart-summary-row savings">
                        <span>Savings</span>
                        <span>− PKR {{ number_format($savings) }}</span>
                    </div>
                @endif
                <div class="cart-summary-row">
                    <span>Delivery</span>
                    <span>{{ ($subtotal ?? 0) >= 2000 ? 'Free' : 'PKR 150' }}</span>
                </div>

                <div class="cart-coupon">
                    <form method="POST" action="{{ route('cart.coupon') }}">
                        @csrf
                        <input type="text" name="coupon" placeholder="Enter coupon code" class="coupon-input">
                        <button type="submit" class="coupon-btn">Apply</button>
                    </form>
                </div>

                <div class="cart-summary-total">
                    <span>Total</span>
                    <span>PKR {{ number_format(($subtotal ?? 0) + (($subtotal ?? 0) < 2000 ? 150 : 0)) }}</span>
                </div>

                <a href="{{ route('checkout') }}" class="btn btn-primary btn-lg btn-full">Proceed to Checkout</a>
            </aside>
        @endif

    </div>

@endsection
