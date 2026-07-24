<article class="blog-card">
    <a href="{{ route('blog.show', $post->slug) }}" class="blog-card__img">
        @if($post->featured_image_url)
            <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" loading="lazy">
        @else
            <div style="display:flex;align-items:center;justify-content:center;height:100%;background:#f3e8d8;">
                <svg viewBox="0 0 60 60" fill="none" width="48"><circle cx="30" cy="30" r="28" fill="#e8d5bb"/><path d="M20 42l8-16 6 12 4-8 6 12" stroke="#c9a96e" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/><circle cx="22" cy="22" r="4" fill="#c9a96e"/></svg>
            </div>
        @endif
        @if($post->category)
            <a href="{{ route('blog.category', $post->category->slug) }}" class="blog-card__cat" onclick="event.stopPropagation()">
                {{ $post->category->name }}
            </a>
        @endif
    </a>
    <div class="blog-card__body">
        <p class="blog-card__date">{{ $post->published_at?->format('d M Y') ?? $post->created_at->format('d M Y') }}</p>
        <h3 class="blog-card__title">
            <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
        </h3>
        @if($post->excerpt)
            <p class="blog-card__excerpt">{{ $post->excerpt }}</p>
        @endif
        <div class="blog-card__footer">
            <span class="blog-card__author">
                <span class="blog-card__author-avatar">
                    {{ strtoupper(substr($post->author?->name ?? 'A', 0, 1)) }}
                </span>
                {{ $post->author?->name ?? 'Amsaz Cosmetics' }}
            </span>
            <span class="blog-card__read">{{ $post->read_time }} min read</span>
        </div>
        <a href="{{ route('blog.show', $post->slug) }}" class="blog-card__cta" style="margin-top:.75rem;display:inline-block;">
            Read More →
        </a>
    </div>
</article>
