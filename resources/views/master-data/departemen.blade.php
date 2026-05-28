@extends('layouts.app')

@section('title', 'Master Departemen - ' . config('app.name'))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Master Departemen</h4>
        <p class="text-muted small mb-0">Kelola departemen/divisi perusahaan.</p>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalDepartemen">
        <span class="material-symbols-outlined">add</span> Departemen Baru
    </button>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nama Departemen</th>
                        <th style="width:100px">Jumlah User</th>
                        <th style="width:120px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($departemen as $d)
                    <tr>
                        <td class="fw-bold">{{ $d->nama }}</td>
                        <td><span class="badge bg-primary">{{ $d->users_count }}</span></td>
                        <td>
                            <button class="btn btn-sm btn-warning edit-departemen"
                                data-id="{{ $d->id }}"
                                data-nama="{{ $d->nama }}">
                                <span class="material-symbols-outlined">edit</span>
                            </button>
                            <button class="btn btn-sm btn-danger hapus-departemen" data-id="{{ $d->id }}" data-nama="{{ $d->nama }}">
                                <span class="material-symbols-outlined">delete</span>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted py-4">Belum ada departemen.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDepartemen" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalDepartemenTitle">Departemen Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formDepartemen" method="POST" action="{{ route('master.departemen.store') }}">
                    @csrf
                    <input type="hidden" name="_method" value="POST">
                    <input type="hidden" name="id" id="departemenId">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Nama Departemen</label>
                        <input type="text" name="nama" id="departemenNama" class="form-control" placeholder="Contoh: Teknologi Informasi" required>
                    </div>
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary py-2 fw-bold" id="btnSimpanDepartemen">Simpan</button>
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
                <h5 class="fw-bold mt-2" id="konfirmasiJudul">Hapus Departemen</h5>
                <p class="text-muted small" id="konfirmasiPesan">Departemen akan dihapus permanen. Lanjutkan?</p>
                <div class="d-flex gap-2 justify-content-center mt-3">
                    <button class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-danger px-4" id="konfirmasiBtn">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    $('#modalDepartemen').on('hidden.bs.modal', function () {
        $('#formDepartemen')[0].reset();
        $('#formDepartemen').attr('action', '{{ route("master.departemen.store") }}');
        $('input[name="_method"]').val('POST');
        $('#btnSimpanDepartemen').text('Simpan');
        $('#modalDepartemenTitle').text('Departemen Baru');
        $('#departemenId').val('');
    });

    $(document).on('click', '.edit-departemen', function () {
        const id = $(this).data('id');
        $('#departemenId').val(id);
        $('#departemenNama').val($(this).data('nama'));
        $('#formDepartemen').attr('action', '{{ url("admin/master/departemen") }}/' + id);
        $('input[name="_method"]').val('PUT');
        $('#btnSimpanDepartemen').text('Perbarui');
        $('#modalDepartemenTitle').text('Edit Departemen');
        $('#modalDepartemen').modal('show');
    });

    let hapusId = null;
    let hapusNama = '';

    $(document).on('click', '.hapus-departemen', function () {
        hapusId = $(this).data('id');
        hapusNama = $(this).data('nama');
        $('#konfirmasiJudul').text('Hapus ' + hapusNama);
        $('#konfirmasiPesan').text('Departemen "' + hapusNama + '" akan dihapus permanen. Lanjutkan?');
        $('#modalKonfirmasi').modal('show');
    });

    $('#konfirmasiBtn').on('click', function () {
        if (hapusId) {
            $.ajax({
                url: '{{ url("admin/master/departemen") }}/' + hapusId,
                method: 'POST',
                data: { _method: 'DELETE', _token: '{{ csrf_token() }}' },
                success: function () {
                    $('#modalKonfirmasi').modal('hide');
                    location.reload();
                },
                error: function (xhr) {
                    $('#modalKonfirmasi').modal('hide');
                    alert(xhr.responseJSON?.message || 'Gagal menghapus departemen.');
                }
            });
        }
    });
});
</script>
@endpush
