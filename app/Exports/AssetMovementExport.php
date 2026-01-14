<?php

namespace App\Exports;

use App\Models\AssetMovement;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AssetMovementExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = AssetMovement::with([
            'asset',
            'asset.masjidSurau',
            'masjidSurauAsal',
            'masjidSurauDestinasi',
            'approvedByAsal',
            'approvedByDestinasi'
        ]);

        // Apply filters
        if ($this->request->filled('search')) {
            $search = $this->request->search;
            $query->whereHas('asset', function ($q) use ($search) {
                $q->where('nama_aset', 'like', "%{$search}%")
                    ->orWhere('no_siri_pendaftaran', 'like', "%{$search}%");
            });
        }

        if ($this->request->filled('status')) {
            $query->where('status_pergerakan', $this->request->status);
        }

        if ($this->request->filled('jenis_pergerakan')) {
            $query->where('jenis_pergerakan', $this->request->jenis_pergerakan);
        }

        if ($this->request->filled('masjid_surau_asal_id')) {
            $query->where('masjid_surau_asal_id', $this->request->masjid_surau_asal_id);
        }

        if ($this->request->filled('masjid_surau_destinasi_id')) {
            $query->where('masjid_surau_destinasi_id', $this->request->masjid_surau_destinasi_id);
        }

        return $query->latest();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Aset',
            'No. Siri Pendaftaran',
            'Jenis Pergerakan',
            'Status',
            'Kuantiti',
            'Lokasi Asal',
            'Lokasi Destinasi',
            'Tarikh Permohonan',
            'Tarikh Pergerakan',
            'Jangka Pulang',
            'Tarikh Pulang',
            'Tujuan',
            'Pegawai Bertanggungjawab/Peminjam',
            'Catatan'
        ];
    }

    public function map($movement): array
    {
        return [
            $movement->id,
            $movement->asset->nama_aset ?? '-',
            $movement->asset->no_siri_pendaftaran ?? '-',
            ucfirst($movement->jenis_pergerakan),
            ucfirst(str_replace('_', ' ', $movement->status_pergerakan)),
            $movement->kuantiti,
            $movement->masjidSurauAsal->nama ?? 'Lain-lain',
            $movement->masjidSurauDestinasi->nama ?? 'Lain-lain',
            $movement->tarikh_permohonan ? $movement->tarikh_permohonan->format('d/m/Y') : '-',
            $movement->tarikh_pergerakan ? $movement->tarikh_pergerakan->format('d/m/Y') : '-',
            $movement->tarikh_jangka_pulang ? $movement->tarikh_jangka_pulang->format('d/m/Y') : '-',
            $movement->tarikh_pulang_sebenar ? $movement->tarikh_pulang_sebenar->format('d/m/Y') : '-',
            $movement->tujuan_pergerakan,
            $movement->nama_peminjam_pegawai_bertanggungjawab,
            $movement->catatan
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:O1')->getFont()->setBold(true);
        $sheet->getStyle('A1:O1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('E2EFDA');
    }
}
