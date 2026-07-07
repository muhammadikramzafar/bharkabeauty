@extends('layouts.admin')
@section('title', 'Service Categories')
@section('page_title', 'Service Categories')

@section('content')


<a href="{{ route('admin.services.index') }}" class="admin-back-link">
    <svg class="admin-back-link__icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
    </svg>
    Back to Services
</a>

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem;">
    <p style="color:#6b7280;font-size:.875rem;margin:0;">{{ $categories->total() }} categories total</p>
    <a href="{{ route('admin.service-categories.create') }}" class="btn btn-primary btn-sm">+ New Category</a>
</div>

<div class="admin-card">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Services</th>
                <th>Order</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($categories as $cat)
        <tr>
            <td>
                @if($cat->image_url)
                    <img src="{{ $cat->image_url }}" style="width:52px;height:40px;object-fit:cover;border-radius:6px;">
                @else
                    <div style="width:52px;height:40px;background:#f3f4f6;border-radius:6px;display:flex;align-items:center;justify-content:center;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#d1d5db" stroke-width="1.5" width="20"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    </div>
                @endif
            </td>
            <td style="font-weight:600;">{{ $cat->name }}</td>
            <td><code style="font-size:.78rem;color:#6b7280;">{{ $cat->slug }}</code></td>
            <td>
                <a href="{{ route('admin.services.index', ['category' => $cat->id]) }}" style="color:#c9a96e;font-weight:600;">
                    {{ $cat->services_count }}
                </a>
            </td>
            <td style="color:#6b7280;">{{ $cat->sort_order }}</td>
            <td>
                <span class="status-badge {{ $cat->is_active ? 'badge-active' : 'badge-inactive' }}">
                    {{ $cat->is_active ? 'Active' : 'Hidden' }}
                </span>
            </td>
            <td>
                <div style="display:flex;gap:.5rem;align-items:center;">
                    <a href="{{ route('admin.service-categories.edit', $cat) }}" class="btn btn-outline btn-sm">Edit</a>
                    <form method="POST" action="{{ route('admin.service-categories.destroy', $cat) }}"
                          onsubmit="return confirm('Delete this category? Services in it will be uncategorised.')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" style="text-align:center;padding:3rem;color:#9ca3af;">
                No categories yet.
                <a href="{{ route('admin.service-categories.create') }}" style="color:#c9a96e;">Add the first one &rarr;</a>
            </td>
        </tr>
        @endforelse
        </tbody>
    </table>

    @if($categories->hasPages())
        <div class="admin-pagination">{{ $categories->links() }}</div>
    @endif
</div>

@endsection
