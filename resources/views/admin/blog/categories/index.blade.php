@extends('layouts.admin')
@section('title', 'Blog Categories')
@section('page_title', 'Blog Categories')

@section('content')

<a href="{{ route('admin.blog.posts.index') }}" class="admin-back-link">
    <svg class="admin-back-link__icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
    </svg>
    Back to Posts
</a>

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem;">
    <p style="color:#6b7280;font-size:.875rem;margin:0;">{{ $categories->total() }} categories</p>
    <a href="{{ route('admin.blog.categories.create') }}" class="btn btn-primary btn-sm">+ New Category</a>
</div>

<div class="admin-card">
    <table class="admin-table">
        <thead>
            <tr><th>Name</th><th>Slug</th><th>Posts</th><th>Order</th><th>Status</th><th>Actions</th></tr>
        </thead>
        <tbody>
        @forelse($categories as $cat)
        <tr>
            <td style="font-weight:600;">{{ $cat->name }}</td>
            <td><code style="font-size:.78rem;color:#6b7280;">/blog/category/{{ $cat->slug }}</code></td>
            <td>
                <a href="{{ route('admin.blog.posts.index', ['category' => $cat->id]) }}" style="color:#c9a96e;font-weight:600;">
                    {{ $cat->posts_count }}
                </a>
            </td>
            <td style="color:#6b7280;">{{ $cat->sort_order }}</td>
            <td>
                <span class="status-badge {{ $cat->is_active ? 'badge-active' : 'badge-inactive' }}">
                    {{ $cat->is_active ? 'Active' : 'Hidden' }}
                </span>
            </td>
            <td>
                <div style="display:flex;gap:.5rem;">
                    <a href="{{ route('admin.blog.categories.edit', $cat) }}" class="btn btn-outline btn-sm">Edit</a>
                    <form method="POST" action="{{ route('admin.blog.categories.destroy', $cat) }}"
                          onsubmit="return confirm('Delete category? Posts will be uncategorised.')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" style="text-align:center;padding:3rem;color:#9ca3af;">
                No categories. <a href="{{ route('admin.blog.categories.create') }}" style="color:#c9a96e;">Add one →</a>
            </td>
        </tr>
        @endforelse
        </tbody>
    </table>
    @if($categories->hasPages())<div class="admin-pagination">{{ $categories->links() }}</div>@endif
</div>
@endsection
