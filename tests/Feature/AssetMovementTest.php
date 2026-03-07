<?php

namespace Tests\Feature;

use App\Models\Asset;
use App\Models\AssetMovement;
use App\Models\MasjidSurau;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AssetMovementTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private MasjidSurau $origin;
    private MasjidSurau $destination;
    private Asset $asset;

    protected function setUp(): void
    {
        parent::setUp();

        $this->origin = MasjidSurau::create([
            'nama' => 'Test Origin',
            'jenis' => 'Masjid',
            'status' => 'Aktif',
        ]);

        $this->destination = MasjidSurau::create([
            'nama' => 'Test Destination',
            'jenis' => 'Masjid',
            'status' => 'Aktif',
        ]);

        $this->admin = User::factory()->create([
            'masjid_surau_id' => $this->origin->id,
            'role' => 'administrator',
        ]);

        $this->asset = Asset::create([
            'masjid_surau_id' => $this->origin->id,
            'no_siri_pendaftaran' => 'TEST-001',
            'nama_aset' => 'Test Asset',
            'jenis_aset' => 'Elektronik',
            'tarikh_perolehan' => now(),
            'kaedah_perolehan' => 'Pembelian',
            'nilai_perolehan' => 1000,
            'susut_nilai_tahunan' => 100,
            'lokasi_penempatan' => 'Stor A',
            'pegawai_bertanggungjawab_lokasi' => 'Test Officer',
            'status_aset' => 'Aktif',
        ]);
    }

    #[Test]
    public function admin_can_create_asset_movement(): void
    {
        $payload = [
            'asset_id' => $this->asset->id,
            'jenis_pergerakan' => 'Pemindahan',
            'origin_masjid_surau_id' => $this->origin->id,
            'destination_masjid_surau_id' => $this->destination->id,
            'lokasi_asal_spesifik' => 'Stor A',
            'lokasi_destinasi_spesifik' => 'Stor B',
            'tarikh_pergerakan' => now()->addDay()->format('Y-m-d'),
            'nama_peminjam_pegawai_bertanggungjawab' => 'Test Borrower',
            'tujuan_pergerakan' => 'Testing purposes',
            'kuantiti' => 1,
            'pegawai_bertanggungjawab_signature' => 'signature-data',
            'disediakan_oleh_jawatan' => 'Pegawai Aset',
            'disediakan_oleh_tarikh' => now()->format('Y-m-d'),
        ];

        $response = $this->actingAs($this->admin)->post('/admin/asset-movements', $payload);

        $response->assertStatus(302);
        $movement = AssetMovement::first();
        $this->assertNotNull($movement);
        $response->assertRedirect("/admin/asset-movements/{$movement->id}");
        $this->assertDatabaseHas('asset_movements', [
            'id' => $movement->id,
            'asset_id' => $this->asset->id,
            'user_id' => $this->admin->id,
            'status_pergerakan' => 'menunggu_kelulusan',
        ]);
    }

    #[Test]
    public function admin_can_approve_and_reject_movement(): void
    {
        $movement = AssetMovement::create([
            'asset_id' => $this->asset->id,
            'user_id' => $this->admin->id,
            'kuantiti' => 1,
            'origin_masjid_surau_id' => $this->origin->id,
            'destination_masjid_surau_id' => $this->destination->id,
            'tarikh_permohonan' => now(),
            'jenis_pergerakan' => 'Pemindahan',
            'lokasi_asal_spesifik' => 'Stor A',
            'lokasi_destinasi_spesifik' => 'Stor B',
            'nama_peminjam_pegawai_bertanggungjawab' => 'Test Borrower',
            'tujuan_pergerakan' => 'Testing purposes',
            'tarikh_pergerakan' => now()->addDay(),
            'status_pergerakan' => 'menunggu_kelulusan',
        ]);

        $approve = $this->actingAs($this->admin)
            ->patch("/admin/asset-movements/{$movement->id}/approve", ['catatan' => 'Approved']);
        $approve->assertStatus(302)->assertRedirect("/admin/asset-movements/{$movement->id}");

        $this->assertDatabaseHas('asset_movements', [
            'id' => $movement->id,
            'status_pergerakan' => 'diluluskan',
        ]);

        $reject = $this->actingAs($this->admin)
            ->patch("/admin/asset-movements/{$movement->id}/reject", ['catatan' => 'Rejected']);
        $reject->assertStatus(302)->assertRedirect("/admin/asset-movements/{$movement->id}");

        $this->assertDatabaseHas('asset_movements', [
            'id' => $movement->id,
            'status_pergerakan' => 'ditolak',
        ]);
    }

    #[Test]
    public function admin_can_record_asset_return(): void
    {
        $movement = AssetMovement::create([
            'asset_id' => $this->asset->id,
            'user_id' => $this->admin->id,
            'kuantiti' => 1,
            'origin_masjid_surau_id' => $this->origin->id,
            'destination_masjid_surau_id' => $this->destination->id,
            'tarikh_permohonan' => now()->subDays(2),
            'jenis_pergerakan' => 'Peminjaman',
            'lokasi_asal_spesifik' => 'Stor A',
            'lokasi_destinasi_spesifik' => 'Stor B',
            'nama_peminjam_pegawai_bertanggungjawab' => 'Test Borrower',
            'tujuan_pergerakan' => 'Borrowing',
            'tarikh_pergerakan' => now()->subDay(),
            'status_pergerakan' => 'diluluskan',
        ]);

        $response = $this->actingAs($this->admin)
            ->patch("/admin/asset-movements/{$movement->id}/process-return", [
                'tarikh_pulang_sebenar' => now()->format('Y-m-d H:i:s'),
                'catatan' => 'Returned safely',
                'tandatangan_penerima' => 'sig-1',
                'tandatangan_pemulangan' => 'sig-2',
            ]);

        $response->assertStatus(302)->assertRedirect("/admin/asset-movements/{$movement->id}");
        $this->assertDatabaseHas('asset_movements', [
            'id' => $movement->id,
            'status_pergerakan' => 'dipulangkan',
        ]);
    }

    #[Test]
    public function regular_user_cannot_create_movement(): void
    {
        $user = User::factory()->create([
            'masjid_surau_id' => $this->origin->id,
            'role' => 'user',
        ]);

        $response = $this->actingAs($user)->post('/admin/asset-movements', [
            'asset_id' => $this->asset->id,
            'jenis_pergerakan' => 'Pemindahan',
            'origin_masjid_surau_id' => $this->origin->id,
            'destination_masjid_surau_id' => $this->destination->id,
            'lokasi_asal_spesifik' => 'Stor A',
            'lokasi_destinasi_spesifik' => 'Stor B',
            'tarikh_pergerakan' => now()->addDay()->format('Y-m-d'),
            'nama_peminjam_pegawai_bertanggungjawab' => 'Test Borrower',
            'tujuan_pergerakan' => 'Testing purposes',
            'kuantiti' => 1,
            'pegawai_bertanggungjawab_signature' => 'signature-data',
            'disediakan_oleh_jawatan' => 'Pegawai Aset',
            'disediakan_oleh_tarikh' => now()->format('Y-m-d'),
        ]);

        $response->assertStatus(403);
    }
}
