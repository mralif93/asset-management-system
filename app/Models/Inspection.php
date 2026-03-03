<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\Auditable;
use App\Traits\ScopesToMasjidSurau;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inspection extends Model
{
    use HasFactory, Auditable, SoftDeletes, ScopesToMasjidSurau;

    protected $fillable = [
        'asset_id',
        'user_id',
        'tarikh_pemeriksaan',
        'kondisi_aset',
        'lokasi_semasa_pemeriksaan',
        'cadangan_tindakan',
        'pegawai_pemeriksa',
        'catatan_pemeriksa',
        'signature',
        'jawatan_pemeriksa',
        'tarikh_pemeriksaan_akan_datang',
        'gambar_pemeriksaan',
    ];

    protected $casts = [
        'tarikh_pemeriksaan' => 'datetime',
        'tarikh_pemeriksaan_akan_datang' => 'datetime',
        'gambar_pemeriksaan' => 'array',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the asset that owns the inspection.
     */
    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    /**
     * Get the user who performed the inspection.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user who performed the inspection (alias).
     */
    public function inspector(): BelongsTo
    {
        return $this->user();
    }

    /**
     * Scope inspections by asset condition.
     */
    public function scopeByCondition(Builder $query, string $condition): Builder
    {
        return $query->where('kondisi_aset', $condition);
    }

    /**
     * Scope inspections by date range.
     */
    public function scopeInspectionDateRange(Builder $query, Carbon $startDate, Carbon $endDate): Builder
    {
        return $query->whereBetween('tarikh_pemeriksaan', [$startDate, $endDate]);
    }

    /**
     * Scope inspections that need action.
     */
    public function scopeNeedsAction(Builder $query): Builder
    {
        return $query->whereIn('cadangan_tindakan', ['Penyelenggaraan', 'Pelupusan', 'Hapus Kira']);
    }

    /**
     * Scope upcoming inspections.
     */
    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('tarikh_pemeriksaan_akan_datang', '>', now());
    }

    /**
     * Get formatted condition attribute.
     */
    public function getFormattedConditionAttribute(): string
    {
        $conditions = [
            'sedang_digunakan' => 'Sedang Digunakan',
            'tidak_digunakan' => 'Tidak Digunakan',
            'rosak' => 'Rosak',
            'sedang_diselenggara' => 'Sedang Diselenggara',
            'hilang' => 'Hilang',
            'baik' => 'Baik',
            'sederhana' => 'Sederhana',
        ];

        return $conditions[strtolower($this->kondisi_aset)] ?? $this->kondisi_aset;
    }

    /**
     * Check if inspection needs action.
     */
    public function needsAction(): bool
    {
        return in_array($this->cadangan_tindakan, ['Penyelenggaraan', 'Pelupusan', 'Hapus Kira']);
    }

    /**
     * Check if inspection is overdue.
     */
    public function isOverdue(): bool
    {
        return $this->tarikh_pemeriksaan_akan_datang && $this->tarikh_pemeriksaan_akan_datang->isPast();
    }
}
