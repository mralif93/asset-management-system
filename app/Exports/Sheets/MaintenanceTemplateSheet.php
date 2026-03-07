<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MaintenanceTemplateSheet implements WithHeadings, WithTitle, ShouldAutoSize, WithStyles
{
    public function headings(): array
    {
        return [
            'No. Siri Pendaftaran Aset',
            'Tarikh Penyelenggaraan (DD/MM/YYYY)',
            'Jenis Penyelenggaraan (Pencegahan/Pembaikan/Kalibrasi/Pembersihan)',
            'Butiran Kerja',
            'Penyedia Perkhidmatan',
            'Kos Penyelenggaraan (RM)',
            'Status (Selesai/Dalam Proses/Belum Selesai)',
            'Pegawai Bertanggungjawab',
            'Catatan'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:I1')->getFont()->setBold(true);
        $sheet->getStyle('A1:I1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('E2EFDA');
    }

    public function title(): string
    {
        return 'Muat Naik Data';
    }
}
