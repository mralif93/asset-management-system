<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>BR-AMS 002 - Senarai Daftar Inventori</title>
    <style>
        @page {
            margin: 0;
            size: A4 landscape;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 8px;
            color: #1f2937;
            line-height: 1.3;
            padding: 10mm;
        }

        .header {
            background: #059669;
            color: white;
            padding: 10px 12px;
            margin-bottom: 8px;
            page-break-after: avoid;
        }

        h1 {
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 3px;
            text-align: center;
        }

        .subtitle {
            font-size: 8px;
            text-align: center;
            font-weight: normal;
        }

        .info-badges {
            text-align: center;
            margin-top: 5px;
            font-size: 6px;
        }

        .badge {
            display: inline-block;
            margin: 0 6px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 3px;
            background: white;
            page-break-inside: auto;
        }

        thead {
            display: table-header-group;
            background: #10b981;
        }

        thead tr {
            page-break-inside: avoid;
            page-break-after: avoid;
        }

        th {
            color: white;
            font-weight: 600;
            text-align: center;
            padding: 4px 3px;
            font-size: 6px;
            text-transform: uppercase;
            letter-spacing: 0.2px;
            border: 1px solid #059669;
            line-height: 1.1;
        }

        tbody {
            display: table-row-group;
        }

        tbody tr {
            page-break-inside: avoid;
            border-bottom: 1px solid #e5e7eb;
        }

        td {
            padding: 4px 3px;
            border: 1px solid #e5e7eb;
            vertical-align: top;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .font-medium {
            font-weight: 600;
            color: #111827;
        }

        .text-sm {
            font-size: 7px;
            color: #6b7280;
            margin-top: 1px;
        }

        .status-badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 8px;
            font-size: 6px;
            font-weight: 600;
            text-align: center;
            white-space: nowrap;
        }

        .status-active {
            background: #d1fae5;
            color: #065f46;
        }

        .status-disposed {
            background: #fee2e2;
            color: #991b1b;
        }

        .status-writeoff {
            background: #f3f4f6;
            color: #374151;
        }

        .method-badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 8px;
            font-size: 6px;
            background: #dbeafe;
            color: #1e40af;
            font-weight: 500;
            white-space: nowrap;
        }

        tfoot {
            display: table-footer-group;
            background: #f9fafb;
            border-top: 2px solid #059669;
            page-break-inside: avoid;
        }

        tfoot td {
            padding: 6px 4px;
            font-weight: bold;
            color: #111827;
            border: 1px solid #d1d5db;
        }

        .summary-row {
            background: #f3f4f6;
        }

        .grand-total-row {
            background: #e5e7eb;
        }

        .note-section {
            margin-top: 6px;
            padding: 5px 8px;
            background: #eff6ff;
            border-left: 2px solid #3b82f6;
            page-break-inside: avoid;
        }

        .note-section p {
            font-size: 6px;
            color: #1e40af;
            line-height: 1.3;
        }

        .footer {
            margin-top: 5px;
            padding-top: 4px;
            border-top: 1px solid #e5e7eb;
            font-size: 5px;
            color: #6b7280;
            text-align: center;
            page-break-inside: avoid;
        }

        .empty-state {
            padding: 20px;
            text-align: center;
            color: #9ca3af;
        }

        .amount {
            font-weight: 600;
            color: #059669;
        }
    </style>
</head>

<body>
    <!-- Header Section -->
    <div class="header">
        <h1>BR-AMS 002 - SENARAI DAFTAR INVENTORI</h1>
        <div class="subtitle">Garis Panduan Pengurusan Kewangan, Perolehan Dan Aset Masjid Dan Surau Negeri Selangor
        </div>
        <div class="info-badges">
            <div class="badge">📦 Laporan Rasmi</div>
            <div class="badge">🛡️ Negeri Selangor</div>
        </div>
    </div>

    <!-- Main Table -->
    <table>
        <thead>
            <tr>
                <th style="width: 4%;">BIL.</th>
                <th style="width: 12%;">NOMBOR SIRI<br>PENDAFTARAN</th>
                <th style="width: 18%;">KETERANGAN ASET</th>
                <th style="width: 11%;">CARA ASET<br>DIPEROLEHI</th>
                <th style="width: 9%;">TARIKH<br>PEMBELIAN</th>
                <th style="width: 11%;">HARGA<br>PEMBELIAN (RM)</th>
                <th style="width: 16%;">PENEMPATAN</th>
                <th style="width: 10%;">STATUS ASET</th>
                <th style="width: 9%;">JUMLAH<br>(RM)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($assets as $index => $asset)
                <tr>
                    <td class="text-center font-medium">{{ $index + 1 }}</td>
                    <td class="font-medium">{{ $asset->no_siri_pendaftaran ?? 'N/A' }}</td>
                    <td>
                        <div class="font-medium">{{ $asset->nama_aset }}</div>
                        <div class="text-sm">{{ $asset->jenis_aset }}</div>
                    </td>
                    <td class="text-center">
                        <span
                            class="method-badge">{{ ucfirst(str_replace('_', ' ', $asset->kaedah_perolehan ?? 'N/A')) }}</span>
                    </td>
                    <td class="text-center">
                        {{ $asset->tarikh_perolehan ? \Carbon\Carbon::parse($asset->tarikh_perolehan)->format('d/m/Y') : 'N/A' }}
                    </td>
                    <td class="text-right">{{ number_format($asset->nilai_perolehan, 2) }}</td>
                    <td>
                        <div class="font-medium">{{ $asset->lokasi_penempatan ?? 'N/A' }}</div>
                        @if($asset->masjidSurau)
                            <div class="text-sm">{{ $asset->masjidSurau->nama }}</div>
                        @endif
                    </td>
                    <td class="text-center">
                        @php
                            $statusClass = 'status-active';
                            $statusText = ucfirst(str_replace('_', ' ', $asset->status_aset));

                            if (stripos($asset->status_aset, 'dilupuskan') !== false || stripos($asset->status_aset, 'disposal') !== false) {
                                $statusClass = 'status-disposed';
                            } elseif (stripos($asset->status_aset, 'hapus') !== false || stripos($asset->status_aset, 'writeoff') !== false) {
                                $statusClass = 'status-writeoff';
                            }
                        @endphp
                        <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                    </td>
                    <td class="text-right font-medium amount">{{ number_format($asset->getCurrentValue(), 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="empty-state">
                        <div style="font-size: 12px; margin-bottom: 5px;">📦</div>
                        <div style="font-size: 10px; font-weight: 600;">Tiada inventori ditemui</div>
                        <div style="font-size: 8px;">Tiada inventori yang memenuhi kriteria carian</div>
                    </td>
                </tr>
            @endforelse
        </tbody>

        @if($assets->count() > 0)
            <tfoot>
                <tr class="grand-total-row">
                    <td colspan="8" class="text-right">JUMLAH KESELURUHAN (RM)*</td>
                    <td class="text-right amount">{{ number_format($totalValue, 2) }}</td>
                </tr>
            </tfoot>
        @endif
    </table>

    <!-- Note Section -->
    <div class="note-section">
        <p><strong>ℹ️ NOTA:</strong> Laporan ini melaporkan kedudukan keseluruhan inventori yang dimiliki oleh
            masjid/surau merangkumi penerimaan serta maklumat pelupusan dan hapus kira yang telah dikemaskini.</p>
    </div>

    <!-- Footer -->
    <div class="footer">
        Dijana pada: {{ now()->format('d/m/Y H:i:s') }} | Sistem Pengurusan Aset Masjid & Surau
    </div>
</body>

</html>