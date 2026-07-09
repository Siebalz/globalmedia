<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('category')->nullable(); // contoh: Thermal 58mm, Thermal 80mm, A4, dst
            $table->decimal('price', 12, 2)->default(0);
            $table->text('description')->nullable();
            $table->string('image')->nullable(); // path gambar preview produk
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sold_count')->default(0); // jumlah terjual (tampilan saja)
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
