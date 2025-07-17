<?php

namespace Tests\Feature;

use App\Models\Asset;
use App\Models\MasjidSurau;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssetNewFieldsTest extends TestCase
{
    use RefreshDatabase;

    public function test_asset_can_have_physical_condition()
    {
        $masjidSurau = MasjidSurau::factory()->create();
        $user = User::factory()->create(['role' => 'admin']);

        $asset = Asset::factory()->create([
            'masjid_surau_id' => $masjidSurau->id,
            'keadaan_fizikal' => 'Cemerlang',
        ]);

        $this->assertEquals('Cemerlang', $asset->keadaan_fizikal);
    }

    public function test_asset_can_have_warranty_status()
    {
        $masjidSurau = MasjidSurau::factory()->create();
        $user = User::factory()->create(['role' => 'admin']);

        $asset = Asset::factory()->create([
            'masjid_surau_id' => $masjidSurau->id,
            'status_jaminan' => 'Aktif',
        ]);

        $this->assertEquals('Aktif', $asset->status_jaminan);
    }

    public function test_asset_can_have_inspection_and_maintenance_dates()
    {
        $masjidSurau = MasjidSurau::factory()->create();
        $user = User::factory()->create(['role' => 'admin']);

        $asset = Asset::factory()->create([
            'masjid_surau_id' => $masjidSurau->id,
            'tarikh_pemeriksaan_terakhir' => '2024-01-15',
            'tarikh_penyelenggaraan_akan_datang' => '2024-06-15',
        ]);

        $this->assertEquals('2024-01-15', $asset->tarikh_pemeriksaan_terakhir->format('Y-m-d'));
        $this->assertEquals('2024-06-15', $asset->tarikh_penyelenggaraan_akan_datang->format('Y-m-d'));
    }

    public function test_asset_can_have_warranty_notes()
    {
        $masjidSurau = MasjidSurau::factory()->create();
        $user = User::factory()->create(['role' => 'admin']);

        $asset = Asset::factory()->create([
            'masjid_surau_id' => $masjidSurau->id,
            'catatan_jaminan' => 'Jaminan 2 tahun dari pembekal',
        ]);

        $this->assertEquals('Jaminan 2 tahun dari pembekal', $asset->catatan_jaminan);
    }

    public function test_asset_has_default_values()
    {
        $masjidSurau = MasjidSurau::factory()->create();
        $user = User::factory()->create(['role' => 'admin']);

        $asset = Asset::factory()->create([
            'masjid_surau_id' => $masjidSurau->id,
        ]);

        $this->assertEquals('Baik', $asset->keadaan_fizikal);
        $this->assertEquals('Tiada Jaminan', $asset->status_jaminan);
    }
}
