<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServiceRequest;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with('category')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(20);

        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        $categories = ServiceCategory::active()->get();
        return view('admin.services.form', [
            'service'    => new Service,
            'categories' => $categories,
        ]);
    }

    public function store(ServiceRequest $request)
    {
        $data = $request->validated();

        foreach (['banner_image', 'featured_image'] as $field) {
            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store('services', 'public');
            }
        }

        Service::create($data);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service created successfully.');
    }

    public function edit(Service $service)
    {
        $categories = ServiceCategory::active()->get();
        return view('admin.services.form', compact('service', 'categories'));
    }

    public function update(ServiceRequest $request, Service $service)
    {
        $data = $request->validated();

        foreach (['banner_image', 'featured_image'] as $field) {
            if ($request->hasFile($field)) {
                if ($service->$field) Storage::disk('public')->delete($service->$field);
                $data[$field] = $request->file($field)->store('services', 'public');
            }
        }

        $service->update($data);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        foreach (['banner_image', 'featured_image'] as $f) {
            if ($service->$f) Storage::disk('public')->delete($service->$f);
        }
        $service->delete();

        return back()->with('success', 'Service deleted.');
    }
}
