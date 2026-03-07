<?php

namespace Tests\Feature\Auth;

use App\Models\MasjidSurau;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $masjid = MasjidSurau::create([
            'nama' => 'Masjid Test',
            'jenis' => 'Masjid',
            'status' => 'Aktif',
        ]);

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'phone' => '0123456789',
            'position' => 'AJK',
            'masjid_surau_id' => $masjid->id,
            'terms' => '1',
        ]);

        $this->assertGuest();
        $response->assertRedirect('/login');

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'role' => 'user',
            'masjid_surau_id' => $masjid->id,
        ]);
    }
}
