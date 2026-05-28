@extends('layouts.app')

@section('title', 'Bobot Penilaian 360 - ' . config('app.name'))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Bobot Penilaian 360</h4>
        <p class="text-muted small mb-0">Atur bobot penilaian berdasarkan relasi peran. Skor akhir = rata-rata dimensi × bobot relasi.</p>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('bobot.update') }}">
            @csrf
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Penilai</th>
                            <th>Dinilai</th>
                            <th style="width:200px">Bobot</th>
                            <th style="width:120px">Skor Maks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bobot as $item)
                        <tr>
                            <td class="fw-bold">{{ $item->peranPenilai->nama ?? '-' }}</td>
                            <td>{{ $item->peranDinilai->nama ?? '-' }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2 bobot-wrapper">
                                    <input type="range" class="form-range flex-grow-1 bobot-slider" min="0" max="5" step="0.1" value="{{ $item->bobot }}" data-target="{{ $item->id }}">
                                    <input type="number" name="bobot[{{ $item->id }}]" class="form-control bobot-input" style="width:80px" min="0" max="5" step="0.1" value="{{ number_format($item->bobot, 2) }}">
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info">5 × {{ number_format($item->bobot, 2) }} = <strong>{{ number_format(5 * $item->bobot, 2) }}</strong></span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">Belum ada data bobot.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($bobot->isNotEmpty())
            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-primary py-2 px-4 fw-bold">Simpan Bobot</button>
            </div>
            @endif
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 mt-4 p-4">
    <h5 class="fw-bold mb-3">Cara Perhitungan Skor Akhir</h5>
    <div class="bg-light rounded-3 p-3">
        <p class="mb-1"><strong>Skor Akhir</strong> = Rata-rata Skor Dimensi × Bobot Relasi</p>
        <p class="mb-0 small text-muted">
            Contoh: Seorang Karyawan menilai Karyawan lain dengan skor rata-rata 4.0 dan bobot 1.00 →
            <strong>4.0 × 1.00 = 4.00</strong>.
            <br>
            Seorang Manajer menilai Karyawan dengan skor rata-rata 4.0 dan bobot 1.50 →
            <strong>4.0 × 1.50 = 6.00</strong>.
        </p>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    $('.bobot-wrapper').each(function () {
        const wrapper = $(this);
        const slider = wrapper.find('.bobot-slider');
        const input = wrapper.find('.bobot-input');

        slider.on('input', function () {
            input.val(parseFloat(this.value).toFixed(2));
        });

        input.on('input', function () {
            let val = parseFloat(this.value);
            if (isNaN(val)) val = 0;
            if (val > 5) val = 5;
            if (val < 0) val = 0;
            slider.val(val);
        });
    });
});
</script>
@endpush
