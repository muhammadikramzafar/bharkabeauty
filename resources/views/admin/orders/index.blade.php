@extends('layouts.admin')
@section('title','Orders')
@section('page_title','Orders')
@section('content')

{{-- Status Tabs --}}
<div style="display:flex;gap:.5rem;margin-bottom:1.25rem;flex-wrap:wrap;">
    @php $statuses = ['all'=>'All','pending'=>'Pending','confirmed'=>'Confirmed','processing'=>'Processing','shipped'=>'Shipped','delivered'=>'Delivered','cancelled'=>'Cancelled']; @endphp
    @foreach($statuses as $key => $label)
    <a href="{{ route('admin.orders.index', $key==='all' ? [] : ['status'=>$key]) }}"
       class="btn btn-sm {{ (!request('status') && $key==='all') || request('status')===$key ? 'btn-primary' : 'btn-outline' }}">
        {{ $label }} <span style="opacity:.7;font-size:.75rem;">({{ $counts[$key === 'all' ? 'all' : $key] ?? 0 }})</span>
    </a>
    @endforeach
</div>

<div class="admin-card">
    <table class="admin-table">
        <thead><tr><th>Order #</th><th>Customer</th><th>Date</th><th>Items</th><th>Total</th><th>Payment</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
        @forelse($orders as $order)
        <tr>
            <td style="font-weight:700;color:#c9a96e;">{{ $order->order_number }}</td>
            <td>
                <p style="font-weight:600;margin:0;">{{ $order->user?->name ?? 'Guest' }}</p>
                <p style="font-size:.78rem;color:#9ca3af;margin:0;">{{ $order->user?->email }}</p>
            </td>
            <td style="font-size:.82rem;color:#6b7280;white-space:nowrap;">{{ $order->created_at->format('d M Y') }}<br>{{ $order->created_at->format('H:i') }}</td>
            <td style="font-weight:600;">{{ $order->items->count() ?? '—' }}</td>
            <td style="font-weight:700;">PKR {{ number_format($order->total) }}</td>
            <td>
                <span class="status-badge {{ $order->payment_status==='paid' ? 'badge-published' : ($order->payment_status==='refunded'?'badge-scheduled':'badge-new') }}">
                    {{ ucfirst($order->payment_status) }}
                </span>
                <p style="font-size:.75rem;color:#9ca3af;margin:.2rem 0 0;">{{ strtoupper($order->payment_method) }}</p>
            </td>
            <td>
                <span class="status-badge {{ $order->status_badge_class }}">{{ ucfirst($order->status) }}</span>
            </td>
            <td>
                <a href="{{ route('admin.orders.show',$order) }}" class="btn btn-outline btn-sm">View</a>
            </td>
        </tr>
        @empty
        <tr><td colspan="8" style="text-align:center;padding:3rem;color:#9ca3af;">No orders yet.</td></tr>
        @endforelse
        </tbody>
    </table>
    @if($orders->hasPages())<div class="admin-pagination">{{ $orders->links() }}</div>@endif
</div>
@endsection
