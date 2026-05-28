@extends('layouts.app')

@section('title', 'Detail Laporan ' . $user->name . ' - ' . config('app.name'))

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.min.css">
@endpush

@section('content')
<div class="d-md-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Detail Penilaian: {{ $user->name }}</h4>
        <p class="text-muted small mb-0">
            {{ $user->departemen?->nama ?? '-' }} &middot; {{ $user->peran?->nama ?? '-' }}
        </p>
    </div>
    <div class="mt-2 mt-md-0 d-flex gap-2">
        <a href="{{ route('laporan-360.pdf-individu', $user->id) }}" target="_blank" class="btn btn-danger btn-sm">
            <span class="material-symbols-outlined">picture_as_pdf</span> PDF
        </a>
        <a href="{{ route('laporan-360.individu') }}" class="btn btn-outline-secondary btn-sm">
            <span class="material-symbols-outlined">arrow_back</span> Kembali
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <table id="tabelDetail" class="table table-hover align-middle mb-0 w-100">
            <thead class="table-light">
                <tr>
                    <th>Penilai</th>
                    <th>Departemen</th>
                    <th>Skor Akhir</th>
                    <th>Dimensi</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function () {
    const table = $('#tabelDetail').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("laporan-360.detail-data", $user->id) }}',
        language: {
            url: 'https://cdn.datatables.net/plug-ins/2.2.2/i18n/id.json',
            paginate: { first: '«', previous: '‹', next: '›', last: '»' },
        },
        order: [[4, 'desc']],
        columns: [
            { data: 'penilai_nama', name: 'penilai_nama' },
            { data: 'penilai_dept', name: 'penilai_dept', orderable: false, searchable: false },
            { data: 'skor_akhir', name: 'skor_akhir', searchable: false },
            { data: 'dimensi', name: 'dimensi', orderable: false, searchable: false },
            { data: 'tanggal_selesai', name: 'tanggal_selesai', searchable: false },
        ],
    });

    function initSearchMinChars(table, wrapperSelector) {
        var input = $(wrapperSelector).closest('.table-responsive, .card-body, div').find('.dt-search input, .dataTables_filter input');
        if (!input.length) input = $('.dt-search input, .dataTables_filter input').first();
        input.unbind();
        input.on('keyup', function() {
            if (this.value.length >= 2 || this.value.length === 0) {
                table.search(this.value).draw();
            }
        });
    }

    initSearchMinChars(table, '#tabelDetail');
});
</script>
@endpush
