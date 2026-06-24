<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CmsPage extends Model
{
    protected $fillable = [
        'title', 'slug', 'banner_image', 'description',
        'status', 'seo_title', 'seo_description', 'seo_keywords', 'created_by',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
        });
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
