<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public const ROLES = ['admin', 'uploader', 'user'];

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isUploader(): bool
    {
        return $this->role === 'uploader';
    }

    // Admin dan uploader boleh menambah dan mengedit produk
    public function canManageProducts(): bool
    {
        return $this->isAdmin() || $this->isUploader();
    }

    public function roleLabel(): string
    {
        return match ($this->role) {
            'admin'    => 'Admin',
            'uploader' => 'Uploader',
            default    => 'User',
        };
    }

    // Relasi ke keranjang belanja (produk fisik)
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    // Relasi ke pesanan produk fisik
    public function productOrders()
    {
        return $this->hasMany(ProductOrder::class);
    }

    // Relasi ke pesanan layanan/jasa (existing)
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
