<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CmsPageRequest;
use App\Models\CmsPage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CmsPageController extends Controller
{
    public function index()
    {
        $pages = CmsPage::latest()->paginate(15);
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(CmsPageRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = auth()->id();

        if ($request->hasFile('banner_image')) {
            $data['banner_image'] = $request->file('banner_image')->store('pages', 'public');
        }

        CmsPage::create($data);
        return redirect()->route('admin.pages.index')->with('success', 'Page created successfully.');
    }

    public function edit(CmsPage $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(CmsPageRequest $request, CmsPage $page)
    {
        $data = $request->validated();

        if ($request->hasFile('banner_image')) {
            if ($page->banner_image) Storage::disk('public')->delete($page->banner_image);
            $data['banner_image'] = $request->file('banner_image')->store('pages', 'public');
        }

        $page->update($data);
        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully.');
    }

    public function destroy(CmsPage $page)
    {
        if ($page->banner_image) Storage::disk('public')->delete($page->banner_image);
        $page->delete();
        return redirect()->route('admin.pages.index')->with('success', 'Page deleted.');
    }

    public function show(CmsPage $page)
    {
        return redirect()->route('admin.pages.edit', $page);
    }
}
