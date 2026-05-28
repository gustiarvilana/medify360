@extends('layouts.app')

@section('title', 'Dimensi Penilaian - ' . config('app.name'))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Dimensi Penilaian</h4>
        <p class="text-muted small mb-0">Atur dimensi yang digunakan dalam penilaian 360.</p>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalDimensi">
        <span class="material-symbols-outlined">add</span> Dimensi Baru
    </button>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width:60px">Urutan</th>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th style="width:120px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dimensi as $d)
                    <tr>
                        <td><span class="badge bg-secondary">{{ $d->urutan }}</span></td>
                        <td class="fw-bold">{{ $d->nama }}</td>
                        <td class="text-muted">{{ $d->deskripsi ?? '-' }}</td>
                        <td>
                            <button class="btn btn-sm btn-warning edit-dimensi"
                                data-id="{{ $d->id }}"
                                data-nama="{{ $d->nama }}"
                                data-deskripsi="{{ $d->deskripsi }}"
                                data-urutan="{{ $d->urutan }}">
                                <span class="material-symbols-outlined">edit</span>
                            </button>
                            <button class="btn btn-sm btn-danger hapus-dimensi" data-id="{{ $d->id }}">
                                <span class="material-symbols-outlined">delete</span>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">Belum ada dimensi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDimensi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalDimensiTitle">Dimensi Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formDimensi" method="POST" action="{{ route('dimensi.store') }}">
                    @csrf
                    <input type="hidden" name="_method" value="POST">
                    <input type="hidden" name="id" id="dimensiId">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Nama Dimensi</label>
                        <input type="text" name="nama" id="dimensiNama" class="form-control" placeholder="Contoh: Kepemimpinan" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Deskripsi (opsional)</label>
                        <textarea name="deskripsi" id="dimensiDeskripsi" class="form-control" rows="2" placeholder="Penjelasan singkat..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Urutan</label>
                        <input type="number" name="urutan" id="dimensiUrutan" class="form-control" min="1" max="99" required>
                    </div>
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary py-2 fw-bold" id="btnSimpanDimensi">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalKonfirmasi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0">
            <div class="modal-body p-4 text-center">
                <span class="material-symbols-outlined text-warning fs-1">warning</span>
                <h5 class="fw-bold mt-2">Hapus Dimensi</h5>
                <p class="text-muted small">Dimensi akan dihapus permanen. Lanjutkan?</p>
                <div class="d-flex gap-2 justify-content-center mt-3">
                    <button class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-danger px-4" id="konfirmasiHapus">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    $('#modalDimensi').on('hidden.bs.modal', function () {
        $('#formDimensi')[0].reset();
        $('#formDimensi').attr('action', '{{ route("dimensi.store") }}');
        $('input[name="_method"]').val('POST');
        $('#btnSimpanDimensi').text('Simpan');
        $('#modalDimensiTitle').text('Dimensi Baru');
        $('#dimensiId').val('');
    });

    $(document).on('click', '.edit-dimensi', function () {
        const id = $(this).data('id');
        $('#dimensiId').val(id);
        $('#dimensiNama').val($(this).data('nama'));
        $('#dimensiDeskripsi').val($(this).data('deskripsi') || '');
        $('#dimensiUrutan').val($(this).data('urutan'));
        $('#formDimensi').attr('action', '{{ url("admin/dimensi") }}/' + id);
        $('input[name="_method"]').val('PUT');
        $('#btnSimpanDimensi').text('Perbarui');
        $('#modalDimensiTitle').text('Edit Dimensi');
        $('#modalDimensi').modal('show');
    });

    let hapusId = null;
    $(document).on('click', '.hapus-dimensi', function () {
        hapusId = $(this).data('id');
        $('#modalKonfirmasi').modal('show');
    });

    $('#konfirmasiHapus').on('click', function () {
        if (hapusId) {
            $.ajax({
                url: '{{ url("admin/dimensi") }}/' + hapusId,
                method: 'POST',
                data: { _method: 'DELETE', _token: '{{ csrf_token() }}' },
                success: function () {
                    $('#modalKonfirmasi').modal('hide');
                    location.reload();
                }
            });
        }
    });
});
</script>
@endpush
