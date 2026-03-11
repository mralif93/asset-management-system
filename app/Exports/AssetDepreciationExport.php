<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AssetDepreciationExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithTitle
{
    protected $assets;

    public function __construct($assets)
    {
        $this->assets = $assets;
    }

    public function collection()
    {
        return $this->assets;
    }

    public function headings(): array
    {
        return [
            'No. Siri Pendaftaran',
            'Nama Aset',
            'Nilai Asal (RM)',
            'Susut Nilai Tahunan (RM)',
            'Umur (Tahun)',
            'Jumlah Susut Nilai (RM)',
            'Nilai Semasa (RM)',
        ];
    }

    public function map($asset): array
    {
        return [
            $asset->no_siri_pendaftaran,
            $asset->nama_aset,
            $asset->nilai_perolehan,
            $asset->annual_depreciation,
            $asset->years_elapsed,
            $asset->total_depreciation,
            $asset->current_value,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function title(): string
    {
        return 'Susut Nilai Aset';
    }
}
