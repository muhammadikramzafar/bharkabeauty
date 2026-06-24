<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'company_name', 'logo', 'favicon', 'tagline',
        'contact_email', 'contact_phone', 'contact_whatsapp', 'contact_address',
        'social_facebook', 'social_instagram', 'social_twitter',
        'social_youtube', 'social_tiktok', 'social_pinterest',
        'footer_about', 'footer_copyright',
        'meta_title', 'meta_description', 'google_analytics_id',
    ];

    public static function instance(): self
    {
        return static::firstOrCreate(['id' => 1]);
    }
}
