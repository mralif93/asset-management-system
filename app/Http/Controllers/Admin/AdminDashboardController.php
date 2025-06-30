<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AssetMovement;
use App\Models\Inspection;
use App\Models\MaintenanceRecord;
use App\Models\Disposal;
use App\Models\LossWriteoff;
use App\Models\ImmovableAsset;
use App\Models\MasjidSurau;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    // Middleware is handled in routes/web.php - no need for constructor middleware

    public function index()
    {
        // System-wide statistics for admin
        $stats = [
            'total_masjids' => MasjidSurau::count(),
            'total_users' => User::count(),
            'total_assets' => Asset::count(),
            'total_value' => Asset::sum('nilai_perolehan') ?: 0,
            'pending_movements' => AssetMovement::where('status_permohonan', 'Menunggu Kelulusan')->count(),
            'immovable_assets' => ImmovableAsset::count(),
            'assets_needing_inspection' => Asset::whereDoesntHave('inspections', function($q) {
                $q->where('tarikh_pemeriksaan', '>=', now()->subYear());
            })->count(),
            'recent_disposals' => Disposal::whereMonth('created_at', now()->month)->count(),
            'active_users' => User::where('email_verified_at', '!=', null)->count(),
            'admin_users' => User::where('role', 'admin')->count(),
        ];

        // Recent activities across all masjids
        $recentAssets = Asset::with(['masjidSurau', 'assetMovements'])
                            ->latest()
                            ->limit(5)
                            ->get();

        $recentUsers = User::with(['masjidSurau'])
                          ->latest()
                          ->limit(5)
                          ->get();

        $recentMovements = AssetMovement::with(['asset.masjidSurau', 'user', 'masjidSurauAsal', 'masjidSurauDestinasi'])
                                     ->latest()
                                     ->limit(5)
                                     ->get();

        // Top performing masjids by asset count
        $topMasjidsByAssets = MasjidSurau::withCount('assets')
                                        ->orderBy('assets_count', 'desc')
                                        ->limit(5)
                                        ->get();

        // Recent maintenance across all masjids
        $upcomingMaintenance = MaintenanceRecord::with(['asset.masjidSurau'])
                                               ->where('tarikh_penyelenggaraan_akan_datang', '<=', now()->addDays(30))
                                               ->where('tarikh_penyelenggaraan_akan_datang', '>=', now())
                                               ->orderBy('tarikh_penyelenggaraan_akan_datang')
                                               ->limit(10)
                                               ->get();

        // System health metrics
        $systemHealth = [
            'assets_with_images' => Asset::whereNotNull('gambar_aset')->count(),
            'assets_without_images' => Asset::whereNull('gambar_aset')->count(),
            'movements_this_month' => AssetMovement::whereMonth('created_at', now()->month)->count(),
            'inspections_this_month' => Inspection::whereMonth('created_at', now()->month)->count(),
            'maintenance_this_month' => MaintenanceRecord::whereMonth('created_at', now()->month)->count(),
        ];

        // Extract individual variables for the view
        $totalMasjids = $stats['total_masjids'];
        $totalUsers = $stats['total_users'];
        $totalAssets = $stats['total_assets'];
        $totalValue = $stats['total_value'];
        $adminCount = $stats['admin_users'];
        $userCount = $stats['total_users'] - $stats['admin_users'];

        return view('admin.dashboard', compact(
            'stats',
            'totalMasjids',
            'totalUsers',
            'totalAssets',
            'totalValue',
            'adminCount',
            'userCount',
            'recentAssets',
            'recentUsers',
            'recentMovements',
            'topMasjidsByAssets',
            'upcomingMaintenance',
            'systemHealth'
        ));
    }

    /**
     * System overview for admins
     */
    public function systemOverview(Request $request)
    {
        $query = MasjidSurau::with(['assets', 'users'])
                           ->withCount(['assets', 'users']);
        
        // Add search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('alamat_baris_1', 'like', "%{$search}%")
                  ->orWhere('bandar', 'like', "%{$search}%")
                  ->orWhere('negeri', 'like', "%{$search}%");
            });
        }
        
        // Add filter by type
        if ($request->filled('type')) {
            $query->where('jenis', $request->get('type'));
        }
        
        // Get per page value with default of 10
        $perPage = $request->get('per_page', 10);
        
        // Get the paginated results
        $masjids = $query->paginate($perPage)->withQueryString();
        
        // Calculate system stats
        $systemStats = [
            'total_assets' => Asset::count(),
            'total_value' => Asset::sum('nilai_perolehan') ?: 0,
            'active_users' => User::whereNotNull('email_verified_at')->count(),
            'pending_approvals' => AssetMovement::where('status_permohonan', 'Menunggu Kelulusan')->count(),
            'total_masjids' => MasjidSurau::count(),
            'total_users' => User::count(),
            'admin_users' => User::where('role', 'admin')->count(),
            'regular_users' => User::where('role', 'user')->count(),
            'assets_this_month' => Asset::whereMonth('created_at', now()->month)->count(),
            'movements_this_month' => AssetMovement::whereMonth('created_at', now()->month)->count(),
            'inspections_this_month' => Inspection::whereMonth('created_at', now()->month)->count(),
            'maintenance_this_month' => MaintenanceRecord::whereMonth('created_at', now()->month)->count(),
        ];

        $overview = [
            'masjids' => $masjids,
            'system_stats' => $systemStats
        ];

        return view('admin.system-overview', compact('overview'));
    }


}
