<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Auditable;
use App\Traits\ScopesToMasjidSurau;
use Illuminate\Database\Eloquent\SoftDeletes;

class Disposal extends Model
{
    use HasFactory, Auditable, SoftDeletes, ScopesToMasjidSurau;

    protected $fillable = [
        'asset_id',
        'kuantiti',
        'tarikh_permohonan',
        'justifikasi_pelupusan',
        'kaedah_pelupusan_dicadang',
        'kaedah_pelupusan',
        'nombor_mesyuarat_jawatankuasa',
        'tarikh_kelulusan_pelupusan',
        'tarikh_pelupusan',
        'status_pelupusan',
        'pegawai_pemohon',
        'tempat_pelupusan',
        'hasil_pelupusan',
        'nilai_pelupusan',
        'nilai_baki',
        'catatan',
        'user_id',
        'gambar_pelupusan',
    ];

    protected $casts = [
        'tarikh_permohonan' => 'datetime',
        'tarikh_kelulusan_pelupusan' => 'datetime',
        'tarikh_pelupusan' => 'datetime',
        'kuantiti' => 'integer',
        'hasil_pelupusan' => 'decimal:2',
        'nilai_pelupusan' => 'decimal:2',
        'nilai_baki' => 'decimal:2',
        'gambar_pelupusan' => 'array',
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
     * Get the user who created the disposal request.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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

        return $methods[strtolower($this->kaedah_pelupusan_dicadang)] ?? ucwords(str_replace('_', ' ', $this->kaedah_pelupusan_dicadang));
    }

    /**
     * Get formatted actual disposal method attribute.
     */
    public function getFormattedActualDisposalMethodAttribute(): string
    {
        $methods = [
            'dijual' => 'Dijual',
            'dibuang' => 'Dibuang',
            'dikitar semula' => 'Dikitar Semula',
            'disumbangkan' => 'Disumbangkan',
            'dipindahkan' => 'Dipindahkan',
            'lain-lain' => 'Lain-lain',
            'jualan' => 'Jualan',
            'sumbangan' => 'Sumbangan',
        ];

        $value = $this->kaedah_pelupusan ?? $this->kaedah_pelupusan_dicadang;

        return $methods[strtolower($value)] ?? ucwords(str_replace('_', ' ', $value));
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

    /**
     * Get nilai_baki - calculate from asset if not set.
     */
    public function getNilaiBakiAttribute(): ?float
    {
        // If explicitly set, return it
        if (isset($this->attributes['nilai_baki'])) {
            return $this->attributes['nilai_baki'];
        }

        // Otherwise calculate from asset's current value
        if ($this->relationLoaded('asset') && $this->asset) {
            return $this->asset->getCurrentValue();
        }

        return null;
    }

    /**
     * Get formatted nilai baki attribute.
     */
    public function getFormattedNilaiBakiAttribute(): string
    {
        $value = $this->nilai_baki;
        return $value !== null ? 'RM ' . number_format($value, 2) : 'RM 0.00';
    }
}
