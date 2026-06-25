<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'brand_id', 'name', 'slug', 'sku',
        'short_description', 'description', 'price', 'sale_price',
        'stock_qty', 'images', 'is_featured', 'is_active', 'sort_order',
        'seo_title', 'seo_description', 'seo_keywords',
    ];

    protected $casts = [
        'is_active'   => 'boolean',
        'is_featured' => 'boolean',
        'images'      => 'array',
        'price'       => 'decimal:2',
        'sale_price'  => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::saving(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

    public function category() { return $this->belongsTo(Category::class); }
    public function brand()    { return $this->belongsTo(Brand::class); }

    public function scopeActive($q)   { return $q->where('is_active', true); }
    public function scopeFeatured($q) { return $q->where('is_featured', true); }

    public function getRouteKeyName(): string { return 'slug'; }

    public function getCurrentPriceAttribute(): float
    {
        return $this->sale_price && $this->sale_price < $this->price
            ? (float) $this->sale_price
            : (float) $this->price;
    }

    public function getFirstImageUrlAttribute(): ?string
    {
        $images = $this->images ?? [];
        if (empty($images)) return null;
        return Storage::disk('public')->url($images[0]);
    }

    public function getMainImageAttribute(): string
    {
        return $this->first_image_url
            ?? 'https://images.unsplash.com/photo-1583241800698-e8ab01830a22?w=600&h=600&fit=crop';
    }

    public function getAllImageUrlsAttribute(): array
    {
        $images = $this->images ?? [];
        return array_map(fn ($img) => Storage::disk('public')->url($img), $images);
    }

    public function getDiscountPercentAttribute(): int
    {
        if (!$this->sale_price || $this->sale_price >= $this->price || !$this->price) return 0;
        return (int) round((($this->price - $this->sale_price) / $this->price) * 100);
    }

    public function getIsOnSaleAttribute(): bool
    {
        return $this->sale_price && $this->sale_price < $this->price;
    }
}
