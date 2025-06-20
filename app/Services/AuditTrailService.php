<?php

namespace App\Services;

use App\Models\AuditTrail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuditTrailService
{
    /**
     * Log an audit trail entry
     */
    public static function log(array $data): AuditTrail
    {
        $request = request();
        $user = Auth::user();

        $auditData = array_merge([
            'user_id' => $user?->id,
            'user_name' => $user?->name,
            'user_email' => $user?->email,
            'user_role' => $user?->role,
            'ip_address' => $request?->ip(),
            'user_agent' => $request?->userAgent(),
            'method' => $request?->method(),
            'url' => $request?->fullUrl(),
            'route_name' => $request?->route()?->getName(),
            'event_type' => app()->runningInConsole() ? 'console' : 'web',
            'status' => 'success',
        ], $data);

        return AuditTrail::create($auditData);
    }

    /**
     * Log model creation
     */
    public static function logCreate(Model $model, string $description = null): AuditTrail
    {
        return self::log([
            'action' => 'CREATE',
            'model_type' => get_class($model),
            'model_id' => $model->getKey(),
            'model_name' => self::getModelName($model),
            'new_values' => $model->getAttributes(),
            'description' => $description ?? 'Rekod baharu dicipta: ' . self::getModelName($model),
        ]);
    }

    /**
     * Log model update
     */
    public static function logUpdate(Model $model, array $oldValues, string $description = null): AuditTrail
    {
        $changes = [];
        foreach ($model->getDirty() as $key => $value) {
            if (isset($oldValues[$key])) {
                $changes[$key] = [
                    'old' => $oldValues[$key],
                    'new' => $value
                ];
            }
        }

        return self::log([
            'action' => 'UPDATE',
            'model_type' => get_class($model),
            'model_id' => $model->getKey(),
            'model_name' => self::getModelName($model),
            'old_values' => $oldValues,
            'new_values' => $model->getAttributes(),
            'description' => $description ?? 'Rekod dikemaskini: ' . self::getModelName($model),
            'additional_data' => ['changes' => $changes]
        ]);
    }

    /**
     * Log model deletion
     */
    public static function logDelete(Model $model, string $description = null): AuditTrail
    {
        return self::log([
            'action' => 'DELETE',
            'model_type' => get_class($model),
            'model_id' => $model->getKey(),
            'model_name' => self::getModelName($model),
            'old_values' => $model->getAttributes(),
            'description' => $description ?? 'Rekod dipadam: ' . self::getModelName($model),
        ]);
    }

    /**
     * Log model view/access
     */
    public static function logView(Model $model, string $description = null): AuditTrail
    {
        return self::log([
            'action' => 'VIEW',
            'model_type' => get_class($model),
            'model_id' => $model->getKey(),
            'model_name' => self::getModelName($model),
            'description' => $description ?? 'Rekod dilihat: ' . self::getModelName($model),
        ]);
    }

    /**
     * Log user login
     */
    public static function logLogin($user, bool $successful = true): AuditTrail
    {
        return self::log([
            'action' => 'LOGIN',
            'user_id' => $successful ? $user?->id : null,
            'user_name' => $user?->name,
            'user_email' => $user?->email,
            'user_role' => $user?->role,
            'status' => $successful ? 'success' : 'failed',
            'description' => $successful 
                ? 'Pengguna berjaya log masuk: ' . ($user?->name ?? 'Unknown')
                : 'Cubaan log masuk gagal untuk: ' . ($user?->email ?? 'Unknown'),
        ]);
    }

    /**
     * Log user logout
     */
    public static function logLogout($user): AuditTrail
    {
        return self::log([
            'action' => 'LOGOUT',
            'description' => 'Pengguna log keluar: ' . ($user?->name ?? 'Unknown'),
        ]);
    }

    /**
     * Log export action
     */
    public static function logExport(string $exportType, array $filters = [], string $description = null): AuditTrail
    {
        return self::log([
            'action' => 'EXPORT',
            'description' => $description ?? 'Data dieksport: ' . $exportType,
            'additional_data' => [
                'export_type' => $exportType,
                'filters' => $filters,
                'exported_at' => now()->toISOString()
            ]
        ]);
    }

    /**
     * Log import action
     */
    public static function logImport(string $importType, int $recordCount, string $description = null): AuditTrail
    {
        return self::log([
            'action' => 'IMPORT',
            'description' => $description ?? "Data diimport: {$importType} ({$recordCount} rekod)",
            'additional_data' => [
                'import_type' => $importType,
                'record_count' => $recordCount,
                'imported_at' => now()->toISOString()
            ]
        ]);
    }

    /**
     * Log approval action
     */
    public static function logApproval(Model $model, bool $approved, string $reason = null): AuditTrail
    {
        $action = $approved ? 'APPROVE' : 'REJECT';
        $status = $approved ? 'Diluluskan' : 'Ditolak';
        
        return self::log([
            'action' => $action,
            'model_type' => get_class($model),
            'model_id' => $model->getKey(),
            'model_name' => self::getModelName($model),
            'description' => "{$status}: " . self::getModelName($model) . ($reason ? " - {$reason}" : ''),
            'additional_data' => [
                'approved' => $approved,
                'reason' => $reason
            ]
        ]);
    }

    /**
     * Log status change
     */
    public static function logStatusChange(Model $model, string $oldStatus, string $newStatus, string $description = null): AuditTrail
    {
        $action = $newStatus === 'active' || $newStatus === 'Aktif' ? 'ACTIVATE' : 'DEACTIVATE';
        
        return self::log([
            'action' => $action,
            'model_type' => get_class($model),
            'model_id' => $model->getKey(),
            'model_name' => self::getModelName($model),
            'description' => $description ?? "Status bertukar dari {$oldStatus} kepada {$newStatus}: " . self::getModelName($model),
            'additional_data' => [
                'old_status' => $oldStatus,
                'new_status' => $newStatus
            ]
        ]);
    }

    /**
     * Log custom action
     */
    public static function logCustom(
        string $action, 
        string $description, 
        Model $model = null, 
        array $additionalData = [],
        string $status = 'success'
    ): AuditTrail {
        $data = [
            'action' => strtoupper($action),
            'description' => $description,
            'status' => $status,
        ];

        if ($model) {
            $data['model_type'] = get_class($model);
            $data['model_id'] = $model->getKey();
            $data['model_name'] = self::getModelName($model);
        }

        if (!empty($additionalData)) {
            $data['additional_data'] = $additionalData;
        }

        return self::log($data);
    }

    /**
     * Log failed action
     */
    public static function logFailure(string $action, string $error, Model $model = null): AuditTrail
    {
        $data = [
            'action' => strtoupper($action),
            'status' => 'failed',
            'error_message' => $error,
            'description' => "Kegagalan {$action}: {$error}",
        ];

        if ($model) {
            $data['model_type'] = get_class($model);
            $data['model_id'] = $model->getKey();
            $data['model_name'] = self::getModelName($model);
        }

        return self::log($data);
    }

    /**
     * Get readable model name
     */
    private static function getModelName(Model $model): string
    {
        $className = class_basename($model);
        
        // Try to get a name/title field
        $nameFields = ['nama', 'name', 'title', 'nama_aset', 'singkatan_nama'];
        foreach ($nameFields as $field) {
            if (isset($model->$field) && !empty($model->$field)) {
                return $model->$field;
            }
        }

        // Fallback to model class and ID
        return "{$className} #{$model->getKey()}";
    }

    /**
     * Clean up old audit trails
     */
    public static function cleanup(int $daysToKeep = 90): int
    {
        $cutoffDate = now()->subDays($daysToKeep);
        return AuditTrail::where('created_at', '<', $cutoffDate)->delete();
    }

    /**
     * Get recent activities for a user
     */
    public static function getRecentActivities(int $userId, int $limit = 10): \Illuminate\Database\Eloquent\Collection
    {
        return AuditTrail::where('user_id', $userId)
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Get system statistics
     */
    public static function getSystemStats(): array
    {
        $today = now()->startOfDay();
        $thisWeek = now()->startOfWeek();
        $thisMonth = now()->startOfMonth();

        return [
            'total_activities' => AuditTrail::count(),
            'today_activities' => AuditTrail::where('created_at', '>=', $today)->count(),
            'week_activities' => AuditTrail::where('created_at', '>=', $thisWeek)->count(),
            'month_activities' => AuditTrail::where('created_at', '>=', $thisMonth)->count(),
            'failed_activities' => AuditTrail::where('status', 'failed')->count(),
            'unique_users' => AuditTrail::whereNotNull('user_id')->distinct('user_id')->count(),
        ];
    }
} 