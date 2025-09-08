<?php

namespace Tests\Unit\Models;

use App\Models\AssetMovement;
use App\Models\Asset;
use App\Models\User;
use App\Models\MasjidSurau;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssetMovementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_fillable_attributes()
    {
        $assetMovement = new AssetMovement();
        
        $fillable = [
            'asset_id',
            'user_id',
            'origin_masjid_surau_id',
            'destination_masjid_surau_id',
            'tarikh_permohonan',
            'jenis_pergerakan',
            'lokasi_asal_spesifik',
            'lokasi_destinasi_spesifik',
            'nama_peminjam_pegawai_bertanggungjawab',
            'tujuan_pergerakan',
            'tarikh_pergerakan',
            'tarikh_jangka_pulang',
            'tarikh_pulang_sebenar',
            'status_pergerakan',
            'pegawai_meluluskan',
            'catatan'
        ];

        $this->assertEquals($fillable, $assetMovement->getFillable());
    }

    /** @test */
    public function it_casts_attributes_correctly()
    {
        $assetMovement = new AssetMovement();
        
        $expectedCasts = [
            'tarikh_permohonan' => 'datetime',
            'tarikh_pergerakan' => 'datetime',
            'tarikh_jangka_pulang' => 'datetime',
            'tarikh_pulang_sebenar' => 'datetime',
            'id' => 'int',
            'deleted_at' => 'datetime',
        ];

        $this->assertEquals($expectedCasts, $assetMovement->getCasts());
    }

    /** @test */
    public function it_belongs_to_asset()
    {
        $assetMovement = new AssetMovement();
        
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\BelongsTo::class,
            $assetMovement->asset()
        );
    }

    /** @test */
    public function it_belongs_to_user()
    {
        $assetMovement = new AssetMovement();
        
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\BelongsTo::class,
            $assetMovement->user()
        );
    }

    /** @test */
    public function it_belongs_to_approved_by_user()
    {
        $assetMovement = new AssetMovement();
        
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\BelongsTo::class,
            $assetMovement->approvedBy()
        );
    }

    /** @test */
    public function it_belongs_to_masjid_surau_asal()
    {
        $assetMovement = new AssetMovement();
        
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\BelongsTo::class,
            $assetMovement->masjidSurauAsal()
        );
    }

    /** @test */
    public function it_belongs_to_masjid_surau_destinasi()
    {
        $assetMovement = new AssetMovement();
        
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\BelongsTo::class,
            $assetMovement->masjidSurauDestinasi()
        );
    }

    /** @test */
    public function it_belongs_to_approved_by_asal_user()
    {
        $assetMovement = new AssetMovement();
        
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\BelongsTo::class,
            $assetMovement->approvedByAsal()
        );
    }

    /** @test */
    public function it_belongs_to_approved_by_destinasi_user()
    {
        $assetMovement = new AssetMovement();
        
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\BelongsTo::class,
            $assetMovement->approvedByDestinasi()
        );
    }
} 