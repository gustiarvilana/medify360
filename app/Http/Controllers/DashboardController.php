<?php

namespace App\Http\Controllers;

use App\Models\TargetPenilaian;
use App\Models\Penilaian360;
use App\Repositories\Contracts\TransaksiCendolRepositoryInterface;
use App\Repositories\Contracts\LaporanInsidenRepositoryInterface;

class DashboardController extends Controller
{
    public function __construct(
        protected TransaksiCendolRepositoryInterface $cendolRepo,
        protected LaporanInsidenRepositoryInterface $laporanRepo,
    ) {}

    public function index()
    {
        $user = auth()->user();
        $cendolDiterima = $this->cendolRepo->findByPenerima($user->id);
        $cendolDikirim = $this->cendolRepo->findByPengirim($user->id);
        $laporan = $this->laporanRepo->findByPelapor($user->id);
        $recentActivity = $this->cendolRepo->all()->sortByDesc('created_at')->take(5);

        $targetPenilaian = TargetPenilaian::where('id_penilai', $user->id)->count();
        $penilaianSelesai = Penilaian360::where('id_penilai', $user->id)->count();
        $adaTarget = $targetPenilaian > 0;

        return view('dashboard', compact(
            'cendolDiterima', 'cendolDikirim', 'laporan', 'recentActivity',
            'targetPenilaian', 'penilaianSelesai', 'adaTarget'
        ));
    }
}
