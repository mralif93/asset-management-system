<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inspection extends Model
{
    use HasFactory, Auditable, SoftDeletes;

    protected $fillable = [
        'asset_id',
        'tarikh_pemeriksaan',
        'keadaan_aset',
        'lokasi_semasa_pemeriksaan',
        'cadangan_tindakan',
        'pegawai_pemeriksa',
        'catatan_pemeriksa'
    ];

    protected $casts = [
        'tarikh_pemeriksaan' => 'datetime',
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
    public function inspector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'nama_pemeriksa', 'name');
    }

    /**
     * Scope inspections by asset condition.
     */
    public function scopeByCondition(Builder $query, string $condition): Builder
    {
        return $query->where('keadaan_aset', $condition);
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
            'baik' => 'Baik',
            'rosak_kecil' => 'Rosak Kecil',
            'rosak_teruk' => 'Rosak Teruk',
        ];

        return $conditions[strtolower($this->keadaan_aset)] ?? ucfirst($this->keadaan_aset);
    }

    /**
     * Check if inspection needs action.
     */
    public function needsAction(): bool
    {
        return $this->tindakan_diperlukan;
    }

    /**
     * Check if inspection is overdue.
     */
    public function isOverdue(): bool
    {
        return $this->tarikh_pemeriksaan_akan_datang && $this->tarikh_pemeriksaan_akan_datang->isPast();
    }
}
