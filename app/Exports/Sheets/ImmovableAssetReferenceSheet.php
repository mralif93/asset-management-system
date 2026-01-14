<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\MasjidSurau;
use App\Helpers\SystemData;

class ImmovableAssetReferenceSheet implements FromCollection, WithTitle, WithHeadings
{
    public function collection()
    {
        $data = [];

        // 1. Masjid/Surau List
        $masjids = MasjidSurau::select('id', 'nama')->get();
        // 2. Asset Types
        $types = ['Tanah', 'Bangunan', 'Tanah dan Bangunan'];
        // 3. Acquisition Sources
        $sources = SystemData::getAcquisitionSources();
        // 4. Physical Conditions
        $conditions = SystemData::getPhysicalConditions();

        // Calculate max rows needed
        $maxRows = max($masjids->count(), count($types), count($sources), count($conditions));

        for ($i = 0; $i < $maxRows; $i++) {
            $data[] = [
                $masjids[$i]->id ?? '',
                $masjids[$i]->nama ?? '',
                $types[$i] ?? '',
                $sources[$i] ?? '',
                $conditions[$i] ?? '',
            ];
        }

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'Masjid ID',
            'Nama Masjid',
            'Jenis Aset',
            'Sumber Perolehan',
            'Keadaan Semasa',
        ];
    }

    public function title(): string
    {
        return 'Rujukan';
    }
}
