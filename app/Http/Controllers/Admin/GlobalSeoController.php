<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GlobalSeoController extends Controller
{
    public function index()
    {
        $seo = SeoSetting::firstOrCreate(['id' => 1]);
        return view('admin.seo.index', compact('seo'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name'              => 'nullable|string|max:120',
            'title_separator'        => 'nullable|string|max:10',
            'default_title'          => 'nullable|string|max:160',
            'default_description'    => 'nullable|string|max:320',
            'default_keywords'       => 'nullable|string|max:255',
            'og_image'               => 'nullable|image|max:3072',
            'og_type'                => 'nullable|string|max:40',
            'twitter_card'           => 'nullable|string|max:40',
            'twitter_site'           => 'nullable|string|max:80',
            'google_analytics_id'    => 'nullable|string|max:60',
            'google_tag_manager_id'  => 'nullable|string|max:60',
            'facebook_pixel_id'      => 'nullable|string|max:60',
            'custom_head_code'       => 'nullable|string',
            'custom_body_code'       => 'nullable|string',
            'robots_txt'             => 'nullable|string',
            'canonical_base_url'     => 'nullable|url|max:255',
        ]);

        $seo  = SeoSetting::firstOrCreate(['id' => 1]);
        $data = $request->except(['_token', '_method', 'og_image']);

        if ($request->hasFile('og_image')) {
            if ($seo->og_image) Storage::disk('public')->delete($seo->og_image);
            $data['og_image'] = $request->file('og_image')->store('seo', 'public');
        }

        $seo->update($data);
        SeoSetting::clearCache();

        return back()->with('success', 'SEO settings saved.');
    }
}
