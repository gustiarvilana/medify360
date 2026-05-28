<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CendolController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dashboard360Controller;
use App\Http\Controllers\Laporan360Controller;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\Penilaian360Controller;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\WhistleblowController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat');
    Route::get('/riwayat/data', [RiwayatController::class, 'data'])->name('riwayat.data');
    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard');
    Route::get('/leaderboard/data', [LeaderboardController::class, 'data'])->name('leaderboard.data');

    Route::get('/whistleblow', [WhistleblowController::class, 'index'])->name('whistleblow.index');
    Route::get('/whistleblow/data', [WhistleblowController::class, 'data'])->name('whistleblow.data');
    Route::get('/whistleblow/detail/{id}', [WhistleblowController::class, 'detail'])->name('whistleblow.detail');

    Route::post('/cendol/kirim', [CendolController::class, 'kirim'])->name('cendol.kirim');

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
    Route::get('/laporan/data-laporan', [LaporanController::class, 'dataLaporan'])->name('laporan.data');
    Route::get('/laporan/data-cendol', [LaporanController::class, 'dataCendol'])->name('laporan.data-cendol');
    Route::get('/laporan/detail/{id}', [LaporanController::class, 'detail'])->name('laporan.detail');
    Route::post('/laporan', [LaporanController::class, 'store'])->name('laporan.store');

    Route::get('/admin/user', [AdminController::class, 'index'])->name('manajemen-user');
    Route::get('/admin/user/data', [AdminController::class, 'data'])->name('manajemen-user.data');
    Route::post('/admin/user', [AdminController::class, 'store'])->name('manajemen-user.store');
    Route::put('/admin/user/{id}', [AdminController::class, 'update'])->name('manajemen-user.update');
    Route::delete('/admin/user/{id}', [AdminController::class, 'destroy'])->name('manajemen-user.destroy');

    Route::get('/admin/laporan', [AdminController::class, 'laporanIndex'])->name('admin.laporan');
    Route::get('/admin/laporan/data', [AdminController::class, 'laporanData'])->name('admin.laporan.data');
    Route::post('/admin/laporan/{id}/status', [AdminController::class, 'laporanUpdateStatus'])->name('admin.laporan.status');

    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan');
    Route::post('/pengaturan/profile', [PengaturanController::class, 'updateProfile'])->name('pengaturan.update-profile');
    Route::post('/pengaturan/foto', [PengaturanController::class, 'updateFoto'])->name('pengaturan.update-foto');
    Route::post('/pengaturan/password', [PengaturanController::class, 'updatePassword'])->name('pengaturan.update-password');

    Route::get('/notifikasi/unread', [NotifikasiController::class, 'unread'])->name('notifikasi.unread');
    Route::post('/notifikasi/{id}/read', [NotifikasiController::class, 'markRead'])->name('notifikasi.read');
    Route::post('/notifikasi/read-all', [NotifikasiController::class, 'markAllRead'])->name('notifikasi.read-all');
    Route::post('/notifikasi/preferensi', [NotifikasiController::class, 'updatePreferences'])->name('notifikasi.preferensi');

    Route::get('/dashboard-360', [Dashboard360Controller::class, 'index'])->name('dashboard-360');

    Route::get('/penilaian-360', [Penilaian360Controller::class, 'index'])->name('penilaian-360.index');
    Route::get('/penilaian-360/data', [Penilaian360Controller::class, 'data'])->name('penilaian-360.data');
    Route::get('/penilaian-360/nilai/{idTarget}', [Penilaian360Controller::class, 'create'])->name('penilaian-360.create');
    Route::post('/penilaian-360', [Penilaian360Controller::class, 'store'])->name('penilaian-360.store');
    Route::get('/penilaian-360/{id}', [Penilaian360Controller::class, 'show'])->name('penilaian-360.show');

    Route::get('/laporan-360', [Laporan360Controller::class, 'index'])->name('laporan-360.index');
    Route::get('/laporan-360/data', [Laporan360Controller::class, 'data'])->name('laporan-360.data');
    Route::get('/laporan-360/pdf', [Laporan360Controller::class, 'pdf'])->name('laporan-360.pdf');
    Route::get('/laporan-360/individu', [Laporan360Controller::class, 'individu'])->name('laporan-360.individu');
    Route::get('/laporan-360/individu-data', [Laporan360Controller::class, 'individuData'])->name('laporan-360.individu-data');
    Route::get('/laporan-360/individu/{id}', [Laporan360Controller::class, 'detail'])->name('laporan-360.detail');
    Route::get('/laporan-360/individu/{id}/data', [Laporan360Controller::class, 'detailData'])->name('laporan-360.detail-data');
    Route::get('/laporan-360/individu/{id}/pdf', [Laporan360Controller::class, 'pdfIndividu'])->name('laporan-360.pdf-individu');

    Route::get('/admin/bobot', [Penilaian360Controller::class, 'bobotIndex'])->name('bobot.index');
    Route::post('/admin/bobot', [Penilaian360Controller::class, 'bobotUpdate'])->name('bobot.update');

    Route::get('/admin/dimensi', [Penilaian360Controller::class, 'dimensiIndex'])->name('dimensi.index');
    Route::post('/admin/dimensi', [Penilaian360Controller::class, 'dimensiStore'])->name('dimensi.store');
    Route::put('/admin/dimensi/{id}', [Penilaian360Controller::class, 'dimensiUpdate'])->name('dimensi.update');
    Route::delete('/admin/dimensi/{id}', [Penilaian360Controller::class, 'dimensiDestroy'])->name('dimensi.destroy');

    Route::get('/admin/master/jabatan', [MasterDataController::class, 'jabatanIndex'])->name('master.jabatan');
    Route::post('/admin/master/jabatan', [MasterDataController::class, 'jabatanStore'])->name('master.jabatan.store');
    Route::put('/admin/master/jabatan/{id}', [MasterDataController::class, 'jabatanUpdate'])->name('master.jabatan.update');
    Route::delete('/admin/master/jabatan/{id}', [MasterDataController::class, 'jabatanDestroy'])->name('master.jabatan.destroy');

    Route::get('/admin/master/departemen', [MasterDataController::class, 'departemenIndex'])->name('master.departemen');
    Route::post('/admin/master/departemen', [MasterDataController::class, 'departemenStore'])->name('master.departemen.store');
    Route::put('/admin/master/departemen/{id}', [MasterDataController::class, 'departemenUpdate'])->name('master.departemen.update');
    Route::delete('/admin/master/departemen/{id}', [MasterDataController::class, 'departemenDestroy'])->name('master.departemen.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
