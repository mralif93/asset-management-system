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
            'email_verified_at',
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
} 