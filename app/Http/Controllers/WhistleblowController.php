<?php

namespace App\Http\Controllers;

use App\Models\LaporanInsiden;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class WhistleblowController extends Controller
{
    public function index(): View
    {
        return view('whistleblow');
    }

    public function data()
    {
        $query = LaporanInsiden::with('pelapor', 'penerima')
            ->where('id_pelapor', auth()->id());

        return DataTables::of($query)
            ->editColumn('created_at', fn($l) => $l->created_at ? $l->created_at->format('d M Y') : '-')
            ->addColumn('terlapor', fn($l) => $l->penerima?->name ?? '(tidak disebut)')
            ->addColumn('deskripsi_singkat', fn($l) => mb_strlen($l->deskripsi) > 80 ? mb_substr($l->deskripsi, 0, 80) . '...' : $l->deskripsi)
            ->editColumn('status', function ($l) {
                $badge = match($l->status) {
                    'menunggu' => 'bg-warning text-dark',
                    'ditinjau' => 'bg-info text-white',
                    'selesai' => 'bg-success',
                    'ditolak' => 'bg-danger',
                    default => 'bg-secondary',
                };
                return '<span class="badge ' . $badge . '">' . ucfirst($l->status) . '</span>';
            })
            ->addColumn('action', function ($l) {
                return '<button class="btn btn-sm btn-outline-primary detail-whistleblow" data-id="' . $l->id . '">Detail</button>';
            })
            ->filterColumn('terlapor', function ($query, $keyword) {
                $query->whereHas('penerima', fn($q) => $q->where('name', 'like', "%{$keyword}%"));
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function detail(int $id): JsonResponse
    {
        $laporan = LaporanInsiden::with('pelapor', 'penerima')->findOrFail($id);

        if ($laporan->id_pelapor !== auth()->id()) {
            abort(403);
        }

        $badge = match($laporan->status) {
            'menunggu' => 'bg-warning text-dark',
            'ditinjau' => 'bg-info text-white',
            'selesai' => 'bg-success',
            'ditolak' => 'bg-danger',
            default => 'bg-secondary',
        };

        return response()->json([
            'tipe' => $laporan->tipe,
            'deskripsi' => $laporan->deskripsi,
            'status' => ucfirst($laporan->status),
            'status_badge' => $badge,
            'terlapor' => $laporan->penerima?->name ?? null,
            'adalah_anonim' => $laporan->adalah_anonim,
        ]);
    }
}
