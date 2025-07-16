<?php

namespace Tests\Unit\Models;

use App\Models\User;
use App\Models\MasjidSurau;
use App\Models\Asset;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_fillable_attributes()
    {
        $user = new User();
        
        $fillable = [
            'name',
            'email',
            'password',
            'role',
            'masjid_surau_id',
            'phone',
            'position',
        ];

        $this->assertEquals($fillable, $user->getFillable());
    }

    /** @test */
    public function it_has_hidden_attributes()
    {
        $user = new User();
        
        $hidden = [
            'password',
            'remember_token',
        ];

        $this->assertEquals($hidden, $user->getHidden());
    }

    /** @test */
    public function it_casts_attributes_correctly()
    {
        $user = new User();
        
        $expectedCasts = [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'deleted_at' => 'datetime',
            'id' => 'int',
        ];

        $this->assertEquals($expectedCasts, $user->getCasts());
    }

    /** @test */
    public function it_belongs_to_masjid_surau()
    {
        $user = new User();
        
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\BelongsTo::class,
            $user->masjidSurau()
        );
    }

    /** @test */
    public function it_has_many_through_assets()
    {
        $user = new User();
        
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\HasManyThrough::class,
            $user->assets()
        );
    }

    /** @test */
    public function it_uses_auditable_trait()
    {
        $user = new User();
        $this->assertContains('App\Traits\Auditable', class_uses_recursive($user));
    }

    /** @test */
    public function it_uses_notifiable_trait()
    {
        $user = new User();
        $this->assertContains('Illuminate\Notifications\Notifiable', class_uses_recursive($user));
    }
    
    /** @test */
    public function it_uses_soft_deletes()
    {
        $user = new User();
        $this->assertContains('Illuminate\Database\Eloquent\SoftDeletes', class_uses_recursive($user));
    }
    
    /** @test */
    public function it_can_be_soft_deleted_and_restored()
    {
        $masjidSurau = MasjidSurau::create([
            'nama' => 'Test Masjid',
            'jenis' => 'Masjid',
            'status' => 'Aktif',
        ]);
        
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
            'masjid_surau_id' => $masjidSurau->id,
            'phone' => '0123456789',
            'position' => 'Staff',
        ]);
        
        $this->assertDatabaseHas('users', ['id' => $user->id]);
        
        $user->delete();
        $this->assertSoftDeleted('users', ['id' => $user->id]);
        
        $user->restore();
        $this->assertDatabaseHas('users', ['id' => $user->id, 'deleted_at' => null]);
    }
    
    /** @test */
    public function it_can_create_user_with_valid_attributes()
    {
        $masjidSurau = MasjidSurau::create([
            'nama' => 'Test Masjid',
            'jenis' => 'Masjid',
            'status' => 'Aktif',
        ]);
        
        $userData = [
            'name' => 'New Test User',
            'email' => 'newtest@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'masjid_surau_id' => $masjidSurau->id,
            'phone' => '0123456789',
            'position' => 'Manager',
        ];
        
        $user = User::create($userData);
        
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'New Test User',
            'email' => 'newtest@example.com',
            'role' => 'admin',
            'masjid_surau_id' => $masjidSurau->id,
            'phone' => '0123456789',
            'position' => 'Manager',
        ]);
    }
} 