<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Service extends Model
{
    protected $fillable = [
        'service_category_id',
        'title', 'slug', 'excerpt', 'description',
        'banner_image', 'featured_image',
        'price', 'duration',
        'seo_title', 'seo_description', 'seo_keywords',
        'sort_order', 'status',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $model) {
            if (empty($model->slug)) {
                $model->slug = static::uniqueSlug($model->title);
            }
        });
    }

    public static function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i    = 2;
        while (static::where('slug', $slug)->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')->orderBy('sort_order');
    }

    public function getIsPublishedAttribute(): bool
    {
        return $this->status === 'published';
    }

    public function getBannerImageUrlAttribute(): ?string
    {
        return $this->banner_image ? Storage::disk('public')->url($this->banner_image) : null;
    }

    public function getFeaturedImageUrlAttribute(): ?string
    {
        return $this->featured_image ? Storage::disk('public')->url($this->featured_image) : null;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
