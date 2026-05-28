@extends('layouts.app')

@section('title', 'Laporan & Apresiasi - ' . config('app.name'))

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.min.css">
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Laporan & Apresiasi</h2>
</div>

<ul class="nav nav-pills mb-4 gap-2" id="laporanTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active rounded-pill px-4" id="bata-tab" data-bs-toggle="tab" data-bs-target="#bata" type="button">Laporan Bata</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link rounded-pill px-4" id="cendol-tab" data-bs-toggle="tab" data-bs-target="#cendol" type="button">Cendol Saya</button>
    </li>
</ul>

<div class="tab-content">
    <div class="tab-pane fade show active" id="bata">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <table id="bata-table" class="table table-hover align-middle mb-0 w-100">
                    <thead class="table-light">
                        <tr><th>Tanggal</th><th>Jenis Insiden</th><th>Status</th><th>Aksi</th></tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="cendol">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <table id="cendol-table" class="table table-hover align-middle mb-0 w-100">
                    <thead class="table-light">
                        <tr><th>Tanggal</th><th>Pengirim</th><th>Kategori</th><th>Pesan</th></tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold">Detail Laporan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="fw-bold small text-muted">Tipe</label>
                    <p class="mb-0 fs-6" id="detail-tipe"></p>
                </div>
                <div class="mb-3">
                    <label class="fw-bold small text-muted">Deskripsi</label>
                    <p class="mb-0 fs-6" id="detail-deskripsi"></p>
                </div>
                <div class="mb-0">
                    <label class="fw-bold small text-muted">Status</label>
                    <p class="mb-0" id="detail-status"></p>
                </div>
            </div>
        </div>
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

    const bataTable = $('#bata-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("laporan.data") }}',
        language: {
            url: 'https://cdn.datatables.net/plug-ins/2.2.2/i18n/id.json',
            paginate: { first: '«', previous: '‹', next: '›', last: '»' },
        },
        columns: [
            { data: 'created_at', name: 'created_at' },
            { data: 'tipe', name: 'tipe' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
        order: [[0, 'desc']],
        pageLength: 10,
        lengthMenu: [[5, 10, 25, -1], [5, 10, 25, 'Semua']],
    });

    initSearchMinChars(bataTable, '#bata-table');

    const cendolTable = $('#cendol-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("laporan.data-cendol") }}',
        language: {
            url: 'https://cdn.datatables.net/plug-ins/2.2.2/i18n/id.json',
            paginate: { first: '«', previous: '‹', next: '›', last: '»' },
        },
        columns: [
            { data: 'created_at', name: 'created_at' },
            { data: 'id_pengirim', name: 'id_pengirim' },
            { data: 'kategori', name: 'kategori' },
            { data: 'pesan', name: 'pesan' },
        ],
        order: [[0, 'desc']],
        pageLength: 10,
        lengthMenu: [[5, 10, 25, -1], [5, 10, 25, 'Semua']],
    });

    initSearchMinChars(cendolTable, '#cendol-table');

    $(document).on('click', '.detail-laporan', function() {
        const id = $(this).data('id');
        $.get('{{ url("laporan/detail") }}/' + id, function(data) {
            $('#detail-tipe').text(data.tipe);
            $('#detail-deskripsi').text(data.deskripsi);
            $('#detail-status').html('<span class="badge ' + data.status_badge + '">' + data.status + '</span>');
            $('#detailModal').modal('show');
        });
    });
});
</script>
@endpush
