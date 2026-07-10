@extends('layouts.app')

@section('title', ($post->seo_title ?: $post->title) . ' — AmsazBeauty Blog')
@if($post->seo_description)
@section('meta_description', $post->seo_description)
@endif
@if($post->seo_keywords)
@section('meta_keywords', $post->seo_keywords)
@endif

@push('styles')
<style>
/* Reuse blog grid/sidebar CSS from index */
.blog-layout { display: grid; grid-template-columns: 1fr 300px; gap: 2.5rem; padding: 2.5rem 0 4rem; }
@media(max-width: 860px) { .blog-layout { grid-template-columns: 1fr; } .blog-sidebar { order: -1; } }

.blog-sidebar { }
.sidebar-widget { background: #fff; border-radius: 14px; padding: 1.25rem; box-shadow: 0 2px 10px rgba(0,0,0,.06); margin-bottom: 1.5rem; }
.sidebar-widget h3 { font-size: .95rem; font-weight: 700; color: #1a1a2e; margin: 0 0 1rem; padding-bottom: .6rem; border-bottom: 2px solid #f0e8da; }
.sidebar-recent-item { display: flex; gap: .75rem; align-items: flex-start; padding: .6rem 0; border-bottom: 1px solid #f9f5f0; }
.sidebar-recent-item:last-child { border-bottom: none; padding-bottom: 0; }
.sidebar-recent-img { width: 54px; height: 42px; border-radius: 6px; object-fit: cover; flex-shrink: 0; background: #f3f4f6; }
.sidebar-recent-title { font-size: .82rem; font-weight: 600; color: #1a1a2e; text-decoration: none; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.sidebar-recent-title:hover { color: #c9a96e; }
.sidebar-recent-date { font-size: .73rem; color: #9ca3af; margin-top: .2rem; }
.sidebar-cat-item { display: flex; justify-content: space-between; align-items: center; padding: .5rem 0; border-bottom: 1px solid #f9f5f0; }
.sidebar-cat-item:last-child { border-bottom: none; }
.sidebar-cat-link { font-size: .85rem; color: #1a1a2e; text-decoration: none; font-weight: 500; }
.sidebar-cat-link:hover { color: #c9a96e; }
.sidebar-cat-count { font-size: .75rem; color: #9ca3af; background: #f3f4f6; padding: .15rem .5rem; border-radius: 999px; }
.sidebar-tags { display: flex; flex-wrap: wrap; gap: .4rem; }
.sidebar-tag { display: inline-block; padding: .3rem .7rem; border-radius: 999px; font-size: .78rem; font-weight: 600; background: #f3e8d8; color: #92621a; text-decoration: none; }
.sidebar-tag:hover { background: #c9a96e; color: #fff; }

/* Post detail */
.post-featured-image { width: 100%; max-height: 460px; object-fit: cover; border-radius: 14px; margin-bottom: 2rem; display: block; }
.post-header { margin-bottom: 1.5rem; }
.post-category-badge { display: inline-block; background: #f3e8d8; color: #92621a; font-size: .78rem; font-weight: 700; padding: .3rem .8rem; border-radius: 999px; text-decoration: none; margin-bottom: .75rem; }
.post-title { font-size: 2rem; font-weight: 800; color: #1a1a2e; line-height: 1.25; margin: 0 0 1rem; }
.post-meta { display: flex; gap: 1.25rem; align-items: center; flex-wrap: wrap; padding-bottom: 1rem; border-bottom: 1px solid #f0e8da; }
.post-meta-author { display: flex; align-items: center; gap: .5rem; font-size: .85rem; color: #4b5563; }
.post-meta-avatar { width: 32px; height: 32px; border-radius: 50%; background: #c9a96e; color: #fff; font-size: .8rem; font-weight: 700; display: flex; align-items: center; justify-content: center; }
.post-meta-date, .post-meta-read { font-size: .82rem; color: #9ca3af; }
.post-meta-date svg, .post-meta-read svg { vertical-align: middle; margin-right: .2rem; }

.post-content { font-size: 1rem; line-height: 1.85; color: #374151; }
.post-content h1, .post-content h2, .post-content h3, .post-content h4 { color: #1a1a2e; margin: 1.75rem 0 .6rem; line-height: 1.3; }
.post-content h2 { font-size: 1.5rem; }
.post-content h3 { font-size: 1.2rem; }
.post-content p  { margin-bottom: 1.1rem; }
.post-content ul, .post-content ol { padding-left: 1.6rem; margin-bottom: 1.1rem; }
.post-content li { margin-bottom: .4rem; }
.post-content blockquote { border-left: 4px solid #c9a96e; margin: 1.5rem 0; padding: 1rem 1.25rem; background: #fdf8f4; border-radius: 0 8px 8px 0; font-style: italic; color: #4b5563; }
.post-content img { max-width: 100%; border-radius: 10px; margin: 1rem 0; }
.post-content a { color: #c9a96e; }
.post-content pre { background: #1a1a2e; color: #e5e7eb; padding: 1.25rem; border-radius: 10px; overflow-x: auto; font-size: .88rem; margin-bottom: 1.1rem; }
.post-content code { background: #f3f4f6; padding: .1rem .35rem; border-radius: 4px; font-size: .88em; }
.post-content pre code { background: none; padding: 0; }

.post-tags { margin-top: 2rem; padding-top: 1.25rem; border-top: 1px solid #f0e8da; }
.post-tags span { font-size: .85rem; color: #6b7280; margin-right: .5rem; }

/* Related posts */
.related-posts { background: #fdf8f4; padding: 3rem 0 4rem; margin-top: 0; }
.related-posts h2 { font-size: 1.5rem; font-weight: 700; color: #1a1a2e; margin-bottom: 1.5rem; }
.related-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px,1fr)); gap: 1.5rem; }
.related-card { background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,.06); text-decoration: none; color: inherit; transition: transform .2s; display: block; }
.related-card:hover { transform: translateY(-3px); }
.related-card__img { height: 170px; overflow: hidden; background: #f9f5f0; }
.related-card__img img { width: 100%; height: 100%; object-fit: cover; }
.related-card__body { padding: 1rem; }
.related-card__cat  { font-size: .73rem; color: #c9a96e; font-weight: 700; margin: 0 0 .3rem; }
.related-card__title { font-size: .9rem; font-weight: 700; color: #1a1a2e; margin: 0; line-height: 1.4; }
</style>
@endpush

@section('content')

{{-- Breadcrumb --}}
<div class="breadcrumb-bar">
    <div class="container">
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <ol>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('blog.index') }}">Blog</a></li>
                @if($post->category)
                    <li><a href="{{ route('blog.category', $post->category->slug) }}">{{ $post->category->name }}</a></li>
                @endif
                <li aria-current="page">{{ Str::limit($post->title, 40) }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container blog-layout">

    {{-- Article --}}
    <article>
        <div class="post-header">
            @if($post->category)
                <a href="{{ route('blog.category', $post->category->slug) }}" class="post-category-badge">{{ $post->category->name }}</a>
            @endif
            <h1 class="post-title">{{ $post->title }}</h1>
            <div class="post-meta">
                <span class="post-meta-author">
                    <span class="post-meta-avatar">{{ strtoupper(substr($post->author?->name ?? 'B', 0, 1)) }}</span>
                    {{ $post->author?->name ?? 'AmsazBeauty' }}
                </span>
                <span class="post-meta-date">
                    <svg viewBox="0 0 20 20" fill="currentColor" width="14"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>
                    {{ $post->published_at?->format('d F Y') ?? $post->created_at->format('d F Y') }}
                </span>
                <span class="post-meta-read">
                    <svg viewBox="0 0 20 20" fill="currentColor" width="14"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                    {{ $post->read_time }} min read
                </span>
            </div>
        </div>

        @if($post->featured_image_url)
            <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="post-featured-image">
        @endif

        @if($post->excerpt)
            <p style="font-size:1.1rem;font-style:italic;color:#4b5563;line-height:1.7;margin-bottom:1.75rem;padding:1rem 1.25rem;background:#fdf8f4;border-left:4px solid #c9a96e;border-radius:0 8px 8px 0;">
                {{ $post->excerpt }}
            </p>
        @endif

        <div class="post-content">
            {!! $post->content !!}
        </div>

        @if($post->tags->count() > 0)
        <div class="post-tags">
            <span>Tags:</span>
            @foreach($post->tags as $tag)
                <a href="{{ route('blog.tag', $tag->slug) }}" class="sidebar-tag" style="display:inline-block;">{{ $tag->name }}</a>
            @endforeach
        </div>
        @endif

        {{-- Share --}}
        <div style="margin-top:2rem;padding-top:1.5rem;border-top:1px solid #f0e8da;display:flex;gap:1rem;align-items:center;flex-wrap:wrap;">
            <span style="font-size:.85rem;color:#6b7280;font-weight:600;">Share:</span>
            <a href="https://wa.me/?text={{ urlencode($post->title . ' - ' . request()->url()) }}"
               target="_blank" rel="noopener"
               style="display:inline-flex;align-items:center;gap:.4rem;padding:.4rem .85rem;background:#25d366;color:#fff;border-radius:6px;font-size:.8rem;font-weight:600;text-decoration:none;">
               <svg viewBox="0 0 24 24" fill="currentColor" width="14"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
               WhatsApp
            </a>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
               target="_blank" rel="noopener"
               style="display:inline-flex;align-items:center;gap:.4rem;padding:.4rem .85rem;background:#1877f2;color:#fff;border-radius:6px;font-size:.8rem;font-weight:600;text-decoration:none;">
               <svg viewBox="0 0 24 24" fill="currentColor" width="14"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
               Facebook
            </a>
        </div>
    </article>

    {{-- Sidebar --}}
    @include('blog._sidebar', compact('categories', 'recentPosts', 'allTags'))

</div>

{{-- Related Posts --}}
@if($related->count() > 0)
<section class="related-posts">
    <div class="container">
        <h2>You Might Also Like</h2>
        <div class="related-grid">
            @foreach($related as $r)
            <a href="{{ route('blog.show', $r->slug) }}" class="related-card">
                <div class="related-card__img">
                    @if($r->featured_image_url)
                        <img src="{{ $r->featured_image_url }}" alt="{{ $r->title }}" loading="lazy">
                    @endif
                </div>
                <div class="related-card__body">
                    @if($r->category)
                        <p class="related-card__cat">{{ $r->category->name }}</p>
                    @endif
                    <p class="related-card__title">{{ $r->title }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
