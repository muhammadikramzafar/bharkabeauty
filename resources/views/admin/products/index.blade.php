@extends('layouts.admin')
@section('title','Products')
@section('page_title','Products')
@section('content')
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem;gap:1rem;flex-wrap:wrap;">
    <form method="GET" style="display:flex;gap:.5rem;flex-wrap:wrap;flex:1;">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name or SKU…" class="form-control" style="max-width:220px;">
        <select name="category" class="form-control" style="max-width:160px;">
            <option value="">All Categories</option>
            @foreach($categories as $c)<option value="{{ $c->id }}" {{ request('category')==$c->id?'selected':'' }}>{{ $c->name }}</option>@endforeach
        </select>
        <select name="brand" class="form-control" style="max-width:140px;">
            <option value="">All Brands</option>
            @foreach($brands as $b)<option value="{{ $b->id }}" {{ request('brand')==$b->id?'selected':'' }}>{{ $b->name }}</option>@endforeach
        </select>
        <select name="status" class="form-control" style="max-width:130px;">
            <option value="">All Status</option>
            <option value="active"   {{ request('status')=='active'?'selected':'' }}>Active</option>
            <option value="inactive" {{ request('status')=='inactive'?'selected':'' }}>Inactive</option>
        </select>
        <button type="submit" class="btn btn-outline btn-sm">Filter</button>
        @if(request()->hasAny(['search','category','brand','status']))<a href="{{ route('admin.products.index') }}" class="btn btn-outline btn-sm">Clear</a>@endif
    </form>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">+ Add Product</a>
</div>

<div class="admin-card">
    <table class="admin-table">
        <thead><tr><th>Image</th><th>Name</th><th>SKU</th><th>Category</th><th>Brand</th><th>Price</th><th>Stock</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
        @forelse($products as $p)
        <tr>
            <td>
                @if($p->first_image_url)
                    <img src="{{ $p->first_image_url }}" style="width:48px;height:48px;object-fit:cover;border-radius:8px;">
                @else
                    <div style="width:48px;height:48px;background:#f5f0ea;border-radius:8px;display:flex;align-items:center;justify-content:center;color:#c9a96e;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="20"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    </div>
                @endif
            </td>
            <td>
                <p style="font-weight:600;margin:0;">{{ $p->name }}</p>
                @if($p->is_featured)<span class="status-badge badge-scheduled" style="font-size:.65rem;">Featured</span>@endif
            </td>
            <td style="color:#9ca3af;font-size:.82rem;">{{ $p->sku ?: '—' }}</td>
            <td style="font-size:.85rem;">{{ $p->category?->name ?? '—' }}</td>
            <td style="font-size:.85rem;">{{ $p->brand?->name ?? '—' }}</td>
            <td>
                <p style="font-weight:700;margin:0;">PKR {{ number_format($p->price) }}</p>
                @if($p->is_on_sale)<p style="font-size:.78rem;color:#16a34a;margin:0;">Sale: PKR {{ number_format($p->sale_price) }}</p>@endif
            </td>
            <td>
                <span style="font-weight:600;color:{{ $p->stock_qty > 0 ? '#16a34a' : '#ef4444' }};">{{ $p->stock_qty }}</span>
            </td>
            <td><span class="status-badge {{ $p->is_active ? 'badge-published' : 'badge-inactive' }}">{{ $p->is_active ? 'Active' : 'Inactive' }}</span></td>
            <td>
                <div style="display:flex;gap:.4rem;">
                    <a href="{{ route('admin.products.edit', $p) }}" class="btn btn-outline btn-sm">Edit</a>
                    <form method="POST" action="{{ route('admin.products.destroy', $p) }}" onsubmit="return confirm('Delete this product?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Del</button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr><td colspan="9" style="text-align:center;padding:3rem;color:#9ca3af;">No products yet. <a href="{{ route('admin.products.create') }}" style="color:#c9a96e;">Add one →</a></td></tr>
        @endforelse
        </tbody>
    </table>
    @if($products->hasPages())<div class="admin-pagination">{{ $products->links() }}</div>@endif
</div>
@endsection
