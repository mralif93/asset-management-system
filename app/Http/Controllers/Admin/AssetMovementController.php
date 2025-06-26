<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AssetMovement;
use App\Models\Asset;
use App\Models\MasjidSurau;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssetMovementController extends Controller
{
    /**
     * lihatSenaraiPergerakanPinjaman(): Display list of all asset movement and loan records
     */
    public function index()
    {
        $query = AssetMovement::with([
            'asset', 
            'asset.masjidSurau',
            'masjidSurauAsal',
            'masjidSurauDestinasi',
            'approvedByAsal',
            'approvedByDestinasi'
        ]);
        
        // Apply filters
        if (request()->filled('search')) {
            $search = request('search');
            $query->whereHas('asset', function($q) use ($search) {
                $q->where('nama_aset', 'like', "%{$search}%")
                  ->orWhere('no_siri_pendaftaran', 'like', "%{$search}%");
            });
        }

        if (request()->filled('status')) {
            $query->where('status_pergerakan', request('status'));
        }

        if (request()->filled('jenis_pergerakan')) {
            $query->where('jenis_pergerakan', request('jenis_pergerakan'));
        }

        if (request()->filled('masjid_surau_asal_id')) {
            $query->where('masjid_surau_asal_id', request('masjid_surau_asal_id'));
        }

        if (request()->filled('masjid_surau_destinasi_id')) {
            $query->where('masjid_surau_destinasi_id', request('masjid_surau_destinasi_id'));
        }

        $assetMovements = $query->latest()->paginate(15)->withQueryString();
        $masjidSuraus = MasjidSurau::orderBy('nama')->get();

        return view('admin.asset-movements.index', compact('assetMovements', 'masjidSuraus'));
    }

    /**
     * borangMohonPergerakanPinjaman(): Display form interface for users to apply for asset movement/loan
     */
    public function create()
    {
        $assets = Asset::with('masjidSurau')->get();
        $masjidSuraus = MasjidSurau::orderBy('nama')->get();
        
        return view('admin.asset-movements.create', compact('assets', 'masjidSuraus'));
    }

    /**
     * simpanPermohonanPergerakanPinjaman(): Process and save asset movement/loan application details
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'jenis_pergerakan' => 'required|in:Pemindahan,Peminjaman,Pulangan',
            'masjid_surau_asal_id' => 'required|exists:masjid_surau,id',
            'masjid_surau_destinasi_id' => 'required|exists:masjid_surau,id|different:masjid_surau_asal_id',
            'lokasi_asal' => 'required|string|max:255',
            'lokasi_destinasi' => 'required|string|max:255',
            'lokasi_terperinci_asal' => 'required|string|max:255',
            'lokasi_terperinci_destinasi' => 'required|string|max:255',
            'tarikh_permohonan' => 'required|date',
            'tarikh_pergerakan' => 'required|date|after_or_equal:tarikh_permohonan',
            'tarikh_jangka_pulangan' => 'nullable|date|after:tarikh_pergerakan',
            'nama_peminjam_pegawai_bertanggungjawab' => 'required|string|max:255',
            'sebab_pergerakan' => 'required|string',
            'catatan_pergerakan' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status_pergerakan'] = 'menunggu_kelulusan';
        $validated['status_kelulusan_asal'] = 'menunggu';
        $validated['status_kelulusan_destinasi'] = 'menunggu';

        $assetMovement = AssetMovement::create($validated);

        return redirect()
            ->route('admin.asset-movements.show', $assetMovement)
            ->with('success', 'Pergerakan aset berjaya didaftarkan dan sedang menunggu kelulusan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AssetMovement $assetMovement)
    {
        $assetMovement->load([
            'asset',
            'asset.masjidSurau',
            'masjidSurauAsal',
            'masjidSurauDestinasi',
            'approvedByAsal',
            'approvedByDestinasi'
        ]);

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
        $masjidSuraus = MasjidSurau::orderBy('nama')->get();
        
        return view('admin.asset-movements.edit', compact('assetMovement', 'assets', 'masjidSuraus'));
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
            'jenis_pergerakan' => 'required|in:Pemindahan,Peminjaman,Pulangan',
            'masjid_surau_asal_id' => 'required|exists:masjid_surau,id',
            'masjid_surau_destinasi_id' => 'required|exists:masjid_surau,id|different:masjid_surau_asal_id',
            'lokasi_asal' => 'required|string|max:255',
            'lokasi_destinasi' => 'required|string|max:255',
            'lokasi_terperinci_asal' => 'required|string|max:255',
            'lokasi_terperinci_destinasi' => 'required|string|max:255',
            'tarikh_permohonan' => 'required|date',
            'tarikh_pergerakan' => 'required|date|after_or_equal:tarikh_permohonan',
            'tarikh_jangka_pulangan' => 'nullable|date|after:tarikh_pergerakan',
            'nama_peminjam_pegawai_bertanggungjawab' => 'required|string|max:255',
            'sebab_pergerakan' => 'required|string',
            'catatan_pergerakan' => 'nullable|string',
        ]);

        // Reset approval status if key fields are changed
        if ($assetMovement->masjid_surau_asal_id != $validated['masjid_surau_asal_id']) {
            $validated['status_kelulusan_asal'] = 'menunggu';
            $validated['diluluskan_oleh_asal'] = null;
            $validated['tarikh_kelulusan_asal'] = null;
        }

        if ($assetMovement->masjid_surau_destinasi_id != $validated['masjid_surau_destinasi_id']) {
            $validated['status_kelulusan_destinasi'] = 'menunggu';
            $validated['diluluskan_oleh_destinasi'] = null;
            $validated['tarikh_kelulusan_destinasi'] = null;
        }

        $assetMovement->update($validated);

        return redirect()
            ->route('admin.asset-movements.show', $assetMovement)
            ->with('success', 'Pergerakan aset berjaya dikemaskini.');
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
    public function approve(Request $request, AssetMovement $assetMovement)
    {
        $user = auth()->user();
        $type = $request->input('type', 'asal');
        $status = $request->input('status', 'diluluskan');
        $catatan = $request->input('catatan');

        if ($type === 'asal') {
            $assetMovement->update([
                'status_kelulusan_asal' => $status,
                'diluluskan_oleh_asal' => $user->id,
                'tarikh_kelulusan_asal' => now(),
                'catatan_kelulusan_asal' => $catatan,
            ]);
        } else {
            $assetMovement->update([
                'status_kelulusan_destinasi' => $status,
                'diluluskan_oleh_destinasi' => $user->id,
                'tarikh_kelulusan_destinasi' => now(),
                'catatan_kelulusan_destinasi' => $catatan,
            ]);
        }

        // Update overall status if both approvals are complete
        if ($assetMovement->status_kelulusan_asal === 'diluluskan' && 
            $assetMovement->status_kelulusan_destinasi === 'diluluskan') {
            $assetMovement->update(['status_pergerakan' => 'diluluskan']);
        } elseif ($assetMovement->status_kelulusan_asal === 'ditolak' || 
                  $assetMovement->status_kelulusan_destinasi === 'ditolak') {
            $assetMovement->update(['status_pergerakan' => 'ditolak']);
        }

        return redirect()
            ->route('admin.asset-movements.show', $assetMovement)
            ->with('success', 'Status kelulusan pergerakan aset berjaya dikemaskini.');
    }

    /**
     * tolakPermohonanPergerakanPinjaman(id): Reject asset movement/loan application by authority
     */
    public function reject(Request $request, AssetMovement $assetMovement)
    {
        $request->validate([
            'sebab_penolakan' => 'required|string',
            'approval_type' => 'required|in:asal,destinasi'
        ]);

        $user = Auth::user();
        $approvalType = $request->input('approval_type');

        // Check if user has authority in the respective masjid/surau
        if ($approvalType === 'asal' && $user->masjid_surau_id !== $assetMovement->masjid_surau_asal_id) {
            abort(403, 'Anda tidak mempunyai kebenaran untuk menolak dari lokasi asal.');
        }
        if ($approvalType === 'destinasi' && $user->masjid_surau_id !== $assetMovement->masjid_surau_destinasi_id) {
            abort(403, 'Anda tidak mempunyai kebenaran untuk menolak dari lokasi destinasi.');
        }

        // Update rejection status
        if ($approvalType === 'asal') {
            $assetMovement->update([
                'status_kelulusan_asal' => 'ditolak',
                'diluluskan_oleh_asal' => $user->id,
                'tarikh_kelulusan_asal' => now()
            ]);
        } else {
            $assetMovement->update([
                'status_kelulusan_destinasi' => 'ditolak',
                'diluluskan_oleh_destinasi' => $user->id,
                'tarikh_kelulusan_destinasi' => now()
            ]);
        }

        // If either location rejects, the whole movement is rejected
        $assetMovement->update([
            'status_pergerakan' => 'ditolak',
            'tarikh_kelulusan' => now(),
            'sebab_penolakan' => $request->sebab_penolakan
        ]);

        return redirect()->route('admin.asset-movements.show', $assetMovement)
                        ->with('success', 'Pergerakan aset telah ditolak.');
    }

    /**
     * rekodPulanganAset(id): Record return of borrowed or transferred assets
     */
    public function recordReturn(Request $request, AssetMovement $assetMovement)
    {
        if ($assetMovement->status_pergerakan !== 'diluluskan') {
            abort(403, 'Hanya pergerakan yang diluluskan boleh dikembalikan.');
        }

        $validated = $request->validate([
            'tarikh_pulang_sebenar' => 'required|date',
            'catatan_pergerakan' => 'nullable|string'
        ]);

        $assetMovement->update([
            'status_pergerakan' => 'selesai',
            'tarikh_pulang_sebenar' => $validated['tarikh_pulang_sebenar'],
            'catatan_pergerakan' => $validated['catatan_pergerakan'],
            'tarikh_kepulangan' => now()
        ]);

        // Update asset location back to original
        $assetMovement->asset->update([
            'lokasi_penempatan' => $assetMovement->lokasi_asal,
            'masjid_surau_id' => $assetMovement->masjid_surau_asal_id
        ]);

        return redirect()->route('admin.asset-movements.show', $assetMovement)
                        ->with('success', 'Kepulangan aset telah direkodkan.');
    }
}
