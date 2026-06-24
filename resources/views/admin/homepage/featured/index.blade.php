@extends('layouts.admin')
@section('title', 'Featured Collections')
@section('page_title', 'Featured Collections')

@section('content')

@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
    <a href="{{ route('admin.homepage.index') }}" class="btn btn-outline btn-sm">&larr; Homepage</a>
    <a href="{{ route('admin.homepage.featured.create') }}" class="btn btn-primary btn-sm">+ Add Collection</a>
</div>

<div class="admin-card">
    <table class="admin-table">
        <thead><tr><th>Image</th><th>Title</th><th>Button</th><th>Order</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
        @forelse($featured as $item)
        <tr>
            <td>
                @if($item->image_url)
                    <img src="{{ $item->image_url }}" style="width:80px;height:48px;object-fit:cover;border-radius:6px;">
                @else
                    <span style="color:#9ca3af;font-size:.8rem;">No image</span>
                @endif
            </td>
            <td>
                @if($item->eyebrow)<p style="font-size:.75rem;color:#9ca3af;margin:0 0 .1rem;text-transform:uppercase;letter-spacing:.05em;">{{ $item->eyebrow }}</p>@endif
                <p style="font-weight:600;margin:0;">{{ $item->title }}</p>
            </td>
            <td style="font-size:.82rem;color:#6b7280;">{{ $item->button_text }}</td>
            <td>{{ $item->sort_order }}</td>
            <td><span class="status-badge {{ $item->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $item->is_active ? 'Active' : 'Draft' }}</span></td>
            <td>
                <div style="display:flex;gap:.5rem;">
                    <a href="{{ route('admin.homepage.featured.edit', $item) }}" class="btn btn-outline btn-sm">Edit</a>
                    <form method="POST" action="{{ route('admin.homepage.featured.destroy', $item) }}" onsubmit="return confirm('Delete?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr><td colspan="6" style="text-align:center;padding:2rem;color:#9ca3af;">No featured collections yet.</td></tr>
        @endforelse
        </tbody>
    </table>
    @if($featured->hasPages())<div class="admin-pagination">{{ $featured->links() }}</div>@endif
</div>
@endsection
