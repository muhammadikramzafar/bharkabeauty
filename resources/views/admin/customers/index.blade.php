@extends('layouts.admin')
@section('title','Customers')
@section('page_title','Customers')
@section('content')

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem;gap:1rem;flex-wrap:wrap;">
    <form method="GET" style="display:flex;gap:.5rem;flex:1;flex-wrap:wrap;">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name or email…" class="form-control" style="max-width:280px;">
        <button type="submit" class="btn btn-outline btn-sm">Search</button>
        @if(request('search'))<a href="{{ route('admin.customers.index') }}" class="btn btn-outline btn-sm">Clear</a>@endif
    </form>
    <p style="font-size:.875rem;color:#6b7280;margin:0;">{{ $customers->total() }} customers</p>
</div>

<div class="admin-card">
    <table class="admin-table">
        <thead><tr><th>Name</th><th>Email</th><th>Orders</th><th>Joined</th><th>Actions</th></tr></thead>
        <tbody>
        @forelse($customers as $customer)
        <tr>
            <td>
                <div style="display:flex;align-items:center;gap:.75rem;">
                    <div style="width:36px;height:36px;border-radius:50%;background:#f5f0ea;display:flex;align-items:center;justify-content:center;color:#c9a96e;font-weight:700;font-size:.9rem;flex-shrink:0;">
                        {{ strtoupper(substr($customer->name,0,1)) }}
                    </div>
                    <span style="font-weight:600;">{{ $customer->name }}</span>
                </div>
            </td>
            <td style="color:#6b7280;font-size:.875rem;">{{ $customer->email }}</td>
            <td style="font-weight:700;color:{{ $customer->orders_count > 0 ? '#c9a96e' : '#9ca3af' }};">{{ $customer->orders_count }}</td>
            <td style="font-size:.82rem;color:#9ca3af;">{{ $customer->created_at->format('d M Y') }}</td>
            <td>
                <a href="{{ route('admin.customers.show',$customer->id) }}" class="btn btn-outline btn-sm">View</a>
            </td>
        </tr>
        @empty
        <tr><td colspan="5" style="text-align:center;padding:3rem;color:#9ca3af;">No customers yet.</td></tr>
        @endforelse
        </tbody>
    </table>
    @if($customers->hasPages())<div class="admin-pagination">{{ $customers->links() }}</div>@endif
</div>
@endsection
