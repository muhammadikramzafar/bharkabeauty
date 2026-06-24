<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;
use Illuminate\Http\Request;

class BlogPageController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogPost::published()->with('category', 'author', 'tags');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) =>
                $q->where('title', 'like', "%$s%")
                  ->orWhere('excerpt', 'like', "%$s%")
                  ->orWhere('content', 'like', "%$s%")
            );
        }

        $posts      = $query->paginate(9)->withQueryString();
        $categories = BlogCategory::active()->withCount('publishedPosts')->get();
        $recentPosts= BlogPost::published()->with('category')->limit(5)->get();
        $allTags    = BlogTag::has('posts')->withCount('posts')->orderByDesc('posts_count')->limit(20)->get();

        return view('blog.index', compact('posts', 'categories', 'recentPosts', 'allTags'));
    }

    public function show(string $slug)
    {
        $post = BlogPost::where('slug', $slug)
            ->with('category', 'author', 'tags')
            ->firstOrFail();

        abort_if(!$post->is_live, 404);

        $related = BlogPost::published()
            ->where('id', '!=', $post->id)
            ->when($post->blog_category_id, fn($q) => $q->where('blog_category_id', $post->blog_category_id))
            ->with('category')
            ->limit(3)
            ->get();

        $categories = BlogCategory::active()->withCount('publishedPosts')->get();
        $recentPosts= BlogPost::published()->where('id', '!=', $post->id)->with('category')->limit(5)->get();
        $allTags    = BlogTag::has('posts')->withCount('posts')->orderByDesc('posts_count')->limit(20)->get();

        return view('blog.show', compact('post', 'related', 'categories', 'recentPosts', 'allTags'));
    }

    public function category(string $slug)
    {
        $category = BlogCategory::where('slug', $slug)->where('is_active', true)->firstOrFail();

        $posts      = BlogPost::published()
            ->where('blog_category_id', $category->id)
            ->with('author', 'tags')
            ->paginate(9);
        $categories = BlogCategory::active()->withCount('publishedPosts')->get();
        $recentPosts= BlogPost::published()->with('category')->limit(5)->get();
        $allTags    = BlogTag::has('posts')->withCount('posts')->orderByDesc('posts_count')->limit(20)->get();

        return view('blog.category', compact('category', 'posts', 'categories', 'recentPosts', 'allTags'));
    }

    public function tag(string $slug)
    {
        $tag = BlogTag::where('slug', $slug)->firstOrFail();

        $posts = BlogPost::published()
            ->whereHas('tags', fn($q) => $q->where('blog_tags.id', $tag->id))
            ->with('category', 'author')
            ->paginate(9);
        $categories = BlogCategory::active()->withCount('publishedPosts')->get();
        $recentPosts= BlogPost::published()->with('category')->limit(5)->get();
        $allTags    = BlogTag::has('posts')->withCount('posts')->orderByDesc('posts_count')->limit(20)->get();

        return view('blog.tag', compact('tag', 'posts', 'categories', 'recentPosts', 'allTags'));
    }
}
