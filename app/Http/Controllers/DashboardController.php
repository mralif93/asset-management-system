<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetMovement;
use App\Models\Inspection;
use App\Models\MaintenanceRecord;
use App\Models\Disposal;
use App\Models\LossWriteoff;
use App\Models\ImmovableAsset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Base query filters based on user role
        $assetQuery = Asset::query();
        $movementQuery = AssetMovement::query();
        $inspectionQuery = Inspection::query();
        $maintenanceQuery = MaintenanceRecord::query();
        $disposalQuery = Disposal::query();
        $lossQuery = LossWriteoff::query();
        $immovableQuery = ImmovableAsset::query();
        
        // Filter by masjid/surau if user is not admin
        if ($user->role !== 'admin') {
            $masjidSurauId = $user->masjid_surau_id;
            
            $assetQuery->where('masjid_surau_id', $masjidSurauId);
            $movementQuery->whereHas('asset', fn($q) => $q->where('masjid_surau_id', $masjidSurauId));
            $inspectionQuery->whereHas('asset', fn($q) => $q->where('masjid_surau_id', $masjidSurauId));
            $maintenanceQuery->whereHas('asset', fn($q) => $q->where('masjid_surau_id', $masjidSurauId));
            $disposalQuery->whereHas('asset', fn($q) => $q->where('masjid_surau_id', $masjidSurauId));
            $lossQuery->whereHas('asset', fn($q) => $q->where('masjid_surau_id', $masjidSurauId));
            $immovableQuery->where('masjid_surau_id', $masjidSurauId);
        }

        // Asset Statistics
        $totalAssets = $assetQuery->count();
        $totalValue = $assetQuery->sum('nilai_perolehan');
        
        $assetsByType = $assetQuery->select('jenis_aset', DB::raw('count(*) as total'))
                                  ->groupBy('jenis_aset')
                                  ->get();
        
        $assetsByStatus = $assetQuery->select('status_aset', DB::raw('count(*) as total'))
                                    ->groupBy('status_aset')
                                    ->get();

        // Movement Statistics
        $pendingMovements = $movementQuery->where('status_permohonan', 'Menunggu Kelulusan')->count();
        $approvedMovements = $movementQuery->where('status_permohonan', 'Diluluskan')->count();
        $completedMovements = $movementQuery->where('status_permohonan', 'Selesai')->count();

        // Recent Activities
        $recentAssets = $assetQuery->with('masjidSurau')
                                  ->orderBy('created_at', 'desc')
                                  ->limit(5)
                                  ->get();

        $recentMovements = $movementQuery->with(['asset.masjidSurau'])
                                        ->orderBy('created_at', 'desc')
                                        ->limit(5)
                                        ->get();

        $recentInspections = $inspectionQuery->with(['asset.masjidSurau'])
                                           ->orderBy('tarikh_pemeriksaan', 'desc')
                                           ->limit(5)
                                           ->get();

        // Maintenance due soon (within 30 days)
        $upcomingMaintenance = $maintenanceQuery->with(['asset.masjidSurau'])
                                               ->where('tarikh_penyelenggaraan_akan_datang', '<=', now()->addDays(30))
                                               ->where('tarikh_penyelenggaraan_akan_datang', '>=', now())
                                               ->orderBy('tarikh_penyelenggaraan_akan_datang')
                                               ->limit(10)
                                               ->get();

        // Monthly trends (last 12 months)
        $monthlyData = collect();
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthStart = $date->copy()->startOfMonth();
            $monthEnd = $date->copy()->endOfMonth();
            
            $newAssets = $assetQuery->whereBetween('created_at', [$monthStart, $monthEnd])->count();
            $newMovements = $movementQuery->whereBetween('created_at', [$monthStart, $monthEnd])->count();
            $newInspections = $inspectionQuery->whereBetween('created_at', [$monthStart, $monthEnd])->count();
            
            $monthlyData->push([
                'month' => $date->format('M Y'),
                'assets' => $newAssets,
                'movements' => $newMovements,
                'inspections' => $newInspections,
            ]);
        }

        // Quick stats for cards
        $stats = [
            'total_assets' => $totalAssets,
            'total_value' => $totalValue,
            'pending_movements' => $pendingMovements,
            'immovable_assets' => $immovableQuery->count(),
            'assets_needing_inspection' => $assetQuery->whereDoesntHave('inspections', function($q) {
                $q->where('tarikh_pemeriksaan', '>=', now()->subYear());
            })->count(),
            'recent_disposals' => $disposalQuery->whereMonth('created_at', now()->month)->count(),
        ];

        return view('dashboard', compact(
            'stats',
            'assetsByType',
            'assetsByStatus',
            'recentAssets',
            'recentMovements',
            'recentInspections',
            'upcomingMaintenance',
            'monthlyData'
        ));
    }
}
