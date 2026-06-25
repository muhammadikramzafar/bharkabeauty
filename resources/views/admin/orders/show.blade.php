@extends('layouts.admin')
@section('title','Order — ' . $order->order_number)
@section('page_title','Order Detail')
@section('content')
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

<div class="page-editor-layout">
    <div class="page-editor-main">

        {{-- Items --}}
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title">Order {{ $order->order_number }}</h3>
                <span style="font-size:.8rem;color:#9ca3af;">{{ $order->created_at->format('d M Y, H:i') }}</span>
            </div>
            <table class="admin-table">
                <thead><tr><th>Product</th><th>SKU</th><th>Price</th><th>Qty</th><th>Total</th></tr></thead>
                <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td style="font-weight:600;">{{ $item->product_name }}</td>
                    <td style="font-size:.8rem;color:#9ca3af;">{{ $item->product_sku ?: '—' }}</td>
                    <td>PKR {{ number_format($item->price) }}</td>
                    <td style="font-weight:600;">{{ $item->qty }}</td>
                    <td style="font-weight:700;">PKR {{ number_format($item->total) }}</td>
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                    <tr><td colspan="4" style="text-align:right;padding:10px 20px;font-size:.82rem;color:#6b7280;">Subtotal</td><td style="padding:10px 20px;font-weight:600;">PKR {{ number_format($order->subtotal) }}</td></tr>
                    @if($order->discount > 0)
                    <tr><td colspan="4" style="text-align:right;padding:6px 20px;font-size:.82rem;color:#16a34a;">Discount</td><td style="padding:6px 20px;color:#16a34a;font-weight:600;">− PKR {{ number_format($order->discount) }}</td></tr>
                    @endif
                    <tr><td colspan="4" style="text-align:right;padding:6px 20px;font-size:.82rem;color:#6b7280;">Shipping</td><td style="padding:6px 20px;font-weight:600;">PKR {{ number_format($order->shipping) }}</td></tr>
                    <tr style="background:#faf7f3;"><td colspan="4" style="text-align:right;padding:12px 20px;font-weight:700;">Total</td><td style="padding:12px 20px;font-weight:800;font-size:1.1rem;color:#c9a96e;">PKR {{ number_format($order->total) }}</td></tr>
                </tfoot>
            </table>
        </div>

        {{-- Shipping Address --}}
        @if($order->shipping_address)
        <div class="admin-card">
            <div class="admin-card-header"><h3 class="admin-card-title">Shipping Address</h3></div>
            <div style="padding:1.25rem 1.5rem;font-size:.9rem;line-height:2;">
                @foreach($order->shipping_address as $k => $v)
                @if($v)<p style="margin:0;"><strong style="color:#6b7280;min-width:100px;display:inline-block;">{{ ucfirst(str_replace('_',' ',$k)) }}:</strong> {{ $v }}</p>@endif
                @endforeach
            </div>
        </div>
        @endif

    </div>

    {{-- Sidebar --}}
    <div class="page-editor-sidebar">
        <div class="admin-card">
            <div class="admin-card-header"><h3 class="admin-card-title">Customer</h3></div>
            <div style="padding:1.25rem;">
                <p style="font-weight:700;margin:0 0 .25rem;">{{ $order->user?->name ?? 'Guest' }}</p>
                <p style="font-size:.85rem;color:#6b7280;margin:0;">{{ $order->user?->email }}</p>
                @if($order->user)
                <a href="{{ route('admin.customers.show',$order->user->id) }}" class="btn btn-outline btn-sm btn-full" style="margin-top:.75rem;">View Customer</a>
                @endif
            </div>
        </div>

        <div class="admin-card">
            <div class="admin-card-header"><h3 class="admin-card-title">Update Order</h3></div>
            <form method="POST" action="{{ route('admin.orders.update',$order) }}">
                @csrf @method('PUT')
                <div class="admin-form">
                    <div class="form-group">
                        <label>Order Status</label>
                        <select name="status" class="form-control">
                            @foreach(['pending','confirmed','processing','shipped','delivered','cancelled','refunded'] as $s)
                            <option value="{{ $s }}" {{ $order->status===$s?'selected':'' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Payment Status</label>
                        <select name="payment_status" class="form-control">
                            @foreach(['unpaid','paid','refunded'] as $s)
                            <option value="{{ $s }}" {{ $order->payment_status===$s?'selected':'' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-full">Update</button>
                </div>
            </form>
        </div>

        <div class="admin-card">
            <div class="admin-card-header"><h3 class="admin-card-title">Payment</h3></div>
            <div style="padding:1rem 1.25rem;">
                <p style="margin:.3rem 0;font-size:.875rem;"><strong>Method:</strong> {{ strtoupper($order->payment_method) }}</p>
                <p style="margin:.3rem 0;font-size:.875rem;"><strong>Status:</strong>
                    <span class="status-badge {{ $order->payment_status==='paid'?'badge-published':'badge-new' }}">{{ ucfirst($order->payment_status) }}</span>
                </p>
            </div>
        </div>

        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline btn-full">← Back to Orders</a>
    </div>
</div>
@endsection
