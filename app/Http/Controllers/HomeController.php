<?php

namespace App\Http\Controllers;

use App\Models\HomeSetting;
use App\Models\HeroSlide;
use App\Models\HomepageBanner;
use App\Models\HomepageService;
use App\Models\HomepageCounter;
use App\Models\HomepageTestimonial;
use App\Models\HomepageFeatured;
use App\Models\HomepageLogo;
use App\Models\HomepageCta;
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

        return view('home', compact(
            'setting',
            'heroSlides',
            'services',
            'counters',
            'logos',
            'featured',
            'testimonials',
            'banners',
            'ctas'
        ));
    }
}
