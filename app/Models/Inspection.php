<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Inspection extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'tarikh_pemeriksaan',
        'kondisi_aset',
        'tarikh_pemeriksaan_akan_datang',
        'nama_pemeriksa',
        'catatan_pemeriksaan',
        'tindakan_diperlukan',
        'gambar_pemeriksaan',
    ];

    protected $casts = [
        'tarikh_pemeriksaan' => 'date',
        'tarikh_pemeriksaan_akan_datang' => 'date',
        'gambar_pemeriksaan' => 'array',
        'tindakan_diperlukan' => 'boolean',
        'id' => 'int',
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
        return $query->where('tindakan_diperlukan', true);
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
            'sederhana' => 'Sederhana',
            'rosak' => 'Rosak',
        ];

        return $conditions[strtolower($this->kondisi_aset)] ?? ucfirst($this->kondisi_aset);
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
