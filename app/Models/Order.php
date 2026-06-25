<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'order_number', 'status', 'payment_method', 'payment_status',
        'subtotal', 'discount', 'shipping', 'total', 'shipping_address', 'notes',
    ];

    protected $casts = [
        'shipping_address' => 'array',
        'subtotal'  => 'decimal:2',
        'discount'  => 'decimal:2',
        'shipping'  => 'decimal:2',
        'total'     => 'decimal:2',
    ];

    public function user()  { return $this->belongsTo(User::class); }
    public function items() { return $this->hasMany(OrderItem::class); }

    public function scopeByStatus($q, string $status) { return $q->where('status', $status); }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending'    => '#d97706',
            'confirmed'  => '#2563eb',
            'processing' => '#7c3aed',
            'shipped'    => '#0891b2',
            'delivered'  => '#16a34a',
            'cancelled'  => '#dc2626',
            'refunded'   => '#6b7280',
            default      => '#6b7280',
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'delivered'  => 'badge-published',
            'cancelled','refunded' => 'badge-inactive',
            'pending'    => 'badge-new',
            default      => 'badge-scheduled',
        };
    }

    protected static function booted(): void
    {
        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = 'BB-' . strtoupper(substr(uniqid(), -6));
            }
        });
    }
}
