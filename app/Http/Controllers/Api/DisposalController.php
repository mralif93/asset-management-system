<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Disposal;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DisposalController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Disposal::with(['asset', 'asset.masjidSurau']);

        if ($request->filled('status_pelupusan')) {
            $query->where('status_pelupusan', $request->status_pelupusan);
        }

        if ($request->filled('masjid_surau_id')) {
            $query->whereHas('asset', function ($q) use ($request) {
                $q->where('masjid_surau_id', $request->masjid_surau_id);
            });
        }

        $disposals = $query->latest()->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $disposals,
        ]);
    }

    public function show(Disposal $disposal): JsonResponse
    {
        $disposal->load(['asset', 'asset.masjidSurau']);

        return response()->json([
            'success' => true,
            'data' => $disposal,
        ]);
    }

    public function pending(): JsonResponse
    {
        $pendingDisposals = Disposal::with(['asset', 'asset.masjidSurau'])
            ->where('status_pelupusan', 'Dimohon')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $pendingDisposals,
            'count' => $pendingDisposals->count(),
        ]);
    }

    public function summary(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                'total' => Disposal::count(),
                'pending' => Disposal::where('status_pelupusan', 'Dimohon')->count(),
                'approved' => Disposal::where('status_pelupusan', 'Diluluskan')->count(),
                'rejected' => Disposal::where('status_pelupusan', 'Ditolak')->count(),
                'total_proceeds' => Disposal::where('status_pelupusan', 'Diluluskan')
                    ->whereIn('kaedah_pelupusan', ['Dijual', 'dijual', 'Jualan', 'jualan'])
                    ->sum('hasil_pelupusan'),
            ],
        ]);
    }
}
