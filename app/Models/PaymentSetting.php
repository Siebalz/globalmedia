<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentSetting extends Model
{
    protected $fillable = [
        'qris_image',
        'notes',
        'is_active',        // legacy — masih disimpan agar data lama tidak rusak
        'qris_is_active',   // toggle khusus QRIS
        'bca_is_active',    // toggle khusus Transfer BCA
        'bca_account_number',
        'bca_account_name',
    ];

    protected $casts = [
        'is_active'      => 'boolean',
        'qris_is_active' => 'boolean',
        'bca_is_active'  => 'boolean',
    ];

    /**
     * Ambil baris setting (selalu 1 baris saja / singleton).
     * Kalau belum ada, otomatis dibuat dengan semua metode aktif.
     */
    public static function current(): self
    {
        return static::firstOrCreate(['id' => 1], [
            'is_active'      => true,
            'qris_is_active' => true,
            'bca_is_active'  => true,
        ]);
    }

    /** Apakah QRIS boleh ditampilkan (aktif DAN gambar sudah ada). */
    public function qrisVisible(): bool
    {
        return $this->qris_is_active && (bool) $this->qris_image;
    }

    /** Apakah Transfer BCA boleh ditampilkan (aktif DAN nomor rekening sudah diisi). */
    public function bcaVisible(): bool
    {
        return $this->bca_is_active && (bool) $this->bca_account_number;
    }
}
