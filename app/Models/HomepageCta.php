<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class HomepageCta extends Model
{
    protected $fillable = [
        'section_key', 'title', 'description', 'image',
        'button_text', 'button_url', 'extra_line1', 'extra_line2',
        'sort_order', 'is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? Storage::disk('public')->url($this->image) : null;
    }

    public static function forKey(string $key): ?self
    {
        return static::where('section_key', $key)->where('is_active', true)->first();
    }
}
