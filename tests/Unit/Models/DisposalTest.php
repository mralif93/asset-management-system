<?php

namespace Tests\Unit\Models;

use App\Models\Disposal;
use App\Models\Asset;
use App\Models\User;
use App\Models\MasjidSurau;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DisposalTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_fillable_attributes()
    {
        $disposal = new Disposal();
        
        $fillable = [
            'asset_id',
            'tarikh_permohonan',
            'justifikasi_pelupusan',
            'kaedah_pelupusan_dicadang',
            'nombor_mesyuarat_jawatankuasa',
            'tarikh_kelulusan_pelupusan',
            'status_pelupusan',
            'pegawai_pemohon',
            'catatan',
        ];

        $this->assertEquals($fillable, $disposal->getFillable());
    }

    /** @test */
    public function it_casts_attributes_correctly()
    {
        $disposal = new Disposal();
        
        $expectedCasts = [
            'tarikh_permohonan' => 'datetime',
            'tarikh_kelulusan_pelupusan' => 'datetime',
            'deleted_at' => 'datetime',
            'id' => 'int',
        ];

        $this->assertEquals($expectedCasts, $disposal->getCasts());
    }

    /** @test */
    public function it_belongs_to_asset()
    {
        $disposal = new Disposal();
        
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\BelongsTo::class,
            $disposal->asset()
        );
    }

    /** @test */
    public function it_does_not_have_user_relationship()
    {
        $disposal = new Disposal();
        
        $this->assertFalse(method_exists($disposal, 'user'));
    }

    /** @test */
    public function it_does_not_have_approver_relationship()
    {
        $disposal = new Disposal();
        
        $this->assertFalse(method_exists($disposal, 'approver'));
    }

    /** @test */
    public function it_uses_auditable_trait()
    {
        $disposal = new Disposal();
        $this->assertContains('App\Traits\Auditable', class_uses_recursive($disposal));
    }

    /** @test */
    public function it_uses_soft_deletes()
    {
        $disposal = new Disposal();
        $this->assertContains('Illuminate\Database\Eloquent\SoftDeletes', class_uses_recursive($disposal));
    }

    /** @test */
    public function it_formats_justification_correctly()
    {
        $disposal = new Disposal();
        
        $disposal->justifikasi_pelupusan = 'rosak_teruk';
        $this->assertEquals('Rosak Teruk', $disposal->getFormattedJustificationAttribute());
        
        $disposal->justifikasi_pelupusan = 'usang';
        $this->assertEquals('Usang', $disposal->getFormattedJustificationAttribute());
        
        $disposal->justifikasi_pelupusan = 'tidak_ekonomi';
        $this->assertEquals('Tidak Ekonomi', $disposal->getFormattedJustificationAttribute());
        
        $disposal->justifikasi_pelupusan = 'custom_reason';
        $this->assertEquals('Custom reason', $disposal->getFormattedJustificationAttribute());
    }

    /** @test */
    public function it_formats_disposal_method_correctly()
    {
        $disposal = new Disposal();
        
        $disposal->kaedah_pelupusan_dicadang = 'jualan';
        $this->assertEquals('Jualan', $disposal->getFormattedDisposalMethodAttribute());
        
        $disposal->kaedah_pelupusan_dicadang = 'buangan';
        $this->assertEquals('Buangan', $disposal->getFormattedDisposalMethodAttribute());
        
        $disposal->kaedah_pelupusan_dicadang = 'hapus_kira';
        $this->assertEquals('Hapus Kira', $disposal->getFormattedDisposalMethodAttribute());
    }

    /** @test */
    public function it_formats_status_correctly()
    {
        $disposal = new Disposal();
        
        $disposal->status_pelupusan = 'dimohon';
        $this->assertEquals('Dimohon', $disposal->getFormattedStatusAttribute());
        
        $disposal->status_pelupusan = 'diluluskan';
        $this->assertEquals('Diluluskan', $disposal->getFormattedStatusAttribute());
        
        $disposal->status_pelupusan = 'selesai_dilupus';
        $this->assertEquals('Selesai Dilupus', $disposal->getFormattedStatusAttribute());
    }

    /** @test */
    public function it_can_create_disposal_with_valid_attributes()
    {
        $masjidSurau = MasjidSurau::create([
            'nama' => 'Test Masjid',
            'jenis' => 'Masjid',
            'status' => 'Aktif',
        ]);
        
        $asset = Asset::create([
            'masjid_surau_id' => $masjidSurau->id,
            'no_siri_pendaftaran' => 'TEST-001',
            'nama_aset' => 'Test Asset',
            'jenis_aset' => 'Elektronik',
            'tarikh_perolehan' => now(),
            'kaedah_perolehan' => 'Pembelian',
            'nilai_perolehan' => 1000,
            'lokasi_penempatan' => 'Test Location',
            'pegawai_bertanggungjawab_lokasi' => 'Test Officer',
        ]);
        
        $disposalData = [
            'asset_id' => $asset->id,
            'tarikh_permohonan' => now(),
            'justifikasi_pelupusan' => 'rosak_teruk',
            'kaedah_pelupusan_dicadang' => 'buangan',
            'status_pelupusan' => 'dimohon',
            'pegawai_pemohon' => 'Test Requester',
        ];
        
        $disposal = Disposal::create($disposalData);
        
        $this->assertDatabaseHas('disposals', [
            'id' => $disposal->id,
            'asset_id' => $asset->id,
            'justifikasi_pelupusan' => 'rosak_teruk',
            'kaedah_pelupusan_dicadang' => 'buangan',
            'status_pelupusan' => 'dimohon',
        ]);
    }
} 