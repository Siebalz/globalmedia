<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_biasa_tidak_bisa_membuka_halaman_pengguna(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('admin.users'))
            ->assertForbidden();
    }

    public function test_uploader_tidak_bisa_membuka_halaman_pengguna(): void
    {
        $this->actingAs(User::factory()->uploader()->create())
            ->get(route('admin.users'))
            ->assertForbidden();
    }

    public function test_user_biasa_tidak_bisa_menaikkan_role_dirinya(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->patch(route('admin.users.role', $user), ['role' => 'admin'])
            ->assertForbidden();

        $this->assertSame('user', $user->fresh()->role);
    }

    public function test_uploader_tidak_bisa_menaikkan_role_dirinya(): void
    {
        $uploader = User::factory()->uploader()->create();

        $this->actingAs($uploader)
            ->patch(route('admin.users.role', $uploader), ['role' => 'admin'])
            ->assertForbidden();

        $this->assertSame('uploader', $uploader->fresh()->role);
    }

    public function test_admin_melihat_dan_mencari_pengguna(): void
    {
        $admin = User::factory()->admin()->create();
        User::factory()->create(['name' => 'Budi Teknisi']);
        User::factory()->create(['name' => 'Sinta Operator']);

        $this->actingAs($admin)->get(route('admin.users'))
            ->assertOk()->assertSee('Budi Teknisi')->assertSee('Sinta Operator');

        $this->actingAs($admin)->get(route('admin.users', ['q' => 'Sinta']))
            ->assertOk()->assertSee('Sinta Operator')->assertDontSee('Budi Teknisi');
    }

    public function test_admin_bisa_mengatur_ketiga_role(): void
    {
        $admin = User::factory()->admin()->create();
        $user  = User::factory()->create();

        foreach (['uploader', 'admin', 'user'] as $role) {
            $this->actingAs($admin)
                ->patch(route('admin.users.role', $user), ['role' => $role])
                ->assertSessionHas('success');

            $this->assertSame($role, $user->fresh()->role);
        }
    }

    public function test_admin_tidak_bisa_mengubah_role_akunnya_sendiri(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->patch(route('admin.users.role', $admin), ['role' => 'user'])
            ->assertSessionHas('error');

        $this->assertTrue($admin->fresh()->isAdmin());
    }

    public function test_role_di_luar_daftar_ditolak(): void
    {
        $admin = User::factory()->admin()->create();
        $user  = User::factory()->create();

        $this->actingAs($admin)
            ->patch(route('admin.users.role', $user), ['role' => 'superuser'])
            ->assertSessionHasErrors('role');

        $this->assertSame('user', $user->fresh()->role);
    }
}
