<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AssetTemplateSheet implements FromArray, WithTitle, WithHeadings, WithStyles, ShouldAutoSize
{
    public function array(): array
    {
        // Example Row
        return [
            [
                '1',
                'Contoh: Komputer Desktop',
                'Perabot', // Example
                'asset',
                date('Y-m-d'),
                'Pembelian',
                '2500.00',
                '0.00',
                '5',
                '500.00',
                'Bilik Setiausaha',
                'Ahmad bin Abdullah',
                'Setiausaha',
                'Sedang Digunakan',
                'Baik',
                'Aktif',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                'Contoh catatan',
                ''
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'Masjid/Surau ID',
            'Nama Aset',
            'Jenis Aset',
            'Kategori Aset (asset/non-asset)',
            'Tarikh Perolehan (YYYY-MM-DD)',
            'Kaedah Perolehan',
            'Nilai Perolehan (RM)',
            'Diskaun (RM)',
            'Umur Faedah (Tahun)',
            'Susut Nilai Tahunan (RM)',
            'Lokasi Penempatan',
            'Pegawai Bertanggungjawab',
            'Jawatan Pegawai',
            'Status Aset',
            'Keadaan Fizikal',
            'Status Jaminan',
            'Tarikh Pemeriksaan Terakhir (YYYY-MM-DD)',
            'Tarikh Penyelenggaraan Akan Datang (YYYY-MM-DD)',
            'No. Resit',
            'Tarikh Resit (YYYY-MM-DD)',
            'Pembekal',
            'Jenama',
            'No. Pesanan Kerajaan',
            'No. Rujukan Kontrak',
            'Tempoh Jaminan',
            'Tarikh Tamat Jaminan (YYYY-MM-DD)',
            'Catatan',
            'Catatan Jaminan'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '059669']]],
        ];
    }

    public function title(): string
    {
        return 'Template Import';
    }
}
