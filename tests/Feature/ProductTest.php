<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    // ─────────────────────────────────────────────────────────
    // AKSES PUBLIK
    // ─────────────────────────────────────────────────────────

    public function test_halaman_produk_bisa_diakses_publik(): void
    {
        $this->get(route('products.index'))
            ->assertStatus(200);
    }

    public function test_detail_produk_aktif_bisa_diakses_publik(): void
    {
        $product = Product::factory()->create(['is_active' => true]);

        $this->get(route('products.show', $product))
            ->assertStatus(200);
    }

    public function test_hanya_produk_aktif_muncul_di_listing(): void
    {
        Product::factory()->count(3)->create(['is_active' => true]);
        Product::factory()->count(2)->inactive()->create();

        $this->get(route('products.index'))->assertStatus(200);

        $this->assertEquals(3, Product::where('is_active', true)->count());
        $this->assertEquals(2, Product::where('is_active', false)->count());
    }

    // ─────────────────────────────────────────────────────────
    // AKSES KONTROL ADMIN
    // ─────────────────────────────────────────────────────────

    public function test_guest_tidak_bisa_akses_halaman_buat_produk(): void
    {
        $this->get(route('products.create'))
            ->assertRedirect(route('login'));
    }

    public function test_user_biasa_tidak_bisa_akses_halaman_buat_produk(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('products.create'))
            ->assertForbidden(); // EnsureUserIsAdmin return 403
    }

    public function test_admin_bisa_akses_halaman_buat_produk(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get(route('products.create'))
            ->assertStatus(200);
    }

    // ─────────────────────────────────────────────────────────
    // CRUD PRODUK (ADMIN)
    // ─────────────────────────────────────────────────────────

    public function test_admin_bisa_buat_produk_baru(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post(route('products.store'), [
                'name'        => 'Switch Cisco SG300',
                'category'    => 'switch',
                'price'       => 1500000,
                'description' => 'Switch managed 28 port',
                'is_active'   => true,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('products', [
            'name'  => 'Switch Cisco SG300',
            'price' => 1500000,
        ]);
    }

    public function test_admin_bisa_edit_produk(): void
    {
        Storage::fake('public');
        $admin   = User::factory()->admin()->create();
        $product = Product::factory()->create(['price' => 100000]);

        $this->actingAs($admin)
            ->put(route('products.update', $product), [
                'name'        => 'Nama Baru',
                'category'    => 'router',
                'price'       => 200000,
                'description' => 'Deskripsi baru',
                'is_active'   => true,
            ])
            ->assertRedirect();

        $this->assertEquals(200000, (int) $product->fresh()->price);
    }

    public function test_admin_bisa_hapus_produk(): void
    {
        $admin   = User::factory()->admin()->create();
        $product = Product::factory()->create();

        $this->actingAs($admin)
            ->delete(route('products.destroy', $product))
            ->assertRedirect();

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_user_biasa_tidak_bisa_hapus_produk(): void
    {
        $user    = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user)
            ->delete(route('products.destroy', $product))
            ->assertForbidden(); // EnsureUserIsAdmin return 403

        $this->assertDatabaseHas('products', ['id' => $product->id]);
    }

    // ─────────────────────────────────────────────────────────
    // VALIDASI INPUT
    // ─────────────────────────────────────────────────────────

    public function test_buat_produk_gagal_tanpa_nama(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post(route('products.store'), [
                'price'     => 100000,
                'is_active' => true,
            ])
            ->assertSessionHasErrors('name');
    }

    public function test_buat_produk_gagal_dengan_harga_negatif(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post(route('products.store'), [
                'name'  => 'Produk Test',
                'price' => -1000,
            ])
            ->assertSessionHasErrors('price');
    }
}
