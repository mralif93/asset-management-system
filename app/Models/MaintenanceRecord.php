<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'tarikh_penyelenggaraan',
        'jenis_penyelenggaraan',
        'butiran_kerja',
        'nama_syarikat_kontraktor',
        'kos_penyelenggaraan',
        'status_penyelenggaraan',
        'pegawai_bertanggungjawab',
        'catatan',
    ];

    protected $casts = [
        'tarikh_penyelenggaraan' => 'date',
        'kos_penyelenggaraan' => 'decimal:2',
    ];

    /**
     * Get the asset that owns the maintenance record.
     */
    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }
}
