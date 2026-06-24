<?php

namespace App\Http\Controllers\Admin\Homepage;

use App\Http\Controllers\Controller;
use App\Models\HomepageService;
use Illuminate\Http\Request;

class HomepageServiceController extends Controller
{
    public function index()
    {
        $services = HomepageService::orderBy('sort_order')->orderBy('id')->paginate(20);
        return view('admin.homepage.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.homepage.services.form', ['service' => new HomepageService]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');
        HomepageService::create($data);
        return redirect()->route('admin.homepage.services.index')->with('success', 'Service created.');
    }

    public function edit(HomepageService $service)
    {
        return view('admin.homepage.services.form', compact('service'));
    }

    public function update(Request $request, HomepageService $service)
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');
        $service->update($data);
        return redirect()->route('admin.homepage.services.index')->with('success', 'Service updated.');
    }

    public function destroy(HomepageService $service)
    {
        $service->delete();
        return back()->with('success', 'Service deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'icon'        => 'nullable|string|max:2000',
            'icon_type'   => 'required|in:svg,emoji',
            'title'       => 'required|string|max:120',
            'description' => 'nullable|string|max:255',
            'sort_order'  => 'nullable|integer|min:0',
        ]);
    }
}
