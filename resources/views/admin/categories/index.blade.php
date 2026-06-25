@extends('layouts.admin')
@section('title','Categories')
@section('page_title','Product Categories')
@section('content')
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem;">
    <p style="color:#6b7280;font-size:.875rem;">{{ $categories->total() }} categories total</p>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">+ Add Category</a>
</div>

<div class="admin-card">
    <table class="admin-table">
        <thead><tr><th>Image</th><th>Name</th><th>Slug</th><th>Parent</th><th>Products</th><th>Order</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
        @forelse($categories as $cat)
        <tr>
            <td>
                @if($cat->image_url)
                    <img src="{{ $cat->image_url }}" style="width:44px;height:44px;object-fit:cover;border-radius:8px;">
                @else
                    <div style="width:44px;height:44px;background:#f5f0ea;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#c9a96e" stroke-width="1.5" width="18"><path d="M4 6h16M4 12h16M4 18h7"/></svg>
                    </div>
                @endif
            </td>
            <td style="font-weight:600;">{{ $cat->name }}</td>
            <td style="font-size:.8rem;color:#9ca3af;">{{ $cat->slug }}</td>
            <td style="font-size:.85rem;">{{ $cat->parent?->name ?? '—' }}</td>
            <td><span style="font-weight:600;">{{ $cat->products_count }}</span></td>
            <td style="color:#6b7280;">{{ $cat->sort_order }}</td>
            <td><span class="status-badge {{ $cat->is_active ? 'badge-published' : 'badge-inactive' }}">{{ $cat->is_active ? 'Active' : 'Inactive' }}</span></td>
            <td>
                <div style="display:flex;gap:.4rem;">
                    <a href="{{ route('admin.categories.edit',$cat) }}" class="btn btn-outline btn-sm">Edit</a>
                    <form method="POST" action="{{ route('admin.categories.destroy',$cat) }}" onsubmit="return confirm('Delete this category?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Del</button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr><td colspan="8" style="text-align:center;padding:3rem;color:#9ca3af;">No categories yet. <a href="{{ route('admin.categories.create') }}" style="color:#c9a96e;">Add one →</a></td></tr>
        @endforelse
        </tbody>
    </table>
    @if($categories->hasPages())<div class="admin-pagination">{{ $categories->links() }}</div>@endif
</div>
@endsection
