@extends('layouts.app')
@section('title', 'Order #'.$order->order_number.' — AmsazBeauty')

@section('content')

<div class="breadcrumb-bar">
    <div class="container">
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <ol>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('customer.dashboard') }}">My Account</a></li>
                <li><a href="{{ route('customer.orders') }}">Orders</a></li>
                <li aria-current="page">#{{ $order->order_number }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container" style="padding-top:2.5rem;padding-bottom:4rem;display:grid;grid-template-columns:260px 1fr;gap:2rem;align-items:start;">

    @include('profile._sidebar')

    <div>
        {{-- Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;flex-wrap:wrap;gap:.75rem;">
            <div>
                <h1 style="font-size:1.4rem;font-weight:800;margin:0 0 .2rem;">Order #{{ $order->order_number }}</h1>
                <p style="font-size:.875rem;color:var(--color-text-muted);margin:0;">Placed on {{ $order->created_at->format('d M Y \a\t h:i A') }}</p>
            </div>
            @php
            $colors = ['pending'=>['#fef3c7','#92400e'],'confirmed'=>['#dbeafe','#1e40af'],'processing'=>['#ede9fe','#5b21b6'],'shipped'=>['#cffafe','#0e7490'],'delivered'=>['#d1fae5','#065f46'],'cancelled'=>['#fee2e2','#991b1b'],'refunded'=>['#f3f4f6','#374151']];
            [$bg,$fg] = $colors[$order->status] ?? ['#f3f4f6','#374151'];
            $steps = ['pending','confirmed','processing','shipped','delivered'];
            $currentStep = array_search($order->status, $steps);
            @endphp
            <span style="background:{{ $bg }};color:{{ $fg }};padding:6px 18px;border-radius:50px;font-size:.8rem;font-weight:700;text-transform:uppercase;letter-spacing:.04em;">
                {{ ucfirst($order->status) }}
            </span>
        </div>

        {{-- Delivery progress --}}
        @if(!in_array($order->status, ['cancelled','refunded']) && $currentStep !== false)
        <div style="background:var(--color-surface);border:1.5px solid var(--color-border);border-radius:var(--radius-xl);padding:1.5rem;margin-bottom:1.5rem;">
            <h3 style="font-size:.8rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--color-text-muted);margin-bottom:1.5rem;">Delivery Status</h3>
            <div style="display:flex;align-items:flex-start;gap:0;">
                @foreach($steps as $i => $step)
                @php $done = $i <= $currentStep; $active = $i === $currentStep; @endphp
                <div style="display:flex;align-items:center;flex:1;">
                    <div style="display:flex;flex-direction:column;align-items:center;">
                        <div style="width:36px;height:36px;border-radius:50%;background:{{ $done ? 'var(--color-accent)' : 'var(--color-border)' }};display:flex;align-items:center;justify-content:center;font-size:.75rem;font-weight:700;color:{{ $done ? '#fff' : 'var(--color-text-muted)' }};border:2px solid {{ $active ? 'var(--color-accent)' : 'transparent' }};box-shadow:{{ $active ? '0 0 0 4px rgba(200,168,130,.2)' : 'none' }};">
                            @if($done && !$active)✓@else{{ $i+1 }}@endif
                        </div>
                        <span style="font-size:.72rem;margin-top:6px;color:{{ $active ? 'var(--color-text)' : 'var(--color-text-muted)' }};font-weight:{{ $active ? '700' : '400' }};white-space:nowrap;text-align:center;">
                            {{ ucfirst($step) }}
                        </span>
                    </div>
                    @if($i < count($steps)-1)
                    <div style="flex:1;height:2px;background:{{ $i < $currentStep ? 'var(--color-accent)' : 'var(--color-border)' }};margin:0 6px;margin-bottom:22px;"></div>
                    @endif
                </div>
                @endforeach
            </div>

            @php
            $messages = ['pending'=>'Your order has been received and is awaiting confirmation.','confirmed'=>'Your order is confirmed and will be prepared soon.','processing'=>'Your order is being packed and prepared for shipment.','shipped'=>'Your order is on its way! Expected delivery within 1–3 days.','delivered'=>'Your order has been delivered. Enjoy your purchase!'];
            @endphp
            <p style="background:var(--color-bg-alt);border-radius:8px;padding:.75rem 1rem;font-size:.85rem;color:var(--color-text-muted);margin:1.25rem 0 0;">
                {{ $messages[$order->status] ?? '' }}
            </p>
        </div>
        @endif

        {{-- Items + Summary row --}}
        <div style="display:grid;grid-template-columns:1fr 320px;gap:1.25rem;align-items:start;">

            {{-- Items --}}
            <div style="background:var(--color-surface);border:1.5px solid var(--color-border);border-radius:var(--radius-xl);overflow:hidden;">
                <div style="padding:1rem 1.5rem;border-bottom:1px solid var(--color-border);">
                    <h3 style="font-size:.9rem;font-weight:700;margin:0;">Items Ordered ({{ $order->items->count() }})</h3>
                </div>
                @foreach($order->items as $item)
                <div style="display:flex;align-items:center;gap:1rem;padding:1rem 1.5rem;border-bottom:1px solid var(--color-border-soft,#f0ece6);">
                    @if($item->product && $item->product->main_image)
                    <img src="{{ $item->product->main_image }}" alt="{{ $item->product_name }}"
                         style="width:56px;height:56px;object-fit:cover;border-radius:8px;flex-shrink:0;border:1px solid var(--color-border);">
                    @else
                    <div style="width:56px;height:56px;background:var(--color-bg-alt);border-radius:8px;flex-shrink:0;"></div>
                    @endif
                    <div style="flex:1;min-width:0;">
                        <p style="font-weight:600;margin:0 0 .2rem;font-size:.9rem;">{{ $item->product_name }}</p>
                        <p style="font-size:.8rem;color:var(--color-text-muted);margin:0;">
                            PKR {{ number_format($item->price) }} × {{ $item->qty }}
                        </p>
                    </div>
                    <p style="font-weight:700;margin:0;white-space:nowrap;font-size:.9rem;">PKR {{ number_format($item->total) }}</p>
                </div>
                @endforeach
            </div>

            {{-- Summary --}}
            <div style="display:flex;flex-direction:column;gap:1rem;">

                {{-- Totals --}}
                <div style="background:var(--color-surface);border:1.5px solid var(--color-border);border-radius:var(--radius-xl);padding:1.25rem;">
                    <h3 style="font-size:.8rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--color-text-muted);margin-bottom:1rem;">Order Summary</h3>
                    <div style="display:flex;justify-content:space-between;font-size:.875rem;margin-bottom:.6rem;color:var(--color-text-muted);">
                        <span>Subtotal</span><span>PKR {{ number_format($order->subtotal) }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;font-size:.875rem;margin-bottom:.6rem;color:var(--color-text-muted);">
                        <span>Delivery</span>
                        <span style="{{ $order->shipping == 0 ? 'color:#16a34a;font-weight:600;' : '' }}">
                            {{ $order->shipping == 0 ? 'Free' : 'PKR '.number_format($order->shipping) }}
                        </span>
                    </div>
                    @if($order->discount > 0)
                    <div style="display:flex;justify-content:space-between;font-size:.875rem;margin-bottom:.6rem;color:#059669;">
                        <span>Discount</span><span>− PKR {{ number_format($order->discount) }}</span>
                    </div>
                    @endif
                    <div style="display:flex;justify-content:space-between;font-size:1rem;font-weight:800;padding-top:.75rem;border-top:2px solid var(--color-primary);margin-top:.5rem;">
                        <span>Total</span><span>PKR {{ number_format($order->total) }}</span>
                    </div>
                </div>

                {{-- Payment --}}
                <div style="background:var(--color-surface);border:1.5px solid var(--color-border);border-radius:var(--radius-xl);padding:1.25rem;">
                    <h3 style="font-size:.8rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--color-text-muted);margin-bottom:.75rem;">Payment</h3>
                    <p style="font-size:.9rem;font-weight:600;margin:0 0 .3rem;">
                        {{ match($order->payment_method) {'cod'=>'💵 Cash on Delivery','jazzcash'=>'📱 JazzCash','easypaisa'=>'📱 EasyPaisa',default=>ucfirst($order->payment_method)} }}
                    </p>
                    <p style="font-size:.8rem;color:var(--color-text-muted);margin:0;">Status: {{ ucfirst($order->payment_status) }}</p>
                </div>

                {{-- Delivery address --}}
                @if($order->shipping_address)
                @php $addr = $order->shipping_address; @endphp
                <div style="background:var(--color-surface);border:1.5px solid var(--color-border);border-radius:var(--radius-xl);padding:1.25rem;">
                    <h3 style="font-size:.8rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--color-text-muted);margin-bottom:.75rem;">Delivery Address</h3>
                    <p style="font-size:.875rem;line-height:1.7;margin:0;">
                        <strong>{{ $addr['first_name'] ?? '' }}</strong><br>
                        {{ $addr['address'] ?? '' }}<br>
                        {{ $addr['city'] ?? '' }}@if(!empty($addr['postal_code'])), {{ $addr['postal_code'] }}@endif<br>
                        {{ $addr['phone'] ?? '' }}
                    </p>
                </div>
                @endif

            </div>
        </div>

        <div style="margin-top:1.5rem;">
            <a href="{{ route('customer.orders') }}" style="color:var(--color-text-muted);font-size:.875rem;">← Back to orders</a>
        </div>
    </div>
</div>

@endsection
