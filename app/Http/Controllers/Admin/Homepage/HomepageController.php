<?php

namespace App\Http\Controllers\Admin\Homepage;

use App\Http\Controllers\Controller;
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
use Illuminate\Support\Facades\Storage;

class HomepageController extends Controller
{
    public function index()
    {
        $setting = HomeSetting::instance();
        $counts  = [
            'hero'         => HeroSlide::where('is_active', true)->count(),
            'banners'      => HomepageBanner::where('is_active', true)->count(),
            'services'     => HomepageService::where('is_active', true)->count(),
            'counters'     => HomepageCounter::where('is_active', true)->count(),
            'testimonials' => HomepageTestimonial::where('is_active', true)->count(),
            'featured'     => HomepageFeatured::where('is_active', true)->count(),
            'logos'        => HomepageLogo::where('is_active', true)->count(),
            'ctas'         => HomepageCta::where('is_active', true)->count(),
        ];
        return view('admin.homepage.index', compact('setting', 'counts'));
    }

    public function settings()
    {
        $setting = HomeSetting::instance();
        return view('admin.homepage.settings', compact('setting'));
    }

    public function updateSettings(Request $request)
    {
        $data = $request->validate([
            'flash_sale_title'    => 'nullable|string|max:120',
            'flash_sale_subtitle' => 'nullable|string|max:255',
            'flash_sale_end'      => 'nullable|date',
            'show_flash_sale'     => 'nullable|boolean',
            'about_eyebrow'       => 'nullable|string|max:80',
            'about_title'         => 'nullable|string|max:180',
            'about_description'   => 'nullable|string|max:1000',
            'about_image'         => 'nullable|image|max:3072',
            'about_button_text'   => 'nullable|string|max:60',
            'about_button_url'    => 'nullable|string|max:255',
            'store_title'         => 'nullable|string|max:120',
            'store_description'   => 'nullable|string|max:500',
            'store_address'       => 'nullable|string|max:255',
            'store_hours'         => 'nullable|string|max:120',
            'store_button_text'   => 'nullable|string|max:60',
            'store_button_url'    => 'nullable|string|max:255',
            'newsletter_title'    => 'nullable|string|max:120',
            'newsletter_subtitle' => 'nullable|string|max:255',
            'show_hero'           => 'nullable|boolean',
            'show_categories'     => 'nullable|boolean',
            'show_brands'         => 'nullable|boolean',
            'show_featured'       => 'nullable|boolean',
            'show_about'          => 'nullable|boolean',
            'show_services'       => 'nullable|boolean',
            'show_counters'       => 'nullable|boolean',
            'show_testimonials'   => 'nullable|boolean',
            'show_store_cta'      => 'nullable|boolean',
            'show_newsletter'     => 'nullable|boolean',
            'seo_title'           => 'nullable|string|max:160',
            'seo_description'     => 'nullable|string|max:320',
            'seo_keywords'        => 'nullable|string|max:255',
        ]);

        // Booleans: unchecked checkboxes send nothing
        foreach (['show_flash_sale','show_hero','show_categories','show_brands','show_featured',
                  'show_about','show_services','show_counters','show_testimonials',
                  'show_store_cta','show_newsletter'] as $toggle) {
            $data[$toggle] = $request->boolean($toggle);
        }

        $setting = HomeSetting::instance();

        if ($request->hasFile('about_image')) {
            if ($setting->about_image) Storage::disk('public')->delete($setting->about_image);
            $data['about_image'] = $request->file('about_image')->store('homepage', 'public');
        }

        $setting->update($data);

        return redirect()->route('admin.homepage.settings')
            ->with('success', 'Homepage settings updated.');
    }
}
