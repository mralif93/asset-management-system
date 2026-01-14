<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ImmovableAssetTemplateSheet implements FromCollection, WithTitle, WithHeadings, WithStyles
{
    public function collection()
    {
        return collect([
            [
                '1', // Masjid ID
                'Contoh: Tanah Wakaf Masjid', // Nama
                'Tanah', // Jenis
                'Jalan Masjid, 53100 KL', // Alamat
                'H.S.(D) 12345', // Hakmilik
                'Lot 123', // Lot
                '1000.50', // Luas
                date('Y-m-d'), // Tarikh
                'Wakaf', // Sumber
                '0.00', // Kos
                'Baik', // Keadaan
                'Tanah wakaf dari Tuan Haji Ali', // Catatan
            ]
        ]);
    }

    public function headings(): array
    {
        return [
            'Masjid/Surau ID',
            'Nama Aset',
            'Jenis Aset (Tanah/Bangunan/Tanah dan Bangunan)',
            'Alamat',
            'No. Hakmilik',
            'No. Lot',
            'Luas Tanah/Bangunan (m²)',
            'Tarikh Perolehan (YYYY-MM-DD)',
            'Sumber Perolehan',
            'Kos Perolehan (RM)',
            'Keadaan Semasa',
            'Catatan'
        ];
    }

    public function title(): string
    {
        return 'Template';
    }

    public function styles(Worksheet $sheet)
    {
        // Style the header
        $sheet->getStyle('A1:L1')->getFont()->setBold(true);
        $sheet->getStyle('A1:L1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('E2EFDA');

        // Auto size columns
        foreach (range('A', 'L') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }
}
