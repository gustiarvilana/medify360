<?php

namespace App\Http\Controllers;

use App\Models\BobotRelasi;
use App\Models\DimensiPenilaian;
use App\Models\Penilaian360;
use App\Models\Peran;
use App\Models\SkorPenilaian;
use App\Models\TargetPenilaian;
use App\Repositories\Contracts\Penilaian360RepositoryInterface;
use App\Repositories\Contracts\SkorPenilaianRepositoryInterface;
use App\Repositories\Contracts\TargetPenilaianRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class Penilaian360Controller extends Controller
{
    public function __construct(
        protected TargetPenilaianRepositoryInterface $targetRepo,
        protected Penilaian360RepositoryInterface $penilaianRepo,
        protected SkorPenilaianRepositoryInterface $skorRepo,
    ) {}

    public function index(): View
    {
        $this->generateTargets(auth()->user());
        return view('penilaian-360.penilaian-index');
    }

    public function data()
    {
        $user = Auth::user();
        $this->generateTargets($user);
        $targets = TargetPenilaian::with(['dinilai.departemen', 'penilaian'])
            ->where('id_penilai', $user->id);

        return DataTables::of($targets)
            ->addColumn('dinilai_nama', fn($row) => $row->dinilai?->name ?? '-')
            ->addColumn('departemen', fn($row) => $row->dinilai?->departemen?->nama ?? '-')
            ->editColumn('status', function ($row) {
                if ($row->penilaian) {
                    return '<span class="badge bg-success">Selesai</span>';
                }
                return '<span class="badge bg-warning text-dark">Menunggu</span>';
            })
            ->addColumn('aksi', function ($row) {
                if ($row->penilaian) {
                    return '<a href="'.route('penilaian-360.show', $row->penilaian->id).'" class="btn btn-sm btn-info"><span class="material-symbols-outlined">visibility</span></a>';
                }
                return '<a href="'.route('penilaian-360.create', $row->id).'" class="btn btn-sm btn-primary"><span class="material-symbols-outlined">rate_review</span></a>';
            })
            ->filterColumn('dinilai_nama', function ($query, $keyword) {
                $query->whereHas('dinilai', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('departemen', function ($query, $keyword) {
                $query->whereHas('dinilai.departemen', function ($q) use ($keyword) {
                    $q->where('nama', 'like', "%{$keyword}%");
                });
            })
            ->rawColumns(['status', 'aksi'])
            ->make(true);
    }

    public function create(int $idTarget): View
    {
        $target = TargetPenilaian::with(['dinilai', 'penilai'])->findOrFail($idTarget);

        if ($target->id_penilai !== Auth::id()) {
            abort(403);
        }

        if ($target->penilaian) {
            return redirect()->route('penilaian-360.show', $target->penilaian->id);
        }

        $dimensi = DimensiPenilaian::orderBy('urutan')->get();

        return view('penilaian-360.penilaian-form', compact('target', 'dimensi'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_target' => 'required|exists:target_penilaian,id',
            'catatan' => 'nullable|string|max:500',
            'skor' => 'required|array',
            'skor.*' => 'required|integer|min:1|max:5',
        ]);

        $target = TargetPenilaian::findOrFail($validated['id_target']);

        if ($target->id_penilai !== Auth::id()) {
            abort(403);
        }

        if ($target->penilaian) {
            return redirect()->route('penilaian-360.show', $target->penilaian->id);
        }

        $penilaian = $this->penilaianRepo->create([
            'id_target' => $target->id,
            'id_penilai' => $target->id_penilai,
            'id_dinilai' => $target->id_dinilai,
            'catatan' => $validated['catatan'],
            'tanggal_selesai' => now(),
        ]);

        foreach ($validated['skor'] as $idDimensi => $skor) {
            $this->skorRepo->create([
                'id_penilaian' => $penilaian->id,
                'id_dimensi' => $idDimensi,
                'skor' => $skor,
            ]);
        }

        $skorAkhir = $this->hitungSkorAkhir($penilaian->id, $target->id_penilai, $target->id_dinilai);

        $this->penilaianRepo->update($penilaian->id, ['skor_akhir' => $skorAkhir]);

        $this->targetRepo->update($target->id, ['status' => 'selesai']);

        return redirect()->route('penilaian-360.index')->with('success', 'Penilaian 360 berhasil disimpan.');
    }

    public function show(int $id): View
    {
        $penilaian = Penilaian360::with([
            'target', 'penilai', 'dinilai',
            'skor.dimensi',
        ])->findOrFail($id);

        if ($penilaian->id_penilai !== Auth::id() && $penilaian->id_dinilai !== Auth::id() && Auth::user()->id_peran !== 3) {
            abort(403);
        }

        return view('penilaian-360.penilaian-detail', compact('penilaian'));
    }

    public function bobotIndex(): View
    {
        $this->generateBobotRelasi();
        $bobot = BobotRelasi::with(['peranPenilai', 'peranDinilai'])->get();
        $peran = Peran::all();
        return view('penilaian-360.bobot', compact('bobot', 'peran'));
    }

    public function bobotUpdate(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'bobot' => 'required|array',
            'bobot.*' => 'required|numeric|min:0|max:10',
        ]);

        foreach ($validated['bobot'] as $id => $nilai) {
            BobotRelasi::where('id', $id)->update(['bobot' => $nilai]);
        }

        return redirect()->route('bobot.index')->with('success', 'Bobot penilaian berhasil diperbarui.');
    }

    public function dimensiIndex(): View
    {
        $dimensi = DimensiPenilaian::orderBy('urutan')->get();
        return view('penilaian-360.dimensi', compact('dimensi'));
    }

    public function dimensiStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'deskripsi' => 'nullable|string|max:255',
            'urutan' => 'required|integer|min:1|max:99',
        ]);

        DimensiPenilaian::create($validated);

        return redirect()->route('dimensi.index')->with('success', 'Dimensi penilaian berhasil ditambahkan.');
    }

    public function dimensiUpdate(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'deskripsi' => 'nullable|string|max:255',
            'urutan' => 'required|integer|min:1|max:99',
        ]);

        $dimensi = DimensiPenilaian::findOrFail($id);
        $dimensi->update($validated);

        return redirect()->route('dimensi.index')->with('success', 'Dimensi penilaian berhasil diperbarui.');
    }

    public function dimensiDestroy(int $id): RedirectResponse
    {
        $dimensi = DimensiPenilaian::findOrFail($id);
        $dimensi->delete();

        return redirect()->route('dimensi.index')->with('success', 'Dimensi penilaian berhasil dihapus.');
    }

    protected function hitungSkorAkhir(int $idPenilaian, int $idPenilai, int $idDinilai): float
    {
        $skorList = SkorPenilaian::where('id_penilaian', $idPenilaian)->get();
        $totalSkor = $skorList->sum('skor');
        $jumlahDimensi = $skorList->count();

        if ($jumlahDimensi === 0) {
            return 0;
        }

        $rataDimensi = $totalSkor / $jumlahDimensi;

        $bobotRelasi = BobotRelasi::where('id_peran_penilai', $idPenilai)
            ->where('id_peran_dinilai', $idDinilai)
            ->first();

        $bobot = $bobotRelasi?->bobot ?? 1.0;

        return round($rataDimensi * $bobot, 2);
    }

    protected function generateBobotRelasi(): void
    {
        $peran = Peran::all();

        foreach ($peran as $penilai) {
            foreach ($peran as $dinilai) {
                $exists = BobotRelasi::where('id_peran_penilai', $penilai->id)
                    ->where('id_peran_dinilai', $dinilai->id)
                    ->exists();

                if (! $exists) {
                    BobotRelasi::create([
                        'id_peran_penilai' => $penilai->id,
                        'id_peran_dinilai' => $dinilai->id,
                        'bobot' => 1.00,
                    ]);
                }
            }
        }
    }

    protected function generateTargets($user): void
    {
        $existing = TargetPenilaian::where('id_penilai', $user->id)->count();
        if ($existing > 0) {
            return;
        }

        $allUsers = \App\Models\User::with('peran', 'departemen')->where('id', '!=', $user->id)->get();
        $targets = [];

        foreach ($allUsers as $dinilai) {
            if ($dinilai->id_departemen !== $user->id_departemen) {
                continue;
            }

            if ($user->id_peran === 3) {
                $targets[] = ['id_penilai' => $user->id, 'id_dinilai' => $dinilai->id, 'status' => 'menunggu'];
            } elseif ($user->id_peran === 2 && $dinilai->id_peran === 1) {
                $targets[] = ['id_penilai' => $user->id, 'id_dinilai' => $dinilai->id, 'status' => 'menunggu'];
            } elseif ($user->id_peran === 1 && $dinilai->id_peran === 1) {
                $targets[] = ['id_penilai' => $user->id, 'id_dinilai' => $dinilai->id, 'status' => 'menunggu'];
            }
        }

        foreach ($targets as $t) {
            $this->targetRepo->create($t);
        }
    }
}
