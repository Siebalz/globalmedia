<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Kapan layanan ini mulai diaktifkan (saat admin set status diproses/selesai).
            $table->timestamp('activated_at')->nullable()->after('status');

            // Kapan layanan ini akan/sudah expired. Default 1 bulan dari activated_at.
            $table->timestamp('expired_at')->nullable()->after('activated_at');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['activated_at', 'expired_at']);
        });
    }
};
