@extends('layouts.app')

@section('title', 'Checkout — AmsazBeauty')

@section('content')

<div class="container checkout-layout">

    {{-- ── LEFT: Steps + Form ──────────────────────────────────── --}}
    <div>

        {{-- Progress Steps --}}
        <div class="checkout-steps">
            <div class="checkout-step {{ $step >= 1 ? 'active' : '' }} {{ $step > 1 ? 'done' : '' }}">
                <span class="step-num">{{ $step > 1 ? '✓' : '1' }}</span>
                <span>Address</span>
            </div>
            <div class="checkout-step {{ $step >= 2 ? 'active' : '' }} {{ $step > 2 ? 'done' : '' }}">
                <span class="step-num">{{ $step > 2 ? '✓' : '2' }}</span>
                <span>Delivery</span>
            </div>
            <div class="checkout-step {{ $step >= 3 ? 'active' : '' }}">
                <span class="step-num">3</span>
                <span>Payment</span>
            </div>
        </div>

        {{-- Validation Errors --}}
        @if($errors->any())
            <div style="background:#fee2e2;color:#991b1b;border-radius:10px;padding:1rem 1.25rem;margin-bottom:1.5rem;font-size:.875rem;">
                <ul style="margin:0;padding-left:1.25rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ── STEP 1: Address ─────────────────────────────────── --}}
        @if($step == 1)
        <div style="background:var(--color-surface);border:1.5px solid var(--color-border);border-radius:var(--radius-xl);padding:2rem;">
            <h2 class="checkout-section-title">Delivery Address</h2>

            <form method="POST" action="{{ route('checkout.address') }}">
                @csrf

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label" for="first_name">Full Name <span style="color:#dc2626;">*</span></label>
                        <input class="form-input{{ $errors->has('first_name') ? ' is-invalid' : '' }}" type="text" id="first_name" name="first_name"
                               value="{{ old('first_name', $address['first_name'] ?? auth()->user()?->name ?? '') }}"
                               placeholder="Muhammad Ali">
                        @error('first_name')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="phone">Mobile Number <span style="color:#dc2626;">*</span></label>
                        <input class="form-input{{ $errors->has('phone') ? ' is-invalid' : '' }}" type="tel" id="phone" name="phone"
                               value="{{ old('phone', $address['phone'] ?? auth()->user()?->phone ?? '') }}"
                               placeholder="03001234567">
                        @error('phone')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="form-group" style="margin-bottom:1.25rem;">
                    <label class="form-label" for="email">Email Address <span style="color:#dc2626;">*</span></label>
                    <input class="form-input{{ $errors->has('email') ? ' is-invalid' : '' }}" type="email" id="email" name="email"
                           value="{{ old('email', $address['email'] ?? auth()->user()?->email ?? '') }}"
                           placeholder="you@example.com">
                    @error('email')<p class="field-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group" style="margin-bottom:1.25rem;">
                    <label class="form-label" for="address">Street Address <span style="color:#dc2626;">*</span></label>
                    <input class="form-input{{ $errors->has('address') ? ' is-invalid' : '' }}" type="text" id="address" name="address"
                           value="{{ old('address', $address['address'] ?? '') }}"
                           placeholder="House No., Street, Area">
                    @error('address')<p class="field-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label" for="city">City <span style="color:#dc2626;">*</span></label>
                        <input class="form-input{{ $errors->has('city') ? ' is-invalid' : '' }}" type="text" id="city" name="city"
                               value="{{ old('city', $address['city'] ?? '') }}"
                               placeholder="Lahore">
                        @error('city')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="postal_code">Postal Code</label>
                        <input class="form-input" type="text" id="postal_code" name="postal_code"
                               value="{{ old('postal_code', $address['postal_code'] ?? '') }}"
                               placeholder="54000">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-lg" style="width:100%;margin-top:.5rem;">
                    Continue to Delivery →
                </button>
            </form>
        </div>

        {{-- ── STEP 2: Delivery ────────────────────────────────── --}}
        @elseif($step == 2)
        <div style="background:var(--color-surface);border:1.5px solid var(--color-border);border-radius:var(--radius-xl);padding:2rem;">
            <h2 class="checkout-section-title">Choose Delivery Method</h2>

            {{-- Saved address summary --}}
            @if(session('checkout_address'))
            @php $addr = session('checkout_address'); @endphp
            <div style="background:var(--color-bg-alt);border-radius:10px;padding:1rem 1.25rem;margin-bottom:1.75rem;font-size:.875rem;display:flex;justify-content:space-between;align-items:center;">
                <div>
                    <strong>{{ $addr['first_name'] }}</strong><br>
                    <span style="color:var(--color-text-muted);">{{ $addr['address'] }}, {{ $addr['city'] }}</span><br>
                    <span style="color:var(--color-text-muted);">{{ $addr['phone'] }} · {{ $addr['email'] ?? '' }}</span>
                </div>
                <a href="{{ route('checkout') }}" style="font-size:.8rem;color:var(--color-accent);">Edit</a>
            </div>
            @endif

            <form method="POST" action="{{ route('checkout.delivery') }}">
                @csrf
                <div class="payment-methods">
                    <label class="payment-option" style="cursor:pointer;">
                        <input type="radio" name="delivery_method" value="standard" checked style="accent-color:var(--color-accent);">
                        <div style="flex:1;">
                            <strong>Standard Delivery</strong>
                            <p style="margin:.2rem 0 0;font-size:.8rem;color:var(--color-text-muted);">3–5 business days · {{ $subtotal >= 2000 ? 'Free' : 'PKR 150' }}</p>
                        </div>
                        <span style="font-weight:600;">{{ $subtotal >= 2000 ? 'Free' : 'PKR 150' }}</span>
                    </label>
                    <label class="payment-option" style="cursor:pointer;">
                        <input type="radio" name="delivery_method" value="express" style="accent-color:var(--color-accent);">
                        <div style="flex:1;">
                            <strong>Express Delivery</strong>
                            <p style="margin:.2rem 0 0;font-size:.8rem;color:var(--color-text-muted);">1–2 business days</p>
                        </div>
                        <span style="font-weight:600;">PKR 300</span>
                    </label>
                    <label class="payment-option" style="cursor:pointer;">
                        <input type="radio" name="delivery_method" value="same_day" style="accent-color:var(--color-accent);">
                        <div style="flex:1;">
                            <strong>Same-Day Delivery</strong>
                            <p style="margin:.2rem 0 0;font-size:.8rem;color:var(--color-text-muted);">Within Lahore only</p>
                        </div>
                        <span style="font-weight:600;">PKR 500</span>
                    </label>
                </div>
                <button type="submit" class="btn btn-primary btn-lg" style="width:100%;">
                    Continue to Payment →
                </button>
            </form>
        </div>

        {{-- ── STEP 3: Payment ─────────────────────────────────── --}}
        @elseif($step == 3)
        <div style="background:var(--color-surface);border:1.5px solid var(--color-border);border-radius:var(--radius-xl);padding:2rem;">
            <h2 class="checkout-section-title">Payment Method</h2>

            <form method="POST" action="{{ route('checkout.place-order') }}">
                @csrf
                <div class="payment-methods">
                    <label class="payment-option" style="cursor:pointer;">
                        <input type="radio" name="payment_method" value="cod" checked style="accent-color:var(--color-accent);">
                        <div style="flex:1;">
                            <strong>Cash on Delivery</strong>
                            <p style="margin:.2rem 0 0;font-size:.8rem;color:var(--color-text-muted);">Pay when your order arrives</p>
                        </div>
                    </label>
                    <label class="payment-option" style="cursor:pointer;">
                        <input type="radio" name="payment_method" value="jazzcash" style="accent-color:var(--color-accent);">
                        <div style="flex:1;">
                            <strong>JazzCash</strong>
                            <p style="margin:.2rem 0 0;font-size:.8rem;color:var(--color-text-muted);">Mobile wallet payment</p>
                        </div>
                    </label>
                    <label class="payment-option" style="cursor:pointer;">
                        <input type="radio" name="payment_method" value="easypaisa" style="accent-color:var(--color-accent);">
                        <div style="flex:1;">
                            <strong>EasyPaisa</strong>
                            <p style="margin:.2rem 0 0;font-size:.8rem;color:var(--color-text-muted);">Mobile wallet payment</p>
                        </div>
                    </label>
                </div>

                {{-- Order confirmation summary --}}
                @if(session('checkout_address'))
                @php $addr = session('checkout_address'); @endphp
                <div style="background:var(--color-bg-alt);border-radius:10px;padding:1rem 1.25rem;margin-bottom:1.5rem;font-size:.875rem;">
                    <p style="font-weight:600;margin-bottom:.4rem;">Delivering to:</p>
                    <p style="color:var(--color-text-muted);margin:0;">{{ $addr['first_name'] }}, {{ $addr['address'] }}, {{ $addr['city'] }} · {{ $addr['phone'] }}</p>
                </div>
                @endif

                <button type="submit" class="btn btn-primary btn-lg" style="width:100%;">
                    Place Order
                </button>

                <p style="text-align:center;font-size:.78rem;color:var(--color-text-muted);margin-top:1rem;">
                    By placing your order you agree to our
                    <a href="#" style="color:var(--color-accent);">Terms &amp; Conditions</a>
                </p>
            </form>
        </div>
        @endif

    </div>

    {{-- ── RIGHT: Order Summary ─────────────────────────────────── --}}
    <aside style="background:var(--color-surface);border:1.5px solid var(--color-border);border-radius:var(--radius-xl);padding:1.75rem;position:sticky;top:calc(var(--header-height,80px) + 20px);">

        <h3 style="font-size:1.1rem;font-weight:700;margin-bottom:1.25rem;padding-bottom:.75rem;border-bottom:1px solid var(--color-border);">
            Order Summary
        </h3>

        {{-- Cart items --}}
        <div style="display:flex;flex-direction:column;gap:.75rem;margin-bottom:1.25rem;">
            @forelse($items ?? [] as $item)
            <div style="display:flex;gap:.75rem;align-items:center;">
                <div style="position:relative;flex-shrink:0;">
                    <img src="{{ $item['image'] ?? 'https://images.unsplash.com/photo-1583241800698-e8ab01830a22?w=100&h=100&fit=crop' }}"
                         alt="{{ $item['name'] }}"
                         style="width:52px;height:52px;border-radius:8px;object-fit:cover;border:1px solid var(--color-border);">
                    <span style="position:absolute;top:-6px;right:-6px;background:var(--color-text);color:#fff;border-radius:50%;width:18px;height:18px;font-size:.65rem;display:flex;align-items:center;justify-content:center;font-weight:700;">
                        {{ $item['quantity'] }}
                    </span>
                </div>
                <div style="flex:1;min-width:0;">
                    <p style="font-size:.825rem;font-weight:600;margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $item['name'] }}</p>
                    <p style="font-size:.75rem;color:var(--color-text-muted);margin:2px 0 0;">{{ $item['brand'] ?? '' }}</p>
                </div>
                <span style="font-size:.85rem;font-weight:600;white-space:nowrap;">
                    PKR {{ number_format($item['price'] * $item['quantity']) }}
                </span>
            </div>
            @empty
            <p style="font-size:.85rem;color:var(--color-text-muted);">No items in bag.</p>
            @endforelse
        </div>

        {{-- Totals --}}
        <div style="border-top:1px solid var(--color-border);padding-top:1rem;display:flex;flex-direction:column;gap:.6rem;">
            <div style="display:flex;justify-content:space-between;font-size:.875rem;">
                <span style="color:var(--color-text-muted);">Subtotal</span>
                <span>PKR {{ number_format($subtotal ?? 0) }}</span>
            </div>
            @if(($couponDiscount ?? 0) > 0)
            <div style="display:flex;justify-content:space-between;font-size:.875rem;">
                <span style="color:#16a34a;font-weight:600;">Coupon ({{ $coupon['code'] }})</span>
                <span style="color:#16a34a;font-weight:700;">− PKR {{ number_format($couponDiscount) }}</span>
            </div>
            @endif
            <div style="display:flex;justify-content:space-between;font-size:.875rem;">
                <span style="color:var(--color-text-muted);">Delivery</span>
                <span style="{{ ($delivery ?? 0) == 0 ? 'color:var(--color-success,#16a34a);font-weight:600;' : '' }}">
                    {{ ($delivery ?? 0) == 0 ? 'Free' : 'PKR '.number_format($delivery) }}
                </span>
            </div>
            <div style="display:flex;justify-content:space-between;font-size:1rem;font-weight:700;padding-top:.6rem;border-top:2px solid var(--color-primary);">
                <span>Total</span>
                <span>PKR {{ number_format(($subtotal ?? 0) - ($couponDiscount ?? 0) + ($delivery ?? 0)) }}</span>
            </div>
        </div>

        {{-- Trust --}}
        <div style="margin-top:1.25rem;padding-top:1rem;border-top:1px solid var(--color-border-soft);display:flex;flex-direction:column;gap:.5rem;">
            <div style="display:flex;align-items:center;gap:.5rem;font-size:.75rem;color:var(--color-text-muted);">
                <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" style="width:15px;height:15px;flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                Secure SSL checkout
            </div>
            <div style="display:flex;align-items:center;gap:.5rem;font-size:.75rem;color:var(--color-text-muted);">
                <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" style="width:15px;height:15px;flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                Free returns within 7 days
            </div>
            <div style="display:flex;align-items:center;gap:.5rem;font-size:.75rem;color:var(--color-text-muted);">
                <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" style="width:15px;height:15px;flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z"/></svg>
                100% authentic products
            </div>
        </div>

    </aside>

</div>

@endsection
