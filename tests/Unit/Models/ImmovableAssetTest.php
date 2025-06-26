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
            'tarikh_perolehan' => 'date',
            'luas_tanah_bangunan' => 'decimal:2',
            'kos_perolehan' => 'decimal:2',
            'gambar_aset' => 'array',
            'id' => 'int',
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
} 