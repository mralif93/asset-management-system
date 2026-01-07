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
            $query->whereHas('asset', function ($q) use ($search) {
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
        $validLocations = \App\Helpers\SystemData::getValidLocations();

        return view('admin.asset-movements.create', compact('assets', 'masjidSuraus', 'validLocations'));
    }

    /**
     * simpanPermohonanPergerakanPinjaman(): Process and save asset movement/loan application details
     */
    public function store(Request $request)
    {
        $request->merge(['tarikh_permohonan' => now()->toDateString()]);

        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'jenis_pergerakan' => 'required|in:Pemindahan,Peminjaman,Pulangan',
            'origin_masjid_surau_id' => 'required|exists:masjid_surau,id',
            'destination_masjid_surau_id' => 'required|exists:masjid_surau,id|different:origin_masjid_surau_id',
            'lokasi_asal_spesifik' => 'required|string|max:255',
            'lokasi_destinasi_spesifik' => 'required|string|max:255',
            'tarikh_permohonan' => 'required|date',
            'tarikh_pergerakan' => 'required|date|after_or_equal:tarikh_permohonan',
            'tarikh_jangka_pulang' => 'nullable|date|after:tarikh_pergerakan',
            'nama_peminjam_pegawai_bertanggungjawab' => 'required|string|max:255',
            'tujuan_pergerakan' => 'required|string',
            'kuantiti' => 'required|integer|min:1',
            'catatan' => 'nullable|string',
            'pembekal' => 'nullable|string|max:255',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status_pergerakan'] = 'menunggu_kelulusan';

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
        $validLocations = \App\Helpers\SystemData::getValidLocations();

        return view('admin.asset-movements.edit', compact('assetMovement', 'assets', 'masjidSuraus', 'validLocations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AssetMovement $assetMovement)
    {
        if ($assetMovement->status_pergerakan !== 'menunggu_kelulusan') {
            abort(403, 'Pergerakan yang telah diluluskan tidak boleh diedit.');
        }

        if (!$request->has('tarikh_permohonan')) {
            $request->merge(['tarikh_permohonan' => $assetMovement->tarikh_permohonan ? $assetMovement->tarikh_permohonan->format('Y-m-d') : now()->toDateString()]);
        }

        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'jenis_pergerakan' => 'required|in:Pemindahan,Peminjaman,Pulangan',
            'origin_masjid_surau_id' => 'required|exists:masjid_surau,id',
            'destination_masjid_surau_id' => 'required|exists:masjid_surau,id|different:origin_masjid_surau_id',
            'lokasi_asal_spesifik' => 'required|string|max:255',
            'lokasi_destinasi_spesifik' => 'required|string|max:255',
            'tarikh_permohonan' => 'required|date',
            'tarikh_pergerakan' => 'required|date|after_or_equal:tarikh_permohonan',
            'tarikh_jangka_pulang' => 'nullable|date|after:tarikh_pergerakan',
            'nama_peminjam_pegawai_bertanggungjawab' => 'required|string|max:255',
            'tujuan_pergerakan' => 'required|string',
            'kuantiti' => 'required|integer|min:1',
            'catatan' => 'nullable|string',
            'pembekal' => 'nullable|string|max:255',
        ]);

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
        $catatan = $request->input('catatan');

        $assetMovement->update([
            'status_pergerakan' => 'diluluskan',
            'pegawai_meluluskan' => $user->name,
            'catatan' => $catatan ? $assetMovement->catatan . "\n[Lulus]: " . $catatan : $assetMovement->catatan,
        ]);

        return redirect()
            ->route('admin.asset-movements.show', $assetMovement)
            ->with('success', 'Pergerakan aset telah diluluskan.');
    }

    /**
     * tolakPermohonanPergerakanPinjaman(id): Reject asset movement/loan application by authority
     */
    public function reject(Request $request, AssetMovement $assetMovement)
    {
        $validated = $request->validate([
            'catatan' => 'required|string',
        ]);

        $user = Auth::user();

        // Optional: Ensure user is authorized based on masjid/surau if strict checking is needed
        // For now, allow authorized admins to reject.

        $assetMovement->update([
            'status_pergerakan' => 'ditolak',
            'pegawai_meluluskan' => $user->name, // Storing who rejected it
            'catatan' => $assetMovement->catatan . "\n[Ditolak]: " . $validated['catatan'],
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
            'catatan' => 'nullable|string'
        ]);

        $assetMovement->update([
            'status_pergerakan' => 'Pulangan', // Or 'selesai' if that's preferred, but 'Pulangan' is a type. Let's use 'selesai' to indicate completed return if that's the status flow.
            // Wait, migration schema allows string status. Previous code used 'selesai'. Let's stick to 'selesai' (completed).
            // Actually, in `index.blade.php`, we only filtered for 'menunggu_kelulusan', 'diluluskan', 'ditolak'.
            // If I set it to 'selesai', it might disappear from some filters if not accounted for.
            // But 'selesai' is logical for returned items.
            // Let's use 'selesai' as status.
        ]);

        $assetMovement->update([
            'status_pergerakan' => 'selesai',
            'tarikh_pulang_sebenar' => $validated['tarikh_pulang_sebenar'],
            'catatan' => $validated['catatan'] ? $assetMovement->catatan . "\n[Pulang]: " . $validated['catatan'] : $assetMovement->catatan,
        ]);

        // Update asset location back to original
        $assetMovement->asset->update([
            // Assuming we want to return it to the origin
            'lokasi_penempatan' => $assetMovement->lokasi_asal_spesifik,
            'masjid_surau_id' => $assetMovement->origin_masjid_surau_id
        ]);

        return redirect()->route('admin.asset-movements.show', $assetMovement)
            ->with('success', 'Kepulangan aset telah direkodkan.');
    }
}
