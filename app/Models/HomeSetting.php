<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeSetting extends Model
{
    protected $table = 'home_settings';

    protected $fillable = [
        'flash_sale_title', 'flash_sale_subtitle', 'flash_sale_end', 'show_flash_sale',
        'about_eyebrow', 'about_title', 'about_description', 'about_image',
        'about_button_text', 'about_button_url',
        'store_title', 'store_description', 'store_address', 'store_hours',
        'store_image', 'store_button_text', 'store_button_url',
        'newsletter_title', 'newsletter_subtitle',
        'show_hero', 'show_categories', 'show_brands', 'show_featured',
        'show_about', 'show_services', 'show_counters', 'show_testimonials',
        'show_store_cta', 'show_newsletter',
        'seo_title', 'seo_description', 'seo_keywords',
    ];

    protected $casts = [
        'flash_sale_end'   => 'datetime',
        'show_flash_sale'  => 'boolean',
        'show_hero'        => 'boolean',
        'show_categories'  => 'boolean',
        'show_brands'      => 'boolean',
        'show_featured'    => 'boolean',
        'show_about'       => 'boolean',
        'show_services'    => 'boolean',
        'show_counters'    => 'boolean',
        'show_testimonials'=> 'boolean',
        'show_store_cta'   => 'boolean',
        'show_newsletter'  => 'boolean',
    ];

    public static function instance(): self
    {
        return static::firstOrCreate(['id' => 1]);
    }
}
