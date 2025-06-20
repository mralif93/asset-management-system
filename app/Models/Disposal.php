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
        'user_id',
        'tarikh_pelupusan',
        'sebab_pelupusan',
        'kaedah_pelupusan',
        'nilai_pelupusan',
        'nilai_baki',
        'catatan',
        'status_kelulusan',
        'tarikh_kelulusan',
        'diluluskan_oleh',
        'sebab_penolakan',
        'gambar_pelupusan',
        // Legacy fields for backward compatibility
        'tarikh_permohonan',
        'justifikasi_pelupusan',
        'kaedah_pelupusan_dicadang',
        'nombor_mesyuarat_jawatankuasa',
        'tarikh_kelulusan_pelupusan',
        'status_pelupusan',
        'pegawai_pemohon',
        'catatan_pelupusan',
    ];

    protected $casts = [
        'tarikh_permohonan' => 'date',
        'tarikh_kelulusan_pelupusan' => 'date',
        'tarikh_pelupusan' => 'date',
        'tarikh_kelulusan' => 'date',
        'nilai_pelupusan' => 'decimal:2',
        'nilai_baki' => 'decimal:2',
        'gambar_pelupusan' => 'array',
    ];

    /**
     * Get the asset that owns the disposal.
     */
    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    /**
     * Get the user who created the disposal request.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user who approved/rejected the disposal.
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diluluskan_oleh');
    }
}
