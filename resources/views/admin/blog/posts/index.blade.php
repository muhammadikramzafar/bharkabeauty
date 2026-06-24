@extends('layouts.admin')
@section('title', 'Blog Posts')
@section('page_title', 'Blog Posts')

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- Status Tabs --}}
<div style="display:flex;gap:.5rem;margin-bottom:1.25rem;flex-wrap:wrap;align-items:center;">
    <a href="{{ route('admin.blog.posts.index') }}"
       class="btn btn-sm {{ !request('status') ? 'btn-primary' : 'btn-outline' }}">
       All <span style="font-size:.78rem;opacity:.7;">({{ $counts['all'] }})</span>
    </a>
    <a href="{{ route('admin.blog.posts.index', ['status' => 'published']) }}"
       class="btn btn-sm {{ request('status') === 'published' ? 'btn-primary' : 'btn-outline' }}">
       Published <span style="font-size:.78rem;opacity:.7;">({{ $counts['published'] }})</span>
    </a>
    <a href="{{ route('admin.blog.posts.index', ['status' => 'scheduled']) }}"
       class="btn btn-sm {{ request('status') === 'scheduled' ? 'btn-primary' : 'btn-outline' }}">
       Scheduled <span style="font-size:.78rem;opacity:.7;">({{ $counts['scheduled'] }})</span>
    </a>
    <a href="{{ route('admin.blog.posts.index', ['status' => 'draft']) }}"
       class="btn btn-sm {{ request('status') === 'draft' ? 'btn-primary' : 'btn-outline' }}">
       Draft <span style="font-size:.78rem;opacity:.7;">({{ $counts['draft'] }})</span>
    </a>
    <div style="margin-left:auto;display:flex;gap:.5rem;">
        <a href="{{ route('admin.blog.tags.index') }}" class="btn btn-outline btn-sm">Tags</a>
        <a href="{{ route('admin.blog.categories.index') }}" class="btn btn-outline btn-sm">Categories</a>
        <a href="{{ route('admin.blog.posts.create') }}" class="btn btn-primary btn-sm">+ New Post</a>
    </div>
</div>

{{-- Filters --}}
<form method="GET" style="display:flex;gap:.75rem;margin-bottom:1.25rem;flex-wrap:wrap;">
    @if(request('status')) <input type="hidden" name="status" value="{{ request('status') }}"> @endif
    <input type="text" name="search" placeholder="Search posts…" value="{{ request('search') }}"
           class="form-control" style="max-width:260px;">
    <select name="category" class="form-control" style="max-width:200px;">
        <option value="">All Categories</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
        @endforeach
    </select>
    <button type="submit" class="btn btn-outline btn-sm">Filter</button>
    @if(request()->hasAny(['search','category']))
        <a href="{{ route('admin.blog.posts.index', request()->only('status')) }}" class="btn btn-outline btn-sm">Clear</a>
    @endif
</form>

<div class="admin-card">
    <table class="admin-table">
        <thead>
            <tr><th>Post</th><th>Category</th><th>Author</th><th>Status</th><th>Published</th><th>Actions</th></tr>
        </thead>
        <tbody>
        @forelse($posts as $post)
        <tr>
            <td>
                <div style="display:flex;gap:.75rem;align-items:center;">
                    @if($post->featured_image_url)
                        <img src="{{ $post->featured_image_url }}" style="width:56px;height:42px;object-fit:cover;border-radius:6px;flex-shrink:0;">
                    @else
                        <div style="width:56px;height:42px;background:#f3f4f6;border-radius:6px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <svg viewBox="0 0 20 20" fill="#d1d5db" width="18"><path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/></svg>
                        </div>
                    @endif
                    <div>
                        <p style="font-weight:600;margin:0;font-size:.88rem;max-width:280px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $post->title }}</p>
                        <p style="font-size:.75rem;color:#9ca3af;margin:.1rem 0 0;">{{ $post->read_time }} min read</p>
                    </div>
                </div>
            </td>
            <td>
                @if($post->category)
                    <span class="status-badge" style="background:#f3f4f6;color:#374151;">{{ $post->category->name }}</span>
                @else
                    <span style="color:#d1d5db;font-size:.8rem;">None</span>
                @endif
            </td>
            <td style="font-size:.85rem;color:#4b5563;">{{ $post->author?->name ?? '—' }}</td>
            <td>
                @php
                    $sc = match($post->status) {
                        'published' => 'badge-active',
                        'scheduled' => 'status-badge' ,
                        default     => 'badge-inactive',
                    };
                    $style = $post->status === 'scheduled' ? 'background:#fef9c3;color:#854d0e;' : '';
                @endphp
                <span class="status-badge {{ $sc }}" style="{{ $style }}">{{ $post->status_label }}</span>
            </td>
            <td style="font-size:.8rem;color:#6b7280;white-space:nowrap;">
                {{ $post->published_at?->format('d M Y, H:i') ?? '—' }}
            </td>
            <td>
                <div style="display:flex;gap:.4rem;align-items:center;">
                    @if($post->is_live)
                    <a href="{{ route('blog.show', $post->slug) }}" target="_blank"
                       class="btn btn-outline btn-sm" title="View post">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="12"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                    </a>
                    @endif
                    <a href="{{ route('admin.blog.posts.edit', $post) }}" class="btn btn-outline btn-sm">Edit</a>
                    <form method="POST" action="{{ route('admin.blog.posts.destroy', $post) }}"
                          onsubmit="return confirm('Delete this post permanently?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" style="text-align:center;padding:3rem;color:#9ca3af;">
                No posts found.
                <a href="{{ route('admin.blog.posts.create') }}" style="color:#c9a96e;">Write the first one →</a>
            </td>
        </tr>
        @endforelse
        </tbody>
    </table>
    @if($posts->hasPages())<div class="admin-pagination">{{ $posts->links() }}</div>@endif
</div>
@endsection
