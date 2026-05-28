
# 🧵 Stitch 360 — Platform Budaya Perusahaan

> **CendolBata** — Apresiasi, Transparansi, Integritas.

Stitch 360 adalah platform manajemen budaya perusahaan berbasis web yang memungkinkan karyawan saling memberi apresiasi (**Cendol**), melaporkan insiden (**Bata**/Whistleblow), dan melakukan **Penilaian 360°** secara berkala.

Dibangun dengan **Laravel 13**, **Bootstrap 5.3**, **Yajra DataTables**, dan **DomPDF**.

---

## ✨ Fitur Utama

### 🟢 Cendol (Apresiasi)
- Kirim apresiasi ke rekan kerja (Kolaborasi, Integritas, Inovasi)
- Riwayat Cendol diterima & dikirim
- Leaderboard peringkat apresiasi
- Notifikasi real-time via bell icon + sound

### 🔴 Bata (Whistleblow)
- Laporkan insiden / pelanggaran (Kekerasan, Pelecehan, Penipuan, dll.)
- Pilih karyawan yang dilaporkan (opsional)
- Laporkan secara anonim
- Batas kuota per bulan sesuai peran (Karyawan=5, Manajer=10, Admin=∞)
- Admin meninjau & mengubah status (Menunggu → Ditinjau → Selesai/Ditolak)
- Notifikasi status berubah

### 🎯 Penilaian 360°
- **Dimensi Penilaian:** Kepemimpinan, Kerjasama, Komunikasi, Inisiatif, Kualitas Kerja
- **Bobot Relasi:** Setiap pasangan peran (penilai → dinilai) punya bobot berbeda
- **Target Otomatis:** Target penilaian dibuat otomatis berdasarkan aturan peran
- **Star Rating:** Input skor 1–5 per dimensi dengan label (Sangat Kurang – Sangat Baik)
- **Skor Akhir:** Rata-rata dimensi × bobot relasi
- **Dashboard 360:** Statistik per departemen, progress bar
- **Laporan:** Semua penilaian / per individu + **Download PDF** dengan rincian dimensi, bobot, dan perhitungan skor

### 👥 Manajemen User (Admin)
- CRUD karyawan dengan username, foto profil, departemen, peran
- DataTables server-side dengan search, sort, pagination

### 📊 Dashboard
- Statistik: Cendol diterima/dikirim, Bata, Skor Budaya
- Progress Penilaian 360 (widget)
- Notifikasi bell icon dengan polling 15 detik

### 🔧 Pengaturan
- Edit profil (nama, username, email)
- Upload foto profil (crop preview)
- Ganti password (toggle visibility)
- Toggle notifikasi Cendol / Bata

---

## 🏗️ Arsitektur

### Pola Desain: Repository Pattern

```
Interface (Contract)          → App\Repositories\Contracts\
Eloquent Implementation       → App\Repositories\Eloquent\
Binding                       → App\Providers\AppServiceProvider
```

### Struktur Direktori

```
├── .agents/                  # Dokumentasi pengembangan (PRD, design, tasklist)
├── app/
│   ├── Http/Controllers/     # 12 Controllers
│   ├── Models/               # 13 Eloquent Models
│   ├── Notifications/        # CendolReceived, BataStatusUpdated
│   ├── Repositories/
│   │   ├── Contracts/        # Interface repository
│   │   └── Eloquent/         # Implementasi Eloquent
│   └── Providers/
├── database/
│   ├── factories/
│   ├── migrations/           # 19 migration files
│   └── seeders/              # DepartemenSeeder, PeranSeeder, Penilaian360Seeder, DataPenilaianSeeder
├── mockup/                   # Prototipe desain HTML/CSS/JS
├── resources/
│   ├── css/                  # app.css (Bootstrap import + kustom)
│   ├── js/                   # app.js (Bootstrap + Vite ESM)
│   └── views/                # Blade templates
│       ├── layouts/          # app.blade.php, sidebar.blade.php
│       ├── auth/             # Login, Register
│       ├── penilaian-360/    # 10 view files
│       ├── master-data/      # Jabatan, Departemen
│       └── *.blade.php       # Dashboard, Laporan, dll.
├── routes/
│   └── web.php               # Semua route (auth + verified)
├── storage/
│   ├── app/data/             # Data JSON (prototyping)
│   └── app/public/foto-profil/
└── tests/                    # PHPUnit (Unit + Feature)
```

### Controllers

| Controller | Route Prefix | Fungsi |
|---|---|---|
| `DashboardController` | `/dashboard` | Statistik utama + widget 360 |
| `CendolController` | `/cendol/kirim` | Kirim apresiasi |
| `LaporanController` | `/laporan` | CRUD laporan insiden (Bata) |
| `Laporan360Controller` | `/laporan-360` | Laporan penilaian 360 + PDF |
| `Penilaian360Controller` | `/penilaian-360` | CRUD penilaian 360, target, bobot, dimensi |
| `Dashboard360Controller` | `/dashboard-360` | Statistik penilaian per departemen |
| `WhistleblowController` | `/whistleblow` | Halaman whistleblow dedicated |
| `AdminController` | `/admin` | Manajemen user, kelola laporan |
| `MasterDataController` | `/admin/master` | CRUD jabatan & departemen |
| `PengaturanController` | `/pengaturan` | Profil, foto, password, notifikasi |
| `NotifikasiController` | `/notifikasi` | Bell icon, mark read, preferensi |
| `RiwayatController` | `/riwayat` | Riwayat Cendol + Bata |
| `LeaderboardController` | `/leaderboard` | Peringkat apresiasi |

### Eloquent Models

| Model | Table | Relasi Utama |
|---|---|---|
| `User` | `users` | `departemen`, `peran`, `penilaianDiterima`, `cendolDiterima`, `laporanInsiden` |
| `Departemen` | `departemen` | `users` |
| `Peran` | `peran` | `users`, `batas_whistleblow` |
| `TransaksiCendol` | `transaksi_cendol` | `pengirim`, `penerima` |
| `LaporanInsiden` | `laporan_insiden` | `pelapor`, `penerima` |
| `Penilaian360` | `penilaian_360` | `penilai`, `dinilai`, `skor` |
| `SkorPenilaian` | `skor_penilaian` | `penilaian`, `dimensi` |
| `TargetPenilaian` | `target_penilaian` | `penilai`, `dinilai` |
| `BobotRelasi` | `bobot_relasi` | `peranPenilai`, `peranDinilai` |
| `DimensiPenilaian` | `dimensi_penilaian` | `skorPenilaian` |

---

## 💻 Tech Stack

| Teknologi | Versi |
|---|---|
| **PHP** | ^8.3 |
| **Laravel** | ^13.8 |
| **Bootstrap** | 5.3 (npm import) |
| **Yajra DataTables** | ^13.1 (server-side) |
| **DomPDF** | ^3.1 (barryvdh/laravel-dompdf) |
| **Select2** | CDN (global, auto-init on `.form-select`) |
| **Chart.js** | CDN (dashboard) |
| **MySQL** | Production database |
| **Vite** | Asset bundler |
| **Laravel Breeze** | Blade stack auth |
| **PHPUnit** | Testing |

---

## ⚙️ Setup & Instalasi

### Prasyarat
- PHP ^8.3
- Composer
- Node.js & npm
- MySQL

### Instalasi Cepat

```bash
composer setup
```

Atau manual:

```bash
cp .env.example .env
# Edit .env — atur database MySQL
php artisan key:generate
php artisan migrate --seed
npm install && npm run build
```

### Environment Variables (.env)

```env
APP_NAME=Stitch 360
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

### Test Database (.env.testing)

```env
DB_CONNECTION=mysql
DB_DATABASE=laravel_testing
```

---

## 🚀 Development

### Menjalankan Server

```bash
composer dev
```

Menjalankan 4 proses concurrently:
- `php artisan serve` (http://localhost:8000)
- `php artisan queue:listen` (notifikasi queue)
- `php artisan pail` (log viewer)
- `npm run dev` (Vite HMR)

### Build Asset

```bash
npm run build
```

### Menjalankan Tests

```bash
composer test
# atau
php artisan test --filter=NamaTest
```

---

## 🎨 Sistem Desain

### Warna Semantik

| Warna | Makna | Bootstrap |
|---|---|---|
| Hijau `#198754` | **Cendol** — Apresiasi, sukses | `.btn-success` |
| Merah `#dc3545` | **Bata** — Insiden, danger | `.btn-danger` |
| Biru `#0d6efd` | Primary / aksi utama | `.btn-primary` |
| Abu `#f0f2f5` | Background halaman | — |

### Komponen Kustom

- **`.stat-card`** — Kartu statistik dengan shadow + hover lift
- **`.feed-card`** — Kartu daftar aktivitas
- **`.btn-action`** — Tombol aksi dengan transisi scale
- **`.icon-box`** — Wrapper ikon 48×48px

---

## 🗄️ Database

### ER Diagram (Ringkas)

```
departemen ──< users >── peran
                │
      ┌─────────┼─────────┐
      │         │         │
  transaksi_  laporan_  penilaian_360
  cendol      insiden      │
                           └── skor_penilaian >── dimensi_penilaian
                      
target_penilaian
bobot_relasi >── peran (penilai & dinilai)
```

### Aturan Target Penilaian

| Peran Penilai | Bisa Menilai |
|---|---|
| Admin (id=3) | Semua user di departemen yang sama |
| Manajer (id=2) | Karyawan (id=1) di departemen yang sama |
| Karyawan (id=1) | Karyawan lain (id=1) di departemen yang sama |

---

## 📊 Seeder Data

```bash
php artisan migrate:fresh --seed
```

Membuat:
- **5 Departemen:** TI, SDM, Keuangan, Operasional, Pemasaran
- **3 Peran:** Karyawan (batas=5), Manajer (batas=10), Admin (batas=∞)
- **21 User** — Admin + Manajer + 3 Karyawan per departemen
- **5 Dimensi Penilaian** — Kepemimpinan, Kerjasama, Komunikasi, Inisiatif, Kualitas Kerja
- **9 Bobot Relasi** — Semua kombinasi peran
- **25 Penilaian 360** — Realistis, tersebar di semua departemen
- **25 Cendol** + **10 Laporan Insiden**

### Akun Default (`password` untuk semua)

| Email | Nama | Peran | Departemen |
|---|---|---|---|
| admin@stitch360.com | Admin TI | Admin | TI |
| budi@stitch360.com | Budi Santoso | Manajer | TI |
| citra@stitch360.com | Citra Dewi | Karyawan | TI |
| dimas@stitch360.com | Dimas Ardiansyah | Karyawan | TI |
| bambang@stitch360.com | Bambang Sutejo | Manajer | SDM |
| dedi@stitch360.com | Dedi Kusnandar | Karyawan | SDM |
| hendra@stitch360.com | Hendra Gunawan | Manajer | Keuangan |
| putri@stitch360.com | Putri Wulandari | Manajer | Pemasaran |
| (dan 12 user lainnya) | | | |

---

## 📄 Lisensi

MIT License — lihat file `LICENSE` untuk detail.
