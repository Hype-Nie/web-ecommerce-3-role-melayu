<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'order_number', 'user_id', 'address_id',
        'subtotal', 'total',
        'status', 'payment_method', 'payment_status',
        'whatsapp_sent', 'notes',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'total' => 'decimal:2',
        'whatsapp_sent' => 'boolean',
    ];

    /* ---------- Relationships ---------- */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /* ---------- Helpers ---------- */
    public function statusLabel(): string
    {
        return match ($this->status) {
            'pending' => 'Menunggu',
            'sold' => 'Terjual',
            'processing' => 'Diproses',
            'shipped' => 'Dihantar',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => $this->status,
        };
    }

    public function statusBadge(): string
    {
        return match ($this->status) {
            'pending' => 'badge-info',
            'sold' => 'badge-success',
            'processing' => 'badge-warning',
            'shipped' => 'badge-success',
            'completed' => 'badge-gray',
            'cancelled' => 'badge-danger',
            default => 'badge-gray',
        };
    }

    public static function generateOrderNumber(): string
    {
        do {
            $num = 'CB'.date('ymd').str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        } while (static::where('order_number', $num)->exists());

        return $num;
    }
}
