<?php

namespace Tests\Unit\Models;

use App\Models\LossWriteoff;
use App\Models\Asset;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LossWriteoffTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_uses_correct_table_name()
    {
        $lossWriteoff = new LossWriteoff();
        $this->assertEquals('losses_writeoffs', $lossWriteoff->getTable());
    }

    /** @test */
    public function it_has_fillable_attributes()
    {
        $lossWriteoff = new LossWriteoff();
        
        $fillable = [
            'asset_id',
            'user_id',
            'kuantiti_kehilangan',
            'tarikh_laporan',
            'tarikh_kehilangan',
            'jenis_kejadian',
            'sebab_kejadian',
            'butiran_kejadian',
            'pegawai_pelapor',
            'nilai_kehilangan',
            'laporan_polis',
            'dokumen_kehilangan',
            'tarikh_kelulusan_hapus_kira',
            'status_kejadian',
            'diluluskan_oleh',
            'sebab_penolakan',
            'catatan',
        ];

        $this->assertEquals($fillable, $lossWriteoff->getFillable());
    }

    /** @test */
    public function it_casts_attributes_correctly()
    {
        $lossWriteoff = new LossWriteoff();
        
        $expectedCasts = [
            'tarikh_laporan' => 'datetime',
            'tarikh_kehilangan' => 'datetime',
            'tarikh_kelulusan_hapus_kira' => 'datetime',
            'kuantiti_kehilangan' => 'integer',
            'nilai_kehilangan' => 'decimal:2',
            'dokumen_kehilangan' => 'array',
            'deleted_at' => 'datetime',
            'id' => 'int',
        ];

        $this->assertEquals($expectedCasts, $lossWriteoff->getCasts());
    }

    /** @test */
    public function it_belongs_to_asset()
    {
        $lossWriteoff = new LossWriteoff();
        
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\BelongsTo::class,
            $lossWriteoff->asset()
        );
    }

    /** @test */
    public function it_belongs_to_approver()
    {
        $lossWriteoff = new LossWriteoff();
        
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\BelongsTo::class,
            $lossWriteoff->approver()
        );
    }
} 
