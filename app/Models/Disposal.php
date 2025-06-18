<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Disposal extends Model
{
    use HasFactory;

    protected $fillable = [
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

    protected $casts = [
        'tarikh_permohonan' => 'date',
        'tarikh_kelulusan_pelupusan' => 'date',
    ];

    /**
     * Get the asset that owns the disposal.
     */
    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }
}
