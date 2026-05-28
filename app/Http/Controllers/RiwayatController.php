<?php

namespace App\Http\Controllers;

use App\Models\LaporanInsiden;
use App\Models\TransaksiCendol;
use App\Repositories\Contracts\TransaksiCendolRepositoryInterface;
use App\Repositories\Contracts\LaporanInsidenRepositoryInterface;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RiwayatController extends Controller
{
    public function __construct(
        protected TransaksiCendolRepositoryInterface $cendolRepo,
        protected LaporanInsidenRepositoryInterface $laporanRepo,
    ) {}

    public function index()
    {
        $cendol = $this->cendolRepo->all();
        $laporan = $this->laporanRepo->all();
        return view('riwayat', compact('cendol', 'laporan'));
    }

    public function data(Request $request)
    {
        $cendol = TransaksiCendol::with(['pengirim', 'penerima'])->get()->map(function ($item) {
            return [
                'tipe' => 'Cendol',
                'tipe_badge' => 'bg-success-subtle text-success',
                'tanggal' => $item->created_at ? $item->created_at->format('d M Y H:i') : '-',
                'subjek' => $item->penerima->name ?? '-',
                'kategori' => $item->kategori,
                'pesan' => $item->pesan ?? '-',
                'status' => '<span class="badge bg-success">Terkirim</span>',
                'sort_time' => $item->created_at ? $item->created_at->timestamp : 0,
            ];
        });

        $laporan = LaporanInsiden::with(['pelapor', 'penerima'])->get()->map(function ($item) {
            $badge = match($item->status) {
                'menunggu' => 'bg-warning text-dark',
                'ditinjau' => 'bg-info text-white',
                'selesai' => 'bg-success',
                'ditolak' => 'bg-danger',
                default => 'bg-secondary',
            };
            return [
                'tipe' => 'Bata',
                'tipe_badge' => 'bg-danger-subtle text-danger',
                'tanggal' => $item->created_at ? $item->created_at->format('d M Y H:i') : '-',
                'subjek' => $item->penerima->name ?? ($item->pelapor->name ?? '-'),
                'kategori' => $item->tipe,
                'pesan' => $item->deskripsi ?? '-',
                'status' => '<span class="badge ' . $badge . '">' . ucfirst($item->status) . '</span>',
                'sort_time' => $item->created_at ? $item->created_at->timestamp : 0,
            ];
        });

        $collection = collect(array_merge($cendol->toArray(), $laporan->toArray()))
            ->sortByDesc('sort_time')
            ->values();

        if ($request->has('tipe') && $request->tipe !== 'all') {
            $filter = ucfirst($request->tipe);
            $collection = $collection->where('tipe', $filter);
        }

        return DataTables::of($collection)
            ->addColumn('aksi_display', fn($row) => '<span class="badge ' . $row['tipe_badge'] . '">' . $row['tipe'] . '</span>')
            ->rawColumns(['aksi_display', 'status'])
            ->make(true);
    }
}
