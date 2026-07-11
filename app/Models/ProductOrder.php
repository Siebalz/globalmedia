<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Pesanan produk fisik (perangkat jaringan second).
 * Berbeda dari Order yang dipakai untuk layanan/jasa.
 */
class ProductOrder extends Model
{
    protected $fillable = [
        'user_id',
        'total_price',
        'payment_proof',   // path file bukti transfer
        'notes',
        'status',          // pending | confirmed | shipped | done | cancelled
        'tracking_number',
        'courier',
    ];

    public const STATUSES = [
        'pending'    => 'Menunggu Konfirmasi',
        'confirmed'  => 'Dikonfirmasi',
        'shipped'    => 'Dikirim',
        'done'       => 'Selesai',
        'cancelled'  => 'Dibatalkan',
    ];

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(ProductOrderItem::class);
    }
}
