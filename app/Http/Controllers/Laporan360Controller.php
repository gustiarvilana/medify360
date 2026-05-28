<?php

namespace App\Http\Controllers;

use App\Models\BobotRelasi;
use App\Models\Penilaian360;
use App\Models\Departemen;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\View\View;

class Laporan360Controller extends Controller
{
    public function index(): View
    {
        $departemen = Departemen::all();
        return view('penilaian-360.laporan-360', compact('departemen'));
    }

    public function data(Request $request)
    {
        $penilaian = Penilaian360::with([
            'penilai.departemen',
            'dinilai.departemen',
            'skor.dimensi',
        ]);

        return \Yajra\DataTables\Facades\DataTables::of($penilaian)
            ->addColumn('penilai_nama', fn($row) => $row->penilai?->name ?? '-')
            ->addColumn('penilai_dept', fn($row) => $row->penilai?->departemen?->nama ?? '-')
            ->addColumn('dinilai_nama', fn($row) => $row->dinilai?->name ?? '-')
            ->addColumn('dinilai_dept', fn($row) => $row->dinilai?->departemen?->nama ?? '-')
            ->editColumn('skor_akhir', fn($row) => number_format($row->skor_akhir, 2))
            ->editColumn('tanggal_selesai', fn($row) => $row->tanggal_selesai?->format('d M Y H:i') ?? '-')
            ->addColumn('dimensi', function ($row) {
                $labels = [];
                foreach ($row->skor as $s) {
                    $labels[] = '<span class="badge bg-info me-1">' . e($s->dimensi?->nama ?? '-') . ': ' . $s->skor . '</span>';
                }
                return implode('', $labels);
            })
            ->filterColumn('penilai_nama', function ($query, $keyword) {
                $query->whereHas('penilai', fn($q) => $q->where('name', 'like', "%{$keyword}%"));
            })
            ->filterColumn('dinilai_nama', function ($query, $keyword) {
                $query->whereHas('dinilai', fn($q) => $q->where('name', 'like', "%{$keyword}%"));
            })
            ->filterColumn('penilai_dept', function ($query, $keyword) {
                $query->whereHas('penilai.departemen', fn($q) => $q->where('nama', 'like', "%{$keyword}%"));
            })
            ->filterColumn('dinilai_dept', function ($query, $keyword) {
                $query->whereHas('dinilai.departemen', fn($q) => $q->where('nama', 'like', "%{$keyword}%"));
            })
            ->rawColumns(['dimensi'])
            ->make(true);
    }

    public function pdf()
    {
        $penilaian = Penilaian360::with([
            'penilai.departemen',
            'dinilai.departemen',
            'skor.dimensi',
        ])->get();

        $rataRata = Penilaian360::avg('skor_akhir') ?? 0;
        $totalData = $penilaian->count();

        $pdf = Pdf::loadView('penilaian-360.pdf-laporan-360', compact('penilaian', 'rataRata', 'totalData'));

        return $pdf->stream('laporan-penilaian-360.pdf');
    }

    public function individu(): View
    {
        $departemen = Departemen::all();
        return view('penilaian-360.laporan-individu', compact('departemen'));
    }

    public function individuData(Request $request)
    {
        $users = User::with('departemen', 'peran')
            ->whereHas('penilaianDiterima');

        return \Yajra\DataTables\Facades\DataTables::of($users)
            ->addColumn('departemen_nama', fn($row) => $row->departemen?->nama ?? '-')
            ->addColumn('peran_nama', fn($row) => $row->peran?->nama ?? '-')
            ->addColumn('total_penilaian', fn($row) => $row->penilaianDiterima()->count())
            ->addColumn('rata_skor', fn($row) => number_format($row->penilaianDiterima()->avg('skor_akhir') ?? 0, 2))
            ->addColumn('aksi', function ($row) {
                $detailUrl = route('laporan-360.detail', $row->id);
                $pdfUrl = route('laporan-360.pdf-individu', $row->id);
                return '<a href="' . $detailUrl . '" class="btn btn-sm btn-outline-primary me-1">Detail</a>'
                     . '<a href="' . $pdfUrl . '" target="_blank" class="btn btn-sm btn-outline-danger">PDF</a>';
            })
            ->filterColumn('departemen_nama', function ($query, $keyword) {
                $query->whereHas('departemen', fn($q) => $q->where('nama', 'like', "%{$keyword}%"));
            })
            ->filterColumn('peran_nama', function ($query, $keyword) {
                $query->whereHas('peran', fn($q) => $q->where('nama', 'like', "%{$keyword}%"));
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function detail($id): View
    {
        $user = User::with('departemen', 'peran', 'penilaianDiterima')->findOrFail($id);
        return view('penilaian-360.laporan-individu-detail', compact('user'));
    }

    public function detailData($id, Request $request)
    {
        $penilaian = Penilaian360::with([
            'penilai.departemen',
            'skor.dimensi',
        ])->where('id_dinilai', $id);

        return \Yajra\DataTables\Facades\DataTables::of($penilaian)
            ->addColumn('penilai_nama', fn($row) => $row->penilai?->name ?? '-')
            ->addColumn('penilai_dept', fn($row) => $row->penilai?->departemen?->nama ?? '-')
            ->editColumn('skor_akhir', fn($row) => number_format($row->skor_akhir, 2))
            ->editColumn('tanggal_selesai', fn($row) => $row->tanggal_selesai?->format('d M Y H:i') ?? '-')
            ->addColumn('dimensi', function ($row) {
                $labels = [];
                foreach ($row->skor as $s) {
                    $labels[] = '<span class="badge bg-info me-1">' . e($s->dimensi?->nama ?? '-') . ': ' . $s->skor . '</span>';
                }
                return implode('', $labels);
            })
            ->filterColumn('penilai_nama', function ($query, $keyword) {
                $query->whereHas('penilai', fn($q) => $q->where('name', 'like', "%{$keyword}%"));
            })
            ->rawColumns(['dimensi'])
            ->make(true);
    }

    public function pdfIndividu($id)
    {
        $user = User::with('departemen', 'peran', 'penilaianDiterima')->findOrFail($id);

        $penilaian = Penilaian360::with([
            'penilai.departemen',
            'penilai.peran',
            'dinilai.peran',
            'skor.dimensi',
        ])->where('id_dinilai', $id)->get();

        $rataSkor = $penilaian->avg('skor_akhir') ?? 0;

        $rataDimensi = [];
        foreach ($penilaian as $p) {
            foreach ($p->skor as $s) {
                $rataDimensi[$s->dimensi->nama][] = $s->skor;
            }
        }
        foreach ($rataDimensi as $key => $values) {
            $rataDimensi[$key] = round(array_sum($values) / count($values), 2);
        }

        $bobotPerPenilaian = [];
        foreach ($penilaian as $p) {
            $bobot = BobotRelasi::where('id_peran_penilai', $p->penilai->id_peran)
                ->where('id_peran_dinilai', $p->dinilai->id_peran)
                ->first();
            $bobotPerPenilaian[$p->id] = $bobot?->bobot ?? 1.00;
        }

        $pdf = Pdf::loadView('penilaian-360.pdf-laporan-individu', compact('user', 'penilaian', 'rataSkor', 'rataDimensi', 'bobotPerPenilaian'));

        return $pdf->stream('laporan-penilaian-360-' . $user->name . '.pdf');
    }
}
