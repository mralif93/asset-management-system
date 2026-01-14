<?php

namespace App\Exports;

use App\Models\Asset;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AssetExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = Asset::with('masjidSurau');

        // Apply same filters as index
        if ($this->request->filled('masjid_surau_id')) {
            $query->where('masjid_surau_id', $this->request->masjid_surau_id);
        }

        if ($this->request->filled('jenis_aset')) {
            $query->where('jenis_aset', $this->request->jenis_aset);
        }

        if ($this->request->filled('category')) {
            $query->where('category', $this->request->category);
        }

        if ($this->request->filled('search')) {
            $search = $this->request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_aset', 'like', '%' . $search . '%')
                    ->orWhere('no_siri_pendaftaran', 'like', '%' . $search . '%')
                    ->orWhere('jenis_aset', 'like', '%' . $search . '%');
            });
        }

        return $query->latest();
    }

    public function headings(): array
    {
        return [
            'Masjid/Surau ID',
            'Nama Aset',
            'Jenis Aset',
            'Kategori Aset (asset/non-asset)',
            'Tarikh Perolehan (DD/MM/YYYY)',
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
            'Tarikh Pemeriksaan Terakhir (DD/MM/YYYY)',
            'Tarikh Penyelenggaraan Akan Datang (DD/MM/YYYY)',
            'No. Resit',
            'Tarikh Resit (DD/MM/YYYY)',
            'Pembekal',
            'Jenama',
            'No. Pesanan Kerajaan',
            'No. Rujukan Kontrak',
            'Tempoh Jaminan',
            'Tarikh Tamat Jaminan (DD/MM/YYYY)',
            'Catatan',
            'Catatan Jaminan'
        ];
    }

    public function map($asset): array
    {
        return [
            $asset->masjid_surau_id,
            $asset->nama_aset,
            $asset->jenis_aset,
            $asset->category,
            $asset->tarikh_perolehan ? $asset->tarikh_perolehan->format('d/m/Y') : '',
            $asset->kaedah_perolehan, // Assuming correct field name
            number_format($asset->harga_perolehan ?? 0, 2),
            number_format($asset->discount ?? 0, 2),
            $asset->useful_life ?? '',
            number_format($asset->annual_depreciation ?? 0, 2),
            $asset->lokasi_penempatan,
            $asset->pegawai_bertanggungjawab,
            $asset->jawatan_pegawai,
            $asset->status_aset,
            $asset->keadaan_fizikal,
            $asset->status_jaminan,
            $asset->tarikh_pemeriksaan_terakhir ? $asset->tarikh_pemeriksaan_terakhir->format('d/m/Y') : '',
            $asset->tarikh_penyelenggaraan_seterusnya ? $asset->tarikh_penyelenggaraan_seterusnya->format('d/m/Y') : '',
            $asset->no_resit ?? '',
            $asset->tarikh_resit ? $asset->tarikh_resit->format('d/m/Y') : '',
            $asset->pembekal ?? '',
            $asset->jenama ?? '',
            $asset->no_pesanan_kerajaan ?? '',
            $asset->no_rujukan_kontrak ?? '',
            $asset->tempoh_jaminan ?? '',
            $asset->tarikh_tamat_jaminan ? $asset->tarikh_tamat_jaminan->format('d/m/Y') : '',
            $asset->catatan,
            $asset->catatan_jaminan ?? ''
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:AB1')->getFont()->setBold(true);
        $sheet->getStyle('A1:AB1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('E2EFDA');
    }
}
