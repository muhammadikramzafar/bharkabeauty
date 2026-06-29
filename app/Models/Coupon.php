<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = ['code', 'type', 'value', 'min_order', 'max_uses', 'used_count', 'expires_at', 'active'];

    protected $casts = ['expires_at' => 'datetime', 'active' => 'boolean'];

    public function isValid(float $subtotal): bool
    {
        if (!$this->active) return false;
        if ($this->expires_at && $this->expires_at->isPast()) return false;
        if ($this->max_uses && $this->used_count >= $this->max_uses) return false;
        if ($subtotal < $this->min_order) return false;
        return true;
    }

    public function discountAmount(float $subtotal): float
    {
        if ($this->type === 'percent') {
            return round($subtotal * $this->value / 100);
        }
        return min((float) $this->value, $subtotal);
    }
}
