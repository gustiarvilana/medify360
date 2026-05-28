<?php

namespace App\Http\Controllers;

use App\Models\LaporanInsiden;
use App\Models\User;
use App\Notifications\BataStatusUpdated;
use App\Repositories\Contracts\DepartemenRepositoryInterface;
use App\Repositories\Contracts\LaporanInsidenRepositoryInterface;
use App\Repositories\Contracts\PeranRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    public function __construct(
        protected UserRepositoryInterface $userRepo,
        protected DepartemenRepositoryInterface $departemenRepo,
        protected PeranRepositoryInterface $peranRepo,
        protected LaporanInsidenRepositoryInterface $laporanRepo,
    ) {}

    public function index()
    {
        $departemen = $this->departemenRepo->all();
        $peran = $this->peranRepo->all();

        $usersTotal = \App\Models\User::count();
        $adminCount = \App\Models\User::whereHas('peran', fn($q) => $q->where('nama', 'Admin'))->count();
        $manajerCount = \App\Models\User::whereHas('peran', fn($q) => $q->where('nama', 'Manajer'))->count();

        return view('manajemen-user', compact('departemen', 'peran', 'usersTotal', 'adminCount', 'manajerCount'));
    }

    public function data()
    {
        return DataTables::of(\App\Models\User::with(['departemen', 'peran']))
            ->addColumn('action', function ($user) {
                return '

                    <button class="btn btn-sm btn-outline-secondary edit-user"
                        data-id="' . $user->id . '"
                        data-name="' . e($user->name) . '"
                        data-username="' . e($user->username) . '"
                        data-email="' . e($user->email) . '"
                        data-departemen="' . $user->id_departemen . '"
                        data-peran="' . $user->id_peran . '">
                        <span class="material-symbols-outlined" style="font-size: 18px;">edit</span>
                    </button>
                    <form method="POST" action="' . route('manajemen-user.destroy', $user->id) . '" class="d-inline" onsubmit="return confirm(\'Hapus karyawan ini?\')">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <span class="material-symbols-outlined" style="font-size: 18px;">delete</span>
                        </button>
                    </form>
                ';
            })
            ->editColumn('name', function ($user) {
                return '
                    <div class="d-flex align-items-center gap-2">
                        <img src="' . e($user->foto ? asset('storage/' . $user->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random&size=32') . '" width="32" height="32" class="rounded-circle" style="object-fit: cover;">
                        <div>
                            <span class="fw-bold d-block">' . e($user->name) . '</span>
                            <small class="text-muted">@' . e($user->username) . '</small>
                        </div>
                    </div>
                ';
            })
            ->editColumn('id_peran', fn($user) => $user->peran->nama ?? '-')
            ->editColumn('id_departemen', fn($user) => $user->departemen->nama ?? '-')
            ->addColumn('status', fn() => '<span class="badge bg-success-subtle text-success">Aktif</span>')
            ->rawColumns(['action', 'name', 'status'])
            ->make(true);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'id_departemen' => 'nullable|exists:departemen,id',
            'id_peran' => 'nullable|exists:peran,id',
        ]);

        $this->userRepo->create($validated);

        return redirect()->route('manajemen-user')->with('success', 'Karyawan berhasil ditambahkan.');
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'id_departemen' => 'nullable|exists:departemen,id',
            'id_peran' => 'nullable|exists:peran,id',
        ]);

        $this->userRepo->update($id, $validated);

        return redirect()->route('manajemen-user')->with('success', 'Data karyawan diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->userRepo->delete($id);
        return redirect()->route('manajemen-user')->with('success', 'Karyawan dihapus.');
    }

    public function laporanIndex()
    {
        return view('admin-laporan');
    }

    public function laporanData()
    {
        return DataTables::of(LaporanInsiden::with(['pelapor', 'penerima']))
            ->editColumn('created_at', fn($l) => $l->created_at ? $l->created_at->format('d M Y H:i') : '-')
            ->editColumn('id_pelapor', fn($l) => $l->pelapor->name ?? '-')
            ->editColumn('id_penerima', fn($l) => $l->penerima->name ?? '<em class="text-muted">Tidak ada</em>')
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
                return '
                    <button class="btn btn-sm btn-outline-primary update-status"
                        data-id="' . $l->id . '"
                        data-status="' . $l->status . '">
                        <span class="material-symbols-outlined" style="font-size: 18px;">edit</span>
                    </button>
                ';
            })
            ->rawColumns(['status', 'action', 'id_penerima'])
            ->make(true);
    }

    public function laporanUpdateStatus(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:menunggu,ditinjau,selesai,ditolak',
        ]);

        $laporan = $this->laporanRepo->update($id, $validated);

        $pelapor = User::find($laporan->id_pelapor);
        if ($pelapor && $pelapor->notif_bata) {
            $pelapor->notify(new BataStatusUpdated($laporan));
        }

        return back()->with('success', 'Status laporan diperbarui.');
    }
}
