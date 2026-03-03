<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AssetMovement;
use App\Models\Asset;
use App\Models\MasjidSurau;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAssetRequestController extends Controller
{
    /**
     * Display a listing of the user's asset requests.
     */
    public function index()
    {
        $user = Auth::user();

        $requests = AssetMovement::with(['asset', 'masjidSurauDestinasi'])
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(15);

        return view('user.asset-requests.index', compact('requests'));
    }

    /**
     * Show the form for creating a new request.
     */
    public function create()
    {
        $user = Auth::user();

        // Only load assets belonging to the user's masjid_surau_id
        $assets = Asset::with('masjidSurau')
            ->where('masjid_surau_id', $user->masjid_surau_id)
            ->where('status_aset', 'Aktif')
            ->get();

        $masjidSuraus = MasjidSurau::orderBy('nama')->get();
        $validLocations = \App\Helpers\SystemData::getValidLocations();

        return view('user.asset-requests.create', compact('assets', 'masjidSuraus', 'validLocations'));
    }

    /**
     * Store a newly created request in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'asset_id' => [
                'required',
                'exists:assets,id',
                function ($attribute, $value, $fail) use ($user) {
                    $asset = Asset::find($value);
                    if ($asset && $asset->masjid_surau_id !== $user->masjid_surau_id) {
                        $fail('Anda hanya boleh memohon pergerakan untuk aset dari lokasi anda.');
                    }
                }
            ],
            'jenis_pergerakan' => 'required|in:Pemindahan,Peminjaman,Pulangan',
            'destination_masjid_surau_id' => 'required|exists:masjid_surau,id',
            'lokasi_destinasi_spesifik' => 'required|string|max:255',
            'tujuan_pergerakan' => 'required|string|max:1000',
            'tarikh_jangka_pulang' => 'nullable|date|after_or_equal:today',
        ]);

        $asset = Asset::find($validated['asset_id']);

        AssetMovement::create([
            'asset_id' => $asset->id,
            'user_id' => $user->id,
            'origin_masjid_surau_id' => $user->masjid_surau_id,
            'destination_masjid_surau_id' => $validated['destination_masjid_surau_id'],
            'tarikh_permohonan' => now(),
            'jenis_pergerakan' => $validated['jenis_pergerakan'],
            'lokasi_asal_spesifik' => $asset->lokasi_penempatan ?? 'Tidak Dinyatakan',
            'lokasi_destinasi_spesifik' => $validated['lokasi_destinasi_spesifik'],
            'nama_peminjam_pegawai_bertanggungjawab' => $user->name,
            'tujuan_pergerakan' => $validated['tujuan_pergerakan'],
            'tarikh_jangka_pulang' => $validated['tarikh_jangka_pulang'] ?? null,
            'status_pergerakan' => 'Dimohon',
        ]);

        return redirect()->route('user.asset-requests.index')
            ->with('success', 'Permohonan pergerakan aset berjaya dihantar.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AssetMovement $assetRequest)
    {
        if ($assetRequest->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        $assetRequest->load(['asset', 'masjidSurauAsal', 'masjidSurauDestinasi']);

        return view('user.asset-requests.show', compact('assetRequest'));
    }

    /**
     * Remove the specified resource from storage (Withdraw request).
     */
    public function destroy(AssetMovement $assetRequest)
    {
        if ($assetRequest->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        if ($assetRequest->status_pergerakan !== 'Dimohon') {
            return back()->with('error', 'Hanya permohonan berstatus "Dimohon" yang boleh dibatalkan.');
        }

        $assetRequest->delete();

        return redirect()->route('user.asset-requests.index')
            ->with('success', 'Permohonan berjaya dibatalkan.');
    }
}
