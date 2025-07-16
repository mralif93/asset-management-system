<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasjidSurau extends Model
{
    use HasFactory, Auditable, SoftDeletes;

    protected $table = 'masjid_surau';

    protected $fillable = [
        'id',
        'nama',
        'singkatan_nama',
        'jenis',
        'kategori',
        'alamat_baris_1',
        'alamat_baris_2',
        'alamat_baris_3',
        'poskod',
        'bandar',
        'negeri',
        'negara',
        'daerah',
        'no_telefon',
        'email',
        'imam_ketua',
        'bilangan_jemaah',
        'tahun_dibina',
        'status',
        'catatan',
        'nama_rasmi',
        'kawasan',
        'pautan_peta',
    ];

    protected $casts = [
        'tahun_dibina' => 'integer',
        'bilangan_jemaah' => 'integer',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the users for the masjid/surau.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the assets for the masjid/surau.
     */
    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class);
    }

    /**
     * Get the immovable assets for the masjid/surau.
     */
    public function immovableAssets(): HasMany
    {
        return $this->hasMany(ImmovableAsset::class);
    }
}
