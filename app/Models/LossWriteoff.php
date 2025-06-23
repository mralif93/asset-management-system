<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LossWriteoff extends Model
{
    use HasFactory;

    protected $table = 'losses_writeoffs';

    protected $fillable = [
        'asset_id',
        'tarikh_laporan',
        'jenis_kejadian',
        'sebab_kejadian',
        'butiran_kejadian',
        'pegawai_pelapor',
        'tarikh_kelulusan_hapus_kira',
        'status_kejadian',
        'catatan',
        'nilai_kehilangan',
        'laporan_polis',
        'dokumen_kehilangan',
        'diluluskan_oleh',
        'sebab_penolakan',
    ];

    protected $casts = [
        'tarikh_laporan' => 'date',
        'tarikh_kelulusan_hapus_kira' => 'date',
        'nilai_kehilangan' => 'decimal:2',
        'dokumen_kehilangan' => 'array',
    ];

    /**
     * Get the asset that owns the loss/writeoff.
     */
    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    /**
     * Get the user who approved the loss/writeoff.
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diluluskan_oleh');
    }
}
