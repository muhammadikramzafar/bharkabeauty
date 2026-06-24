<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SeoSetting extends Model
{
    protected $fillable = [
        'site_name', 'title_separator', 'default_title', 'default_description',
        'default_keywords', 'og_image', 'og_type', 'twitter_card', 'twitter_site',
        'google_analytics_id', 'google_tag_manager_id', 'facebook_pixel_id',
        'custom_head_code', 'custom_body_code', 'robots_txt', 'canonical_base_url',
    ];

    public static function instance(): self
    {
        return cache()->remember('seo_settings', 3600, function () {
            return static::firstOrCreate(['id' => 1], [
                'site_name'       => 'BharkaBeauty',
                'title_separator' => '—',
                'og_type'         => 'website',
                'twitter_card'    => 'summary_large_image',
                'robots_txt'      => "User-agent: *\nAllow: /\nDisallow: /admin/\n\nSitemap: " . url('/sitemap.xml'),
            ]);
        });
    }

    public static function clearCache(): void
    {
        cache()->forget('seo_settings');
    }

    public function getOgImageUrlAttribute(): ?string
    {
        return $this->og_image ? Storage::disk('public')->url($this->og_image) : null;
    }
}
