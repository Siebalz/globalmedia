<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    // ─────────────────────────────────────────────────────────
    // REGISTER
    // ─────────────────────────────────────────────────────────

    public function test_halaman_register_dapat_diakses(): void
    {
        $this->get(route('register'))
            ->assertStatus(200);
    }

    public function test_user_baru_bisa_registrasi(): void
    {
        $this->post(route('register'), [
            'name'                  => 'Budi Santoso',
            'email'                 => 'budi@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ])->assertRedirect(route('login')); // RegisterController redirect ke login, bukan dashboard

        $this->assertDatabaseHas('users', ['email' => 'budi@example.com']);
    }

    public function test_setelah_registrasi_ada_flash_success(): void
    {
        $this->post(route('register'), [
            'name'                  => 'Budi Santoso',
            'email'                 => 'budi@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ])->assertSessionHas('success');
    }

    public function test_registrasi_selalu_menghasilkan_role_user_bukan_admin(): void
    {
        // Meskipun tidak ada user lain di DB, role harus tetap 'user'
        // (RegisterController kita sudah fix role hardcode ke 'user')
        $this->post(route('register'), [
            'name'                  => 'User Pertama',
            'email'                 => 'pertama@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $user = User::where('email', 'pertama@example.com')->first();
        $this->assertEquals('user', $user->role);
        $this->assertFalse($user->isAdmin());
    }

    public function test_registrasi_gagal_jika_email_sudah_ada(): void
    {
        User::factory()->create(['email' => 'existing@example.com']);

        $this->post(route('register'), [
            'name'                  => 'User Lain',
            'email'                 => 'existing@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ])->assertSessionHasErrors('email');
    }

    public function test_registrasi_gagal_jika_password_tidak_cocok(): void
    {
        $this->post(route('register'), [
            'name'                  => 'Budi',
            'email'                 => 'budi@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'salah123',
        ])->assertSessionHasErrors('password');
    }

    // ─────────────────────────────────────────────────────────
    // LOGIN
    // ─────────────────────────────────────────────────────────

    public function test_halaman_login_dapat_diakses(): void
    {
        $this->get(route('login'))
            ->assertStatus(200);
    }

    public function test_user_bisa_login_dengan_kredensial_benar(): void
    {
        $user = User::factory()->create(['password' => bcrypt('password123')]);

        $this->post(route('login.process'), [
            'email'    => $user->email,
            'password' => 'password123',
        ])->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_login_gagal_dengan_password_salah(): void
    {
        $user = User::factory()->create(['password' => bcrypt('password123')]);

        $this->post(route('login.process'), [
            'email'    => $user->email,
            'password' => 'salahpassword',
        ])->assertSessionHasErrors();

        $this->assertGuest();
    }

    public function test_login_gagal_dengan_email_tidak_terdaftar(): void
    {
        $this->post(route('login.process'), [
            'email'    => 'tidakada@example.com',
            'password' => 'password123',
        ])->assertSessionHasErrors();

        $this->assertGuest();
    }

    // ─────────────────────────────────────────────────────────
    // LOGOUT
    // ─────────────────────────────────────────────────────────

    public function test_user_bisa_logout(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('logout'))
            ->assertRedirect('/');

        $this->assertGuest();
    }

    // ─────────────────────────────────────────────────────────
    // PROTEKSI ROUTE
    // ─────────────────────────────────────────────────────────

    public function test_guest_diredirect_ke_login_saat_akses_dashboard(): void
    {
        $this->get(route('dashboard'))
            ->assertRedirect(route('login'));
    }

    public function test_user_login_bisa_akses_dashboard(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertStatus(200);
    }
}
