@extends('layouts.app')

@section('title', 'Analisis Performa - ' . config('app.name'))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">📊 Analisis Performa Budaya</h2>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 border-start border-4 border-primary shadow-sm rounded-4 p-3">
            <h6 class="text-muted small">Skor Performa</h6>
            <h3 class="fw-bold text-primary mb-0">85</h3>
            <small class="text-success">+5 dari bulan lalu</small>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 border-start border-4 border-success shadow-sm rounded-4 p-3">
            <h6 class="text-muted small">Posisi Departemen</h6>
            <h3 class="fw-bold text-success mb-0">#2</h3>
            <small class="text-muted">Dari 5 departemen</small>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 border-start border-4 border-info shadow-sm rounded-4 p-3">
            <h6 class="text-muted small">Tren Pertumbuhan</h6>
            <h3 class="fw-bold text-info mb-0">+12%</h3>
            <small class="text-success">Meningkat</small>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-bold mb-3">Radar Kekuatan Budaya 360</h5>
            <canvas id="radarChart" height="250"></canvas>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-bold mb-3">Tren Performa Bulanan</h5>
            <canvas id="lineChart" height="250"></canvas>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
    <h5 class="fw-bold mb-3">Rincian Skor per Kategori</h5>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>Kategori</th><th>Skor</th><th>Target</th><th>Status</th></tr>
            </thead>
            <tbody>
                @foreach(['Kolaborasi', 'Integritas', 'Inovasi', 'Ketelitian', 'Disiplin'] as $cat)
                @php
                    $skor = rand(70, 95);
                    $target = 85;
                    $status = $skor >= $target ? 'Tercapai' : 'Perlu Ditingkatkan';
                    $badge = $skor >= $target ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning';
                @endphp
                <tr>
                    <td class="fw-bold">{{ $cat }}</td>
                    <td>{{ $skor }}%</td>
                    <td>{{ $target }}%</td>
                    <td><span class="badge {{ $badge }}">{{ $status }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="card border-0 border-start border-4 border-primary shadow-sm rounded-4 p-4">
    <div class="d-flex align-items-center gap-3">
        <span class="material-symbols-outlined text-primary" style="font-size: 32px;">lightbulb</span>
        <div>
            <h6 class="fw-bold mb-1">Rekomendasi Pengembangan</h6>
            <p class="text-muted mb-0">Tingkatkan skor Inovasi dengan mengadakan sesi brainstorming mingguan. Departemen Anda unggul dalam Kolaborasi — pertahankan!</p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('radarChart'), {
    type: 'radar',
    data: {
        labels: ['Kolaborasi', 'Integritas', 'Inovasi', 'Ketelitian', 'Disiplin'],
        datasets: [{
            label: 'Skor Saat Ini',
            data: [92, 78, 65, 88, 82],
            backgroundColor: 'rgba(13, 110, 253, 0.1)',
            borderColor: '#0d6efd',
            pointBackgroundColor: '#0d6efd',
        }]
    },
    options: { responsive: true, maintainAspectRatio: true, scales: { r: { min: 0, max: 100 } } }
});

new Chart(document.getElementById('lineChart'), {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei'],
        datasets: [{
            label: 'Skor Budaya',
            data: [72, 75, 80, 85, 92],
            borderColor: '#198754',
            tension: 0.3,
            fill: true,
            backgroundColor: 'rgba(25, 135, 84, 0.1)',
        }]
    },
    options: { responsive: true, maintainAspectRatio: true, scales: { y: { min: 60, max: 100 } } }
});
</script>
@endpush
