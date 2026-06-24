<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServiceCategoryRequest;
use App\Models\ServiceCategory;
use Illuminate\Support\Facades\Storage;

class ServiceCategoryController extends Controller
{
    public function index()
    {
        $categories = ServiceCategory::withCount('services')->orderBy('sort_order')->orderBy('id')->paginate(30);
        return view('admin.service-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.service-categories.form', ['category' => new ServiceCategory]);
    }

    public function store(ServiceCategoryRequest $request)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('services/categories', 'public');
        }

        ServiceCategory::create($data);

        return redirect()->route('admin.service-categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(ServiceCategory $serviceCategory)
    {
        return view('admin.service-categories.form', ['category' => $serviceCategory]);
    }

    public function update(ServiceCategoryRequest $request, ServiceCategory $serviceCategory)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            if ($serviceCategory->image) Storage::disk('public')->delete($serviceCategory->image);
            $data['image'] = $request->file('image')->store('services/categories', 'public');
        }

        $serviceCategory->update($data);

        return redirect()->route('admin.service-categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(ServiceCategory $serviceCategory)
    {
        if ($serviceCategory->image) Storage::disk('public')->delete($serviceCategory->image);
        $serviceCategory->delete();

        return back()->with('success', 'Category deleted.');
    }
}
