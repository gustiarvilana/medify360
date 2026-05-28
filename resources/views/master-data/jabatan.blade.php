@extends('layouts.app')

@section('title', 'Master Jabatan - ' . config('app.name'))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Master Jabatan</h4>
        <p class="text-muted small mb-0">Kelola jabatan/peran pengguna dan batas whistleblow.</p>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalJabatan">
        <span class="material-symbols-outlined">add</span> Jabatan Baru
    </button>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nama Jabatan</th>
                        <th style="width:160px">Batas Whistleblow</th>
                        <th style="width:80px">User</th>
                        <th style="width:120px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jabatan as $j)
                    <tr>
                        <td class="fw-bold">{{ $j->nama }}</td>
                        <td>
                            @if(is_null($j->batas_whistleblow))
                                <span class="badge bg-info">∞ Tanpa batas</span>
                            @else
                                <span class="badge bg-secondary">{{ $j->batas_whistleblow }}x/bulan</span>
                            @endif
                        </td>
                        <td><span class="badge bg-primary">{{ $j->users_count }}</span></td>
                        <td>
                            <button class="btn btn-sm btn-warning edit-jabatan"
                                data-id="{{ $j->id }}"
                                data-nama="{{ $j->nama }}"
                                data-batas="{{ $j->batas_whistleblow }}">
                                <span class="material-symbols-outlined">edit</span>
                            </button>
                            <button class="btn btn-sm btn-danger hapus-jabatan" data-id="{{ $j->id }}" data-nama="{{ $j->nama }}">
                                <span class="material-symbols-outlined">delete</span>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">Belum ada jabatan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalJabatan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalJabatanTitle">Jabatan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formJabatan" method="POST" action="{{ route('master.jabatan.store') }}">
                    @csrf
                    <input type="hidden" name="_method" value="POST">
                    <input type="hidden" name="id" id="jabatanId">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Nama Jabatan</label>
                        <input type="text" name="nama" id="jabatanNama" class="form-control" placeholder="Contoh: Supervisor" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Batas Whistleblow (bulanan)</label>
                        <input type="number" name="batas_whistleblow" id="jabatanBatas" class="form-control" min="0" placeholder="Kosongkan jika tanpa batas">
                        <small class="text-muted">Biarkan kosong untuk tanpa batas (Admin).</small>
                    </div>
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary py-2 fw-bold" id="btnSimpanJabatan">Simpan</button>
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
                <h5 class="fw-bold mt-2" id="konfirmasiJudul">Hapus Jabatan</h5>
                <p class="text-muted small" id="konfirmasiPesan">Jabatan akan dihapus permanen. Lanjutkan?</p>
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
    $('#modalJabatan').on('hidden.bs.modal', function () {
        $('#formJabatan')[0].reset();
        $('#formJabatan').attr('action', '{{ route("master.jabatan.store") }}');
        $('input[name="_method"]').val('POST');
        $('#btnSimpanJabatan').text('Simpan');
        $('#modalJabatanTitle').text('Jabatan Baru');
        $('#jabatanId').val('');
    });

    $(document).on('click', '.edit-jabatan', function () {
        const id = $(this).data('id');
        $('#jabatanId').val(id);
        $('#jabatanNama').val($(this).data('nama'));
        const batas = $(this).data('batas');
        $('#jabatanBatas').val(batas !== null && batas !== undefined ? batas : '');
        $('#formJabatan').attr('action', '{{ url("admin/master/jabatan") }}/' + id);
        $('input[name="_method"]').val('PUT');
        $('#btnSimpanJabatan').text('Perbarui');
        $('#modalJabatanTitle').text('Edit Jabatan');
        $('#modalJabatan').modal('show');
    });

    let hapusId = null;
    let hapusNama = '';

    $(document).on('click', '.hapus-jabatan', function () {
        hapusId = $(this).data('id');
        hapusNama = $(this).data('nama');
        $('#konfirmasiJudul').text('Hapus ' + hapusNama);
        $('#konfirmasiPesan').text('Jabatan "' + hapusNama + '" akan dihapus permanen. Lanjutkan?');
        $('#modalKonfirmasi').modal('show');
    });

    $('#konfirmasiBtn').on('click', function () {
        if (hapusId) {
            $.ajax({
                url: '{{ url("admin/master/jabatan") }}/' + hapusId,
                method: 'POST',
                data: { _method: 'DELETE', _token: '{{ csrf_token() }}' },
                success: function (res) {
                    $('#modalKonfirmasi').modal('hide');
                    location.reload();
                },
                error: function (xhr) {
                    $('#modalKonfirmasi').modal('hide');
                    alert(xhr.responseJSON?.message || 'Gagal menghapus jabatan.');
                }
            });
        }
    });
});
</script>
@endpush
