<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AssetMovement;
use App\Models\MasjidSurau;
use App\Services\NotificationService;
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
            'approvedByDestinasi',
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

        $originId = request('origin_masjid_surau_id', request('masjid_surau_asal_id'));
        if (!empty($originId)) {
            $query->where('masjid_surau_asal_id', $originId);
        }

        $destinationId = request('destination_masjid_surau_id', request('masjid_surau_destinasi_id'));
        if (!empty($destinationId)) {
            $query->where('masjid_surau_destinasi_id', $destinationId);
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
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\AssetMovementExport($request), 'pergerakan-aset-' . now()->format('Y-m-d') . '.xlsx');
    }

    /**
     * Download import template
     */
    public function downloadTemplate()
    {
        $headers = [
            'ID Aset',
            'No. Siri Pendaftaran (Wajib)',
            'Jenis Pergerakan (Pemindahan/Peminjaman/Pulangan)',
            'Kuantiti',
            'ID Masjid/Surau Asal',
            'ID Masjid/Surau Destinasi',
            'Tarikh Permohonan (DD/MM/YYYY)',
            'Tarikh Pergerakan (DD/MM/YYYY)',
            'Tarikh Jangka Pulang (DD/MM/YYYY)',
            'Lokasi Asal Spesifik',
            'Lokasi Destinasi Spesifik',
            'Nama Peminjam/Pegawai Bertanggungjawab',
            'Tujuan Pergerakan',
            'Catatan',
        ];

        $callback = function () use ($headers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);
            fclose($file);
        };

        return response()->stream($callback, 200, [
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=template_import_pergerakan_aset.csv',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ]);
    }

    /**
     * Show import form
     */
    public function showImport()
    {
        $masjidSuraus = MasjidSurau::all();

        return view('admin.asset-movements.import', compact('masjidSuraus'));
    }

    /**
     * Import asset movements from file
     */
    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt,xlsx,xls|max:51200',
        ]);

        $file = $request->file('csv_file');

        try {
            $sheets = \Maatwebsite\Excel\Facades\Excel::toArray(new \App\Imports\AssetMovementImport, $file);
            $rows = $sheets[0] ?? [];
        } catch (\Exception $e) {
            return redirect()->route('admin.asset-movements.import')
                ->with('error', 'Gagal membaca fail: ' . $e->getMessage());
        }

        $result = $this->processImportRows($rows);

        // Only block on hard errors (not duplicates/warnings)
        $hardErrors = array_filter($result['errors'], fn($r) => empty($r['existing_id']));
        if (count($hardErrors) > 0) {
            $displayErrors = [];
            foreach ($result['errors'] as $rowErrors) {
                foreach ($rowErrors['errors'] as $error) {
                    $displayErrors[] = $error;
                }
            }

            return redirect()->route('admin.asset-movements.import')
                ->with('import_errors', $displayErrors)
                ->with('error', 'Terdapat ralat dalam fail import. Sila semak dan cuba lagi.')
                ->withInput();
        }

        // Process valid rows
        $createdCount = 0;
        $updatedCount = 0;

        foreach ($result['valid_rows'] as $row) {
            try {
                if (!empty($row['existing_id'])) {
                    $movement = AssetMovement::find($row['existing_id']);
                    if ($movement) {
                        $movement->update($row['data']);
                        $updatedCount++;
                    }
                } else {
                    AssetMovement::create($row['data']);
                    $createdCount++;
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Asset Movement Import Failed: ' . $e->getMessage());
            }
        }

        $message = 'Import selesai. ';
        if ($createdCount > 0) {
            $message .= "{$createdCount} rekod pergerakan baru ditambah. ";
        }
        if ($updatedCount > 0) {
            $message .= "{$updatedCount} rekod pergerakan dikemaskini.";
        }

        return redirect()->route('admin.asset-movements.index')
            ->with('success', rtrim($message));
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
            $sheets = \Maatwebsite\Excel\Facades\Excel::toArray(new \App\Imports\AssetMovementImport, $file);
            $rows = $sheets[0] ?? [];

            $result = $this->processImportRows($rows);

            $warningsCount = count(array_filter($result['rows'], function ($r) {
                return !empty($r['warnings']);
            }));

            return response()->json([
                'success' => true,
                'data' => $result['rows'],
                'summary' => [
                    'total' => count($rows) - 1,
                    'valid' => count($result['valid_rows']),
                    'invalid' => count($result['errors']),
                    'skipped' => $result['skipped_count'],
                    'warnings' => $warningsCount,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
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
        $rowWarnings = [];

        // Skip header
        array_shift($rows);

        foreach ($rows as $index => $row) {
            $rowNumber = $index + 2;
            $rowErrors = [];

            if (empty(array_filter($row, fn($v) => !is_null($v) && $v !== ''))) {
                $skippedCount++;

                continue;
            }

            $rowErrors = [];
            $existingMovement = null;

            try {
                $noSiri = $row[1] ?? null;
                $asset = null;

                if (!empty($noSiri)) {
                    $asset = Asset::where('no_siri_pendaftaran', $noSiri)->first();
                } elseif (!empty($row[0])) {
                    $asset = Asset::find($row[0]);
                }

                if (!$asset) {
                    $rowErrors[] = "Aset tidak ditemui (No. Siri: $noSiri)";
                } else {
                    // Check if asset already has active movement
                    $existingMovement = \App\Models\AssetMovement::where('asset_id', $asset->id)
                        ->whereIn('status_pergerakan', ['Dimohon', 'Diluluskan'])
                        ->first();
                    if ($existingMovement) {
                        $rowWarnings[$rowNumber] = "Aset ini sedang dalam pergerakan aktif (Status: {$existingMovement->status_pergerakan})";
                    }
                }

                $data = [
                    'asset_id' => $asset ? $asset->id : null,
                    'user_id' => Auth::id(),
                    'jenis_pergerakan' => $row[2] ?? null,
                    'kuantiti' => $row[3] ?? 1,
                    'origin_masjid_surau_id' => $row[4] ?? ($asset ? $asset->masjid_surau_id : null),
                    'destination_masjid_surau_id' => $row[5] ?? null,
                    'tarikh_permohonan' => $row[6] ?? now()->format('Y-m-d'),
                    'tarikh_pergerakan' => $row[7] ?? null,
                    'tarikh_jangka_pulang' => $row[8] ?? null,
                    'lokasi_asal_spesifik' => $row[9] ?? ($asset ? $asset->lokasi_penempatan : null),
                    'lokasi_destinasi_spesifik' => $row[10] ?? null,
                    'nama_peminjam_pegawai_bertanggungjawab' => $row[11] ?? null,
                    'tujuan_pergerakan' => $row[12] ?? null,
                    'catatan' => $row[13] ?? null,
                    'status_pergerakan' => 'menunggu_kelulusan',
                ];

                // Validation
                if (empty($data['jenis_pergerakan']) || !in_array($data['jenis_pergerakan'], ['Pemindahan', 'Peminjaman', 'Pulangan'])) {
                    $rowErrors[] = 'Jenis Pergerakan tidak sah (Pilih: Pemindahan, Peminjaman, atau Pulangan)';
                }

                if (empty($data['origin_masjid_surau_id']) || !MasjidSurau::find($data['origin_masjid_surau_id'])) {
                    $rowErrors[] = 'ID Masjid/Surau Asal tidak sah';
                }

                if ($data['jenis_pergerakan'] !== 'Pulangan' && (empty($data['destination_masjid_surau_id']) || !MasjidSurau::find($data['destination_masjid_surau_id']))) {
                    $rowErrors[] = 'ID Masjid/Surau Destinasi tidak sah';
                }

                $formatDate = function ($date, $field) use (&$rowErrors) {
                    if (empty($date)) {
                        return null;
                    }
                    try {
                        if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $date)) {
                            return \Carbon\Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
                        }

                        return \Carbon\Carbon::parse($date)->format('Y-m-d');
                    } catch (\Exception $e) {
                        $rowErrors[] = "Format tarikh $field tidak sah";

                        return null;
                    }
                };

                $data['tarikh_permohonan'] = $formatDate($data['tarikh_permohonan'], 'permohonan');
                $data['tarikh_pergerakan'] = $formatDate($data['tarikh_pergerakan'], 'pergerakan');
                $data['tarikh_jangka_pulang'] = $formatDate($data['tarikh_jangka_pulang'], 'jangka pulang');

                // Numeric cleaning
                $data['kuantiti'] = (int) str_replace(',', '', (string) ($data['kuantiti'] ?? 1));

                $processedRow = [
                    'row' => $rowNumber,
                    'data' => $data,
                    'existing_id' => ($existingMovement ?? null) ? $existingMovement->id : null,
                    'valid' => empty($rowErrors) && empty($rowWarnings[$rowNumber]),
                    'errors' => array_map(fn($e) => "Baris $rowNumber: $e", $rowErrors),
                    'warnings' => $rowWarnings[$rowNumber] ?? null,
                    'display_data' => [
                        'nama_aset' => $asset ? $asset->nama_aset : '-',
                        'no_siri' => $noSiri,
                        'jenis' => $data['jenis_pergerakan'],
                        'kuantiti' => $data['kuantiti'],
                    ],
                ];

                $processedRows[] = $processedRow;
                // Warned rows = duplicates → update during import
                if (!empty($rowWarnings[$rowNumber])) {
                    $validRows[] = $processedRow;
                } elseif (empty($rowErrors)) {
                    $validRows[] = $processedRow;
                } else {
                    $errorRows[] = $processedRow;
                }

            } catch (\Exception $e) {
                $processedRows[] = [
                    'row' => $rowNumber,
                    'valid' => false,
                    'errors' => ["Baris $rowNumber: Ralat Sistem - " . $e->getMessage()],
                ];
                $errorRows[] = end($processedRows);
            }
        }

        return [
            'rows' => $processedRows,
            'valid_rows' => $validRows,
            'errors' => $errorRows,
            'skipped_count' => $skippedCount,
        ];
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
                'status' => 'Aktif',
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
            NotificationService::notifyNewAssetMovementRequest(AssetMovement::find($movementIds[0]));

            return redirect()->route('admin.asset-movements.index')
                ->with('success', count($movementIds) . ' pergerakan aset berjaya didaftarkan secara berkelompok.');
        }

        NotificationService::notifyNewAssetMovementRequest($movement);

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
            'approvedByDestinasi',
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

        NotificationService::notifyAssetMovementApproved($assetMovement);

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

        NotificationService::notifyAssetMovementRejected($assetMovement, $validated['catatan']);

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
            'masjid_surau_id' => $assetMovement->origin_masjid_surau_id,
        ]);

        return redirect()->route('admin.asset-movements.show', $assetMovement)
            ->with('success', 'Kepulangan aset telah direkodkan.');
    }

    /**
     * Bulk approve asset movements.
     */
    public function bulkApprove(Request $request)
    {
        $validated = $request->validate([
            'movement_ids' => 'required|array',
            'movement_ids.*' => 'exists:asset_movements,id',
            'catatan' => 'nullable|string',
        ]);

        $user = Auth::user();
        $approvedCount = 0;

        foreach ($validated['movement_ids'] as $movementId) {
            $movement = AssetMovement::find($movementId);

            if ($movement && $movement->status_pergerakan === 'menunggu_kelulusan') {
                $movement->update([
                    'status_pergerakan' => 'diluluskan',
                    'pegawai_meluluskan' => $user->name,
                    'catatan' => $validated['catatan']
                        ? $movement->catatan . "\n[Lulus]: " . $validated['catatan']
                        : $movement->catatan,
                ]);
                $approvedCount++;
            }
        }

        return redirect()->route('admin.asset-movements.index')
            ->with('success', $approvedCount . ' pergerakan aset berjaya diluluskan.');
    }

    /**
     * Bulk reject asset movements.
     */
    public function bulkReject(Request $request)
    {
        $validated = $request->validate([
            'movement_ids' => 'required|array',
            'movement_ids.*' => 'exists:asset_movements,id',
            'catatan' => 'required|string',
        ]);

        $user = Auth::user();
        $rejectedCount = 0;

        foreach ($validated['movement_ids'] as $movementId) {
            $movement = AssetMovement::find($movementId);

            if ($movement && $movement->status_pergerakan === 'menunggu_kelulusan') {
                $movement->update([
                    'status_pergerakan' => 'ditolak',
                    'pegawai_meluluskan' => $user->name,
                    'catatan' => $movement->catatan . "\n[Ditolak]: " . $validated['catatan'],
                ]);
                $rejectedCount++;
            }
        }

        return redirect()->route('admin.asset-movements.index')
            ->with('success', $rejectedCount . ' pergerakan aset telah ditolak.');
    }

    /**
     * Display a listing of trashed asset movements.
     */
    public function trashed()
    {
        $trashedMovements = AssetMovement::onlyTrashed()
            ->with([
                'asset',
                'asset.masjidSurau',
                'masjidSurauAsal',
                'masjidSurauDestinasi',
            ])
            ->latest()
            ->paginate(15);

        return view('admin.asset-movements.trashed', compact('trashedMovements'));
    }

    /**
     * Restore a soft-deleted asset movement.
     */
    public function restore($id)
    {
        $movement = AssetMovement::onlyTrashed()->findOrFail($id);
        $movement->restore();

        return redirect()->route('admin.asset-movements.trashed')
            ->with('success', 'Pergerakan aset berjaya dipulihkan.');
    }
}
