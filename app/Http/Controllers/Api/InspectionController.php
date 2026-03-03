<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inspection;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class InspectionController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Inspection::with(['asset', 'asset.masjidSurau']);

        if ($request->filled('asset_id')) {
            $query->where('asset_id', $request->asset_id);
        }

        if ($request->filled('kondisi_aset')) {
            $query->where('kondisi_aset', $request->kondisi_aset);
        }

        if ($request->filled('tarikh_dari')) {
            $query->whereDate('tarikh_pemeriksaan', '>=', $request->tarikh_dari);
        }

        if ($request->filled('tarikh_hingga')) {
            $query->whereDate('tarikh_pemeriksaan', '<=', $request->tarikh_hingga);
        }

        $inspections = $query->latest()->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $inspections,
        ]);
    }

    public function show(Inspection $inspection): JsonResponse
    {
        $inspection->load(['asset', 'asset.masjidSurau']);

        return response()->json([
            'success' => true,
            'data' => $inspection,
        ]);
    }

    public function upcoming(Request $request): JsonResponse
    {
        $inspections = Inspection::with(['asset', 'asset.masjidSurau'])
            ->whereNotNull('tarikh_pemeriksaan_akan_datang')
            ->where('tarikh_pemeriksaan_akan_datang', '>=', now())
            ->orderBy('tarikh_pemeriksaan_akan_datang')
            ->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $inspections,
        ]);
    }

    public function overdue(): JsonResponse
    {
        $assetsNeedingInspection = \App\Models\Asset::where(function ($q) {
            $q->whereNull('tarikh_pemeriksaan_terakhir')
                ->orWhere('tarikh_pemeriksaan_terakhir', '<', now()->subDays(90));
        })->with('masjidSurau')->get();

        return response()->json([
            'success' => true,
            'data' => $assetsNeedingInspection,
            'count' => $assetsNeedingInspection->count(),
        ]);
    }
}
