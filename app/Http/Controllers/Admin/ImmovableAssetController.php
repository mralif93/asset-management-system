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
            'sumber_perolehan' => 'required|string',
            'kos_perolehan' => 'required|numeric|min:0',
            'keadaan_semasa' => 'required|string',
            'catatan' => 'nullable|string',
            'gambar_aset' => 'nullable|array|max:5',
            'gambar_aset.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Combine keluasan_tanah and keluasan_bangunan if provided separately
        if (!$validated['luas_tanah_bangunan'] && ($validated['keluasan_tanah'] || $validated['keluasan_bangunan'])) {
            $validated['luas_tanah_bangunan'] = ($validated['keluasan_tanah'] ?? 0) + ($validated['keluasan_bangunan'] ?? 0);
        }

        // Ensure luas_tanah_bangunan is set
        if (!$validated['luas_tanah_bangunan']) {
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
            'sumber_perolehan' => 'required|string',
            'kos_perolehan' => 'required|numeric|min:0',
            'keadaan_semasa' => 'required|string',
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
     * Export immovable assets to CSV
     */
    public function export(Request $request)
    {
        $query = ImmovableAsset::with('masjidSurau');

        // Apply same filters as index
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

        if ($request->filled('jenis_aset')) {
            $query->where('jenis_aset', $request->jenis_aset);
        }

        if ($request->filled('keadaan_semasa')) {
            $query->where('keadaan_semasa', $request->keadaan_semasa);
        }

        $immovableAssets = $query->latest()->limit(10000)->get(); // Limit to prevent memory issues

        $filename = 'immovable_assets_export_' . now()->format('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($immovableAssets) {
            $file = fopen('php://output', 'w');

            // Add BOM for UTF-8 to support Malay characters
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Write CSV headers - matching import template order and format
            fputcsv($file, [
                'Masjid/Surau ID',
                'Nama Aset',
                'Jenis Aset (Tanah/Bangunan/Tanah dan Bangunan)',
                'Alamat',
                'No. Hakmilik',
                'No. Lot',
                'Luas Tanah/Bangunan (m²)',
                'Tarikh Perolehan (DD/MM/YYYY)',
                'Sumber Perolehan (Pembelian/Hibah/Wakaf/Derma/Lain-lain)',
                'Kos Perolehan (RM)',
                'Keadaan Semasa (Sangat Baik/Baik/Sederhana/Perlu Pembaikan/Rosak)',
                'Catatan'
            ]);

            // Write data rows - matching import template column order
            foreach ($immovableAssets as $asset) {
                fputcsv($file, [
                    $asset->masjid_surau_id,
                    $asset->nama_aset,
                    $asset->jenis_aset,
                    $asset->alamat ?? '',
                    $asset->no_hakmilik ?? '',
                    $asset->no_lot ?? '',
                    number_format($asset->luas_tanah_bangunan ?? 0, 2),
                    $asset->tarikh_perolehan ? $asset->tarikh_perolehan->format('d/m/Y') : '',
                    $asset->sumber_perolehan ?? '',
                    number_format($asset->kos_perolehan ?? 0, 2),
                    $asset->keadaan_semasa ?? '',
                    $asset->catatan ?? ''
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
        $filename = 'immovable_assets_import_template_' . now()->format('Y-m-d') . '.csv';

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
                'Jenis Aset (Tanah/Bangunan/Tanah dan Bangunan)',
                'Alamat',
                'No. Hakmilik',
                'No. Lot',
                'Luas Tanah/Bangunan (m²)',
                'Tarikh Perolehan (DD/MM/YYYY)',
                'Sumber Perolehan (Pembelian/Hibah/Wakaf/Derma/Lain-lain)',
                'Kos Perolehan (RM)',
                'Keadaan Semasa (Sangat Baik/Baik/Sederhana/Perlu Pembaikan/Rosak)',
                'Catatan'
            ]);

            // Add example row
            $masjidSuraus = MasjidSurau::limit(1)->first();

            fputcsv($file, [
                $masjidSuraus->id ?? '1',
                'Contoh: Tanah Masjid',
                'Tanah',
                'Jalan Contoh, Taman Contoh',
                '12345',
                'Lot 123',
                '500.00',
                date('Y-m-d'),
                'Pembelian',
                '100000.00',
                'Baik',
                'Contoh catatan'
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
            fputcsv($file, ['Tanah']);
            fputcsv($file, ['Bangunan']);
            fputcsv($file, ['Tanah dan Bangunan']);
            fputcsv($file, []);

            // 2. Asset Category Reference  
            fputcsv($file, ['--- KATEGORI ASET SAH ---']);
            fputcsv($file, ['asset', '(Aset bernilai)']);
            fputcsv($file, ['non-asset', '(Bukan aset)']);
            fputcsv($file, []);

            // 3. Source Reference
            fputcsv($file, ['--- SUMBER PEROLEHAN SAH ---']);
            fputcsv($file, ['Pembelian']);
            fputcsv($file, ['Hibah']);
            fputcsv($file, ['Wakaf']);
            fputcsv($file, ['Derma']);
            fputcsv($file, ['Lain-lain']);
            fputcsv($file, []);

            // 4. Condition Reference
            fputcsv($file, ['--- KEADAAN SEMASA SAH ---']);
            fputcsv($file, ['Sangat Baik']);
            fputcsv($file, ['Baik']);
            fputcsv($file, ['Sederhana']);
            fputcsv($file, ['Perlu Pembaikan']);
            fputcsv($file, ['Rosak']);
            fputcsv($file, []);

            // Add important notes
            fputcsv($file, ['=== NOTA PENTING ===']);
            fputcsv($file, ['1. Format tarikh: YYYY-MM-DD (contoh: 2024-01-15)']);
            fputcsv($file, ['2. Pastikan Masjid/Surau ID wujud dalam sistem']);
            fputcsv($file, ['3. Nombor siri pendaftaran akan dijana automatik']);
            fputcsv($file, ['4. Gunakan nilai TEPAT seperti dalam senarai rujukan']);
            fputcsv($file, ['5. Kategori Aset: gunakan huruf kecil (asset atau non-asset)']);
            fputcsv($file, ['6. Luas dalam meter persegi (m²)']);

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

        return view('admin.immovable-assets.import', compact('masjidSuraus'));
    }

    /**
     * Import immovable assets from CSV
     */
    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:51200', // 50MB max
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();

        // Read file line by line to handle large files efficiently
        $handle = fopen($path, 'r');
        if (!$handle) {
            return redirect()->route('admin.immovable-assets.import')
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
                // Map CSV columns to immovable asset fields
                $assetData = [
                    'masjid_surau_id' => $row[0] ?? null,
                    'nama_aset' => $row[1] ?? null,
                    'jenis_aset' => $row[2] ?? null,
                    'alamat' => $row[3] ?? null,
                    'no_hakmilik' => $row[4] ?? null,
                    'no_lot' => $row[5] ?? null,
                    'luas_tanah_bangunan' => $row[6] ?? null,
                    'tarikh_perolehan' => !empty($row[7]) ? $row[7] : null,
                    'sumber_perolehan' => $row[8] ?? null,
                    'kos_perolehan' => $row[9] ?? null,
                    'keadaan_semasa' => $row[10] ?? 'Baik',
                    'catatan' => $row[11] ?? null,
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

                if (empty($assetData['jenis_aset']) || !in_array($assetData['jenis_aset'], ['Tanah', 'Bangunan', 'Tanah dan Bangunan'])) {
                    $errors[] = "Baris {$rowNumber}: Jenis Aset tidak sah. Sila gunakan: Tanah, Bangunan, atau Tanah dan Bangunan";
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

                // Validate source
                $validSources = ['Pembelian', 'Hibah', 'Wakaf', 'Derma', 'Lain-lain'];
                if (!empty($assetData['sumber_perolehan']) && !in_array($assetData['sumber_perolehan'], $validSources)) {
                    $errors[] = "Baris {$rowNumber}: Sumber Perolehan tidak sah";
                    continue;
                }

                // Validate condition
                $validConditions = ['Sangat Baik', 'Baik', 'Sederhana', 'Perlu Pembaikan', 'Rosak'];
                if (!empty($assetData['keadaan_semasa']) && !in_array($assetData['keadaan_semasa'], $validConditions)) {
                    $errors[] = "Baris {$rowNumber}: Keadaan Semasa tidak sah";
                    continue;
                }

                // Generate registration number
                $assetData['no_siri_pendaftaran'] = AssetRegistrationNumber::generateImmovable(
                    $assetData['masjid_surau_id'],
                    $tarikhPerolehan->format('y')
                );

                // Check if registration number already exists (duplicate check)
                if (ImmovableAsset::where('no_siri_pendaftaran', $assetData['no_siri_pendaftaran'])->exists()) {
                    $errors[] = "Baris {$rowNumber}: Nombor siri pendaftaran sudah wujud: {$assetData['no_siri_pendaftaran']}";
                    continue;
                }

                // Convert numeric fields
                $assetData['luas_tanah_bangunan'] = (float) ($assetData['luas_tanah_bangunan'] ?? 0);
                $assetData['kos_perolehan'] = (float) ($assetData['kos_perolehan'] ?? 0);

                // Create immovable asset
                ImmovableAsset::create($assetData);
                $successCount++;

            } catch (\Exception $e) {
                $errors[] = "Baris {$rowNumber}: " . $e->getMessage();
            }
        }

        // Close file handle
        fclose($handle);

        $message = "Import selesai. {$successCount} aset tak alih berjaya diimport.";
        if ($skipCount > 0) {
            $message .= " {$skipCount} baris kosong dilangkau.";
        }
        if (count($errors) > 0) {
            $message .= " " . count($errors) . " ralat ditemui.";
        }

        if (count($errors) > 0) {
            return redirect()->route('admin.immovable-assets.import')
                ->with('import_errors', $errors)
                ->with('success', $message)
                ->withInput();
        }

        return redirect()->route('admin.immovable-assets.index')
            ->with('success', $message);
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
