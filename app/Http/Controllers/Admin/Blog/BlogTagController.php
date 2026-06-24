<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlogTagRequest;
use App\Models\BlogTag;

class BlogTagController extends Controller
{
    public function index()
    {
        $tags = BlogTag::withCount('posts')->orderBy('name')->paginate(50);
        return view('admin.blog.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('admin.blog.tags.form', ['tag' => new BlogTag]);
    }

    public function store(BlogTagRequest $request)
    {
        BlogTag::create($request->validated());
        return redirect()->route('admin.blog.tags.index')->with('success', 'Tag created.');
    }

    public function edit(BlogTag $tag)
    {
        return view('admin.blog.tags.form', compact('tag'));
    }

    public function update(BlogTagRequest $request, BlogTag $tag)
    {
        $tag->update($request->validated());
        return redirect()->route('admin.blog.tags.index')->with('success', 'Tag updated.');
    }

    public function destroy(BlogTag $tag)
    {
        $tag->delete();
        return back()->with('success', 'Tag deleted.');
    }
}
