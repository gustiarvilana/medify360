<div class="p-3">
    <nav class="nav flex-column mb-4">
        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
            <span class="material-symbols-outlined">dashboard</span> Beranda
        </a>
    </nav>

    <div class="mb-4">
        <small class="text-uppercase fw-bold text-muted small-ls">Aktivitas</small>
        <nav class="nav flex-column mt-2">
            <a class="nav-link {{ request()->routeIs('riwayat') ? 'active' : '' }}" href="{{ route('riwayat') }}">
                <span class="material-symbols-outlined">history</span> Riwayat
            </a>
            <a class="nav-link {{ request()->routeIs('leaderboard') ? 'active' : '' }}" href="{{ route('leaderboard') }}">
                <span class="material-symbols-outlined">leaderboard</span> Peringkat Apresiasi
            </a>
        </nav>
    </div>

    <div class="mb-4">
        <small class="text-uppercase fw-bold text-muted small-ls">Pelaporan</small>
        <nav class="nav flex-column mt-2">
            <a class="nav-link {{ request()->routeIs('whistleblow.*') ? 'active' : '' }}" href="{{ route('whistleblow.index') }}">
                <span class="material-symbols-outlined">flag</span> Laporan Whistleblow
            </a>
            <a class="nav-link {{ request()->routeIs('laporan') ? 'active' : '' }}" href="{{ route('laporan') }}">
                <span class="material-symbols-outlined">description</span> Laporan & Apresiasi
            </a>
        </nav>
    </div>

    <div class="mb-4">
        <small class="text-uppercase fw-bold text-muted small-ls">Penilaian 360</small>
        <nav class="nav flex-column mt-2">
            <a class="nav-link {{ request()->routeIs('dashboard-360') ? 'active' : '' }}" href="{{ route('dashboard-360') }}">
                <span class="material-symbols-outlined">dashboard</span> Dashboard 360
            </a>
            <a class="nav-link {{ request()->routeIs('penilaian-360.*') ? 'active' : '' }}" href="{{ route('penilaian-360.index') }}">
                <span class="material-symbols-outlined">rate_review</span> Penilaian 360
            </a>
            <a class="nav-link {{ request()->routeIs('laporan-360.index') ? 'active' : '' }}" href="{{ route('laporan-360.index') }}">
                <span class="material-symbols-outlined">assessment</span> Laporan 360
            </a>
            <a class="nav-link {{ request()->routeIs('laporan-360.individu', 'laporan-360.detail', 'laporan-360.detail-data') ? 'active' : '' }}" href="{{ route('laporan-360.individu') }}">
                <span class="material-symbols-outlined">person_search</span> Laporan per Individu
            </a>
        </nav>
    </div>

    @if(Auth::user()->id_peran === 3)
    <div class="mb-4">
        <small class="text-uppercase fw-bold text-muted small-ls">Administrasi</small>
        <nav class="nav flex-column mt-2">
            <a class="nav-link {{ request()->routeIs('admin.laporan') ? 'active' : '' }}" href="{{ route('admin.laporan') }}">
                <span class="material-symbols-outlined">assignment</span> Kelola Laporan
            </a>
            <a class="nav-link {{ request()->routeIs('manajemen-user') ? 'active' : '' }}" href="{{ route('manajemen-user') }}">
                <span class="material-symbols-outlined">group</span> Manajemen User
            </a>
            <div class="small text-muted text-uppercase fw-bold mt-3 mb-1 px-2 small-ls">Master Data</div>
            <a class="nav-link {{ request()->routeIs('master.jabatan') ? 'active' : '' }}" href="{{ route('master.jabatan') }}">
                <span class="material-symbols-outlined">badge</span> Jabatan
            </a>
            <a class="nav-link {{ request()->routeIs('master.departemen') ? 'active' : '' }}" href="{{ route('master.departemen') }}">
                <span class="material-symbols-outlined">business</span> Departemen
            </a>
            <a class="nav-link {{ request()->routeIs('dimensi.*') ? 'active' : '' }}" href="{{ route('dimensi.index') }}">
                <span class="material-symbols-outlined">list_alt</span> Dimensi Penilaian
            </a>
            <a class="nav-link {{ request()->routeIs('bobot.*') ? 'active' : '' }}" href="{{ route('bobot.index') }}">
                <span class="material-symbols-outlined">tune</span> Bobot Penilaian
            </a>
        </nav>
    </div>
    @endif

    <div class="mb-4">
        <small class="text-uppercase fw-bold text-muted small-ls">Akun</small>
        <nav class="nav flex-column mt-2">
            <a class="nav-link {{ request()->routeIs('pengaturan') ? 'active' : '' }}" href="{{ route('pengaturan') }}">
                <span class="material-symbols-outlined">settings</span> Pengaturan
            </a>
            <a class="nav-link text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <span class="material-symbols-outlined">logout</span> Keluar
            </a>
            <form id="logout-form" method="POST" action="{{ route('logout') }}" class="d-none">@csrf</form>
        </nav>
    </div>
</div>
