@extends('layouts.admin')
@section('title','Customer — ' . $customer->name)
@section('page_title','Customer Profile')
@section('content')

<div class="page-editor-layout">
    <div class="page-editor-main">
        <div class="admin-card">
            <div class="admin-card-header"><h3 class="admin-card-title">Recent Orders</h3></div>
            @if($orders->isEmpty())
            <div style="padding:2.5rem;text-align:center;color:#9ca3af;">No orders placed yet.</div>
            @else
            <table class="admin-table">
                <thead><tr><th>Order #</th><th>Date</th><th>Total</th><th>Status</th><th></th></tr></thead>
                <tbody>
                @foreach($orders as $order)
                <tr>
                    <td style="font-weight:700;color:#c9a96e;">{{ $order->order_number }}</td>
                    <td style="font-size:.82rem;color:#6b7280;">{{ $order->created_at->format('d M Y') }}</td>
                    <td style="font-weight:700;">PKR {{ number_format($order->total) }}</td>
                    <td><span class="status-badge {{ $order->status_badge_class }}">{{ ucfirst($order->status) }}</span></td>
                    <td><a href="{{ route('admin.orders.show',$order) }}" class="btn btn-outline btn-sm">View</a></td>
                </tr>
                @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>

    <div class="page-editor-sidebar">
        <div class="admin-card">
            <div class="admin-card-header"><h3 class="admin-card-title">Customer Info</h3></div>
            <div style="padding:1.25rem;">
                <div style="width:56px;height:56px;border-radius:50%;background:linear-gradient(135deg,#c9a96e,#a07840);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:800;font-size:1.2rem;margin-bottom:1rem;">
                    {{ strtoupper(substr($customer->name,0,1)) }}
                </div>
                <p style="font-weight:700;font-size:1rem;margin:.25rem 0;">{{ $customer->name }}</p>
                <p style="font-size:.85rem;color:#6b7280;margin:0 0 1rem;">{{ $customer->email }}</p>
                <div style="border-top:1px solid #f5f0ea;padding-top:1rem;">
                    <div style="display:flex;justify-content:space-between;padding:.4rem 0;font-size:.875rem;border-bottom:1px solid #faf7f3;">
                        <span style="color:#6b7280;">Total Orders</span>
                        <strong>{{ $customer->orders_count }}</strong>
                    </div>
                    <div style="display:flex;justify-content:space-between;padding:.4rem 0;font-size:.875rem;border-bottom:1px solid #faf7f3;">
                        <span style="color:#6b7280;">Joined</span>
                        <strong>{{ $customer->created_at->format('d M Y') }}</strong>
                    </div>
                </div>
            </div>
        </div>
        <a href="{{ route('admin.customers.index') }}" class="btn btn-outline btn-full">← All Customers</a>
    </div>
</div>
@endsection
