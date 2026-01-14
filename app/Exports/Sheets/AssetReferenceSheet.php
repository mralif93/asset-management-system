<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Helpers\SystemData;
use App\Helpers\AssetRegistrationNumber;

class AssetReferenceSheet implements FromCollection, WithTitle, WithHeadings
{
    public function collection()
    {
        // Gather all reference data
        $assetTypes = array_keys(AssetRegistrationNumber::getAssetTypeAbbreviations());
        $locations = SystemData::getValidLocations();
        $conditions = SystemData::getPhysicalConditions();
        $statuses = [
            'Baru',
            'Sedang Digunakan',
            'Dalam Penyelenggaraan',
            'Rosak',
            'Lupus',
        ];
        $categories = ['asset', 'non-asset'];
        $acquisitionMethods = SystemData::getAcquisitionSources();
        $warrantyStatuses = ['Aktif', 'Tamat', 'Tiada Jaminan'];

        // Determine max rows needed
        $maxRows = max(
            count($assetTypes),
            count($locations),
            count($conditions),
            count($statuses),
            count($categories),
            count($acquisitionMethods),
            count($warrantyStatuses)
        );

        $data = [];

        for ($i = 0; $i < $maxRows; $i++) {
            $data[] = [
                $assetTypes[$i] ?? '',
                $categories[$i] ?? '',
                $locations[$i] ?? '',
                $conditions[$i] ?? '',
                $statuses[$i] ?? '',
                $acquisitionMethods[$i] ?? '',
                $warrantyStatuses[$i] ?? '',
            ];
        }

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'JENIS ASET SAH',
            'KATEGORI ASET SAH',
            'LOKASI PENEMPATAN SAH',
            'KEADAAN FIZIKAL SAH',
            'STATUS ASET SAH',
            'KAEDAH PEROLEHAN SAH',
            'STATUS JAMINAN SAH'
        ];
    }

    public function title(): string
    {
        return 'Rujukan (Copy-Paste)';
    }
}
