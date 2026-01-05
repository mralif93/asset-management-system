<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetMovement extends Model
{
    use HasFactory, Auditable, SoftDeletes;

    protected $fillable = [
        'asset_id',
        'kuantiti',
        'user_id',
        'origin_masjid_surau_id',
        'destination_masjid_surau_id',
        'tarikh_permohonan',
        'jenis_pergerakan',
        'lokasi_asal_spesifik',
        'lokasi_destinasi_spesifik',
        'nama_peminjam_pegawai_bertanggungjawab',
        'tujuan_pergerakan',
        'tarikh_pergerakan',
        'tarikh_jangka_pulang',
        'tarikh_pulang_sebenar',
        'status_pergerakan',
        'pegawai_meluluskan',
        'catatan',
        'pembekal'
    ];

    protected $casts = [
        'tarikh_permohonan' => 'datetime',
        'tarikh_pergerakan' => 'datetime',
        'tarikh_jangka_pulang' => 'datetime',
        'tarikh_pulang_sebenar' => 'datetime',
        'kuantiti' => 'integer',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the asset that owns the movement.
     */
    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    /**
     * Get the user who created the movement.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user who approved/rejected the movement.
     */
    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diluluskan_oleh');
    }

    /**
     * Get the source masjid/surau.
     */
    public function masjidSurauAsal(): BelongsTo
    {
        return $this->belongsTo(MasjidSurau::class, 'origin_masjid_surau_id');
    }

    /**
     * Get the destination masjid/surau.
     */
    public function masjidSurauDestinasi(): BelongsTo
    {
        return $this->belongsTo(MasjidSurau::class, 'destination_masjid_surau_id');
    }

    /**
     * Get the user who approved from source location.
     */
    public function approvedByAsal(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diluluskan_oleh_asal');
    }

    /**
     * Get the user who approved from destination location.
     */
    public function approvedByDestinasi(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diluluskan_oleh_destinasi');
    }
}
