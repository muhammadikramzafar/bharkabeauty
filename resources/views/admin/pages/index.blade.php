@extends('layouts.admin')
@section('title', 'CMS Pages')
@section('page_title', 'CMS Pages')

@section('content')
<div class="admin-card-header" style="margin-bottom:1.5rem;display:flex;justify-content:space-between;align-items:center;">
    <span class="text-muted">{{ $pages->total() }} pages</span>
    <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">+ New Page</a>
</div>

<div class="admin-card">
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Slug</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pages as $page)
                <tr>
                    <td><strong>{{ $page->title }}</strong></td>
                    <td><code>/{{ $page->slug }}</code></td>
                    <td>
                        <span class="status-pill {{ $page->status === 'published' ? 'status-active' : 'status-inactive' }}">
                            {{ ucfirst($page->status) }}
                        </span>
                    </td>
                    <td>{{ $page->created_at->format('d M Y') }}</td>
                    <td class="table-actions">
                        <a href="{{ route('admin.pages.edit', $page) }}" class="btn-table-action">Edit</a>
                        <a href="{{ route('cms.page', $page->slug) }}" target="_blank" class="btn-table-action">View</a>
                        <form method="POST" action="{{ route('admin.pages.destroy', $page) }}" onsubmit="return confirm('Delete this page?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-table-action btn-table-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted">No pages created yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($pages->hasPages())
        <div class="admin-pagination">{{ $pages->links() }}</div>
    @endif
</div>
@endsection
