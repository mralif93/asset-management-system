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
        'user_id',
        'tarikh_kehilangan',
        'jenis_kehilangan',
        'sebab_kehilangan',
        'nilai_kehilangan',
        'laporan_polis',
        'catatan_kehilangan',
        'dokumen_kehilangan',
        'status_kelulusan',
        'tarikh_kelulusan',
        'diluluskan_oleh',
        'sebab_penolakan',
        'catatan',
    ];

    protected $casts = [
        'tarikh_kehilangan' => 'date',
        'tarikh_kelulusan' => 'date',
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
     * Get the user who reported the loss/writeoff.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the user who approved the loss/writeoff.
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diluluskan_oleh');
    }
}
