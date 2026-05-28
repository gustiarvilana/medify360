/**
 * Stitch 360 Component Data & Loader
 * Versi Offline: Menggunakan variabel string agar bisa jalan tanpa Live Server.
 */

const NAVBAR_HTML = `
<div class="container-fluid">
    <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand fw-bold ms-2" href="index.html">Stitch 360</a>
    
    <div class="collapse navbar-collapse d-none d-lg-block">
        <div class="position-relative ms-auto me-3">
            <input class="form-control" type="search" id="search-input" placeholder="Cari karyawan..." aria-label="Search" autocomplete="off">
            <div id="search-results" class="dropdown-menu w-100 shadow mt-1 p-0"></div>
        </div>
    </div>
    
    <div class="dropdown me-2">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown">
            <img src="https://ui-avatars.com/api/?name=Budi+Santoso&background=random" width="32" height="32" class="rounded-circle me-2">
            <span class="d-none d-sm-inline">Budi Santoso</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark shadow">
            <li><a class="dropdown-item" href="pengaturan.html">Profil</a></li>
            <li><a class="dropdown-item" href="pengaturan.html">Pengaturan</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="login.html">Keluar</a></li>
        </ul>
    </div>
</div>
<style>
    #search-results { display: none; }
    #search-results.show { display: block; }
</style>
`;

const SIDEBAR_HTML = `
<div class="p-3">
    <div class="mb-4">
        <small class="text-uppercase fw-bold text-muted small-ls">Utama</small>
        <nav class="nav flex-column mt-2">
            <a class="nav-link" data-page="index" href="index.html">
                <span class="material-symbols-outlined">dashboard</span> Beranda
            </a>
        </nav>
    </div>

    <div class="mb-4">
        <small class="text-uppercase fw-bold text-muted small-ls">Aktivitas & Budaya</small>
        <nav class="nav flex-column mt-2">
            <a class="nav-link" data-page="riwayat" href="riwayat.html">
                <span class="material-symbols-outlined">history</span> Riwayat Budaya
            </a>
            <a class="nav-link" data-page="leaderboard" href="leaderboard.html">
                <span class="material-symbols-outlined">leaderboard</span> Leaderboard
            </a>
            <a class="nav-link" data-page="analisis-performa" href="analisis-performa.html">
                <span class="material-symbols-outlined">analytics</span> Analisis Performa
            </a>
        </nav>
    </div>

    <div class="mb-4">
        <small class="text-uppercase fw-bold text-muted small-ls">Laporan</small>
        <nav class="nav flex-column mt-2">
            <a class="nav-link" data-page="laporan" href="laporan.html">
                <span class="material-symbols-outlined">report</span> Laporan Saya
            </a>
        </nav>
    </div>

    <div class="mb-4">
        <small class="text-uppercase fw-bold text-muted small-ls">Administrasi</small>
        <nav class="nav flex-column mt-2">
            <a class="nav-link" data-page="manajemen-user" href="manajemen-user.html">
                <span class="material-symbols-outlined">group</span> Manajemen User
            </a>
        </nav>
    </div>

    <div class="mb-4">
        <small class="text-uppercase fw-bold text-muted small-ls">Sistem</small>
        <nav class="nav flex-column mt-2">
            <a class="nav-link" data-page="pengaturan" href="pengaturan.html">
                <span class="material-symbols-outlined">settings</span> Pengaturan
            </a>
            <a class="nav-link text-danger" href="login.html">
                <span class="material-symbols-outlined">logout</span> Keluar
            </a>
        </nav>
    </div>
</div>

<style>
    .small-ls { letter-spacing: 0.8px; font-size: 0.65rem; color: #adb5bd; }
    .nav-link { 
        color: #555; 
        display: flex; 
        align-items: center; 
        gap: 12px; 
        padding: 10px 15px;
        border-radius: 10px;
        margin-bottom: 4px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
    }
    .nav-link:hover { 
        background-color: #f8f9fa; 
        color: #0d6efd;
        transform: translateX(5px);
    }
    .nav-link.active { 
        background-color: #0d6efd; 
        color: #ffffff; 
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.2);
    }
    .nav-link span { font-size: 20px; }
    .nav-link.active span { color: #ffffff; }
    
    /* Logout hover specific */
    .nav-link.text-danger:hover {
        background-color: #fff5f5;
        color: #dc3545 !important;
    }
</style>
`;

document.addEventListener('DOMContentLoaded', function() {
    // 1. Injeksi Navbar
    const navbarPlaceholder = document.getElementById('navbar-placeholder');
    if (navbarPlaceholder) navbarPlaceholder.innerHTML = NAVBAR_HTML;

    // 2. Injeksi Sidebar (Desktop & Mobile)
    const sidebarPlaceholder = document.getElementById('sidebar-placeholder');
    const mobileSidebarPlaceholder = document.getElementById('mobile-sidebar-placeholder');
    
    if (sidebarPlaceholder) sidebarPlaceholder.innerHTML = SIDEBAR_HTML;
    if (mobileSidebarPlaceholder) mobileSidebarPlaceholder.innerHTML = SIDEBAR_HTML;

    // 3. Tandai menu aktif
    let path = window.location.pathname;
    let page = path.split("/").pop().split(".")[0];
    if (page === "" || page === "index") page = "index";

    document.querySelectorAll(`.nav-link[data-page="${page}"]`).forEach(link => {
        link.classList.add('active');
    });

    // 4. Simulasi Pencarian
    const employees = [
        { name: "Ani Wijaya", dept: "TI", avatar: "Ani+Wijaya" },
        { name: "Rian Putra", dept: "Marketing", avatar: "Rian+Putra" },
        { name: "Siska Putri", dept: "Produk", avatar: "Siska+Putri" },
        { name: "Dedi Kusnandar", dept: "IT", avatar: "Dedi+Kusnandar" }
    ];

    const searchInput = document.getElementById('search-input');
    const searchResults = document.getElementById('search-results');

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            if (query.length < 2) {
                searchResults.classList.remove('show');
                return;
            }

            const filtered = employees.filter(e => e.name.toLowerCase().includes(query) || e.dept.toLowerCase().includes(query));
            
            if (filtered.length > 0) {
                searchResults.innerHTML = filtered.map(e => `
                    <div class="dropdown-item d-flex align-items-center p-2">
                        <img src="https://ui-avatars.com/api/?name=${e.avatar}" class="rounded-circle me-2" width="30">
                        <div>
                            <div class="fw-bold small">${e.name}</div>
                            <small class="text-muted" style="font-size:0.7rem">${e.dept}</small>
                        </div>
                    </div>
                `).join('');
                searchResults.classList.add('show');
            } else {
                searchResults.innerHTML = '<div class="p-2 text-muted small">Karyawan tidak ditemukan</div>';
                searchResults.classList.add('show');
            }
        });
        
        document.addEventListener('click', (e) => {
            if (searchInput && !searchInput.contains(e.target)) searchResults.classList.remove('show');
        });
    }
});
