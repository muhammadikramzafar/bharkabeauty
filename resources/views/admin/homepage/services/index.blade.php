@extends('layouts.admin')
@section('title', 'Service Highlights')
@section('page_title', 'Service Highlights')

@section('content')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
    <a href="{{ route('admin.homepage.index') }}" class="btn btn-outline btn-sm">&larr; Homepage</a>
    <a href="{{ route('admin.homepage.services.create') }}" class="btn btn-primary btn-sm">+ Add Service</a>
</div>

<div class="admin-card">
    <table class="admin-table">
        <thead><tr><th>Icon</th><th>Title</th><th>Description</th><th>Order</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
        @forelse($services as $service)
        <tr>
            <td>
                @if($service->icon_type === 'emoji')
                    <span style="font-size:1.6rem;">{{ $service->icon }}</span>
                @elseif($service->icon)
                    <div style="width:32px;height:32px;">{!! $service->icon !!}</div>
                @else
                    <span style="color:#9ca3af;">—</span>
                @endif
            </td>
            <td style="font-weight:600;">{{ $service->title }}</td>
            <td style="color:#6b7280;font-size:.85rem;">{{ Str::limit($service->description, 60) }}</td>
            <td>{{ $service->sort_order }}</td>
            <td><span class="status-badge {{ $service->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $service->is_active ? 'Active' : 'Draft' }}</span></td>
            <td>
                <div style="display:flex;gap:.5rem;">
                    <a href="{{ route('admin.homepage.services.edit', $service) }}" class="btn btn-outline btn-sm">Edit</a>
                    <form method="POST" action="{{ route('admin.homepage.services.destroy', $service) }}" onsubmit="return confirm('Delete?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr><td colspan="6" style="text-align:center;padding:2rem;color:#9ca3af;">No services yet.</td></tr>
        @endforelse
        </tbody>
    </table>
    @if($services->hasPages())
        <div class="admin-pagination">{{ $services->links() }}</div>
    @endif
</div>
@endsection
