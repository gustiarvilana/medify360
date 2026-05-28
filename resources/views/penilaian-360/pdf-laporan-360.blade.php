<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 9px; color: #333; }
        h1 { text-align: center; font-size: 18px; margin-bottom: 2px; color: #111; }
        .subtitle { text-align: center; color: #888; font-size: 10px; margin-bottom: 25px; }

        .section-title { font-size: 13px; font-weight: bold; color: #0d6efd; border-bottom: 2px solid #0d6efd; padding-bottom: 3px; margin-top: 20px; margin-bottom: 10px; }

        .stats-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .stats-table td { text-align: center; padding: 10px; border: 1px solid #dee2e6; font-size: 10px; color: #555; }
        .stats-table .num { font-size: 20px; font-weight: bold; display: block; color: #0d6efd; }

        table.data { width: 100%; border-collapse: collapse; margin-top: 5px; }
        table.data th { background: #0d6efd; color: white; padding: 5px 6px; text-align: left; font-size: 8px; }
        table.data td { padding: 4px 6px; border-bottom: 1px solid #dee2e6; font-size: 8px; }
        table.data tr:nth-child(even) td { background: #f8f9fa; }

        .footer { text-align: center; color: #999; font-size: 7px; margin-top: 30px; border-top: 1px solid #dee2e6; padding-top: 8px; }
        .page-break { page-break-after: always; }
        .text-right { text-align: right; }
    </style>
</head>
<body>

    <h1>Laporan Penilaian 360</h1>
    <p class="subtitle">Rekap seluruh penilaian &mdash; Dicetak pada {{ now()->format('d M Y H:i') }}</p>

    <div class="section-title">Ringkasan</div>
    <table class="stats-table">
        <tr>
            <td><span class="num">{{ $totalData }}</span> Total Penilaian</td>
            <td><span class="num">{{ number_format($rataRata, 2) }}</span> Rata-rata Skor</td>
            <td><span class="num">{{ $penilaian->groupBy(fn($p) => $p->dinilai?->id)->count() }}</span> Karyawan Dinilai</td>
            <td><span class="num">{{ now()->format('Y') }}</span> Tahun</td>
        </tr>
    </table>

    <div class="section-title">Daftar Seluruh Penilaian</div>
    <table class="data">
        <thead>
            <tr>
                <th>No</th>
                <th>Penilai</th>
                <th>Dept</th>
                <th>Dinilai</th>
                <th>Dept</th>
                <th>Skor</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($penilaian as $index => $p)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $p->penilai?->name ?? '-' }}</td>
                <td>{{ $p->penilai?->departemen?->nama ?? '-' }}</td>
                <td>{{ $p->dinilai?->name ?? '-' }}</td>
                <td>{{ $p->dinilai?->departemen?->nama ?? '-' }}</td>
                <td>{{ number_format($p->skor_akhir, 2) }}</td>
                <td>{{ $p->tanggal_selesai?->format('d M Y') ?? '-' }}</td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center">Belum ada data penilaian.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        {{ config('app.name') }} — Sistem Penilaian Kinerja &copy; {{ now()->format('Y') }}
    </div>
</body>
</html>
