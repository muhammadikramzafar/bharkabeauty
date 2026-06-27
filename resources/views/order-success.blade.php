@extends('layouts.app')

@section('title', 'Order Placed! — BharkaBeauty')

@section('content')

<div class="container" style="max-width:680px;padding:4rem 1.5rem;text-align:center;">

    {{-- Success Icon --}}
    <div style="width:88px;height:88px;background:#d1fae5;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1.75rem;">
        <svg viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
             style="width:42px;height:42px;">
            <path d="M20 6L9 17l-5-5"/>
        </svg>
    </div>

    <h1 style="font-size:1.9rem;font-weight:800;margin-bottom:.5rem;color:var(--color-primary);">Order Placed!</h1>
    <p style="font-size:1rem;color:var(--color-text-muted);margin-bottom:2rem;line-height:1.6;">
        Thank you for shopping with BharkaBeauty.<br>
        A confirmation email has been sent to <strong>{{ auth()->user()->email }}</strong>.
    </p>

    {{-- Order Card --}}
    <div style="background:var(--color-surface);border:1.5px solid var(--color-border);border-radius:var(--radius-xl);padding:2rem;text-align:left;margin-bottom:2rem;">

        <div style="display:flex;justify-content:space-between;align-items:center;padding-bottom:1rem;border-bottom:1px solid var(--color-border);margin-bottom:1.25rem;">
            <div>
                <p style="font-size:.75rem;color:var(--color-text-muted);text-transform:uppercase;letter-spacing:.06em;margin-bottom:3px;">Order Number</p>
                <p style="font-size:1.25rem;font-weight:800;color:var(--color-accent);letter-spacing:.03em;">#{{ $order->order_number }}</p>
            </div>
            <span style="background:#fef3c7;color:#92400e;padding:5px 14px;border-radius:50px;font-size:.78rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;">
                {{ ucfirst($order->status) }}
            </span>
        </div>

        {{-- Items --}}
        <div style="display:flex;flex-direction:column;gap:.75rem;margin-bottom:1.25rem;">
            @foreach($order->items as $item)
            <div style="display:flex;justify-content:space-between;align-items:center;font-size:.9rem;">
                <div>
                    <span style="font-weight:600;">{{ $item->product_name }}</span>
                    <span style="color:var(--color-text-muted);margin-left:.5rem;">×{{ $item->qty }}</span>
                </div>
                <span style="font-weight:600;">PKR {{ number_format($item->total) }}</span>
            </div>
            @endforeach
        </div>

        {{-- Totals --}}
        <div style="border-top:1px solid var(--color-border);padding-top:1rem;display:flex;flex-direction:column;gap:.5rem;">
            <div style="display:flex;justify-content:space-between;font-size:.875rem;color:var(--color-text-muted);">
                <span>Subtotal</span><span>PKR {{ number_format($order->subtotal) }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;font-size:.875rem;color:var(--color-text-muted);">
                <span>Delivery</span>
                <span style="{{ $order->shipping == 0 ? 'color:#16a34a;font-weight:600;' : '' }}">
                    {{ $order->shipping == 0 ? 'Free' : 'PKR '.number_format($order->shipping) }}
                </span>
            </div>
            <div style="display:flex;justify-content:space-between;font-size:1.05rem;font-weight:800;padding-top:.5rem;border-top:2px solid var(--color-primary);">
                <span>Total</span><span>PKR {{ number_format($order->total) }}</span>
            </div>
        </div>

        {{-- Address + Payment --}}
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-top:1.25rem;padding-top:1.25rem;border-top:1px solid var(--color-border);">
            @php $addr = $order->shipping_address ?? []; @endphp
            <div>
                <p style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--color-text-muted);margin-bottom:.4rem;">Delivering To</p>
                <p style="font-size:.875rem;line-height:1.6;margin:0;">
                    <strong>{{ $addr['first_name'] ?? '' }}</strong><br>
                    {{ $addr['address'] ?? '' }}<br>
                    {{ $addr['city'] ?? '' }}@if(!empty($addr['postal_code'])), {{ $addr['postal_code'] }}@endif<br>
                    {{ $addr['phone'] ?? '' }}
                </p>
            </div>
            <div>
                <p style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--color-text-muted);margin-bottom:.4rem;">Payment</p>
                <p style="font-size:.875rem;margin:0;">
                    {{ match($order->payment_method) {
                        'cod'       => '💵 Cash on Delivery',
                        'jazzcash'  => '📱 JazzCash',
                        'easypaisa' => '📱 EasyPaisa',
                        default     => ucfirst($order->payment_method),
                    } }}
                </p>
            </div>
        </div>

    </div>

    {{-- What's next --}}
    <div style="background:var(--color-bg-alt);border-radius:var(--radius-xl);padding:1.5rem;text-align:left;margin-bottom:2rem;">
        <p style="font-weight:700;margin-bottom:1rem;font-size:.9rem;">What happens next?</p>
        <div style="display:flex;flex-direction:column;gap:.75rem;">
            <div style="display:flex;gap:.75rem;align-items:flex-start;font-size:.875rem;">
                <span style="width:26px;height:26px;background:var(--color-accent);color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.75rem;flex-shrink:0;">1</span>
                <span style="padding-top:3px;"><strong>Order Confirmed</strong> — You'll receive an email confirmation shortly.</span>
            </div>
            <div style="display:flex;gap:.75rem;align-items:flex-start;font-size:.875rem;">
                <span style="width:26px;height:26px;background:var(--color-border);color:var(--color-text-muted);border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.75rem;flex-shrink:0;">2</span>
                <span style="padding-top:3px;"><strong>Processing</strong> — We'll prepare and pack your order within 1–2 business days.</span>
            </div>
            <div style="display:flex;gap:.75rem;align-items:flex-start;font-size:.875rem;">
                <span style="width:26px;height:26px;background:var(--color-border);color:var(--color-text-muted);border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.75rem;flex-shrink:0;">3</span>
                <span style="padding-top:3px;"><strong>Shipped</strong> — Delivery within 3–5 business days across Pakistan.</span>
            </div>
        </div>
    </div>

    <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;">
        <a href="{{ route('category.index') }}" class="btn btn-primary btn-lg">Continue Shopping</a>
        <a href="{{ route('home') }}" class="btn btn-outline btn-lg">Back to Home</a>
    </div>

</div>

@endsection
