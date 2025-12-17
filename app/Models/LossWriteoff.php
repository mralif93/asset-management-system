<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class LossWriteoff extends Model
{
    use HasFactory, Auditable, SoftDeletes;

    protected $table = 'losses_writeoffs';

    protected $fillable = [
        'asset_id',
        'kuantiti_kehilangan',
        'tarikh_laporan',
        'jenis_kejadian',
        'sebab_kejadian',
        'butiran_kejadian',
        'pegawai_pelapor',
        'tarikh_kelulusan_hapus_kira',
        'status_kejadian',
        'catatan',
    ];

    protected $casts = [
        'tarikh_laporan' => 'datetime',
        'tarikh_kelulusan_hapus_kira' => 'datetime',
        'kuantiti_kehilangan' => 'integer',
        'deleted_at' => 'datetime',
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

    /**
     * Get formatted incident type attribute.
     */
    public function getFormattedIncidentTypeAttribute(): string
    {
        $types = [
            'hilang' => 'Hilang',
            'hapus_kira' => 'Hapus Kira',
        ];

        return $types[strtolower($this->jenis_kejadian)] ?? ucfirst(str_replace('_', ' ', $this->jenis_kejadian));
    }

    /**
     * Get formatted incident reason attribute.
     */
    public function getFormattedIncidentReasonAttribute(): string
    {
        $reasons = [
            'bencana_alam' => 'Bencana Alam',
            'kecurian' => 'Kecurian',
            'kecuaian' => 'Kecuaian',
            'tidak_dapat_dikesan' => 'Tidak dapat dikesan',
        ];

        return $reasons[strtolower($this->sebab_kejadian)] ?? ucfirst(str_replace('_', ' ', $this->sebab_kejadian));
    }

    /**
     * Get formatted status attribute.
     */
    public function getFormattedStatusAttribute(): string
    {
        $statuses = [
            'dilaporkan' => 'Dilaporkan',
            'diluluskan_hapus_kira' => 'Diluluskan Hapus Kira',
            'ditolak' => 'Ditolak',
        ];

        return $statuses[strtolower($this->status_kejadian)] ?? ucfirst(str_replace('_', ' ', $this->status_kejadian));
    }
}
