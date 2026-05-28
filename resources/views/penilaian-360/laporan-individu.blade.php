@extends('layouts.app')

@section('title', 'Laporan per Individu - ' . config('app.name'))

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.min.css">
@endpush

@section('content')
<div class="d-md-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Laporan per Individu</h4>
        <p class="text-muted small mb-0">Rekap penilaian 360 per individu.</p>
    </div>
    <div class="mt-2 mt-md-0 d-flex gap-2">
        <a href="{{ route('laporan-360.index') }}" class="btn btn-outline-primary btn-sm">
            <span class="material-symbols-outlined">description</span> Semua Laporan
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <table id="tabelIndividu" class="table table-hover align-middle mb-0 w-100">
            <thead class="table-light">
                <tr>
                    <th>Nama</th>
                    <th>Departemen</th>
                    <th>Peran</th>
                    <th>Total Penilaian</th>
                    <th>Rata-rata Skor</th>
                    <th>Aksi</th>
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
    const table = $('#tabelIndividu').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("laporan-360.individu-data") }}',
        language: {
            url: 'https://cdn.datatables.net/plug-ins/2.2.2/i18n/id.json',
            paginate: { first: '«', previous: '‹', next: '›', last: '»' },
        },
        order: [[4, 'desc']],
        columns: [
            { data: 'name', name: 'name' },
            { data: 'departemen_nama', name: 'departemen_nama' },
            { data: 'peran_nama', name: 'peran_nama', orderable: false },
            { data: 'total_penilaian', name: 'total_penilaian', searchable: false },
            { data: 'rata_skor', name: 'rata_skor', searchable: false },
            { data: 'aksi', name: 'aksi', orderable: false, searchable: false },
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

    initSearchMinChars(table, '#tabelIndividu');
});
</script>
@endpush
