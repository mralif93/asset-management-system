<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ImmovableAsset;
use App\Models\MasjidSurau;
use App\Helpers\AssetRegistrationNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImmovableAssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ImmovableAsset::with('masjidSurau');

        // Admin can see all assets

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama_aset', 'like', "%{$searchTerm}%")
                    ->orWhere('no_siri_pendaftaran', 'like', "%{$searchTerm}%")
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

        $assetsGroups = clone $query;
        $assetsGroups = $assetsGroups->selectRaw('MIN(id) as id, nama_aset, alamat')
            ->groupBy('nama_aset', 'alamat')
            ->pluck('id');

        $immovableAssets = ImmovableAsset::whereIn('id', $assetsGroups)
            ->latest()
            ->paginate(15);

        // Preserve query parameters in pagination
        $immovableAssets->appends($request->query());

        // Attach siblings dynamically based on identical name and location
        foreach ($immovableAssets as $asset) {
            $siblings = ImmovableAsset::where('nama_aset', $asset->nama_aset)
                ->where('alamat', $asset->alamat)
                ->orderBy('no_siri_pendaftaran')
                ->get();
            $asset->setRelation('batchSiblings', $siblings);
            $asset->batch_siblings_count = $siblings->count();
            $asset->batch_siblings_sum_kos_perolehan = $siblings->sum('kos_perolehan');
        }

        return view('admin.immovable-assets.index', compact('immovableAssets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $masjidSuraus = MasjidSurau::all();

        // Set default to Masjid Al-Hidayah, Taman Melawati
        $defaultMasjid = MasjidSurau::where('nama', 'like', '%Al-Hidayah%')
            ->where('nama', 'like', '%Taman Melawati%')
            ->first();
        $default_masjid_surau_id = $defaultMasjid ? $defaultMasjid->id : (auth()->user()->masjid_surau_id ?? null);

        return view('admin.immovable-assets.create', compact('masjidSuraus', 'default_masjid_surau_id'));
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
            'luas_tanah_bangunan' => 'nullable|numeric|min:0',
            'keluasan_tanah' => 'nullable|numeric|min:0',
            'keluasan_bangunan' => 'nullable|numeric|min:0',
            'tarikh_perolehan' => 'required|date',
            'sumber_perolehan' => 'required|string|in:' . implode(',', \App\Helpers\SystemData::getAcquisitionSources()),
            'kos_perolehan' => 'required|numeric|min:0',
            'keadaan_semasa' => 'required|string|in:' . implode(',', \App\Helpers\SystemData::getPhysicalConditions()),
            'catatan' => 'nullable|string',
            'gambar_aset' => 'nullable|array|max:5',
            'gambar_aset.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Combine keluasan_tanah and keluasan_bangunan if provided separately
        $luas = $validated['luas_tanah_bangunan'] ?? 0;
        $tanah = $validated['keluasan_tanah'] ?? 0;
        $bangunan = $validated['keluasan_bangunan'] ?? 0;

        if ($luas == 0 && ($tanah > 0 || $bangunan > 0)) {
            $validated['luas_tanah_bangunan'] = $tanah + $bangunan;
        }

        // Ensure luas_tanah_bangunan is set
        if (!isset($validated['luas_tanah_bangunan'])) {
            $validated['luas_tanah_bangunan'] = 0;
        }

        // Remove the separate fields
        unset($validated['keluasan_tanah'], $validated['keluasan_bangunan']);

        // Generate registration number
        $tarikhPerolehan = new \Carbon\Carbon($validated['tarikh_perolehan']);
        $validated['no_siri_pendaftaran'] = AssetRegistrationNumber::generateImmovable(
            $validated['masjid_surau_id'],
            $tarikhPerolehan->format('y')
        );

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
            ->with('success', 'Aset tak alih berjaya didaftarkan dengan nombor siri: ' . $immovableAsset->no_siri_pendaftaran);
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
            'sumber_perolehan' => 'required|string|in:' . implode(',', \App\Helpers\SystemData::getAcquisitionSources()),
            'kos_perolehan' => 'required|numeric|min:0',
            'keadaan_semasa' => 'required|string|in:' . implode(',', \App\Helpers\SystemData::getPhysicalConditions()),
            'catatan' => 'nullable|string',
            'gambar_aset' => 'nullable|array|max:5',
            'gambar_aset.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Handle image deletions
        if ($request->has('delete_images')) {
            $imagesToDelete = is_array($request->delete_images) ? $request->delete_images : [$request->delete_images];
            $currentImages = $immovableAsset->gambar_aset ?? [];
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
            $images = $validated['gambar_aset'] ?? ($immovableAsset->gambar_aset ?? []);
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
        $immovableAsset->delete();

        return redirect()->route('admin.immovable-assets.index')
            ->with('success', 'Rekod aset tak alih berjaya dipadamkan.');
    }

    /**
     * Export immovable assets to Excel
     */
    public function export(Request $request)
    {
        $filename = 'immovable_assets_export_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\ImmovableAssetExport($request), $filename);
    }

    /**
     * Download import template
     */
    public function downloadTemplate()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\ImmovableAssetImportTemplateExport, 'template_import_aset_tak_alih.xlsx');
    }

    /**
     * Show import form
     */
    public function showImport()
    {
        $masjidSuraus = MasjidSurau::all();

        return view('admin.immovable-assets.import', compact('masjidSuraus'));
    }

    /**
     * Import immovable assets from Excel
     */
    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt,xlsx,xls|max:51200',
        ]);

        $file = $request->file('csv_file');

        try {
            $sheets = \Maatwebsite\Excel\Facades\Excel::toArray(new \App\Imports\ImmovableAssetImport, $file);
            $rows = $sheets[0] ?? [];
        } catch (\Exception $e) {
            return redirect()->route('admin.immovable-assets.import')
                ->with('error', 'Gagal membaca fail: ' . $e->getMessage());
        }

        $result = $this->processImportRows($rows);

        if (count($result['errors']) > 0) {
            $displayErrors = [];
            foreach ($result['errors'] as $rowErrors) {
                foreach ($rowErrors['errors'] as $error) {
                    $displayErrors[] = $error;
                }
            }

            return redirect()->route('admin.immovable-assets.import')
                ->with('import_errors', $displayErrors)
                ->with('error', 'Terdapat ralat dalam fail import. Sila semak dan cuba lagi.')
                ->withInput();
        }

        // Process valid rows
        $createdCount = 0;
        foreach ($result['valid_rows'] as $row) {
            try {
                ImmovableAsset::create($row['data']);
                $createdCount++;
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Immovable Asset Import Failed: ' . $e->getMessage());
            }
        }

        return redirect()->route('admin.immovable-assets.index')
            ->with('success', "Import selesai. {$createdCount} aset tak alih baru ditambah.");
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
            $sheets = \Maatwebsite\Excel\Facades\Excel::toArray(new \App\Imports\ImmovableAssetImport, $file);
            $rows = $sheets[0] ?? [];

            $result = $this->processImportRows($rows);

            return response()->json([
                'success' => true,
                'data' => $result['rows'],
                'summary' => [
                    'total' => count($rows) - 1,
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
     * Process import rows
     */
    private function processImportRows($rows)
    {
        $processedRows = [];
        $validRows = [];
        $errorRows = [];
        $skippedCount = 0;

        // Skip header
        array_shift($rows);

        foreach ($rows as $index => $row) {
            $rowNumber = $index + 2;
            $rowErrors = [];

            if (empty(array_filter($row, fn($v) => !is_null($v) && $v !== ''))) {
                $skippedCount++;
                continue;
            }

            try {
                $masjidSurauId = $row[0] ?? null;
                $masjidSurau = MasjidSurau::find($masjidSurauId);

                $data = [
                    'masjid_surau_id' => $masjidSurauId,
                    'nama_aset' => $row[1] ?? null,
                    'jenis_aset' => $row[2] ?? null,
                    'alamat' => $row[3] ?? null,
                    'no_hakmilik' => $row[4] ?? null,
                    'no_lot' => $row[5] ?? null,
                    'luas_tanah_bangunan' => $row[6] ?? 0,
                    'tarikh_perolehan' => $row[7] ?? null,
                    'sumber_perolehan' => $row[8] ?? null,
                    'kos_perolehan' => $row[9] ?? 0,
                    'keadaan_semasa' => $row[10] ?? 'Baik',
                    'catatan' => $row[11] ?? null,
                ];

                // Validation
                if (empty($data['nama_aset'])) {
                    $rowErrors[] = "Nama Aset diperlukan";
                }

                if (!$masjidSurau) {
                    $rowErrors[] = "Masjid/Surau ID tidak sah";
                }

                $validJenis = ['Tanah', 'Bangunan', 'Tanah dan Bangunan'];
                if (empty($data['jenis_aset']) || !in_array($data['jenis_aset'], $validJenis)) {
                    $rowErrors[] = "Jenis Aset tidak sah (Pilih: Tanah, Bangunan, atau Tanah dan Bangunan)";
                }

                // Date parsing
                if (empty($data['tarikh_perolehan'])) {
                    $rowErrors[] = "Tarikh Perolehan diperlukan";
                } else {
                    try {
                        if (is_numeric($data['tarikh_perolehan'])) {
                            $dt = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($data['tarikh_perolehan']);
                            $data['tarikh_perolehan'] = $dt->format('Y-m-d');
                        } elseif (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $data['tarikh_perolehan'])) {
                            $data['tarikh_perolehan'] = \Carbon\Carbon::createFromFormat('d/m/Y', $data['tarikh_perolehan'])->format('Y-m-d');
                        } else {
                            $data['tarikh_perolehan'] = \Carbon\Carbon::parse($data['tarikh_perolehan'])->format('Y-m-d');
                        }
                    } catch (\Exception $e) {
                        $rowErrors[] = "Format tarikh perolehan tidak sah";
                    }
                }

                // Numeric cleaning
                $data['luas_tanah_bangunan'] = (float) str_replace(',', '', (string) ($data['luas_tanah_bangunan'] ?? 0));
                $data['kos_perolehan'] = (float) str_replace(',', '', (string) ($data['kos_perolehan'] ?? 0));

                // Registration number generation
                if (empty($rowErrors)) {
                    $y = (new \Carbon\Carbon($data['tarikh_perolehan']))->format('y');
                    $data['no_siri_pendaftaran'] = AssetRegistrationNumber::generateImmovable($data['masjid_surau_id'], $y);

                    if (ImmovableAsset::where('no_siri_pendaftaran', $data['no_siri_pendaftaran'])->exists()) {
                        $rowErrors[] = "Nombor siri pendaftaran sudah wujud: {$data['no_siri_pendaftaran']}";
                    }
                }

                $processedRow = [
                    'row' => $rowNumber,
                    'data' => $data,
                    'valid' => empty($rowErrors),
                    'errors' => array_map(fn($e) => "Baris $rowNumber: $e", $rowErrors),
                    'display_data' => [
                        'nama_aset' => $data['nama_aset'] ?: '-',
                        'masjid' => $masjidSurau ? $masjidSurau->nama : "ID: " . $data['masjid_surau_id'],
                        'jenis' => $data['jenis_aset'] ?: '-',
                        'tarikh' => $data['tarikh_perolehan'] ?: '-'
                    ]
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

    /**
     * padamAsetTerpilih(): Delete multiple selected immovable assets from the system
     */
    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'asset_ids' => 'required|array|min:1',
            'asset_ids.*' => 'exists:immovable_assets,id'
        ]);

        $deletedCount = ImmovableAsset::whereIn('id', $validated['asset_ids'])->delete();

        return redirect()->route('admin.immovable-assets.index')
            ->with('success', "Berjaya memadamkan {$deletedCount} aset tak alih yang dipilih.");
    }
}
