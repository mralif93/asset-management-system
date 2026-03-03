<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>BR-AMS 010 - Laporan Tahunan Pengurusan Aset Alih</title>
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
        }

        thead {
            background: #10b981;
        }

        th {
            color: white;
            padding: 4px 3px;
            font-size: 6px;
            text-transform: uppercase;
            border: 1px solid #059669;
        }

        td {
            padding: 4px 3px;
            border: 1px solid #e5e7eb;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .font-medium {
            font-weight: 600;
        }

        .text-sm {
            font-size: 7px;
            color: #6b7280;
        }

        .note-section {
            margin-top: 6px;
            padding: 5px 8px;
            background: #eff6ff;
            border-left: 2px solid #3b82f6;
        }

        .note-section p {
            font-size: 6px;
            color: #1e40af;
        }

        .footer {
            margin-top: 8px;
            padding: 8px 12px;
            background: #f8fafc;
            border-top: 2px solid #059669;
            border-radius: 4px;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 6px;
            color: #374151;
        }

        .footer-left {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .footer-right {
            text-align: right;
        }

        .footer-logo {
            width: 16px;
            height: 16px;
            background: #059669;
            border-radius: 3px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 8px;
        }

        .footer-system {
            font-weight: 600;
            color: #059669;
        }

        .footer-date {
            color: #6b7280;
        }

        .footer-official {
            display: inline-block;
            padding: 2px 6px;
            background: #ecfdf5;
            color: #059669;
            border-radius: 2px;
            font-weight: 600;
        }

        .amount {
            font-weight: 600;
            color: #059669;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>BR-AMS 010 - LAPORAN TAHUNAN PENGURUSAN ASET ALIH</h1>
        <div class="subtitle">Garis Panduan Pengurusan Kewangan, Perolehan Dan Aset Masjid Dan Surau Negeri Selangor
        </div>
        <div class="info-badges">
            <div class="badge">📋 Laporan Rasmi</div>
            <div class="badge">🛡️ Negeri Selangor</div>
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th style="width:5%;">BIL.</th>
                <th style="width:55%;">KETERANGAN</th>
                <th style="width:20%;">TAHUN</th>
                <th style="width:20%;">JUMLAH (RM)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($assets as $index => $asset)
                <tr>
                    <td class="text-center font-medium">{{ $index + 1 }}</td>
                    <td>
                        <div class="font-medium">{{ $asset->nama_aset }}</div>
                        <div class="text-sm">{{ $asset->jenis_aset }}</div>
                    </td>
                    <td class="text-center">{{ $asset->tarikh_perolehan ? \Carbon\Carbon::parse($asset->tarikh_perolehan)->format('Y') : '-' }}</td>
                    <td class="text-right font-medium amount">{{ number_format($asset->nilai_perolehan, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center" style="padding:20px;color:#9ca3af;">Tiada rekod ditemui</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="note-section">
        <p><strong>ℹ️ NOTA:</strong> Laporan ini adalah laporan tahunan rasmi pengurusan aset alih.</p>
    </div>
    <div class="footer">
        <div class="footer-content">
            <div class="footer-left">
                <div class="footer-logo">AMS</div>
                <div>
                    <div class="footer-system">Sistem Pengurusan Aset Masjid & Surau</div>
                    <div class="footer-date">Dijana pada: {{ now()->format('d/m/Y H:i:s') }}</div>
                </div>
            </div>
            <div class="footer-right">
                <span class="footer-official">📋 Laporan Rasmi</span>
            </div>
        </div>
    </div>
</body>

</html>
