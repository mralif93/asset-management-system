<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LossWriteoff;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LossWriteoffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $query = Asset::with('masjidSurau');

        // Filter assets by masjid/surau if user is not admin
        if (Auth::user()->role !== 'admin') {
            $query->where('masjid_surau_id', Auth::user()->masjid_surau_id);
        }

        $assets = $query->get();

        return view('admin.loss-writeoffs.create', compact('assets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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

    /**
     * Display the specified resource.
     */
    public function show(LossWriteoff $lossWriteoff)
    {
        $lossWriteoff->load(['asset', 'asset.masjidSurau', 'user']);

        return view('admin.loss-writeoffs.show', compact('lossWriteoff'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LossWriteoff $lossWriteoff)
    {
        // Only allow editing if pending approval
        if ($lossWriteoff->status_kejadian !== 'Dilaporkan') {
            abort(403, 'Laporan yang telah diluluskan atau ditolak tidak boleh diedit.');
        }

        $query = Asset::with('masjidSurau');

        // Filter assets by masjid/surau if user is not admin
        if (Auth::user()->role !== 'admin') {
            $query->where('masjid_surau_id', Auth::user()->masjid_surau_id);
        }

        $assets = $query->get();

        return view('admin.loss-writeoffs.edit', compact('lossWriteoff', 'assets'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LossWriteoff $lossWriteoff)
    {
        // Only allow editing if pending approval
        if ($lossWriteoff->status_kejadian !== 'Dilaporkan') {
            abort(403, 'Laporan yang telah diluluskan atau ditolak tidak boleh diedit.');
        }

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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LossWriteoff $lossWriteoff)
    {
        // Only admin can delete loss write-offs
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $lossWriteoff->delete();

        return redirect()->route('admin.loss-writeoffs.index')
            ->with('success', 'Rekod kehilangan berjaya dipadamkan.');
    }

    /**
     * Approve loss write-off request (Admin only)
     */
    public function approve(LossWriteoff $lossWriteoff)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $lossWriteoff->update([
            'status_kejadian' => 'Diluluskan',
            'tarikh_kelulusan' => now(),
            'diluluskan_oleh' => Auth::id()
        ]);

        return redirect()->route('admin.loss-writeoffs.show', $lossWriteoff)
            ->with('success', 'Laporan kehilangan telah diluluskan.');
    }

    /**
     * Reject loss write-off request (Admin only)
     */
    public function reject(Request $request, LossWriteoff $lossWriteoff)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'sebab_penolakan' => 'required|string'
        ]);

        $lossWriteoff->update([
            'status_kejadian' => 'Ditolak',
            'tarikh_kelulusan' => now(),
            'diluluskan_oleh' => Auth::id(),
            'sebab_penolakan' => $request->sebab_penolakan
        ]);

        return redirect()->route('admin.loss-writeoffs.show', $lossWriteoff)
            ->with('success', 'Laporan kehilangan telah ditolak.');
    }
}
