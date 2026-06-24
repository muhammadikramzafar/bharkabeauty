<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\CmsPage;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\SeoSetting;

class SeoController extends Controller
{
    public function sitemap()
    {
        $seo         = SeoSetting::instance();
        $posts       = BlogPost::published()->select('slug', 'updated_at')->get();
        $blogCats    = BlogCategory::active()->select('slug', 'updated_at')->get();
        $services    = Service::published()->select('slug', 'updated_at')->get();
        $serviceCats = ServiceCategory::active()->select('slug', 'updated_at')->get();
        $pages       = CmsPage::where('status', 'published')->select('slug', 'updated_at')->get();

        $content = view('seo.sitemap', compact(
            'seo', 'posts', 'blogCats', 'services', 'serviceCats', 'pages'
        ))->render();

        return response($content, 200)->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    public function robots()
    {
        $seo     = SeoSetting::instance();
        $content = $seo->robots_txt
            ?: "User-agent: *\nAllow: /\nDisallow: /admin/\n\nSitemap: " . url('/sitemap.xml');

        return response($content, 200)->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}
