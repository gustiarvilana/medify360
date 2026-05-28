<?php

namespace App\Http\Controllers;

use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class LeaderboardController extends Controller
{
    public function index()
    {
        $all = User::with('departemen')
            ->withCount('cendolDiterima')
            ->orderBy('cendol_diterima_count', 'desc')
            ->get();

        $top3 = $all->take(3);

        return view('leaderboard', compact('top3'));
    }

    public function data()
    {
        return DataTables::of(User::with('departemen')->withCount('cendolDiterima'))
            ->addIndexColumn()
            ->editColumn('name', function ($user) {
                return '
                    <div class="d-flex align-items-center gap-2">
                        <img src="https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random&size=32" width="32" class="rounded-circle">
                        <span>' . e($user->name) . '</span>
                    </div>
                ';
            })
            ->editColumn('id_departemen', fn($user) => $user->departemen->nama ?? '-')
            ->addColumn('tren', fn() => '<span class="material-symbols-outlined text-success">trending_up</span>')
            ->rawColumns(['name', 'tren'])
            ->make(true);
    }
}
