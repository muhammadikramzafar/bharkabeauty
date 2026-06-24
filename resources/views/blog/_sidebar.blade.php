<aside class="blog-sidebar">

    {{-- Search --}}
    <div class="sidebar-widget">
        <h3>Search</h3>
        <form method="GET" action="{{ route('blog.index') }}" style="display:flex;gap:.5rem;">
            <input type="search" name="search" value="{{ request('search') }}"
                   placeholder="Search articles…"
                   class="form-control" style="flex:1;font-size:.85rem;">
            <button type="submit" class="btn btn-primary btn-sm">Go</button>
        </form>
    </div>

    {{-- Categories --}}
    @if($categories->count() > 0)
    <div class="sidebar-widget">
        <h3>Categories</h3>
        @foreach($categories as $cat)
        <div class="sidebar-cat-item">
            <a href="{{ route('blog.category', $cat->slug) }}" class="sidebar-cat-link">{{ $cat->name }}</a>
            <span class="sidebar-cat-count">{{ $cat->published_posts_count }}</span>
        </div>
        @endforeach
    </div>
    @endif

    {{-- Recent Posts --}}
    @if($recentPosts->count() > 0)
    <div class="sidebar-widget">
        <h3>Recent Posts</h3>
        @foreach($recentPosts as $r)
        <div class="sidebar-recent-item">
            @if($r->featured_image_url)
                <img src="{{ $r->featured_image_url }}" class="sidebar-recent-img" alt="{{ $r->title }}">
            @else
                <div class="sidebar-recent-img" style="display:flex;align-items:center;justify-content:center;background:#f3e8d8;">
                    <svg viewBox="0 0 20 20" fill="#c9a96e" width="16"><path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/></svg>
                </div>
            @endif
            <div>
                <a href="{{ route('blog.show', $r->slug) }}" class="sidebar-recent-title">{{ $r->title }}</a>
                <p class="sidebar-recent-date">{{ $r->published_at?->format('d M Y') }}</p>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    {{-- Tags --}}
    @if($allTags->count() > 0)
    <div class="sidebar-widget">
        <h3>Tags</h3>
        <div class="sidebar-tags">
            @foreach($allTags as $tag)
            <a href="{{ route('blog.tag', $tag->slug) }}" class="sidebar-tag">{{ $tag->name }}</a>
            @endforeach
        </div>
    </div>
    @endif

</aside>
