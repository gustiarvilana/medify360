<?php

namespace App\Http\Controllers;

use App\Models\LaporanInsiden;
use App\Models\TransaksiCendol;
use App\Repositories\Contracts\LaporanInsidenRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LaporanController extends Controller
{
    public function __construct(
        protected LaporanInsidenRepositoryInterface $laporanRepo,
    ) {}

    public function index()
    {
        return view('laporan');
    }

    public function dataLaporan()
    {
        $query = LaporanInsiden::with('pelapor')
            ->where('id_pelapor', auth()->id());

        return DataTables::of($query)
            ->editColumn('created_at', fn($l) => $l->created_at ? $l->created_at->format('d M Y') : '-')
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
                return '<button class="btn btn-sm btn-outline-primary detail-laporan" data-id="' . $l->id . '">Detail</button>';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function detail(int $id): JsonResponse
    {
        $laporan = LaporanInsiden::with('pelapor')->findOrFail($id);

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
        ]);
    }

    public function dataCendol()
    {
        $query = TransaksiCendol::with('pengirim')
            ->where('id_penerima', auth()->id());

        return DataTables::of($query)
            ->editColumn('created_at', fn($c) => $c->created_at ? $c->created_at->format('d M Y H:i') : '-')
            ->editColumn('id_pengirim', fn($c) => $c->pengirim->name ?? '-')
            ->editColumn('pesan', fn($c) => $c->pesan ?? '-')
            ->make(true);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = auth()->user();
        $sisa = $user->sisaBatasWhistleblow();

        if ($sisa === 0) {
            $batas = $user->peran?->batas_whistleblow ?? 0;
            return redirect()->route('laporan')
                ->with('error', "Batas whistleblow bulan ini habis ({$batas} laporan).");
        }

        $validated = $request->validate([
            'id_penerima' => 'nullable|exists:users,id',
            'tipe' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:2000',
            'adalah_anonim' => 'nullable|boolean',
        ]);

        $validated['id_pelapor'] = auth()->id();
        $validated['status'] = 'menunggu';

        $this->laporanRepo->create($validated);

        return redirect()->back()->with('success', 'Bata berhasil dikirim.');
    }
}
