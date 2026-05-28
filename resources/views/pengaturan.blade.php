@extends('layouts.app')

@section('title', 'Pengaturan - ' . config('app.name'))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">⚙️ Pengaturan Akun</h2>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <ul class="nav nav-pills mb-4 gap-2" id="settingsTab" role="tablist">
            <li class="nav-item"><button class="nav-link active rounded-pill px-4" id="profil-tab" data-bs-toggle="tab" data-bs-target="#profil" type="button">Profil</button></li>
            <li class="nav-item"><button class="nav-link rounded-pill px-4" id="notifikasi-tab" data-bs-toggle="tab" data-bs-target="#notifikasi" type="button">Notifikasi</button></li>
            <li class="nav-item"><button class="nav-link rounded-pill px-4" id="keamanan-tab" data-bs-toggle="tab" data-bs-target="#keamanan" type="button">Privasi & Keamanan</button></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="profil">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h5 class="fw-bold mb-4">Informasi Profil</h5>
                    <form method="POST" action="{{ route('pengaturan.update-profile') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Username</label>
                            <input type="text" name="username" class="form-control" value="{{ Auth::user()->username }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Departemen</label>
                            <input type="text" class="form-control" value="{{ Auth::user()->departemen->nama ?? '-' }}" readonly>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary py-2 fw-bold">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="tab-pane fade" id="notifikasi">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h5 class="fw-bold mb-4">Preferensi Notifikasi</h5>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="notifCendol" {{ Auth::user()->notif_cendol ? 'checked' : '' }}>
                        <label class="form-check-label" for="notifCendol">Notifikasi Cendol diterima</label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="notifBata" {{ Auth::user()->notif_bata ? 'checked' : '' }}>
                        <label class="form-check-label" for="notifBata">Notifikasi update laporan Bata</label>
                    </div>
                    <hr>
                    <div class="small text-muted">Perubahan tersimpan otomatis.</div>
                </div>
            </div>

            <div class="tab-pane fade" id="keamanan">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h5 class="fw-bold mb-4">Ubah Kata Sandi</h5>
                    <form method="POST" action="{{ route('pengaturan.update-password') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Kata Sandi Saat Ini</label>
                            <div class="position-relative">
                                <input type="password" name="current_password" class="form-control pe-5" id="pwCurrent" required>
                                <span class="position-absolute end-0 top-0 h-100 d-flex align-items-center pe-3 toggle-pw" role="button" data-target="pwCurrent" style="cursor: pointer;">
                                    <span class="material-symbols-outlined text-muted">visibility_off</span>
                                </span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Kata Sandi Baru</label>
                            <div class="position-relative">
                                <input type="password" name="password" class="form-control pe-5" id="pwNew" required minlength="8">
                                <span class="position-absolute end-0 top-0 h-100 d-flex align-items-center pe-3 toggle-pw" role="button" data-target="pwNew" style="cursor: pointer;">
                                    <span class="material-symbols-outlined text-muted">visibility_off</span>
                                </span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Konfirmasi Kata Sandi Baru</label>
                            <div class="position-relative">
                                <input type="password" name="password_confirmation" class="form-control pe-5" id="pwConfirm" required minlength="8">
                                <span class="position-absolute end-0 top-0 h-100 d-flex align-items-center pe-3 toggle-pw" role="button" data-target="pwConfirm" style="cursor: pointer;">
                                    <span class="material-symbols-outlined text-muted">visibility_off</span>
                                </span>
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary py-2 fw-bold">Ubah Kata Sandi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 text-center">
            <div class="position-relative d-inline-block mx-auto">
                <img src="{{ Auth::user()->foto ? asset('storage/' . Auth::user()->foto) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=random&size=96' }}" class="rounded-circle mx-auto mb-3" width="96" height="96" style="object-fit: cover;" id="profileFoto">
                <label for="fotoUpload" class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; cursor: pointer;">
                    <span class="material-symbols-outlined" style="font-size: 16px;">camera_alt</span>
                </label>
            </div>
            <form id="fotoForm" method="POST" action="{{ route('pengaturan.update-foto') }}" enctype="multipart/form-data">
                @csrf
                <input type="file" name="foto" id="fotoUpload" accept="image/*" class="d-none" onchange="document.getElementById('fotoForm').submit();">
            </form>
            <h5 class="fw-bold">{{ Auth::user()->name }}</h5>
            <p class="text-muted mb-0 small">{{ '@' . Auth::user()->username }}</p>
            <p class="text-muted small">{{ Auth::user()->email }}</p>
            <p class="text-muted small">{{ Auth::user()->departemen->nama ?? '-' }}</p>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#notifCendol, #notifBata').on('change', function() {
        $.post('{{ route("notifikasi.preferensi") }}', {
            _token: '{{ csrf_token() }}',
            notif_cendol: $('#notifCendol').is(':checked') ? 1 : 0,
            notif_bata: $('#notifBata').is(':checked') ? 1 : 0,
        });
    });

    $(document).on('click', '.toggle-pw', function() {
        var input = $('#' + $(this).data('target'));
        var icon = $(this).find('.material-symbols-outlined');
        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            icon.text('visibility');
        } else {
            input.attr('type', 'password');
            icon.text('visibility_off');
        }
    });
});
</script>
@endpush
