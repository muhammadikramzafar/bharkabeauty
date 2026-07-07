@extends('layouts.admin')
@section('title', 'Client Logos')
@section('page_title', 'Client Logos')

@section('content')


<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
    <a href="{{ route('admin.homepage.index') }}" class="btn btn-outline btn-sm">&larr; Homepage</a>
    <a href="{{ route('admin.homepage.logos.create') }}" class="btn btn-primary btn-sm">+ Add Logo</a>
</div>

<div class="admin-card">
    <div style="padding:.75rem 1.5rem;background:#fef3c7;border-bottom:1px solid #fde68a;font-size:.85rem;color:#92400e;">
        These logos appear in the "Shop by Brand" section on the homepage.
    </div>
    <table class="admin-table">
        <thead><tr><th>Logo</th><th>Name</th><th>Tagline</th><th>URL</th><th>Order</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
        @forelse($logos as $logo)
        <tr>
            <td>
                @if($logo->logo_url)
                    <img src="{{ $logo->logo_url }}" style="max-height:36px;max-width:80px;object-fit:contain;">
                @else
                    <span style="color:#9ca3af;font-size:.8rem;">Text only</span>
                @endif
            </td>
            <td style="font-weight:600;">{{ $logo->name }}</td>
            <td style="color:#6b7280;font-size:.85rem;">{{ $logo->tagline }}</td>
            <td style="font-size:.8rem;color:#6b7280;">{{ Str::limit($logo->url, 30) }}</td>
            <td>{{ $logo->sort_order }}</td>
            <td><span class="status-badge {{ $logo->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $logo->is_active ? 'Active' : 'Hidden' }}</span></td>
            <td>
                <div style="display:flex;gap:.5rem;">
                    <a href="{{ route('admin.homepage.logos.edit', $logo) }}" class="btn btn-outline btn-sm">Edit</a>
                    <form method="POST" action="{{ route('admin.homepage.logos.destroy', $logo) }}" onsubmit="return confirm('Delete?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr><td colspan="7" style="text-align:center;padding:2rem;color:#9ca3af;">No logos yet.</td></tr>
        @endforelse
        </tbody>
    </table>
    @if($logos->hasPages())<div class="admin-pagination">{{ $logos->links() }}</div>@endif
</div>
@endsection
