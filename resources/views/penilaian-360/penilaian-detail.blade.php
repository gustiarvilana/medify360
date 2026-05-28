@extends('layouts.app')

@section('title', 'Detail Penilaian 360 - ' . config('app.name'))

@push('styles')
<style>
    .star-display .material-symbols-outlined {
        font-size: 1.4rem;
    }
</style>
@endpush

@section('content')
<div class="mb-4">
    <a href="{{ route('penilaian-360.index') }}" class="btn btn-sm btn-outline-secondary mb-3">
        <span class="material-symbols-outlined">arrow_back</span> Kembali
    </a>
    <h4 class="fw-bold mb-0">Detail Penilaian 360</h4>
</div>

<div class="row g-4">
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-bold mb-3">Informasi Penilaian</h5>

            <div class="d-flex align-items-center gap-3 mb-4">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($penilaian->dinilai->name) }}&background=0d6efd&color=fff&size=64" class="rounded-circle" width="64">
                <div>
                    <h5 class="fw-bold mb-0">{{ $penilaian->dinilai->name }}</h5>
                    <small class="text-muted">{{ $penilaian->dinilai->departemen?->nama ?? '-' }}</small>
                </div>
            </div>

            <hr>

            <div class="mb-3">
                <div class="d-flex justify-content-between mb-2">
                    <small class="text-muted">Penilai</small>
                    <span>{{ $penilaian->penilai->name }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <small class="text-muted">Tanggal Selesai</small>
                    <span>{{ $penilaian->tanggal_selesai ? $penilaian->tanggal_selesai->format('d M Y H:i') : '-' }}</span>
                </div>
            </div>

            <hr>

            <div class="text-center py-3">
                <small class="text-muted">Skor Akhir</small>
                <div class="display-4 fw-bold text-primary">{{ number_format($penilaian->skor_akhir, 2) }}</div>
                @php
                    $skorRounded = round($penilaian->skor_akhir ?? 0);
                    $predikat = match(true) { $skorRounded <= 2 => 'Perlu Perbaikan', $skorRounded <= 3 => 'Cukup', $skorRounded <= 4 => 'Baik', default => 'Sangat Baik' };
                    $warna = match(true) { $skorRounded <= 2 => 'danger', $skorRounded <= 3 => 'warning', $skorRounded <= 4 => 'info', default => 'success' };
                @endphp
                <span class="badge bg-{{ $warna }} fs-6 mt-1">{{ $predikat }}</span>
            </div>

            @if($penilaian->catatan)
            <hr>
            <div>
                <small class="text-muted">Catatan</small>
                <p class="mb-0 fst-italic mt-1 bg-light p-3 rounded-3">"{{ $penilaian->catatan }}"</p>
            </div>
            @endif
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-bold mb-4">Rincian Skor per Dimensi</h5>

            @foreach($penilaian->skor as $s)
            @php
                $predikatDimensi = match(true) { $s->skor <= 2 => 'Perlu Perbaikan', $s->skor <= 3 => 'Cukup', $s->skor <= 4 => 'Baik', default => 'Sangat Baik' };
                $warnaDimensi = match(true) { $s->skor <= 2 => 'danger', $s->skor <= 3 => 'warning', $s->skor <= 4 => 'info', default => 'success' };
            @endphp
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fw-bold">{{ $s->dimensi->nama ?? '-' }}</span>
                    <span class="badge bg-{{ $warnaDimensi }}">{{ $predikatDimensi }}</span>
                </div>
                <div class="star-display d-flex align-items-center gap-1 mb-2">
                    @for($i = 1; $i <= 5; $i++)
                    <span class="material-symbols-outlined {{ $i <= $s->skor ? 'text-'.$warnaDimensi : 'text-muted' }}" style="font-size:1.4rem">star</span>
                    @endfor
                    <span class="ms-2 small fw-bold">{{ $s->skor }}/5</span>
                </div>
                <div class="progress" style="height:6px">
                    <div class="progress-bar bg-{{ $warnaDimensi }}" style="width: {{ ($s->skor / 5) * 100 }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
