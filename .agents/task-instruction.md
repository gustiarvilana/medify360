# Task Instruction: Migrasi Stitch 360 ke Laravel

Dokumen ini berisi langkah-langkah sistematis untuk mentransformasi prototipe HTML/CSS di `/mockup` menjadi aplikasi fungsional menggunakan **Laravel** (terbaru/Laravel 13*).

## 1. Analisis Prototipe (`/mockup`)
Prototipe saat ini memiliki halaman:
- `index.html` -> Dashboard Utama
- `login.html` & `register.html` -> Autentikasi
- `riwayat.html` -> Log aktivitas
- `laporan.html` -> Sistem pelaporan Bata
- `leaderboard.html` -> Papan peringkat
- `analisis-performa.html` -> Analisis 360°
- `manajemen-user.html` -> Admin CRUD

## 2. Persiapan Basis Data (Migrasi & Prototyping)
Buat migrasi menggunakan Bahasa Indonesia, namun untuk fase pengujian gunakan database berbasis JSON agar tidak mengganggu MySQL:

1. **Migrasi:** Buat migrasi untuk `users`, `departemen`, `peran`, `transaksi_cendol`, `laporan_insiden`.
2. **JSON Prototyping:** 
   - Simpan data simulasi dalam file JSON di `storage/app/data/`.
   - Gunakan *Repository Pattern* agar aplikasi dapat membaca dari JSON (prototyping) atau MySQL (produksi) dengan mudah melalui `AppServiceProvider`.
3. **Struktur Data JSON:** Sesuaikan struktur JSON dengan skema migrasi:
   - `users.json`
   - `transaksi_cendol.json`
   - `laporan_insiden.json`

## 3. Autentikasi — Laravel Breeze
Gunakan **Laravel Breeze** (Blade stack) untuk sistem login/register, bukan custom:

1. **Install:** `composer require laravel/breeze --dev && php artisan breeze:install blade`
2. **Session table:** Breeze otomatis membuat migrasi `create_sessions_table` — jalankan `php artisan migrate`
3. **Customisasi view:** Sesuaikan `resources/views/auth/` (login, register) dengan desain dari `mockup/login.html` & `mockup/register.html` — pertahankan Bootstrap 5.3 classes, routing, dan logika Breeze
4. **Hapus view welcome default** (`resources/views/welcome.blade.php`) — arahkan `/` ke dashboard
5. **Breeze menyediakan:** Controller auth (`Auth\AuthenticatedSessionController`, `Auth\RegisteredUserController`, dll.), routes (`auth.php`), dan middleware sudah terkonfigurasi

## 4. Layouting Blade
Buat struktur layout di `resources/views/layouts/app.blade.php` — **turunkun (`@extends`) dari layout Breeze** atau buat layout kustom sendiri:
- Gunakan `@yield('content')` atau `{{ $slot }}` untuk konten utama.
- Gunakan `@include('layouts.navbar')` dan `@include('layouts.sidebar')`.
- Gunakan `@push('scripts')` untuk memuat `Chart.js` atau skrip khusus halaman.

## 5. Langkah Migrasi Frontend (Blade - WAJIB MERUJUK /MOCKUP)
1. **Analisis Visual:** Sebelum membuat view Blade, buka file HTML terkait di `/mockup/`.
2. **Pindahkan Aset:** Pindahkan CSS/JS dari `mockup/` ke `resources/` (jalankan via Vite).
3. **Pemisahan Layout (Blade Components):**
   - **Main Layout:** Konversi struktur HTML dasar ke `resources/views/layouts/app.blade.php`.
   - **Komponen Navigasi:** Buat `resources/views/layouts/navbar.blade.php` dan `resources/views/layouts/sidebar.blade.php` berdasarkan konten `components/` di mockup.
4. **Konversi HTML ke Blade:**
   - Gunakan `@extends('layouts.app')` untuk setiap halaman.
   - Bungkus konten utama dengan `@section('content')`.
   - Pastikan class CSS dan struktur HTML di Blade **sama persis** dengan yang ada di `/mockup/` untuk menjaga konsistensi desain.
5. **Navigasi Dinamis:** Ganti semua tautan statis (`href="index.html"`) dengan route Laravel (`href="{{ route('dashboard') }}"`).
6. **Validasi:** Pastikan tampilan di Laravel Blade identik dengan prototipe `/mockup/` (cek padding, warna, dan animasi).

## 6. Backend Logic
- **Controller:** Buat controller untuk setiap fitur (misal: `DashboardController`, `LaporanController`, `CendolController`, `AdminController`).
  - *Auth sudah ditangani Breeze — tidak perlu AuthController manual.*
- **Route:** Definisikan rute di `routes/web.php` dengan *middleware* `auth`.
  - *Route auth sudah ditangani Breeze di `routes/auth.php`.*

---

## 7. Panduan Kerja & Aturan Wajib
1. **Selalu baca dan ikuti** file `.agents/prd.md` dan `.agents/design.md` sebelum mengerjakan fitur apapun.
2. Ikuti panduan desain di `.agents/design.md` secara ketat.
3. Pahami flow aplikasi yang akan dibuat di `mockup/dokumentasi/dokumentasi.md` secara ketat.
3. Pahami dokumentasi teknis di `mockup/dokumentasi/dokumen_teknis.md` secara ketat (kamu bisa improv / menyempurnakan saat pembangunan aplikasi kedepan).

### Aturan Update Tasklist (WAJIB!)
Setiap kali selesai mengerjakan **satu task** atau **satu grup task** di `tasklist.md`:
1. Tandai task dengan `[x]` dan emoji `✅`.
2. Tambahkan catatan singkat: file apa yang dibuat/diubah.
3. Update progress keseluruhan (contoh: `Progress: 40%`).

---

## 8. Struktur Task Checklist (Detail)

1. **Project Setup & Configuration**
   - [ ] Install Laravel, setup database, install Bootstrap/Vite.
   - [ ] Setup folder struktur sesuai dokumentasi.

2. **Laravel Breeze (Autentikasi)**
   - [ ] Install Breeze Blade stack.
   - [ ] Customisasi view auth sesuai mockup.
   - [ ] Hapus/redirect welcome default.

3. **Database & Migration**
   - [ ] Buat migrasi `users`, `departemen`, `peran`, `transaksi_cendol`, `laporan_insiden`.
   - [ ] Jalankan `php artisan migrate`.

4. **Models, Relationships & Repository**
   - [ ] Buat model dengan relasi yang sesuai (Eloquent Relationships).
   - [ ] Buat `Repository` interface dan implementasi (JSON & Eloquent).

5. **Backend Logic & API**
   - [ ] Buat Controller: Dashboard, Laporan, Cendol, Admin.
   - [ ] Injeksi Repository ke Controller (Dependency Injection).
   - [ ] Implementasi Request Validation.

6. **Security (CSRF, XSS, Validation)**
   - [ ] Middleware autentikasi.
   - [ ] Form Request Validation untuk semua input.

7. **Frontend & Blade Views (Ikuti design.md)**
   - [ ] Buat layout Blade, components, dan view untuk semua halaman.

8. **JavaScript & Realtime Features**
   - [ ] Konfigurasi Chart.js untuk analisis performa.
   - [ ] Implementasi sistem notifikasi/Toast.

9. **Additional Features**
   - [ ] Implementasi sistem notifikasi/suara.
   - [ ] Fitur berbagi (share).

10. **Cleanup & Scheduler**
    - [ ] Optimasi query, `optimize:clear`.
    - [ ] Setup schedule untuk laporan harian.

11. **Final Polish & Bug Fixes**
    - [ ] Uji coba UI/UX responsif.
    - [ ] Penanganan error (error pages 404/500).

---
*Catatan: Laravel 13 mengacu pada versi stabil terkini/mendatang dengan fitur-fitur terbaru Laravel.*
