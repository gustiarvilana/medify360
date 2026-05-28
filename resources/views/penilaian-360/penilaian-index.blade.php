@extends('layouts.app')

@section('title', 'Penilaian 360 - ' . config('app.name'))

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.min.css">
@endpush

@section('content')
@php
    use App\Models\TargetPenilaian;
    use App\Models\Penilaian360;
    $userId = Auth::id();
    $totalTugas = TargetPenilaian::where('id_penilai', $userId)->count();
    $tugasSelesai = Penilaian360::where('id_penilai', $userId)->count();
    $tugasMenunggu = $totalTugas - $tugasSelesai;
@endphp

<div class="d-md-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Penilaian 360</h4>
        <p class="text-muted small mb-0">Nilai rekan kerja Anda berdasarkan dimensi yang telah ditentukan.</p>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-sm-4">
        <div class="card border-0 shadow-sm rounded-4 p-3">
            <h6 class="text-muted small">Total Tugas</h6>
            <h3 class="fw-bold mb-0">{{ $totalTugas }}</h3>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card border-0 shadow-sm rounded-4 p-3">
            <h6 class="text-muted small">Selesai Dinilai</h6>
            <h3 class="fw-bold text-success mb-0">{{ $tugasSelesai }}</h3>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card border-0 shadow-sm rounded-4 p-3">
            <h6 class="text-muted small">Menunggu</h6>
            <h3 class="fw-bold text-warning mb-0">{{ $tugasMenunggu }}</h3>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <table id="tabelPenilaian" class="table table-hover align-middle mb-0 w-100">
            <thead class="table-light">
                <tr>
                    <th>Rekan Kerja</th>
                    <th>Departemen</th>
                    <th>Status</th>
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
    const table = $('#tabelPenilaian').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("penilaian-360.data") }}',
        language: {
            url: 'https://cdn.datatables.net/plug-ins/2.2.2/i18n/id.json',
            paginate: { first: '«', previous: '‹', next: '›', last: '»' },
        },
        columns: [
            { data: 'dinilai_nama', name: 'dinilai_nama' },
            { data: 'departemen', name: 'departemen', orderable: false },
            { data: 'status', name: 'status', orderable: false },
            { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
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

    initSearchMinChars(table, '#tabelPenilaian');
});
</script>
@endpush
