<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Disposal;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DisposalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Disposal::with(['asset', 'asset.masjidSurau']);

        // Admin can see all disposals

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
        $assets = Asset::with('masjidSurau')->get();

        return view('admin.disposals.create', compact('assets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'sebab_pelupusan' => 'required|string',
            'kaedah_pelupusan' => 'required|string',
            'tarikh_pelupusan' => 'required|date',
            'nilai_baki' => 'nullable|numeric|min:0',
            'nilai_pelupusan' => 'nullable|numeric|min:0',
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

        $validated['user_id'] = Auth::id();
        $validated['status_kelulusan'] = 'menunggu';

        $disposal = Disposal::create($validated);

        return redirect()->route('admin.disposals.show', $disposal)
            ->with('success', 'Permohonan pelupusan berjaya dihantar.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Disposal $disposal)
    {
        $disposal->load(['asset', 'asset.masjidSurau', 'user']);

        return view('admin.disposals.show', compact('disposal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Disposal $disposal)
    {
        // Only allow editing if pending approval
        if ($disposal->status_kelulusan !== 'menunggu') {
            abort(403, 'Permohonan yang telah diluluskan atau ditolak tidak boleh diedit.');
        }

        $assets = Asset::with('masjidSurau')->get();

        return view('admin.disposals.edit', compact('disposal', 'assets'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Disposal $disposal)
    {
        // Only allow editing if pending approval
        if ($disposal->status_kelulusan !== 'menunggu') {
            abort(403, 'Permohonan yang telah diluluskan atau ditolak tidak boleh diedit.');
        }

        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'sebab_pelupusan' => 'required|string',
            'kaedah_pelupusan' => 'required|string',
            'tarikh_pelupusan' => 'required|date',
            'nilai_baki' => 'nullable|numeric|min:0',
            'nilai_pelupusan' => 'nullable|numeric|min:0',
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
        $disposal->delete();

        return redirect()->route('admin.disposals.index')
            ->with('success', 'Rekod pelupusan berjaya dipadamkan.');
    }

    /**
     * Approve disposal request (Admin only)
     */
    public function approve(Disposal $disposal)
    {
        $disposal->update([
            'status_kelulusan' => 'diluluskan',
            'tarikh_kelulusan' => now(),
            'diluluskan_oleh' => Auth::id()
        ]);

        return redirect()->route('admin.disposals.show', $disposal)
            ->with('success', 'Permohonan pelupusan telah diluluskan.');
    }

    /**
     * Reject disposal request (Admin only)
     */
    public function reject(Request $request, Disposal $disposal)
    {
        $request->validate([
            'sebab_penolakan' => 'required|string'
        ]);

        $disposal->update([
            'status_kelulusan' => 'ditolak',
            'tarikh_kelulusan' => now(),
            'diluluskan_oleh' => Auth::id(),
            'sebab_penolakan' => $request->sebab_penolakan
        ]);

        return redirect()->route('admin.disposals.show', $disposal)
            ->with('success', 'Permohonan pelupusan telah ditolak.');
    }
}
