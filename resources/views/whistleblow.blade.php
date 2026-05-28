@extends('layouts.app')

@section('title', 'Laporan Whistleblow - ' . config('app.name'))

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.min.css">
<style>
.modal-laporan .modal-body p { margin-bottom: 0.5rem; }
.modal-laporan .modal-body p:last-child { margin-bottom: 0; }
.modal-laporan .label { font-weight: 600; color: #6c757d; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; }
</style>
@endpush

@section('content')
@php $sisa = Auth::user()->sisaBatasWhistleblow(); $batas = Auth::user()->peran?->batas_whistleblow; @endphp

<div class="d-md-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Laporan Whistleblow</h4>
        <p class="text-muted small mb-0">Laporkan insiden atau pelanggaran secara rahasia.</p>
    </div>
    <div class="mt-2 mt-md-0">
        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalLapor">
            <span class="material-symbols-outlined">add</span> Buat Laporan
        </button>
    </div>
</div>

@if(!is_null($batas))
<div class="alert {{ $sisa <= 1 ? 'alert-danger' : ($sisa <= 2 ? 'alert-warning' : 'alert-info') }} d-flex align-items-center gap-2 rounded-4 border-0 shadow-sm mb-4" role="alert">
    <span class="material-symbols-outlined">info</span>
    <span>Sisa kuota laporan bulan ini: <strong>{{ $sisa }} / {{ $batas }}</strong></span>
</div>
@endif

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <table id="tabelWhistleblow" class="table table-hover align-middle mb-0 w-100">
            <thead class="table-light">
                <tr>
                    <th>Tanggal</th>
                    <th>Tipe</th>
                    <th>Terlapor</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

{{-- Modal Buat Laporan --}}
<div class="modal fade" id="modalLapor" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" action="{{ route('laporan.store') }}">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Laporan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Karyawan yang Dilaporkan</label>
                    <select name="id_penerima" class="form-select">
                        <option value="">-- Pilih (opsional) --</option>
                        @foreach(\App\Models\User::where('id', '!=', Auth::id())->get() as $u)
                            <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->departemen?->nama ?? '-' }})</option>
                        @endforeach
                    </select>
                    <div class="form-text">Kosongkan jika tidak ingin menyebut nama.</div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tipe <span class="text-danger">*</span></label>
                    <select name="tipe" class="form-select" required>
                        <option value="Kekerasan">Kekerasan</option>
                        <option value="Pelecehan">Pelecehan</option>
                        <option value="Penipuan">Penipuan</option>
                        <option value="Pelanggaran">Pelanggaran</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
                    <textarea name="deskripsi" class="form-control" rows="4" required minlength="10" placeholder="Jelaskan insiden yang terjadi..."></textarea>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="adalah_anonim" value="1" id="anonimCheck">
                    <label class="form-check-label" for="anonimCheck">
                        Laporkan secara anonim (nama saya tidak dicantumkan)
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger">Kirim Laporan</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Detail --}}
<div class="modal fade modal-laporan" id="modalDetail" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Detail Laporan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="label">Tipe</p>
                <p id="detail-tipe" class="fw-semibold"></p>
                <p class="label">Karyawan Terlapor</p>
                <p id="detail-terlapor" class="fw-semibold"></p>
                <p class="label">Status</p>
                <p id="detail-status"></p>
                <p class="label">Anonim</p>
                <p id="detail-anonim" class="fw-semibold"></p>
                <p class="label">Deskripsi</p>
                <p id="detail-deskripsi" class="text-muted"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function () {
    const table = $('#tabelWhistleblow').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("whistleblow.data") }}',
        language: {
            url: 'https://cdn.datatables.net/plug-ins/2.2.2/i18n/id.json',
            paginate: { first: '«', previous: '‹', next: '›', last: '»' },
        },
        order: [[0, 'desc']],
        columns: [
            { data: 'created_at', name: 'created_at' },
            { data: 'tipe', name: 'tipe' },
            { data: 'terlapor', name: 'id_penerima', searchable: true },
            { data: 'deskripsi_singkat', name: 'deskripsi', orderable: false },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
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

    initSearchMinChars(table, '#tabelWhistleblow');

    $(document).on('click', '.detail-whistleblow', function () {
        const id = $(this).data('id');
        $.get('/whistleblow/detail/' + id, function (res) {
            $('#detail-tipe').text(res.tipe);
            $('#detail-terlapor').text(res.terlapor || '(tidak disebut)');
            $('#detail-anonim').text(res.adalah_anonim ? 'Ya' : 'Tidak');
            $('#detail-status').html('<span class="badge ' + res.status_badge + '">' + res.status + '</span>');
            $('#detail-deskripsi').text(res.deskripsi);
            new bootstrap.Modal('#modalDetail').show();
        });
    });
});
</script>
@endpush
