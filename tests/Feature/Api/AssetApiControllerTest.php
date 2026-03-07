<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\User;
use App\Models\Asset;
use App\Models\MasjidSurau;
use App\Models\Inspection;
use App\Models\Disposal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

class AssetApiControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private MasjidSurau $masjidSurau;

    protected function setUp(): void
    {
        parent::setUp();

        $this->masjidSurau = MasjidSurau::factory()->create();
        $this->user = User::factory()->create([
            'role' => 'administrator',
            'masjid_surau_id' => $this->masjidSurau->id,
        ]);
    }

    public function test_api_assets_index_requires_authentication(): void
    {
        $response = $this->getJson('/api/v1/assets');

        $response->assertStatus(401);
    }

    public function test_api_assets_index_returns_assets(): void
    {
        Sanctum::actingAs($this->user);

        Asset::factory()->count(3)->create([
            'masjid_surau_id' => $this->masjidSurau->id,
        ]);

        $response = $this->getJson('/api/v1/assets');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'data' => [
                        '*' => [
                            'id',
                            'nama_aset',
                            'no_siri_pendaftaran',
                        ],
                    ],
                ],
            ]);
    }

    public function test_api_assets_show_returns_single_asset(): void
    {
        Sanctum::actingAs($this->user);

        $asset = Asset::factory()->create([
            'masjid_surau_id' => $this->masjidSurau->id,
        ]);

        $response = $this->getJson("/api/v1/assets/{$asset->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'id',
                    'nama_aset',
                ],
                'depreciation' => [
                    'current_value',
                    'total_depreciation',
                ],
            ]);
    }

    public function test_api_assets_summary_returns_statistics(): void
    {
        Sanctum::actingAs($this->user);

        Asset::factory()->count(5)->create([
            'masjid_surau_id' => $this->masjidSurau->id,
            'kategori_aset' => 'asset',
        ]);

        Asset::factory()->count(3)->create([
            'masjid_surau_id' => $this->masjidSurau->id,
            'kategori_aset' => 'non-asset',
        ]);

        $response = $this->getJson('/api/v1/assets/summary');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'total_assets',
                    'total_capital_assets',
                    'total_inventory',
                    'active_assets',
                    'disposed_assets',
                    'total_value',
                    'by_status',
                    'by_type',
                ],
            ]);
    }

    public function test_api_inspections_index_returns_inspections(): void
    {
        Sanctum::actingAs($this->user);

        $asset = Asset::factory()->create([
            'masjid_surau_id' => $this->masjidSurau->id,
        ]);

        Inspection::factory()->count(3)->create([
            'asset_id' => $asset->id,
            'user_id' => $this->user->id,
        ]);

        $response = $this->getJson('/api/v1/inspections');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data',
            ]);
    }

    public function test_api_disposals_index_returns_disposals(): void
    {
        Sanctum::actingAs($this->user);

        $asset = Asset::factory()->create([
            'masjid_surau_id' => $this->masjidSurau->id,
        ]);

        Disposal::factory()->count(3)->create([
            'asset_id' => $asset->id,
            'user_id' => $this->user->id,
        ]);

        $response = $this->getJson('/api/v1/disposals');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data',
            ]);
    }
}
