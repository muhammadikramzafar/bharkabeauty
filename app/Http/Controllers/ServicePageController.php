<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class ServicePageController extends Controller
{
    public function index(Request $request)
    {
        $categories = ServiceCategory::active()->withCount('publishedServices')->get();

        $query = Service::published()->with('category');

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
            $activeCategory = $categories->firstWhere('slug', $request->category);
        }

        $services = $query->paginate(12)->withQueryString();

        return view('services.index', [
            'services'       => $services,
            'categories'     => $categories,
            'activeCategory' => $activeCategory ?? null,
        ]);
    }

    public function show(string $slug)
    {
        $service = Service::where('slug', $slug)
            ->where('status', 'published')
            ->with('category')
            ->firstOrFail();

        $related = Service::published()
            ->where('id', '!=', $service->id)
            ->when($service->service_category_id, fn($q) =>
                $q->where('service_category_id', $service->service_category_id)
            )
            ->limit(3)
            ->get();

        return view('services.show', compact('service', 'related'));
    }
}
