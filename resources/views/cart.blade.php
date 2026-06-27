@extends('layouts.app')

@section('title', 'My Bag — BharkaBeauty')

@section('content')

    <div class="breadcrumb-bar">
        <div class="container">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <ol>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li aria-current="page">My Bag</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container cart-layout">

        {{-- ── LEFT: Cart Items ─────────────────────────────────── --}}
        <div class="cart-main">
            <h1 class="cart-title">My Bag
                <span class="cart-count" style="font-size:1rem;font-weight:400;color:var(--color-text-muted);">
                    ({{ count($cartItems ?? []) }} {{ count($cartItems ?? []) == 1 ? 'item' : 'items' }})
                </span>
            </h1>

            @if(session('success'))
                <div style="background:#d1fae5;color:#065f46;padding:.75rem 1rem;border-radius:8px;margin-bottom:1rem;font-size:.9rem;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="cart-items-list">
                @forelse($cartItems ?? [] as $item)
                    <div class="cart-item">

                        {{-- Image --}}
                        <img class="cart-item-img"
                             src="{{ $item['image'] ?? 'https://images.unsplash.com/photo-1583241800698-e8ab01830a22?w=200&h=200&fit=crop' }}"
                             alt="{{ $item['name'] ?? 'Product' }}"
                             loading="lazy">

                        {{-- Details --}}
                        <div>
                            @if(!empty($item['brand']))
                                <p class="cart-item-brand">{{ $item['brand'] }}</p>
                            @endif
                            <h3 class="cart-item-name">
                                <a href="{{ route('product.show', $item['slug'] ?? '#') }}" style="color:inherit;text-decoration:none;">
                                    {{ $item['name'] ?? 'Product' }}
                                </a>
                            </h3>

                            {{-- Qty controls --}}
                            <form method="POST" action="{{ route('cart.update') }}" class="cart-item-controls">
                                @csrf
                                <input type="hidden" name="item_id" value="{{ $item['id'] }}">
                                <button type="submit" name="quantity" value="{{ max(1, ($item['quantity'] ?? 1) - 1) }}"
                                        class="qty-btn" style="width:32px;height:32px;border:1.5px solid var(--color-border);border-radius:6px;background:#fff;cursor:pointer;font-size:1rem;line-height:1;">−</button>
                                <span style="font-weight:600;min-width:24px;text-align:center;">{{ $item['quantity'] ?? 1 }}</span>
                                <button type="submit" name="quantity" value="{{ min(10, ($item['quantity'] ?? 1) + 1) }}"
                                        class="qty-btn" style="width:32px;height:32px;border:1.5px solid var(--color-border);border-radius:6px;background:#fff;cursor:pointer;font-size:1rem;line-height:1;">+</button>
                            </form>
                        </div>

                        {{-- Price + Remove --}}
                        <div style="text-align:right;display:flex;flex-direction:column;align-items:flex-end;gap:.5rem;">
                            <div class="cart-item-price">
                                PKR {{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1)) }}
                            </div>
                            @if(isset($item['original_price']) && $item['original_price'] > $item['price'])
                                <div style="font-size:.78rem;color:var(--color-text-muted);text-decoration:line-through;">
                                    PKR {{ number_format($item['original_price'] * ($item['quantity'] ?? 1)) }}
                                </div>
                            @endif
                            <form method="POST" action="{{ route('cart.remove') }}">
                                @csrf
                                <input type="hidden" name="item_id" value="{{ $item['id'] }}">
                                <button type="submit" class="cart-item-remove" aria-label="Remove item"
                                        style="background:none;border:none;cursor:pointer;color:var(--color-sale);font-size:.8rem;padding:0;">
                                    Remove
                                </button>
                            </form>
                        </div>

                    </div>
                @empty
                    <div class="cart-empty" style="text-align:center;padding:4rem 1rem;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                             style="width:56px;height:56px;margin:0 auto 1rem;display:block;color:#d1d5db;">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/>
                        </svg>
                        <p style="font-size:1.1rem;font-weight:600;margin-bottom:.5rem;">Your bag is empty</p>
                        <p style="color:var(--color-text-muted);margin-bottom:1.5rem;">Looks like you haven't added anything yet.</p>
                        <a href="{{ route('category.index') }}" class="btn btn-primary btn-md">Start Shopping</a>
                    </div>
                @endforelse
            </div>

            @if(!empty($cartItems))
                <a href="{{ route('category.index') }}" class="cart-continue-link"
                   style="display:inline-block;margin-top:1.5rem;font-size:.9rem;color:var(--color-text-muted);">
                    ← Continue Shopping
                </a>
            @endif
        </div>

        {{-- ── RIGHT: Order Summary ──────────────────────────────── --}}
        @if(!empty($cartItems))
        <aside class="cart-summary">
            <h2 class="cart-summary-title">Order Summary</h2>

            <div class="summary-row">
                <span>Subtotal ({{ count($cartItems) }} items)</span>
                <span>PKR {{ number_format($subtotal ?? 0) }}</span>
            </div>

            @if(isset($savings) && $savings > 0)
                <div class="summary-row" style="color:var(--color-success, #16a34a);">
                    <span>You Save</span>
                    <span>− PKR {{ number_format($savings) }}</span>
                </div>
            @endif

            <div class="summary-row">
                <span>Delivery</span>
                <span>
                    @if(($subtotal ?? 0) >= 2000)
                        <span style="color:var(--color-success,#16a34a);font-weight:600;">Free</span>
                    @else
                        PKR 150
                        <span style="display:block;font-size:.72rem;color:var(--color-text-muted);">Free on orders over PKR 2,000</span>
                    @endif
                </span>
            </div>

            {{-- Coupon --}}
            <div class="promo-input-wrap">
                <form method="POST" action="{{ route('cart.coupon') }}" style="display:flex;gap:.5rem;width:100%;">
                    @csrf
                    <input type="text" name="coupon" placeholder="Enter coupon code"
                           style="flex:1;padding:.6rem .9rem;border:1.5px solid var(--color-border);border-radius:8px;font-size:.875rem;outline:none;">
                    <button type="submit"
                            style="padding:.6rem 1rem;background:var(--color-primary);color:#fff;border:none;border-radius:8px;font-size:.875rem;cursor:pointer;white-space:nowrap;">
                        Apply
                    </button>
                </form>
            </div>

            @php
                $delivery = ($subtotal ?? 0) >= 2000 ? 0 : 150;
                $total    = ($subtotal ?? 0) + $delivery;
            @endphp
            <div class="summary-total">
                <span>Total</span>
                <span>PKR {{ number_format($total) }}</span>
            </div>

            <a href="{{ route('checkout') }}" class="btn btn-primary btn-lg btn-full"
               style="display:block;text-align:center;margin-top:1rem;">
                Proceed to Checkout
            </a>

            {{-- Trust badges --}}
            <div style="display:flex;gap:1rem;margin-top:1.25rem;padding-top:1rem;border-top:1px solid var(--color-border-soft);">
                <div style="display:flex;align-items:center;gap:.4rem;font-size:.72rem;color:var(--color-text-muted);">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:16px;height:16px;flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                    Secure Checkout
                </div>
                <div style="display:flex;align-items:center;gap:.4rem;font-size:.72rem;color:var(--color-text-muted);">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:16px;height:16px;flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    Easy Returns
                </div>
                <div style="display:flex;align-items:center;gap:.4rem;font-size:.72rem;color:var(--color-text-muted);">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:16px;height:16px;flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/></svg>
                    100% Authentic
                </div>
            </div>
        </aside>
        @endif

    </div>

@endsection
