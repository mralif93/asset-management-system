<?php

namespace Tests\Feature\Auth;

use App\Models\MasjidSurau;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PasswordUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_password_can_be_updated(): void
    {
        $masjid = MasjidSurau::create([
            'nama' => 'Masjid Password Update',
            'jenis' => 'Masjid',
            'status' => 'Aktif',
        ]);

        $user = User::factory()->create([
            'role' => 'user',
            'masjid_surau_id' => $masjid->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->from('/user/profile')
            ->put('/user/profile/password', [
                'current_password' => 'password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/user/profile');

        $this->assertTrue(Hash::check('new-password', $user->refresh()->password));
    }

    public function test_correct_password_must_be_provided_to_update_password(): void
    {
        $masjid = MasjidSurau::create([
            'nama' => 'Masjid Password Update 2',
            'jenis' => 'Masjid',
            'status' => 'Aktif',
        ]);

        $user = User::factory()->create([
            'role' => 'user',
            'masjid_surau_id' => $masjid->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->from('/user/profile')
            ->put('/user/profile/password', [
                'current_password' => 'wrong-password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ]);

        $response
            ->assertSessionHasErrorsIn('updatePassword', 'current_password')
            ->assertRedirect('/user/profile');
    }
}
