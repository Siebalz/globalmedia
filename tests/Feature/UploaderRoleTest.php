<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UploaderRoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_uploader_bisa_membuka_form_tambah_dan_edit_produk(): void
    {
        $uploader = User::factory()->uploader()->create();
        $product  = Product::factory()->create();

        $this->actingAs($uploader)->get(route('products.create'))->assertOk();
        $this->actingAs($uploader)->get(route('products.edit', $product))->assertOk();
    }

    public function test_user_biasa_tidak_bisa_membuka_form_tambah_produk(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('products.create'))
            ->assertForbidden();
    }

    public function test_uploader_tidak_bisa_menghapus_produk(): void
    {
        $uploader = User::factory()->uploader()->create();
        $product  = Product::factory()->create();

        $this->actingAs($uploader)
            ->delete(route('products.destroy', $product))
            ->assertForbidden();

        $this->assertDatabaseHas('products', ['id' => $product->id]);
    }

    public function test_admin_bisa_menghapus_produk(): void
    {
        $admin   = User::factory()->admin()->create();
        $product = Product::factory()->create();

        $this->actingAs($admin)
            ->delete(route('products.destroy', $product));

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_uploader_tidak_bisa_membuka_area_admin_lain(): void
    {
        $uploader = User::factory()->uploader()->create();

        $this->actingAs($uploader)->get(route('admin.reports'))->assertForbidden();
        $this->actingAs($uploader)->get(route('cart.admin-orders'))->assertForbidden();
        $this->actingAs($uploader)->get(route('settings.payment.edit'))->assertForbidden();
    }
}
