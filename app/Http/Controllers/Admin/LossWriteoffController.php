<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LossWriteoff;
use App\Models\Asset;
use App\Models\MasjidSurau;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class LossWriteoffController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', LossWriteoff::class);

        $query = LossWriteoff::with(['asset', 'asset.masjidSurau']);

        // Filter by masjid/surau if user is not admin
        if (Auth::user()->role !== 'administrator') {
            $query->whereHas('asset', function ($q) {
                $q->where('masjid_surau_id', Auth::user()->masjid_surau_id);
            });
        }

        $lossWriteoffs = $query->latest()->paginate(15);

        // Calculate statistics
        $statsQuery = LossWriteoff::query();

        // Apply same filter for statistics
        if (Auth::user()->role !== 'administrator') {
            $statsQuery->whereHas('asset', function ($q) {
                $q->where('masjid_surau_id', Auth::user()->masjid_surau_id);
            });
        }

        $totalLosses = $statsQuery->count();
        $pendingLosses = $statsQuery->where('status_kejadian', 'Dilaporkan')->count();
        $approvedLosses = $statsQuery->where('status_kejadian', 'Diluluskan')->count();
        $totalLossValue = $statsQuery->sum('nilai_kehilangan');

        return view('admin.loss-writeoffs.index', compact(
            'lossWriteoffs',
            'totalLosses',
            'pendingLosses',
            'approvedLosses',
            'totalLossValue'
        ));
    }

    /**
     * Export loss/write-offs to Excel
     */
    public function export(Request $request)
    {
        $filename = 'loss_writeoffs_export_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\LossWriteoffExport($request), $filename);
    }

    public function create()
    {
        $this->authorize('create', LossWriteoff::class);

        $query = Asset::with('masjidSurau');

        // Filter assets by masjid/surau if user is not admin
        if (Auth::user()->role !== 'administrator') {
            $query->where('masjid_surau_id', Auth::user()->masjid_surau_id);
        }

        $assets = $query->get();

        return view('admin.loss-writeoffs.create', compact('assets'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', LossWriteoff::class);

        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'jenis_kejadian' => 'required|string',
            'sebab_kejadian' => 'required|string',
            'tarikh_laporan' => 'required|date',
            'nilai_kehilangan' => 'required|numeric|min:0',
            'laporan_polis' => 'nullable|string',
            'catatan' => 'nullable|string',
            'dokumen_kehilangan' => 'nullable|array',
            'dokumen_kehilangan.*' => 'file|mimes:pdf,jpg,jpeg,png|max:5120'
        ]);

        // Handle document uploads
        if ($request->hasFile('dokumen_kehilangan')) {
            $documents = [];
            foreach ($request->file('dokumen_kehilangan') as $document) {
                $path = $document->store('loss-writeoffs', 'public');
                $documents[] = $path;
            }
            $validated['dokumen_kehilangan'] = $documents;
        }

        $validated['user_id'] = Auth::id();
        $validated['status_kejadian'] = 'Dilaporkan';

        $lossWriteoff = LossWriteoff::create($validated);

        return redirect()->route('admin.loss-writeoffs.show', $lossWriteoff)
            ->with('success', 'Laporan kehilangan berjaya dihantar.');
    }

    public function show(LossWriteoff $lossWriteoff)
    {
        $this->authorize('view', $lossWriteoff);

        $lossWriteoff->load(['asset', 'asset.masjidSurau', 'user']);

        return view('admin.loss-writeoffs.show', compact('lossWriteoff'));
    }

    public function edit(LossWriteoff $lossWriteoff)
    {
        $this->authorize('update', $lossWriteoff);

        $query = Asset::with('masjidSurau');

        // Filter assets by masjid/surau if user is not admin
        if (Auth::user()->role !== 'administrator') {
            $query->where('masjid_surau_id', Auth::user()->masjid_surau_id);
        }

        $assets = $query->get();

        return view('admin.loss-writeoffs.edit', compact('lossWriteoff', 'assets'));
    }

    public function update(Request $request, LossWriteoff $lossWriteoff)
    {
        $this->authorize('update', $lossWriteoff);

        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'jenis_kejadian' => 'required|string',
            'sebab_kejadian' => 'required|string',
            'tarikh_laporan' => 'required|date',
            'nilai_kehilangan' => 'required|numeric|min:0',
            'laporan_polis' => 'nullable|string',
            'catatan' => 'nullable|string',
            'dokumen_kehilangan' => 'nullable|array',
            'dokumen_kehilangan.*' => 'file|mimes:pdf,jpg,jpeg,png|max:5120'
        ]);

        // Handle document uploads
        if ($request->hasFile('dokumen_kehilangan')) {
            $documents = $lossWriteoff->dokumen_kehilangan ?? [];
            foreach ($request->file('dokumen_kehilangan') as $document) {
                $path = $document->store('loss-writeoffs', 'public');
                $documents[] = $path;
            }
            $validated['dokumen_kehilangan'] = $documents;
        }

        $lossWriteoff->update($validated);

        return redirect()->route('admin.loss-writeoffs.show', $lossWriteoff)
            ->with('success', 'Laporan kehilangan berjaya dikemaskini.');
    }

    public function destroy(LossWriteoff $lossWriteoff)
    {
        $this->authorize('delete', $lossWriteoff);

        $lossWriteoff->delete();

        return redirect()->route('admin.loss-writeoffs.index')
            ->with('success', 'Rekod kehilangan berjaya dipadamkan.');
    }

    public function approve(LossWriteoff $lossWriteoff)
    {
        $this->authorize('approve', $lossWriteoff);

        $lossWriteoff->update([
            'status_kejadian' => 'Diluluskan',
            'tarikh_kelulusan_hapus_kira' => now(),
            'diluluskan_oleh' => Auth::id()
        ]);

        // Update asset status
        $lossWriteoff->asset->update([
            'status_aset' => Asset::STATUS_LOST
        ]);

        return redirect()->route('admin.loss-writeoffs.show', $lossWriteoff)
            ->with('success', 'Laporan kehilangan telah diluluskan dan status aset dikemaskini.');
    }

    public function reject(Request $request, LossWriteoff $lossWriteoff)
    {
        $this->authorize('reject', $lossWriteoff);

        $request->validate([
            'sebab_penolakan' => 'required|string'
        ]);

        $lossWriteoff->update([
            'status_kejadian' => 'Ditolak',
            'tarikh_kelulusan_hapus_kira' => now(),
            'diluluskan_oleh' => Auth::id(),
            'sebab_penolakan' => $request->sebab_penolakan
        ]);

        return redirect()->route('admin.loss-writeoffs.show', $lossWriteoff)
            ->with('success', 'Laporan kehilangan telah ditolak.');
    }

    public function showImport()
    {
        $this->authorize('create', LossWriteoff::class);
        $masjidSuraus = MasjidSurau::orderBy('nama')->get();
        return view('admin.loss-writeoffs.import', compact('masjidSuraus'));
    }

    public function downloadTemplate()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\LossWriteoffImportTemplateExport(), 'template_hapus_kira.xlsx');
    }

    public function previewImport(Request $request)
    {
        $this->authorize('create', LossWriteoff::class);
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,xlsx,xls'
        ]);

        $file = $request->file('csv_file');
        $sheets = \Maatwebsite\Excel\Facades\Excel::toArray(new \App\Imports\LossWriteoffImport, $file);
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
        $this->authorize('create', LossWriteoff::class);
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,xlsx,xls'
        ]);

        $file = $request->file('csv_file');
        $sheets = \Maatwebsite\Excel\Facades\Excel::toArray(new \App\Imports\LossWriteoffImport, $file);
        $rows = $sheets[0] ?? [];

        $result = $this->processImportRows($rows);

        if (count($result['errors']) > 0) {
            return back()->with('import_errors', collect($result['errors'])->pluck('errors')->flatten()->all());
        }

        foreach ($result['valid_rows'] as $row) {
            LossWriteoff::create($row['data']);
        }

        return redirect()->route('admin.loss-writeoffs.index')
            ->with('success', count($result['valid_rows']) . ' rekod kehilangan berjaya diimport.');
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
                    'kuantiti_kehilangan' => (int) ($row[1] ?? 1),
                    'tarikh_laporan' => $formatDate($row[2] ?? null, 'laporan'),
                    'tarikh_kehilangan' => $formatDate($row[3] ?? null, 'kehilangan'),
                    'jenis_kejadian' => strtolower($row[4] ?? 'hilang'),
                    'sebab_kejadian' => strtolower($row[5] ?? 'kecurian'),
                    'butiran_kejadian' => $row[6] ?? '-',
                    'pegawai_pelapor' => $row[7] ?? Auth::user()->name,
                    'status_kejadian' => 'Dilaporkan',
                ];

                if (empty($data['tarikh_laporan']))
                    $rowErrors[] = "Tarikh Laporan diperlukan.";

                // Validate Jenis
                $validTypes = ['hilang', 'hapus_kira'];
                if (!in_array($data['jenis_kejadian'], $validTypes)) {
                    $rowErrors[] = "Jenis Kejadian tidak sah. Pilih: " . implode(', ', $validTypes);
                }

                // Validate Sebab
                $validReasons = ['bencana_alam', 'kecurian', 'kecuaian', 'tidak_dapat_dikesan'];
                if (!in_array($data['sebab_kejadian'], $validReasons)) {
                    $rowErrors[] = "Sebab Kejadian tidak sah. Pilih: " . implode(', ', $validReasons);
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
                        'jenis' => $data['jenis_kejadian'],
                        'sebab' => $data['sebab_kejadian']
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
