<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\CendolReceived;
use App\Repositories\Contracts\TransaksiCendolRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CendolController extends Controller
{
    public function __construct(
        protected TransaksiCendolRepositoryInterface $cendolRepo,
        protected UserRepositoryInterface $userRepo,
    ) {}

    public function index()
    {
        $cendol = $this->cendolRepo->all()->sortByDesc('created_at');
        return view('cendol.index', compact('cendol'));
    }

    public function create()
    {
        $users = $this->userRepo->all()->where('id', '!=', auth()->id());
        return view('cendol.create', compact('users'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_penerima' => 'required|exists:users,id',
            'kategori' => 'required|string|max:255',
            'pesan' => 'nullable|string|max:1000',
        ]);

        $validated['id_pengirim'] = auth()->id();
        $validated['waktu_transaksi'] = now();

        $transaksi = $this->cendolRepo->create($validated);

        $penerima = User::find($transaksi->id_penerima);
        if ($penerima && $penerima->notif_cendol) {
            $penerima->notify(new CendolReceived($transaksi));
        }

        return redirect()->route('dashboard')->with('success', 'Cendol berhasil dikirim!');
    }

    public function kirim(Request $request): RedirectResponse
    {
        return $this->store($request);
    }
}
