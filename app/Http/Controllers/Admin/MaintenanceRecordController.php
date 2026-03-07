<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceRecord;
use App\Models\Asset;
use App\Models\MasjidSurau;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class MaintenanceRecordController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $this->authorize('viewAny', MaintenanceRecord::class);

        $query = MaintenanceRecord::with(['asset', 'asset.masjidSurau']);

        // Search by asset name or registration number
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('asset', function ($q) use ($search) {
                $q->where('nama_aset', 'like', "%{$search}%")
                    ->orWhere('no_siri_pendaftaran', 'like', "%{$search}%");
            });
        }

        // Filter by masjid/surau
        if ($request->filled('masjid_surau_id')) {
            $query->whereHas('asset', function ($q) use ($request) {
                $q->where('masjid_surau_id', $request->masjid_surau_id);
            });
        }

        // Filter by maintenance type
        if ($request->filled('jenis_penyelenggaraan')) {
            $query->where('jenis_penyelenggaraan', $request->jenis_penyelenggaraan);
        }

        // Filter by maintenance status
        if ($request->filled('status_penyelenggaraan')) {
            $query->where('status_penyelenggaraan', $request->status_penyelenggaraan);
        }

        // Filter by date range
        if ($request->filled('tarikh_dari')) {
            $query->whereDate('tarikh_penyelenggaraan', '>=', $request->tarikh_dari);
        }
        if ($request->filled('tarikh_hingga')) {
            $query->whereDate('tarikh_penyelenggaraan', '<=', $request->tarikh_hingga);
        }

        // Filter by cost range
        if ($request->filled('kos_min')) {
            $query->where('kos_penyelenggaraan', '>=', $request->kos_min);
        }
        if ($request->filled('kos_max')) {
            $query->where('kos_penyelenggaraan', '<=', $request->kos_max);
        }

        $maintenanceRecords = $query->latest()->paginate(15);

        $masjidSuraus = MasjidSurau::orderBy('nama')->get();
        $jenisPenyelenggaraan = ['Pencegahan', 'Betulan', 'Pembaikan', 'Tukar Ganti', 'Pemeriksaan'];
        $statusPenyelenggaraan = ['Selesai', 'Dalam Proses', 'Dijadualkan', 'Dibatalkan'];

        return view('admin.maintenance-records.index', compact(
            'maintenanceRecords',
            'masjidSuraus',
            'jenisPenyelenggaraan',
            'statusPenyelenggaraan'
        ));
    }

    /**
     * Export maintenance records to Excel
     */
    public function export(Request $request)
    {
        $filename = 'maintenance_records_export_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\MaintenanceRecordExport($request), $filename);
    }

    public function create()
    {
        $this->authorize('create', MaintenanceRecord::class);

        $assets = Asset::with('masjidSurau')->get();

        return view('admin.maintenance-records.create', compact('assets'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', MaintenanceRecord::class);

        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'jenis_penyelenggaraan' => 'required|string',
            'tarikh_penyelenggaraan' => 'required|date',
            'kos_penyelenggaraan' => 'required|numeric|min:0',
            'penyedia_perkhidmatan' => 'required|string|max:255',
            'catatan_penyelenggaraan' => 'nullable|string',
            'tarikh_penyelenggaraan_akan_datang' => 'nullable|date|after:tarikh_penyelenggaraan',
            'gambar_penyelenggaraan' => 'nullable|array',
            'gambar_penyelenggaraan.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'butiran_kerja' => 'required|string',
            'pegawai_bertanggungjawab' => 'required|string',
            'status_penyelenggaraan' => 'required|string',
        ]);

        // Handle image uploads
        if ($request->hasFile('gambar_penyelenggaraan')) {
            $images = [];
            foreach ($request->file('gambar_penyelenggaraan') as $image) {
                $path = $image->store('maintenance', 'public');
                $images[] = $path;
            }
            $validated['gambar_penyelenggaraan'] = $images;
        }

        $validated['user_id'] = Auth::id();

        // Map catatan_penyelenggaraan to catatan
        if (array_key_exists('catatan_penyelenggaraan', $validated)) {
            $validated['catatan'] = $validated['catatan_penyelenggaraan'];
            unset($validated['catatan_penyelenggaraan']);
        }

        $maintenanceRecord = MaintenanceRecord::create($validated);

        return redirect()->route('admin.maintenance-records.show', $maintenanceRecord)
            ->with('success', 'Rekod penyelenggaraan berjaya disimpan.');
    }

    public function show(MaintenanceRecord $maintenanceRecord)
    {
        $this->authorize('view', $maintenanceRecord);

        $maintenanceRecord->load(['asset', 'asset.masjidSurau', 'user']);

        return view('admin.maintenance-records.show', compact('maintenanceRecord'));
    }

    public function edit(MaintenanceRecord $maintenanceRecord)
    {
        $this->authorize('update', $maintenanceRecord);

        $assets = Asset::with('masjidSurau')->get();

        return view('admin.maintenance-records.edit', compact('maintenanceRecord', 'assets'));
    }

    public function update(Request $request, MaintenanceRecord $maintenanceRecord)
    {
        $this->authorize('update', $maintenanceRecord);

        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'jenis_penyelenggaraan' => 'required|string',
            'tarikh_penyelenggaraan' => 'required|date',
            'kos_penyelenggaraan' => 'required|numeric|min:0',
            'penyedia_perkhidmatan' => 'required|string|max:255',
            'catatan_penyelenggaraan' => 'nullable|string',
            'tarikh_penyelenggaraan_akan_datang' => 'nullable|date|after:tarikh_penyelenggaraan',
            'gambar_penyelenggaraan' => 'nullable|array',
            'gambar_penyelenggaraan.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'status_penyelenggaraan' => 'required|string'
        ]);

        // Handle image uploads
        if ($request->hasFile('gambar_penyelenggaraan')) {
            $images = $maintenanceRecord->gambar_penyelenggaraan ?? [];
            foreach ($request->file('gambar_penyelenggaraan') as $image) {
                $path = $image->store('maintenance', 'public');
                $images[] = $path;
            }
            $validated['gambar_penyelenggaraan'] = $images;
        }

        // Map catatan_penyelenggaraan to catatan
        if (array_key_exists('catatan_penyelenggaraan', $validated)) {
            $validated['catatan'] = $validated['catatan_penyelenggaraan'];
            unset($validated['catatan_penyelenggaraan']);
        }

        $maintenanceRecord->update($validated);

        return redirect()->route('admin.maintenance-records.show', $maintenanceRecord)
            ->with('success', 'Rekod penyelenggaraan berjaya dikemaskini.');
    }

    public function destroy(MaintenanceRecord $maintenanceRecord)
    {
        $this->authorize('delete', $maintenanceRecord);

        $maintenanceRecord->delete();

        return redirect()->route('admin.maintenance-records.index')
            ->with('success', 'Rekod penyelenggaraan berjaya dipadamkan.');
    }

    /**
     * Display a listing of trashed maintenance records.
     */
    public function trashed()
    {
        $this->authorize('viewAny', MaintenanceRecord::class);

        $trashedRecords = MaintenanceRecord::onlyTrashed()
            ->with(['asset', 'asset.masjidSurau'])
            ->latest()
            ->paginate(15);

        return view('admin.maintenance-records.trashed', compact('trashedRecords'));
    }

    public function showImport()
    {
        $this->authorize('create', MaintenanceRecord::class);
        $masjidSuraus = MasjidSurau::orderBy('nama')->get();
        return view('admin.maintenance-records.import', compact('masjidSuraus'));
    }

    public function downloadTemplate()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\MaintenanceImportTemplateExport(), 'template_penyelenggaraan.xlsx');
    }

    public function previewImport(Request $request)
    {
        $this->authorize('create', MaintenanceRecord::class);
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,xlsx,xls'
        ]);

        $file = $request->file('csv_file');
        $sheets = \Maatwebsite\Excel\Facades\Excel::toArray(new \App\Imports\MaintenanceImport, $file);
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
        $this->authorize('create', MaintenanceRecord::class);
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,xlsx,xls'
        ]);

        $file = $request->file('csv_file');
        $sheets = \Maatwebsite\Excel\Facades\Excel::toArray(new \App\Imports\MaintenanceImport, $file);
        $rows = $sheets[0] ?? [];

        $result = $this->processImportRows($rows);

        if (count($result['errors']) > 0) {
            return back()->with('import_errors', collect($result['errors'])->pluck('errors')->flatten()->all());
        }

        foreach ($result['valid_rows'] as $row) {
            MaintenanceRecord::create($row['data']);
        }

        return redirect()->route('admin.maintenance-records.index')
            ->with('success', count($result['valid_rows']) . ' rekod penyelenggaraan berjaya diimport.');
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
                    'tarikh_penyelenggaraan' => $formatDate($row[1] ?? null, 'penyelenggaraan'),
                    'jenis_penyelenggaraan' => $row[2] ?? 'Pencegahan',
                    'butiran_kerja' => $row[3] ?? null,
                    'penyedia_perkhidmatan' => $row[4] ?? null,
                    'kos_penyelenggaraan' => (float) str_replace(',', '', (string) ($row[5] ?? 0)),
                    'status_penyelenggaraan' => $row[6] ?? 'Selesai',
                    'pegawai_bertanggungjawab' => $row[7] ?? null,
                    'catatan' => $row[8] ?? '-',
                ];

                if (empty($data['tarikh_penyelenggaraan']))
                    $rowErrors[] = "Tarikh Penyelenggaraan diperlukan.";
                if (empty($data['butiran_kerja']))
                    $rowErrors[] = "Butiran Kerja diperlukan.";
                if (empty($data['penyedia_perkhidmatan']))
                    $rowErrors[] = "Penyedia Perkhidmatan diperlukan.";

                // Validate Type
                $validTypes = ['Pencegahan', 'Pembaikan', 'Kalibrasi', 'Pembersihan'];
                if (!in_array($data['jenis_penyelenggaraan'], $validTypes)) {
                    $rowErrors[] = "Jenis Penyelenggaraan tidak sah. Pilih: " . implode(', ', $validTypes);
                }

                // Validate Status
                $validStatuses = ['Selesai', 'Dalam Proses', 'Belum Selesai'];
                if (!in_array($data['status_penyelenggaraan'], $validStatuses)) {
                    $rowErrors[] = "Status tidak sah. Pilih: " . implode(', ', $validStatuses);
                }

                $processedRow = [
                    'row' => $rowNumber,
                    'data' => $data,
                    'valid' => empty($rowErrors),
                    'errors' => array_map(fn($e) => "Baris $rowNumber: $e", $rowErrors),
                    'display_data' => [
                        'no_siri' => $noSiri ?? '-',
                        'nama_aset' => $asset ? $asset->nama_aset : '-',
                        'tarikh' => $row[1] ?? '-',
                        'jenis' => $data['jenis_penyelenggaraan']
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
