<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MasjidSurau extends Model
{
    use HasFactory;

    protected $table = 'masjids_suraus';

    protected $fillable = [
        'nama',
        'singkatan_nama',
        'alamat',
        'daerah',
        'no_telefon',
        'email',
        'status',
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
