<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Auditable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'masjid_surau_id',
        'phone',
        'position',
        'profile_picture',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the masjid/surau that owns the user.
     */
    public function masjidSurau(): BelongsTo
    {
        return $this->belongsTo(MasjidSurau::class, 'masjid_surau_id', 'id');
    }

    /**
     * Get all assets from the user's masjid/surau.
     */
    public function assets(): HasManyThrough
    {
        return $this->hasManyThrough(Asset::class, MasjidSurau::class, 'id', 'masjid_surau_id', 'masjid_surau_id', 'id');
    }

    /**
     * Get the user's asset movements.
     */
    public function assetMovements(): HasMany
    {
        return $this->hasMany(AssetMovement::class, 'user_id');
    }

    /**
     * Get the user's inspections.
     */
    public function inspections(): HasMany
    {
        return $this->hasMany(Inspection::class, 'user_id');
    }

    /**
     * Get the user's maintenance records.
     */
    public function maintenanceRecords(): HasMany
    {
        return $this->hasMany(MaintenanceRecord::class, 'user_id');
    }

    /**
     * Get the user's disposal requests.
     */
    public function disposals(): HasMany
    {
        return $this->hasMany(Disposal::class, 'user_id');
    }

    /**
     * Get the user's loss/writeoff reports.
     */
    public function lossWriteoffs(): HasMany
    {
        return $this->hasMany(LossWriteoff::class, 'user_id');
    }

    /**
     * Get the user's audit trails.
     */
    public function auditTrails(): HasMany
    {
        return $this->hasMany(AuditTrail::class, 'user_id');
    }

    /**
     * Get the profile picture URL.
     */
    public function getProfilePictureUrlAttribute(): string
    {
        if ($this->profile_picture) {
            return asset('storage/' . $this->profile_picture);
        }
        
        // Return default avatar based on user's initials
        $initials = collect(explode(' ', $this->name))
            ->take(2)
            ->map(fn($word) => strtoupper(substr($word, 0, 1)))
            ->join('');
        
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=059669&background=d1fae5&size=200';
    }

    /**
     * Get user's initials.
     */
    public function getInitialsAttribute(): string
    {
        return collect(explode(' ', $this->name))
            ->take(2)
            ->map(fn($word) => strtoupper(substr($word, 0, 1)))
            ->join('');
    }
}
