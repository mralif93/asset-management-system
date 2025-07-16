<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuditTrail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'user_name',
        'user_email',
        'user_role',
        'action',
        'model_type',
        'model_id',
        'model_name',
        'ip_address',
        'user_agent',
        'method',
        'url',
        'route_name',
        'old_values',
        'new_values',
        'description',
        'event_type',
        'status',
        'error_message',
        'additional_data'
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'additional_data' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the user that performed the action
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the auditable model instance
     */
    public function auditable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Scope to filter by action
     */
    public function scopeAction($query, $action)
    {
        return $query->where('action', $action);
    }

    /**
     * Scope to filter by model type
     */
    public function scopeForModel($query, $modelType)
    {
        return $query->where('model_type', $modelType);
    }

    /**
     * Scope to filter by user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope to filter by date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Scope to filter recent activities
     */
    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Get formatted action name
     */
    public function getFormattedActionAttribute()
    {
        return $this->formatAction();
    }

    /**
     * Format action name for display
     */
    public function formatAction()
    {
        $actions = [
            'create' => 'Dicipta',
            'update' => 'Dikemaskini', 
            'delete' => 'Dipadam',
            'view' => 'Dilihat',
            'login' => 'Log Masuk',
            'logout' => 'Log Keluar',
            'export' => 'Dieksport',
            'import' => 'Diimport',
            'approve' => 'Diluluskan',
            'reject' => 'Ditolak',
            'activate' => 'Diaktifkan',
            'deactivate' => 'Dinyahaktifkan',
            'profile_update' => 'Kemaskini Profil',
            'password_update' => 'Tukar Kata Laluan',
            'account_deletion' => 'Padam Akaun',
            // Add more action mappings as needed
            'CREATE' => 'Dicipta',
            'UPDATE' => 'Dikemaskini',
            'DELETE' => 'Dipadam',
            'VIEW' => 'Dilihat',
            'LOGIN' => 'Log Masuk',
            'LOGOUT' => 'Log Keluar',
            'EXPORT' => 'Dieksport',
            'IMPORT' => 'Diimport',
            'APPROVE' => 'Diluluskan',
            'REJECT' => 'Ditolak',
            'ACTIVATE' => 'Diaktifkan',
            'DEACTIVATE' => 'Dinyahaktifkan',
        ];

        return $actions[strtolower($this->action)] ?? $actions[$this->action] ?? ucfirst(str_replace('_', ' ', $this->action));
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'success' => 'green',
            'failed' => 'red',
            'warning' => 'yellow',
            default => 'gray'
        };
    }

    /**
     * Get changes summary
     */
    public function getChangesSummaryAttribute()
    {
        if (!$this->old_values || !$this->new_values) {
            return null;
        }

        $changes = [];
        foreach ($this->new_values as $key => $value) {
            $oldValue = $this->old_values[$key] ?? null;
            if ($oldValue != $value) {
                $changes[] = [
                    'field' => $key,
                    'old' => $oldValue,
                    'new' => $value
                ];
            }
        }

        return $changes;
    }

    /**
     * Get browser name from user agent
     */
    public function getBrowserAttribute()
    {
        return $this->getBrowserName();
    }

    /**
     * Get browser name from user agent
     */
    public function getBrowserName()
    {
        if (!$this->user_agent) {
            return 'Unknown';
        }

        $userAgent = $this->user_agent;
        
        if (strpos($userAgent, 'Chrome') !== false) {
            return 'Chrome';
        } elseif (strpos($userAgent, 'Firefox') !== false) {
            return 'Firefox';
        } elseif (strpos($userAgent, 'Safari') !== false) {
            return 'Safari';
        } elseif (strpos($userAgent, 'Edge') !== false) {
            return 'Edge';
        } elseif (strpos($userAgent, 'Opera') !== false) {
            return 'Opera';
        }

        return 'Unknown';
    }

    /**
     * Get platform from user agent
     */
    public function getPlatformAttribute()
    {
        return $this->getPlatformName();
    }

    /**
     * Get platform name from user agent
     */
    public function getPlatformName()
    {
        if (!$this->user_agent) {
            return 'Unknown';
        }

        $userAgent = $this->user_agent;
        
        if (strpos($userAgent, 'Windows') !== false) {
            return 'Windows';
        } elseif (strpos($userAgent, 'Mac') !== false) {
            return 'macOS';
        } elseif (strpos($userAgent, 'Linux') !== false) {
            return 'Linux';
        } elseif (strpos($userAgent, 'Android') !== false) {
            return 'Android';
        } elseif (strpos($userAgent, 'iOS') !== false) {
            return 'iOS';
        }

        return 'Unknown';
    }
}
