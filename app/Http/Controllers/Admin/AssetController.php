<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        
        // Admin can see all assets
        
        // Filter by location if requested
        if ($request->filled('lokasi')) {
            $query->where('lokasi_penempatan', 'like', '%' . $request->lokasi . '%');
        }
        
        // Filter by asset type
        if ($request->filled('jenis_aset')) {
            $query->where('jenis_aset', $request->jenis_aset);
        }
        
        // Filter by type of asset
        if ($request->filled('kategori_aset')) {
            $query->where('kategori_aset', $request->kategori_aset);
        }

        // Filter by location
        if ($request->filled('lokasi_penempatan')) {
            $query->where('lokasi_penempatan', $request->lokasi_penempatan);
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status_aset', $request->status);
        }
        
        // Filter by physical condition
        if ($request->filled('keadaan_fizikal')) {
            $query->where('keadaan_fizikal', $request->keadaan_fizikal);
        }
        
        $assets = $query->latest()->paginate(15);
        
        return view('admin.assets.index', compact('assets'));
    }

    /**
     * borangDaftarAset(): Display form interface for entering new movable asset details
     */
    public function create()
    {
        $masjidSuraus = MasjidSurau::all();
        $assetTypes = array_keys(AssetRegistrationNumber::getAssetTypeAbbreviations());
        
        // Set default to Masjid Al-Hidayah, Taman Melawati
        $defaultMasjid = MasjidSurau::where('nama', 'like', '%Al-Hidayah%')
                                   ->where('nama', 'like', '%Taman Melawati%')
                                   ->first();
        $default_masjid_surau_id = $defaultMasjid ? $defaultMasjid->id : (auth()->user()->masjid_surau_id ?? null);
        return view('admin.assets.create', compact('masjidSuraus', 'assetTypes', 'default_masjid_surau_id'));
    }

    /**
     * simpanAsetBaru(): Process form data and save new movable asset record to database
     * with automatic generation of unique registration number according to SOP format
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'masjid_surau_id' => 'required|exists:masjid_surau,id',
            'nama_aset' => 'required|string|max:255',
            'jenis_aset' => 'required|string',
            'kategori_aset' => 'required|in:asset,non-asset',
            'tarikh_perolehan' => 'required|date',
            'kaedah_perolehan' => 'required|string',
            'nilai_perolehan' => 'required|numeric|min:0',
            'no_resit' => 'nullable|string|max:255',
            'tarikh_resit' => 'nullable|date',
            'diskaun' => 'nullable|numeric|min:0',
            'umur_faedah_tahunan' => 'nullable|integer|min:1',
            'susut_nilai_tahunan' => 'nullable|numeric|min:0',
            'lokasi_penempatan' => 'required|string|in:Anjung kiri,Anjung kanan,Anjung Depan(Ruang Pengantin),Ruang Utama (tingkat atas, tingkat bawah),Bilik Mesyuarat,Bilik Kuliah,Bilik Bendahari,Bilik Setiausaha,Bilik Nazir & Imam,Bangunan Jenazah,Lain-lain',
            'pegawai_bertanggungjawab_lokasi' => 'required|string|max:255',
            'jawatan_pegawai' => 'nullable|string|max:255',
            'status_aset' => 'required|string',
            'keadaan_fizikal' => 'required|in:Cemerlang,Baik,Sederhana,Rosak,Tidak Boleh Digunakan',
            'status_jaminan' => 'required|in:Aktif,Tamat,Tiada Jaminan',
            'tarikh_pemeriksaan_terakhir' => 'nullable|date',
            'tarikh_penyelenggaraan_akan_datang' => 'nullable|date',
            'catatan_jaminan' => 'nullable|string',
            'catatan' => 'nullable|string',
            'gambar_aset' => 'nullable|array',
            'gambar_aset.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

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

        return redirect()->route('admin.assets.show', $asset)
                        ->with('success', 'Aset baru berjaya didaftarkan dengan nombor siri: ' . $asset->no_siri_pendaftaran);
    }

    /**
     * lihatButiranAset(id): Display complete details of specific movable asset based on unique ID
     */
    public function show(Asset $asset)
    {
        $asset->load(['masjidSurau', 'movements', 'inspections', 'maintenanceRecords']);
        
        return view('admin.assets.show', compact('asset'));
    }

    /**
     * borangEditAset(id): Display form for modifying existing movable asset details
     */
    public function edit(Asset $asset)
    {
        $masjidSuraus = MasjidSurau::all();
        $assetTypes = array_keys(AssetRegistrationNumber::getAssetTypeAbbreviations());
        
        return view('admin.assets.edit', compact('asset', 'masjidSuraus', 'assetTypes'));
    }

    /**
     * kemaskiniAset(id): Process and save changes made to existing movable asset details
     */
    public function update(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'nama_aset' => 'required|string|max:255',
            'jenis_aset' => 'required|string',
            'kategori_aset' => 'required|in:asset,non-asset',
            'tarikh_perolehan' => 'required|date',
            'kaedah_perolehan' => 'required|string',
            'nilai_perolehan' => 'required|numeric|min:0',
            'no_resit' => 'nullable|string|max:255',
            'tarikh_resit' => 'nullable|date',
            'diskaun' => 'nullable|numeric|min:0',
            'umur_faedah_tahunan' => 'nullable|integer|min:1',
            'susut_nilai_tahunan' => 'nullable|numeric|min:0',
            'lokasi_penempatan' => 'required|string|in:Anjung kiri,Anjung kanan,Anjung Depan(Ruang Pengantin),Ruang Utama (tingkat atas, tingkat bawah),Bilik Mesyuarat,Bilik Kuliah,Bilik Bendahari,Bilik Setiausaha,Bilik Nazir & Imam,Bangunan Jenazah,Lain-lain',
            'pegawai_bertanggungjawab_lokasi' => 'required|string|max:255',
            'jawatan_pegawai' => 'nullable|string|max:255',
            'status_aset' => 'required|string',
            'keadaan_fizikal' => 'required|in:Cemerlang,Baik,Sederhana,Rosak,Tidak Boleh Digunakan',
            'status_jaminan' => 'required|in:Aktif,Tamat,Tiada Jaminan',
            'tarikh_pemeriksaan_terakhir' => 'nullable|date',
            'tarikh_penyelenggaraan_akan_datang' => 'nullable|date',
            'catatan_jaminan' => 'nullable|string',
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

        return redirect()->route('admin.assets.show', $asset)
                        ->with('success', 'Butiran aset berjaya dikemaskini.');
    }

    /**
     * padamAset(id): Permanently delete movable asset record from system
     */
    public function destroy(Asset $asset)
    {
        $asset->delete();

        return redirect()->route('admin.assets.index')
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
        
        $assets = $query->get();
        
        return view('admin.assets.by-location', compact('assets', 'lokasi'));
    }

    /**
     * kemaskiniLokasiAset(id, lokasiBaru): Update asset location in system record when physical change occurs
     */
    public function updateLocation(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'lokasi_penempatan' => 'required|string|in:Anjung kiri,Anjung kanan,Anjung Depan(Ruang Pengantin),Ruang Utama (tingkat atas, tingkat bawah),Bilik Mesyuarat,Bilik Kuliah,Bilik Bendahari,Bilik Setiausaha,Bilik Nazir & Imam,Bangunan Jenazah,Lain-lain',
            'pegawai_bertanggungjawab_lokasi' => 'required|string|max:255',
            'jawatan_pegawai' => 'nullable|string|max:255',
        ]);

        $asset->update($validated);

        return redirect()->route('admin.assets.show', $asset)
                        ->with('success', 'Lokasi aset berjaya dikemaskini.');
    }

    /**
     * padamAsetTerpilih(): Delete multiple selected assets from the system
     */
    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'asset_ids' => 'required|array|min:1',
            'asset_ids.*' => 'exists:assets,id'
        ]);

        $deletedCount = Asset::whereIn('id', $validated['asset_ids'])->delete();

        return redirect()->route('admin.assets.index')
                        ->with('success', "Berjaya memadamkan {$deletedCount} aset yang dipilih.");
    }
}
