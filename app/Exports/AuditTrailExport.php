<?php

namespace App\Exports;

use App\Models\AuditTrail;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AuditTrailExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = AuditTrail::with('user')->latest();

        // Apply same filters as index
        if ($this->request->filled('user_id')) {
            $query->where('user_id', $this->request->user_id);
        }

        if ($this->request->filled('action')) {
            $query->where('action', $this->request->action);
        }

        if ($this->request->filled('model_type')) {
            $query->where('model_type', $this->request->model_type);
        }

        if ($this->request->filled('status')) {
            $query->where('status', $this->request->status);
        }

        if ($this->request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $this->request->date_from);
        }

        if ($this->request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $this->request->date_to);
        }

        if ($this->request->filled('search')) {
            $search = $this->request->search;
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', '%' . $search . '%')
                    ->orWhere('user_name', 'like', '%' . $search . '%')
                    ->orWhere('user_email', 'like', '%' . $search . '%')
                    ->orWhere('model_name', 'like', '%' . $search . '%');
            });
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tarikh/Masa',
            'Pengguna',
            'Email',
            'Peranan',
            'Tindakan',
            'Model',
            'Nama Model',
            'IP Address',
            'Pelayar',
            'Platform',
            'Status',
            'Penerangan',
            'URL'
        ];
    }

    public function map($trail): array
    {
        return [
            $trail->id,
            $trail->created_at->format('d/m/Y H:i:s'),
            $trail->user_name ?? 'Sistem',
            $trail->user_email ?? '-',
            $trail->user_role ?? '-',
            $trail->formatted_action,
            class_basename($trail->model_type ?? ''),
            $trail->model_name ?? '-',
            $trail->ip_address ?? '-',
            $trail->browser,
            $trail->platform,
            ucfirst($trail->status),
            $trail->description ?? '-',
            $trail->url ?? '-'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:N1')->getFont()->setBold(true);
        $sheet->getStyle('A1:N1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('E2EFDA');
    }
}
