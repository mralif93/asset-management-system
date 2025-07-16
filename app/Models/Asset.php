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
        'nilai_perolehan' => 'decimal:2',
        'diskaun' => 'decimal:2',
        'susut_nilai_tahunan' => 'decimal:2',
        'gambar_aset' => 'array',
        'deleted_at' => 'datetime',
    ];

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
     * Calculate the current value of the asset after depreciation.
     */
    public function getCurrentValue(): float
    {
        if (!$this->nilai_perolehan || !$this->susut_nilai_tahunan || !$this->tarikh_perolehan) {
            return 0;
        }

        $years = $this->tarikh_perolehan->diffInYears(now());
        $depreciation = $this->susut_nilai_tahunan * $years;
        
        return round(max(0, $this->nilai_perolehan - $depreciation), 2);
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

        return $latestMovement ? $latestMovement->lokasi_destinasi : $this->lokasi_penempatan;
    }

    /**
     * Determine if the asset is disposed.
     */
    public function isDisposed(): bool
    {
        return $this->disposals()
            ->where('status_kelulusan', 'diluluskan')
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
