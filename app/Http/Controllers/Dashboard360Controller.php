<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\Penilaian360;
use App\Models\TargetPenilaian;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class Dashboard360Controller extends Controller
{
    public function index(): View
    {
        $totalPenilaian = Penilaian360::count();
        $totalSelesai = Penilaian360::whereNotNull('tanggal_selesai')->count();
        $totalTarget = TargetPenilaian::count();

        $rataRataGlobal = Penilaian360::whereNotNull('skor_akhir')
            ->avg('skor_akhir') ?? 0;

        $rataPerDepartemen = Departemen::leftJoin('users', 'departemen.id', '=', 'users.id_departemen')
            ->leftJoin('penilaian_360', 'users.id', '=', 'penilaian_360.id_dinilai')
            ->select('departemen.id', 'departemen.nama', DB::raw('AVG(penilaian_360.skor_akhir) as rata_rata'))
            ->groupBy('departemen.id', 'departemen.nama')
            ->get();

        return view('penilaian-360.dashboard-360', compact(
            'totalPenilaian', 'totalSelesai', 'totalTarget', 'rataRataGlobal', 'rataPerDepartemen'
        ));
    }
}
