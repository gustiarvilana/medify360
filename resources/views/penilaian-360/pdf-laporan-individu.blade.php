<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 9px; color: #333; }
        h1 { text-align: center; font-size: 18px; margin-bottom: 2px; color: #111; }
        .subtitle { text-align: center; color: #888; font-size: 10px; margin-bottom: 25px; }

        .section-title { font-size: 13px; font-weight: bold; color: #0d6efd; border-bottom: 2px solid #0d6efd; padding-bottom: 3px; margin-top: 20px; margin-bottom: 10px; }

        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .info-table td { padding: 4px 8px; font-size: 10px; }
        .info-table .label { font-weight: bold; width: 130px; color: #555; }
        .info-table .value { font-weight: bold; color: #111; }

        .stats-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .stats-table td { text-align: center; padding: 10px; border: 1px solid #dee2e6; font-size: 10px; color: #555; }
        .stats-table .num { font-size: 20px; font-weight: bold; display: block; color: #0d6efd; }

        .dimensi-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .dimensi-table th { background: #0d6efd; color: white; padding: 6px 8px; text-align: left; font-size: 9px; }
        .dimensi-table td { padding: 5px 8px; border-bottom: 1px solid #dee2e6; font-size: 9px; }
        .dimensi-table tr:nth-child(even) td { background: #f8f9fa; }

        .bar-container { width: 100px; height: 10px; background: #e9ecef; display: inline-block; vertical-align: middle; }
        .bar-fill { height: 10px; background: #0d6efd; }
        .skor-label { margin-left: 6px; font-weight: bold; }

        .assessment-box { border: 1px solid #dee2e6; border-radius: 6px; padding: 10px; margin-bottom: 12px; }
        .assessment-header { font-size: 10px; margin-bottom: 6px; }
        .assessment-header .penilai-name { font-weight: bold; color: #0d6efd; font-size: 11px; }
        .assessment-header .meta { color: #888; }
        .assessment-catatan { background: #f8f9fa; padding: 6px 8px; border-left: 3px solid #0d6efd; margin-bottom: 8px; font-style: italic; font-size: 9px; }
        .assessment-table { width: 100%; border-collapse: collapse; margin-bottom: 4px; }
        .assessment-table th { background: #e9ecef; padding: 4px 6px; text-align: left; font-size: 8px; color: #555; }
        .assessment-table td { padding: 3px 6px; border-bottom: 1px solid #f0f0f0; font-size: 9px; }
        .bobot-info { font-size: 8px; color: #888; margin-top: 4px; padding: 3px 6px; background: #f0f7ff; border-radius: 3px; display: inline-block; }

        .footer { text-align: center; color: #999; font-size: 7px; margin-top: 30px; border-top: 1px solid #dee2e6; padding-top: 8px; }

        .page-break { page-break-after: always; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>

    <h1>Laporan Penilaian 360</h1>
    <p class="subtitle">Dicetak pada {{ now()->format('d M Y H:i') }}</p>

    {{-- Profil --}}
    <div class="section-title">Profil Karyawan</div>
    <table class="info-table">
        <tr><td class="label">Nama</td><td class="value">: {{ $user->name }}</td></tr>
        <tr><td class="label">Departemen</td><td class="value">: {{ $user->departemen?->nama ?? '-' }}</td></tr>
        <tr><td class="label">Peran / Jabatan</td><td class="value">: {{ $user->peran?->nama ?? '-' }}</td></tr>
        <tr><td class="label">Email</td><td class="value">: {{ $user->email }}</td></tr>
    </table>

    {{-- Ringkasan --}}
    <div class="section-title">Ringkasan Penilaian</div>
    <table class="stats-table">
        <tr>
            <td><span class="num">{{ $penilaian->count() }}</span> Total Penilaian</td>
            <td><span class="num">{{ number_format($rataSkor, 2) }}</span> Rata-rata Skor Akhir</td>
            <td><span class="num">{{ number_format($rataSkor, 2) }}</span> Rata-rata Keseluruhan</td>
        </tr>
    </table>

    {{-- Rata-rata per Dimensi --}}
    @if(count($rataDimensi) > 0)
    <div class="section-title">Rata-rata Skor per Dimensi</div>
    <table class="dimensi-table">
        <thead>
            <tr>
                <th style="width:40%;">Dimensi</th>
                <th style="width:40%;">Skor</th>
                <th style="width:20%;" class="text-right">Nilai</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rataDimensi as $dimensi => $skor)
            <tr>
                <td>{{ $dimensi }}</td>
                <td>
                    <div class="bar-container">
                        <div class="bar-fill" style="width: {{ ($skor / 5) * 100 }}%;"></div>
                    </div>
                    <span class="skor-label">{{ number_format($skor, 2) }}</span>
                </td>
                <td class="text-right">{{ number_format(($skor / 5) * 100, 0) }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    {{-- Detail per Penilaian --}}
    <div class="section-title">Detail Setiap Penilaian</div>

    @forelse($penilaian as $index => $p)
    <div class="assessment-box">
        @php
            $rawAvg = round($p->skor->avg('skor') ?? 0, 2);
            $bobot = $bobotPerPenilaian[$p->id] ?? 1.00;
        @endphp
        <div class="assessment-header">
            <span class="penilai-name">{{ $p->penilai?->name ?? '-' }}</span>
            <span class="meta">
                &middot; {{ $p->penilai?->departemen?->nama ?? '-' }} ({{ $p->penilai?->peran?->nama ?? '-' }})
                &middot; {{ $p->tanggal_selesai?->format('d M Y') ?? '-' }}
                &middot; Skor Akhir: <strong>{{ number_format($p->skor_akhir, 2) }}</strong>
            </span>
        </div>

        @if($p->catatan)
        <div class="assessment-catatan">{{ $p->catatan }}</div>
        @endif

        <table class="assessment-table">
            <thead>
                <tr>
                    <th style="width:50%;">Dimensi</th>
                    <th style="width:25%;">Skor</th>
                    <th style="width:25%;" class="text-right">Persentase</th>
                </tr>
            </thead>
            <tbody>
                @foreach($p->skor as $s)
                <tr>
                    <td>{{ $s->dimensi?->nama ?? '-' }}</td>
                    <td>
                        <span style="display:inline-block;width:40px;height:8px;background:#e9ecef;vertical-align:middle;">
                            <span style="display:block;height:8px;background:#198754;width:{{ ($s->skor / 5) * 100 }}%;"></span>
                        </span>
                        <span style="margin-left:4px;font-weight:bold;">{{ $s->skor }}</span>
                    </td>
                    <td class="text-right">{{ number_format(($s->skor / 5) * 100, 0) }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="bobot-info">
            <strong>Perhitungan Skor Akhir:</strong>
            Rata-rata dimensi = {{ number_format($rawAvg, 2) }}
            &times; Bobot relasi ({{ $p->penilai?->peran?->nama ?? '?' }} &rarr; {{ $p->dinilai?->peran?->nama ?? '?' }}) = {{ number_format($bobot, 2) }}
            &rarr; <strong>{{ number_format($rawAvg * $bobot, 2) }}</strong>
        </div>
    </div>
    @empty
    <p style="text-align:center;color:#999;margin-top:20px;">Belum ada data penilaian.</p>
    @endforelse

    <div class="footer">
        {{ config('app.name') }} — Sistem Penilaian Kinerja &copy; {{ now()->format('Y') }}
    </div>

</body>
</html>
