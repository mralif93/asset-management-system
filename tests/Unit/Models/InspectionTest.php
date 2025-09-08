<?php

namespace Tests\Unit\Models;

use App\Models\Inspection;
use App\Models\Asset;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InspectionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_fillable_attributes()
    {
        $inspection = new Inspection();
        
        $fillable = [
            'asset_id',
            'tarikh_pemeriksaan',
            'keadaan_aset',
            'lokasi_semasa_pemeriksaan',
            'cadangan_tindakan',
            'pegawai_pemeriksa',
            'catatan_pemeriksa'
        ];

        $this->assertEquals($fillable, $inspection->getFillable());
    }

    /** @test */
    public function it_casts_attributes_correctly()
    {
        $inspection = new Inspection();
        
        $expectedCasts = [
            'tarikh_pemeriksaan' => 'datetime',
            'id' => 'int',
            'deleted_at' => 'datetime',
        ];

        $this->assertEquals($expectedCasts, $inspection->getCasts());
    }

    /** @test */
    public function it_belongs_to_asset()
    {
        $inspection = new Inspection();
        
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\BelongsTo::class,
            $inspection->asset()
        );
    }

    /** @test */
    public function it_belongs_to_inspector()
    {
        $inspection = new Inspection();
        
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\BelongsTo::class,
            $inspection->inspector()
        );
    }

    /** @test */
    public function it_can_scope_by_condition()
    {
        $inspection = new Inspection();
        $query = $inspection->newQuery();
        
        $result = $inspection->scopeByCondition($query, 'baik');
        
        $this->assertStringContainsString(
            'where "keadaan_aset" = ?',
            $result->toSql()
        );
    }

    /** @test */
    public function it_can_scope_by_date_range()
    {
        $inspection = new Inspection();
        $query = $inspection->newQuery();
        
        $startDate = now()->subDays(7);
        $endDate = now();
        
        $result = $inspection->scopeInspectionDateRange($query, $startDate, $endDate);
        
        $this->assertStringContainsString(
            'where "tarikh_pemeriksaan" between ? and ?',
            $result->toSql()
        );
    }

    /** @test */
    public function it_can_scope_needs_action()
    {
        $inspection = new Inspection();
        $query = $inspection->newQuery();
        
        $result = $inspection->scopeNeedsAction($query);
        
        $this->assertStringContainsString(
            'where "cadangan_tindakan" in (?, ?, ?)',
            $result->toSql()
        );
    }

    /** @test */
    public function it_can_scope_upcoming_inspections()
    {
        $inspection = new Inspection();
        $query = $inspection->newQuery();
        
        $result = $inspection->scopeUpcoming($query);
        
        $this->assertStringContainsString(
            'where "tarikh_pemeriksaan_akan_datang" > ?',
            $result->toSql()
        );
    }

    /** @test */
    public function it_formats_condition_correctly()
    {
        $inspection = new Inspection();
        
        $inspection->keadaan_aset = 'baik';
        $this->assertEquals('Baik', $inspection->getFormattedConditionAttribute());
        
        $inspection->keadaan_aset = 'rosak_kecil';
        $this->assertEquals('Rosak Kecil', $inspection->getFormattedConditionAttribute());
        
        $inspection->keadaan_aset = 'rosak_teruk';
        $this->assertEquals('Rosak Teruk', $inspection->getFormattedConditionAttribute());
    }

    /** @test */
    public function it_determines_if_action_is_needed()
    {
        $inspection = new Inspection();
        
        $inspection->tindakan_diperlukan = true;
        $this->assertTrue($inspection->needsAction());
        
        $inspection->tindakan_diperlukan = false;
        $this->assertFalse($inspection->needsAction());
    }

    /** @test */
    public function it_determines_if_inspection_is_overdue()
    {
        $inspection = new Inspection();
        
        $inspection->tarikh_pemeriksaan_akan_datang = now()->subDay();
        $this->assertTrue($inspection->isOverdue());
        
        $inspection->tarikh_pemeriksaan_akan_datang = now()->addDay();
        $this->assertFalse($inspection->isOverdue());
    }
} 