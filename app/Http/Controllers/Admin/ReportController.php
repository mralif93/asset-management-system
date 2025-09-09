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

    /**
     * Display BR-AMS forms list (official Selangor state forms)
     */
    public function brAmsForms()
    {
        $brAmsForms = [
            [
                'code' => 'BR-AMS 001',
                'title' => 'Senarai Daftar Harta Modal',
                'description' => 'List of Capital Asset Register',
                'category' => 'Registration',
                'icon' => 'bx-list-ul',
                'color' => 'blue',
                'route' => 'admin.reports.br-ams-001',
                'available' => true
            ],
            [
                'code' => 'BR-AMS 002',
                'title' => 'Senarai Daftar Inventori',
                'description' => 'List of Inventory Register',
                'category' => 'Registration',
                'icon' => 'bx-package',
                'color' => 'blue',
                'route' => 'admin.reports.br-ams-002',
                'available' => true
            ],
            [
                'code' => 'BR-AMS 003',
                'title' => 'Senarai Aset Alih di Lokasi',
                'description' => 'List of Movable Assets at Location',
                'category' => 'Location',
                'icon' => 'bx-map',
                'color' => 'green',
                'route' => 'admin.reports.br-ams-003',
                'available' => true
            ],
            [
                'code' => 'BR-AMS 004',
                'title' => 'Borang Permohonan Pergerakan/ Pinjaman Aset Alih',
                'description' => 'Movable Asset Movement/Loan Application Form',
                'category' => 'Movement',
                'icon' => 'bx-transfer',
                'color' => 'purple',
                'route' => 'admin.reports.br-ams-004',
                'available' => true
            ],
            [
                'code' => 'BR-AMS 005',
                'title' => 'Borang Pemeriksaan Aset Alih',
                'description' => 'Movable Asset Inspection Form',
                'category' => 'Inspection',
                'icon' => 'bx-search',
                'color' => 'orange',
                'route' => 'admin.reports.br-ams-005',
                'available' => true
            ],
            [
                'code' => 'BR-AMS 006',
                'title' => 'Rekod Penyelenggaraan Aset Alih',
                'description' => 'Movable Asset Maintenance Record',
                'category' => 'Maintenance',
                'icon' => 'bx-wrench',
                'color' => 'amber',
                'route' => 'admin.reports.br-ams-006',
                'available' => true
            ],
            [
                'code' => 'BR-AMS 007',
                'title' => 'Rekod Pelupusan Aset Alih',
                'description' => 'Record of Disposal of Movable Assets',
                'category' => 'Disposal',
                'icon' => 'bx-trash',
                'color' => 'red',
                'route' => 'admin.reports.br-ams-007',
                'available' => true
            ],
            [
                'code' => 'BR-AMS 008',
                'title' => 'Laporan Tindakan Pelupusan Aset Alih',
                'description' => 'Asset Disposal Action Report',
                'category' => 'Disposal',
                'icon' => 'bx-file-blank',
                'color' => 'red',
                'route' => 'admin.reports.br-ams-008',
                'available' => true
            ],
            [
                'code' => 'BR-AMS 009',
                'title' => 'Laporan Kehilangan / Hapus Kira Aset Alih',
                'description' => 'Report of Loss / Write-off of Movable Assets',
                'category' => 'Loss',
                'icon' => 'bx-x-circle',
                'color' => 'red',
                'route' => 'admin.reports.br-ams-009',
                'available' => true
            ],
            [
                'code' => 'BR-AMS 010',
                'title' => 'Laporan Tahunan Pengurusan Aset Alih',
                'description' => 'Annual Report on Movable Asset Management',
                'category' => 'Annual',
                'icon' => 'bx-calendar',
                'color' => 'emerald',
                'route' => 'admin.reports.br-ams-010',
                'available' => true
            ],
            [
                'code' => 'BR-AMS 011',
                'title' => 'Senarai Rekod Aset Tak Alih',
                'description' => 'List of Immovable Asset Records',
                'category' => 'Immovable',
                'icon' => 'bx-building',
                'color' => 'blue',
                'route' => 'admin.reports.br-ams-011',
                'available' => true
            ]
        ];

        // Group forms by category
        $formsByCategory = collect($brAmsForms)->groupBy('category');

        return view('admin.reports.br-ams-forms', compact('brAmsForms', 'formsByCategory'));
    }

    /**
     * Generate BR-AMS 001: Senarai Daftar Harta Modal (Capital Asset Register List)
     */
    public function brAms001(Request $request)
    {
        // Get filter parameters
        $masjidSurauId = $request->get('masjid_surau_id');
        $daerah = $request->get('daerah');
        
        // Build query
        $query = Asset::with('masjidSurau');
        
        if ($masjidSurauId) {
            $query->where('masjid_surau_id', $masjidSurauId);
        }
        
        if ($daerah) {
            $query->whereHas('masjidSurau', function($q) use ($daerah) {
                $q->where('daerah', 'like', '%' . $daerah . '%');
            });
        }
        
        $assets = $query->orderBy('created_at', 'desc')->get();
        
        // Get all masjid/surau for filter dropdown
        $masjidSurauList = MasjidSurau::orderBy('nama')->get();
        
        // Calculate totals
        $totalValue = $assets->sum('nilai_perolehan');
        
        // Get unique daerah for filter
        $daerahList = MasjidSurau::select('daerah')->distinct()->orderBy('daerah')->pluck('daerah');
        
        return view('admin.reports.br-ams-001', compact(
            'assets', 
            'masjidSurauList', 
            'daerahList', 
            'totalValue',
            'masjidSurauId',
            'daerah'
        ));
    }

    /**
     * Generate BR-AMS 002: Senarai Daftar Inventori (Inventory Register List)
     */
    public function brAms002(Request $request)
    {
        // Get filter parameters
        $masjidSurauId = $request->get('masjid_surau_id');
        $daerah = $request->get('daerah');
        
        // Build query - for inventory, we might want to filter by specific asset types
        $query = Asset::with('masjidSurau');
        
        if ($masjidSurauId) {
            $query->where('masjid_surau_id', $masjidSurauId);
        }
        
        if ($daerah) {
            $query->whereHas('masjidSurau', function($q) use ($daerah) {
                $q->where('daerah', 'like', '%' . $daerah . '%');
            });
        }
        
        $assets = $query->orderBy('created_at', 'desc')->get();
        
        // Get all masjid/surau for filter dropdown
        $masjidSurauList = MasjidSurau::orderBy('nama')->get();
        
        // Calculate totals
        $totalValue = $assets->sum('nilai_perolehan');
        
        // Get unique daerah for filter
        $daerahList = MasjidSurau::select('daerah')->distinct()->orderBy('daerah')->pluck('daerah');
        
        return view('admin.reports.br-ams-002', compact(
            'assets', 
            'masjidSurauList', 
            'daerahList', 
            'totalValue',
            'masjidSurauId',
            'daerah'
        ));
    }

    /**
     * Generate BR-AMS 003: Senarai Aset Alih di Lokasi (List of Movable Assets at Location)
     */
    public function brAms003(Request $request)
    {
        // Get filter parameters
        $masjidSurauId = $request->get('masjid_surau_id');
        $lokasi = $request->get('lokasi');
        
        // Build query
        $query = Asset::with('masjidSurau');
        
        if ($masjidSurauId) {
            $query->where('masjid_surau_id', $masjidSurauId);
        }
        
        if ($lokasi) {
            $query->where('lokasi_penempatan', 'like', '%' . $lokasi . '%');
        }
        
        $assets = $query->orderBy('lokasi_penempatan')->orderBy('nama_aset')->get();
        
        // Get all masjid/surau for filter dropdown
        $masjidSurauList = MasjidSurau::orderBy('nama')->get();
        
        // Get unique locations for filter
        $lokasiList = Asset::select('lokasi_penempatan')
                          ->whereNotNull('lokasi_penempatan')
                          ->distinct()
                          ->orderBy('lokasi_penempatan')
                          ->pluck('lokasi_penempatan');
        
        // Get selected masjid/surau details
        $selectedMasjidSurau = null;
        if ($masjidSurauId) {
            $selectedMasjidSurau = MasjidSurau::find($masjidSurauId);
        }
        
        return view('admin.reports.br-ams-003', compact(
            'assets', 
            'masjidSurauList', 
            'lokasiList', 
            'masjidSurauId',
            'lokasi',
            'selectedMasjidSurau'
        ));
    }

    /**
     * Generate BR-AMS 004: Borang Permohonan Pergerakan / Pinjaman Aset Alih
     */
    public function brAms004(Request $request)
    {
        // Get filter parameters
        $masjidSurauId = $request->get('masjid_surau_id');
        $status = $request->get('status');
        
        // Build query for asset movements
        $query = AssetMovement::with(['asset', 'asset.masjidSurau', 'user']);
        
        if ($masjidSurauId) {
            $query->whereHas('asset', function($q) use ($masjidSurauId) {
                $q->where('masjid_surau_id', $masjidSurauId);
            });
        }
        
        if ($status) {
            $query->where('status_pergerakan', $status);
        }
        
        $movements = $query->orderBy('created_at', 'desc')->get();
        
        // Get all masjid/surau for filter dropdown
        $masjidSurauList = MasjidSurau::orderBy('nama')->get();
        
        // Get status options
        $statusOptions = [
            'menunggu_kelulusan' => 'Menunggu Kelulusan',
            'diluluskan' => 'Diluluskan',
            'ditolak' => 'Ditolak',
            'dipulangkan' => 'Dipulangkan'
        ];
        
        return view('admin.reports.br-ams-004', compact(
            'movements', 
            'masjidSurauList', 
            'statusOptions',
            'masjidSurauId',
            'status'
        ));
    }

    /**
     * Generate BR-AMS 005: Borang Pemeriksaan Aset Alih (Movable Asset Inspection Form)
     */
    public function brAms005(Request $request)
    {
        // Get filter parameters
        $masjidSurauId = $request->get('masjid_surau_id');
        $tahun = $request->get('tahun', date('Y')); // Default to current year
        $status = $request->get('status'); // Filter by asset status
        $needsInspection = $request->get('needs_inspection'); // Filter assets that need inspection
        
        // Build query for assets to be inspected with related data
        $query = Asset::with([
            'masjidSurau',
            'assetMovements' => function($q) {
                $q->latest()->limit(3); // Get last 3 movements
            },
            'inspections' => function($q) {
                $q->latest()->limit(1); // Get latest inspection
            },
            'maintenanceRecords' => function($q) {
                $q->latest()->limit(1); // Get latest maintenance
            }
        ]);
        
        if ($masjidSurauId) {
            $query->where('masjid_surau_id', $masjidSurauId);
        }
        
        if ($status) {
            $query->where('status_aset', $status);
        }
        
        if ($needsInspection) {
            $query->whereDoesntHave('inspections', function($q) {
                $q->where('tarikh_pemeriksaan', '>=', now()->subDays(90));
            });
        }
        
        // Get assets for inspection
        $assets = $query->orderBy('nama_aset')->get();
        
        // Get all masjid/surau for filter dropdown
        $masjidSurauList = MasjidSurau::orderBy('nama')->get();
        
        // Get immovable assets for context (if needed)
        $immovableAssets = ImmovableAsset::where('masjid_surau_id', $masjidSurauId)->get();
        
        // Get asset status options
        $assetStatuses = Asset::getAvailableStatuses();
        
        return view('admin.reports.br-ams-005', compact(
            'assets', 
            'masjidSurauList', 
            'masjidSurauId',
            'tahun',
            'status',
            'needsInspection',
            'immovableAssets',
            'assetStatuses'
        ));
    }

    /**
     * Generate BR-AMS 006: Rekod Penyelenggaraan Aset Alih (Movable Asset Maintenance Record)
     */
    public function brAms006(Request $request)
    {
        // Get filter parameters
        $masjidSurauId = $request->get('masjid_surau_id');
        $daerah = $request->get('daerah');
        
        // Build query for maintenance records
        $query = MaintenanceRecord::with(['asset', 'asset.masjidSurau']);
        
        if ($masjidSurauId) {
            $query->whereHas('asset', function($q) use ($masjidSurauId) {
                $q->where('masjid_surau_id', $masjidSurauId);
            });
        }
        
        if ($daerah) {
            $query->whereHas('asset.masjidSurau', function($q) use ($daerah) {
                $q->where('daerah', 'like', '%' . $daerah . '%');
            });
        }
        
        $maintenanceRecords = $query->orderBy('tarikh_penyelenggaraan', 'desc')->get();
        
        // Get all masjid/surau for filter dropdown
        $masjidSurauList = MasjidSurau::orderBy('nama')->get();
        
        // Get unique daerah for filter
        $daerahList = MasjidSurau::select('daerah')->distinct()->orderBy('daerah')->pluck('daerah');
        
        // Calculate totals
        $totalCost = $maintenanceRecords->sum('kos_penyelenggaraan');
        
        return view('admin.reports.br-ams-006', compact(
            'maintenanceRecords', 
            'masjidSurauList', 
            'daerahList', 
            'totalCost',
            'masjidSurauId',
            'daerah'
        ));
    }

    /**
     * Generate BR-AMS 007: Rekod Pelupusan Aset Alih (Record of Disposal of Movable Assets)
     */
    public function brAms007(Request $request)
    {
        // Get filter parameters
        $masjidSurauId = $request->get('masjid_surau_id');
        $daerah = $request->get('daerah');
        $tahun = $request->get('tahun', date('Y'));
        
        // Build query for disposal records
        $query = Disposal::with(['asset', 'asset.masjidSurau']);
        
        if ($masjidSurauId) {
            $query->whereHas('asset', function($q) use ($masjidSurauId) {
                $q->where('masjid_surau_id', $masjidSurauId);
            });
        }
        
        if ($daerah) {
            $query->whereHas('asset.masjidSurau', function($q) use ($daerah) {
                $q->where('daerah', 'like', '%' . $daerah . '%');
            });
        }
        
        if ($tahun) {
            $query->whereYear('tarikh_pelupusan', $tahun);
        }
        
        $disposals = $query->orderBy('tarikh_pelupusan', 'desc')->get();
        
        // Get all masjid/surau for filter dropdown
        $masjidSurauList = MasjidSurau::orderBy('nama')->get();
        
        // Get unique daerah for filter
        $daerahList = MasjidSurau::select('daerah')->distinct()->orderBy('daerah')->pluck('daerah');
        
        // Calculate totals
        $totalValue = $disposals->sum('nilai_pelupusan');
        
        return view('admin.reports.br-ams-007', compact(
            'disposals', 
            'masjidSurauList', 
            'daerahList', 
            'totalValue',
            'masjidSurauId',
            'daerah',
            'tahun'
        ));
    }

    /**
     * Generate BR-AMS 008: Laporan Tindakan Pelupusan Aset Alih (Asset Disposal Action Report)
     */
    public function brAms008(Request $request)
    {
        // Get filter parameters
        $masjidSurauId = $request->get('masjid_surau_id');
        $daerah = $request->get('daerah');
        $tahun = $request->get('tahun', date('Y'));
        
        // Build query for disposal records
        $query = Disposal::with(['asset', 'asset.masjidSurau']);
        
        if ($masjidSurauId) {
            $query->whereHas('asset', function($q) use ($masjidSurauId) {
                $q->where('masjid_surau_id', $masjidSurauId);
            });
        }
        
        if ($daerah) {
            $query->whereHas('asset.masjidSurau', function($q) use ($daerah) {
                $q->where('daerah', 'like', '%' . $daerah . '%');
            });
        }
        
        if ($tahun) {
            $query->whereYear('tarikh_pelupusan', $tahun);
        }
        
        $disposals = $query->orderBy('tarikh_pelupusan', 'desc')->get();
        
        // Get all masjid/surau for filter dropdown
        $masjidSurauList = MasjidSurau::orderBy('nama')->get();
        
        // Get unique daerah for filter
        $daerahList = MasjidSurau::select('daerah')->distinct()->orderBy('daerah')->pluck('daerah');
        
        // Calculate totals
        $totalProceeds = $disposals->where('kaedah_pelupusan', 'jualan')->sum('hasil_pelupusan');
        
        return view('admin.reports.br-ams-008', compact(
            'disposals', 
            'masjidSurauList', 
            'daerahList', 
            'totalProceeds',
            'masjidSurauId',
            'daerah',
            'tahun'
        ));
    }

    /**
     * Generate BR-AMS 009: Laporan Kehilangan / Hapus Kira Aset Alih (Report of Loss / Write-off of Movable Assets)
     */
    public function brAms009(Request $request)
    {
        // Get filter parameters
        $masjidSurauId = $request->get('masjid_surau_id');
        $daerah = $request->get('daerah');
        $tahun = $request->get('tahun', date('Y'));
        
        // Build query for loss/write-off records
        $query = LossWriteoff::with(['asset', 'asset.masjidSurau']);
        
        if ($masjidSurauId) {
            $query->whereHas('asset', function($q) use ($masjidSurauId) {
                $q->where('masjid_surau_id', $masjidSurauId);
            });
        }
        
        if ($daerah) {
            $query->whereHas('asset.masjidSurau', function($q) use ($daerah) {
                $q->where('daerah', 'like', '%' . $daerah . '%');
            });
        }
        
        if ($tahun) {
            $query->whereYear('tarikh_kehilangan', $tahun);
        }
        
        $lossWriteoffs = $query->orderBy('tarikh_kehilangan', 'desc')->get();
        
        // Get all masjid/surau for filter dropdown
        $masjidSurauList = MasjidSurau::orderBy('nama')->get();
        
        // Get unique daerah for filter
        $daerahList = MasjidSurau::select('daerah')->distinct()->orderBy('daerah')->pluck('daerah');
        
        // Calculate totals
        $totalValue = $lossWriteoffs->sum('nilai_kehilangan');
        
        return view('admin.reports.br-ams-009', compact(
            'lossWriteoffs', 
            'masjidSurauList', 
            'daerahList', 
            'totalValue',
            'masjidSurauId',
            'daerah',
            'tahun'
        ));
    }

    /**
     * Generate BR-AMS 011: Senarai Rekod Aset Tak Alih (List of Immovable Asset Records)
     */
    public function brAms011(Request $request)
    {
        // Get filter parameters
        $masjidSurauId = $request->get('masjid_surau_id');
        $daerah = $request->get('daerah');
        $tahun = $request->get('tahun', date('Y'));
        
        // Build query for immovable assets
        $query = ImmovableAsset::with(['masjidSurau']);
        
        if ($masjidSurauId) {
            $query->where('masjid_surau_id', $masjidSurauId);
        }
        
        if ($daerah) {
            $query->whereHas('masjidSurau', function($q) use ($daerah) {
                $q->where('daerah', 'like', '%' . $daerah . '%');
            });
        }
        
        if ($tahun) {
            $query->whereYear('tarikh_perolehan', $tahun);
        }
        
        $immovableAssets = $query->orderBy('tarikh_perolehan', 'desc')->get();
        
        // Get all masjid/surau for filter dropdown
        $masjidSurauList = MasjidSurau::orderBy('nama')->get();
        
        // Get unique daerah for filter
        $daerahList = MasjidSurau::select('daerah')->distinct()->orderBy('daerah')->pluck('daerah');
        
        // Calculate totals
        $totalCost = $immovableAssets->sum('kos_perolehan');
        
        return view('admin.reports.br-ams-011', compact(
            'immovableAssets', 
            'masjidSurauList', 
            'daerahList', 
            'totalCost',
            'masjidSurauId',
            'daerah',
            'tahun'
        ));
    }

    /**
     * Generate BR-AMS 010: Laporan Tahunan Pengurusan Aset Alih (Annual Report on Movable Asset Management)
     */
    public function brAms010(Request $request)
    {
        // Get filter parameters
        $masjidSurauId = $request->get('masjid_surau_id');
        $daerah = $request->get('daerah');
        $tahun = $request->get('tahun', date('Y'));
        
        // Get capital assets (BR-AMS 001)
        $capitalAssetsQuery = Asset::where('kategori_aset', 'harta_modal');
        if ($masjidSurauId) {
            $capitalAssetsQuery->where('masjid_surau_id', $masjidSurauId);
        }
        if ($daerah) {
            $capitalAssetsQuery->whereHas('masjidSurau', function($q) use ($daerah) {
                $q->where('daerah', 'like', '%' . $daerah . '%');
            });
        }
        if ($tahun) {
            $capitalAssetsQuery->whereYear('tarikh_perolehan', $tahun);
        }
        $capitalAssets = $capitalAssetsQuery->get();
        $capitalAssetsCount = $capitalAssets->count();
        $capitalAssetsValue = $capitalAssets->sum('nilai_perolehan');
        
        // Get inventory assets (BR-AMS 002)
        $inventoryQuery = Asset::where('kategori_aset', 'inventori');
        if ($masjidSurauId) {
            $inventoryQuery->where('masjid_surau_id', $masjidSurauId);
        }
        if ($daerah) {
            $inventoryQuery->whereHas('masjidSurau', function($q) use ($daerah) {
                $q->where('daerah', 'like', '%' . $daerah . '%');
            });
        }
        if ($tahun) {
            $inventoryQuery->whereYear('tarikh_perolehan', $tahun);
        }
        $inventoryAssets = $inventoryQuery->get();
        $inventoryCount = $inventoryAssets->count();
        $inventoryValue = $inventoryAssets->sum('nilai_perolehan');
        
        // Get disposals (BR-AMS 007)
        $disposalsQuery = Disposal::with('asset');
        if ($masjidSurauId) {
            $disposalsQuery->whereHas('asset', function($q) use ($masjidSurauId) {
                $q->where('masjid_surau_id', $masjidSurauId);
            });
        }
        if ($daerah) {
            $disposalsQuery->whereHas('asset.masjidSurau', function($q) use ($daerah) {
                $q->where('daerah', 'like', '%' . $daerah . '%');
            });
        }
        if ($tahun) {
            $disposalsQuery->whereYear('tarikh_pelupusan', $tahun);
        }
        $disposals = $disposalsQuery->get();
        $disposalsCount = $disposals->count();
        $disposalsValue = $disposals->sum('nilai_pelupusan');
        
        // Get write-offs (BR-AMS 008)
        $writeoffsQuery = LossWriteoff::with('asset');
        if ($masjidSurauId) {
            $writeoffsQuery->whereHas('asset', function($q) use ($masjidSurauId) {
                $q->where('masjid_surau_id', $masjidSurauId);
            });
        }
        if ($daerah) {
            $writeoffsQuery->whereHas('asset.masjidSurau', function($q) use ($daerah) {
                $q->where('daerah', 'like', '%' . $daerah . '%');
            });
        }
        if ($tahun) {
            $writeoffsQuery->whereYear('tarikh_kehilangan', $tahun);
        }
        $writeoffs = $writeoffsQuery->get();
        $writeoffsCount = $writeoffs->count();
        $writeoffsValue = $writeoffs->sum('nilai_kehilangan');
        
        // Calculate grand total: (a) + (b) - (c) - (d)
        $grandTotal = $capitalAssetsValue + $inventoryValue - $disposalsValue - $writeoffsValue;
        
        // Get all masjid/surau for filter dropdown
        $masjidSurauList = MasjidSurau::orderBy('nama')->get();
        
        // Get unique daerah for filter
        $daerahList = MasjidSurau::select('daerah')->distinct()->orderBy('daerah')->pluck('daerah');
        
        return view('admin.reports.br-ams-010', compact(
            'capitalAssetsCount',
            'capitalAssetsValue',
            'inventoryCount',
            'inventoryValue',
            'disposalsCount',
            'disposalsValue',
            'writeoffsCount',
            'writeoffsValue',
            'grandTotal',
            'masjidSurauList',
            'daerahList',
            'masjidSurauId',
            'daerah',
            'tahun'
        ));
    }
}
