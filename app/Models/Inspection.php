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
        'kondisi_aset',
        'tarikh_pemeriksaan_akan_datang',
        'nama_pemeriksa',
        'catatan_pemeriksaan',
        'tindakan_diperlukan',
        'gambar_pemeriksaan',
    ];

    protected $casts = [
        'tarikh_pemeriksaan' => 'date',
        'tarikh_pemeriksaan_akan_datang' => 'date',
        'gambar_pemeriksaan' => 'array',
    ];

    /**
     * Get the asset that owns the inspection.
     */
    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }
}
