@extends('layouts.app')

@section('title', 'Manajemen User - ' . config('app.name'))

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
    <h2 class="fw-bold mb-0">👥 Manajemen User</h2>
    <button class="btn btn-primary btn-action" data-bs-toggle="modal" data-bs-target="#userModal">
        <span class="material-symbols-outlined">add</span> Tambah Karyawan
    </button>
</div>

<div class="row g-3 mb-4">
    <div class="col-sm-4">
        <div class="card border-0 shadow-sm rounded-4 p-3">
            <h6 class="text-muted small">Total User</h6>
            <h3 class="fw-bold">{{ $usersTotal }}</h3>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card border-0 shadow-sm rounded-4 p-3">
            <h6 class="text-muted small">Admin</h6>
            <h3 class="fw-bold text-primary">{{ $adminCount }}</h3>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card border-0 shadow-sm rounded-4 p-3">
            <h6 class="text-muted small">Manajer</h6>
            <h3 class="fw-bold text-info">{{ $manajerCount }}</h3>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <table id="users-table" class="table table-hover align-middle mb-0 w-100">
            <thead class="table-light">
                <tr>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Departemen</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<div class="modal fade" id="userModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="userModalLabel">Tambah Karyawan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form method="POST" action="{{ route('manajemen-user.store') }}" id="userForm">
                    @csrf
                    <input type="hidden" name="user_id" id="user_id">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Nama Lengkap</label>
                            <input type="text" name="name" id="field_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Username</label>
                            <input type="text" name="username" id="field_username" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Email</label>
                            <input type="email" name="email" id="field_email" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Jabatan</label>
                            <select name="id_peran" id="field_peran" class="form-select">
                                <option value="">Pilih jabatan...</option>
                                @foreach($peran as $p)
                                <option value="{{ $p->id }}">{{ $p->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Departemen</label>
                            <select name="id_departemen" id="field_departemen" class="form-select">
                                <option value="">Pilih departemen...</option>
                                @foreach($departemen as $d)
                                <option value="{{ $d->id }}">{{ $d->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6" id="passwordField">
                            <label class="form-label fw-bold small">Password</label>
                            <input type="password" name="password" class="form-control" minlength="8">
                            <small class="text-muted">Min. 8 karakter</small>
                        </div>
                    </div>
                    <div class="d-grid mt-4">
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

    const usersTable = $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("manajemen-user.data") }}',
        language: {
            url: 'https://cdn.datatables.net/plug-ins/2.2.2/i18n/id.json',
            paginate: {
                first: '«',
                previous: '‹',
                next: '›',
                last: '»',
            },
        },
        columns: [
            { data: 'name', name: 'name' },
            { data: 'id_peran', name: 'id_peran', orderable: false },
            { data: 'id_departemen', name: 'id_departemen', orderable: false },
            { data: 'status', name: 'status', orderable: false },
            { data: 'action', name: 'action', orderable: false, width: '150px' },
        ],
    });

    initSearchMinChars(usersTable, '#users-table');

    $(document).on('click', '.edit-user', function() {
        const modal = new bootstrap.Modal(document.getElementById('userModal'));
        document.getElementById('userModalLabel').textContent = 'Edit Akun Saya';
        document.getElementById('user_id').value = this.dataset.id;
        document.getElementById('field_name').value = this.dataset.name;
        document.getElementById('field_username').value = this.dataset.username;
        document.getElementById('field_email').value = this.dataset.email;
        document.getElementById('field_peran').value = this.dataset.peran || '';
        document.getElementById('field_departemen').value = this.dataset.departemen || '';
        document.getElementById('passwordField').style.display = 'none';
        document.getElementById('userForm').action = '/admin/user/' + this.dataset.id;
        const methodInput = document.querySelector('#userForm input[name="_method"]');
        if (!methodInput) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = '_method';
            input.value = 'PUT';
            document.getElementById('userForm').appendChild(input);
        } else {
            methodInput.value = 'PUT';
        }
        modal.show();
    });

    document.querySelector('[data-bs-target="#userModal"]')?.addEventListener('click', function() {
        if (!this.classList.contains('edit-user')) {
            document.getElementById('userModalLabel').textContent = 'Tambah Karyawan';
            document.getElementById('userForm').reset();
            document.getElementById('user_id').value = '';
            document.getElementById('passwordField').style.display = 'block';
            document.getElementById('userForm').action = '{{ route("manajemen-user.store") }}';
            const methodInput = document.querySelector('#userForm input[name="_method"]');
            if (methodInput) methodInput.remove();
        }
    });
});
</script>
@endpush
