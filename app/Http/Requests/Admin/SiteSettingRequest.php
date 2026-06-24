<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SiteSettingRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'company_name'        => 'required|string|max:100',
            'tagline'             => 'nullable|string|max:200',
            'logo'                => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:2048',
            'favicon'             => 'nullable|image|mimes:png,ico,jpg|max:512',
            'contact_email'       => 'nullable|email|max:100',
            'contact_phone'       => 'nullable|string|max:30',
            'contact_whatsapp'    => 'nullable|string|max:30',
            'contact_address'     => 'nullable|string|max:500',
            'social_facebook'     => 'nullable|url|max:255',
            'social_instagram'    => 'nullable|url|max:255',
            'social_twitter'      => 'nullable|url|max:255',
            'social_youtube'      => 'nullable|url|max:255',
            'social_tiktok'       => 'nullable|url|max:255',
            'social_pinterest'    => 'nullable|url|max:255',
            'footer_about'        => 'nullable|string|max:1000',
            'footer_copyright'    => 'nullable|string|max:200',
            'meta_title'          => 'nullable|string|max:160',
            'meta_description'    => 'nullable|string|max:320',
            'google_analytics_id' => 'nullable|string|max:30',
        ];
    }
}
