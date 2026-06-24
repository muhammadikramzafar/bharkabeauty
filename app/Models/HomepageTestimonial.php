<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class HomepageTestimonial extends Model
{
    protected $fillable = [
        'reviewer_name', 'reviewer_location', 'review_text', 'rating',
        'reviewer_image', 'product_brand', 'product_name', 'product_image',
        'sort_order', 'is_active',
    ];

    protected $casts = ['is_active' => 'boolean', 'rating' => 'integer'];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function getReviewerImageUrlAttribute(): ?string
    {
        return $this->reviewer_image ? Storage::disk('public')->url($this->reviewer_image) : null;
    }

    public function getProductImageUrlAttribute(): ?string
    {
        return $this->product_image ? Storage::disk('public')->url($this->product_image) : null;
    }
}
