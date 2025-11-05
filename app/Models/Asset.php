<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use HasFactory, Auditable, SoftDeletes;

    protected $fillable = [
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
        'catatan'
    ];

    protected $casts = [
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
    ];

    // Asset status constants
    public const STATUS_NEW = 'Baru';
    public const STATUS_IN_USE = 'Sedang Digunakan';
    public const STATUS_UNDER_MAINTENANCE = 'Dalam Penyelenggaraan';
    public const STATUS_DAMAGED = 'Rosak';
    public const STATUS_ACTIVE = 'Aktif';
    public const STATUS_DISPOSED = 'Dilupuskan';

    // Get all available statuses
    public static function getAvailableStatuses(): array
    {
        return [
            self::STATUS_NEW,
            self::STATUS_IN_USE,
            self::STATUS_UNDER_MAINTENANCE,
            self::STATUS_DAMAGED,
            self::STATUS_ACTIVE,
            self::STATUS_DISPOSED,
        ];
    }

    /**
     * Get the masjid/surau that owns the asset.
     */
    public function masjidSurau(): BelongsTo
    {
        return $this->belongsTo(MasjidSurau::class);
    }

    /**
     * Get the asset movements for the asset.
     */
    public function assetMovements(): HasMany
    {
        return $this->hasMany(AssetMovement::class);
    }

    /**
     * Alias for assetMovements relationship.
     */
    public function movements(): HasMany
    {
        return $this->assetMovements();
    }

    /**
     * Get the inspections for the asset.
     */
    public function inspections(): HasMany
    {
        return $this->hasMany(Inspection::class);
    }

    /**
     * Get the maintenance records for the asset.
     */
    public function maintenanceRecords(): HasMany
    {
        return $this->hasMany(MaintenanceRecord::class);
    }

    /**
     * Get the disposals for the asset.
     */
    public function disposals(): HasMany
    {
        return $this->hasMany(Disposal::class);
    }

    /**
     * Get the losses/writeoffs for the asset.
     */
    public function lossWriteoffs(): HasMany
    {
        return $this->hasMany(LossWriteoff::class);
    }

    /**
     * Calculate the annual depreciation using straight-line method.
     * Formula: (Cost - Discount) / Useful Life
     */
    public function calculateAnnualDepreciation(): ?float
    {
        $cost = $this->nilai_perolehan ?? 0;
        $discount = $this->diskaun ?? 0;
        $usefulLife = $this->umur_faedah_tahunan;
        
        if ($cost <= 0 || !$usefulLife || $usefulLife <= 0) {
            return null;
        }
        
        $depreciableBase = $cost - $discount;
        return round($depreciableBase / $usefulLife, 2);
    }

    /**
     * Get the annual depreciation amount.
     * Uses manual entry if available, otherwise calculates automatically.
     */
    public function getAnnualDepreciation(): ?float
    {
        // If manual annual depreciation is set, use it
        if ($this->susut_nilai_tahunan && $this->susut_nilai_tahunan > 0) {
            return $this->susut_nilai_tahunan;
        }
        
        // Otherwise, calculate using straight-line method
        return $this->calculateAnnualDepreciation();
    }

    /**
     * Calculate the current value of the asset after depreciation using straight-line method.
     * Formula: Cost - Discount - (Annual Depreciation × Years Elapsed)
     * Depreciation stops at the end of useful life period.
     */
    public function getCurrentValue(): float
    {
        if (!$this->nilai_perolehan || !$this->tarikh_perolehan) {
            return 0;
        }

        $cost = $this->nilai_perolehan;
        $discount = $this->diskaun ?? 0;
        $depreciableBase = $cost - $discount;
        
        // Get annual depreciation amount
        $annualDepreciation = $this->getAnnualDepreciation();
        
        if (!$annualDepreciation || $annualDepreciation <= 0) {
            return round($depreciableBase, 2);
        }

        // Calculate years elapsed (only full years)
        $yearsElapsed = (int) $this->tarikh_perolehan->diffInYears(now());
        
        // Get useful life period
        $usefulLife = $this->umur_faedah_tahunan;
        
        // Don't depreciate beyond useful life
        if ($usefulLife && $yearsElapsed > $usefulLife) {
            $yearsElapsed = $usefulLife;
        }
        
        // Calculate total depreciation
        $totalDepreciation = $annualDepreciation * $yearsElapsed;
        
        // Current value = Depreciable Base - Total Depreciation
        $currentValue = $depreciableBase - $totalDepreciation;
        
        return round(max(0, $currentValue), 2);
    }

    /**
     * Get total accumulated depreciation to date.
     */
    public function getTotalDepreciation(): float
    {
        $annualDepreciation = $this->getAnnualDepreciation();
        
        if (!$annualDepreciation || $annualDepreciation <= 0) {
            return 0;
        }

        $yearsElapsed = (int) $this->tarikh_perolehan->diffInYears(now());
        $usefulLife = $this->umur_faedah_tahunan;
        
        // Don't depreciate beyond useful life
        if ($usefulLife && $yearsElapsed > $usefulLife) {
            $yearsElapsed = $usefulLife;
        }
        
        return round($annualDepreciation * $yearsElapsed, 2);
    }

    /**
     * Get depreciation schedule (year-by-year breakdown).
     */
    public function getDepreciationSchedule(): array
    {
        $schedule = [];
        $cost = $this->nilai_perolehan ?? 0;
        $discount = $this->diskaun ?? 0;
        $depreciableBase = $cost - $discount;
        $annualDepreciation = $this->getAnnualDepreciation();
        $usefulLife = $this->umur_faedah_tahunan;
        
        if (!$annualDepreciation || !$usefulLife) {
            return $schedule;
        }
        
        $startingNBV = $depreciableBase;
        
        for ($year = 1; $year <= $usefulLife; $year++) {
            $endingNBV = max(0, $startingNBV - $annualDepreciation);
            
            $schedule[] = [
                'year' => $year,
                'starting_nbv' => round($startingNBV, 2),
                'annual_depreciation' => round($annualDepreciation, 2),
                'ending_nbv' => round($endingNBV, 2),
            ];
            
            $startingNBV = $endingNBV;
        }
        
        return $schedule;
    }

    /**
     * Determine if the asset needs inspection.
     */
    public function needsInspection(): bool
    {
        $lastInspection = $this->inspections()
            ->orderBy('tarikh_pemeriksaan', 'desc')
            ->first();

        if (!$lastInspection) {
            return true;
        }

        return $lastInspection->tarikh_pemeriksaan->addDays(90)->isPast();
    }

    /**
     * Determine if the asset needs maintenance.
     */
    public function needsMaintenance(): bool
    {
        $lastMaintenance = $this->maintenanceRecords()
            ->orderBy('tarikh_penyelenggaraan', 'desc')
            ->first();

        if (!$lastMaintenance) {
            return true;
        }

        return $lastMaintenance->tarikh_penyelenggaraan->addDays(180)->isPast();
    }

    /**
     * Get the latest movement record.
     */
    public function getLatestMovement(): ?AssetMovement
    {
        return $this->assetMovements()
            ->orderBy('tarikh_pergerakan', 'desc')
            ->first();
    }

    /**
     * Get the current location of the asset.
     */
    public function getCurrentLocation(): string
    {
        $latestMovement = $this->assetMovements()
            ->where('status_pergerakan', 'selesai')
            ->orderBy('tarikh_pergerakan', 'desc')
            ->first();

        return $latestMovement ? $latestMovement->lokasi_destinasi_spesifik : $this->lokasi_penempatan;
    }

    /**
     * Determine if the asset is disposed.
     */
    public function isDisposed(): bool
    {
        return $this->disposals()
            ->where('status_pelupusan', 'diluluskan')
            ->exists();
    }

    /**
     * Determine if the asset is written off.
     */
    public function isWrittenOff(): bool
    {
        return $this->lossWriteoffs()
            ->where('status_kejadian', 'diluluskan')
            ->exists();
    }
}
