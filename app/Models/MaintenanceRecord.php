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
}
