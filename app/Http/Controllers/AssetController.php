<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\MasjidSurau;
use App\Helpers\AssetRegistrationNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssetController extends Controller
{
    /**
     * lihatSenaraiAset(): Display complete list of all registered movable assets
     */
    public function index(Request $request)
    {
        $query = Asset::with('masjidSurau');
        
        // Filter by masjid/surau if user is not admin
        if (Auth::user()->role !== 'admin') {
            $query->where('masjid_surau_id', Auth::user()->masjid_surau_id);
        }
        
        // Filter by location if requested
        if ($request->filled('lokasi')) {
            $query->where('lokasi_penempatan', 'like', '%' . $request->lokasi . '%');
        }
        
        // Filter by asset type
        if ($request->filled('jenis_aset')) {
            $query->where('jenis_aset', $request->jenis_aset);
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status_aset', $request->status);
        }
        
        $assets = $query->paginate(15);
        
        return view('assets.index', compact('assets'));
    }

    /**
     * borangDaftarAset(): Display form interface for entering new movable asset details
     */
    public function create()
    {
        $masjidSuraus = MasjidSurau::all();
        $assetTypes = array_keys(AssetRegistrationNumber::getAssetTypeAbbreviations());
        
        return view('assets.create', compact('masjidSuraus', 'assetTypes'));
    }

    /**
     * simpanAsetBaru(): Process form data and save new movable asset record to database
     * with automatic generation of unique registration number according to SOP format
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'masjid_surau_id' => 'required|exists:masjids_suraus,id',
            'nama_aset' => 'required|string|max:255',
            'jenis_aset' => 'required|string',
            'tarikh_perolehan' => 'required|date',
            'kaedah_perolehan' => 'required|string',
            'nilai_perolehan' => 'required|numeric|min:0',
            'umur_faedah_tahunan' => 'nullable|integer|min:1',
            'susut_nilai_tahunan' => 'nullable|numeric|min:0',
            'lokasi_penempatan' => 'required|string|max:255',
            'pegawai_bertanggungjawab_lokasi' => 'required|string|max:255',
            'status_aset' => 'required|string',
            'catatan' => 'nullable|string',
            'gambar_aset' => 'nullable|array',
            'gambar_aset.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Set masjid_surau_id based on user role
        if (Auth::user()->role !== 'admin') {
            $validated['masjid_surau_id'] = Auth::user()->masjid_surau_id;
        }

        // Generate registration number
        $tarikhPerolehan = new \Carbon\Carbon($validated['tarikh_perolehan']);
        $validated['no_siri_pendaftaran'] = AssetRegistrationNumber::generate(
            $validated['masjid_surau_id'],
            $validated['jenis_aset'],
            $tarikhPerolehan->format('y')
        );

        // Handle image uploads
        if ($request->hasFile('gambar_aset')) {
            $images = [];
            foreach ($request->file('gambar_aset') as $image) {
                $path = $image->store('assets', 'public');
                $images[] = $path;
            }
            $validated['gambar_aset'] = $images;
        }

        $asset = Asset::create($validated);

        return redirect()->route('assets.show', $asset)
                        ->with('success', 'Aset baru berjaya didaftarkan dengan nombor siri: ' . $asset->no_siri_pendaftaran);
    }

    /**
     * lihatButiranAset(id): Display complete details of specific movable asset based on unique ID
     */
    public function show(Asset $asset)
    {
        $asset->load(['masjidSurau', 'movements', 'inspections', 'maintenanceRecords']);
        
        return view('assets.show', compact('asset'));
    }

    /**
     * borangEditAset(id): Display form for modifying existing movable asset details
     */
    public function edit(Asset $asset)
    {
        $masjidSuraus = MasjidSurau::all();
        $assetTypes = array_keys(AssetRegistrationNumber::getAssetTypeAbbreviations());
        
        return view('assets.edit', compact('asset', 'masjidSuraus', 'assetTypes'));
    }

    /**
     * kemaskiniAset(id): Process and save changes made to existing movable asset details
     */
    public function update(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'nama_aset' => 'required|string|max:255',
            'jenis_aset' => 'required|string',
            'tarikh_perolehan' => 'required|date',
            'kaedah_perolehan' => 'required|string',
            'nilai_perolehan' => 'required|numeric|min:0',
            'umur_faedah_tahunan' => 'nullable|integer|min:1',
            'susut_nilai_tahunan' => 'nullable|numeric|min:0',
            'lokasi_penempatan' => 'required|string|max:255',
            'pegawai_bertanggungjawab_lokasi' => 'required|string|max:255',
            'status_aset' => 'required|string',
            'catatan' => 'nullable|string',
            'gambar_aset' => 'nullable|array',
            'gambar_aset.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Handle image uploads
        if ($request->hasFile('gambar_aset')) {
            $images = $asset->gambar_aset ?? [];
            foreach ($request->file('gambar_aset') as $image) {
                $path = $image->store('assets', 'public');
                $images[] = $path;
            }
            $validated['gambar_aset'] = $images;
        }

        $asset->update($validated);

        return redirect()->route('assets.show', $asset)
                        ->with('success', 'Butiran aset berjaya dikemaskini.');
    }

    /**
     * padamAset(id): Permanently delete movable asset record from system
     */
    public function destroy(Asset $asset)
    {
        $asset->delete();

        return redirect()->route('assets.index')
                        ->with('success', 'Rekod aset berjaya dipadamkan.');
    }

    /**
     * lihatAsetMengikutLokasi(lokasi): Filter and display list of movable assets by specific location
     */
    public function byLocation(Request $request)
    {
        $lokasi = $request->get('lokasi');
        
        $query = Asset::with('masjidSurau')
                     ->where('lokasi_penempatan', 'like', '%' . $lokasi . '%');
        
        // Filter by masjid/surau if user is not admin
        if (Auth::user()->role !== 'admin') {
            $query->where('masjid_surau_id', Auth::user()->masjid_surau_id);
        }
        
        $assets = $query->get();
        
        return view('assets.by-location', compact('assets', 'lokasi'));
    }

    /**
     * kemaskiniLokasiAset(id, lokasiBaru): Update asset location in system record when physical change occurs
     */
    public function updateLocation(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'lokasi_penempatan' => 'required|string|max:255',
            'pegawai_bertanggungjawab_lokasi' => 'required|string|max:255',
        ]);

        $asset->update($validated);

        return redirect()->route('assets.show', $asset)
                        ->with('success', 'Lokasi aset berjaya dikemaskini.');
    }
}
