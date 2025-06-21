<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ImmovableAsset;
use App\Models\MasjidSurau;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImmovableAssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ImmovableAsset::with('masjidSurau');
        
        // Filter by masjid/surau if user is not admin
        if (Auth::user()->role !== 'admin') {
            $query->where('masjid_surau_id', Auth::user()->masjid_surau_id);
        }

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama_aset', 'like', "%{$searchTerm}%")
                  ->orWhere('alamat', 'like', "%{$searchTerm}%")
                  ->orWhere('no_hakmilik', 'like', "%{$searchTerm}%")
                  ->orWhere('no_lot', 'like', "%{$searchTerm}%");
            });
        }

        // Filter by asset type
        if ($request->filled('jenis_aset')) {
            $query->where('jenis_aset', $request->jenis_aset);
        }

        // Filter by condition
        if ($request->filled('keadaan_semasa')) {
            $query->where('keadaan_semasa', $request->keadaan_semasa);
        }

        $immovableAssets = $query->latest()->paginate(15);
        
        // Preserve query parameters in pagination
        $immovableAssets->appends($request->query());

        return view('admin.immovable-assets.index', compact('immovableAssets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $masjidSuraus = MasjidSurau::all();
        
        return view('admin.immovable-assets.create', compact('masjidSuraus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'masjid_surau_id' => 'required|exists:masjid_surau,id',
            'nama_aset' => 'required|string|max:255',
            'jenis_aset' => 'required|string',
            'alamat' => 'nullable|string',
            'no_hakmilik' => 'nullable|string|max:255',
            'no_lot' => 'nullable|string|max:255',
            'luas_tanah_bangunan' => 'required|numeric|min:0',
            'tarikh_perolehan' => 'required|date',
            'sumber_perolehan' => 'required|string',
            'kos_perolehan' => 'required|numeric|min:0',
            'keadaan_semasa' => 'required|string',
            'catatan' => 'nullable|string',
            'gambar_aset' => 'nullable|array',
            'gambar_aset.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Set masjid_surau_id based on user role
        if (Auth::user()->role !== 'admin') {
            $validated['masjid_surau_id'] = Auth::user()->masjid_surau_id;
        }

        // Handle image uploads
        if ($request->hasFile('gambar_aset')) {
            $images = [];
            foreach ($request->file('gambar_aset') as $image) {
                $path = $image->store('immovable-assets', 'public');
                $images[] = $path;
            }
            $validated['gambar_aset'] = $images;
        }

        $immovableAsset = ImmovableAsset::create($validated);

        return redirect()->route('admin.immovable-assets.show', $immovableAsset)
                        ->with('success', 'Aset tak alih berjaya didaftarkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ImmovableAsset $immovableAsset)
    {
        $immovableAsset->load('masjidSurau');
        
        return view('admin.immovable-assets.show', compact('immovableAsset'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ImmovableAsset $immovableAsset)
    {
        $masjidSuraus = MasjidSurau::all();
        
        return view('admin.immovable-assets.edit', compact('immovableAsset', 'masjidSuraus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ImmovableAsset $immovableAsset)
    {
        $validated = $request->validate([
            'nama_aset' => 'required|string|max:255',
            'jenis_aset' => 'required|string',
            'alamat' => 'nullable|string',
            'no_hakmilik' => 'nullable|string|max:255',
            'no_lot' => 'nullable|string|max:255',
            'luas_tanah_bangunan' => 'required|numeric|min:0',
            'tarikh_perolehan' => 'required|date',
            'sumber_perolehan' => 'required|string',
            'kos_perolehan' => 'required|numeric|min:0',
            'keadaan_semasa' => 'required|string',
            'catatan' => 'nullable|string',
            'gambar_aset' => 'nullable|array',
            'gambar_aset.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Handle image uploads
        if ($request->hasFile('gambar_aset')) {
            $images = $immovableAsset->gambar_aset ?? [];
            foreach ($request->file('gambar_aset') as $image) {
                $path = $image->store('immovable-assets', 'public');
                $images[] = $path;
            }
            $validated['gambar_aset'] = $images;
        }

        $immovableAsset->update($validated);

        return redirect()->route('admin.immovable-assets.show', $immovableAsset)
                        ->with('success', 'Butiran aset tak alih berjaya dikemaskini.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ImmovableAsset $immovableAsset)
    {
        // Only admin can delete immovable assets
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $immovableAsset->delete();

        return redirect()->route('admin.immovable-assets.index')
                        ->with('success', 'Rekod aset tak alih berjaya dipadamkan.');
    }
}
