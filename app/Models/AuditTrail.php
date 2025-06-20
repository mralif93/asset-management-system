<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditTrail extends Model
{
    use HasFactory;

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
        'additional_data',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'additional_data' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
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
    public function auditable()
    {
        if ($this->model_type && $this->model_id) {
            return $this->model_type::find($this->model_id);
        }
        return null;
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
        $actions = [
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

        return $actions[$this->action] ?? $this->action;
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
