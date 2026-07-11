<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOrderItem extends Model
{
    protected $fillable = [
        'product_order_id',
        'product_id',
        'product_name',   // snapshot nama saat checkout (produk bisa dihapus)
        'price',          // snapshot harga saat checkout
        'qty',
    ];

    protected $casts = ['price' => 'decimal:2'];

    public function product()
    {
        return $this->belongsTo(Product::class)->withDefault();
    }

    public function order()
    {
        return $this->belongsTo(ProductOrder::class, 'product_order_id');
    }

    public function getSubtotalAttribute(): float
    {
        return $this->qty * (float) $this->price;
    }
}
