<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Disposal;
use App\Models\Asset;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DisposalController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $this->authorize('viewAny', Disposal::class);
        
        $query = Disposal::with(['asset', 'asset.masjidSurau']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status_pelupusan', $request->status);
        }

        // Filter by search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('asset', function ($q) use ($search) {
                $q->where('nama_aset', 'like', "%{$search}%")
                    ->orWhere('no_siri_pendaftaran', 'like', "%{$search}%");
            });
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('tarikh_permohonan', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('tarikh_permohonan', '<=', $request->date_to);
        }

        $disposals = $query->latest()->paginate(15);

        return view('admin.disposals.index', compact('disposals'));
    }

    /**
     * Export disposals to Excel
     */
    public function export(Request $request)
    {
        $filename = 'disposals_export_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\DisposalExport($request), $filename);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Disposal::class);
        
        $assets = Asset::with('masjidSurau')->get();

        return view('admin.disposals.create', compact('assets'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Disposal::class);
        
        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'justifikasi_pelupusan' => 'required|string',
            'kaedah_pelupusan_dicadang' => 'required|string',
            'kaedah_pelupusan' => 'nullable|string',
            'tarikh_permohonan' => 'required|date',
            'nilai_pelupusan' => 'nullable|numeric|min:0',
            'nilai_baki' => 'nullable|numeric|min:0',
            'hasil_pelupusan' => 'nullable|numeric|min:0',
            'catatan' => 'nullable|string',
            'gambar_pelupusan' => 'nullable|array',
            'gambar_pelupusan.*' => 'file|mimes:pdf,jpg,jpeg,png|max:10240'
        ]);

        // Handle document uploads
        if ($request->hasFile('gambar_pelupusan')) {
            $documents = [];
            foreach ($request->file('gambar_pelupusan') as $document) {
                $path = $document->store('disposals', 'public');
                $documents[] = $path;
            }
            $validated['gambar_pelupusan'] = $documents;
        }

        // Calculate nilai_baki from asset if not provided
        if (empty($validated['nilai_baki'])) {
            $asset = Asset::find($validated['asset_id']);
            $validated['nilai_baki'] = $asset ? $asset->getCurrentValue() : 0;
        }

        // Set nilai_pelupusan from asset if not provided
        if (empty($validated['nilai_pelupusan'])) {
            $asset = Asset::find($validated['asset_id']);
            $validated['nilai_pelupusan'] = $asset ? $asset->nilai_perolehan : 0;
        }

        $validated['user_id'] = Auth::id();
        $validated['status_pelupusan'] = 'Dimohon';
        $validated['pegawai_pemohon'] = Auth::user()->name;

        $disposal = Disposal::create($validated);

        NotificationService::notifyNewDisposalRequest($disposal);

        return redirect()->route('admin.disposals.show', $disposal)
            ->with('success', 'Permohonan pelupusan berjaya dihantar.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Disposal $disposal)
    {
        $this->authorize('view', $disposal);
        
        $disposal->load(['asset', 'asset.masjidSurau']);

        return view('admin.disposals.show', compact('disposal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Disposal $disposal)
    {
        $this->authorize('update', $disposal);

        $assets = Asset::with('masjidSurau')->get();

        return view('admin.disposals.edit', compact('disposal', 'assets'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Disposal $disposal)
    {
        $this->authorize('update', $disposal);

        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'justifikasi_pelupusan' => 'required|string',
            'kaedah_pelupusan_dicadang' => 'required|string',
            'kaedah_pelupusan' => 'nullable|string',
            'tarikh_permohonan' => 'required|date',
            'nilai_pelupusan' => 'nullable|numeric|min:0',
            'nilai_baki' => 'nullable|numeric|min:0',
            'hasil_pelupusan' => 'nullable|numeric|min:0',
            'catatan' => 'nullable|string',
            'gambar_pelupusan' => 'nullable|array',
            'gambar_pelupusan.*' => 'file|mimes:pdf,jpg,jpeg,png|max:10240'
        ]);

        // Handle document uploads
        if ($request->hasFile('gambar_pelupusan')) {
            $documents = $disposal->gambar_pelupusan ?? [];
            foreach ($request->file('gambar_pelupusan') as $document) {
                $path = $document->store('disposals', 'public');
                $documents[] = $path;
            }
            $validated['gambar_pelupusan'] = $documents;
        }

        $disposal->update($validated);

        return redirect()->route('admin.disposals.show', $disposal)
            ->with('success', 'Permohonan pelupusan berjaya dikemaskini.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Disposal $disposal)
    {
        $this->authorize('delete', $disposal);
        
        $disposal->delete();

        return redirect()->route('admin.disposals.index')
            ->with('success', 'Rekod pelupusan berjaya dipadamkan.');
    }

    public function approve(Disposal $disposal)
    {
        $this->authorize('approve', $disposal);
        
        $disposal->update([
            'status_pelupusan' => 'Diluluskan',
            'tarikh_kelulusan_pelupusan' => now(),
            'tarikh_pelupusan' => now(),
        ]);

        // Update asset status
        $disposal->asset->update([
            'status_aset' => Asset::STATUS_DISPOSED
        ]);

        NotificationService::notifyDisposalApproved($disposal);

        return redirect()->route('admin.disposals.show', $disposal)
            ->with('success', 'Permohonan pelupusan telah diluluskan dan status aset dikemaskini.');
    }

    public function reject(Request $request, Disposal $disposal)
    {
        $this->authorize('reject', $disposal);
        
        $request->validate([
            'sebab_penolakan' => 'required|string'
        ]);

        $disposal->update([
            'status_pelupusan' => 'Ditolak',
            'tarikh_kelulusan_pelupusan' => now(),
            'catatan' => $disposal->catatan . "\n\nSebab Penolakan: " . $request->sebab_penolakan,
        ]);

        NotificationService::notifyDisposalRejected($disposal, $request->sebab_penolakan);

        return redirect()->route('admin.disposals.show', $disposal)
            ->with('success', 'Permohonan pelupusan telah ditolak.');
    }

    /**
     * Bulk approve disposal requests.
     */
    public function bulkApprove(Request $request)
    {
        $this->authorize('approve', Disposal::class);
        
        $validated = $request->validate([
            'disposal_ids' => 'required|array',
            'disposal_ids.*' => 'exists:disposals,id',
        ]);

        $approvedCount = 0;

        foreach ($validated['disposal_ids'] as $disposalId) {
            $disposal = Disposal::find($disposalId);
            
            if ($disposal && $disposal->status_pelupusan === 'Dimohon') {
                $disposal->update([
                    'status_pelupusan' => 'Diluluskan',
                    'tarikh_kelulusan_pelupusan' => now(),
                    'tarikh_pelupusan' => now(),
                ]);

                $disposal->asset->update([
                    'status_aset' => Asset::STATUS_DISPOSED
                ]);
                
                $approvedCount++;
            }
        }

        return redirect()->route('admin.disposals.index')
            ->with('success', $approvedCount . ' permohonan pelupusan berjaya diluluskan.');
    }

    /**
     * Bulk reject disposal requests.
     */
    public function bulkReject(Request $request)
    {
        $this->authorize('reject', Disposal::class);
        
        $validated = $request->validate([
            'disposal_ids' => 'required|array',
            'disposal_ids.*' => 'exists:disposals,id',
            'sebab_penolakan' => 'required|string',
        ]);

        $rejectedCount = 0;

        foreach ($validated['disposal_ids'] as $disposalId) {
            $disposal = Disposal::find($disposalId);
            
            if ($disposal && $disposal->status_pelupusan === 'Dimohon') {
                $disposal->update([
                    'status_pelupusan' => 'Ditolak',
                    'tarikh_kelulusan_pelupusan' => now(),
                    'catatan' => $disposal->catatan . "\n\nSebab Penolakan: " . $validated['sebab_penolakan'],
                ]);
                
                $rejectedCount++;
            }
        }

        return redirect()->route('admin.disposals.index')
            ->with('success', $rejectedCount . ' permohonan pelupusan telah ditolak.');
    }
}
