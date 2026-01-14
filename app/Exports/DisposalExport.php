<?php

namespace App\Exports;

use App\Models\Disposal;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DisposalExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = Disposal::with(['asset', 'asset.masjidSurau']);

        if ($this->request->filled('search')) {
            $search = $this->request->search;
            $query->whereHas('asset', function ($q) use ($search) {
                $q->where('nama_aset', 'like', "%{$search}%")
                    ->orWhere('no_siri_pendaftaran', 'like', "%{$search}%");
            });
        }

        if ($this->request->filled('status')) {
            $query->where('status_pelupusan', $this->request->status);
        }

        if ($this->request->filled('method')) {
            $query->where('kaedah_pelupusan_dicadang', $this->request->method);
        }

        return $query->latest();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Aset',
            'No. Siri Pendaftaran',
            'Kuantiti',
            'Tarikh Permohonan',
            'Justifikasi',
            'Kaedah Dicadang',
            'Status',
            'Pegawai Pemohon',
            'Tarikh Kelulusan',
            'No. Mesyuarat',
            'Catatan'
        ];
    }

    public function map($disposal): array
    {
        return [
            $disposal->id,
            $disposal->asset->nama_aset ?? '-',
            $disposal->asset->no_siri_pendaftaran ?? '-',
            $disposal->kuantiti,
            $disposal->tarikh_permohonan ? $disposal->tarikh_permohonan->format('d/m/Y') : '-',
            ucfirst(str_replace('_', ' ', $disposal->justifikasi_pelupusan)),
            ucfirst(str_replace('_', ' ', $disposal->kaedah_pelupusan_dicadang)),
            ucfirst(str_replace('_', ' ', $disposal->status_pelupusan)),
            $disposal->pegawai_pemohon,
            $disposal->tarikh_kelulusan_pelupusan ? $disposal->tarikh_kelulusan_pelupusan->format('d/m/Y') : '-',
            $disposal->nombor_mesyuarat_jawatankuasa ?? '-',
            $disposal->catatan
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:L1')->getFont()->setBold(true);
        $sheet->getStyle('A1:L1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('E2EFDA');
    }
}
