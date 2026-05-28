# Dokumentasi Proyek: Stitch 360 (CendolBata)

Platform **Stitch 360** (juga dikenal sebagai **CendolBata**) adalah sistem manajemen performa dan budaya perusahaan yang berfokus pada apresiasi positif dan integritas pelaporan insiden.

## 1. Ikhtisar Proyek
Platform ini dirancang untuk menciptakan lingkungan kerja yang apresiatif namun tetap transparan dan patuh pada aturan perusahaan. 
- **Cendol:** Simbol apresiasi positif (hijau).
- **Bata:** Simbol pelaporan insiden/pelanggaran (merah).

## 2. Fitur Utama
- **Dashboard Utama:** Ringkasan statistik performa, feed aktivitas, target budaya, dan aksi cepat.
- **Kirim Cendol & Bata:** Modal interaktif untuk apresiasi dan pelaporan insiden.
- **Leaderboard:** Papan peringkat budaya yang kompetitif dan informatif.
- **Analisis Performa:** Visualisasi data (Radar & Line Chart) untuk pengembangan diri karyawan.
- **Manajemen User:** Modul administratif untuk mengelola data karyawan.
- **Pengaturan:** Konfigurasi profil, notifikasi, dan keamanan akun.

## 3. Algoritma Analisis Performa
Skor performa budaya dihitung menggunakan algoritma *weighted average*:

$$Skor = (C_{diterima} \times W_1) + (C_{diberikan} \times W_2) - (B_{terbukti} \times W_3)$$

*Hasil skor di-normalisasi ke skala 0-100.*

## 4. Arsitektur Teknis
- **Framework:** Bootstrap 5.3 (CDN).
- **Navigasi Modular:** Menggunakan `js/components.js` untuk menyuntikkan (inject) Navbar dan Sidebar ke setiap halaman. Sistem ini menggunakan teknik **JavaScript String Embed** agar navigasi tetap konsisten dan **bisa berjalan secara offline (file://)** tanpa memerlukan *Local Server*.
- **Visualisasi:** Chart.js untuk grafik interaktif.
- **Responsivitas:** *Mobile-first* menggunakan sistem Grid Bootstrap dan *Offcanvas* sidebar.

## 5. Panduan Pengembangan
### Menjalankan Platform
Aplikasi ini sudah dioptimalkan untuk akses langsung (buka file `.html` di browser). Tidak diperlukan instalasi *Local Server* tambahan.

## 6. Alur Kerja Fitur Pencarian Karyawan
Fitur pencarian di Navbar dirancang untuk membantu pengguna menemukan rekan kerja dengan cepat dan melakukan tindakan proaktif.

### Alur Kerja:
1.  **Input:** Pengguna mengetik nama atau departemen di kotak pencarian (minimal 2 karakter).
2.  **Pemrosesan:** Sistem secara *real-time* (tanpa memuat ulang halaman) memfilter daftar karyawan yang tersedia.
3.  **Tampilan Hasil:** Dropdown akan muncul langsung di bawah kotak pencarian, menampilkan:
    -   **Foto Profil:** Untuk memastikan identitas yang tepat.
    -   **Nama & Departemen:** Sebagai konteks tambahan.
4.  **Tindakan:**
    -   **Klik Hasil:** Pengguna dapat mengklik entri karyawan untuk diarahkan ke halaman profil atau memicu tindakan (seperti membuka modal Cendol).
    -   **Tidak Ditemukan:** Jika query tidak cocok, sistem akan menampilkan pesan "Karyawan tidak ditemukan" untuk mencegah ambiguitas.
5.  **Penutupan:** Hasil pencarian otomatis tertutup jika pengguna mengklik area di luar kotak pencarian.

