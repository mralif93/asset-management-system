<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaintenanceRecord extends Model
{
    use HasFactory, Auditable, SoftDeletes;

    protected $fillable = [
        'asset_id',
        'user_id',
        'tarikh_penyelenggaraan',
        'jenis_penyelenggaraan',
        'butiran_kerja',
        'nama_syarikat_kontraktor',
        'penyedia_perkhidmatan',
        'kos_penyelenggaraan',
        'status_penyelenggaraan',
        'pegawai_bertanggungjawab',
        'catatan'
    ];

    protected $casts = [
        'tarikh_penyelenggaraan' => 'datetime',
        'kos_penyelenggaraan' => 'decimal:2',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the asset that owns the maintenance record.
     */
    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    /**
     * Scope maintenance records by status.
     */
    public function scopeByStatus(Builder $query, string $status): Builder
    {
        return $query->where('status_penyelenggaraan', $status);
    }

    /**
     * Scope maintenance records by type.
     */
    public function scopeByType(Builder $query, string $type): Builder
    {
        return $query->where('jenis_penyelenggaraan', $type);
    }

    /**
     * Scope maintenance records by date range.
     */
    public function scopeMaintenanceDateRange(Builder $query, Carbon $startDate, Carbon $endDate): Builder
    {
        return $query->whereBetween('tarikh_penyelenggaraan', [$startDate, $endDate]);
    }

    /**
     * Get formatted status attribute.
     */
    public function getFormattedStatusAttribute(): string
    {
        $statuses = [
            'selesai' => 'Selesai',
            'dalam_proses' => 'Dalam Proses',
        ];

        return $statuses[strtolower($this->status_penyelenggaraan)] ?? ucfirst(str_replace('_', ' ', $this->status_penyelenggaraan));
    }

    /**
     * Get formatted type attribute.
     */
    public function getFormattedTypeAttribute(): string
    {
        $types = [
            'pencegahan' => 'Pencegahan',
            'pembaikan' => 'Pembaikan',
        ];

        return $types[strtolower($this->jenis_penyelenggaraan)] ?? ucfirst(str_replace('_', ' ', $this->jenis_penyelenggaraan));
    }

    /**
     * Check if maintenance is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status_penyelenggaraan === 'Selesai';
    }

    /**
     * Check if maintenance is overdue.
     */
    public function isOverdue(): bool
    {
        return $this->tarikh_penyelenggaraan_akan_datang && $this->tarikh_penyelenggaraan_akan_datang->isPast();
    }

    /**
     * Calculate days until next maintenance.
     */
    public function daysUntilNextMaintenance(): int
    {
        if (!$this->tarikh_penyelenggaraan_akan_datang) {
            return 0;
        }

        $now = Carbon::now()->startOfDay();
        $nextDate = $this->tarikh_penyelenggaraan_akan_datang->copy()->startOfDay();
        return $now->diffInDays($nextDate, false);
    }

    /**
     * Get status color for display.
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status_penyelenggaraan) {
            'selesai' => 'green',
            'dalam_proses' => 'yellow',
            'belum_mula' => 'gray',
            default => 'gray'
        };
    }
}
