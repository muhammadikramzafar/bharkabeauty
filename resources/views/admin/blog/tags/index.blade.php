@extends('layouts.admin')
@section('title', 'Blog Tags')
@section('page_title', 'Blog Tags')

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem;">
    <p style="color:#6b7280;font-size:.875rem;margin:0;">{{ $tags->total() }} tags</p>
    <a href="{{ route('admin.blog.tags.create') }}" class="btn btn-primary btn-sm">+ New Tag</a>
</div>

<div class="admin-card">
    <table class="admin-table">
        <thead>
            <tr><th>Name</th><th>Slug</th><th>Posts</th><th>Actions</th></tr>
        </thead>
        <tbody>
        @forelse($tags as $tag)
        <tr>
            <td style="font-weight:600;">
                <span style="background:#f3e8d8;color:#92621a;padding:.25rem .65rem;border-radius:999px;font-size:.82rem;">
                    {{ $tag->name }}
                </span>
            </td>
            <td><code style="font-size:.78rem;color:#6b7280;">/blog/tag/{{ $tag->slug }}</code></td>
            <td><span style="color:#c9a96e;font-weight:600;">{{ $tag->posts_count }}</span></td>
            <td>
                <div style="display:flex;gap:.5rem;">
                    <a href="{{ route('admin.blog.tags.edit', $tag) }}" class="btn btn-outline btn-sm">Edit</a>
                    <form method="POST" action="{{ route('admin.blog.tags.destroy', $tag) }}"
                          onsubmit="return confirm('Delete tag?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4" style="text-align:center;padding:3rem;color:#9ca3af;">
                No tags. <a href="{{ route('admin.blog.tags.create') }}" style="color:#c9a96e;">Add one →</a>
            </td>
        </tr>
        @endforelse
        </tbody>
    </table>
    @if($tags->hasPages())<div class="admin-pagination">{{ $tags->links() }}</div>@endif
</div>
@endsection
