<?php

namespace App\Exports;

use App\Models\LossWriteoff;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LossWriteoffExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = LossWriteoff::with(['asset', 'asset.masjidSurau']);

        if ($this->request->filled('search')) {
            $search = $this->request->search;
            $query->whereHas('asset', function ($q) use ($search) {
                $q->where('nama_aset', 'like', "%{$search}%")
                    ->orWhere('no_siri_pendaftaran', 'like', "%{$search}%");
            });
        }

        if ($this->request->filled('status')) {
            $query->where('status_kejadian', $this->request->status);
        }

        if ($this->request->filled('type')) {
            $query->where('jenis_kejadian', $this->request->type);
        }

        return $query->latest();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Aset',
            'No. Siri Pendaftaran',
            'Kuantiti Kehilangan',
            'Tarikh Laporan',
            'Jenis Kejadian',
            'Sebab Kejadian',
            'Status',
            'Pegawai Pelapor',
            'Tarikh Kelulusan',
            'Catatan'
        ];
    }

    public function map($loss): array
    {
        return [
            $loss->id,
            $loss->asset->nama_aset ?? '-',
            $loss->asset->no_siri_pendaftaran ?? '-',
            $loss->kuantiti_kehilangan,
            $loss->tarikh_laporan ? $loss->tarikh_laporan->format('d/m/Y') : '-',
            ucfirst(str_replace('_', ' ', $loss->jenis_kejadian)),
            ucfirst(str_replace('_', ' ', $loss->sebab_kejadian)),
            ucfirst(str_replace('_', ' ', $loss->status_kejadian)),
            $loss->pegawai_pelapor,
            $loss->tarikh_kelulusan_hapus_kira ? $loss->tarikh_kelulusan_hapus_kira->format('d/m/Y') : '-',
            $loss->catatan
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:K1')->getFont()->setBold(true);
        $sheet->getStyle('A1:K1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('E2EFDA');
    }
}
