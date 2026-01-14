<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\MasjidSurau;
use App\Helpers\AssetRegistrationNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Support\Str;

class AssetController extends Controller
{
    // Valid locations moved to App\Helpers\SystemData

    /**
     * lihatSenaraiAset(): Display complete list of all registered movable assets
     */
    public function index(Request $request)
    {
        $query = Asset::with('masjidSurau')->withCount('batchSiblings');

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

        $assets = $query->where(function ($q) {
            $q->whereNull('batch_id')
                ->orWhereIn('id', function ($sub) {
                    $sub->selectRaw('MIN(id)')
                        ->from('assets')
                        ->whereNotNull('batch_id')
                        ->groupBy('batch_id');
                });
        })->latest()->paginate(15);
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
            'kuantiti' => 'required|integer|min:1',
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
            'lokasi_penempatan' => ['required', 'string', Rule::in(\App\Helpers\SystemData::getValidLocations())],
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
            'pembekal_alamat' => 'nullable|string',
            'pembekal_no_telefon' => 'nullable|string|max:50',
            'jenama' => 'nullable|string|max:255',
            'no_pesanan_kerajaan' => 'nullable|string|max:255',
            'no_rujukan_kontrak' => 'nullable|string|max:255',
            'tempoh_jaminan' => 'nullable|string|max:255',
            'tarikh_tamat_jaminan' => 'nullable|date',
            'gambar_aset' => 'nullable|array|max:5',
            'gambar_aset.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'dokumen_resit_url' => 'nullable|url',
        ]);

        \DB::beginTransaction();
        try {
            // Generate Registration Number
            // Use current year or year from date of acquisition
            $year = Carbon::parse($validated['tarikh_perolehan'])->format('y');

            // Handle multiple quantity
            $quantity = (int) $validated['kuantiti'];
            $firstAssetId = null;
            $batchId = Str::uuid();

            for ($i = 0; $i < $quantity; $i++) {
                // Generate unique registration number for each asset
                // Pass offset to handle concurrent creations in loop
                $registrationNumber = AssetRegistrationNumber::generate(
                    $validated['masjid_surau_id'],
                    $validated['jenis_aset'],
                    $year,
                    $i // Offset
                );

                $assetData = $validated;
                $assetData['no_siri_pendaftaran'] = $registrationNumber;
                $assetData['batch_id'] = $batchId;
                unset($assetData['kuantiti']); // Remove quantity from individual asset data

                $asset = Asset::create($assetData);

                // Handle image uploads if any
                if ($request->hasFile('gambar_aset')) {
                    $imagePaths = [];
                    foreach ($request->file('gambar_aset') as $image) {
                        $path = $image->store('assets', 'public');
                        $imagePaths[] = $path;
                    }
                    $asset->gambar_aset = $imagePaths;
                    $asset->save();
                }

                if ($i === 0) {
                    $firstAssetId = $asset->id;
                }
            }

            \DB::commit();

            if ($quantity > 1) {
                return redirect()->route('admin.assets.index')
                    ->with('success', "$quantity aset telah berjaya didaftarkan.");
            }

            return redirect()->route('admin.assets.show', $firstAssetId)
                ->with('success', 'Aset berjaya didaftarkan.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            \DB::rollBack();
            throw $e;
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollBack();
            // Check for duplicate entry error
            if ($e->errorInfo[1] == 1062) { // MySQL duplicate entry error code
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Ralat: Nombor siri pendaftaran aset ini telah wujud. Sila cuba lagi.');
            }
            return redirect()->back()
                ->withInput()
                ->with('error', 'Ralat pangkalan data: ' . $e->getMessage());

        } catch (\Exception $e) {
            \DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Ralat mewujudkan aset: ' . $e->getMessage());
        }
    }

    /**
     * lihatButiranAset(id): Display complete details of specific movable asset based on unique ID
     */
    public function show(Asset $asset)
    {
        $asset->load(['masjidSurau', 'movements', 'inspections', 'maintenanceRecords'])
            ->loadCount('batchSiblings');

        return view('admin.assets.show', compact('asset'));
    }

    /**
     * borangEditAset(id): Display form for modifying existing movable asset details
     */
    public function edit(Asset $asset)
    {
        $asset->loadCount('batchSiblings');
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
            'lokasi_penempatan' => ['required', 'string', Rule::in(\App\Helpers\SystemData::getValidLocations())],
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
            'pembekal_alamat' => 'nullable|string',
            'pembekal_no_telefon' => 'nullable|string|max:50',
            'jenama' => 'nullable|string|max:255',
            'no_pesanan_kerajaan' => 'nullable|string|max:255',
            'no_rujukan_kontrak' => 'nullable|string|max:255',
            'tempoh_jaminan' => 'nullable|string|max:255',
            'tarikh_tamat_jaminan' => 'nullable|date',
            'gambar_aset' => 'nullable|array|max:5',
            'gambar_aset.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'dokumen_resit_url' => 'nullable|url',
        ]);

        $asset->update($validated);

        if ($request->hasFile('gambar_aset')) {
            $imagePaths = $asset->gambar_aset ?? [];
            foreach ($request->file('gambar_aset') as $image) {
                $path = $image->store('assets', 'public');
                $imagePaths[] = $path;
            }
            $asset->gambar_aset = $imagePaths;
            $asset->save();
        }

        if ($request->has('remove_images')) {
            $currentImages = $asset->gambar_aset ?? [];
            foreach ($request->remove_images as $imageToRemove) {
                if (($key = array_search($imageToRemove, $currentImages)) !== false) {
                    Storage::disk('public')->delete($imageToRemove);
                    unset($currentImages[$key]);
                }
            }
            $asset->gambar_aset = array_values($currentImages);
            $asset->save();
        }

        return redirect()->route('admin.assets.show', $asset)
            ->with('success', 'Aset berjaya dikemaskini.');
    }

    /**
     * padamAset(id): Permanently delete movable asset record from system
     */
    public function destroy(Asset $asset)
    {
        if ($asset->gambar_aset) {
            foreach ($asset->gambar_aset as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $asset->delete();

        return redirect()->route('admin.assets.index')
            ->with('success', 'Aset berjaya dipadamkan.');
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
            'lokasi_penempatan' => ['required', 'string', Rule::in(\App\Helpers\SystemData::getValidLocations())],
            'pegawai_bertanggungjawab_lokasi' => 'required|string|max:255',
            'jawatan_pegawai' => 'nullable|string|max:255',
        ]);

        $asset->update($validated);

        return back()->with('success', 'Lokasi aset berjaya dikemaskini.');
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

        $filename = 'assets_export_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\AssetExport($request), $filename);
    }

    /**
     * Download import template
     */
    public function downloadTemplate()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\AssetImportTemplateExport, 'template_import_aset.xlsx');
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
    /**
     * Import assets from CSV
     */
    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt,xlsx,xls|max:51200',
        ]);

        $file = $request->file('csv_file');

        try {
            $sheets = \Maatwebsite\Excel\Facades\Excel::toArray(new \App\Imports\AssetImport, $file);
            $rows = $sheets[0] ?? [];
        } catch (\Exception $e) {
            return redirect()->route('admin.assets.import')
                ->with('error', 'Gagal membaca fail: ' . $e->getMessage());
        }

        $result = $this->processImportRows($rows);

        if (count($result['errors']) > 0) {
            // Flatten errors for display
            $displayErrors = [];
            foreach ($result['errors'] as $rowErrors) {
                foreach ($rowErrors['errors'] as $error) {
                    $displayErrors[] = $error;
                }
            }

            return redirect()->route('admin.assets.import')
                ->with('import_errors', $displayErrors)
                ->with('error', 'Terdapat ralat dalam fail import. Sila semak dan cuba lagi.')
                ->withInput();
        }

        // Process valid rows
        $successCount = 0;
        foreach ($result['valid_rows'] as $row) {
            try {
                Asset::create($row['data']);
                $successCount++;
            } catch (\Exception $e) {
                // Log critical error if creation fails despite validation
                \Illuminate\Support\Facades\Log::error('Asset Creation Failed in Import: ' . $e->getMessage());
            }
        }

        $message = "Import selesai. {$successCount} aset berjaya diimport.";
        if ($result['skipped_count'] > 0) {
            $message .= " {$result['skipped_count']} baris kosong dilangkau.";
        }

        return redirect()->route('admin.assets.index')->with('success', $message);
    }

    /**
     * Preview import data
     */
    public function previewImport(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt,xlsx,xls|max:51200',
        ]);

        try {
            $file = $request->file('csv_file');
            $sheets = \Maatwebsite\Excel\Facades\Excel::toArray(new \App\Imports\AssetImport, $file);
            $rows = $sheets[0] ?? [];

            $result = $this->processImportRows($rows);

            return response()->json([
                'success' => true,
                'data' => $result['rows'],
                'summary' => [
                    'total' => count($rows) - 1, // Exclude header
                    'valid' => count($result['valid_rows']),
                    'invalid' => count($result['errors']),
                    'skipped' => $result['skipped_count']
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Process import rows for validation and preview
     */
    private function processImportRows($rows)
    {
        $availableAssetTypes = array_keys(AssetRegistrationNumber::getAssetTypeAbbreviations());
        $processedRows = [];
        $validRows = [];
        $errorRows = [];
        $skippedCount = 0;
        $sequenceOffsets = []; // Track ID generation offsets

        // Skip header row
        array_shift($rows);

        foreach ($rows as $index => $row) {
            $rowNumber = $index + 2; // +1 for 0-index, +1 for header
            $rowErrors = [];
            $assetData = [];

            // Skip empty rows
            if (
                empty(array_filter($row, function ($value) {
                    return !is_null($value) && $value !== '';
                }))
            ) {
                $skippedCount++;
                continue;
            }

            try {
                // Map columns
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
                if (empty($assetData['nama_aset']))
                    $rowErrors[] = "Nama Aset diperlukan";

                if (empty($assetData['masjid_surau_id']) || !MasjidSurau::find($assetData['masjid_surau_id'])) {
                    $rowErrors[] = "Masjid/Surau ID tidak sah";
                }

                if (empty($assetData['jenis_aset']) || !in_array($assetData['jenis_aset'], $availableAssetTypes)) {
                    $rowErrors[] = "Jenis Aset tidak sah. Gunakan: " . implode(', ', $availableAssetTypes);
                }

                if (empty($assetData['kategori_aset']) || !in_array($assetData['kategori_aset'], ['asset', 'non-asset'])) {
                    $rowErrors[] = "Kategori Aset mesti 'asset' atau 'non-asset'";
                }

                if (empty($assetData['tarikh_perolehan'])) {
                    $rowErrors[] = "Tarikh Perolehan diperlukan";
                } else {
                    try {
                        $tarikhPerolehan = \Carbon\Carbon::parse($assetData['tarikh_perolehan']);
                    } catch (\Exception $e) {
                        $rowErrors[] = "Format tarikh perolehan tidak sah (YYYY-MM-DD)";
                    }
                }

                // Field validation helper
                $validateDate = function ($date, $field) use (&$rowErrors) {
                    if (!empty($date)) {
                        try {
                            \Carbon\Carbon::parse($date);
                        } catch (\Exception $e) {
                            $rowErrors[] = "Format $field tidak sah (YYYY-MM-DD)";
                        }
                    }
                };

                $validateDate($assetData['tarikh_pemeriksaan_terakhir'], 'tarikh pemeriksaan terakhir');
                $validateDate($assetData['tarikh_penyelenggaraan_akan_datang'], 'tarikh penyelenggaraan');
                $validateDate($assetData['tarikh_resit'], 'tarikh resit');
                $validateDate($assetData['tarikh_tamat_jaminan'], 'tarikh tamat jaminan');

                $validLocations = ['Anjung kiri', 'Anjung kanan', 'Anjung Depan(Ruang Pengantin)', 'Ruang Utama (tingkat atas, tingkat bawah)', 'Bilik Mesyuarat', 'Bilik Kuliah', 'Bilik Bendahari', 'Bilik Setiausaha', 'Bilik Nazir & Imam', 'Bangunan Jenazah', 'Lain-lain'];
                if (empty($assetData['lokasi_penempatan']) || !in_array($assetData['lokasi_penempatan'], $validLocations)) {
                    $rowErrors[] = "Lokasi Penempatan tidak sah";
                }

                if (empty($assetData['pegawai_bertanggungjawab_lokasi']))
                    $rowErrors[] = "Pegawai Bertanggungjawab diperlukan";
                if (empty($assetData['kaedah_perolehan']))
                    $rowErrors[] = "Kaedah Perolehan diperlukan";

                // Generate ID if valid basic info
                if (empty($rowErrors)) {
                    $year = $tarikhPerolehan->format('y');
                    $offsetKey = "{$assetData['masjid_surau_id']}_{$assetData['jenis_aset']}_{$year}";
                    $currentOffset = $sequenceOffsets[$offsetKey] ?? 0;

                    $assetData['no_siri_pendaftaran'] = AssetRegistrationNumber::generate(
                        $assetData['masjid_surau_id'],
                        $assetData['jenis_aset'],
                        $year,
                        $currentOffset
                    );

                    // Increment offset for this key
                    $sequenceOffsets[$offsetKey] = $currentOffset + 1;

                    // Check duplicate
                    if (Asset::where('no_siri_pendaftaran', $assetData['no_siri_pendaftaran'])->exists()) {
                        // Note: If we are just previewing, this check is against DB. 
                        // Since we assume generating NEW IDs, existence means meaningful collision or logic error.
                        // But for preview of NEXT item, it shouldn't exist unless race condition.
                        // However, if the generated ID exists, we report it.
                        $rowErrors[] = "Nombor siri pendaftaran dijana sudah wujud: {$assetData['no_siri_pendaftaran']}";
                    }
                }

                // Conversions
                $assetData['nilai_perolehan'] = (float) ($assetData['nilai_perolehan'] ?? 0);
                $assetData['diskaun'] = (float) ($assetData['diskaun'] ?? 0);
                $assetData['umur_faedah_tahunan'] = !empty($assetData['umur_faedah_tahunan']) ? (int) $assetData['umur_faedah_tahunan'] : null;
                $assetData['susut_nilai_tahunan'] = !empty($assetData['susut_nilai_tahunan']) ? (float) $assetData['susut_nilai_tahunan'] : null;

                $processedRow = [
                    'row' => $rowNumber,
                    'data' => $assetData,
                    'valid' => empty($rowErrors),
                    'errors' => array_map(function ($e) use ($rowNumber) {
                        return "Baris $rowNumber: $e"; }, $rowErrors)
                ];

                $processedRows[] = $processedRow;

                if (empty($rowErrors)) {
                    $validRows[] = $processedRow;
                } else {
                    $errorRows[] = $processedRow;
                }

            } catch (\Exception $e) {
                $processedRows[] = [
                    'row' => $rowNumber,
                    'data' => $row, // Raw data on crash
                    'valid' => false,
                    'errors' => ["Baris $rowNumber: Ralat Sistem - " . $e->getMessage()]
                ];
                $errorRows[] = end($processedRows);
            }
        }

        return [
            'rows' => $processedRows,
            'valid_rows' => $validRows,
            'errors' => $errorRows,
            'skipped_count' => $skippedCount
        ];
    }
}
