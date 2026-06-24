@extends('layouts.app')

@section('title', 'Blog — BharkaBeauty')
@section('meta_description', 'Beauty tips, tutorials, trends and expert advice from BharkaBeauty.')

@push('styles')
<style>
/* ── Blog Layout ──────────────────────────────────────── */
.blog-hero { background: linear-gradient(135deg, #fdf8f4 0%, #f3e8d8 100%); padding: 3rem 0 2.5rem; text-align: center; }
.blog-hero h1 { font-size: 2.4rem; font-weight: 800; color: #1a1a2e; margin: 0 0 .5rem; }
.blog-hero p  { color: #6b7280; font-size: 1rem; margin: 0; }

.blog-search-bar { max-width: 500px; margin: 1.5rem auto 0; display: flex; border-radius: 50px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,.1); }
.blog-search-bar input { flex: 1; padding: .75rem 1.25rem; border: none; font-size: .95rem; outline: none; background: #fff; }
.blog-search-bar button { padding: .75rem 1.5rem; background: #c9a96e; color: #fff; border: none; font-weight: 700; cursor: pointer; font-size: .9rem; }
.blog-search-bar button:hover { background: #b8956a; }

.blog-layout { display: grid; grid-template-columns: 1fr 300px; gap: 2.5rem; padding: 3rem 0 4rem; }
@media(max-width: 860px) { .blog-layout { grid-template-columns: 1fr; } .blog-sidebar { order: -1; } }

/* Cards */
.blog-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px,1fr)); gap: 1.75rem; }

.blog-card { background: #fff; border-radius: 14px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,.06); transition: transform .25s, box-shadow .25s; display: flex; flex-direction: column; }
.blog-card:hover { transform: translateY(-4px); box-shadow: 0 8px 28px rgba(0,0,0,.11); }

.blog-card__img { position: relative; height: 200px; overflow: hidden; background: #f9f5f0; display: block; }
.blog-card__img img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; }
.blog-card:hover .blog-card__img img { transform: scale(1.04); }
.blog-card__cat { position: absolute; top: .75rem; left: .75rem; background: rgba(201,169,110,.93); color: #fff; font-size: .72rem; font-weight: 700; padding: .3rem .7rem; border-radius: 999px; letter-spacing: .03em; text-decoration: none; }

.blog-card__body { padding: 1.25rem; flex: 1; display: flex; flex-direction: column; }
.blog-card__date { font-size: .75rem; color: #9ca3af; margin: 0 0 .5rem; }
.blog-card__title { font-size: 1rem; font-weight: 700; color: #1a1a2e; margin: 0 0 .65rem; line-height: 1.4; }
.blog-card__title a { color: inherit; text-decoration: none; }
.blog-card__title a:hover { color: #c9a96e; }
.blog-card__excerpt { font-size: .84rem; color: #6b7280; line-height: 1.6; flex: 1; margin: 0 0 1rem; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
.blog-card__footer { display: flex; justify-content: space-between; align-items: center; padding-top: .75rem; border-top: 1px solid #f3f4f6; }
.blog-card__author { font-size: .78rem; color: #4b5563; display: flex; align-items: center; gap: .4rem; }
.blog-card__author-avatar { width: 24px; height: 24px; border-radius: 50%; background: #c9a96e; color: #fff; font-size: .65rem; font-weight: 700; display: flex; align-items: center; justify-content: center; }
.blog-card__read { font-size: .75rem; color: #9ca3af; }
.blog-card__cta { display: inline-block; font-size: .8rem; font-weight: 600; color: #c9a96e; text-decoration: none; }
.blog-card__cta:hover { text-decoration: underline; }

/* Sidebar */
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
.sidebar-tag { display: inline-block; padding: .3rem .7rem; border-radius: 999px; font-size: .78rem; font-weight: 600; background: #f3e8d8; color: #92621a; text-decoration: none; transition: all .15s; }
.sidebar-tag:hover { background: #c9a96e; color: #fff; }
</style>
@endpush

@section('content')

{{-- Breadcrumb --}}
<div class="breadcrumb-bar">
    <div class="container">
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <ol>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li aria-current="page">Blog</li>
            </ol>
        </nav>
    </div>
</div>

{{-- Hero with Search --}}
<section class="blog-hero">
    <div class="container">
        <h1>Beauty Blog</h1>
        <p>Tips, tutorials, trends & expert advice from our beauty community</p>
        <form method="GET" action="{{ route('blog.index') }}" class="blog-search-bar">
            <input type="search" name="search" value="{{ request('search') }}" placeholder="Search articles…" aria-label="Search blog">
            <button type="submit">Search</button>
        </form>
    </div>
</section>

<div class="container blog-layout">

    {{-- Posts --}}
    <div>
        @if(request('search'))
            <p style="color:#6b7280;margin-bottom:1.25rem;font-size:.9rem;">
                {{ $posts->total() }} result(s) for "<strong>{{ request('search') }}</strong>"
                <a href="{{ route('blog.index') }}" style="color:#c9a96e;margin-left:.5rem;">Clear ×</a>
            </p>
        @endif

        @if($posts->isEmpty())
            <div style="text-align:center;padding:4rem 1rem;">
                <h3 style="color:#1a1a2e;margin-bottom:.5rem;">No posts found</h3>
                <p style="color:#6b7280;">Try a different search or check back soon.</p>
                <a href="{{ route('blog.index') }}" class="btn btn-primary" style="margin-top:1rem;">View All Posts</a>
            </div>
        @else
            <div class="blog-grid">
                @foreach($posts as $post)
                @include('blog._card', compact('post'))
                @endforeach
            </div>
            @if($posts->hasPages())
                <div class="pagination-wrap" style="margin-top:2.5rem;">{{ $posts->links() }}</div>
            @endif
        @endif
    </div>

    {{-- Sidebar --}}
    @include('blog._sidebar', compact('categories', 'recentPosts', 'allTags'))

</div>

@endsection
