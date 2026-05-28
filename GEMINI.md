# GEMINI.md - Panduan Instruksional Proyek

Repositori ini berisi aplikasi web berbasis **Laravel**.

## Proyek Overview
Proyek ini adalah aplikasi web yang dibangun dengan framework PHP **Laravel**. Laravel adalah framework web dengan sintaks yang ekspresif dan elegan.

- **Teknologi Utama:** PHP, Laravel Framework.
- **Arsitektur:** Model-View-Controller (MVC).

## Membangun dan Menjalankan Proyek

Pastikan Anda memiliki PHP dan Composer terinstal di lingkungan Anda.

1. **Instalasi Dependensi:**
   ```bash
   composer install
   npm install
   ```

2. **Konfigurasi Lingkungan:**
   Salin file `.env.example` ke `.env` dan sesuaikan konfigurasi basis data Anda:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Menjalankan Aplikasi:**
   ```bash
   php artisan serve
   ```
   Aplikasi akan berjalan di `http://127.0.0.1:8000`.

4. **Menjalankan Frontend (Vite):**
   ```bash
   npm run dev
   ```

## Konvensi Pengembangan
- **Coding Style:** Mengikuti standar PSR (PHP Standard Recommendations) dan konvensi Laravel.
- **Testing:** Menggunakan PHPUnit. Jalankan pengujian dengan `php artisan test`.
- **Struktur:** Ikuti struktur direktori standar Laravel (`app/`, `resources/`, `routes/`, `database/`).
- **Penting:** Proyek ini mencakup folder `/mockup` yang berisi prototipe desain statis (HTML/CSS/JS) untuk fitur "Stitch 360 Culture Performance Platform". Prototipe ini bersifat independen dan dapat dijalankan langsung di browser.
