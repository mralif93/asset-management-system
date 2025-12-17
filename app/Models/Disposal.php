<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Disposal extends Model
{
    use HasFactory, Auditable, SoftDeletes;

    protected $fillable = [
        'asset_id',
        'kuantiti',
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
        'tarikh_permohonan' => 'datetime',
        'tarikh_kelulusan_pelupusan' => 'datetime',
        'kuantiti' => 'integer',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the asset that owns the disposal.
     */
    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    /**
     * Get formatted justification attribute.
     */
    public function getFormattedJustificationAttribute(): string
    {
        $justifications = [
            'rosak_teruk' => 'Rosak Teruk',
            'usang' => 'Usang',
            'tidak_ekonomi' => 'Tidak Ekonomi',
            'tiada_penggunaan' => 'Tiada Penggunaan',
            'lain_lain' => 'Lain-lain',
        ];

        return $justifications[strtolower($this->justifikasi_pelupusan)] ?? ucfirst(str_replace('_', ' ', $this->justifikasi_pelupusan));
    }

    /**
     * Get formatted disposal method attribute.
     */
    public function getFormattedDisposalMethodAttribute(): string
    {
        $methods = [
            'jualan' => 'Jualan',
            'buangan' => 'Buangan',
            'hadiah' => 'Hadiah',
            'tukar_beli' => 'Tukar Beli',
            'hapus_kira' => 'Hapus Kira',
        ];

        return $methods[strtolower($this->kaedah_pelupusan_dicadang)] ?? ucfirst(str_replace('_', ' ', $this->kaedah_pelupusan_dicadang));
    }

    /**
     * Get formatted status attribute.
     */
    public function getFormattedStatusAttribute(): string
    {
        $statuses = [
            'dimohon' => 'Dimohon',
            'diluluskan' => 'Diluluskan',
            'ditolak' => 'Ditolak',
            'selesai_dilupus' => 'Selesai Dilupus',
        ];

        return $statuses[strtolower($this->status_pelupusan)] ?? ucfirst(str_replace('_', ' ', $this->status_pelupusan));
    }
}
