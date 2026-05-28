<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PengaturanController extends Controller
{
    public function __construct(
        protected UserRepositoryInterface $userRepo,
    ) {}

    public function index()
    {
        return view('pengaturan');
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users,username,' . auth()->id(),
            'email' => 'required|email|unique:users,email,' . auth()->id(),
        ]);

        $this->userRepo->update(auth()->id(), $validated);

        return redirect()->route('pengaturan')->with('success', 'Profil diperbarui.');
    }

    public function updateFoto(Request $request): RedirectResponse
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $user = auth()->user();

        if ($user->foto) {
            Storage::disk('public')->delete($user->foto);
        }

        $path = $request->file('foto')->store('foto-profil', 'public');

        $this->userRepo->update($user->id, ['foto' => $path]);

        return redirect()->route('pengaturan')->with('success', 'Foto profil diperbarui.');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $this->userRepo->update(auth()->id(), [
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('pengaturan')->with('success', 'Kata sandi diubah.');
    }
}
