# Sistem Desain: Stitch 360

Dokumen ini mendefinisikan standar visual yang digunakan dalam prototipe Stitch 360 (`/mockup`). Panduan ini menggunakan **Bootstrap 5.3** dan wajib diikuti saat migrasi ke Laravel Blade.

## 1. Palet Warna (Bootstrap 5.3 Semantic)
Aplikasi menggunakan sistem warna semantik Bootstrap untuk konsistensi:
- **Primary:** `.btn-primary`, `.text-primary` (`#0d6efd`)
- **Success (Cendol):** `.btn-success`, `.text-success` (`#198754`)
- **Danger (Bata):** `.btn-danger`, `.text-danger` (`#dc3545`)
- **Background:** `#f0f2f5` (Aplikasi), `#ffffff` (Kartu)

## 2. Tipografi
- **Font Family:** `'Inter', sans-serif` (Muat via Google Fonts)
- **Hierarki:**
  - **Extra Bold (800):** Judul utama (`<h1>`, `<h2>`).
  - **Bold (600/700):** Header kartu, tombol, label formulir.
  - **Regular (400):** Isi konten/paragraf.

## 3. Komponen UI Kustom (Bootstrap Extensions)
Selain komponen standar Bootstrap, digunakan kelas kustom berikut:
- **`.stat-card`:** Kartu statistik dengan shadow lembut dan efek *hover lift*.
  - *Border-radius:* `16px`.
  - *Transition:* `all 0.3s cubic-bezier(0.4, 0, 0.2, 1)`.
- **`.feed-card`:** Kartu daftar aktivitas dengan *padding* 4 rem.
- **`.btn-action`:** Tombol aksi dengan `gap-8px` dan transisi `scale(1.02)`.
- **`.icon-box`:** Wrapper ikon 48x48px dengan *border-radius* 12px.

## 4. Layout & Tata Letak
- **Dashboard:** Layout Sidebar (240px) dan Main Content (`padding: 30px` di desktop).
- **Autentikasi (Login/Register):** Layout *Card-based* yang berpusat di tengah layar, dengan *padding* 40px pada kartu.
- **Grid:** Menggunakan `container-fluid` dan sistem Bootstrap Grid (`row`, `col-*`) untuk responsivitas penuh.

## 5. Animasi & Interaktivitas
- **FadeIn:** Digunakan saat halaman dimuat (0.6s) untuk memberi kesan elegan.
- **Hover:** Efek `translateY(-8px)` pada `.stat-card`.
- **Tooltip:** Bootstrap Tooltips diaktifkan pada elemen statistik untuk informasi tambahan.

## 6. Integrasi Frontend (Blade)
Saat migrasi ke Laravel Blade:
- Gunakan `@extends('layouts.app')`.
- Pastikan semua file CSS/JS di-compile melalui **Vite**.
- Simpan komponen navigasi dalam file Blade parsial (`navbar.blade.php`, `sidebar.blade.php`) dan panggil dengan `@include`.
