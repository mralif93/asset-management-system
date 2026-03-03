<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\Auditable;
use App\Traits\ScopesToMasjidSurau;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use HasFactory, Auditable, SoftDeletes, ScopesToMasjidSurau;

    protected $fillable = [
        'masjid_surau_id',
        'no_siri_pendaftaran',
        'nama_aset',
        'kuantiti',
        'batch_id',
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
        'pembekal_alamat',
        'pembekal_no_telefon',
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
        'kuantiti' => 'integer',
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
    public const STATUS_LOST = 'Kehilangan';

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
            self::STATUS_LOST,
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
     * Get other assets in the same batch.
     */
    public function batchSiblings(): HasMany
    {
        return $this->hasMany(Asset::class, 'batch_id', 'batch_id');
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
            ->whereIn('status_pelupusan', ['Diluluskan', 'diluluskan'])
            ->exists();
    }

    /**
     * Determine if the asset is written off.
     */
    public function isWrittenOff(): bool
    {
        return $this->lossWriteoffs()
            ->whereIn('status_kejadian', ['Diluluskan', 'Diluluskan Hapus Kira', 'diluluskan'])
            ->exists();
    }

    /**
     * Scope for active assets.
     */
    public function scopeActive($query)
    {
        return $query->where('status_aset', 'Aktif');
    }

    /**
     * Scope for disposed assets.
     */
    public function scopeDisposed($query)
    {
        return $query->where('status_aset', 'Dilupuskan');
    }

    /**
     * Scope for lost assets.
     */
    public function scopeLost($query)
    {
        return $query->where('status_aset', 'Kehilangan');
    }

    /**
     * Scope for assets by location.
     */
    public function scopeByLocation($query, $location)
    {
        return $query->where('lokasi_penempatan', 'like', "%{$location}%");
    }

    /**
     * Scope for assets by type.
     */
    public function scopeByType($query, $type)
    {
        return $query->where('jenis_aset', $type);
    }

    /**
     * Scope for assets by category.
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('kategori_aset', $category);
    }

    /**
     * Scope for assets by masjid/surau.
     */
    public function scopeByMasjidSurau($query, $masjidSurauId)
    {
        return $query->where('masjid_surau_id', $masjidSurauId);
    }

    /**
     * Scope for capital assets (asset category).
     */
    public function scopeCapitalAssets($query)
    {
        return $query->where('kategori_aset', 'asset');
    }

    /**
     * Scope for inventory (non-asset category).
     */
    public function scopeInventory($query)
    {
        return $query->where('kategori_aset', 'non-asset');
    }

    /**
     * Scope for search.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('nama_aset', 'like', "%{$search}%")
                ->orWhere('no_siri_pendaftaran', 'like', "%{$search}%")
                ->orWhere('jenama', 'like', "%{$search}%")
                ->orWhere('pembekal', 'like', "%{$search}%");
        });
    }

    /**
     * Scope for assets needing inspection.
     */
    public function scopeNeedsInspection($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('tarikh_pemeriksaan_terakhir')
                ->orWhere('tarikh_pemeriksaan_terakhir', '<', now()->subDays(90));
        });
    }

    /**
     * Scope for assets needing maintenance.
     */
    public function scopeNeedsMaintenance($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('tarikh_penyelenggaraan_akan_datang')
                ->orWhere('tarikh_penyelenggaraan_akan_datang', '<', now());
        });
    }

    /**
     * Scope for warranty expiring soon (within 30 days).
     */
    public function scopeWarrantyExpiringSoon($query)
    {
        return $query->whereNotNull('tarikh_tamat_jaminan')
            ->whereBetween('tarikh_tamat_jaminan', [now(), now()->addDays(30)])
            ->where('status_jaminan', 'Aktif');
    }

    /**
     * Scope for assets under warranty.
     */
    public function scopeUnderWarranty($query)
    {
        return $query->where('status_jaminan', 'Aktif')
            ->where('tarikh_tamat_jaminan', '>', now());
    }

    /**
     * Get formatted acquisition value.
     */
    public function getFormattedNilaiPerolehanAttribute(): string
    {
        return 'RM ' . number_format($this->nilai_perolehan ?? 0, 2);
    }

    /**
     * Get formatted current value.
     */
    public function getFormattedCurrentValueAttribute(): string
    {
        return 'RM ' . number_format($this->getCurrentValue() ?? 0, 2);
    }

    /**
     * Get status badge color.
     */
    public function getStatusBadgeColorAttribute(): string
    {
        return match ($this->status_aset) {
            'Aktif', 'Sedang Digunakan' => 'green',
            'Baru' => 'blue',
            'Dalam Penyelenggaraan' => 'yellow',
            'Rosak' => 'red',
            'Dilupuskan' => 'gray',
            'Kehilangan' => 'purple',
            default => 'gray',
        };
    }
}
