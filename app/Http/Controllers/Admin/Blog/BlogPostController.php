<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlogPostRequest;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogPostController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogPost::with('category', 'author')
            ->when($request->filled('status'), fn($q) => $q->where('status', $request->status))
            ->when($request->filled('category'), fn($q) => $q->where('blog_category_id', $request->category))
            ->when($request->filled('search'), fn($q) => $q->where('title', 'like', '%' . $request->search . '%'))
            ->latest('id');

        $posts      = $query->paginate(20)->withQueryString();
        $categories = BlogCategory::active()->get();
        $counts     = [
            'all'       => BlogPost::count(),
            'published' => BlogPost::where('status', 'published')->count(),
            'draft'     => BlogPost::where('status', 'draft')->count(),
            'scheduled' => BlogPost::where('status', 'scheduled')->count(),
        ];

        return view('admin.blog.posts.index', compact('posts', 'categories', 'counts'));
    }

    public function create()
    {
        $categories = BlogCategory::active()->get();
        $tags       = BlogTag::orderBy('name')->get();
        $authors    = User::orderBy('name')->get();
        return view('admin.blog.posts.form', [
            'post'       => new BlogPost,
            'categories' => $categories,
            'tags'       => $tags,
            'authors'    => $authors,
            'postTags'   => collect(),
        ]);
    }

    public function store(BlogPostRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('blog/posts', 'public');
        }

        $tagIds = $data['tags'] ?? [];
        unset($data['tags']);

        $post = BlogPost::create($data);
        if ($tagIds) $post->tags()->sync($tagIds);

        return redirect()->route('admin.blog.posts.index')->with('success', 'Post created successfully.');
    }

    public function edit(BlogPost $post)
    {
        $categories = BlogCategory::active()->get();
        $tags       = BlogTag::orderBy('name')->get();
        $authors    = User::orderBy('name')->get();
        $postTags   = $post->tags->pluck('id');
        return view('admin.blog.posts.form', compact('post', 'categories', 'tags', 'authors', 'postTags'));
    }

    public function update(BlogPostRequest $request, BlogPost $post)
    {
        $data = $request->validated();

        if ($request->hasFile('featured_image')) {
            if ($post->featured_image) Storage::disk('public')->delete($post->featured_image);
            $data['featured_image'] = $request->file('featured_image')->store('blog/posts', 'public');
        }

        $tagIds = $data['tags'] ?? [];
        unset($data['tags']);

        $post->update($data);
        $post->tags()->sync($tagIds);

        return redirect()->route('admin.blog.posts.index')->with('success', 'Post updated successfully.');
    }

    public function show(BlogPost $post)
    {
        return redirect()->route('blog.show', $post->slug);
    }

    public function destroy(BlogPost $post)
    {
        if ($post->featured_image) Storage::disk('public')->delete($post->featured_image);
        $post->tags()->detach();
        $post->delete();
        return back()->with('success', 'Post deleted.');
    }
}
