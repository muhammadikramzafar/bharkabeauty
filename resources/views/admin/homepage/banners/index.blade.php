@extends('layouts.admin')
@section('title', 'Homepage Banners')
@section('page_title', 'Homepage Banners')

@section('content')


<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
    <a href="{{ route('admin.homepage.index') }}" class="btn btn-outline btn-sm">&larr; Homepage</a>
    <a href="{{ route('admin.homepage.banners.create') }}" class="btn btn-primary btn-sm">+ Add Banner</a>
</div>

<div class="admin-card">
    <table class="admin-table">
        <thead><tr><th>Image</th><th>Title</th><th>Position</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
        @forelse($banners as $banner)
        <tr>
            <td>
                @if($banner->image_url)
                    <img src="{{ $banner->image_url }}" style="width:80px;height:48px;object-fit:cover;border-radius:6px;">
                @else
                    <span style="color:#9ca3af;font-size:.8rem;">No image</span>
                @endif
            </td>
            <td>
                <p style="font-weight:600;margin:0;">{{ $banner->title }}</p>
                @if($banner->subtitle)<p style="font-size:.8rem;color:#6b7280;margin:.1rem 0 0;">{{ $banner->subtitle }}</p>@endif
            </td>
            <td><span class="status-badge" style="background:#e5e7eb;color:#374151;">{{ ucfirst($banner->position) }}</span></td>
            <td><span class="status-badge {{ $banner->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $banner->is_active ? 'Active' : 'Draft' }}</span></td>
            <td>
                <div style="display:flex;gap:.5rem;">
                    <a href="{{ route('admin.homepage.banners.edit', $banner) }}" class="btn btn-outline btn-sm">Edit</a>
                    <form method="POST" action="{{ route('admin.homepage.banners.destroy', $banner) }}" onsubmit="return confirm('Delete this banner?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr><td colspan="5" style="text-align:center;padding:2rem;color:#9ca3af;">No banners yet.</td></tr>
        @endforelse
        </tbody>
    </table>
    @if($banners->hasPages())
        <div class="admin-pagination">{{ $banners->links() }}</div>
    @endif
</div>
@endsection
