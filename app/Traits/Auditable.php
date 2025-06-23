<?php

namespace App\Traits;

use App\Services\AuditTrailService;
use Illuminate\Database\Eloquent\Model;

trait Auditable
{
    /**
     * Boot the Auditable trait for a model.
     */
    public static function bootAuditable()
    {
        // Log model creation
        static::created(function (Model $model) {
            try {
                AuditTrailService::logCreate($model);
            } catch (\Exception $e) {
                // Log the error but don't break the application
                logger()->error('Failed to log audit trail for model creation: ' . $e->getMessage());
            }
        });

        // Log model update - capture changes
        static::updated(function (Model $model) {
            try {
                // Get changes directly from the model
                $changes = $model->getChanges();
                if (!empty($changes)) {
                    // Build old values from original attributes
                    $oldValues = [];
                    foreach (array_keys($changes) as $key) {
                        $oldValues[$key] = $model->getOriginal($key);
                    }
                    AuditTrailService::logUpdate($model, $oldValues);
                }
            } catch (\Exception $e) {
                // Log the error but don't break the application
                logger()->error('Failed to log audit trail for model update: ' . $e->getMessage());
            }
        });

        // Log model deletion
        static::deleting(function (Model $model) {
            try {
                AuditTrailService::logDelete($model);
            } catch (\Exception $e) {
                // Log the error but don't break the application
                logger()->error('Failed to log audit trail for model deletion: ' . $e->getMessage());
            }
        });
    }

    /**
     * Log a custom audit event for this model
     */
    public function auditLog(string $action, string $description, array $additionalData = [])
    {
        try {
            return AuditTrailService::logCustom($action, $description, $this, $additionalData);
        } catch (\Exception $e) {
            logger()->error('Failed to log custom audit trail: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Log a view event for this model
     */
    public function auditView(?string $description = null)
    {
        try {
            return AuditTrailService::logView($this, $description);
        } catch (\Exception $e) {
            logger()->error('Failed to log audit view: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Log status change for this model
     */
    public function auditStatusChange(string $oldStatus, string $newStatus, ?string $description = null)
    {
        try {
            return AuditTrailService::logStatusChange($this, $oldStatus, $newStatus, $description);
        } catch (\Exception $e) {
            logger()->error('Failed to log audit status change: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Log approval/rejection for this model
     */
    public function auditApproval(bool $approved, ?string $reason = null)
    {
        try {
            return AuditTrailService::logApproval($this, $approved, $reason);
        } catch (\Exception $e) {
            logger()->error('Failed to log audit approval: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get audit trails for this model
     */
    public function auditTrails()
    {
        return $this->morphMany(\App\Models\AuditTrail::class, 'auditable', 'model_type', 'model_id');
    }

    /**
     * Get recent audit trails for this model
     */
    public function getRecentAuditTrails(int $limit = 10)
    {
        return \App\Models\AuditTrail::where('model_type', get_class($this))
            ->where('model_id', $this->getKey())
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Disable audit logging for the next operation
     */
    public function withoutAuditing(\Closure $callback)
    {
        // Temporarily remove event listeners
        $events = ['created', 'updating', 'updated', 'deleting'];
        $listeners = [];
        
        foreach ($events as $event) {
            $listeners[$event] = static::getEventDispatcher()->getListeners("eloquent.{$event}: " . static::class);
            static::getEventDispatcher()->forget("eloquent.{$event}: " . static::class);
        }

        try {
            return $callback();
        } finally {
            // Restore event listeners
            foreach ($listeners as $event => $eventListeners) {
                foreach ($eventListeners as $listener) {
                    static::getEventDispatcher()->listen("eloquent.{$event}: " . static::class, $listener);
                }
            }
        }
    }
} 