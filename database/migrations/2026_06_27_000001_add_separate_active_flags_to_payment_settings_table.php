<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Pisahkan is_active menjadi dua flag terpisah:
     *   qris_is_active  → tampil/sembunyikan metode QRIS
     *   bca_is_active   → tampil/sembunyikan metode Transfer BCA
     *
     * Kolom is_active lama tetap ada (tidak di-drop) untuk kompatibilitas
     * data lama; nilai-nya disalin ke kedua kolom baru saat migrate.
     */
    public function up(): void
    {
        Schema::table('payment_settings', function (Blueprint $table) {
            $table->boolean('qris_is_active')->default(true)->after('is_active');
            $table->boolean('bca_is_active')->default(true)->after('qris_is_active');
        });

        // Salin nilai is_active lama ke kedua kolom baru
        DB::table('payment_settings')->update([
            'qris_is_active' => DB::raw('is_active'),
            'bca_is_active'  => DB::raw('is_active'),
        ]);
    }

    public function down(): void
    {
        Schema::table('payment_settings', function (Blueprint $table) {
            $table->dropColumn(['qris_is_active', 'bca_is_active']);
        });
    }
};
