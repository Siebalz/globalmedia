<?php

namespace Tests\Unit;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Unit test untuk generateUniqueSlug.
 * Butuh database karena cek duplikat.
 */
class ProductSlugTest extends TestCase
{
    use RefreshDatabase;

    public function test_slug_dibuat_dari_nama(): void
    {
        $slug = Product::generateUniqueSlug('Router TP-Link Archer C6');

        $this->assertEquals('router-tp-link-archer-c6', $slug);
    }

    public function test_slug_unik_saat_sudah_ada(): void
    {
        Product::factory()->create(['slug' => 'router-tp-link']);

        $slug = Product::generateUniqueSlug('Router TP-Link');

        $this->assertEquals('router-tp-link-1', $slug);
    }

    public function test_slug_increment_terus_saat_banyak_duplikat(): void
    {
        Product::factory()->create(['slug' => 'switch-cisco']);
        Product::factory()->create(['slug' => 'switch-cisco-1']);
        Product::factory()->create(['slug' => 'switch-cisco-2']);

        $slug = Product::generateUniqueSlug('Switch Cisco');

        $this->assertEquals('switch-cisco-3', $slug);
    }

    public function test_slug_tidak_konflik_dengan_produk_sendiri_saat_update(): void
    {
        $product = Product::factory()->create(['slug' => 'access-point-ubiquiti']);

        // Update nama produk yang sama — slug seharusnya tetap sama
        $slug = Product::generateUniqueSlug('Access Point Ubiquiti', $product->id);

        $this->assertEquals('access-point-ubiquiti', $slug);
    }
}
