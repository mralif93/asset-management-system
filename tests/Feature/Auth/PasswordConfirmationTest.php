<?php

namespace Tests\Feature\Auth;

use App\Models\MasjidSurau;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PasswordConfirmationTest extends TestCase
{
    use RefreshDatabase;

    public function test_confirm_password_routes_are_not_exposed_in_custom_auth_flow(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
        ]);

        $response = $this->actingAs($user)->get('/confirm-password');
        $response->assertStatus(404);

        $response = $this->actingAs($user)->post('/confirm-password', [
            'password' => 'password',
        ]);
        $response->assertStatus(404);
    }

    public function test_user_can_update_password_via_user_profile_route(): void
    {
        $masjid = MasjidSurau::create([
            'nama' => 'Masjid Password',
            'jenis' => 'Masjid',
            'status' => 'Aktif',
        ]);

        $user = User::factory()->create([
            'role' => 'user',
            'masjid_surau_id' => $masjid->id,
        ]);

        $response = $this->actingAs($user)->put('/user/profile/password', [
            'current_password' => 'password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertTrue(Hash::check('new-password', $user->refresh()->password));
    }
}
