<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImmovableAsset extends Model
{
    use HasFactory;

    protected $fillable = [
        'masjid_surau_id',
        'nama_aset',
        'jenis_aset',
        'alamat',
        'no_hakmilik',
        'no_lot',
        'luas_tanah_bangunan',
        'tarikh_perolehan',
        'sumber_perolehan',
        'kos_perolehan',
        'keadaan_semasa',
        'gambar_aset',
        'catatan',
    ];

    protected $casts = [
        'tarikh_perolehan' => 'date',
        'luas_tanah_bangunan' => 'decimal:2',
        'kos_perolehan' => 'decimal:2',
        'gambar_aset' => 'array',
    ];

    /**
     * Get the masjid/surau that owns the immovable asset.
     */
    public function masjidSurau(): BelongsTo
    {
        return $this->belongsTo(MasjidSurau::class);
    }
}
