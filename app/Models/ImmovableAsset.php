<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImmovableAsset extends Model
{
    use HasFactory, Auditable, SoftDeletes;

    protected $fillable = [
        'masjid_surau_id',
        'nama_aset',
        'jenis_aset',
        'alamat',
        'no_hakmilik',
        'no_lot',
        'luas_tanah_bangunan',
        'tarikh_perolehan',
        'sumber_perolehan',
        'kos_perolehan',
        'keadaan_semasa',
        'gambar_aset',
        'catatan',
    ];

    protected $casts = [
        'luas_tanah_bangunan' => 'decimal:2',
        'kos_perolehan' => 'decimal:2',
        'tarikh_perolehan' => 'datetime',
        'gambar_aset' => 'array',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the masjid/surau that owns the immovable asset.
     */
    public function masjidSurau(): BelongsTo
    {
        return $this->belongsTo(MasjidSurau::class);
    }

    /**
     * Get formatted asset type attribute.
     */
    public function getFormattedAssetTypeAttribute(): string
    {
        $types = [
            'tanah' => 'Tanah',
            'bangunan' => 'Bangunan',
        ];

        return $types[strtolower($this->jenis_aset)] ?? ucfirst($this->jenis_aset);
    }

    /**
     * Get formatted acquisition source attribute.
     */
    public function getFormattedAcquisitionSourceAttribute(): string
    {
        $sources = [
            'pembelian' => 'Pembelian',
            'hadiah' => 'Hadiah',
            'hibah' => 'Hibah',
            'sumbangan' => 'Sumbangan',
            'wakaf' => 'Wakaf',
            'lain_lain' => 'Lain-lain',
        ];

        return $sources[strtolower($this->sumber_perolehan)] ?? ucfirst(str_replace('_', ' ', $this->sumber_perolehan));
    }

    /**
     * Get formatted current condition attribute.
     */
    public function getFormattedCurrentConditionAttribute(): string
    {
        return ucfirst($this->keadaan_semasa);
    }
}
