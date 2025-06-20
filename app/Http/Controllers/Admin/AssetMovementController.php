<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AssetMovement;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssetMovementController extends Controller
{
    /**
     * lihatSenaraiPergerakanPinjaman(): Display list of all asset movement and loan records
     */
    public function index()
    {
        $query = AssetMovement::with(['asset', 'asset.masjidSurau']);
        
        $assetMovements = $query->latest()->paginate(15);
        
        return view('admin.asset-movements.index', compact('assetMovements'));
    }

    /**
     * borangMohonPergerakanPinjaman(): Display form interface for users to apply for asset movement/loan
     */
    public function create()
    {
        $assets = Asset::with('masjidSurau')->get();
        
        return view('admin.asset-movements.create', compact('assets'));
    }

    /**
     * simpanPermohonanPergerakanPinjaman(): Process and save asset movement/loan application details
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'jenis_pergerakan' => 'required|string',
            'lokasi_asal' => 'required|string|max:255',
            'lokasi_destinasi' => 'required|string|max:255',
            'tarikh_pergerakan' => 'required|date',
            'sebab_pergerakan' => 'required|string',
            'catatan_pergerakan' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status_pergerakan'] = 'menunggu_kelulusan';

        $assetMovement = AssetMovement::create($validated);

        return redirect()->route('admin.asset-movements.show', $assetMovement)
                        ->with('success', 'Permohonan pergerakan aset berjaya dihantar.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AssetMovement $assetMovement)
    {
        $assetMovement->load(['asset', 'asset.masjidSurau', 'user']);
        
        return view('admin.asset-movements.show', compact('assetMovement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AssetMovement $assetMovement)
    {
        if ($assetMovement->status_pergerakan !== 'menunggu_kelulusan') {
            abort(403, 'Pergerakan yang telah diluluskan tidak boleh diedit.');
        }

        $assets = Asset::with('masjidSurau')->get();
        
        return view('admin.asset-movements.edit', compact('assetMovement', 'assets'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AssetMovement $assetMovement)
    {
        if ($assetMovement->status_pergerakan !== 'menunggu_kelulusan') {
            abort(403, 'Pergerakan yang telah diluluskan tidak boleh diedit.');
        }

        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'jenis_pergerakan' => 'required|string',
            'lokasi_asal' => 'required|string|max:255',
            'lokasi_destinasi' => 'required|string|max:255',
            'tarikh_pergerakan' => 'required|date',
            'sebab_pergerakan' => 'required|string',
            'catatan_pergerakan' => 'nullable|string',
        ]);

        $assetMovement->update($validated);

        return redirect()->route('admin.asset-movements.show', $assetMovement)
                        ->with('success', 'Permohonan pergerakan aset berjaya dikemaskini.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AssetMovement $assetMovement)
    {
        $assetMovement->delete();

        return redirect()->route('admin.asset-movements.index')
                        ->with('success', 'Rekod pergerakan aset berjaya dipadamkan.');
    }

    /**
     * lulusPermohonanPergerakanPinjaman(id): Approve asset movement/loan application by authorized officer
     */
    public function approve(AssetMovement $assetMovement)
    {
        $assetMovement->update([
            'status_pergerakan' => 'diluluskan',
            'tarikh_kelulusan' => now(),
            'diluluskan_oleh' => Auth::id()
        ]);

        // Update asset location
        $assetMovement->asset->update([
            'lokasi_penempatan' => $assetMovement->lokasi_destinasi
        ]);

        return redirect()->route('admin.asset-movements.show', $assetMovement)
                        ->with('success', 'Pergerakan aset telah diluluskan.');
    }

    /**
     * tolakPermohonanPergerakanPinjaman(id): Reject asset movement/loan application by authority
     */
    public function reject(Request $request, AssetMovement $assetMovement)
    {
        $request->validate([
            'sebab_penolakan' => 'required|string'
        ]);

        $assetMovement->update([
            'status_pergerakan' => 'ditolak',
            'tarikh_kelulusan' => now(),
            'diluluskan_oleh' => Auth::id(),
            'sebab_penolakan' => $request->sebab_penolakan
        ]);

        return redirect()->route('admin.asset-movements.show', $assetMovement)
                        ->with('success', 'Pergerakan aset telah ditolak.');
    }

    /**
     * rekodPulanganAset(id): Record return of borrowed or transferred assets
     */
    public function recordReturn(AssetMovement $assetMovement)
    {
        if ($assetMovement->status_pergerakan !== 'diluluskan') {
            abort(403, 'Hanya pergerakan yang diluluskan boleh dikembalikan.');
        }

        $assetMovement->update([
            'tarikh_kepulangan' => now()
        ]);

        // Update asset location back to original
        $assetMovement->asset->update([
            'lokasi_penempatan' => $assetMovement->lokasi_asal
        ]);

        return redirect()->route('admin.asset-movements.show', $assetMovement)
                        ->with('success', 'Kepulangan aset telah direkodkan.');
    }
}
