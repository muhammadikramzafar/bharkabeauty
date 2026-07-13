@extends('layouts.admin')
@section('title','Categories')
@section('page_title','Product Categories')
@section('content')

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem;gap:.75rem;flex-wrap:wrap;">
    <p style="color:#6b7280;font-size:.875rem;">{{ $categories->total() }} categories total</p>
    <div style="display:flex;gap:.5rem;">
        <a href="{{ route('admin.categories.export') }}" class="btn btn-outline btn-sm">Export CSV</a>
        <a href="{{ route('admin.categories.import') }}" class="btn btn-outline btn-sm">Import CSV</a>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">+ Add Category</a>
    </div>
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
                    <form method="POST" action="{{ route('admin.categories.toggle-visibility',$cat) }}">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn btn-outline btn-sm btn-icon" title="{{ $cat->is_active ? 'Hide from storefront' : 'Show on storefront' }}">
                            @if($cat->is_active)
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                                Hide
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88"/></svg>
                                Show
                            @endif
                        </button>
                    </form>
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
