<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class MaintenanceRecord extends Model
{
    use HasFactory;

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
        'catatan',
        'catatan_penyelenggaraan',
        'tarikh_penyelenggaraan_akan_datang',
        'gambar_penyelenggaraan',
    ];

    protected $casts = [
        'tarikh_penyelenggaraan' => 'date',
        'tarikh_penyelenggaraan_akan_datang' => 'date',
        'kos_penyelenggaraan' => 'decimal:2',
        'gambar_penyelenggaraan' => 'array',
        'id' => 'int',
    ];

    /**
     * Get the asset that owns the maintenance record.
     */
    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    /**
     * Get the user who created the maintenance record.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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
     * Scope upcoming maintenance records.
     */
    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('tarikh_penyelenggaraan_akan_datang', '>', now());
    }

    /**
     * Scope overdue maintenance records.
     */
    public function scopeOverdue(Builder $query): Builder
    {
        return $query->where('tarikh_penyelenggaraan_akan_datang', '<', now());
    }

    /**
     * Get formatted status attribute.
     */
    public function getFormattedStatusAttribute(): string
    {
        $statuses = [
            'belum_mula' => 'Belum Mula',
            'dalam_proses' => 'Dalam Proses',
            'selesai' => 'Selesai',
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
        return $this->status_penyelenggaraan === 'selesai';
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
