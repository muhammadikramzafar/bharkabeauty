<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\HomeSetting;
use App\Models\HeroSlide;
use App\Models\HomepageBanner;
use App\Models\HomepageService;
use App\Models\HomepageCounter;
use App\Models\HomepageTestimonial;
use App\Models\HomepageFeatured;
use App\Models\HomepageLogo;
use App\Models\HomepageCta;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $setting = HomeSetting::instance();

        $heroSlides   = HeroSlide::active()->get();
        $services     = HomepageService::active()->get();
        $counters     = HomepageCounter::active()->get();
        $logos        = HomepageLogo::active()->get();
        $featured     = HomepageFeatured::active()->get();
        $testimonials = HomepageTestimonial::active()->get();
        $banners      = HomepageBanner::active()->get();
        $ctas         = HomepageCta::active()->get()->keyBy('section_key');

        // ── Real data from catalog ────────────────────────────────
        $rootCategories = Category::whereNull('parent_id')
            ->active()
            ->withCount('products')
            ->orderBy('sort_order')
            ->get();

        $featuredBrands = Brand::active()
            ->where('is_featured', true)
            ->withCount('products')
            ->orderBy('sort_order')
            ->get();

        $featuredProducts = Product::with(['category', 'brand'])
            ->active()
            ->where('is_featured', true)
            ->latest()
            ->limit(8)
            ->get();

        $newArrivals = Product::with(['category', 'brand'])
            ->active()
            ->latest()
            ->limit(8)
            ->get();

        $saleProducts = Product::with(['category', 'brand'])
            ->active()
            ->whereNotNull('sale_price')
            ->whereColumn('sale_price', '<', 'price')
            ->inRandomOrder()
            ->limit(8)
            ->get();

        return view('home', compact(
            'setting',
            'heroSlides',
            'services',
            'counters',
            'logos',
            'featured',
            'testimonials',
            'banners',
            'ctas',
            'rootCategories',
            'featuredBrands',
            'featuredProducts',
            'newArrivals',
            'saleProducts',
        ));
    }
}
