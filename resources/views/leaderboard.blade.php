@extends('layouts.app')

@section('title', 'Peringkat Apresiasi - ' . config('app.name'))

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.min.css">
<style>
    div.dt-container .dt-paging .dt-paging-button { border-radius: 8px; }
    div.dt-container .dt-search input { border-radius: 8px; border: 1px solid #dee2e6; padding: 6px 12px; }
    div.dt-container .dt-length select { border-radius: 8px; border: 1px solid #dee2e6; }
    .top-rank-card { transition: all 0.3s; }
    .top-rank-card:hover { transform: translateY(-8px); box-shadow: 0 12px 24px rgba(0,0,0,0.1); }
    .rank-1 { transform: scale(1.05); }
</style>
@endpush

@section('content')
<div class="d-md-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-1">Peringkat Apresiasi</h2>
    <select class="form-select form-select-sm" id="filterPeriode" style="width: auto;">
        <option>Mingguan</option>
        <option>Bulanan</option>
    </select>
</div>

@if($top3->isNotEmpty())
<div class="row justify-content-center g-4 mb-5">
    @foreach($top3 as $index => $user)
    @php
        $rank = $loop->index + 1;
        $border = $rank === 1 ? 'border-warning' : ($rank === 2 ? 'border-secondary' : 'border-warning-subtle');
    @endphp
    <div class="col-md-4 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 p-4 text-center top-rank-card {{ $rank === 1 ? 'rank-1' : '' }}">
            <div class="position-relative d-inline-block mx-auto mb-3">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random&size=80" class="rounded-circle border border-3 {{ $border }}" width="80" height="80">
                <div class="position-absolute bottom-0 end-0 bg-{{ $rank === 1 ? 'warning' : ($rank === 2 ? 'secondary' : 'warning') }} rounded-circle d-flex align-items-center justify-content-center" style="width: 28px; height: 28px;">
                    <span class="fw-bold small text-white">{{ $rank }}</span>
                </div>
            </div>
            <h6 class="fw-bold mb-1">{{ $user->name }}</h6>
            <small class="text-muted">{{ $user->departemen->nama ?? '-' }}</small>
            <h4 class="fw-bold text-success mt-2 mb-0">{{ $user->cendol_diterima_count }}</h4>
            <small class="text-muted">Cendol</small>
        </div>
    </div>
    @endforeach
</div>
@endif

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <table id="leaderboard-table" class="table table-hover align-middle mb-0 w-100">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Departemen</th>
                    <th>Cendol</th>
                    <th>Tren</th>
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

    initSearchMinChars(leaderboardTable, '#leaderboard-table');
    }

    const leaderboardTable = $('#leaderboard-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("leaderboard.data") }}',
        language: {
            url: 'https://cdn.datatables.net/plug-ins/2.2.2/i18n/id.json',
            paginate: { first: '«', previous: '‹', next: '›', last: '»' },
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', width: '40px', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'id_departemen', name: 'id_departemen', orderable: false },
            { data: 'cendol_diterima_count', name: 'cendol_diterima_count' },
            { data: 'tren', name: 'tren', orderable: false, searchable: false },
        ],
        order: [[3, 'desc']],
        pageLength: 10,
        lengthMenu: [[5, 10, 25, -1], [5, 10, 25, 'Semua']],
    });
});
</script>
@endpush
