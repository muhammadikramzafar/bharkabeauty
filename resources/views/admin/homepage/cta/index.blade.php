@extends('layouts.admin')
@section('title', 'CTA Sections')
@section('page_title', 'Call To Action Sections')

@section('content')

@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
    <a href="{{ route('admin.homepage.index') }}" class="btn btn-outline btn-sm">&larr; Homepage</a>
    <a href="{{ route('admin.homepage.cta.create') }}" class="btn btn-primary btn-sm">+ Add CTA</a>
</div>

<div class="admin-card">
    <div style="padding:.75rem 1.5rem;background:#eff6ff;border-bottom:1px solid #bfdbfe;font-size:.85rem;color:#1e40af;">
        Tip: Use section keys <strong>flagship_store</strong> and <strong>newsletter</strong> to override the built-in homepage sections.
    </div>
    <table class="admin-table">
        <thead><tr><th>Key</th><th>Title</th><th>Description</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
        @forelse($ctas as $cta)
        <tr>
            <td><code style="background:#f3f4f6;padding:.15rem .4rem;border-radius:4px;font-size:.8rem;">{{ $cta->section_key }}</code></td>
            <td style="font-weight:600;">{{ $cta->title }}</td>
            <td style="color:#6b7280;font-size:.85rem;">{{ Str::limit($cta->description, 70) }}</td>
            <td><span class="status-badge {{ $cta->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $cta->is_active ? 'Active' : 'Draft' }}</span></td>
            <td>
                <div style="display:flex;gap:.5rem;">
                    <a href="{{ route('admin.homepage.cta.edit', $cta) }}" class="btn btn-outline btn-sm">Edit</a>
                    <form method="POST" action="{{ route('admin.homepage.cta.destroy', $cta) }}" onsubmit="return confirm('Delete?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr><td colspan="5" style="text-align:center;padding:2rem;color:#9ca3af;">No CTA sections yet.</td></tr>
        @endforelse
        </tbody>
    </table>
    @if($ctas->hasPages())<div class="admin-pagination">{{ $ctas->links() }}</div>@endif
</div>
@endsection
