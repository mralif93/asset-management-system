<?php

namespace App\Exports;

use App\Models\MaintenanceRecord;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MaintenanceRecordExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = MaintenanceRecord::with(['asset', 'asset.masjidSurau']);

        if ($this->request->filled('search')) {
            $search = $this->request->search;
            $query->whereHas('asset', function ($q) use ($search) {
                $q->where('nama_aset', 'like', "%{$search}%")
                    ->orWhere('no_siri_pendaftaran', 'like', "%{$search}%");
            });
        }

        if ($this->request->filled('status')) {
            $query->where('status_penyelenggaraan', $this->request->status);
        }

        if ($this->request->filled('jenis')) {
            $query->where('jenis_penyelenggaraan', $this->request->jenis);
        }

        return $query->latest();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Aset',
            'No. Siri Pendaftaran',
            'Tarikh',
            'Jenis Penyelenggaraan',
            'Butiran Kerja',
            'Penyedia Perkhidmatan',
            'Kos (RM)',
            'Status',
            'Pegawai Bertanggungjawab',
            'Catatan'
        ];
    }

    public function map($record): array
    {
        return [
            $record->id,
            $record->asset->nama_aset ?? '-',
            $record->asset->no_siri_pendaftaran ?? '-',
            $record->tarikh_penyelenggaraan ? $record->tarikh_penyelenggaraan->format('d/m/Y') : '-',
            ucfirst(str_replace('_', ' ', $record->jenis_penyelenggaraan)),
            $record->butiran_kerja,
            $record->penyedia_perkhidmatan,
            number_format($record->kos_penyelenggaraan, 2),
            ucfirst(str_replace('_', ' ', $record->status_penyelenggaraan)),
            $record->pegawai_bertanggungjawab,
            $record->catatan
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:K1')->getFont()->setBold(true);
        $sheet->getStyle('A1:K1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('E2EFDA');
    }
}
