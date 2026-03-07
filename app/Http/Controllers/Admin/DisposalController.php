<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Disposal;
use App\Models\Asset;
use App\Models\MasjidSurau;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DisposalController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $this->authorize('viewAny', Disposal::class);

        $query = Disposal::with(['asset', 'asset.masjidSurau']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status_pelupusan', $request->status);
        }

        // Filter by search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('asset', function ($q) use ($search) {
                $q->where('nama_aset', 'like', "%{$search}%")
                    ->orWhere('no_siri_pendaftaran', 'like', "%{$search}%");
            });
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('tarikh_permohonan', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('tarikh_permohonan', '<=', $request->date_to);
        }

        $disposals = $query->latest()->paginate(15);

        return view('admin.disposals.index', compact('disposals'));
    }

    /**
     * Export disposals to Excel
     */
    public function export(Request $request)
    {
        $filename = 'disposals_export_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\DisposalExport($request), $filename);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Disposal::class);

        $assets = Asset::with('masjidSurau')->get();

        return view('admin.disposals.create', compact('assets'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Disposal::class);

        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'justifikasi_pelupusan' => 'required|string',
            'kaedah_pelupusan_dicadang' => 'required|string',
            'kaedah_pelupusan' => 'nullable|string',
            'tarikh_permohonan' => 'required|date',
            'nilai_pelupusan' => 'nullable|numeric|min:0',
            'nilai_baki' => 'nullable|numeric|min:0',
            'hasil_pelupusan' => 'nullable|numeric|min:0',
            'catatan' => 'nullable|string',
            'gambar_pelupusan' => 'nullable|array',
            'gambar_pelupusan.*' => 'file|mimes:pdf,jpg,jpeg,png|max:10240'
        ]);

        // Handle document uploads
        if ($request->hasFile('gambar_pelupusan')) {
            $documents = [];
            foreach ($request->file('gambar_pelupusan') as $document) {
                $path = $document->store('disposals', 'public');
                $documents[] = $path;
            }
            $validated['gambar_pelupusan'] = $documents;
        }

        // Calculate nilai_baki from asset if not provided
        if (empty($validated['nilai_baki'])) {
            $asset = Asset::find($validated['asset_id']);
            $validated['nilai_baki'] = $asset ? $asset->getCurrentValue() : 0;
        }

        // Set nilai_pelupusan from asset if not provided
        if (empty($validated['nilai_pelupusan'])) {
            $asset = Asset::find($validated['asset_id']);
            $validated['nilai_pelupusan'] = $asset ? $asset->nilai_perolehan : 0;
        }

        $validated['user_id'] = Auth::id();
        $validated['status_pelupusan'] = 'Dimohon';
        $validated['pegawai_pemohon'] = Auth::user()->name;

        $disposal = Disposal::create($validated);

        NotificationService::notifyNewDisposalRequest($disposal);

        return redirect()->route('admin.disposals.show', $disposal)
            ->with('success', 'Permohonan pelupusan berjaya dihantar.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Disposal $disposal)
    {
        $this->authorize('view', $disposal);

        $disposal->load(['asset', 'asset.masjidSurau']);

        return view('admin.disposals.show', compact('disposal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Disposal $disposal)
    {
        $this->authorize('update', $disposal);

        $assets = Asset::with('masjidSurau')->get();

        return view('admin.disposals.edit', compact('disposal', 'assets'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Disposal $disposal)
    {
        $this->authorize('update', $disposal);

        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'justifikasi_pelupusan' => 'required|string',
            'kaedah_pelupusan_dicadang' => 'required|string',
            'kaedah_pelupusan' => 'nullable|string',
            'tarikh_permohonan' => 'required|date',
            'nilai_pelupusan' => 'nullable|numeric|min:0',
            'nilai_baki' => 'nullable|numeric|min:0',
            'hasil_pelupusan' => 'nullable|numeric|min:0',
            'catatan' => 'nullable|string',
            'gambar_pelupusan' => 'nullable|array',
            'gambar_pelupusan.*' => 'file|mimes:pdf,jpg,jpeg,png|max:10240'
        ]);

        // Handle document uploads
        if ($request->hasFile('gambar_pelupusan')) {
            $documents = $disposal->gambar_pelupusan ?? [];
            foreach ($request->file('gambar_pelupusan') as $document) {
                $path = $document->store('disposals', 'public');
                $documents[] = $path;
            }
            $validated['gambar_pelupusan'] = $documents;
        }

        $disposal->update($validated);

        return redirect()->route('admin.disposals.show', $disposal)
            ->with('success', 'Permohonan pelupusan berjaya dikemaskini.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Disposal $disposal)
    {
        $this->authorize('delete', $disposal);

        $disposal->delete();

        return redirect()->route('admin.disposals.index')
            ->with('success', 'Rekod pelupusan berjaya dipadamkan.');
    }

    public function approve(Disposal $disposal)
    {
        $this->authorize('approve', $disposal);

        $disposal->update([
            'status_pelupusan' => 'Diluluskan',
            'tarikh_kelulusan_pelupusan' => now(),
            'tarikh_pelupusan' => now(),
        ]);

        // Update asset status
        $disposal->asset->update([
            'status_aset' => Asset::STATUS_DISPOSED
        ]);

        NotificationService::notifyDisposalApproved($disposal);

        return redirect()->route('admin.disposals.show', $disposal)
            ->with('success', 'Permohonan pelupusan telah diluluskan dan status aset dikemaskini.');
    }

    public function reject(Request $request, Disposal $disposal)
    {
        $this->authorize('reject', $disposal);

        $request->validate([
            'sebab_penolakan' => 'required|string'
        ]);

        $disposal->update([
            'status_pelupusan' => 'Ditolak',
            'tarikh_kelulusan_pelupusan' => now(),
            'catatan' => $disposal->catatan . "\n\nSebab Penolakan: " . $request->sebab_penolakan,
        ]);

        NotificationService::notifyDisposalRejected($disposal, $request->sebab_penolakan);

        return redirect()->route('admin.disposals.show', $disposal)
            ->with('success', 'Permohonan pelupusan telah ditolak.');
    }

    /**
     * Bulk approve disposal requests.
     */
    public function bulkApprove(Request $request)
    {
        $this->authorize('approve', Disposal::class);

        $validated = $request->validate([
            'disposal_ids' => 'required|array',
            'disposal_ids.*' => 'exists:disposals,id',
        ]);

        $approvedCount = 0;

        foreach ($validated['disposal_ids'] as $disposalId) {
            $disposal = Disposal::find($disposalId);

            if ($disposal && $disposal->status_pelupusan === 'Dimohon') {
                $disposal->update([
                    'status_pelupusan' => 'Diluluskan',
                    'tarikh_kelulusan_pelupusan' => now(),
                    'tarikh_pelupusan' => now(),
                ]);

                $disposal->asset->update([
                    'status_aset' => Asset::STATUS_DISPOSED
                ]);

                $approvedCount++;
            }
        }

        return redirect()->route('admin.disposals.index')
            ->with('success', $approvedCount . ' permohonan pelupusan berjaya diluluskan.');
    }

    /**
     * Bulk reject disposal requests.
     */
    public function bulkReject(Request $request)
    {
        $this->authorize('reject', Disposal::class);

        $validated = $request->validate([
            'disposal_ids' => 'required|array',
            'disposal_ids.*' => 'exists:disposals,id',
            'sebab_penolakan' => 'required|string',
        ]);

        $rejectedCount = 0;

        foreach ($validated['disposal_ids'] as $disposalId) {
            $disposal = Disposal::find($disposalId);

            if ($disposal && $disposal->status_pelupusan === 'Dimohon') {
                $disposal->update([
                    'status_pelupusan' => 'Ditolak',
                    'tarikh_kelulusan_pelupusan' => now(),
                    'catatan' => $disposal->catatan . "\n\nSebab Penolakan: " . $validated['sebab_penolakan'],
                ]);

                $rejectedCount++;
            }
        }

        return redirect()->route('admin.disposals.index')
            ->with('success', $rejectedCount . ' permohonan pelupusan telah ditolak.');
    }

    public function showImport()
    {
        $this->authorize('create', Disposal::class);
        $masjidSuraus = MasjidSurau::orderBy('nama')->get();
        return view('admin.disposals.import', compact('masjidSuraus'));
    }

    public function downloadTemplate()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\DisposalImportTemplateExport(), 'template_pelupusan.xlsx');
    }

    public function previewImport(Request $request)
    {
        $this->authorize('create', Disposal::class);
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,xlsx,xls'
        ]);

        $file = $request->file('csv_file');
        $sheets = \Maatwebsite\Excel\Facades\Excel::toArray(new \App\Imports\DisposalImport, $file);
        $rows = $sheets[0] ?? [];

        $result = $this->processImportRows($rows);

        return response()->json([
            'success' => true,
            'data' => $result['rows'],
            'summary' => [
                'total' => count($result['rows']),
                'valid' => count($result['valid_rows']),
                'invalid' => count($result['errors']),
                'skipped' => $result['skipped_count']
            ]
        ]);
    }

    public function import(Request $request)
    {
        $this->authorize('create', Disposal::class);
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,xlsx,xls'
        ]);

        $file = $request->file('csv_file');
        $sheets = \Maatwebsite\Excel\Facades\Excel::toArray(new \App\Imports\DisposalImport, $file);
        $rows = $sheets[0] ?? [];

        $result = $this->processImportRows($rows);

        if (count($result['errors']) > 0) {
            return back()->with('import_errors', collect($result['errors'])->pluck('errors')->flatten()->all());
        }

        foreach ($result['valid_rows'] as $row) {
            Disposal::create($row['data']);
        }

        return redirect()->route('admin.disposals.index')
            ->with('success', count($result['valid_rows']) . ' rekod pelupusan berjaya diimport.');
    }

    private function processImportRows(array $rows)
    {
        $processedRows = [];
        $validRows = [];
        $errorRows = [];
        $skippedCount = 0;

        // Skip header row
        array_shift($rows);

        foreach ($rows as $index => $row) {
            $rowNumber = $index + 2;

            // Skip empty rows
            if (empty(array_filter($row, fn($v) => !is_null($v) && $v !== ''))) {
                $skippedCount++;
                continue;
            }

            $rowErrors = [];

            try {
                $noSiri = $row[0] ?? null;
                $asset = Asset::where('no_siri_pendaftaran', $noSiri)->first();

                if (!$asset) {
                    $rowErrors[] = "No. Siri Pendaftaran Aset tidak sah atau tidak wujud.";
                }

                $formatDate = function ($date, $field) use (&$rowErrors) {
                    if (empty($date))
                        return null;
                    try {
                        if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $date)) {
                            return \Carbon\Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
                        }
                        return \Carbon\Carbon::parse($date)->format('Y-m-d');
                    } catch (\Exception $e) {
                        $rowErrors[] = "Format tarikh $field tidak sah (Gunakan DD/MM/YYYY)";
                        return null;
                    }
                };

                $data = [
                    'asset_id' => $asset ? $asset->id : null,
                    'user_id' => Auth::id(),
                    'kuantiti' => (int) ($row[1] ?? 1),
                    'tarikh_permohonan' => $formatDate($row[2] ?? null, 'permohonan'),
                    'justifikasi_pelupusan' => strtolower($row[3] ?? 'usang'),
                    'kaedah_pelupusan_dicadang' => strtolower($row[4] ?? 'jualan'),
                    'pegawai_pemohon' => $row[5] ?? Auth::user()->name,
                    'catatan' => $row[6] ?? '-',
                    'status_pelupusan' => 'Dimohon',
                ];

                if (empty($data['tarikh_permohonan']))
                    $rowErrors[] = "Tarikh Permohonan diperlukan.";

                // Validate Justifikasi
                $validJustifications = ['rosak_teruk', 'usang', 'tidak_ekonomi', 'tiada_penggunaan', 'lain_lain'];
                if (!in_array($data['justifikasi_pelupusan'], $validJustifications)) {
                    $rowErrors[] = "Justifikasi tidak sah. Pilih: " . implode(', ', $validJustifications);
                }

                // Validate Kaedah
                $validMethods = ['jualan', 'buangan', 'hadiah', 'tukar_beli', 'hapus_kira'];
                if (!in_array($data['kaedah_pelupusan_dicadang'], $validMethods)) {
                    $rowErrors[] = "Kaedah tidak sah. Pilih: " . implode(', ', $validMethods);
                }

                $processedRow = [
                    'row' => $rowNumber,
                    'data' => $data,
                    'valid' => empty($rowErrors),
                    'errors' => array_map(fn($e) => "Baris $rowNumber: $e", $rowErrors),
                    'display_data' => [
                        'no_siri' => $noSiri ?? '-',
                        'nama_aset' => $asset ? $asset->nama_aset : '-',
                        'tarikh' => $row[2] ?? '-',
                        'justifikasi' => $data['justifikasi_pelupusan'],
                        'kaedah' => $data['kaedah_pelupusan_dicadang']
                    ]
                ];

                $processedRows[] = $processedRow;
                if (empty($rowErrors))
                    $validRows[] = $processedRow;
                else
                    $errorRows[] = $processedRow;

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
}
