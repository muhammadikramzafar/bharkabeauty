@extends('layouts.app')
@section('title', 'My Account — BharkaBeauty')

@section('content')

<div class="breadcrumb-bar">
    <div class="container">
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <ol>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li aria-current="page">My Account</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container" style="padding-top:2.5rem;padding-bottom:4rem;display:grid;grid-template-columns:260px 1fr;gap:2rem;align-items:start;">

    {{-- ── Sidebar ──────────────────────────────────────────── --}}
    @include('profile._sidebar')

    {{-- ── Dashboard Content ───────────────────────────────── --}}
    <div>

        {{-- Welcome banner --}}
        <div style="background:linear-gradient(135deg,var(--color-primary) 0%,#4a3520 100%);border-radius:var(--radius-xl);padding:2rem;color:#fff;margin-bottom:1.75rem;position:relative;overflow:hidden;">
            <div style="position:absolute;right:-20px;top:-20px;width:140px;height:140px;border-radius:50%;background:rgba(200,168,130,.15);"></div>
            <p style="font-size:.8rem;letter-spacing:.08em;text-transform:uppercase;opacity:.7;margin-bottom:.4rem;">Welcome back</p>
            <h1 style="font-size:1.6rem;font-weight:800;margin:0 0 .25rem;">{{ $user->name }}</h1>
            <p style="opacity:.7;font-size:.875rem;margin:0;">{{ $user->email }}</p>
        </div>

        {{-- Stats --}}
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;margin-bottom:1.75rem;">
            <div style="background:var(--color-surface);border:1.5px solid var(--color-border);border-radius:var(--radius-xl);padding:1.25rem;text-align:center;">
                <p style="font-size:1.75rem;font-weight:800;color:var(--color-accent);margin:0 0 .25rem;">{{ $count }}</p>
                <p style="font-size:.8rem;color:var(--color-text-muted);margin:0;text-transform:uppercase;letter-spacing:.05em;">Total Orders</p>
            </div>
            <div style="background:var(--color-surface);border:1.5px solid var(--color-border);border-radius:var(--radius-xl);padding:1.25rem;text-align:center;">
                <p style="font-size:1.1rem;font-weight:800;color:var(--color-accent);margin:0 0 .25rem;">PKR {{ number_format($total) }}</p>
                <p style="font-size:.8rem;color:var(--color-text-muted);margin:0;text-transform:uppercase;letter-spacing:.05em;">Total Spent</p>
            </div>
            <div style="background:var(--color-surface);border:1.5px solid var(--color-border);border-radius:var(--radius-xl);padding:1.25rem;text-align:center;">
                <p style="font-size:1.75rem;font-weight:800;color:var(--color-accent);margin:0 0 .25rem;">
                    {{ $orders->where('status','delivered')->count() }}
                </p>
                <p style="font-size:.8rem;color:var(--color-text-muted);margin:0;text-transform:uppercase;letter-spacing:.05em;">Delivered</p>
            </div>
        </div>

        {{-- Recent orders --}}
        <div style="background:var(--color-surface);border:1.5px solid var(--color-border);border-radius:var(--radius-xl);overflow:hidden;">
            <div style="display:flex;justify-content:space-between;align-items:center;padding:1.25rem 1.5rem;border-bottom:1px solid var(--color-border);">
                <h2 style="font-size:1rem;font-weight:700;margin:0;">Recent Orders</h2>
                <a href="{{ route('customer.orders') }}" style="font-size:.825rem;color:var(--color-accent);font-weight:600;">View all →</a>
            </div>

            @forelse($orders as $order)
            <div style="display:flex;align-items:center;justify-content:space-between;padding:1rem 1.5rem;border-bottom:1px solid var(--color-border-soft,#f0ece6);gap:1rem;">
                <div style="flex:1;min-width:0;">
                    <p style="font-weight:700;margin:0 0 .2rem;font-size:.9rem;">#{{ $order->order_number }}</p>
                    <p style="font-size:.78rem;color:var(--color-text-muted);margin:0;">{{ $order->created_at->format('d M Y') }} · {{ $order->items()->count() }} item(s)</p>
                </div>
                <div style="text-align:right;flex-shrink:0;">
                    <p style="font-weight:700;margin:0 0 .25rem;font-size:.9rem;">PKR {{ number_format($order->total) }}</p>
                    @php
                    $colors = ['pending'=>['#fef3c7','#92400e'],'confirmed'=>['#dbeafe','#1e40af'],'processing'=>['#ede9fe','#5b21b6'],'shipped'=>['#cffafe','#0e7490'],'delivered'=>['#d1fae5','#065f46'],'cancelled'=>['#fee2e2','#991b1b'],'refunded'=>['#f3f4f6','#374151']];
                    [$bg,$fg] = $colors[$order->status] ?? ['#f3f4f6','#374151'];
                    @endphp
                    <span style="background:{{ $bg }};color:{{ $fg }};padding:3px 10px;border-radius:50px;font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.04em;">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                <a href="{{ route('customer.orders.detail', $order->order_number) }}"
                   style="font-size:.8rem;color:var(--color-text-muted);white-space:nowrap;">Details →</a>
            </div>
            @empty
            <div style="padding:3rem;text-align:center;color:var(--color-text-muted);">
                <p style="margin-bottom:1rem;">You haven't placed any orders yet.</p>
                <a href="{{ route('category.index') }}" class="btn btn-primary btn-sm">Start Shopping</a>
            </div>
            @endforelse
        </div>

    </div>
</div>

@endsection
