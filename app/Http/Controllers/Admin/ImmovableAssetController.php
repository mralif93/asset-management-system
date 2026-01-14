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
            'csv_file' => 'required|file|mimes:csv,txt,xlsx,xls|max:51200', // Allow Excel
        ]);

        $file = $request->file('csv_file');

        try {
            // Use Laravel Excel to convert file to array
            $sheets = \Maatwebsite\Excel\Facades\Excel::toArray(new \App\Imports\ImmovableAssetImport, $file);
            $rows = $sheets[0] ?? []; // Get first sheet
        } catch (\Exception $e) {
            return redirect()->route('admin.immovable-assets.import')
                ->with('error', 'Gagal membaca fail: ' . $e->getMessage());
        }

        $errors = [];
        $successCount = 0;
        $skipCount = 0;

        // Skip header row
        array_shift($rows);

        $rowIndex = 0;

        foreach ($rows as $row) {
            $rowIndex++;
            $rowNumber = $rowIndex + 1;

            // Skip empty rows
            if (empty(array_filter($row, function ($value) {
                return !is_null($value) && $value !== ''; }))) {
                $skipCount++;
                continue;
            }

            try {
                // Map columns
                $assetData = [
                    'masjid_surau_id' => $row[0] ?? null,
                    'nama_aset' => $row[1] ?? null,
                    'jenis_aset' => $row[2] ?? null,
                    'alamat' => $row[3] ?? null,
                    'no_hakmilik' => $row[4] ?? null,
                    'no_lot' => $row[5] ?? null,
                    'luas_tanah_bangunan' => $row[6] ?? null,
                    'tarikh_perolehan' => $row[7] ?? null,
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

                // Validate date format (Excel might return internal date, but since we use ToArray it might be raw string if cell is text, or calculation if general. 
                // However, standard PHPSpreadsheet handles dates nicely usually returning serial or string depending on options.
                // Since we didn't specify date formatting in Import, we assume input is YYYY-MM-DD string or recognizable.
                // If Excel returns numeric date, we might need handling. For simplicity assuming text input YYYY-MM-DD as per template instructions.
                try {
                    // Check if it's numeric (Excel date serial)
                    if (is_numeric($assetData['tarikh_perolehan'])) {
                        $tarikhPerolehan = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($assetData['tarikh_perolehan']);
                    } else {
                        $tarikhPerolehan = \Carbon\Carbon::parse($assetData['tarikh_perolehan']);
                    }
                    $assetData['tarikh_perolehan'] = $tarikhPerolehan->format('Y-m-d');

                } catch (\Exception $e) {
                    $errors[] = "Baris {$rowNumber}: Format tarikh perolehan tidak sah. Gunakan format YYYY-MM-DD";
                    continue;
                }

                // Validate source
                $validSources = \App\Helpers\SystemData::getAcquisitionSources();
                if (!empty($assetData['sumber_perolehan']) && !in_array($assetData['sumber_perolehan'], $validSources)) {
                    $errors[] = "Baris {$rowNumber}: Sumber Perolehan tidak sah. Sila gunakan: " . implode(', ', $validSources);
                    continue;
                }

                // Validate condition
                $validConditions = \App\Helpers\SystemData::getPhysicalConditions();
                if (!empty($assetData['keadaan_semasa']) && !in_array($assetData['keadaan_semasa'], $validConditions)) {
                    $errors[] = "Baris {$rowNumber}: Keadaan Semasa tidak sah. Sila gunakan: " . implode(', ', $validConditions);
                    continue;
                }

                // Generate registration number
                $assetData['no_siri_pendaftaran'] = AssetRegistrationNumber::generateImmovable(
                    $assetData['masjid_surau_id'],
                    (new \Carbon\Carbon($assetData['tarikh_perolehan']))->format('y')
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
