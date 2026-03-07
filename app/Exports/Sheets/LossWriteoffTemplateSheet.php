<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LossWriteoffTemplateSheet implements WithHeadings, WithTitle, WithStyles
{
    public function headings(): array
    {
        return [
            'No. Siri Pendaftaran Aset',
            'Kuantiti Kehilangan',
            'Tarikh Laporan (DD/MM/YYYY)',
            'Tarikh Kehilangan (DD/MM/YYYY)',
            'Jenis Kejadian',
            'Sebab Kejadian',
            'Butiran Kejadian',
            'Pegawai Pelapor'
        ];
    }

    public function title(): string
    {
        return 'Template Hapus Kira';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '10B981']
                ],
            ],
        ];
    }
}
