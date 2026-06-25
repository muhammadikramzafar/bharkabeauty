<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request, ?string $cat = null)
    {
        $catSlug   = $cat;
        $subSlugs  = (array) $request->query('category', []);
        $brandSlugs= (array) $request->query('brand', []);
        $prices    = (array) $request->query('price', []);
        $avail     = (array) $request->query('availability', []);
        $sort      = $request->query('sort', 'featured');

        // ── Root category ────────────────────────────────────────
        $rootCategory = null;
        if ($catSlug && $catSlug !== 'all') {
            $rootCategory = Category::where('slug', $catSlug)
                ->whereNull('parent_id')
                ->first();
        }

        // ── Sidebar: sub-categories of this root (or root cats if no selection) ─
        if ($rootCategory) {
            $sidebarCategories = Category::where('parent_id', $rootCategory->id)
                ->active()
                ->withCount('products')
                ->orderBy('sort_order')
                ->get();
        } else {
            $sidebarCategories = Category::whereNull('parent_id')
                ->active()
                ->withCount('products')
                ->orderBy('sort_order')
                ->get();
        }

        // ── Sidebar: all active brands with product counts ────────
        $brands = Brand::active()
            ->withCount('products')
            ->orderBy('name')
            ->get();

        // ── Product query ─────────────────────────────────────────
        $query = Product::with(['category', 'brand'])->active();

        // Filter by root category (include all its sub-categories)
        if ($rootCategory) {
            $childIds = Category::where('parent_id', $rootCategory->id)->pluck('id');
            $query->where(function ($q) use ($rootCategory, $childIds) {
                $q->where('category_id', $rootCategory->id)
                  ->orWhereIn('category_id', $childIds);
            });
        }

        // Drill-down sub-category filter
        if (!empty($subSlugs)) {
            $subIds = Category::whereIn('slug', $subSlugs)->pluck('id');
            $query->whereIn('category_id', $subIds);
        }

        // Brand filter
        if (!empty($brandSlugs)) {
            $brandIds = Brand::whereIn('slug', $brandSlugs)->pluck('id');
            $query->whereIn('brand_id', $brandIds);
        }

        // Price range filter (OR between selected ranges)
        if (!empty($prices)) {
            $query->where(function ($q) use ($prices) {
                foreach ($prices as $range) {
                    if ($range === '10000+') {
                        $q->orWhere('price', '>=', 10000);
                    } elseif (str_contains((string) $range, '-')) {
                        [$min, $max] = explode('-', $range);
                        $q->orWhereBetween('price', [(int) $min, (int) $max]);
                    }
                }
            });
        }

        // Availability filters
        if (in_array('in_stock', $avail)) {
            $query->where('stock_qty', '>', 0);
        }
        if (in_array('on_sale', $avail)) {
            $query->whereNotNull('sale_price')->whereColumn('sale_price', '<', 'price');
        }

        // Sorting
        match ($sort) {
            'price-asc'  => $query->orderBy('price', 'asc'),
            'price-desc' => $query->orderBy('price', 'desc'),
            'newest'     => $query->latest(),
            default      => $query->orderByDesc('is_featured')->orderBy('sort_order')->orderBy('name'),
        };

        $products = $query->paginate(12)->withQueryString();

        $pageTitle = $rootCategory
            ? $rootCategory->name
            : ($catSlug === 'all' || !$catSlug ? 'Shop All' : ucfirst($catSlug));

        $pageDescription = $rootCategory
            ? ($rootCategory->description ?: 'Discover our curated collection of ' . $rootCategory->name . ' products.')
            : 'Discover our full collection of premium beauty products.';

        // Alias for sidebar partial
        $categories = $sidebarCategories;

        return view('category', compact(
            'products',
            'categories',
            'brands',
            'pageTitle',
            'pageDescription',
            'rootCategory',
        ));
    }
}
