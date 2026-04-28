<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'order_number', 'user_id', 'address_id', 'shipping_type_id',
        'subtotal', 'shipping_cost', 'total',
        'status', 'payment_method', 'payment_status',
        'tracking_number', 'notes',
    ];

    protected $casts = [
        'subtotal'      => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'total'         => 'decimal:2',
    ];

    /* ---------- Relationships ---------- */
    public function user(): BelongsTo         { return $this->belongsTo(User::class); }
    public function address(): BelongsTo      { return $this->belongsTo(Address::class); }
    public function shippingType(): BelongsTo { return $this->belongsTo(ShippingType::class); }
    public function items(): HasMany          { return $this->hasMany(OrderItem::class); }

    /* ---------- Helpers ---------- */
    public function statusLabel(): string
    {
        return match ($this->status) {
            'pending'    => 'Menunggu',
            'processing' => 'Diproses',
            'shipped'    => 'Dihantar',
            'completed'  => 'Selesai',
            'cancelled'  => 'Dibatalkan',
            default      => $this->status,
        };
    }

    public function statusBadge(): string
    {
        return match ($this->status) {
            'pending'    => 'badge-info',
            'processing' => 'badge-warning',
            'shipped'    => 'badge-success',
            'completed'  => 'badge-gray',
            'cancelled'  => 'badge-danger',
            default      => 'badge-gray',
        };
    }

    public static function generateOrderNumber(): string
    {
        $last = static::orderBy('id', 'desc')->first();
        $num  = $last ? intval(substr($last->order_number, 2)) + 1 : 1001;
        return 'KD' . $num;
    }
}
