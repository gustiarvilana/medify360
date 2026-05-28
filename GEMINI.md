# GEMINI.md - Panduan Instruksional Proyek

Repositori ini berisi proyek pengembangan perangkat lunak berbasis **Laravel** dengan integrasi prototipe desain statis.

## 1. Proyek Overview
Proyek ini adalah aplikasi web menggunakan framework **Laravel** (PHP). Selain struktur aplikasi Laravel standar, repositori ini mencakup direktori `/mockup` yang berisi kumpulan prototipe desain statis (HTML/CSS/JS) untuk fitur **Stitch 360 Culture Performance Platform**.

- **Teknologi Backend/Core:** PHP, Laravel Framework (MVC), Composer.
- **Teknologi Frontend Utama:** Laravel Blade, Vite, NPM/JS.
- **Teknologi Prototipe (/mockup):** HTML5, Bootstrap 5.3, JavaScript (sistem komponen modular).

## 2. Membangun dan Menjalankan Proyek

### A. Aplikasi Utama (Laravel)
Pastikan PHP, Composer, dan Node.js terinstal.

1. **Instalasi:** `composer install && npm install`
2. **Konfigurasi:** Salin `.env.example` ke `.env` dan jalankan `php artisan key:generate`.
3. **Menjalankan Server:** 
   - Backend: `php artisan serve` (di `http://127.0.0.1:8000`)
   - Frontend (Vite): `npm run dev`

### B. Prototipe Desain (/mockup)
Bagian ini bersifat independen dan berfungsi sebagai referensi UI/UX.

1. **Menjalankan:** Cukup buka file `.html` di direktori `mockup/` langsung di browser.
2. **Struktur Komponen:** Menggunakan sistem modular (`js/components.js`) yang menginjeksi Navbar dan Sidebar secara dinamis di sisi klien untuk konsistensi tanpa server (Teknik *JavaScript String Embed*).

## 3. Konvensi Pengembangan
- **Coding Style:** Mengikuti standar PSR (PHP) dan konvensi Laravel.
- **Testing:** Menggunakan PHPUnit (`php artisan test`).
- **Struktur Direktori:**
  - `app/`, `resources/`, `routes/`, `database/`: Struktur standar Laravel.
  - `mockup/`: Prototipe frontend statis untuk fitur *Culture Performance*.
  - `dokumentasi/`: Dokumentasi teknis terperinci (PRD, Design, dll).
  - `.agents/`: Konfigurasi khusus untuk agen AI.

## 4. Panduan Interaksi AI
- **Konteks:** Jika diminta membuat fitur baru, periksa apakah fitur tersebut sudah ada di `/mockup` sebagai referensi desain sebelum mengimplementasikannya ke Laravel Blade.
- **Navigasi:** Selalu gunakan sistem komponen modular jika perlu memodifikasi Navbar atau Sidebar di prototipe `/mockup`.
- **Bahasa:** Gunakan Bahasa Indonesia dalam penamaan tabel/field basis data dan dokumentasi proyek.
- **Dokumentasi Teknis:** Referensi teknis detail tersedia di `dokumentasi/dokumen_teknis.md`.
