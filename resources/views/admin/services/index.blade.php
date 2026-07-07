@extends('layouts.admin')
@section('title', 'Services')
@section('page_title', 'Services')

@section('content')


<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem;">
    <p style="color:#6b7280;font-size:.875rem;margin:0;">{{ $services->total() }} services total</p>
    <div style="display:flex;gap:.75rem;">
        <a href="{{ route('admin.service-categories.index') }}" class="btn btn-outline btn-sm">Manage Categories</a>
        <a href="{{ route('admin.services.create') }}" class="btn btn-primary btn-sm">+ New Service</a>
    </div>
</div>

<div class="admin-card">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Category</th>
                <th>Price</th>
                <th>Duration</th>
                <th>Order</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($services as $service)
        <tr>
            <td>
                @if($service->featured_image_url)
                    <img src="{{ $service->featured_image_url }}" style="width:60px;height:44px;object-fit:cover;border-radius:6px;">
                @elseif($service->banner_image_url)
                    <img src="{{ $service->banner_image_url }}" style="width:60px;height:44px;object-fit:cover;border-radius:6px;">
                @else
                    <div style="width:60px;height:44px;background:#f3f4f6;border-radius:6px;display:flex;align-items:center;justify-content:center;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#d1d5db" stroke-width="1.5" width="20"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    </div>
                @endif
            </td>
            <td>
                <p style="font-weight:600;margin:0;font-size:.9rem;">{{ $service->title }}</p>
                @if($service->excerpt)
                <p style="font-size:.78rem;color:#9ca3af;margin:.1rem 0 0;">{{ Str::limit($service->excerpt, 55) }}</p>
                @endif
            </td>
            <td>
                @if($service->category)
                    <span class="status-badge" style="background:#f3f4f6;color:#374151;">{{ $service->category->name }}</span>
                @else
                    <span style="color:#d1d5db;font-size:.82rem;">Uncategorised</span>
                @endif
            </td>
            <td style="font-size:.85rem;color:#374151;">{{ $service->price ?: '—' }}</td>
            <td style="font-size:.85rem;color:#6b7280;">{{ $service->duration ?: '—' }}</td>
            <td style="color:#6b7280;font-size:.85rem;">{{ $service->sort_order }}</td>
            <td>
                <span class="status-badge {{ $service->status === 'published' ? 'badge-active' : 'badge-inactive' }}">
                    {{ ucfirst($service->status) }}
                </span>
            </td>
            <td>
                <div style="display:flex;gap:.5rem;align-items:center;">
                    <a href="{{ route('services.show', $service->slug) }}" target="_blank"
                       class="btn btn-outline btn-sm" title="View on site">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="13"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                    </a>
                    <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-outline btn-sm">Edit</a>
                    <form method="POST" action="{{ route('admin.services.destroy', $service) }}"
                          onsubmit="return confirm('Delete this service permanently?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="8" style="text-align:center;padding:3rem;color:#9ca3af;">
                No services yet.
                <a href="{{ route('admin.services.create') }}" style="color:#c9a96e;">Add the first service &rarr;</a>
            </td>
        </tr>
        @endforelse
        </tbody>
    </table>

    @if($services->hasPages())
        <div class="admin-pagination">{{ $services->links() }}</div>
    @endif
</div>

@endsection
