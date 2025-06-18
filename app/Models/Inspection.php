<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inspection extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'tarikh_pemeriksaan',
        'keadaan_aset',
        'lokasi_semasa_pemeriksaan',
        'cadangan_tindakan',
        'pegawai_pemeriksa',
        'catatan_pemeriksa',
    ];

    protected $casts = [
        'tarikh_pemeriksaan' => 'date',
    ];

    /**
     * Get the asset that owns the inspection.
     */
    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }
}
