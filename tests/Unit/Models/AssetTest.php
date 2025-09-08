<?php

namespace Tests\Unit\Models;

use App\Models\Asset;
use App\Models\MasjidSurau;
use App\Models\AssetMovement;
use App\Models\Inspection;
use App\Models\MaintenanceRecord;
use App\Models\Disposal;
use App\Models\LossWriteoff;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssetTest extends TestCase
{
    use RefreshDatabase;

    private MasjidSurau $masjidSurau;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a masjid/surau and user for testing
        $this->masjidSurau = MasjidSurau::create([
            'nama' => 'Test Masjid',
            'jenis' => 'Masjid',
            'status' => 'Aktif',
        ]);

        $this->user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'masjid_surau_id' => $this->masjidSurau->id,
        ]);
    }

    /** @test */
    public function it_has_fillable_attributes()
    {
        $asset = new Asset();
        
        $fillable = [
            'masjid_surau_id',
            'no_siri_pendaftaran',
            'nama_aset',
            'jenis_aset',
            'kategori_aset',
            'tarikh_perolehan',
            'kaedah_perolehan',
            'nilai_perolehan',
            'diskaun',
            'umur_faedah_tahunan',
            'susut_nilai_tahunan',
            'lokasi_penempatan',
            'pegawai_bertanggungjawab_lokasi',
            'jawatan_pegawai',
            'status_aset',
            'keadaan_fizikal',
            'status_jaminan',
            'tarikh_pemeriksaan_terakhir',
            'tarikh_penyelenggaraan_akan_datang',
            'catatan_jaminan',
            'gambar_aset',
            'no_resit',
            'tarikh_resit',
            'dokumen_resit_url',
            'pembekal',
            'jenama',
            'no_pesanan_kerajaan',
            'no_rujukan_kontrak',
            'tempoh_jaminan',
            'tarikh_tamat_jaminan',
            'catatan',
        ];

        $this->assertEquals($fillable, $asset->getFillable());
    }

    /** @test */
    public function it_casts_attributes_correctly()
    {
        $asset = new Asset();
        
        $expectedCasts = [
            'tarikh_perolehan' => 'date',
            'tarikh_resit' => 'datetime',
            'tarikh_tamat_jaminan' => 'date',
            'tarikh_pemeriksaan_terakhir' => 'date',
            'tarikh_penyelenggaraan_akan_datang' => 'date',
            'nilai_perolehan' => 'decimal:2',
            'diskaun' => 'decimal:2',
            'susut_nilai_tahunan' => 'decimal:2',
            'gambar_aset' => 'array',
            'deleted_at' => 'datetime',
            'id' => 'int',
        ];

        $this->assertEquals($expectedCasts, $asset->getCasts());
    }

    /** @test */
    public function it_belongs_to_masjid_surau()
    {
        $asset = new Asset();
        
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\BelongsTo::class,
            $asset->masjidSurau()
        );
    }

    /** @test */
    public function it_has_many_asset_movements()
    {
        $asset = new Asset();
        
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\HasMany::class,
            $asset->assetMovements()
        );
    }

    /** @test */
    public function movements_is_alias_for_asset_movements()
    {
        $asset = new Asset();
        
        $this->assertEquals(
            $asset->assetMovements()->getQuery()->toSql(),
            $asset->movements()->getQuery()->toSql()
        );
    }

    /** @test */
    public function it_has_many_inspections()
    {
        $asset = new Asset();
        
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\HasMany::class,
            $asset->inspections()
        );
    }

    /** @test */
    public function it_has_many_maintenance_records()
    {
        $asset = new Asset();
        
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\HasMany::class,
            $asset->maintenanceRecords()
        );
    }

    /** @test */
    public function it_has_many_disposals()
    {
        $asset = new Asset();
        
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\HasMany::class,
            $asset->disposals()
        );
    }

    /** @test */
    public function it_has_many_loss_writeoffs()
    {
        $asset = new Asset();
        
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\HasMany::class,
            $asset->lossWriteoffs()
        );
    }

    /** @test */
    public function it_uses_auditable_trait()
    {
        $asset = new Asset();
        $this->assertContains('App\Traits\Auditable', class_uses_recursive($asset));
    }

    /** @test */
    public function it_can_calculate_current_value()
    {
        $asset = new Asset([
            'masjid_surau_id' => $this->masjidSurau->id,
            'no_siri_pendaftaran' => 'TEST-001',
            'nama_aset' => 'Test Asset',
            'jenis_aset' => 'Elektronik',
            'kategori_aset' => 'asset',
            'tarikh_perolehan' => now()->subYears(2),
            'kaedah_perolehan' => 'Pembelian',
            'nilai_perolehan' => 1000,
            'susut_nilai_tahunan' => 100,
            'lokasi_penempatan' => 'Test Location',
            'pegawai_bertanggungjawab_lokasi' => 'Test Officer',
        ]);
        $asset->save();

        $expectedValue = 799.99; // 1000 - (100 * 2) with rounding
        $this->assertEqualsWithDelta($expectedValue, $asset->getCurrentValue(), 0.01);
    }

    /** @test */
    public function it_can_determine_if_needs_inspection()
    {
        $asset = Asset::create([
            'masjid_surau_id' => $this->masjidSurau->id,
            'no_siri_pendaftaran' => 'TEST-002',
            'nama_aset' => 'Test Asset',
            'jenis_aset' => 'Elektronik',
            'kategori_aset' => 'asset',
            'tarikh_perolehan' => now(),
            'kaedah_perolehan' => 'Pembelian',
            'nilai_perolehan' => 1000,
            'lokasi_penempatan' => 'Test Location',
            'pegawai_bertanggungjawab_lokasi' => 'Test Officer',
        ]);
        
        // No inspections
        $this->assertTrue($asset->needsInspection());

        // Recent inspection
        $inspection = new Inspection([
            'tarikh_pemeriksaan' => now()->subDays(30),
            'asset_id' => $asset->id,
            'keadaan_aset' => 'baik',
            'lokasi_semasa_pemeriksaan' => 'Test Location',
            'cadangan_tindakan' => 'Tiada',
            'pegawai_pemeriksa' => 'Test Inspector',
        ]);
        $asset->inspections()->save($inspection);
        
        $this->assertFalse($asset->needsInspection());

        // Old inspection
        $inspection->tarikh_pemeriksaan = now()->subDays(180);
        $inspection->save();
        
        $this->assertTrue($asset->needsInspection());
    }

    /** @test */
    public function it_can_determine_if_needs_maintenance()
    {
        $asset = Asset::create([
            'masjid_surau_id' => $this->masjidSurau->id,
            'no_siri_pendaftaran' => 'TEST-003',
            'nama_aset' => 'Test Asset',
            'jenis_aset' => 'Elektronik',
            'kategori_aset' => 'asset',
            'tarikh_perolehan' => now(),
            'kaedah_perolehan' => 'Pembelian',
            'nilai_perolehan' => 1000,
            'lokasi_penempatan' => 'Test Location',
            'pegawai_bertanggungjawab_lokasi' => 'Test Officer',
        ]);
        
        // No maintenance records
        $this->assertTrue($asset->needsMaintenance());

        // Recent maintenance
        $maintenance = new MaintenanceRecord([
            'tarikh_penyelenggaraan' => now()->subDays(30),
            'asset_id' => $asset->id,
            'user_id' => $this->user->id,
            'jenis_penyelenggaraan' => 'Pemeriksaan Berkala',
            'butiran_kerja' => 'Pemeriksaan rutin',
            'kos_penyelenggaraan' => 100.00,
            'pegawai_bertanggungjawab' => 'Test Officer',
        ]);
        $asset->maintenanceRecords()->save($maintenance);
        
        $this->assertFalse($asset->needsMaintenance());

        // Old maintenance
        $maintenance->tarikh_penyelenggaraan = now()->subDays(365);
        $maintenance->save();
        
        $this->assertTrue($asset->needsMaintenance());
    }

    /** @test */
    public function it_can_get_latest_movement()
    {
        $asset = Asset::create([
            'masjid_surau_id' => $this->masjidSurau->id,
            'no_siri_pendaftaran' => 'TEST-004',
            'nama_aset' => 'Test Asset',
            'jenis_aset' => 'Elektronik',
            'kategori_aset' => 'asset',
            'tarikh_perolehan' => now(),
            'kaedah_perolehan' => 'Pembelian',
            'nilai_perolehan' => 1000,
            'lokasi_penempatan' => 'Test Location',
            'pegawai_bertanggungjawab_lokasi' => 'Test Officer',
        ]);

        $movement1 = AssetMovement::create([
            'asset_id' => $asset->id,
            'user_id' => $this->user->id,
            'origin_masjid_surau_id' => $this->masjidSurau->id,
            'destination_masjid_surau_id' => $this->masjidSurau->id,
            'tarikh_pergerakan' => now()->subDays(5),
            'tarikh_permohonan' => now()->subDays(7),
            'jenis_pergerakan' => 'Pemindahan',
            'lokasi_asal_spesifik' => 'Original Location',
            'lokasi_destinasi_spesifik' => 'New Location',
            'nama_peminjam_pegawai_bertanggungjawab' => 'Test Officer',
            'tujuan_pergerakan' => 'Penambahbaikan',
        ]);

        $movement2 = AssetMovement::create([
            'asset_id' => $asset->id,
            'user_id' => $this->user->id,
            'origin_masjid_surau_id' => $this->masjidSurau->id,
            'destination_masjid_surau_id' => $this->masjidSurau->id,
            'tarikh_pergerakan' => now()->subDays(2),
            'tarikh_permohonan' => now()->subDays(4),
            'jenis_pergerakan' => 'Pemindahan',
            'lokasi_asal_spesifik' => 'Original Location',
            'lokasi_destinasi_spesifik' => 'New Location',
            'nama_peminjam_pegawai_bertanggungjawab' => 'Test Officer',
            'tujuan_pergerakan' => 'Penambahbaikan',
        ]);

        $latestMovement = $asset->getLatestMovement();
        $this->assertEquals($movement2->id, $latestMovement->id);
    }

    /** @test */
    public function it_can_get_current_location()
    {
        $asset = Asset::create([
            'masjid_surau_id' => $this->masjidSurau->id,
            'no_siri_pendaftaran' => 'TEST-005',
            'nama_aset' => 'Test Asset',
            'jenis_aset' => 'Elektronik',
            'kategori_aset' => 'asset',
            'tarikh_perolehan' => now(),
            'kaedah_perolehan' => 'Pembelian',
            'nilai_perolehan' => 1000,
            'lokasi_penempatan' => 'Original Location',
            'pegawai_bertanggungjawab_lokasi' => 'Test Officer',
        ]);

        // No movements
        $this->assertEquals('Original Location', $asset->getCurrentLocation());

        // With movement
        $movement = AssetMovement::create([
            'asset_id' => $asset->id,
            'user_id' => $this->user->id,
            'origin_masjid_surau_id' => $this->masjidSurau->id,
            'destination_masjid_surau_id' => $this->masjidSurau->id,
            'lokasi_destinasi_spesifik' => 'New Location',
            'lokasi_asal_spesifik' => 'Original Location',
            'status_pergerakan' => 'selesai',
            'tarikh_pergerakan' => now()->subDays(2),
            'tarikh_permohonan' => now()->subDays(4),
            'jenis_pergerakan' => 'Pemindahan',
            'nama_peminjam_pegawai_bertanggungjawab' => 'Test Officer',
            'tujuan_pergerakan' => 'Penambahbaikan',
        ]);

        $this->assertEquals('New Location', $asset->getCurrentLocation());
    }

    /** @test */
    public function it_can_determine_if_is_disposed()
    {
        $asset = Asset::create([
            'masjid_surau_id' => $this->masjidSurau->id,
            'no_siri_pendaftaran' => 'TEST-006',
            'nama_aset' => 'Test Asset',
            'jenis_aset' => 'Elektronik',
            'kategori_aset' => 'asset',
            'tarikh_perolehan' => now(),
            'kaedah_perolehan' => 'Pembelian',
            'nilai_perolehan' => 1000,
            'lokasi_penempatan' => 'Test Location',
            'pegawai_bertanggungjawab_lokasi' => 'Test Officer',
        ]);

        // No disposals
        $this->assertFalse($asset->isDisposed());

        // With pending disposal
        $disposal = Disposal::create([
            'asset_id' => $asset->id,
            'status_pelupusan' => 'dimohon',
            'tarikh_permohonan' => now(),
            'justifikasi_pelupusan' => 'rosak_teruk',
            'kaedah_pelupusan_dicadang' => 'jualan',
            'pegawai_pemohon' => 'Test Officer',
        ]);
        
        $this->assertFalse($asset->isDisposed());

        // With approved disposal
        $disposal->status_pelupusan = 'diluluskan';
        $disposal->save();
        
        $this->assertTrue($asset->isDisposed());
    }

    /** @test */
    public function it_can_determine_if_is_written_off()
    {
        $asset = Asset::create([
            'masjid_surau_id' => $this->masjidSurau->id,
            'no_siri_pendaftaran' => 'TEST-007',
            'nama_aset' => 'Test Asset',
            'jenis_aset' => 'Elektronik',
            'kategori_aset' => 'asset',
            'tarikh_perolehan' => now(),
            'kaedah_perolehan' => 'Pembelian',
            'nilai_perolehan' => 1000,
            'lokasi_penempatan' => 'Test Location',
            'pegawai_bertanggungjawab_lokasi' => 'Test Officer',
        ]);

        // No writeoffs
        $this->assertFalse($asset->isWrittenOff());

        // With pending writeoff
        $writeoff = LossWriteoff::create([
            'asset_id' => $asset->id,
            'status_kejadian' => 'pending',
            'tarikh_laporan' => now(),
            'jenis_kejadian' => 'Kehilangan',
            'sebab_kejadian' => 'Kecurian',
            'butiran_kejadian' => 'Aset hilang dari lokasi asal',
            'pegawai_pelapor' => 'Test Officer',
        ]);
        
        $this->assertFalse($asset->isWrittenOff());

        // With approved writeoff
        $writeoff->status_kejadian = 'diluluskan';
        $writeoff->save();
        
        $this->assertTrue($asset->isWrittenOff());
    }
} 