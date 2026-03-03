<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\MasjidSurau;

class RoleAccessVerificationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Set up a user with a specific role.
     */
    private function createUserWithRole(string $role): User
    {
        $masjid = MasjidSurau::first() ?? MasjidSurau::factory()->create();

        return User::factory()->create([
            'role' => $role,
            'masjid_surau_id' => $role === 'superadmin' ? null : $masjid->id,
            'email_verified_at' => now(),
        ]);
    }

    public function test_user_role_access()
    {
        $user = $this->createUserWithRole('user');

        $this->actingAs($user)
            ->get('/user/dashboard')
            ->assertStatus(200);

        $this->actingAs($user)
            ->get('/admin/dashboard')
            ->assertStatus(403);

        $this->actingAs($user)
            ->get('/admin/assets')
            ->assertStatus(403);

        $this->actingAs($user)
            ->get('/admin/users')
            ->assertStatus(403);
    }

    public function test_asset_officer_role_access()
    {
        $officer = $this->createUserWithRole('Asset Officer');

        $this->actingAs($officer)
            ->get('/user/dashboard')
            ->assertStatus(403);

        $this->actingAs($officer)
            ->get('/admin/dashboard')
            ->assertStatus(200);

        $this->actingAs($officer)
            ->get('/admin/assets')
            ->assertStatus(200);

        // Should be blocked from strict admin areas
        $this->actingAs($officer)
            ->get('/admin/users')
            ->assertStatus(403);

        $this->actingAs($officer)
            ->get('/admin/masjid-surau')
            ->assertStatus(403);

        $this->actingAs($officer)
            ->get('/admin/audit-trails')
            ->assertStatus(403);
    }

    public function test_admin_role_access()
    {
        $admin = $this->createUserWithRole('admin');

        $this->actingAs($admin)
            ->get('/user/dashboard')
            ->assertStatus(403);

        $this->actingAs($admin)
            ->get('/admin/dashboard')
            ->assertStatus(200);

        $this->actingAs($admin)
            ->get('/admin/assets')
            ->assertStatus(200);

        // Admin should have access to strict admin areas
        $this->actingAs($admin)
            ->get('/admin/users')
            ->assertStatus(200);

        $this->actingAs($admin)
            ->get('/admin/masjid-surau')
            ->assertStatus(200);

        $this->actingAs($admin)
            ->get('/admin/audit-trails')
            ->assertStatus(200);
    }

    public function test_superadmin_role_access()
    {
        $superadmin = $this->createUserWithRole('superadmin');

        $this->actingAs($superadmin)
            ->get('/user/dashboard')
            ->assertStatus(403);

        $this->actingAs($superadmin)
            ->get('/admin/dashboard')
            ->assertStatus(200);

        $this->actingAs($superadmin)
            ->get('/admin/assets')
            ->assertStatus(200);

        $this->actingAs($superadmin)
            ->get('/admin/users')
            ->assertStatus(200);

        $this->actingAs($superadmin)
            ->get('/admin/masjid-surau')
            ->assertStatus(200);

        $this->actingAs($superadmin)
            ->get('/admin/audit-trails')
            ->assertStatus(200);
    }
}
