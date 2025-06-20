<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AssetMovement;
use App\Models\Disposal;
use App\Models\ImmovableAsset;
use App\Models\Inspection;
use App\Models\LossWriteoff;
use App\Models\MaintenanceRecord;
use App\Models\MasjidSurau;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display a listing of available reports.
     */
    public function index()
    {
        // Admin can see system-wide statistics
        $totalAssets = Asset::count();
        $totalValue = Asset::sum('nilai_perolehan');
        $totalInspections = Inspection::count();
        $totalMaintenance = MaintenanceRecord::count();
        $pendingApprovals = AssetMovement::where('status_pergerakan', 'menunggu_kelulusan')->count() +
                           Disposal::where('status_kelulusan', 'menunggu')->count() +
                           LossWriteoff::where('status_kelulusan', 'menunggu')->count();
        
        // Asset status counts
        $statusCounts = [
            'aktif' => Asset::where('status_aset', 'aktif')->count(),
            'maintenance' => Asset::where('status_aset', 'dalam_penyelenggaraan')->count(),
            'rosak' => Asset::where('status_aset', 'rosak')->count(),
        ];
        
        // Asset types
        $assetTypes = Asset::select('jenis_aset', DB::raw('count(*) as count'))
                          ->groupBy('jenis_aset')
                          ->pluck('count', 'jenis_aset')
                          ->toArray();
        
        // Recent activities (sample data - you can customize this based on your needs)
        $recentActivities = [
            [
                'icon' => 'bx-box',
                'description' => 'Aset baharu didaftarkan',
                'time' => '2 jam yang lalu'
            ],
            [
                'icon' => 'bx-wrench',
                'description' => 'Penyelenggaraan dijadualkan',
                'time' => '4 jam yang lalu'
            ],
            [
                'icon' => 'bx-check-circle',
                'description' => 'Pemeriksaan selesai',
                'time' => '6 jam yang lalu'
            ]
        ];
        
        return view('admin.reports.index', compact(
            'totalAssets', 
            'totalValue',
            'totalInspections', 
            'totalMaintenance', 
            'pendingApprovals',
            'statusCounts',
            'assetTypes',
            'recentActivities'
        ));
    }

    /**
     * Generate assets by location report
     */
    public function assetsByLocation(Request $request, $lokasi = null)
    {
        // Get lokasi from route parameter or request parameter
        $lokasi = $lokasi ?? $request->get('lokasi', '');
        
        $query = Asset::with('masjidSurau');
        
        // Only filter by location if lokasi is provided and not empty
        if (!empty($lokasi)) {
            $query->where('lokasi_penempatan', 'like', '%' . $lokasi . '%');
        }
        
        $assets = $query->get();
        
        return view('admin.reports.assets-by-location', compact('assets', 'lokasi'));
    }

    /**
     * Generate disposal report
     */
    public function disposalReport($id)
    {
        $disposal = Disposal::with(['asset', 'asset.masjidSurau'])->findOrFail($id);
        
        return view('admin.reports.disposal', compact('disposal'));
    }

    /**
     * Generate annual summary report
     */
    public function annualSummary($year = null)
    {
        $year = $year ?? now()->year;
        
        $summary = [
            'total_assets' => Asset::whereYear('tarikh_perolehan', $year)->count(),
            'total_acquisitions_value' => Asset::whereYear('tarikh_perolehan', $year)->sum('nilai_perolehan'),
            'total_disposals' => Disposal::whereYear('tarikh_pelupusan', $year)->count(),
            'total_disposals_value' => Disposal::whereYear('tarikh_pelupusan', $year)->sum('nilai_pelupusan'),
            'total_maintenance_cost' => MaintenanceRecord::whereYear('tarikh_penyelenggaraan', $year)->sum('kos_penyelenggaraan'),
            'inspections_conducted' => Inspection::whereYear('tarikh_pemeriksaan', $year)->count(),
        ];
        
        return view('admin.reports.annual-summary', compact('summary', 'year'));
    }

    /**
     * Generate asset movements summary report
     */
    public function movementsSummary()
    {
        $movements = AssetMovement::with(['asset', 'asset.masjidSurau'])
                                ->where('status_pergerakan', 'diluluskan')
                                ->latest()
                                ->get();
        
        return view('admin.reports.movements-summary', compact('movements'));
    }

    /**
     * Generate inspection schedule report
     */
    public function inspectionSchedule()
    {
        $upcomingInspections = Inspection::with(['asset', 'asset.masjidSurau'])
                                       ->whereNotNull('tarikh_pemeriksaan_akan_datang')
                                       ->where('tarikh_pemeriksaan_akan_datang', '>=', now())
                                       ->orderBy('tarikh_pemeriksaan_akan_datang')
                                       ->get();
        
        return view('admin.reports.inspection-schedule', compact('upcomingInspections'));
    }

    /**
     * Generate maintenance schedule report
     */
    public function maintenanceSchedule()
    {
        $upcomingMaintenance = MaintenanceRecord::with(['asset', 'asset.masjidSurau'])
                                               ->whereNotNull('tarikh_penyelenggaraan_akan_datang')
                                               ->where('tarikh_penyelenggaraan_akan_datang', '>=', now())
                                               ->orderBy('tarikh_penyelenggaraan_akan_datang')
                                               ->get();
        
        return view('admin.reports.maintenance-schedule', compact('upcomingMaintenance'));
    }

    /**
     * Generate asset value depreciation report
     */
    public function assetDepreciation()
    {
        $assets = Asset::with('masjidSurau')
                      ->whereNotNull('susut_nilai_tahunan')
                      ->where('susut_nilai_tahunan', '>', 0)
                      ->get()
                      ->map(function ($asset) {
                          $yearsElapsed = now()->diffInYears($asset->tarikh_perolehan);
                          $totalDepreciation = $asset->susut_nilai_tahunan * $yearsElapsed;
                          $currentValue = max(0, $asset->nilai_perolehan - $totalDepreciation);
                          
                          $asset->years_elapsed = $yearsElapsed;
                          $asset->total_depreciation = $totalDepreciation;
                          $asset->current_value = $currentValue;
                          
                          return $asset;
                      });
        
        return view('admin.reports.asset-depreciation', compact('assets'));
    }
}
