<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\MasjidSurau;
use App\Helpers\AssetRegistrationNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        $assetTypes = array_keys(AssetRegistrationNumber::getAssetTypeAbbreviations());

        return view('admin.assets.index', compact('assets', 'assetTypes'));
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
        $availableAssetTypes = array_keys(AssetRegistrationNumber::getAssetTypeAbbreviations());

        $validated = $request->validate([
            'masjid_surau_id' => 'required|exists:masjid_surau,id',
            'nama_aset' => 'required|string|max:255',
            'jenis_aset' => 'required|string|in:' . implode(',', $availableAssetTypes),
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
            'pembekal' => 'nullable|string|max:255',
            'jenama' => 'nullable|string|max:255',
            'no_pesanan_kerajaan' => 'nullable|string|max:255',
            'no_rujukan_kontrak' => 'nullable|string|max:255',
            'tempoh_jaminan' => 'nullable|string|max:255',
            'tarikh_tamat_jaminan' => 'nullable|date',
            'gambar_aset' => 'nullable|array|max:5',
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
        $availableAssetTypes = array_keys(AssetRegistrationNumber::getAssetTypeAbbreviations());

        $validated = $request->validate([
            'nama_aset' => 'required|string|max:255',
            'jenis_aset' => 'required|string|in:' . implode(',', $availableAssetTypes),
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
            'pembekal' => 'nullable|string|max:255',
            'jenama' => 'nullable|string|max:255',
            'no_pesanan_kerajaan' => 'nullable|string|max:255',
            'no_rujukan_kontrak' => 'nullable|string|max:255',
            'tempoh_jaminan' => 'nullable|string|max:255',
            'tarikh_tamat_jaminan' => 'nullable|date',
            'gambar_aset' => 'nullable|array|max:5',
            'gambar_aset.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Handle image deletions
        if ($request->has('delete_images')) {
            $imagesToDelete = is_array($request->delete_images) ? $request->delete_images : [$request->delete_images];
            $currentImages = $asset->gambar_aset ?? [];
            $remainingImages = array_filter($currentImages, function ($image) use ($imagesToDelete) {
                return !in_array($image, $imagesToDelete);
            });
            $validated['gambar_aset'] = array_values($remainingImages);

            // Delete files from storage
            foreach ($imagesToDelete as $imagePath) {
                if (Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
            }
        }

        // Handle image uploads
        if ($request->hasFile('gambar_aset')) {
            $images = $validated['gambar_aset'] ?? ($asset->gambar_aset ?? []);
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

    /**
     * Export assets to CSV
     */
    public function export(Request $request)
    {
        $query = Asset::with('masjidSurau');

        // Apply same filters as index
        if ($request->filled('lokasi')) {
            $query->where('lokasi_penempatan', 'like', '%' . $request->lokasi . '%');
        }

        if ($request->filled('jenis_aset')) {
            $query->where('jenis_aset', $request->jenis_aset);
        }

        if ($request->filled('kategori_aset')) {
            $query->where('kategori_aset', $request->kategori_aset);
        }

        if ($request->filled('lokasi_penempatan')) {
            $query->where('lokasi_penempatan', $request->lokasi_penempatan);
        }

        if ($request->filled('status')) {
            $query->where('status_aset', $request->status);
        }

        if ($request->filled('keadaan_fizikal')) {
            $query->where('keadaan_fizikal', $request->keadaan_fizikal);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_aset', 'like', '%' . $search . '%')
                    ->orWhere('no_siri_pendaftaran', 'like', '%' . $search . '%')
                    ->orWhere('jenis_aset', 'like', '%' . $search . '%');
            });
        }

        $assets = $query->latest()->limit(10000)->get(); // Limit to prevent memory issues

        $filename = 'assets_export_' . now()->format('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($assets) {
            $file = fopen('php://output', 'w');

            // Add BOM for UTF-8 to support Malay characters
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Write CSV headers - matching import template order and format
            fputcsv($file, [
                'Masjid/Surau ID',
                'Nama Aset',
                'Jenis Aset',
                'Kategori Aset (asset/non-asset)',
                'Tarikh Perolehan (DD/MM/YYYY)',
                'Kaedah Perolehan',
                'Nilai Perolehan (RM)',
                'Diskaun (RM)',
                'Umur Faedah (Tahun)',
                'Susut Nilai Tahunan (RM)',
                'Lokasi Penempatan',
                'Pegawai Bertanggungjawab',
                'Jawatan Pegawai',
                'Status Aset',
                'Keadaan Fizikal',
                'Status Jaminan',
                'Tarikh Pemeriksaan Terakhir (DD/MM/YYYY)',
                'Tarikh Penyelenggaraan Akan Datang (DD/MM/YYYY)',
                'No. Resit',
                'Tarikh Resit (DD/MM/YYYY)',
                'Pembekal',
                'Jenama',
                'No. Pesanan Kerajaan',
                'No. Rujukan Kontrak',
                'Tempoh Jaminan',
                'Tarikh Tamat Jaminan (DD/MM/YYYY)',
                'Catatan',
                'Catatan Jaminan'
            ]);

            // Write data rows - matching import template column order
            foreach ($assets as $asset) {
                fputcsv($file, [
                    $asset->masjid_surau_id,
                    $asset->nama_aset,
                    $asset->jenis_aset,
                    $asset->kategori_aset === 'asset' ? 'asset' : 'non-asset',
                    $asset->tarikh_perolehan ? $asset->tarikh_perolehan->format('d/m/Y') : '',
                    $asset->kaedah_perolehan ?? '',
                    number_format($asset->nilai_perolehan ?? 0, 2),
                    number_format($asset->diskaun ?? 0, 2),
                    $asset->umur_faedah_tahunan ?? '',
                    number_format($asset->susut_nilai_tahunan ?? 0, 2),
                    $asset->lokasi_penempatan,
                    $asset->pegawai_bertanggungjawab_lokasi,
                    $asset->jawatan_pegawai ?? '',
                    $asset->status_aset,
                    $asset->keadaan_fizikal ?? '',
                    $asset->status_jaminan ?? '',
                    $asset->tarikh_pemeriksaan_terakhir ? $asset->tarikh_pemeriksaan_terakhir->format('d/m/Y') : '',
                    $asset->tarikh_penyelenggaraan_akan_datang ? $asset->tarikh_penyelenggaraan_akan_datang->format('d/m/Y') : '',
                    $asset->no_resit ?? '',
                    $asset->tarikh_resit ? $asset->tarikh_resit->format('d/m/Y') : '',
                    $asset->pembekal ?? '',
                    $asset->jenama ?? '',
                    $asset->no_pesanan_kerajaan ?? '',
                    $asset->no_rujukan_kontrak ?? '',
                    $asset->tempoh_jaminan ?? '',
                    $asset->tarikh_tamat_jaminan ? $asset->tarikh_tamat_jaminan->format('d/m/Y') : '',
                    $asset->catatan ?? '',
                    $asset->catatan_jaminan ?? ''
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Download import template
     */
    public function downloadTemplate()
    {
        $filename = 'assets_import_template_' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');

            // Add BOM for UTF-8
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Write CSV headers
            fputcsv($file, [
                'Masjid/Surau ID',
                'Nama Aset',
                'Jenis Aset',
                'Kategori Aset (asset/non-asset)',
                'Tarikh Perolehan (DD/MM/YYYY)',
                'Kaedah Perolehan',
                'Nilai Perolehan (RM)',
                'Diskaun (RM)',
                'Umur Faedah (Tahun)',
                'Susut Nilai Tahunan (RM)',
                'Lokasi Penempatan',
                'Pegawai Bertanggungjawab',
                'Jawatan Pegawai',
                'Status Aset',
                'Keadaan Fizikal',
                'Status Jaminan',
                'Tarikh Pemeriksaan Terakhir (DD/MM/YYYY)',
                'Tarikh Penyelenggaraan Akan Datang (DD/MM/YYYY)',
                'No. Resit',
                'Tarikh Resit (DD/MM/YYYY)',
                'Pembekal',
                'Jenama',
                'No. Pesanan Kerajaan',
                'No. Rujukan Kontrak',
                'Tempoh Jaminan',
                'Tarikh Tamat Jaminan (DD/MM/YYYY)',
                'Catatan',
                'Catatan Jaminan'
            ]);

            // Add example row
            $masjidSuraus = MasjidSurau::limit(1)->first();
            $assetTypes = array_keys(AssetRegistrationNumber::getAssetTypeAbbreviations());

            fputcsv($file, [
                $masjidSuraus->id ?? '1',
                'Contoh: Komputer Desktop',
                $assetTypes[0] ?? 'Perabot',
                'asset',
                date('Y-m-d'),
                'Pembelian',
                '2500.00',
                '0.00',
                '5',
                '500.00',
                'Bilik Setiausaha',
                'Ahmad bin Abdullah',
                'Setiausaha',
                'Sedang Digunakan',
                'Baik',
                'Aktif',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                'Contoh catatan',
                ''
            ]);

            // Add blank rows for separation
            fputcsv($file, []);
            fputcsv($file, []);

            // Add reference sections
            fputcsv($file, ['=== RUJUKAN: SENARAI NILAI SAH ===']);
            fputcsv($file, ['Gunakan nilai-nilai di bawah untuk mengisi template']);
            fputcsv($file, []);

            // 1. Asset Types Reference
            fputcsv($file, ['--- JENIS ASET SAH ---']);
            foreach ($assetTypes as $type) {
                fputcsv($file, [$type]);
            }
            fputcsv($file, []);

            // 2. Asset Category Reference
            fputcsv($file, ['--- KATEGORI ASET SAH ---']);
            fputcsv($file, ['asset', '(Aset bernilai)']);
            fputcsv($file, ['non-asset', '(Bukan aset)']);
            fputcsv($file, []);

            // 3. Location Reference
            fputcsv($file, ['--- LOKASI PENEMPATAN SAH ---']);
            $validLocations = [
                'Anjung kiri',
                'Anjung kanan',
                'Anjung Depan(Ruang Pengantin)',
                'Ruang Utama (tingkat atas, tingkat bawah)',
                'Bilik Mesyuarat',
                'Bilik Kuliah',
                'Bilik Bendahari',
                'Bilik Setiausaha',
                'Bilik Nazir & Imam',
                'Bangunan Jenazah',
                'Lain-lain'
            ];
            foreach ($validLocations as $location) {
                fputcsv($file, [$location]);
            }
            fputcsv($file, []);

            // 4. Physical Condition Reference
            fputcsv($file, ['--- KEADAAN FIZIKAL SAH ---']);
            fputcsv($file, ['Cemerlang']);
            fputcsv($file, ['Baik']);
            fputcsv($file, ['Sederhana']);
            fputcsv($file, ['Rosak']);
            fputcsv($file, ['Tidak Boleh Digunakan']);
            fputcsv($file, []);

            // 5. Asset Status Reference
            fputcsv($file, ['--- STATUS ASET SAH ---']);
            fputcsv($file, ['Baru']);
            fputcsv($file, ['Sedang Digunakan']);
            fputcsv($file, ['Dalam Penyelenggaraan']);
            fputcsv($file, ['Rosak']);
            fputcsv($file, []);

            // 6. Acquisition Method Reference
            fputcsv($file, ['--- KAEDAH PEROLEHAN SAH ---']);
            fputcsv($file, ['Pembelian']);
            fputcsv($file, ['Sumbangan']);
            fputcsv($file, ['Hibah']);
            fputcsv($file, ['Infaq']);
            fputcsv($file, ['Lain-lain']);
            fputcsv($file, []);

            // 7. Warranty Status Reference
            fputcsv($file, ['--- STATUS JAMINAN SAH ---']);
            fputcsv($file, ['Aktif']);
            fputcsv($file, ['Tamat']);
            fputcsv($file, ['Tiada Jaminan']);
            fputcsv($file, []);

            // Add important notes
            fputcsv($file, ['=== NOTA PENTING ===']);
            fputcsv($file, ['1. Format tarikh: YYYY-MM-DD (contoh: 2024-01-15)']);
            fputcsv($file, ['2. Pastikan Masjid/Surau ID wujud dalam sistem']);
            fputcsv($file, ['3. Nombor siri pendaftaran akan dijana automatik']);
            fputcsv($file, ['4. Gunakan nilai TEPAT seperti dalam senarai rujukan']);
            fputcsv($file, ['5. Kategori Aset: gunakan huruf kecil (asset atau non-asset)']);

            fclose($file);

        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Show import form
     */
    public function showImport()
    {
        $masjidSuraus = MasjidSurau::all();
        $assetTypes = array_keys(AssetRegistrationNumber::getAssetTypeAbbreviations());

        return view('admin.assets.import', compact('masjidSuraus', 'assetTypes'));
    }

    /**
     * Import assets from CSV
     */
    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:51200', // 50MB max (increased for large imports)
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();

        // Read file line by line to handle large files efficiently
        $handle = fopen($path, 'r');
        if (!$handle) {
            return redirect()->route('admin.assets.import')
                ->with('error', 'Tidak dapat membaca fail CSV.');
        }

        // Read and skip header row
        $header = fgetcsv($handle);
        if ($header && isset($header[0]) && substr($header[0], 0, 3) == pack('CCC', 0xef, 0xbb, 0xbf)) {
            $header[0] = substr($header[0], 3);
        }

        $errors = [];
        $successCount = 0;
        $skipCount = 0;
        $availableAssetTypes = array_keys(AssetRegistrationNumber::getAssetTypeAbbreviations());
        $rowIndex = 0;

        // Process rows in batches for better performance
        $batchSize = 100;
        $batch = [];

        while (($row = fgetcsv($handle)) !== false) {
            $rowIndex++;
            $rowNumber = $rowIndex + 1; // +1 because header is row 1

            // Skip empty rows
            if (empty(array_filter($row))) {
                $skipCount++;
                continue;
            }

            try {
                // Map CSV columns to asset fields
                $assetData = [
                    'masjid_surau_id' => $row[0] ?? null,
                    'nama_aset' => $row[1] ?? null,
                    'jenis_aset' => $row[2] ?? null,
                    'kategori_aset' => $row[3] ?? null,
                    'tarikh_perolehan' => $row[4] ?? null,
                    'kaedah_perolehan' => $row[5] ?? null,
                    'nilai_perolehan' => $row[6] ?? null,
                    'diskaun' => $row[7] ?? 0,
                    'umur_faedah_tahunan' => $row[8] ?? null,
                    'susut_nilai_tahunan' => $row[9] ?? null,
                    'lokasi_penempatan' => $row[10] ?? null,
                    'pegawai_bertanggungjawab_lokasi' => $row[11] ?? null,
                    'jawatan_pegawai' => $row[12] ?? null,
                    'status_aset' => $row[13] ?? 'Sedang Digunakan',
                    'keadaan_fizikal' => $row[14] ?? 'Baik',
                    'status_jaminan' => $row[15] ?? 'Tiada Jaminan',
                    'tarikh_pemeriksaan_terakhir' => !empty($row[16]) ? $row[16] : null,
                    'tarikh_penyelenggaraan_akan_datang' => !empty($row[17]) ? $row[17] : null,
                    'no_resit' => $row[18] ?? null,
                    'tarikh_resit' => !empty($row[19]) ? $row[19] : null,
                    'pembekal' => $row[20] ?? null,
                    'jenama' => $row[21] ?? null,
                    'no_pesanan_kerajaan' => $row[22] ?? null,
                    'no_rujukan_kontrak' => $row[23] ?? null,
                    'tempoh_jaminan' => $row[24] ?? null,
                    'tarikh_tamat_jaminan' => !empty($row[25]) ? $row[25] : null,
                    'catatan' => $row[26] ?? null,
                    'catatan_jaminan' => $row[27] ?? null,
                ];

                // Validate required fields
                if (empty($assetData['nama_aset'])) {
                    $errors[] = "Baris {$rowNumber}: Nama Aset diperlukan";
                    continue;
                }

                if (empty($assetData['masjid_surau_id']) || !MasjidSurau::find($assetData['masjid_surau_id'])) {
                    $errors[] = "Baris {$rowNumber}: Masjid/Surau ID tidak sah";
                    continue;
                }

                if (empty($assetData['jenis_aset']) || !in_array($assetData['jenis_aset'], $availableAssetTypes)) {
                    $errors[] = "Baris {$rowNumber}: Jenis Aset tidak sah. Sila gunakan salah satu: " . implode(', ', $availableAssetTypes);
                    continue;
                }

                if (empty($assetData['kategori_aset']) || !in_array($assetData['kategori_aset'], ['asset', 'non-asset'])) {
                    $errors[] = "Baris {$rowNumber}: Kategori Aset mesti 'asset' atau 'non-asset'";
                    continue;
                }

                if (empty($assetData['tarikh_perolehan'])) {
                    $errors[] = "Baris {$rowNumber}: Tarikh Perolehan diperlukan";
                    continue;
                }

                // Validate date format
                try {
                    $tarikhPerolehan = \Carbon\Carbon::parse($assetData['tarikh_perolehan']);
                } catch (\Exception $e) {
                    $errors[] = "Baris {$rowNumber}: Format tarikh perolehan tidak sah. Gunakan format YYYY-MM-DD";
                    continue;
                }

                // Validate and parse other date fields if provided
                if (!empty($assetData['tarikh_pemeriksaan_terakhir'])) {
                    try {
                        \Carbon\Carbon::parse($assetData['tarikh_pemeriksaan_terakhir']);
                    } catch (\Exception $e) {
                        $errors[] = "Baris {$rowNumber}: Format tarikh pemeriksaan terakhir tidak sah. Gunakan format YYYY-MM-DD";
                        continue;
                    }
                }

                if (!empty($assetData['tarikh_penyelenggaraan_akan_datang'])) {
                    try {
                        \Carbon\Carbon::parse($assetData['tarikh_penyelenggaraan_akan_datang']);
                    } catch (\Exception $e) {
                        $errors[] = "Baris {$rowNumber}: Format tarikh penyelenggaraan akan datang tidak sah. Gunakan format YYYY-MM-DD";
                        continue;
                    }
                }

                if (!empty($assetData['tarikh_resit'])) {
                    try {
                        \Carbon\Carbon::parse($assetData['tarikh_resit']);
                    } catch (\Exception $e) {
                        $errors[] = "Baris {$rowNumber}: Format tarikh resit tidak sah. Gunakan format YYYY-MM-DD";
                        continue;
                    }
                }

                if (!empty($assetData['tarikh_tamat_jaminan'])) {
                    try {
                        \Carbon\Carbon::parse($assetData['tarikh_tamat_jaminan']);
                    } catch (\Exception $e) {
                        $errors[] = "Baris {$rowNumber}: Format tarikh tamat jaminan tidak sah. Gunakan format YYYY-MM-DD";
                        continue;
                    }
                }

                // Validate location
                $validLocations = ['Anjung kiri', 'Anjung kanan', 'Anjung Depan(Ruang Pengantin)', 'Ruang Utama (tingkat atas, tingkat bawah)', 'Bilik Mesyuarat', 'Bilik Kuliah', 'Bilik Bendahari', 'Bilik Setiausaha', 'Bilik Nazir & Imam', 'Bangunan Jenazah', 'Lain-lain'];
                if (empty($assetData['lokasi_penempatan']) || !in_array($assetData['lokasi_penempatan'], $validLocations)) {
                    $errors[] = "Baris {$rowNumber}: Lokasi Penempatan tidak sah";
                    continue;
                }

                if (empty($assetData['pegawai_bertanggungjawab_lokasi'])) {
                    $errors[] = "Baris {$rowNumber}: Pegawai Bertanggungjawab diperlukan";
                    continue;
                }

                if (empty($assetData['kaedah_perolehan'])) {
                    $errors[] = "Baris {$rowNumber}: Kaedah Perolehan diperlukan";
                    continue;
                }

                // Generate registration number (tarikh already validated above)
                $assetData['no_siri_pendaftaran'] = AssetRegistrationNumber::generate(
                    $assetData['masjid_surau_id'],
                    $assetData['jenis_aset'],
                    $tarikhPerolehan->format('y')
                );

                // Check if registration number already exists (duplicate check)
                if (Asset::where('no_siri_pendaftaran', $assetData['no_siri_pendaftaran'])->exists()) {
                    $errors[] = "Baris {$rowNumber}: Nombor siri pendaftaran sudah wujud: {$assetData['no_siri_pendaftaran']}";
                    continue;
                }

                // Convert numeric fields
                $assetData['nilai_perolehan'] = (float) ($assetData['nilai_perolehan'] ?? 0);
                $assetData['diskaun'] = (float) ($assetData['diskaun'] ?? 0);
                $assetData['umur_faedah_tahunan'] = !empty($assetData['umur_faedah_tahunan']) ? (int) $assetData['umur_faedah_tahunan'] : null;
                $assetData['susut_nilai_tahunan'] = !empty($assetData['susut_nilai_tahunan']) ? (float) $assetData['susut_nilai_tahunan'] : null;

                // Ensure date fields are properly formatted (set to null if empty)
                $assetData['tarikh_pemeriksaan_terakhir'] = !empty($assetData['tarikh_pemeriksaan_terakhir']) ? $assetData['tarikh_pemeriksaan_terakhir'] : null;
                $assetData['tarikh_penyelenggaraan_akan_datang'] = !empty($assetData['tarikh_penyelenggaraan_akan_datang']) ? $assetData['tarikh_penyelenggaraan_akan_datang'] : null;
                $assetData['tarikh_resit'] = !empty($assetData['tarikh_resit']) ? $assetData['tarikh_resit'] : null;
                $assetData['tarikh_tamat_jaminan'] = !empty($assetData['tarikh_tamat_jaminan']) ? $assetData['tarikh_tamat_jaminan'] : null;

                // Create asset
                Asset::create($assetData);
                $successCount++;

            } catch (\Exception $e) {
                $errors[] = "Baris {$rowNumber}: " . $e->getMessage();
            }
        }

        // Close file handle
        fclose($handle);

        $message = "Import selesai. {$successCount} aset berjaya diimport.";
        if ($skipCount > 0) {
            $message .= " {$skipCount} baris kosong dilangkau.";
        }
        if (count($errors) > 0) {
            $message .= " " . count($errors) . " ralat ditemui.";
        }

        if (count($errors) > 0) {
            return redirect()->route('admin.assets.import')
                ->with('import_errors', $errors)
                ->with('success', $message)
                ->withInput();
        }

        return redirect()->route('admin.assets.index')
            ->with('success', $message);
    }
}
