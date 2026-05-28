# Product Requirement Document (PRD): Stitch 360

## 1. Visi Produk
Stitch 360 (CendolBata) adalah platform manajemen budaya perusahaan untuk meningkatkan apresiasi, transparansi, dan integritas di lingkungan kerja.

## 2. Target Pengguna
- **Karyawan:** Memberikan apresiasi, memantau performa, dan melaporkan insiden.
- **Manajer:** Memantau tren budaya tim dan performa individu.
- **HR/Admin:** Mengelola data karyawan, meninjau laporan, dan mengelola nilai budaya.

## 3. User Stories
- **Sebagai Karyawan**, saya ingin memberi "Cendol" agar rekan kerja tahu kontribusinya dihargai.
- **Sebagai Karyawan**, saya ingin melapor insiden secara anonim agar merasa aman saat melapor.
- **Sebagai Admin**, saya ingin memantau kesehatan budaya perusahaan melalui papan peringkat dan laporan.

## 4. Spesifikasi Fitur Terperinci
### A. Autentikasi
- Login/Register menggunakan username atau email.
- Toggle visibility password untuk keamanan.
- Validasi form (konfirmasi password saat daftar).

### B. Dashboard & Performa
- Statistik: Cendol diterima/diberikan, Laporan Bata, Skor Budaya (Agregat).
- Visualisasi: Radar Chart (kemampuan 360°) dan Line Chart (tren performa).

### C. Apresiasi & Pelaporan
- Apresiasi: Form dengan kategori (Kolaborasi, Integritas, Inovasi).
- Pelaporan: Form dengan kategori insiden, deskripsi, dan opsi anonim.

## 5. Manajemen Error & Notifikasi
- **Notifikasi:** Toast untuk feedback aksi sukses (Kirim Cendol/Bata).
- **Validasi:** HTML5 `required` pada semua form untuk mencegah input kosong.
- **Penanganan Error:** Placeholder navigasi yang informatif jika komponen dinamis gagal dimuat.

## 6. Roadmap Pengembangan
- **Fase 1 (MVP):** Autentikasi, Dashboard, Cendol, Bata, Pengaturan.
- **Fase 2 (Peningkatan):** Leaderboard, Analisis Performa (Chart.js), Manajemen User (CRUD).
- **Fase 3 (Lanjutan):** Integrasi API, Notifikasi real-time (Pusher/Websocket), Integrasi Bukti Dokumen pada Laporan Bata.
