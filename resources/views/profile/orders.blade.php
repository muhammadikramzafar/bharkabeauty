@extends('layouts.app')
@section('title', 'My Orders — BharkaBeauty')

@section('content')

<div class="breadcrumb-bar">
    <div class="container">
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <ol>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('customer.dashboard') }}">My Account</a></li>
                <li aria-current="page">Orders</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container" style="padding-top:2.5rem;padding-bottom:4rem;display:grid;grid-template-columns:260px 1fr;gap:2rem;align-items:start;">

    @include('profile._sidebar')

    <div>
        <h1 style="font-size:1.4rem;font-weight:800;margin-bottom:1.5rem;">My Orders</h1>

        @forelse($orders as $order)
        @php
            $colors = ['pending'=>['#fef3c7','#92400e'],'confirmed'=>['#dbeafe','#1e40af'],'processing'=>['#ede9fe','#5b21b6'],'shipped'=>['#cffafe','#0e7490'],'delivered'=>['#d1fae5','#065f46'],'cancelled'=>['#fee2e2','#991b1b'],'refunded'=>['#f3f4f6','#374151']];
            [$bg,$fg] = $colors[$order->status] ?? ['#f3f4f6','#374151'];
            $steps = ['pending','confirmed','processing','shipped','delivered'];
            $currentStep = array_search($order->status, $steps);
        @endphp

        <div style="background:var(--color-surface);border:1.5px solid var(--color-border);border-radius:var(--radius-xl);margin-bottom:1.25rem;overflow:hidden;">

            {{-- Order header --}}
            <div style="display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:.75rem;padding:1.1rem 1.5rem;background:var(--color-bg-alt);border-bottom:1px solid var(--color-border);">
                <div style="display:flex;gap:2rem;flex-wrap:wrap;">
                    <div>
                        <p style="font-size:.7rem;color:var(--color-text-muted);text-transform:uppercase;letter-spacing:.05em;margin:0 0 2px;">Order</p>
                        <p style="font-weight:800;margin:0;font-size:.95rem;color:var(--color-accent);">#{{ $order->order_number }}</p>
                    </div>
                    <div>
                        <p style="font-size:.7rem;color:var(--color-text-muted);text-transform:uppercase;letter-spacing:.05em;margin:0 0 2px;">Placed</p>
                        <p style="font-weight:600;margin:0;font-size:.875rem;">{{ $order->created_at->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p style="font-size:.7rem;color:var(--color-text-muted);text-transform:uppercase;letter-spacing:.05em;margin:0 0 2px;">Total</p>
                        <p style="font-weight:700;margin:0;font-size:.875rem;">PKR {{ number_format($order->total) }}</p>
                    </div>
                </div>
                <div style="display:flex;align-items:center;gap:.75rem;">
                    <span style="background:{{ $bg }};color:{{ $fg }};padding:4px 12px;border-radius:50px;font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.04em;">
                        {{ ucfirst($order->status) }}
                    </span>
                    <a href="{{ route('customer.orders.detail', $order->order_number) }}"
                       style="font-size:.825rem;color:var(--color-accent);font-weight:600;">View →</a>
                </div>
            </div>

            {{-- Delivery progress (only for active orders) --}}
            @if(!in_array($order->status, ['cancelled','refunded']) && $currentStep !== false)
            <div style="padding:1rem 1.5rem;">
                <div style="display:flex;align-items:center;gap:0;">
                    @foreach($steps as $i => $step)
                    @php $done = $i <= $currentStep; $active = $i === $currentStep; @endphp
                    <div style="display:flex;align-items:center;flex:1;">
                        <div style="display:flex;flex-direction:column;align-items:center;flex-shrink:0;">
                            <div style="width:28px;height:28px;border-radius:50%;background:{{ $done ? 'var(--color-accent)' : 'var(--color-border)' }};display:flex;align-items:center;justify-content:center;font-size:.65rem;font-weight:700;color:{{ $done ? '#fff' : 'var(--color-text-muted)' }};">
                                @if($done && !$active)
                                ✓
                                @else
                                {{ $i+1 }}
                                @endif
                            </div>
                            <span style="font-size:.65rem;margin-top:4px;color:{{ $active ? 'var(--color-accent)' : 'var(--color-text-muted)' }};font-weight:{{ $active ? '700' : '400' }};white-space:nowrap;">{{ ucfirst($step) }}</span>
                        </div>
                        @if($i < count($steps)-1)
                        <div style="flex:1;height:2px;background:{{ $i < $currentStep ? 'var(--color-accent)' : 'var(--color-border)' }};margin:0 4px;margin-bottom:18px;"></div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Items preview --}}
            <div style="padding:.75rem 1.5rem 1rem;display:flex;gap:.75rem;align-items:center;flex-wrap:wrap;">
                @foreach($order->items()->take(3)->get() as $item)
                <div style="display:flex;align-items:center;gap:.5rem;background:var(--color-bg-alt);border-radius:8px;padding:.4rem .75rem;font-size:.8rem;">
                    <span style="font-weight:600;">{{ $item->product_name }}</span>
                    <span style="color:var(--color-text-muted);">×{{ $item->qty }}</span>
                </div>
                @endforeach
                @if($order->items()->count() > 3)
                <span style="font-size:.8rem;color:var(--color-text-muted);">+{{ $order->items()->count()-3 }} more</span>
                @endif
            </div>

        </div>
        @empty
        <div style="background:var(--color-surface);border:1.5px solid var(--color-border);border-radius:var(--radius-xl);padding:4rem;text-align:center;">
            <p style="color:var(--color-text-muted);margin-bottom:1.25rem;">You haven't placed any orders yet.</p>
            <a href="{{ route('category.index') }}" class="btn btn-primary btn-md">Start Shopping</a>
        </div>
        @endforelse

        {{ $orders->links() }}
    </div>
</div>

@endsection
