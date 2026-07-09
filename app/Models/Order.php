<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'category',
        'service_name',
        'price_label',
        'notes',
        'status',
        'activated_at',
        'expired_at',
    ];

    protected $casts = [
        'activated_at' => 'datetime',
        'expired_at' => 'datetime',
    ];

    // Status yang dianggap "layanan aktif" (muncul di Server Saya).
    public const ACTIVE_STATUSES = ['diproses', 'selesai'];

    public const STATUSES = [
        'pending' => 'Menunggu Konfirmasi',
        'diproses' => 'Diproses',
        'selesai' => 'Selesai',
        'dibatalkan' => 'Dibatalkan',
        'expired' => 'Expired',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'order-badge-pending',
            'diproses' => 'order-badge-process',
            'selesai' => 'order-badge-done',
            'dibatalkan' => 'order-badge-cancel',
            'expired' => 'order-badge-expired',
            default => 'order-badge-pending',
        };
    }

    /**
     * Apakah layanan ini sudah lewat tanggal expired tapi statusnya
     * belum diupdate jadi "expired" (misal: belum sempat dijalankan scheduler).
     */
    public function getIsExpiredAttribute(): bool
    {
        return $this->expired_at !== null
            && $this->expired_at->isPast()
            && in_array($this->status, self::ACTIVE_STATUSES, true);
    }

    /**
     * Sisa hari sebelum layanan ini expired. Null kalau belum aktif/tidak punya expired_at.
     */
    public function getDaysUntilExpiredAttribute(): ?int
    {
        if (! $this->expired_at) {
            return null;
        }

        return (int) Carbon::now()->startOfDay()->diffInDays($this->expired_at->copy()->startOfDay(), false);
    }

    /**
     * Aktifkan layanan: tandai mulai aktif sekarang dan set expired 1 bulan
     * ke depan. Tidak menimpa activated_at/expired_at yang sudah ada,
     * supaya tanggal aktif tidak ikut bergeser setiap admin menyentuh status.
     */
    public function activateForOneMonth(): void
    {
        if ($this->activated_at === null) {
            $this->activated_at = now();
        }

        if ($this->expired_at === null) {
            $this->expired_at = Carbon::parse($this->activated_at)->addMonth();
        }
    }

    /**
     * Perpanjang masa aktif layanan 1 bulan dari sekarang
     * (dipakai misalnya saat user bayar ulang/perpanjang).
     */
    public function renewForOneMonth(): void
    {
        $base = $this->expired_at && $this->expired_at->isFuture()
            ? $this->expired_at
            : now();

        $this->activated_at = $this->activated_at ?? now();
        $this->expired_at = Carbon::parse($base)->addMonth();
        $this->status = 'diproses';
        $this->save();
    }

    /**
     * Scope: order yang sudah lewat expired_at tapi statusnya masih aktif.
     */
    public function scopeDueForExpiry($query)
    {
        return $query->whereIn('status', self::ACTIVE_STATUSES)
            ->whereNotNull('expired_at')
            ->where('expired_at', '<=', now());
    }
}
