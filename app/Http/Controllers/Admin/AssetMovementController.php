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
     * Export asset movements to Excel
     */
    public function export(Request $request)
    {
        $filename = 'asset_movements_export_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\AssetMovementExport($request), $filename);
    }

    /**
     * borangMohonPergerakanPinjaman(): Display form interface for users to apply for asset movement/loan
     */
    public function create()
    {
        $assets = Asset::with('masjidSurau')
            ->withCount('batchSiblings')
            ->where(function ($q) {
                $q->whereNull('batch_id')
                    ->orWhereIn('id', function ($sub) {
                        $sub->selectRaw('MIN(id)')
                            ->from('assets')
                            ->whereNotNull('batch_id')
                            ->groupBy('batch_id');
                    });
            })
            ->get();
        $masjidSuraus = MasjidSurau::orderBy('nama')->get();
        $validLocations = \App\Helpers\SystemData::getValidLocations();


        $defaultMasjid = MasjidSurau::where('nama', 'like', '%Al-Hidayah%')
            ->where('nama', 'like', '%Taman Melawati%')
            ->first();
        $default_masjid_surau_id = $defaultMasjid ? $defaultMasjid->id : null;

        // Ensure "Lain-lain" exists for destination default
        $lainLain = MasjidSurau::firstOrCreate(
            ['nama' => 'Lain-lain'],
            [
                'jenis' => 'Surau', // Valid enum value required
                'alamat_baris_1' => '-',
                'daerah' => 'Lain-lain',
                'status' => 'Aktif'
            ]
        );
        $default_destination_masjid_id = $lainLain->id;

        // Refresh list to include new item if it was just created
        if ($masjidSuraus->where('id', $lainLain->id)->isEmpty()) {
            $masjidSuraus->push($lainLain);
            $masjidSuraus = $masjidSuraus->sortBy('nama');
        }

        // Calculate available quantity for each asset considering pending movements
        foreach ($assets as $asset) {
            if ($asset->batch_id) {
                // Use the helper to get accurate count subtracting pending moves
                $asset->available_quantity = \App\Helpers\BatchHelper::getAvailableQuantity(
                    $asset->batch_id,
                    $asset->masjid_surau_id
                );
            } else {
                // For single assets, check if it has pending movement
                $hasPending = $asset->assetMovements()
                    ->where('status_pergerakan', 'menunggu_kelulusan')
                    ->exists();
                $asset->available_quantity = $hasPending ? 0 : 1;
            }
        }

        // Filter out assets with 0 quantity if desired, or keep them disabled in view
        // For now, we keep them but the view should handle 0.

        return view('admin.asset-movements.create', compact('assets', 'masjidSuraus', 'validLocations', 'default_masjid_surau_id', 'default_destination_masjid_id'));
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
            'pegawai_bertanggungjawab_signature' => 'required|string',
            'disediakan_oleh_jawatan' => 'required|string|max:255',
            'disediakan_oleh_tarikh' => 'required|date',
            'disahkan_oleh_signature' => 'nullable|string',
            'disahkan_oleh_nama' => 'nullable|string|max:255',
            'disahkan_oleh_jawatan' => 'nullable|string|max:255',
            'disahkan_oleh_tarikh' => 'nullable|date',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status_pergerakan'] = 'menunggu_kelulusan';

        $quantity = (int) $validated['kuantiti'];
        $selectedAsset = Asset::find($validated['asset_id']);
        $movementIds = [];

        if ($quantity > 1 && $selectedAsset) {
            // Bulk Logic
            $assetsToMove = collect([$selectedAsset]);

            if ($selectedAsset->batch_id) {
                // Find Available Siblings in same original location
                $siblings = Asset::where('batch_id', $selectedAsset->batch_id)
                    ->where('id', '!=', $selectedAsset->id)
                    ->where('masjid_surau_id', $validated['origin_masjid_surau_id'])
                    ->limit($quantity - 1)
                    ->get();

                $assetsToMove = $assetsToMove->merge($siblings);
            }

            foreach ($assetsToMove as $asset) {
                $data = $validated;
                $data['asset_id'] = $asset->id;
                $data['kuantiti'] = 1; // Force 1 per record for strict serial tracking
                $movement = AssetMovement::create($data);
                $movementIds[] = $movement->id;
            }
        } else {
            // Single Logic
            // Force kuantiti = 1 to ensure data integrity
            $validated['kuantiti'] = 1;
            $movement = AssetMovement::create($validated);
            $movementIds[] = $movement->id;
        }

        if (count($movementIds) > 1) {
            return redirect()->route('admin.asset-movements.index')
                ->with('success', count($movementIds) . ' pergerakan aset berjaya didaftarkan secara berkelompok.');
        }

        return redirect()
            ->route('admin.asset-movements.show', $movementIds[0])
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

        // Load the count for the specific asset attached to the movement
        $assetMovement->asset->loadCount('batchSiblings');

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
            'pegawai_bertanggungjawab_signature' => 'nullable|string',
            'disediakan_oleh_jawatan' => 'nullable|string|max:255',
            'disediakan_oleh_tarikh' => 'nullable|date',
            'disahkan_oleh_signature' => 'nullable|string',
            'disahkan_oleh_nama' => 'nullable|string|max:255',
            'disahkan_oleh_jawatan' => 'nullable|string|max:255',
            'disahkan_oleh_tarikh' => 'nullable|date',
        ]);

        if (empty($validated['pegawai_bertanggungjawab_signature'])) {
            unset($validated['pegawai_bertanggungjawab_signature']);
        }
        if (empty($validated['disahkan_oleh_signature'])) {
            unset($validated['disahkan_oleh_signature']);
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
     * showReturnForm(id): Display form for returning a borrowed asset
     */
    public function showReturnForm(AssetMovement $assetMovement)
    {
        if ($assetMovement->status_pergerakan !== 'diluluskan') {
            abort(403, 'Hanya pergerakan yang diluluskan boleh dikembalikan.');
        }

        $assetMovement->load(['asset', 'masjidSurauAsal', 'masjidSurauDestinasi']);

        return view('admin.asset-movements.return', compact('assetMovement'));
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
            'catatan' => 'nullable|string',
            'tandatangan_penerima' => 'required|string',
            'tandatangan_pemulangan' => 'required|string',
        ]);

        $assetMovement->update([
            'status_pergerakan' => 'dipulangkan',
            'tarikh_pulang_sebenar' => $validated['tarikh_pulang_sebenar'],
            'catatan' => $validated['catatan'] ? $assetMovement->catatan . "\n\n[Pulangan]: " . $validated['catatan'] : $assetMovement->catatan,
            'tandatangan_penerima' => $validated['tandatangan_penerima'],
            'tandatangan_pemulangan' => $validated['tandatangan_pemulangan'],
        ]);

        // Update asset location back to original
        $assetMovement->asset->update([
            'lokasi_penempatan' => $assetMovement->lokasi_asal_spesifik,
            'masjid_surau_id' => $assetMovement->origin_masjid_surau_id
        ]);

        return redirect()->route('admin.asset-movements.show', $assetMovement)
            ->with('success', 'Kepulangan aset telah direkodkan.');
    }
}
