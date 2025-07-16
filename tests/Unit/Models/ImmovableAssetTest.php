<?php

namespace Tests\Unit\Models;

use App\Models\ImmovableAsset;
use App\Models\MasjidSurau;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ImmovableAssetTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_fillable_attributes()
    {
        $immovableAsset = new ImmovableAsset();
        
        $fillable = [
            'masjid_surau_id',
            'nama_aset',
            'jenis_aset',
            'alamat',
            'no_hakmilik',
            'no_lot',
            'luas_tanah_bangunan',
            'tarikh_perolehan',
            'sumber_perolehan',
            'kos_perolehan',
            'keadaan_semasa',
            'gambar_aset',
            'catatan',
        ];

        $this->assertEquals($fillable, $immovableAsset->getFillable());
    }

    /** @test */
    public function it_casts_attributes_correctly()
    {
        $immovableAsset = new ImmovableAsset();
        
        $expectedCasts = [
            'luas_tanah_bangunan' => 'decimal:2',
            'kos_perolehan' => 'decimal:2',
            'tarikh_perolehan' => 'datetime',
            'gambar_aset' => 'array',
            'deleted_at' => 'datetime',
        ];

        $this->assertEquals($expectedCasts, $immovableAsset->getCasts());
    }

    /** @test */
    public function it_belongs_to_masjid_surau()
    {
        $immovableAsset = new ImmovableAsset();
        
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\BelongsTo::class,
            $immovableAsset->masjidSurau()
        );
    }
    
    /** @test */
    public function it_uses_auditable_trait()
    {
        $immovableAsset = new ImmovableAsset();
        $this->assertContains('App\Traits\Auditable', class_uses_recursive($immovableAsset));
    }
    
    /** @test */
    public function it_uses_soft_deletes()
    {
        $immovableAsset = new ImmovableAsset();
        $this->assertContains('Illuminate\Database\Eloquent\SoftDeletes', class_uses_recursive($immovableAsset));
    }
    
    /** @test */
    public function it_formats_asset_type_correctly()
    {
        $immovableAsset = new ImmovableAsset();
        
        $immovableAsset->jenis_aset = 'tanah';
        $this->assertEquals('Tanah', $immovableAsset->getFormattedAssetTypeAttribute());
        
        $immovableAsset->jenis_aset = 'bangunan';
        $this->assertEquals('Bangunan', $immovableAsset->getFormattedAssetTypeAttribute());
        
        $immovableAsset->jenis_aset = 'other';
        $this->assertEquals('Other', $immovableAsset->getFormattedAssetTypeAttribute());
    }
    
    /** @test */
    public function it_formats_acquisition_source_correctly()
    {
        $immovableAsset = new ImmovableAsset();
        
        $immovableAsset->sumber_perolehan = 'pembelian';
        $this->assertEquals('Pembelian', $immovableAsset->getFormattedAcquisitionSourceAttribute());
        
        $immovableAsset->sumber_perolehan = 'wakaf';
        $this->assertEquals('Wakaf', $immovableAsset->getFormattedAcquisitionSourceAttribute());
        
        $immovableAsset->sumber_perolehan = 'lain_lain';
        $this->assertEquals('Lain-lain', $immovableAsset->getFormattedAcquisitionSourceAttribute());
    }
    
    /** @test */
    public function it_formats_current_condition_correctly()
    {
        $immovableAsset = new ImmovableAsset();
        
        $immovableAsset->keadaan_semasa = 'baik';
        $this->assertEquals('Baik', $immovableAsset->getFormattedCurrentConditionAttribute());
        
        $immovableAsset->keadaan_semasa = 'sederhana';
        $this->assertEquals('Sederhana', $immovableAsset->getFormattedCurrentConditionAttribute());
    }
    
    /** @test */
    public function it_can_create_immovable_asset_with_valid_attributes()
    {
        $masjidSurau = MasjidSurau::create([
            'nama' => 'Test Masjid',
            'jenis' => 'Masjid',
            'status' => 'Aktif',
        ]);
        
        $assetData = [
            'masjid_surau_id' => $masjidSurau->id,
            'nama_aset' => 'Tanah Masjid',
            'jenis_aset' => 'tanah',
            'alamat' => 'Jalan Test 123',
            'no_hakmilik' => 'HS(D) 123456',
            'no_lot' => 'PT 12345',
            'luas_tanah_bangunan' => 1000.50,
            'tarikh_perolehan' => now(),
            'sumber_perolehan' => 'wakaf',
            'kos_perolehan' => 500000.00,
            'keadaan_semasa' => 'baik',
        ];
        
        $immovableAsset = ImmovableAsset::create($assetData);
        
        $this->assertDatabaseHas('immovable_assets', [
            'id' => $immovableAsset->id,
            'masjid_surau_id' => $masjidSurau->id,
            'nama_aset' => 'Tanah Masjid',
            'jenis_aset' => 'tanah',
            'no_hakmilik' => 'HS(D) 123456',
        ]);
    }
} 