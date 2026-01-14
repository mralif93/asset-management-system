<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditTrail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AuditTrailController extends Controller
{
    /**
     * Display a listing of audit trails
     */
    public function index(Request $request)
    {
        $query = AuditTrail::with('user')->latest();

        // Apply filters
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('model_type')) {
            $query->where('model_type', $request->model_type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('ip_address')) {
            $query->where('ip_address', 'like', '%' . $request->ip_address . '%');
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', '%' . $search . '%')
                    ->orWhere('user_name', 'like', '%' . $search . '%')
                    ->orWhere('user_email', 'like', '%' . $search . '%')
                    ->orWhere('model_name', 'like', '%' . $search . '%')
                    ->orWhere('url', 'like', '%' . $search . '%');
            });
        }

        $auditTrails = $query->paginate(20)->withQueryString();

        // Get filter options
        $users = User::select('id', 'name', 'email')->orderBy('name')->get();
        $actions = AuditTrail::distinct()->pluck('action')->filter()->sort()->values();
        $modelTypes = AuditTrail::distinct()->pluck('model_type')->filter()->sort()->values();
        $statuses = AuditTrail::distinct()->pluck('status')->filter()->sort()->values();

        // Get statistics
        $stats = $this->getStatistics();

        return view('admin.audit-trails.index', compact(
            'auditTrails',
            'users',
            'actions',
            'modelTypes',
            'statuses',
            'stats'
        ));
    }

    /**
     * Display the specified audit trail
     */
    public function show(AuditTrail $auditTrail)
    {
        $auditTrail->load('user');

        // Get related audit trails for the same model
        $relatedTrails = collect();
        if ($auditTrail->model_type && $auditTrail->model_id) {
            $relatedTrails = AuditTrail::where('model_type', $auditTrail->model_type)
                ->where('model_id', $auditTrail->model_id)
                ->where('id', '!=', $auditTrail->id)
                ->with('user')
                ->latest()
                ->limit(10)
                ->get();
        }

        return view('admin.audit-trails.show', compact('auditTrail', 'relatedTrails'));
    }

    /**
     * Export audit trails to CSV
     */
    /**
     * Export audit trails to Excel
     */
    public function export(Request $request)
    {
        $filename = 'audit_trails_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\AuditTrailExport($request), $filename);
    }

    /**
     * Delete old audit trails
     */
    public function cleanup(Request $request)
    {
        $request->validate([
            'days' => 'required|integer|min:1|max:365'
        ]);

        $days = $request->days;
        $cutoffDate = now()->subDays($days);

        $deletedCount = AuditTrail::where('created_at', '<', $cutoffDate)->delete();

        return redirect()->route('admin.audit-trails.index')
            ->with('success', "Sebanyak {$deletedCount} rekod audit telah dipadam (lebih lama dari {$days} hari).");
    }

    /**
     * Get audit trail statistics
     */
    private function getStatistics()
    {
        $today = now()->startOfDay();
        $yesterday = now()->subDay()->startOfDay();
        $thisWeek = now()->startOfWeek();
        $thisMonth = now()->startOfMonth();

        return [
            'total_trails' => AuditTrail::count(),
            'today_count' => AuditTrail::where('created_at', '>=', $today)->count(),
            'yesterday_count' => AuditTrail::whereBetween('created_at', [$yesterday, $today])->count(),
            'week_count' => AuditTrail::where('created_at', '>=', $thisWeek)->count(),
            'month_count' => AuditTrail::where('created_at', '>=', $thisMonth)->count(),
            'failed_count' => AuditTrail::where('status', 'failed')->count(),
            'unique_users' => AuditTrail::whereNotNull('user_id')->distinct('user_id')->count(),
            'unique_ips' => AuditTrail::whereNotNull('ip_address')->distinct('ip_address')->count(),
            'top_actions' => AuditTrail::selectRaw('action, COUNT(*) as count')
                ->groupBy('action')
                ->orderByDesc('count')
                ->limit(5)
                ->get(),
            'recent_activities' => AuditTrail::with('user')
                ->latest()
                ->limit(10)
                ->get()
        ];
    }

    /**
     * Get user activity summary
     */
    public function userActivity(Request $request)
    {
        $userId = $request->user_id;
        $days = $request->days ?? 30;

        if (!$userId) {
            return response()->json(['error' => 'User ID is required'], 400);
        }

        $user = User::find($userId);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $startDate = now()->subDays($days);

        $activities = AuditTrail::where('user_id', $userId)
            ->where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, action, COUNT(*) as count')
            ->groupBy('date', 'action')
            ->orderBy('date', 'desc')
            ->get()
            ->groupBy('date');

        $summary = [
            'user' => $user,
            'total_actions' => AuditTrail::where('user_id', $userId)
                ->where('created_at', '>=', $startDate)
                ->count(),
            'actions_by_type' => AuditTrail::where('user_id', $userId)
                ->where('created_at', '>=', $startDate)
                ->selectRaw('action, COUNT(*) as count')
                ->groupBy('action')
                ->get(),
            'daily_activities' => $activities
        ];

        return response()->json($summary);
    }
}
