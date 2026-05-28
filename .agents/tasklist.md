# Tasklist: Stitch 360 + Penilaian 360

**Progress: ~60%** (tanpa periode — lebih simple)

---

## ✅ Selesai (Fitur Dasar)
- [x] Setup Laravel + Breeze (Bootstrap 5.3)
- [x] Database migrations (departemen, peran, users, transaksi_cendol, laporan_insiden)
- [x] Models + Repositories (Eloquent + Interface)
- [x] Layout (navbar, sidebar, offcanvas mobile)
- [x] All Blade views (dashboard, riwayat, laporan, leaderboard, analisis, manajemen-user, admin-laporan, pengaturan)
- [x] Yajra DataTables server-side (manajemen-user, admin-laporan, riwayat, leaderboard, laporan)
- [x] Chart.js (analisis performa)
- [x] Auth: login via username/email, register
- [x] Notifikasi real-time (bell icon, dropdown, suara)
- [x] Select2 di semua dropdown
- [x] Toast sukses/gagal (posisi kanan atas)
- [x] Password toggle mata
- [x] Username field (migrasi, register, pengaturan, admin)
- [x] Ganti foto profil (upload + storage)
- [x] Limit Whistleblow (batas_whistleblow per role, validasi store, dashboard card, sidebar badge)

---

## 📋 Penilaian 360 — Database (5 Migrasi) ✅

- [x] Migration: `dimensi_penilaian` — `nama`, `deskripsi`, `urutan`
- [x] Migration: `bobot_relasi` — `id_peran_penilai` (FK peran), `id_peran_dinilai` (FK peran), `bobot` (decimal 5.2)
- [x] Migration: `target_penilaian` — `id_penilai` (FK users), `id_dinilai` (FK users), `status` (menunggu/selesai)
- [x] Migration: `penilaian_360` — `id_target` (FK), `id_penilai` (FK), `id_dinilai` (FK), `skor_akhir` (decimal 5.2), `catatan` (text nullable), `tanggal_selesai`
- [x] Migration: `skor_penilaian` — `id_penilaian` (FK), `id_dimensi` (FK), `skor` (tinyint 1-5)
- [x] Seed: dimensi default + bobot relasi default

## 📋 Penilaian 360 — Model + Repository ✅

- [x] Model: `PeriodePenilaian` + Repository Interface + Eloquent impl
- [x] Model: `DimensiPenilaian` + Repository Interface + Eloquent impl
- [x] Model: `BobotRelasi` + Repository Interface + Eloquent impl
- [x] Model: `TargetPenilaian` + Repository Interface + Eloquent impl
- [x] Model: `Penilaian360` + Repository Interface + Eloquent impl
- [x] Model: `SkorPenilaian` + Repository Interface + Eloquent impl
- [x] Register 6 binding baru di `AppServiceProvider`

## 📋 Penilaian 360 — Controller + Route ✅

- [x] `Penilaian360Controller` — index (tugas saya), create (form nilai), store, show (detail), bobotIndex, bobotUpdate
- [x] `Dashboard360Controller` — widget skor rata-rata per orang/departemen
- [x] Route: `/penilaian-360/*`, `/dashboard-360`, `/admin/bobot`
- [x] Update `DashboardController` — tambah data 360 ke dashboard utama

## 📋 Penilaian 360 — View ✅

- [x] `penilaian-index.blade.php` — DataTable tugas penilaian saya (tanpa kolom periode)
- [x] `penilaian-form.blade.php` — Form star rating per dimensi (1-5) + catatan
- [x] `penilaian-detail.blade.php` — Breakdown skor per dimensi + rata-rata bobot
- [x] `dashboard-360.blade.php` — stat cards + progress per departemen
- [x] `bobot.blade.php` — Atur bobot relasi per peran
- [x] Update sidebar — menu group "Penilaian 360" (Penilaian Saya + Bobot Penilaian)

## 📋 Penilaian 360 — Scoring Logic ✅

- [x] Generate target: Admin nilai semua, Manajer nilai staff, Staff nilai peer (tanpa periode)
- [x] Hitung skor akhir: `rata_rata_dimensi × bobot_relasi`
- [x] Dashboard widget: rata-rata 360 per orang, per departemen

---

## ⏳ Nanti (Enhancement)

- [ ] Export report 360 ke PDF
- [ ] Notifikasi saat ada target penilaian baru
- [ ] Reminder otomatis (email/bell) jika target belum selesai
- [ ] Multi-periode comparison chart
- [ ] RBAC: akses admin/manajer/staff untuk fitur tertentu
