<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('category'); // remote_server, hosting, network_setting
            $table->string('service_name'); // contoh: "Basic - Remote Server", "Load Balance"
            $table->string('price_label')->nullable(); // contoh: "Rp 2.000 / bulan"
            $table->text('notes')->nullable();
            $table->string('status')->default('pending'); // pending, diproses, selesai, dibatalkan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
