<?php

namespace App\Exports;

use App\Models\ImmovableAsset;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ImmovableAssetExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = ImmovableAsset::with('masjidSurau');

        if ($this->request->filled('search')) {
            $searchTerm = $this->request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama_aset', 'like', "%{$searchTerm}%")
                    ->orWhere('no_siri_pendaftaran', 'like', "%{$searchTerm}%")
                    ->orWhere('alamat', 'like', "%{$searchTerm}%")
                    ->orWhere('no_hakmilik', 'like', "%{$searchTerm}%")
                    ->orWhere('no_lot', 'like', "%{$searchTerm}%");
            });
        }

        if ($this->request->filled('jenis_aset')) {
            $query->where('jenis_aset', $this->request->jenis_aset);
        }

        if ($this->request->filled('keadaan_semasa')) {
            $query->where('keadaan_semasa', $this->request->keadaan_semasa);
        }

        return $query->latest();
    }

    public function headings(): array
    {
        return [
            'Masjid/Surau ID',
            'Nama Aset',
            'Jenis Aset',
            'Alamat',
            'No. Hakmilik',
            'No. Lot',
            'Luas Tanah/Bangunan (m²)',
            'Tarikh Perolehan',
            'Sumber Perolehan',
            'Kos Perolehan (RM)',
            'Keadaan Semasa',
            'Catatan'
        ];
    }

    public function map($asset): array
    {
        return [
            $asset->masjid_surau_id,
            $asset->nama_aset,
            $asset->jenis_aset,
            $asset->alamat ?? '',
            $asset->no_hakmilik ?? '',
            $asset->no_lot ?? '',
            number_format($asset->luas_tanah_bangunan ?? 0, 2),
            $asset->tarikh_perolehan ? $asset->tarikh_perolehan->format('d/m/Y') : '',
            $asset->sumber_perolehan ?? '',
            number_format($asset->kos_perolehan ?? 0, 2),
            $asset->keadaan_semasa ?? '',
            $asset->catatan ?? ''
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:L1')->getFont()->setBold(true);
        $sheet->getStyle('A1:L1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('E2EFDA');
    }
}
