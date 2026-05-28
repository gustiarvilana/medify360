@extends('layouts.app')

@section('title', 'Admin Laporan - ' . config('app.name'))

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.min.css">
<style>
    div.dt-container .dt-paging .dt-paging-button { border-radius: 8px; }
    div.dt-container .dt-search input { border-radius: 8px; border: 1px solid #dee2e6; padding: 6px 12px; }
    div.dt-container .dt-length select { border-radius: 8px; border: 1px solid #dee2e6; }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">📋 Admin — Semua Laporan Bata</h2>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <table id="laporan-table" class="table table-hover align-middle mb-0 w-100">
            <thead class="table-light">
                <tr>
                    <th>Tanggal</th>
                    <th>Pelapor</th>
                    <th>Dilaporkan</th>
                    <th>Tipe</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<div class="modal fade" id="statusModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold">Ubah Status</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form method="POST" action="" id="statusForm">
                    @csrf
                    <select name="status" class="form-select mb-3" required>
                        <option value="menunggu">Menunggu</option>
                        <option value="ditinjau">Ditinjau</option>
                        <option value="selesai">Selesai</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary py-2 fw-bold">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.min.js"></script>
<script>
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

$(document).ready(function() {
    const laporanTable = $('#laporan-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.laporan.data") }}',
        language: {
            url: 'https://cdn.datatables.net/plug-ins/2.2.2/i18n/id.json',
            paginate: { first: '«', previous: '‹', next: '›', last: '»' },
        },
        columns: [
            { data: 'created_at', name: 'created_at' },
            { data: 'id_pelapor', name: 'id_pelapor', orderable: false },
            { data: 'id_penerima', name: 'id_penerima', orderable: false },
            { data: 'tipe', name: 'tipe' },
            { data: 'deskripsi', name: 'deskripsi', render: function(d) { return d && d.length > 40 ? d.substr(0, 40) + '…' : d || '-'; } },
            { data: 'status', name: 'status', orderable: false },
            { data: 'action', name: 'action', orderable: false, width: '60px' },
        ],
    });

    initSearchMinChars(laporanTable, '#laporan-table');

    $(document).on('click', '.update-status', function() {
        const id = $(this).data('id');
        $('#statusForm').attr('action', '{{ url("admin/laporan") }}/' + id + '/status');
        $('#statusForm select[name="status"]').val($(this).data('status'));
        new bootstrap.Modal($('#statusModal')[0]).show();
    });
});
</script>
@endpush
