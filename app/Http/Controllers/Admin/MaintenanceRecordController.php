<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceRecord;
use App\Models\Asset;
use App\Models\MasjidSurau;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class MaintenanceRecordController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $this->authorize('viewAny', MaintenanceRecord::class);

        $query = MaintenanceRecord::with(['asset', 'asset.masjidSurau']);

        // Search by asset name or registration number
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('asset', function ($q) use ($search) {
                $q->where('nama_aset', 'like', "%{$search}%")
                    ->orWhere('no_siri_pendaftaran', 'like', "%{$search}%");
            });
        }

        // Filter by masjid/surau
        if ($request->filled('masjid_surau_id')) {
            $query->whereHas('asset', function ($q) use ($request) {
                $q->where('masjid_surau_id', $request->masjid_surau_id);
            });
        }

        // Filter by maintenance type
        if ($request->filled('jenis_penyelenggaraan')) {
            $query->where('jenis_penyelenggaraan', $request->jenis_penyelenggaraan);
        }

        // Filter by maintenance status
        if ($request->filled('status_penyelenggaraan')) {
            $query->where('status_penyelenggaraan', $request->status_penyelenggaraan);
        }

        // Filter by date range
        if ($request->filled('tarikh_dari')) {
            $query->whereDate('tarikh_penyelenggaraan', '>=', $request->tarikh_dari);
        }
        if ($request->filled('tarikh_hingga')) {
            $query->whereDate('tarikh_penyelenggaraan', '<=', $request->tarikh_hingga);
        }

        // Filter by cost range
        if ($request->filled('kos_min')) {
            $query->where('kos_penyelenggaraan', '>=', $request->kos_min);
        }
        if ($request->filled('kos_max')) {
            $query->where('kos_penyelenggaraan', '<=', $request->kos_max);
        }

        $maintenanceRecords = $query->latest()->paginate(15);

        $masjidSuraus = MasjidSurau::orderBy('nama')->get();
        $jenisPenyelenggaraan = ['Pencegahan', 'Betulan', 'Pembaikan', 'Tukar Ganti', 'Pemeriksaan'];
        $statusPenyelenggaraan = ['Selesai', 'Dalam Proses', 'Dijadualkan', 'Dibatalkan'];

        return view('admin.maintenance-records.index', compact(
            'maintenanceRecords',
            'masjidSuraus',
            'jenisPenyelenggaraan',
            'statusPenyelenggaraan'
        ));
    }

    /**
     * Export maintenance records to Excel
     */
    public function export(Request $request)
    {
        $filename = 'maintenance_records_export_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\MaintenanceRecordExport($request), $filename);
    }

    public function create()
    {
        $this->authorize('create', MaintenanceRecord::class);

        $assets = Asset::with('masjidSurau')->get();

        return view('admin.maintenance-records.create', compact('assets'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', MaintenanceRecord::class);

        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'jenis_penyelenggaraan' => 'required|string',
            'tarikh_penyelenggaraan' => 'required|date',
            'kos_penyelenggaraan' => 'required|numeric|min:0',
            'penyedia_perkhidmatan' => 'required|string|max:255',
            'catatan_penyelenggaraan' => 'nullable|string',
            'tarikh_penyelenggaraan_akan_datang' => 'nullable|date|after:tarikh_penyelenggaraan',
            'gambar_penyelenggaraan' => 'nullable|array',
            'gambar_penyelenggaraan.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'butiran_kerja' => 'required|string',
            'pegawai_bertanggungjawab' => 'required|string',
            'status_penyelenggaraan' => 'required|string',
        ]);

        // Handle image uploads
        if ($request->hasFile('gambar_penyelenggaraan')) {
            $images = [];
            foreach ($request->file('gambar_penyelenggaraan') as $image) {
                $path = $image->store('maintenance', 'public');
                $images[] = $path;
            }
            $validated['gambar_penyelenggaraan'] = $images;
        }

        $validated['user_id'] = Auth::id();

        // Map catatan_penyelenggaraan to catatan
        if (array_key_exists('catatan_penyelenggaraan', $validated)) {
            $validated['catatan'] = $validated['catatan_penyelenggaraan'];
            unset($validated['catatan_penyelenggaraan']);
        }

        $maintenanceRecord = MaintenanceRecord::create($validated);

        return redirect()->route('admin.maintenance-records.show', $maintenanceRecord)
            ->with('success', 'Rekod penyelenggaraan berjaya disimpan.');
    }

    public function show(MaintenanceRecord $maintenanceRecord)
    {
        $this->authorize('view', $maintenanceRecord);

        $maintenanceRecord->load(['asset', 'asset.masjidSurau', 'user']);

        return view('admin.maintenance-records.show', compact('maintenanceRecord'));
    }

    public function edit(MaintenanceRecord $maintenanceRecord)
    {
        $this->authorize('update', $maintenanceRecord);

        $assets = Asset::with('masjidSurau')->get();

        return view('admin.maintenance-records.edit', compact('maintenanceRecord', 'assets'));
    }

    public function update(Request $request, MaintenanceRecord $maintenanceRecord)
    {
        $this->authorize('update', $maintenanceRecord);

        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'jenis_penyelenggaraan' => 'required|string',
            'tarikh_penyelenggaraan' => 'required|date',
            'kos_penyelenggaraan' => 'required|numeric|min:0',
            'penyedia_perkhidmatan' => 'required|string|max:255',
            'catatan_penyelenggaraan' => 'nullable|string',
            'tarikh_penyelenggaraan_akan_datang' => 'nullable|date|after:tarikh_penyelenggaraan',
            'gambar_penyelenggaraan' => 'nullable|array',
            'gambar_penyelenggaraan.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'status_penyelenggaraan' => 'required|string'
        ]);

        // Handle image uploads
        if ($request->hasFile('gambar_penyelenggaraan')) {
            $images = $maintenanceRecord->gambar_penyelenggaraan ?? [];
            foreach ($request->file('gambar_penyelenggaraan') as $image) {
                $path = $image->store('maintenance', 'public');
                $images[] = $path;
            }
            $validated['gambar_penyelenggaraan'] = $images;
        }

        // Map catatan_penyelenggaraan to catatan
        if (array_key_exists('catatan_penyelenggaraan', $validated)) {
            $validated['catatan'] = $validated['catatan_penyelenggaraan'];
            unset($validated['catatan_penyelenggaraan']);
        }

        $maintenanceRecord->update($validated);

        return redirect()->route('admin.maintenance-records.show', $maintenanceRecord)
            ->with('success', 'Rekod penyelenggaraan berjaya dikemaskini.');
    }

    public function destroy(MaintenanceRecord $maintenanceRecord)
    {
        $this->authorize('delete', $maintenanceRecord);

        $maintenanceRecord->delete();

        return redirect()->route('admin.maintenance-records.index')
            ->with('success', 'Rekod penyelenggaraan berjaya dipadamkan.');
    }

    /**
     * Display a listing of trashed maintenance records.
     */
    public function trashed()
    {
        $this->authorize('viewAny', MaintenanceRecord::class);

        $trashedRecords = MaintenanceRecord::onlyTrashed()
            ->with(['asset', 'asset.masjidSurau'])
            ->latest()
            ->paginate(15);

        return view('admin.maintenance-records.trashed', compact('trashedRecords'));
    }

    /**
     * Restore a soft-deleted maintenance record.
     */
    public function restore($id)
    {
        $this->authorize('restore', MaintenanceRecord::class);

        $record = MaintenanceRecord::onlyTrashed()->findOrFail($id);
        $record->restore();

        return redirect()->route('admin.maintenance-records.trashed')
            ->with('success', 'Rekod penyelenggaraan berjaya dipulihkan.');
    }
}
