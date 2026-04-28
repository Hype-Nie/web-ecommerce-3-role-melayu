<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'seller_id', 'category_id', 'name', 'slug', 'description',
        'price', 'old_price', 'stock', 'is_active',
    ];

    protected $casts = [
        'price'     => 'decimal:2',
        'old_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    /* ---------- Relationships ---------- */
    public function seller(): BelongsTo    { return $this->belongsTo(User::class, 'seller_id'); }
    public function category(): BelongsTo  { return $this->belongsTo(Category::class); }
    public function images(): HasMany      { return $this->hasMany(ProductImage::class); }
    public function orderItems(): HasMany  { return $this->hasMany(OrderItem::class); }
    public function cartItems(): HasMany   { return $this->hasMany(CartItem::class); }

    public function primaryImage()
    {
        return $this->images()->where('is_primary', true)->first();
    }

    public function discountPercent(): ?int
    {
        if ($this->old_price && $this->old_price > $this->price) {
            return round((($this->old_price - $this->price) / $this->old_price) * 100);
        }
        return null;
    }
}
