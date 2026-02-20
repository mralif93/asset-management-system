<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>BR-AMS 004 - Borang Permohonan Pergerakan / Pinjaman Aset Alih</title>
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
            text-transform: uppercase;
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

        .italic {
            font-style: italic;
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

        /* Specific column widths optimization */
        .col-bil {
            width: 3%;
        }

        .col-user {
            width: 10%;
        }

        .col-jawatan {
            width: 8%;
        }

        .col-tujuan {
            width: 10%;
        }

        .col-no-siri {
            width: 10%;
        }

        .col-aset {
            width: 12%;
        }

        .col-pinjam {
            width: 23%;
        }

        /* Split into 4 sub-cols */
        .col-pulang {
            width: 23%;
        }

        /* Split into 4 sub-cols */

        .sub-col {
            width: 25%;
        }

        /* Within the 23% sections */
    </style>
</head>

<body>
    <div class="header">
        <h1>BR-AMS 004 - BORANG PERMOHONAN PERGERAKAN / PINJAMAN ASET ALIH</h1>
        <div class="subtitle">Garis Panduan Pengurusan Kewangan, Perolehan Dan Aset Masjid Dan Surau Negeri Selangor
        </div>
        <div class="info-badges">
            <div class="badge">📋 Borang Rasmi</div>
            <div class="badge">🛡️ Negeri Selangor</div>
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th rowspan="2" class="col-bil">BIL.</th>
                <th rowspan="2" class="col-user">NAMA PEMOHON</th>
                <th rowspan="2" class="col-jawatan">JAWATAN</th>
                <th rowspan="2" class="col-tujuan">TUJUAN</th>
                <th rowspan="2" class="col-no-siri">NO. SIRI PENDAFTARAN</th>
                <th rowspan="2" class="col-aset">KETERANGAN ASET</th>
                <th colspan="4">DIPINJAM / DIKELUARKAN</th>
                <th colspan="4">DIPULANGKAN</th>
            </tr>
            <tr>
                <!-- Dipinjam Sub-headers -->
                <th>TARIKH</th>
                <th>KUANTITI</th>
                <th>T/T PENGELUAR</th>
                <th>T/T PEMINJAM</th>

                <!-- Dipulangkan Sub-headers -->
                <th>TARIKH</th>
                <th>KUANTITI</th>
                <th>T/T PENERIMA</th>
                <th>T/T PEMULANG</th>
            </tr>
        </thead>
        <tbody>
            @forelse($groupedMovements as $groupKey => $movements)
                @php
                    $firstMovement = $movements->first();
                    $totalQuantity = $movements->sum('kuantiti');
                    $asset = $firstMovement->asset;
                @endphp
                <tr>
                    <td class="text-center font-medium">{{ $loop->iteration }}</td>
                    <td class="text-center">
                        <div class="font-medium">{{ $firstMovement->user->name ?? 'N/A' }}</div>
                    </td>
                    <td class="text-center">{{ $firstMovement->user->jawatan ?? 'N/A' }}</td>
                    <td class="text-center">{{ $firstMovement->tujuan_pergerakan ?? 'N/A' }}</td>
                    <td class="text-center">
                        <div class="font-medium">{{ $asset->no_siri_pendaftaran ?? 'N/A' }}</div>
                        @if($movements->count() > 1)
                            <div class="text-sm italic">(+{{ $movements->count() - 1 }} item)</div>
                        @endif
                    </td>
                    <td>
                        <div class="font-medium">{{ $asset->nama_aset ?? 'N/A' }}</div>
                        <div class="text-sm">{{ $asset->jenis_aset ?? '' }}</div>
                    </td>

                    <!-- Dipinjam -->
                    <td class="text-center">
                        {{ $firstMovement->tarikh_mula ? \Carbon\Carbon::parse($firstMovement->tarikh_mula)->format('d/m/Y') : '' }}
                    </td>
                    <td class="text-center">{{ $totalQuantity }}</td>
                    <td class="text-center">
                        <div class="text-sm">{{ $firstMovement->approver->name ?? '-' }}</div>
                    </td>
                    <td class="text-center">
                        @if($firstMovement->pegawai_bertanggungjawab_signature)
                            <span class="text-sm">[Tandatangan]</span>
                        @else
                            -
                        @endif
                    </td>

                    <!-- Dipulangkan -->
                    <td class="text-center">
                        {{ $firstMovement->tarikh_pulang_sebenar ? \Carbon\Carbon::parse($firstMovement->tarikh_pulang_sebenar)->format('d/m/Y') : '-' }}
                    </td>
                    <td class="text-center">
                        {{ $firstMovement->tarikh_pulang_sebenar ? $totalQuantity : '-' }}
                    </td>
                    <td class="text-center">
                        @if($firstMovement->tandatangan_penerima)
                            <span class="text-sm">[Tandatangan]</span>
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-center">
                        @if($firstMovement->tandatangan_pemulangan)
                            <span class="text-sm">[Tandatangan]</span>
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="14" class="empty-state">
                        <div style="font-size: 10px; font-weight: 600;">Tiada rekod pergerakan ditemui</div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="footer">Dijana pada: {{ now()->format('d/m/Y H:i:s') }} | Sistem Pengurusan Aset Masjid & Surau</div>
</body>

</html>