<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InspectionTemplateSheet implements WithHeadings, WithTitle, ShouldAutoSize, WithStyles
{
    public function headings(): array
    {
        return [
            'No. Siri Pendaftaran Aset',
            'Tarikh Pemeriksaan (DD/MM/YYYY)',
            'Kondisi Aset (Baik/Sederhana/Rosak/Sedang Digunakan/Tidak Digunakan)',
            'Pegawai Pemeriksa',
            'Jawatan Pemeriksa',
            'Catatan Pemeriksa',
            'Cadangan Tindakan (Tiada Tindakan/Penyelenggaraan/Pelupusan/Hapus Kira)',
            'Tarikh Pemeriksaan Akan Datang (DD/MM/YYYY)'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:H1')->getFont()->setBold(true);
        $sheet->getStyle('A1:H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('E2EFDA');
    }

    public function title(): string
    {
        return 'Muat Naik Data';
    }
}
