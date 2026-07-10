@extends('layouts.app')

@section('title', 'Beauty Box — AmsazBeauty')

@section('content')

<div class="breadcrumb-bar">
    <div class="container">
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <ol>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li aria-current="page">Beauty Box</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container" style="padding-top:2.5rem;padding-bottom:4rem;">
    <div style="display:grid;grid-template-columns:1fr 380px;gap:2.5rem;align-items:start;">

        {{-- ── LEFT: Items ──────────────────────────────────────── --}}
        <div>

            {{-- Header --}}
            <div style="display:flex;align-items:baseline;gap:.75rem;margin-bottom:1.75rem;padding-bottom:1.25rem;border-bottom:2px solid var(--color-primary);">
                <h1 style="font-family:var(--font-display);font-size:2rem;font-weight:800;color:var(--color-primary);margin:0;">Beauty Box</h1>
                <span style="font-size:.9rem;color:var(--color-text-muted);font-weight:400;">
                    {{ count($cartItems ?? []) }} {{ count($cartItems ?? []) == 1 ? 'item' : 'items' }}
                </span>
            </div>

            {{-- Items list --}}
            @forelse($cartItems ?? [] as $item)
            <div style="display:grid;grid-template-columns:88px 1fr auto;gap:1.25rem;align-items:center;padding:1.25rem 0;border-bottom:1px solid var(--color-border);">

                {{-- Image --}}
                <a href="{{ route('product.show', $item['slug'] ?? '#') }}"
                   style="display:block;width:88px;height:88px;border-radius:var(--radius-lg);overflow:hidden;background:var(--color-bg-alt);flex-shrink:0;">
                    <img src="{{ $item['image'] ?? '' }}" alt="{{ $item['name'] }}"
                         style="width:100%;height:100%;object-fit:cover;" loading="lazy">
                </a>

                {{-- Details --}}
                <div style="min-width:0;">
                    @if(!empty($item['brand']))
                    <p style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--color-accent);margin:0 0 .25rem;">{{ $item['brand'] }}</p>
                    @endif
                    <h3 style="font-size:.95rem;font-weight:700;color:var(--color-primary);margin:0 0 .75rem;line-height:1.35;">
                        <a href="{{ route('product.show', $item['slug'] ?? '#') }}" style="color:inherit;text-decoration:none;">{{ $item['name'] }}</a>
                    </h3>

                    {{-- Qty controls --}}
                    <div style="display:flex;align-items:center;gap:.5rem;">
                        <form method="POST" action="{{ route('cart.update') }}" style="display:contents;">
                            @csrf
                            <input type="hidden" name="item_id" value="{{ $item['id'] }}">
                            <button type="submit" name="quantity" value="{{ max(1, ($item['quantity'] ?? 1) - 1) }}"
                                    style="width:30px;height:30px;border:1.5px solid var(--color-border);border-radius:6px;background:var(--color-surface);cursor:pointer;font-size:1rem;color:var(--color-primary);display:flex;align-items:center;justify-content:center;line-height:1;">−</button>
                        </form>
                        <span style="font-size:.9rem;font-weight:700;min-width:22px;text-align:center;color:var(--color-primary);">{{ $item['quantity'] ?? 1 }}</span>
                        <form method="POST" action="{{ route('cart.update') }}" style="display:contents;">
                            @csrf
                            <input type="hidden" name="item_id" value="{{ $item['id'] }}">
                            <button type="submit" name="quantity" value="{{ ($item['quantity'] ?? 1) + 1 }}"
                                    style="width:30px;height:30px;border:1.5px solid var(--color-border);border-radius:6px;background:var(--color-surface);cursor:pointer;font-size:1rem;color:var(--color-primary);display:flex;align-items:center;justify-content:center;line-height:1;">+</button>
                        </form>

                        <span style="width:1px;height:16px;background:var(--color-border);margin:0 .25rem;"></span>

                        <form method="POST" action="{{ route('cart.remove') }}" style="display:contents;">
                            @csrf
                            <input type="hidden" name="item_id" value="{{ $item['id'] }}">
                            <button type="submit"
                                    style="background:none;border:none;cursor:pointer;font-size:.78rem;color:var(--color-text-muted);padding:0;text-decoration:underline;text-underline-offset:2px;"
                                    onmouseover="this.style.color='#dc2626'" onmouseout="this.style.color='var(--color-text-muted)'">
                                Remove
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Price --}}
                <div style="text-align:right;flex-shrink:0;">
                    <p style="font-size:1rem;font-weight:800;color:var(--color-primary);margin:0 0 .2rem;">
                        PKR {{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1)) }}
                    </p>
                    @if(isset($item['original_price']) && $item['original_price'] > $item['price'])
                    <p style="font-size:.78rem;color:var(--color-text-muted);text-decoration:line-through;margin:0;">
                        PKR {{ number_format($item['original_price'] * ($item['quantity'] ?? 1)) }}
                    </p>
                    @endif
                </div>

            </div>
            @empty
            {{-- Empty state --}}
            <div style="text-align:center;padding:5rem 1rem;">
                <div style="width:80px;height:80px;border-radius:50%;background:var(--color-bg-alt);display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;">
                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="var(--color-border)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/>
                    </svg>
                </div>
                <h2 style="font-family:var(--font-display);font-size:1.5rem;font-weight:800;color:var(--color-primary);margin:0 0 .5rem;">Your Beauty Box is empty</h2>
                <p style="color:var(--color-text-muted);margin:0 0 2rem;font-size:.9rem;">Explore our curated collection and fill your box with favourites.</p>
                <a href="{{ route('category.index') }}" class="btn btn-primary"
                   style="display:inline-flex;align-items:center;gap:.6rem;height:52px;padding:0 2rem;font-size:.95rem;font-weight:700;border-radius:var(--radius-full,50px);">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/>
                    </svg>
                    Start Shopping
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
            @endforelse

            @if(!empty($cartItems))
            <a href="{{ route('category.index') }}"
               style="display:inline-flex;align-items:center;gap:.4rem;margin-top:1.5rem;font-size:.85rem;color:var(--color-text-muted);text-decoration:none;"
               onmouseover="this.style.color='var(--color-accent)'" onmouseout="this.style.color='var(--color-text-muted)'">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                Continue Shopping
            </a>
            @endif
        </div>

        {{-- ── RIGHT: Order Summary ──────────────────────────────── --}}
        @if(!empty($cartItems))
        @php
            $couponDiscount = $coupon['discount'] ?? 0;
            $delivery = ($subtotal ?? 0) >= 2000 ? 0 : 150;
            $total    = ($subtotal ?? 0) - $couponDiscount + $delivery;
        @endphp
        <aside style="background:var(--color-surface);border:1.5px solid var(--color-border);border-radius:var(--radius-xl);padding:1.75rem;position:sticky;top:100px;">

            <h2 style="font-family:var(--font-display);font-size:1.15rem;font-weight:800;color:var(--color-primary);margin:0 0 1.5rem;">Order Summary</h2>

            {{-- Subtotal --}}
            <div style="display:flex;justify-content:space-between;align-items:center;font-size:.875rem;margin-bottom:.75rem;color:var(--color-text-muted);">
                <span>Subtotal ({{ count($cartItems) }} {{ count($cartItems) == 1 ? 'item' : 'items' }})</span>
                <span style="color:var(--color-primary);font-weight:600;">PKR {{ number_format($subtotal ?? 0) }}</span>
            </div>

            {{-- Savings from sale prices --}}
            @if(isset($savings) && $savings > 0)
            <div style="display:flex;justify-content:space-between;align-items:center;font-size:.875rem;margin-bottom:.75rem;">
                <span style="color:#16a34a;font-weight:600;">You Save</span>
                <span style="color:#16a34a;font-weight:700;">− PKR {{ number_format($savings) }}</span>
            </div>
            @endif

            {{-- Coupon discount --}}
            @if($couponDiscount > 0)
            <div style="display:flex;justify-content:space-between;align-items:center;font-size:.875rem;margin-bottom:.75rem;">
                <span style="color:#16a34a;font-weight:600;">Coupon ({{ $coupon['code'] }})</span>
                <span style="color:#16a34a;font-weight:700;">− PKR {{ number_format($couponDiscount) }}</span>
            </div>
            @endif

            {{-- Delivery --}}
            <div style="display:flex;justify-content:space-between;align-items:center;font-size:.875rem;margin-bottom:1.25rem;padding-bottom:1.25rem;border-bottom:1px solid var(--color-border);">
                <span style="color:var(--color-text-muted);">Delivery</span>
                @if($delivery == 0)
                    <span style="color:#16a34a;font-weight:700;">Free</span>
                @else
                    <div style="text-align:right;">
                        <span style="color:var(--color-primary);font-weight:600;">PKR 150</span>
                        <p style="font-size:.7rem;color:var(--color-text-muted);margin:.15rem 0 0;">Free above PKR 2,000</p>
                    </div>
                @endif
            </div>

            {{-- Free delivery progress --}}
            @if($delivery > 0)
            @php $progress = min(100, round((($subtotal ?? 0) / 2000) * 100)); @endphp
            <div style="margin-bottom:1.25rem;">
                <div style="height:5px;background:var(--color-bg-alt);border-radius:50px;overflow:hidden;">
                    <div style="height:100%;width:{{ $progress }}%;background:var(--color-accent);border-radius:50px;transition:width .4s;"></div>
                </div>
                <p style="font-size:.72rem;color:var(--color-text-muted);margin:.4rem 0 0;">
                    Add <strong style="color:var(--color-primary);">PKR {{ number_format(2000 - ($subtotal ?? 0)) }}</strong> more for free delivery
                </p>
            </div>
            @endif

            {{-- Coupon --}}
            @if($coupon)
            <div style="display:flex;align-items:center;justify-content:space-between;background:#f0fdf4;border:1.5px solid #86efac;border-radius:var(--radius-md);padding:.6rem .85rem;margin-bottom:1rem;font-size:.82rem;">
                <div>
                    <span style="font-weight:700;color:#15803d;">{{ $coupon['code'] }}</span>
                    <span style="color:#15803d;margin-left:.4rem;">applied — save PKR {{ number_format($coupon['discount']) }}</span>
                </div>
                <form method="POST" action="{{ route('cart.coupon.remove') }}" style="margin:0;">
                    @csrf
                    <button type="submit" style="background:none;border:none;cursor:pointer;color:#15803d;font-size:1rem;line-height:1;opacity:.7;" title="Remove coupon">✕</button>
                </form>
            </div>
            @else
            <form method="POST" action="{{ route('cart.coupon') }}" style="display:flex;gap:.5rem;margin-bottom:1.25rem;">
                @csrf
                <input type="text" name="coupon" placeholder="Coupon code"
                       style="flex:1;height:40px;padding:0 .85rem;border:1.5px solid var(--color-border);border-radius:var(--radius-md);font-size:.82rem;color:var(--color-primary);outline:none;background:var(--color-surface);"
                       onfocus="this.style.borderColor='var(--color-accent)'" onblur="this.style.borderColor='var(--color-border)'">
                <button type="submit"
                        style="height:40px;padding:0 1rem;background:var(--color-primary);color:#fff;border:none;border-radius:var(--radius-md);font-size:.82rem;font-weight:700;cursor:pointer;white-space:nowrap;">
                    Apply
                </button>
            </form>
            @endif

            {{-- Total --}}
            <div style="display:flex;justify-content:space-between;align-items:center;padding:1rem 0;border-top:2px solid var(--color-primary);border-bottom:1px solid var(--color-border);margin-bottom:1.25rem;">
                <span style="font-size:1rem;font-weight:800;color:var(--color-primary);">Total</span>
                <span style="font-family:var(--font-display);font-size:1.2rem;font-weight:800;color:var(--color-primary);">PKR {{ number_format($total) }}</span>
            </div>

            <a href="{{ route('checkout') }}" class="btn btn-primary btn-lg"
               style="display:block;text-align:center;width:100%;">
                Proceed to Checkout
            </a>

            {{-- Trust row --}}
            <div style="display:flex;justify-content:space-around;margin-top:1.25rem;padding-top:1rem;border-top:1px solid var(--color-border);">
                <div style="text-align:center;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--color-accent)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="display:block;margin:0 auto .35rem;">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                    <p style="font-size:.68rem;color:var(--color-text-muted);margin:0;font-weight:600;">Secure</p>
                </div>
                <div style="text-align:center;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--color-accent)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="display:block;margin:0 auto .35rem;">
                        <polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 102.13-9.36L1 10"/>
                    </svg>
                    <p style="font-size:.68rem;color:var(--color-text-muted);margin:0;font-weight:600;">Easy Returns</p>
                </div>
                <div style="text-align:center;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--color-accent)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="display:block;margin:0 auto .35rem;">
                        <path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    <p style="font-size:.68rem;color:var(--color-text-muted);margin:0;font-weight:600;">100% Authentic</p>
                </div>
            </div>

        </aside>
        @endif

    </div>
</div>

@push('scripts')
<style>
@media (max-width: 768px) {
    .container > div[style*="grid-template-columns:1fr 380px"] {
        grid-template-columns: 1fr !important;
    }
    .container > div > aside { position: static !important; }
}
</style>
@endpush

@endsection
