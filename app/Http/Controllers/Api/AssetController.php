<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\MasjidSurau;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AssetController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Asset::with('masjidSurau');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_aset', 'like', "%{$search}%")
                    ->orWhere('no_siri_pendaftaran', 'like', "%{$search}%");
            });
        }

        if ($request->filled('masjid_surau_id')) {
            $query->where('masjid_surau_id', $request->masjid_surau_id);
        }

        if ($request->filled('status_aset')) {
            $query->where('status_aset', $request->status_aset);
        }

        if ($request->filled('kategori_aset')) {
            $query->where('kategori_aset', $request->kategori_aset);
        }

        $assets = $query->latest()->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $assets,
        ]);
    }

    public function show(Asset $asset): JsonResponse
    {
        $asset->load(['masjidSurau', 'inspections', 'maintenanceRecords', 'assetMovements']);

        return response()->json([
            'success' => true,
            'data' => $asset,
            'depreciation' => [
                'current_value' => $asset->getCurrentValue(),
                'total_depreciation' => $asset->getTotalDepreciation(),
                'annual_depreciation' => $asset->getAnnualDepreciation(),
                'schedule' => $asset->getDepreciationSchedule(),
            ],
        ]);
    }

    public function summary(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                'total_assets' => Asset::count(),
                'total_capital_assets' => Asset::where('kategori_aset', 'asset')->count(),
                'total_inventory' => Asset::where('kategori_aset', 'non-asset')->count(),
                'active_assets' => Asset::where('status_aset', 'Aktif')->count(),
                'disposed_assets' => Asset::where('status_aset', 'Dilupuskan')->count(),
                'total_value' => Asset::sum('nilai_perolehan'),
                'by_status' => Asset::selectRaw('status_aset, count(*) as count')
                    ->groupBy('status_aset')
                    ->pluck('count', 'status_aset'),
                'by_type' => Asset::selectRaw('jenis_aset, count(*) as count')
                    ->groupBy('jenis_aset')
                    ->pluck('count', 'jenis_aset'),
            ],
        ]);
    }
}
