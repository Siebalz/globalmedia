<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductOrder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminOrderTest extends TestCase
{
    use RefreshDatabase;

    // ─────────────────────────────────────────────────────────
    // AKSES KONTROL
    // ─────────────────────────────────────────────────────────

    public function test_user_biasa_tidak_bisa_akses_halaman_pesanan_admin(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('cart.admin-orders'))
            ->assertForbidden(); // EnsureUserIsAdmin return 403
    }

    public function test_admin_bisa_akses_halaman_pesanan(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get(route('cart.admin-orders'))
            ->assertStatus(200);
    }

    // ─────────────────────────────────────────────────────────
    // UPDATE STATUS
    // ─────────────────────────────────────────────────────────

    public function test_admin_bisa_update_status_pesanan(): void
    {
        $admin = User::factory()->admin()->create();
        $order = ProductOrder::factory()->create(['status' => 'pending']);

        $this->actingAs($admin)
            ->patch(route('cart.admin-update-status', $order), [
                'status' => 'confirmed',
            ])
            ->assertRedirect();

        $this->assertEquals('confirmed', $order->fresh()->status);
    }

    public function test_admin_bisa_input_resi_saat_status_dikirim(): void
    {
        $admin = User::factory()->admin()->create();
        $order = ProductOrder::factory()->create(['status' => 'confirmed']);

        $this->actingAs($admin)
            ->patch(route('cart.admin-update-status', $order), [
                'status'          => 'shipped',
                'courier'         => 'JNE',
                'tracking_number' => 'JNE123456789',
            ])
            ->assertRedirect();

        $order->refresh();
        $this->assertEquals('shipped', $order->status);
        $this->assertEquals('JNE', $order->courier);
        $this->assertEquals('JNE123456789', $order->tracking_number);
    }

    public function test_resi_tidak_tersimpan_jika_status_bukan_dikirim(): void
    {
        $admin = User::factory()->admin()->create();
        $order = ProductOrder::factory()->create(['status' => 'pending']);

        $this->actingAs($admin)
            ->patch(route('cart.admin-update-status', $order), [
                'status'          => 'confirmed',
                'tracking_number' => 'NOMOR-RESI-ISENG',
            ])
            ->assertRedirect();

        $this->assertNull($order->fresh()->tracking_number);
    }

    public function test_status_tidak_valid_ditolak(): void
    {
        $admin = User::factory()->admin()->create();
        $order = ProductOrder::factory()->create(['status' => 'pending']);

        $this->actingAs($admin)
            ->patch(route('cart.admin-update-status', $order), [
                'status' => 'status_tidak_ada',
            ])
            ->assertSessionHasErrors('status');
    }

    public function test_user_biasa_tidak_bisa_update_status_pesanan(): void
    {
        $user  = User::factory()->create();
        $order = ProductOrder::factory()->create(['status' => 'pending']);

        $this->actingAs($user)
            ->patch(route('cart.admin-update-status', $order), [
                'status' => 'confirmed',
            ])
            ->assertForbidden(); // middleware EnsureUserIsAdmin return 403

        $this->assertEquals('pending', $order->fresh()->status);
    }

    // ─────────────────────────────────────────────────────────
    // UPLOAD BUKTI BAYAR (USER)
    // ─────────────────────────────────────────────────────────

    public function test_user_bisa_upload_bukti_bayar_untuk_pesanannya(): void
    {
        Storage::fake('public');

        $user  = User::factory()->create();
        $order = ProductOrder::factory()->create([
            'user_id' => $user->id,
            'status'  => 'pending',
        ]);

        $file = UploadedFile::fake()->image('bukti.png');

        $this->actingAs($user)
            ->patch(route('cart.upload-proof', $order), [
                'payment_proof' => $file,
            ])
            ->assertRedirect();

        $this->assertNotNull($order->fresh()->payment_proof);
    }

    public function test_user_tidak_bisa_upload_bukti_untuk_pesanan_orang_lain(): void
    {
        Storage::fake('public');

        $user      = User::factory()->create();
        $otherUser = User::factory()->create();
        $order     = ProductOrder::factory()->create([
            'user_id' => $otherUser->id,
            'status'  => 'pending',
        ]);

        $file = UploadedFile::fake()->image('bukti.png');

        $this->actingAs($user)
            ->patch(route('cart.upload-proof', $order), [
                'payment_proof' => $file,
            ])
            ->assertForbidden();
    }

    public function test_user_tidak_bisa_upload_bukti_untuk_pesanan_yang_sudah_selesai(): void
    {
        Storage::fake('public');

        $user  = User::factory()->create();
        $order = ProductOrder::factory()->create([
            'user_id' => $user->id,
            'status'  => 'done',
        ]);

        $file = UploadedFile::fake()->image('bukti.png');

        $this->actingAs($user)
            ->patch(route('cart.upload-proof', $order), [
                'payment_proof' => $file,
            ])
            ->assertStatus(422);
    }
}
