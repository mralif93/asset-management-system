<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'masjid_surau_id',
        'no_siri_pendaftaran',
        'nama_aset',
        'jenis_aset',
        'tarikh_perolehan',
        'kaedah_perolehan',
        'nilai_perolehan',
        'umur_faedah_tahunan',
        'susut_nilai_tahunan',
        'lokasi_penempatan',
        'pegawai_bertanggungjawab_lokasi',
        'status_aset',
        'gambar_aset',
        'catatan',
    ];

    protected $casts = [
        'tarikh_perolehan' => 'date',
        'nilai_perolehan' => 'decimal:2',
        'susut_nilai_tahunan' => 'decimal:2',
        'gambar_aset' => 'array',
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
}
