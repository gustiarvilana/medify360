@extends('layouts.app')

@section('title', 'Dashboard 360 - ' . config('app.name'))

@push('styles')
<style>
    .progress-thin { height: 8px; border-radius: 4px; }
</style>
@endpush

@section('content')
<div class="d-md-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Dashboard Penilaian 360</h4>
        <p class="text-muted small mb-0">Rangkuman penilaian 360 seluruh karyawan.</p>
    </div>
    <div class="mt-2 mt-md-0">
        <a href="{{ route('penilaian-360.index') }}" class="btn btn-outline-primary btn-sm">
            <span class="material-symbols-outlined">rate_review</span> Penilaian Saya
        </a>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 p-3">
            <h6 class="text-muted small">Total Target</h6>
            <h3 class="fw-bold text-primary mb-0">{{ $totalTarget }}</h3>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 p-3">
            <h6 class="text-muted small">Selesai Dinilai</h6>
            <h3 class="fw-bold text-success mb-0">{{ $totalSelesai }}</h3>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 p-3">
            <h6 class="text-muted small">Menunggu</h6>
            <h3 class="fw-bold text-warning mb-0">{{ $totalTarget - $totalSelesai }}</h3>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 p-3">
            <h6 class="text-muted small">Rata-rata Global</h6>
            <h3 class="fw-bold text-info mb-0">{{ number_format($rataRataGlobal, 2) }}</h3>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
            <h5 class="fw-bold mb-3">Rata-rata Skor per Departemen</h5>
            @if($rataPerDepartemen->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Departemen</th>
                            <th style="width:40%">Progress</th>
                            <th style="width:15%" class="text-end">Skor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rataPerDepartemen as $dept)
                        @php
                            $rata = $dept->rata_rata ? round($dept->rata_rata, 2) : 0;
                            $warna = match(true) { $rata <= 2 => 'danger', $rata <= 3 => 'warning', $rata <= 4 => 'info', default => 'success' };
                        @endphp
                        <tr>
                            <td class="fw-bold">{{ $dept->nama }}</td>
                            <td>
                                <div class="progress progress-thin">
                                    <div class="progress-bar bg-{{ $warna }}" style="width: {{ ($rata / 5) * 100 }}%"></div>
                                </div>
                            </td>
                            <td class="text-end">
                                <span class="fw-bold text-{{ $warna }}">{{ number_format($rata, 2) }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center text-muted py-5">
                <span class="material-symbols-outlined fs-1">bar_chart</span>
                <p class="mt-2">Belum ada data penilaian.</p>
            </div>
            @endif
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
            <h5 class="fw-bold mb-3">Ringkasan</h5>
            <div class="text-center mb-3">
                <div class="display-3 fw-bold text-primary">{{ $totalTarget > 0 ? round(($totalSelesai / $totalTarget) * 100) : 0 }}%</div>
                <small class="text-muted">Progress Penyelesaian</small>
            </div>
            <div class="progress mb-4" style="height:12px; border-radius:6px;">
                <div class="progress-bar bg-success" style="width: {{ $totalTarget > 0 ? ($totalSelesai / $totalTarget) * 100 : 0 }}%"></div>
            </div>
            <div class="d-flex justify-content-between small text-muted">
                <span>{{ $totalSelesai }} selesai</span>
                <span>{{ $totalTarget - $totalSelesai }} menunggu</span>
            </div>
        </div>
    </div>
</div>
@endsection
