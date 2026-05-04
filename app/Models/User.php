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
        'name', 'campus_id', 'email', 'password', 'role', 'phone', 'shop_name',
        'is_active', 'is_seller', 'is_customer',
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
            'is_seller' => 'boolean',
            'is_customer' => 'boolean',
        ];
    }

    /* ---------- Role helpers ---------- */
    public function isAdmin(): bool   { return $this->role === 'admin'; }
    public function isSeller(): bool  { return $this->is_seller; }
    public function isCustomer(): bool { return $this->is_customer; }

    /* ---------- Relationships ---------- */
    public function products(): HasMany  { return $this->hasMany(Product::class, 'seller_id'); }
    public function orders(): HasMany    { return $this->hasMany(Order::class); }
    public function addresses(): HasMany { return $this->hasMany(Address::class); }
}
