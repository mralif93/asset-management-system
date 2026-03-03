<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inspection;
use App\Models\Asset;
use App\Models\MasjidSurau;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InspectionController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Inspection::class);
        
        $query = Inspection::with(['asset', 'asset.masjidSurau']);

        // Search by asset name or registration number
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('asset', function ($q) use ($search) {
                $q->where('nama_aset', 'like', "%{$search}%")
                    ->orWhere('no_siri_pendaftaran', 'like', "%{$search}%");
            });
        }

        // Filter by asset condition
        if ($request->filled('kondisi_aset')) {
            $query->where('kondisi_aset', $request->kondisi_aset);
        }

        // Filter by masjid/surau
        if ($request->filled('masjid_surau_id')) {
            $query->whereHas('asset', function ($q) use ($request) {
                $q->where('masjid_surau_id', $request->masjid_surau_id);
            });
        }

        // Filter by date range
        if ($request->filled('tarikh_dari')) {
            $query->whereDate('tarikh_pemeriksaan', '>=', $request->tarikh_dari);
        }
        if ($request->filled('tarikh_hingga')) {
            $query->whereDate('tarikh_pemeriksaan', '<=', $request->tarikh_hingga);
        }

        // Filter by inspector
        if ($request->filled('pegawai_pemeriksa')) {
            $query->where('pegawai_pemeriksa', 'like', "%{$request->pegawai_pemeriksa}%");
        }

        // Filter by recommended action
        if ($request->filled('cadangan_tindakan')) {
            $query->where('cadangan_tindakan', $request->cadangan_tindakan);
        }

        $inspections = $query->latest()->paginate(15);
        
        $masjidSuraus = MasjidSurau::orderBy('nama')->get();
        $conditions = ['Baik', 'Sederhana', 'Rosak', 'Sedang Digunakan', 'Tidak Digunakan'];
        $actions = ['Tiada Tindakan', 'Penyelenggaraan', 'Pelupusan', 'Hapus Kira'];

        return view('admin.inspections.index', compact('inspections', 'masjidSuraus', 'conditions', 'actions'));
    }

    /**
     * Export inspections to Excel
     */
    public function export(Request $request)
    {
        $filename = 'inspections_export_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\InspectionExport($request), $filename);
    }

    public function create()
    {
        $this->authorize('create', Inspection::class);
        
        $assets = Asset::with('masjidSurau')->get();

        return view('admin.inspections.create', compact('assets'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Inspection::class);
        
        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'tarikh_pemeriksaan' => 'required|date',
            'kondisi_aset' => 'required|string',
            'nama_pemeriksa' => 'required|string',
            'catatan_pemeriksaan' => 'nullable|string',
            'tindakan_diperlukan' => 'nullable|string',
            'tarikh_pemeriksaan_akan_datang' => 'nullable|date|after:tarikh_pemeriksaan',
            'gambar_pemeriksaan' => 'nullable|array',
            'gambar_pemeriksaan.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'signature' => 'required|string',
            'jawatan_pemeriksa' => 'required|string'
        ]);

        // Handle image uploads
        if ($request->hasFile('gambar_pemeriksaan')) {
            $images = [];
            foreach ($request->file('gambar_pemeriksaan') as $image) {
                $path = $image->store('inspections', 'public');
                $images[] = $path;
            }
            $validated['gambar_pemeriksaan'] = $images;
        }


        // Get asset location
        $asset = Asset::find($validated['asset_id']);
        $validated['lokasi_semasa_pemeriksaan'] = $asset->lokasi_penempatan ?? '-';

        // Map nama_pemeriksa to pegawai_pemeriksa (legacy naming fix)
        $validated['pegawai_pemeriksa'] = $validated['nama_pemeriksa'];
        unset($validated['nama_pemeriksa']);

        // Map tindakan_diperlukan to cadangan_tindakan
        $validated['cadangan_tindakan'] = $validated['tindakan_diperlukan'] ?? '-';
        unset($validated['tindakan_diperlukan']);

        // Map catatan_pemeriksaan to catatan_pemeriksa
        $validated['catatan_pemeriksa'] = $validated['catatan_pemeriksaan'] ?? '-';
        unset($validated['catatan_pemeriksaan']);

        // Set user_id
        $validated['user_id'] = Auth::id();

        $inspection = Inspection::create($validated);

        return redirect()->route('admin.inspections.show', $inspection)
            ->with('success', 'Pemeriksaan berjaya direkodkan.');
    }

    public function show(Inspection $inspection)
    {
        $this->authorize('view', $inspection);
        
        $inspection->load(['asset', 'asset.masjidSurau']);

        // Get related inspections for the same asset
        $relatedInspections = Inspection::where('asset_id', $inspection->asset_id)
            ->where('id', '!=', $inspection->id)
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.inspections.show', compact('inspection', 'relatedInspections'));
    }

    public function edit(Inspection $inspection)
    {
        $this->authorize('update', $inspection);
        
        $assets = Asset::with('masjidSurau')->get();

        return view('admin.inspections.edit', compact('inspection', 'assets'));
    }

    public function update(Request $request, Inspection $inspection)
    {
        $this->authorize('update', $inspection);
        
        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'tarikh_pemeriksaan' => 'required|date',
            'kondisi_aset' => 'required|string',
            'nama_pemeriksa' => 'required|string',
            'catatan_pemeriksaan' => 'nullable|string',
            'tindakan_diperlukan' => 'nullable|string',
            'tarikh_pemeriksaan_akan_datang' => 'nullable|date|after:tarikh_pemeriksaan',
            'gambar_pemeriksaan' => 'nullable|array',
            'gambar_pemeriksaan.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'signature' => 'nullable|string',
            'jawatan_pemeriksa' => 'required|string'
        ]);

        // Handle image uploads
        if ($request->hasFile('gambar_pemeriksaan')) {
            $images = $inspection->gambar_pemeriksaan ?? [];
            foreach ($request->file('gambar_pemeriksaan') as $image) {
                $path = $image->store('inspections', 'public');
                $images[] = $path;
            }
            $validated['gambar_pemeriksaan'] = $images;
        }

        // Get asset location
        $asset = Asset::find($validated['asset_id']);
        $validated['lokasi_semasa_pemeriksaan'] = $asset->lokasi_penempatan ?? '-';

        // Map nama_pemeriksa to pegawai_pemeriksa (legacy naming fix)
        $validated['pegawai_pemeriksa'] = $validated['nama_pemeriksa'];
        unset($validated['nama_pemeriksa']);

        // Map tindakan_diperlukan to cadangan_tindakan
        $validated['cadangan_tindakan'] = $validated['tindakan_diperlukan'] ?? '-';
        unset($validated['tindakan_diperlukan']);

        // Map catatan_pemeriksaan to catatan_pemeriksa
        $validated['catatan_pemeriksa'] = $validated['catatan_pemeriksaan'] ?? '-';
        unset($validated['catatan_pemeriksaan']);

        $inspection->update($validated);

        return redirect()->route('admin.inspections.show', $inspection)
            ->with('success', 'Rekod pemeriksaan berjaya dikemaskini.');
    }

    public function destroy(Inspection $inspection)
    {
        $this->authorize('delete', $inspection);
        
        $inspection->delete();

        return redirect()->route('admin.inspections.index')
            ->with('success', 'Rekod pemeriksaan berjaya dipadamkan.');
    }

    /**
     * Display a listing of trashed inspections.
     */
    public function trashed()
    {
        $this->authorize('viewAny', Inspection::class);
        
        $trashedInspections = Inspection::onlyTrashed()
            ->with(['asset', 'asset.masjidSurau'])
            ->latest()
            ->paginate(15);

        return view('admin.inspections.trashed', compact('trashedInspections'));
    }

    /**
     * Restore a soft-deleted inspection.
     */
    public function restore($id)
    {
        $this->authorize('restore', Inspection::class);
        
        $inspection = Inspection::onlyTrashed()->findOrFail($id);
        $inspection->restore();

        return redirect()->route('admin.inspections.trashed')
            ->with('success', 'Rekod pemeriksaan berjaya dipulihkan.');
    }
}
