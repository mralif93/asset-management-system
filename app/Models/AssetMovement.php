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
        'user_id',
        'tarikh_permohonan',
        'jenis_pergerakan',
        'lokasi_asal',
        'lokasi_destinasi',
        'tarikh_pergerakan',
        'tarikh_jangka_pulangan',
        'nama_peminjam_pegawai_bertanggungjawab',
        'sebab_pergerakan',
        'catatan_pergerakan',
        'tarikh_jangka_pulang',
        'tarikh_pulang_sebenar',
        'status_pergerakan',
        'pegawai_meluluskan',
        'diluluskan_oleh',
        'tarikh_kelulusan',
        'sebab_penolakan',
        'tarikh_kepulangan',
        'catatan',
    ];

    protected $casts = [
        'tarikh_permohonan' => 'date',
        'tarikh_pergerakan' => 'date',
        'tarikh_jangka_pulangan' => 'date',
        'tarikh_jangka_pulang' => 'date',
        'tarikh_pulang_sebenar' => 'date',
        'tarikh_kelulusan' => 'datetime',
        'tarikh_kepulangan' => 'datetime',
    ];

    /**
     * Get the asset that owns the movement.
     */
    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    /**
     * Get the user who created the movement.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user who approved/rejected the movement.
     */
    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diluluskan_oleh');
    }
}
