<?php

namespace Tests\Feature;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductOrder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Feature test untuk keranjang belanja dan checkout.
 */
class CartTest extends TestCase
{
    use RefreshDatabase;

    // ─────────────────────────────────────────────────────────
    // PROTEKSI AKSES
    // ─────────────────────────────────────────────────────────

    public function test_guest_tidak_bisa_akses_keranjang(): void
    {
        $this->get(route('cart.index'))
            ->assertRedirect(route('login'));
    }

    public function test_guest_tidak_bisa_tambah_ke_keranjang(): void
    {
        $product = Product::factory()->create();

        $this->post(route('cart.add', $product))
            ->assertRedirect(route('login'));
    }

    // ─────────────────────────────────────────────────────────
    // TAMBAH KE KERANJANG
    // ─────────────────────────────────────────────────────────

    public function test_user_bisa_tambah_produk_ke_keranjang(): void
    {
        $user    = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user)
            ->post(route('cart.add', $product))
            ->assertRedirect();

        $this->assertDatabaseHas('cart_items', [
            'user_id'    => $user->id,
            'product_id' => $product->id,
            'qty'        => 1,
        ]);
    }

    public function test_tambah_produk_yang_sama_menambah_qty_bukan_duplikat(): void
    {
        $user    = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user)->post(route('cart.add', $product));
        $this->actingAs($user)->post(route('cart.add', $product));

        $this->assertEquals(1, CartItem::where('user_id', $user->id)->count());
        $this->assertEquals(2, CartItem::where('user_id', $user->id)->first()->qty);
    }

    public function test_tambah_ke_keranjang_default_qty_satu(): void
    {
        $user    = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user)->post(route('cart.add', $product));

        $this->assertEquals(1, CartItem::where('user_id', $user->id)->first()->qty);
    }

    public function test_tambah_ke_keranjang_dengan_qty_kustom(): void
    {
        $user    = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user)
            ->post(route('cart.add', $product), ['qty' => 3]);

        $this->assertEquals(3, CartItem::where('user_id', $user->id)->first()->qty);
    }

    // ─────────────────────────────────────────────────────────
    // UPDATE QTY
    // ─────────────────────────────────────────────────────────

    public function test_user_bisa_update_qty_item_miliknya(): void
    {
        $user = User::factory()->create();
        $item = CartItem::factory()->create(['user_id' => $user->id, 'qty' => 1]);

        $this->actingAs($user)
            ->patch(route('cart.update', $item), ['qty' => 5])
            ->assertRedirect();

        $this->assertEquals(5, $item->fresh()->qty);
    }

    public function test_user_tidak_bisa_update_item_milik_user_lain(): void
    {
        $user      = User::factory()->create();
        $otherUser = User::factory()->create();
        $item      = CartItem::factory()->create(['user_id' => $otherUser->id]);

        $this->actingAs($user)
            ->patch(route('cart.update', $item), ['qty' => 5])
            ->assertForbidden();
    }

    // ─────────────────────────────────────────────────────────
    // HAPUS ITEM
    // ─────────────────────────────────────────────────────────

    public function test_user_bisa_hapus_item_miliknya(): void
    {
        $user = User::factory()->create();
        $item = CartItem::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->delete(route('cart.remove', $item))
            ->assertRedirect();

        $this->assertDatabaseMissing('cart_items', ['id' => $item->id]);
    }

    public function test_user_tidak_bisa_hapus_item_milik_user_lain(): void
    {
        $user      = User::factory()->create();
        $otherUser = User::factory()->create();
        $item      = CartItem::factory()->create(['user_id' => $otherUser->id]);

        $this->actingAs($user)
            ->delete(route('cart.remove', $item))
            ->assertForbidden();

        $this->assertDatabaseHas('cart_items', ['id' => $item->id]);
    }

    // ─────────────────────────────────────────────────────────
    // CHECKOUT
    // ─────────────────────────────────────────────────────────

    public function test_checkout_berhasil_membuat_order_dan_kosongkan_keranjang(): void
    {
        Storage::fake('public');

        $user    = User::factory()->create();
        $product = Product::factory()->create(['price' => 300000]);

        CartItem::factory()->create([
            'user_id'    => $user->id,
            'product_id' => $product->id,
            'qty'        => 2,
        ]);

        $this->actingAs($user)
            ->post(route('cart.checkout'), [
                'notes' => 'Kirim ke Bandung',
            ])
            ->assertRedirect(route('cart.orders'));

        // Order terbuat
        $this->assertDatabaseHas('product_orders', [
            'user_id'     => $user->id,
            'total_price' => 600000,
            'status'      => 'pending',
        ]);

        // Keranjang kosong setelah checkout
        $this->assertEquals(0, CartItem::where('user_id', $user->id)->count());
    }

    public function test_checkout_dengan_upload_bukti_bayar(): void
    {
        Storage::fake('public');

        $user    = User::factory()->create();
        $product = Product::factory()->create(['price' => 100000]);

        CartItem::factory()->create([
            'user_id'    => $user->id,
            'product_id' => $product->id,
            'qty'        => 1,
        ]);

        $file = UploadedFile::fake()->image('bukti.jpg');

        $this->actingAs($user)
            ->post(route('cart.checkout'), [
                'payment_proof' => $file,
            ])
            ->assertRedirect(route('cart.orders'));

        $order = ProductOrder::where('user_id', $user->id)->first();
        $this->assertNotNull($order->payment_proof);
        Storage::disk('public')->assertExists($order->payment_proof);
    }

    public function test_checkout_gagal_jika_keranjang_kosong(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('cart.checkout'))
            ->assertRedirect(route('cart.index'));
    }

    public function test_checkout_snapshot_nama_dan_harga_produk(): void
    {
        Storage::fake('public');

        $user    = User::factory()->create();
        $product = Product::factory()->create(['name' => 'Router Asus RT-AX88U', 'price' => 2500000]);

        CartItem::factory()->create(['user_id' => $user->id, 'product_id' => $product->id, 'qty' => 1]);

        $this->actingAs($user)->post(route('cart.checkout'));

        // Verifikasi snapshot tersimpan
        $this->assertDatabaseHas('product_order_items', [
            'product_name' => 'Router Asus RT-AX88U',
            'price'        => 2500000,
            'qty'          => 1,
        ]);

        // Update nama produk — snapshot tidak berubah
        $product->update(['name' => 'Nama Baru']);
        $this->assertDatabaseHas('product_order_items', ['product_name' => 'Router Asus RT-AX88U']);
    }

    // ─────────────────────────────────────────────────────────
    // RIWAYAT PESANAN
    // ─────────────────────────────────────────────────────────

    public function test_user_hanya_lihat_pesanan_miliknya(): void
    {
        $user      = User::factory()->create();
        $otherUser = User::factory()->create();

        ProductOrder::factory()->create(['user_id' => $user->id]);
        ProductOrder::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->actingAs($user)->get(route('cart.orders'));

        $response->assertStatus(200);
        $this->assertEquals(1, $user->productOrders()->count());
    }
}
