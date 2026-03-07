<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DisposalTemplateSheet implements WithHeadings, WithTitle, WithStyles
{
    public function headings(): array
    {
        return [
            'No. Siri Pendaftaran Aset',
            'Kuantiti',
            'Tarikh Permohonan (DD/MM/YYYY)',
            'Justifikasi Pelupusan',
            'Kaedah Pelupusan Dicadang',
            'Pegawai Pemohon',
            'Catatan'
        ];
    }

    public function title(): string
    {
        return 'Template Pelupusan';
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
