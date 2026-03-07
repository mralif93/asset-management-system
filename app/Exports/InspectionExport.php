<?php

namespace App\Exports;

use App\Models\Inspection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InspectionExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = Inspection::with(['asset', 'asset.masjidSurau']);

        if ($this->request->filled('search')) {
            $search = $this->request->search;
            $query->whereHas('asset', function ($q) use ($search) {
                $q->where('nama_aset', 'like', "%{$search}%")
                    ->orWhere('no_siri_pendaftaran', 'like', "%{$search}%");
            });
        }

        $kondisi = $this->request->input('kondisi', $this->request->input('kondisi_aset', $this->request->input('status')));
        if (!empty($kondisi)) {
            $query->where('kondisi_aset', $kondisi);
        }

        if ($this->request->filled('tarikh')) {
            $query->whereDate('tarikh_pemeriksaan', $this->request->tarikh);
        } else {
            if ($this->request->filled('tarikh_dari')) {
                $query->whereDate('tarikh_pemeriksaan', '>=', $this->request->tarikh_dari);
            }
            if ($this->request->filled('tarikh_hingga')) {
                $query->whereDate('tarikh_pemeriksaan', '<=', $this->request->tarikh_hingga);
            }
        }

        return $query->latest();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Aset',
            'No. Siri Pendaftaran',
            'Lokasi Aset',
            'Tarikh Pemeriksaan',
            'Kondisi Aset',
            'Pegawai Pemeriksa',
            'Jawatan',
            'Lokasi Semasa Pemeriksaan',
            'Cadangan Tindakan',
            'Catatan',
            'Pemeriksaan Seterusnya'
        ];
    }

    public function map($inspection): array
    {
        return [
            $inspection->id,
            $inspection->asset->nama_aset ?? '-',
            $inspection->asset->no_siri_pendaftaran ?? '-',
            $inspection->asset->lokasi_penempatan ?? '-',
            $inspection->tarikh_pemeriksaan ? $inspection->tarikh_pemeriksaan->format('d/m/Y') : '-',
            ucfirst(str_replace('_', ' ', $inspection->kondisi_aset)),
            $inspection->pegawai_pemeriksa,
            $inspection->jawatan_pemeriksa,
            $inspection->lokasi_semasa_pemeriksaan,
            $inspection->cadangan_tindakan,
            $inspection->catatan_pemeriksa,
            $inspection->tarikh_pemeriksaan_akan_datang ? $inspection->tarikh_pemeriksaan_akan_datang->format('d/m/Y') : '-'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:L1')->getFont()->setBold(true);
        $sheet->getStyle('A1:L1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('E2EFDA');
    }
}
