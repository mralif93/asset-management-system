<?php

namespace Tests\Unit\Models;

use App\Models\MasjidSurau;
use App\Models\User;
use App\Models\Asset;
use App\Models\ImmovableAsset;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MasjidSurauTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_uses_correct_table_name()
    {
        $masjidSurau = new MasjidSurau();
        $this->assertEquals('masjid_surau', $masjidSurau->getTable());
    }

    /** @test */
    public function it_has_fillable_attributes()
    {
        $masjidSurau = new MasjidSurau();
        
        $fillable = [
            'nama',
            'singkatan_nama',
            'jenis',
            'kategori',
            'alamat_baris_1',
            'alamat_baris_2',
            'alamat_baris_3',
            'poskod',
            'bandar',
            'negeri',
            'negara',
            'daerah',
            'no_telefon',
            'email',
            'imam_ketua',
            'bilangan_jemaah',
            'tahun_dibina',
            'status',
            'catatan',
            'nama_rasmi',
            'kawasan',
            'pautan_peta',
        ];

        $this->assertEquals($fillable, $masjidSurau->getFillable());
    }

    /** @test */
    public function it_has_many_users()
    {
        $masjidSurau = new MasjidSurau();
        
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\HasMany::class,
            $masjidSurau->users()
        );
    }

    /** @test */
    public function it_has_many_assets()
    {
        $masjidSurau = new MasjidSurau();
        
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\HasMany::class,
            $masjidSurau->assets()
        );
    }

    /** @test */
    public function it_has_many_immovable_assets()
    {
        $masjidSurau = new MasjidSurau();
        
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\HasMany::class,
            $masjidSurau->immovableAssets()
        );
    }

    /** @test */
    public function it_uses_auditable_trait()
    {
        $masjidSurau = new MasjidSurau();
        $this->assertContains('App\Traits\Auditable', class_uses_recursive($masjidSurau));
    }
} 