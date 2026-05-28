@extends('layouts.app')

@section('title', 'Riwayat Aktivitas - ' . config('app.name'))

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.min.css">
<style>
    div.dt-container .dt-paging .dt-paging-button { border-radius: 8px; }
    div.dt-container .dt-search input { border-radius: 8px; border: 1px solid #dee2e6; padding: 6px 12px; }
    div.dt-container .dt-length select { border-radius: 8px; border: 1px solid #dee2e6; }
</style>
@endpush

@section('content')
<div class="d-md-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-1">Riwayat Aktivitas</h2>
    <div class="d-flex gap-2">
        <select class="form-select form-select-sm" id="filterTipe" style="width: auto;">
            <option value="all">Semua Tipe</option>
            <option value="cendol">Cendol</option>
            <option value="bata">Bata</option>
        </select>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-sm-4">
        <div class="card border-0 shadow-sm rounded-4 p-3">
            <h6 class="text-muted small">Total Interaksi</h6>
            <h3 class="fw-bold">{{ $cendol->count() + $laporan->count() }}</h3>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card border-0 shadow-sm rounded-4 p-3">
            <h6 class="text-muted small">Apresiasi Diberikan</h6>
            <h3 class="fw-bold text-success">{{ $cendol->count() }}</h3>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card border-0 shadow-sm rounded-4 p-3">
            <h6 class="text-muted small">Laporan Dibuat</h6>
            <h3 class="fw-bold text-danger">{{ $laporan->count() }}</h3>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <table id="riwayat-table" class="table table-hover align-middle mb-0 w-100">
            <thead class="table-light">
                <tr>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                    <th>Subjek</th>
                    <th>Kategori</th>
                    <th>Pesan</th>
                    <th>Status</th>
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
$(document).ready(function() {
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

    const table = $('#riwayat-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("riwayat.data") }}',
            data: function(d) {
                d.tipe = $('#filterTipe').val();
            },
        },
        language: {
            url: 'https://cdn.datatables.net/plug-ins/2.2.2/i18n/id.json',
            paginate: { first: '«', previous: '‹', next: '›', last: '»' },
        },
        columns: [
            { data: 'tanggal', name: 'tanggal' },
            { data: 'aksi_display', name: 'tipe', orderable: false },
            { data: 'subjek', name: 'subjek' },
            { data: 'kategori', name: 'kategori' },
            { data: 'pesan', name: 'pesan', render: function(d) { return d && d.length > 50 ? d.substr(0, 50) + '…' : d || '-'; } },
            { data: 'status', name: 'status', orderable: false },
        ],
    });

    initSearchMinChars(table, '#riwayat-table');

    $('#filterTipe').on('change', function() {
        table.ajax.reload();
    });
});
</script>
@endpush
