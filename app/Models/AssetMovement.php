<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'tarikh_permohonan',
        'jenis_pergerakan',
        'lokasi_asal',
        'lokasi_destinasi',
        'nama_peminjam_pegawai_bertanggungjawab',
        'tujuan_pergerakan',
        'tarikh_jangka_pulang',
        'tarikh_pulang_sebenar',
        'status_pergerakan',
        'pegawai_meluluskan',
        'catatan',
    ];

    protected $casts = [
        'tarikh_permohonan' => 'date',
        'tarikh_jangka_pulang' => 'date',
        'tarikh_pulang_sebenar' => 'date',
    ];

    /**
     * Get the asset that owns the movement.
     */
    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }
}
