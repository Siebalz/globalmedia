<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_orders', function (Blueprint $table) {
            $table->string('tracking_number')->nullable()->after('payment_proof');
            $table->string('courier')->nullable()->after('tracking_number'); // nama ekspedisi
        });
    }

    public function down(): void
    {
        Schema::table('product_orders', function (Blueprint $table) {
            $table->dropColumn(['tracking_number', 'courier']);
        });
    }
};
