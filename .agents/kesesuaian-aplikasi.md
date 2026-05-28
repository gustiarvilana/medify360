# Checklist Kesesuaian Aplikasi vs Kebutuhan

## 📖 Cerita / Kebutuhan

> *Dibutuhkan aplikasi untuk penilaian 360. Jadi satu orang bisa menilai orang lain. Manajer bisa menilai staff, staff bisa menilai staff lain di satu tim yang sama. Tentunya manajer ke staff dan staff ke staff beda bobot skoringnya, dan tersedia dashboard dan report nya.*
>
> *Tersedia fitur whistleblow, dimana staff bisa melaporkan staff lain dan memberikan "bata" apabila ada insiden yang tidak sesuai dengan budaya kerja, atau melakukan kesalahan berat atau perilaku tidak pantas lainnya.*
>
> *Dan ada juga fitur dimana staff lain bisa memberikan "cendol" kepada staff lain yang memiliki budaya kerja baik.*
>
> *Setiap orang memiliki batasan bisa berapa kali memberikan whistleblow.*

---

## 1. 🎯 Penilaian 360

| # | Kebutuhan | Status | Implementasi |
|---|-----------|--------|-------------|
| 1.1 | Satu orang bisa menilai orang lain | ✅ | `Penilaian360Controller::generateTargets()` — tiap user mendapat target penilaian |
| 1.2 | Manajer bisa menilai staff | ✅ | Manajer (peran id=2) → Karyawan (peran id=1) di departemen yang sama |
| 1.3 | Staff bisa menilai staff lain di satu tim yang sama | ✅ | Karyawan (peran id=1) → Karyawan lain (peran id=1) di departemen yang sama |
| 1.4 | Beda bobot skoring untuk beda relasi | ✅ | `bobot_relasi` table + `generateBobotRelasi()` — default 9 kombinasi dengan bobot berbeda (Karyawan→Karyawan=1.00, Manajer→Karyawan=1.50, dll.) |
| 1.5 | Perhitungan skor akhir = rata-rata dimensi × bobot | ✅ | `hitungSkorAkhir()` di `Penilaian360Controller` |
| 1.6 | Tersedia dashboard | ✅ | `Dashboard360Controller` — stat per departemen, progress bar |
| 1.7 | Tersedia report / laporan | ✅ | `Laporan360Controller` — DataTable semua penilaian + per individu + download PDF (detail dimensi, bobot, perhitungan) |
| 1.8 | Input nilai per dimensi (star rating) | ✅ | `penilaian-form.blade.php` — star rating 1-5 per dimensi (Kepemimpinan, Kerjasama, Komunikasi, Inisiatif, Kualitas Kerja) |
| 1.9 | Admin bisa atur bobot per relasi | ✅ | `BobotPenilaian` — slider + number input min 0 max 5 step 0.1 |
| 1.10 | Admin bisa atur dimensi penilaian | ✅ | `DimensiPenilaian` — CRUD dengan modal |

---

## 2. 🔴 Whistleblow (Bata)

| # | Kebutuhan | Status | Implementasi |
|---|-----------|--------|-------------|
| 2.1 | Staff bisa melaporkan staff lain | ✅ | Form Whistleblow → pilih `id_penerima` (Select2 dropdown semua user) |
| 2.2 | Memberikan "bata" untuk insiden | ✅ | Tipe insiden: Kekerasan, Pelecehan, Penipuan, Pelanggaran, Lainnya |
| 2.3 | Insiden tidak sesuai budaya kerja | ✅ | Deskripsi bebas + tipe terstruktur |
| 2.4 | Kesalahan berat / perilaku tidak pantas | ✅ | Tipe mencakup semua kategori pelanggaran |
| 2.5 | Opsi laporan anonim | ✅ | Checkbox `adalah_anonim` di form |
| 2.6 | Detail laporan (modal) | ✅ | `WhistleblowController::detail()` — tampil tipe, terlapor, status, anonim, deskripsi |
| 2.7 | Status laporan (menunggu → ditinjau → selesai/ditolak) | ✅ | Admin ubah status di **Administrasi → Kelola Laporan** |
| 2.8 | Admin melihat semua laporan | ✅ | `AdminController::laporanData()` — DataTable semua laporan + pelapor + terlapor |
| 2.9 | Notifikasi saat status berubah | ✅ | `BataStatusUpdated` notification + bell icon |
| 2.10 | Halaman Whistleblow khusus | ✅ | `WhistleblowController` — DataTable server-side + form lapor |

---

## 3. 🟢 Cendol (Apresiasi)

| # | Kebutuhan | Status | Implementasi |
|---|-----------|--------|-------------|
| 3.1 | Staff bisa memberi "cendol" ke staff lain | ✅ | `CendolController::kirim()` — form kirim apresiasi |
| 3.2 | Untuk budaya kerja baik | ✅ | Kategori: Kolaborasi, Integritas, Inovasi |
| 3.3 | Riwayat Cendol diterima & dikirim | ✅ | `laporan` page tab "Cendol Saya" + `riwayat` |
| 3.4 | Leaderboard peringkat apresiasi | ✅ | `LeaderboardController` — peringkat penerima Cendol terbanyak |
| 3.5 | Notifikasi saat dapat Cendol | ✅ | `CendolReceived` notification + bell icon + sound |

---

## 4. 🔒 Batas Whistleblow

| # | Kebutuhan | Status | Implementasi |
|---|-----------|--------|-------------|
| 4.1 | Setiap orang punya batas whistleblow | ✅ | `batas_whistleblow` column di tabel `peran` |
| 4.2 | Batas berbeda per peran | ✅ | Karyawan=5, Manajer=10, Admin=null (∞) |
| 4.3 | Perhitungan per bulan | ✅ | `sisaBatasWhistleblow()` — reset tiap awal bulan |
| 4.4 | Tampilkan sisa batas | ✅ | Sidebar badge + alert di halaman Whistleblow |
| 4.5 | Tolak bila batas habis | ✅ | `LaporanController::store()` — return error redirect jika sisa = 0 |

---

## 5. 📋 Dashboard & Navigasi

| # | Kebutuhan | Status | Implementasi |
|---|-----------|--------|-------------|
| 5.1 | Dashboard utama | ✅ | Stat: Cendol diterima/dikirim, Bata, Skor Budaya |
| 5.2 | Menu navigasi sidebar | ✅ | 6 grup: Beranda, Aktivitas, Pelaporan, Penilaian 360, Administrasi, Akun |
| 5.3 | Sidebar collapsible (mobile) | ✅ | Offcanvas di mobile, fixed di desktop |

---

## 6. 🧪 Testing

| # | Kebutuhan | Status | Implementasi |
|---|-----------|--------|-------------|
| 6.1 | Unit test | ✅ | 26 test methods, 62 assertions |
| 6.2 | Seeder data realistis | ✅ | 21 user, 25 penilaian, 25 cendol, 10 laporan |

---

## Ringkasan

| Fitur | Total Kebutuhan | Terpenuhi |
|-------|----------------|-----------|
| Penilaian 360 | 10/10 | ✅ 100% |
| Whistleblow (Bata) | 10/10 | ✅ 100% |
| Cendol (Apresiasi) | 5/5 | ✅ 100% |
| Batas Whistleblow | 5/5 | ✅ 100% |
| Dashboard & Navigasi | 3/3 | ✅ 100% |
| **Total** | **33/33** | **✅ 100%** |
