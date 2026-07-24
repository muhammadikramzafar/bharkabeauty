@extends('layouts.app')
@section('title', $category->name . ' — Blog — Amsaz Cosmetics')
@section('meta_description', $category->description ?? 'Browse ' . $category->name . ' articles on Amsaz Cosmetics Blog.')

@push('styles')
<style>
.blog-layout { display: grid; grid-template-columns: 1fr 300px; gap: 2.5rem; padding: 3rem 0 4rem; }
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
.blog-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px,1fr)); gap: 1.75rem; }
.blog-card { background: #fff; border-radius: 14px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,.06); transition: transform .25s, box-shadow .25s; display: flex; flex-direction: column; }
.blog-card:hover { transform: translateY(-4px); box-shadow: 0 8px 28px rgba(0,0,0,.11); }
.blog-card__img { position: relative; height: 200px; overflow: hidden; background: #f9f5f0; display: block; }
.blog-card__img img { width: 100%; height: 100%; object-fit: cover; }
.blog-card__cat { position: absolute; top: .75rem; left: .75rem; background: rgba(201,169,110,.93); color: #fff; font-size: .72rem; font-weight: 700; padding: .3rem .7rem; border-radius: 999px; text-decoration: none; }
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
</style>
@endpush

@section('content')

<div class="breadcrumb-bar">
    <div class="container">
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <ol>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('blog.index') }}">Blog</a></li>
                <li aria-current="page">{{ $category->name }}</li>
            </ol>
        </nav>
    </div>
</div>

<section class="category-hero">
    <div class="container">
        <h1 class="category-hero__title">{{ $category->name }}</h1>
        <p class="category-hero__desc">
            {{ $category->description ?? 'Browse all ' . $category->name . ' articles.' }}
        </p>
    </div>
</section>

<div class="container blog-layout">

    <div>
        @if($posts->isEmpty())
            <div style="text-align:center;padding:4rem;color:#9ca3af;">
                <p>No posts in this category yet. <a href="{{ route('blog.index') }}" style="color:#c9a96e;">View all posts →</a></p>
            </div>
        @else
            <p style="font-size:.85rem;color:#6b7280;margin-bottom:1.25rem;">{{ $posts->total() }} articles in {{ $category->name }}</p>
            <div class="blog-grid">
                @foreach($posts as $post)
                @include('blog._card', compact('post'))
                @endforeach
            </div>
            @if($posts->hasPages())<div class="pagination-wrap" style="margin-top:2.5rem;">{{ $posts->links() }}</div>@endif
        @endif
    </div>

    @include('blog._sidebar', compact('categories', 'recentPosts', 'allTags'))

</div>
@endsection
