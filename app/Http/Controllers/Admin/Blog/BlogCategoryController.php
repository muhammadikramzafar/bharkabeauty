<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlogCategoryRequest;
use App\Models\BlogCategory;
use Illuminate\Support\Facades\Storage;

class BlogCategoryController extends Controller
{
    public function index()
    {
        $categories = BlogCategory::withCount('posts')->orderBy('sort_order')->orderBy('id')->paginate(30);
        return view('admin.blog.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.blog.categories.form', ['category' => new BlogCategory]);
    }

    public function store(BlogCategoryRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('blog/categories', 'public');
        }
        BlogCategory::create($data);
        return redirect()->route('admin.blog.categories.index')->with('success', 'Category created.');
    }

    public function edit(BlogCategory $category)
    {
        return view('admin.blog.categories.form', compact('category'));
    }

    public function update(BlogCategoryRequest $request, BlogCategory $category)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            if ($category->image) Storage::disk('public')->delete($category->image);
            $data['image'] = $request->file('image')->store('blog/categories', 'public');
        }
        $category->update($data);
        return redirect()->route('admin.blog.categories.index')->with('success', 'Category updated.');
    }

    public function destroy(BlogCategory $category)
    {
        if ($category->image) Storage::disk('public')->delete($category->image);
        $category->delete();
        return back()->with('success', 'Category deleted.');
    }
}
