<?php

namespace App\Exports\Sheets;

use App\Models\Asset;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AssetListReferenceSheet implements FromCollection, WithTitle, WithHeadings, ShouldAutoSize
{
    public function collection()
    {
        return Asset::with('masjidSurau')
            ->get()
            ->map(function ($asset) {
                return [
                    'no_siri_pendaftaran' => $asset->no_siri_pendaftaran,
                    'nama_aset' => $asset->nama_aset,
                    'masjid_surau' => $asset->masjidSurau->nama ?? '-',
                    'lokasi' => $asset->lokasi_penempatan,
                    'kondisi' => $asset->keadaan_fizikal,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'No. Siri Pendaftaran',
            'Nama Aset',
            'Masjid/Surau',
            'Lokasi Penempatan',
            'Kondisi Fizikal Semasa'
        ];
    }

    public function title(): string
    {
        return 'Senarai Aset (Rujukan)';
    }
}
