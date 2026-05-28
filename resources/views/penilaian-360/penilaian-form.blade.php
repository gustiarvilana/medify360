@extends('layouts.app')

@section('title', 'Nilai Rekan Kerja - ' . config('app.name'))

@push('styles')
<style>
    .star-rating .material-symbols-outlined {
        font-size: 2rem;
        cursor: pointer;
        transition: color 0.15s, transform 0.15s;
    }
    .star-rating .material-symbols-outlined:hover {
        transform: scale(1.3);
    }
    .star-rating .material-symbols-outlined.checked {
        font-variation-settings: 'FILL' 1;
    }
</style>
@endpush

@section('content')
<div class="mb-4">
    <a href="{{ route('penilaian-360.index') }}" class="btn btn-sm btn-outline-secondary mb-3">
        <span class="material-symbols-outlined">arrow_back</span> Kembali
    </a>
    <div class="d-flex align-items-center gap-3">
        <img src="https://ui-avatars.com/api/?name={{ urlencode($target->dinilai->name) }}&background=0d6efd&color=fff&size=56" class="rounded-circle" width="56">
        <div>
            <h4 class="fw-bold mb-0">{{ $target->dinilai->name }}</h4>
            <p class="text-muted small mb-0">{{ $target->dinilai->departemen?->nama ?? '-' }}</p>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('penilaian-360.store') }}">
            @csrf
            <input type="hidden" name="id_target" value="{{ $target->id }}">

            <p class="text-muted mb-4">Berikan penilaian untuk setiap dimensi berikut (1 = Sangat Kurang, 5 = Sangat Baik).</p>

            @foreach($dimensi as $d)
            <div class="mb-4 p-3 bg-light rounded-3">
                <label class="form-label fw-bold mb-1">{{ $d->nama }}</label>
                @if($d->deskripsi)
                <p class="text-muted small mb-2">{{ $d->deskripsi }}</p>
                @endif
                <div class="star-rating d-flex align-items-center gap-1" data-dimensi="{{ $d->id }}">
                    @for($i = 1; $i <= 5; $i++)
                    <span class="material-symbols-outlined text-muted" data-value="{{ $i }}" role="button">star</span>
                    @endfor
                    <span class="ms-2 small fw-bold text-primary rating-label">Pilih</span>
                </div>
                <input type="hidden" name="skor[{{ $d->id }}]" class="skor-input" value="">
            </div>
            @endforeach

            <div class="mb-4">
                <label class="form-label fw-bold">Catatan (opsional)</label>
                <textarea name="catatan" class="form-control" rows="3" placeholder="Tambahkan catatan untuk penilaian ini..."></textarea>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary py-2 fw-bold flex-fill" id="btnSimpan">Simpan Penilaian</button>
                <a href="{{ route('penilaian-360.index') }}" class="btn btn-secondary py-2">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    $('.star-rating').each(function () {
        const container = $(this);
        const stars = container.find('.material-symbols-outlined');
        const hiddenInput = container.siblings('.skor-input');
        const label = container.find('.rating-label');

        function setRating(val) {
            stars.each(function () {
                const v = parseInt($(this).data('value'));
                if (v <= val) {
                    $(this).removeClass('text-muted').addClass('text-warning checked');
                } else {
                    $(this).removeClass('text-warning checked').addClass('text-muted');
                }
            });
            hiddenInput.val(val);
            const labels = ['', 'Sangat Kurang', 'Kurang', 'Cukup', 'Baik', 'Sangat Baik'];
            label.text(labels[val] || 'Pilih');
        }

        stars.on('click', function () {
            setRating(parseInt($(this).data('value')));
        });

        stars.on('mouseenter', function () {
            const val = parseInt($(this).data('value'));
            stars.each(function () {
                const v = parseInt($(this).data('value'));
                if (v <= val) {
                    $(this).removeClass('text-muted').addClass('text-warning');
                } else {
                    $(this).removeClass('text-warning').addClass('text-muted');
                }
            });
        });

        container.on('mouseleave', function () {
            const current = parseInt(hiddenInput.val());
            if (current) {
                setRating(current);
            } else {
                stars.removeClass('text-warning').addClass('text-muted');
                label.text('Pilih');
            }
        });
    });

    $('#btnSimpan').on('click', function (e) {
        let allFilled = true;
        $('.skor-input').each(function () {
            if (!$(this).val()) {
                allFilled = false;
                $(this).closest('.mb-4').addClass('border border-danger rounded-3');
            } else {
                $(this).closest('.mb-4').removeClass('border border-danger rounded-3');
            }
        });
        if (!allFilled) {
            e.preventDefault();
            alert('Harap berikan penilaian untuk semua dimensi.');
        }
    });
});
</script>
@endpush
