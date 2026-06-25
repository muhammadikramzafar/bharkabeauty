@extends('layouts.admin')
@section('title','Brands')
@section('page_title','Brands')
@section('content')
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem;">
    <p style="color:#6b7280;font-size:.875rem;">{{ $brands->total() }} brands total</p>
    <a href="{{ route('admin.brands.create') }}" class="btn btn-primary btn-sm">+ Add Brand</a>
</div>

<div class="admin-card">
    <table class="admin-table">
        <thead><tr><th>Logo</th><th>Name</th><th>Website</th><th>Products</th><th>Featured</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
        @forelse($brands as $brand)
        <tr>
            <td>
                @if($brand->logo_url)
                    <img src="{{ $brand->logo_url }}" style="width:44px;height:44px;object-fit:contain;border-radius:8px;background:#f9f5f0;padding:4px;">
                @else
                    <div style="width:44px;height:44px;background:#f5f0ea;border-radius:8px;display:flex;align-items:center;justify-content:center;font-weight:800;color:#c9a96e;font-size:.9rem;">
                        {{ substr($brand->name,0,1) }}
                    </div>
                @endif
            </td>
            <td style="font-weight:600;">{{ $brand->name }}</td>
            <td style="font-size:.82rem;">
                @if($brand->website)<a href="{{ $brand->website }}" target="_blank" style="color:#c9a96e;">{{ parse_url($brand->website, PHP_URL_HOST) }}</a>@else—@endif
            </td>
            <td><span style="font-weight:600;">{{ $brand->products_count }}</span></td>
            <td>
                @if($brand->is_featured)<span class="status-badge badge-scheduled">Featured</span>@else<span style="color:#9ca3af;font-size:.8rem;">—</span>@endif
            </td>
            <td><span class="status-badge {{ $brand->is_active ? 'badge-published' : 'badge-inactive' }}">{{ $brand->is_active ? 'Active' : 'Inactive' }}</span></td>
            <td>
                <div style="display:flex;gap:.4rem;">
                    <a href="{{ route('admin.brands.edit',$brand) }}" class="btn btn-outline btn-sm">Edit</a>
                    <form method="POST" action="{{ route('admin.brands.destroy',$brand) }}" onsubmit="return confirm('Delete this brand?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Del</button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr><td colspan="7" style="text-align:center;padding:3rem;color:#9ca3af;">No brands yet. <a href="{{ route('admin.brands.create') }}" style="color:#c9a96e;">Add one →</a></td></tr>
        @endforelse
        </tbody>
    </table>
    @if($brands->hasPages())<div class="admin-pagination">{{ $brands->links() }}</div>@endif
</div>
@endsection
