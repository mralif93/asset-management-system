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
            'masjid_surau_asal_id',
            'masjid_surau_destinasi_id',
            'tarikh_permohonan',
            'jenis_pergerakan',
            'lokasi_asal',
            'lokasi_terperinci_asal',
            'lokasi_destinasi',
            'lokasi_terperinci_destinasi',
            'tarikh_pergerakan',
            'tarikh_jangka_pulangan',
            'nama_peminjam_pegawai_bertanggungjawab',
            'sebab_pergerakan',
            'catatan_pergerakan',
            'tarikh_jangka_pulang',
            'tarikh_pulang_sebenar',
            'status_pergerakan',
            'status_kelulusan_asal',
            'status_kelulusan_destinasi',
            'pegawai_meluluskan',
            'diluluskan_oleh',
            'diluluskan_oleh_asal',
            'diluluskan_oleh_destinasi',
            'tarikh_kelulusan',
            'tarikh_kelulusan_asal',
            'tarikh_kelulusan_destinasi',
            'sebab_penolakan',
            'tarikh_kepulangan',
            'catatan',
        ];

        $this->assertEquals($fillable, $assetMovement->getFillable());
    }

    /** @test */
    public function it_casts_attributes_correctly()
    {
        $assetMovement = new AssetMovement();
        
        $expectedCasts = [
            'tarikh_permohonan' => 'date',
            'tarikh_pergerakan' => 'date',
            'tarikh_jangka_pulangan' => 'date',
            'tarikh_jangka_pulang' => 'date',
            'tarikh_pulang_sebenar' => 'date',
            'tarikh_kelulusan' => 'datetime',
            'tarikh_kelulusan_asal' => 'datetime',
            'tarikh_kelulusan_destinasi' => 'datetime',
            'tarikh_kepulangan' => 'datetime',
            'id' => 'int',
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