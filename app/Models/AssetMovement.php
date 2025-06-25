<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'user_id',
        'masjid_surau_asal_id',
        'masjid_surau_destinasi_id',
        'tarikh_permohonan',
        'jenis_pergerakan',
        'lokasi_asal',
        'lokasi_terperinci_asal',
        'lokasi_destinasi',
        'lokasi_terperinci_destinasi',
        'tarikh_pergerakan',
        'tarikh_jangka_pulangan',
        'nama_peminjam_pegawai_bertanggungjawab',
        'sebab_pergerakan',
        'catatan_pergerakan',
        'tarikh_jangka_pulang',
        'tarikh_pulang_sebenar',
        'status_pergerakan',
        'status_kelulusan_asal',
        'status_kelulusan_destinasi',
        'pegawai_meluluskan',
        'diluluskan_oleh',
        'diluluskan_oleh_asal',
        'diluluskan_oleh_destinasi',
        'tarikh_kelulusan',
        'tarikh_kelulusan_asal',
        'tarikh_kelulusan_destinasi',
        'sebab_penolakan',
        'tarikh_kepulangan',
        'catatan',
    ];

    protected $casts = [
        'tarikh_permohonan' => 'date',
        'tarikh_pergerakan' => 'date',
        'tarikh_jangka_pulangan' => 'date',
        'tarikh_jangka_pulang' => 'date',
        'tarikh_pulang_sebenar' => 'date',
        'tarikh_kelulusan' => 'datetime',
        'tarikh_kelulusan_asal' => 'datetime',
        'tarikh_kelulusan_destinasi' => 'datetime',
        'tarikh_kepulangan' => 'datetime',
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
        return $this->belongsTo(MasjidSurau::class, 'masjid_surau_asal_id');
    }

    /**
     * Get the destination masjid/surau.
     */
    public function masjidSurauDestinasi(): BelongsTo
    {
        return $this->belongsTo(MasjidSurau::class, 'masjid_surau_destinasi_id');
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
