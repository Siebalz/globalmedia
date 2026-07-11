<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = ['user_id', 'product_id', 'qty'];

    public function product()
    {
        return $this->belongsTo(Product::class)->with('images');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** Subtotal item ini (qty × harga produk). */
    public function getSubtotalAttribute(): float
    {
        return $this->qty * (float) $this->product->price;
    }
}
