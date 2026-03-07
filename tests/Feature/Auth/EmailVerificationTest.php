<?php

namespace Tests\Feature\Auth;

use App\Models\MasjidSurau;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_unverified_user_cannot_login(): void
    {
        $masjid = MasjidSurau::create([
            'nama' => 'Masjid Verification',
            'jenis' => 'Masjid',
            'status' => 'Aktif',
        ]);

        $user = User::factory()->unverified()->create([
            'role' => 'user',
            'masjid_surau_id' => $masjid->id,
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }

    public function test_verified_user_can_login(): void
    {
        $masjid = MasjidSurau::create([
            'nama' => 'Masjid Verification 2',
            'jenis' => 'Masjid',
            'status' => 'Aktif',
        ]);

        $user = User::factory()->create([
            'role' => 'user',
            'masjid_surau_id' => $masjid->id,
            'email_verified_at' => now(),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/user/dashboard');
        $this->assertAuthenticatedAs($user);
    }
}
