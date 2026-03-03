<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LossWriteoff;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class LossWriteoffController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', LossWriteoff::class);
        
        $query = LossWriteoff::with(['asset', 'asset.masjidSurau']);

        // Filter by masjid/surau if user is not admin
        if (Auth::user()->role !== 'admin') {
            $query->whereHas('asset', function ($q) {
                $q->where('masjid_surau_id', Auth::user()->masjid_surau_id);
            });
        }

        $lossWriteoffs = $query->latest()->paginate(15);

        // Calculate statistics
        $statsQuery = LossWriteoff::query();

        // Apply same filter for statistics
        if (Auth::user()->role !== 'admin') {
            $statsQuery->whereHas('asset', function ($q) {
                $q->where('masjid_surau_id', Auth::user()->masjid_surau_id);
            });
        }

        $totalLosses = $statsQuery->count();
        $pendingLosses = $statsQuery->where('status_kejadian', 'Dilaporkan')->count();
        $approvedLosses = $statsQuery->where('status_kejadian', 'Diluluskan')->count();
        $totalLossValue = $statsQuery->sum('nilai_kehilangan');

        return view('admin.loss-writeoffs.index', compact(
            'lossWriteoffs',
            'totalLosses',
            'pendingLosses',
            'approvedLosses',
            'totalLossValue'
        ));
    }

    /**
     * Export loss/write-offs to Excel
     */
    public function export(Request $request)
    {
        $filename = 'loss_writeoffs_export_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\LossWriteoffExport($request), $filename);
    }

    public function create()
    {
        $this->authorize('create', LossWriteoff::class);
        
        $query = Asset::with('masjidSurau');

        // Filter assets by masjid/surau if user is not admin
        if (Auth::user()->role !== 'admin') {
            $query->where('masjid_surau_id', Auth::user()->masjid_surau_id);
        }

        $assets = $query->get();

        return view('admin.loss-writeoffs.create', compact('assets'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', LossWriteoff::class);
        
        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'jenis_kejadian' => 'required|string',
            'sebab_kejadian' => 'required|string',
            'tarikh_laporan' => 'required|date',
            'nilai_kehilangan' => 'required|numeric|min:0',
            'laporan_polis' => 'nullable|string',
            'catatan' => 'nullable|string',
            'dokumen_kehilangan' => 'nullable|array',
            'dokumen_kehilangan.*' => 'file|mimes:pdf,jpg,jpeg,png|max:5120'
        ]);

        // Handle document uploads
        if ($request->hasFile('dokumen_kehilangan')) {
            $documents = [];
            foreach ($request->file('dokumen_kehilangan') as $document) {
                $path = $document->store('loss-writeoffs', 'public');
                $documents[] = $path;
            }
            $validated['dokumen_kehilangan'] = $documents;
        }

        $validated['user_id'] = Auth::id();
        $validated['status_kejadian'] = 'Dilaporkan';

        $lossWriteoff = LossWriteoff::create($validated);

        return redirect()->route('admin.loss-writeoffs.show', $lossWriteoff)
            ->with('success', 'Laporan kehilangan berjaya dihantar.');
    }

    public function show(LossWriteoff $lossWriteoff)
    {
        $this->authorize('view', $lossWriteoff);
        
        $lossWriteoff->load(['asset', 'asset.masjidSurau', 'user']);

        return view('admin.loss-writeoffs.show', compact('lossWriteoff'));
    }

    public function edit(LossWriteoff $lossWriteoff)
    {
        $this->authorize('update', $lossWriteoff);

        $query = Asset::with('masjidSurau');

        // Filter assets by masjid/surau if user is not admin
        if (Auth::user()->role !== 'admin') {
            $query->where('masjid_surau_id', Auth::user()->masjid_surau_id);
        }

        $assets = $query->get();

        return view('admin.loss-writeoffs.edit', compact('lossWriteoff', 'assets'));
    }

    public function update(Request $request, LossWriteoff $lossWriteoff)
    {
        $this->authorize('update', $lossWriteoff);

        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'jenis_kejadian' => 'required|string',
            'sebab_kejadian' => 'required|string',
            'tarikh_laporan' => 'required|date',
            'nilai_kehilangan' => 'required|numeric|min:0',
            'laporan_polis' => 'nullable|string',
            'catatan' => 'nullable|string',
            'dokumen_kehilangan' => 'nullable|array',
            'dokumen_kehilangan.*' => 'file|mimes:pdf,jpg,jpeg,png|max:5120'
        ]);

        // Handle document uploads
        if ($request->hasFile('dokumen_kehilangan')) {
            $documents = $lossWriteoff->dokumen_kehilangan ?? [];
            foreach ($request->file('dokumen_kehilangan') as $document) {
                $path = $document->store('loss-writeoffs', 'public');
                $documents[] = $path;
            }
            $validated['dokumen_kehilangan'] = $documents;
        }

        $lossWriteoff->update($validated);

        return redirect()->route('admin.loss-writeoffs.show', $lossWriteoff)
            ->with('success', 'Laporan kehilangan berjaya dikemaskini.');
    }

    public function destroy(LossWriteoff $lossWriteoff)
    {
        $this->authorize('delete', $lossWriteoff);

        $lossWriteoff->delete();

        return redirect()->route('admin.loss-writeoffs.index')
            ->with('success', 'Rekod kehilangan berjaya dipadamkan.');
    }

    public function approve(LossWriteoff $lossWriteoff)
    {
        $this->authorize('approve', $lossWriteoff);

        $lossWriteoff->update([
            'status_kejadian' => 'Diluluskan',
            'tarikh_kelulusan_hapus_kira' => now(),
            'diluluskan_oleh' => Auth::id()
        ]);

        // Update asset status
        $lossWriteoff->asset->update([
            'status_aset' => Asset::STATUS_LOST
        ]);

        return redirect()->route('admin.loss-writeoffs.show', $lossWriteoff)
            ->with('success', 'Laporan kehilangan telah diluluskan dan status aset dikemaskini.');
    }

    public function reject(Request $request, LossWriteoff $lossWriteoff)
    {
        $this->authorize('reject', $lossWriteoff);

        $request->validate([
            'sebab_penolakan' => 'required|string'
        ]);

        $lossWriteoff->update([
            'status_kejadian' => 'Ditolak',
            'tarikh_kelulusan_hapus_kira' => now(),
            'diluluskan_oleh' => Auth::id(),
            'sebab_penolakan' => $request->sebab_penolakan
        ]);

        return redirect()->route('admin.loss-writeoffs.show', $lossWriteoff)
            ->with('success', 'Laporan kehilangan telah ditolak.');
    }
}
