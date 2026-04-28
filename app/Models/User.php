<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'phone', 'shop_name', 'is_active',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /* ---------- Role helpers ---------- */
    public function isAdmin(): bool   { return $this->role === 'admin'; }
    public function isSeller(): bool  { return $this->role === 'seller'; }
    public function isCustomer(): bool { return $this->role === 'customer'; }

    /* ---------- Relationships ---------- */
    public function products(): HasMany  { return $this->hasMany(Product::class, 'seller_id'); }
    public function orders(): HasMany    { return $this->hasMany(Order::class); }
    public function addresses(): HasMany { return $this->hasMany(Address::class); }
    public function cartItems(): HasMany { return $this->hasMany(CartItem::class); }
}
