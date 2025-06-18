<?php

namespace App\Http\Controllers;

use App\Models\AssetMovement;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssetMovementController extends Controller
{
    /**
     * lihatSenaraiPergerakanPinjaman(): Display list of all asset movement and loan records
     */
    public function index(Request $request)
    {
        $query = AssetMovement::with(['asset.masjidSurau']);
        
        // Filter by masjid/surau if user is not admin
        if (Auth::user()->role !== 'admin') {
            $query->whereHas('asset', function($q) {
                $q->where('masjid_surau_id', Auth::user()->masjid_surau_id);
            });
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status_permohonan', $request->status);
        }
        
        // Filter by movement type
        if ($request->filled('jenis')) {
            $query->where('jenis_pergerakan', $request->jenis);
        }
        
        $movements = $query->orderBy('created_at', 'desc')->paginate(15);
        
        return view('asset-movements.index', compact('movements'));
    }

    /**
     * borangMohonPergerakanPinjaman(): Display form interface for users to apply for asset movement/loan
     */
    public function create()
    {
        $query = Asset::where('status_aset', 'Sedang Digunakan');
        
        // Filter by masjid/surau if user is not admin
        if (Auth::user()->role !== 'admin') {
            $query->where('masjid_surau_id', Auth::user()->masjid_surau_id);
        }
        
        $assets = $query->get();
        
        return view('asset-movements.create', compact('assets'));
    }

    /**
     * simpanPermohonanPergerakanPinjaman(): Process and save asset movement/loan application details
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'jenis_pergerakan' => 'required|in:Pinjaman,Pemindahan,Penempatan Semula',
            'nama_pemohon' => 'required|string|max:255',
            'jawatan_pemohon' => 'required|string|max:255',
            'tujuan_pergerakan' => 'required|string',
            'lokasi_asal' => 'required|string|max:255',
            'lokasi_destinasi' => 'required|string|max:255',
            'tarikh_mula' => 'required|date|after_or_equal:today',
            'tarikh_tamat_dijangka' => 'nullable|date|after:tarikh_mula',
            'kuantiti_dipohon' => 'required|integer|min:1',
            'catatan' => 'nullable|string',
        ]);

        // Set default values
        $validated['status_permohonan'] = 'Menunggu Kelulusan';
        $validated['tarikh_permohonan'] = now();
        $validated['pemohon_user_id'] = Auth::id();
        
        $movement = AssetMovement::create($validated);

        return redirect()->route('asset-movements.show', $movement)
                        ->with('success', 'Permohonan pergerakan/pinjaman aset berjaya dihantar.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AssetMovement $assetMovement)
    {
        $assetMovement->load(['asset.masjidSurau', 'pemohon']);
        
        return view('asset-movements.show', compact('assetMovement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AssetMovement $assetMovement)
    {
        // Only allow editing if status is still pending
        if ($assetMovement->status_permohonan !== 'Menunggu Kelulusan') {
            return redirect()->route('asset-movements.show', $assetMovement)
                           ->with('error', 'Permohonan yang telah diproses tidak boleh diubah.');
        }
        
        $query = Asset::where('status_aset', 'Sedang Digunakan');
        
        if (Auth::user()->role !== 'admin') {
            $query->where('masjid_surau_id', Auth::user()->masjid_surau_id);
        }
        
        $assets = $query->get();
        
        return view('asset-movements.edit', compact('assetMovement', 'assets'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AssetMovement $assetMovement)
    {
        // Only allow updating if status is still pending
        if ($assetMovement->status_permohonan !== 'Menunggu Kelulusan') {
            return redirect()->route('asset-movements.show', $assetMovement)
                           ->with('error', 'Permohonan yang telah diproses tidak boleh diubah.');
        }
        
        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'jenis_pergerakan' => 'required|in:Pinjaman,Pemindahan,Penempatan Semula',
            'nama_pemohon' => 'required|string|max:255',
            'jawatan_pemohon' => 'required|string|max:255',
            'tujuan_pergerakan' => 'required|string',
            'lokasi_asal' => 'required|string|max:255',
            'lokasi_destinasi' => 'required|string|max:255',
            'tarikh_mula' => 'required|date|after_or_equal:today',
            'tarikh_tamat_dijangka' => 'nullable|date|after:tarikh_mula',
            'kuantiti_dipohon' => 'required|integer|min:1',
            'catatan' => 'nullable|string',
        ]);

        $assetMovement->update($validated);

        return redirect()->route('asset-movements.show', $assetMovement)
                        ->with('success', 'Permohonan berjaya dikemaskini.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AssetMovement $assetMovement)
    {
        // Only allow deletion if status is still pending
        if ($assetMovement->status_permohonan !== 'Menunggu Kelulusan') {
            return redirect()->route('asset-movements.index')
                           ->with('error', 'Permohonan yang telah diproses tidak boleh dipadamkan.');
        }
        
        $assetMovement->delete();

        return redirect()->route('asset-movements.index')
                        ->with('success', 'Permohonan berjaya dipadamkan.');
    }

    /**
     * lulusPermohonanPergerakanPinjaman(id): Approve asset movement/loan application by authorized officer
     */
    public function approve(Request $request, AssetMovement $assetMovement)
    {
        $validated = $request->validate([
            'pegawai_kelulusan' => 'required|string|max:255',
            'catatan_kelulusan' => 'nullable|string',
        ]);

        $assetMovement->update([
            'status_permohonan' => 'Diluluskan',
            'tarikh_kelulusan' => now(),
            'pegawai_kelulusan' => $validated['pegawai_kelulusan'],
            'catatan_kelulusan' => $validated['catatan_kelulusan'],
        ]);

        return redirect()->route('asset-movements.show', $assetMovement)
                        ->with('success', 'Permohonan berjaya diluluskan.');
    }

    /**
     * tolakPermohonanPergerakanPinjaman(id): Reject asset movement/loan application by authority
     */
    public function reject(Request $request, AssetMovement $assetMovement)
    {
        $validated = $request->validate([
            'pegawai_kelulusan' => 'required|string|max:255',
            'catatan_kelulusan' => 'required|string',
        ]);

        $assetMovement->update([
            'status_permohonan' => 'Ditolak',
            'tarikh_kelulusan' => now(),
            'pegawai_kelulusan' => $validated['pegawai_kelulusan'],
            'catatan_kelulusan' => $validated['catatan_kelulusan'],
        ]);

        return redirect()->route('asset-movements.show', $assetMovement)
                        ->with('success', 'Permohonan telah ditolak.');
    }

    /**
     * rekodPulanganAset(id): Record return of borrowed or transferred assets
     */
    public function recordReturn(Request $request, AssetMovement $assetMovement)
    {
        $validated = $request->validate([
            'kuantiti_dipulangkan' => 'required|integer|min:1|max:' . $assetMovement->kuantiti_dipohon,
            'tarikh_pulangan_sebenar' => 'required|date',
            'keadaan_semasa_pulangan' => 'required|string',
            'pegawai_penerima' => 'required|string|max:255',
            'catatan_pulangan' => 'nullable|string',
        ]);

        $assetMovement->update(array_merge($validated, [
            'status_permohonan' => 'Selesai',
        ]));

        return redirect()->route('asset-movements.show', $assetMovement)
                        ->with('success', 'Pulangan aset berjaya direkodkan.');
    }
}
