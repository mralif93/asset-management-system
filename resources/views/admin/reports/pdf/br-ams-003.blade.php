<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>BR-AMS 003 - Senarai Aset Alih</title>
    <style>
        @page {
            margin: 0;
            size: A4 portrait;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
            color: #1f2937;
            line-height: 1.3;
            padding: 15mm;
        }

        .header {
            background: #059669;
            color: white;
            padding: 12px 15px;
            margin-bottom: 10px;
            page-break-after: avoid;
        }

        h1 {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 4px;
            text-align: center;
        }

        .subtitle {
            font-size: 9px;
            text-align: center;
            font-weight: normal;
        }

        .info-badges {
            text-align: center;
            margin-top: 6px;
            font-size: 7px;
        }

        .badge {
            display: inline-block;
            margin: 0 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
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
            padding: 8px 5px;
            font-size: 8px;
            text-transform: uppercase;
            letter-spacing: 0.2px;
            border: 1px solid #059669;
            line-height: 1.2;
        }

        tbody {
            display: table-row-group;
        }

        tbody tr {
            page-break-inside: avoid;
            border-bottom: 1px solid #e5e7eb;
        }

        td {
            padding: 8px 5px;
            border: 1px solid #e5e7eb;
            vertical-align: top;
        }

        .text-center {
            text-align: center;
        }

        .font-medium {
            font-weight: 600;
            color: #111827;
        }

        .text-sm {
            font-size: 8px;
            color: #6b7280;
            margin-top: 2px;
        }

        .quantity-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 8px;
            font-size: 7px;
            background: #d1fae5;
            color: #065f46;
            font-weight: 500;
        }

        .note-section {
            margin-top: 10px;
            padding: 8px 10px;
            background: #eff6ff;
            border-left: 2px solid #3b82f6;
            page-break-inside: avoid;
        }

        .note-section p {
            font-size: 7px;
            color: #1e40af;
            line-height: 1.4;
        }

        .footer {
            margin-top: 10px;
            padding-top: 6px;
            border-top: 1px solid #e5e7eb;
            font-size: 6px;
            color: #6b7280;
            text-align: center;
            page-break-inside: avoid;
        }

        .empty-state {
            padding: 30px;
            text-align: center;
            color: #9ca3af;
        }
    </style>
</head>

<body>
    <!-- Header Section -->
    <div class="header">
        <h1>BR-AMS 003 - SENARAI ASET ALIH DI LOKASI</h1>
        <div class="subtitle">Garis Panduan Pengurusan Kewangan, Perolehan Dan Aset Masjid Dan Surau Negeri Selangor
        </div>
        <div class="info-badges">
            <div class="badge">📋 Laporan Rasmi</div>
            <div class="badge">🛡️ Negeri Selangor</div>
        </div>
    </div>

    <!-- Main Table -->
    <table>
        <thead>
            <tr>
                <th style="width: 10%;">BIL</th>
                <th style="width: 25%;">NOMBOR SIRI<br>PENDAFTARAN</th>
                <th style="width: 50%;">KETERANGAN ASET</th>
                <th style="width: 15%;">KUANTITI</th>
            </tr>
        </thead>
        <tbody>
            @forelse($assets as $index => $asset)
                <tr>
                    <td class="text-center font-medium">{{ $index + 1 }}</td>
                    <td class="text-center font-medium">{{ $asset->no_siri_pendaftaran ?? 'N/A' }}</td>
                    <td>
                        <div class="font-medium">{{ $asset->nama_aset }}</div>
                        <div class="text-sm">{{ $asset->jenis_aset }}</div>
                        @if($asset->masjidSurau)
                            <div class="text-sm">{{ $asset->masjidSurau->nama }}</div>
                        @endif
                    </td>
                    <td class="text-center">
                        <span class="quantity-badge">{{ $asset->kuantiti ?? 1 }}</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="empty-state">
                        <div style="font-size: 14px; margin-bottom: 5px;">📦</div>
                        <div style="font-size: 11px; font-weight: 600;">Tiada aset ditemui</div>
                        <div style="font-size: 9px;">Tiada aset yang memenuhi kriteria carian</div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Note Section -->
    <div class="note-section">
        <p><strong>ℹ️ NOTA:</strong> Laporan ini melaporkan senarai aset alih yang ditempatkan di lokasi tertentu.</p>
    </div>

    <!-- Footer -->
    <div class="footer">
        Dijana pada: {{ now()->format('d/m/Y H:i:s') }} | Sistem Pengurusan Aset Masjid & Surau
    </div>
</body>

</html>