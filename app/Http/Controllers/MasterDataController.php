<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\Peran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MasterDataController extends Controller
{
    public function jabatanIndex(): View
    {
        $jabatan = Peran::withCount('users')->get();
        return view('master-data.jabatan', compact('jabatan'));
    }

    public function jabatanStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:50|unique:peran,nama',
            'batas_whistleblow' => 'nullable|integer|min:0',
        ]);

        Peran::create($validated);

        return redirect()->route('master.jabatan')->with('success', 'Jabatan berhasil ditambahkan.');
    }

    public function jabatanUpdate(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:50|unique:peran,nama,'.$id,
            'batas_whistleblow' => 'nullable|integer|min:0',
        ]);

        $jabatan = Peran::findOrFail($id);
        $jabatan->update($validated);

        return redirect()->route('master.jabatan')->with('success', 'Jabatan berhasil diperbarui.');
    }

    public function jabatanDestroy(int $id): RedirectResponse
    {
        $jabatan = Peran::findOrFail($id);
        if ($jabatan->users()->exists()) {
            return back()->with('error', 'Jabatan masih memiliki user, tidak bisa dihapus.');
        }
        $jabatan->delete();

        return redirect()->route('master.jabatan')->with('success', 'Jabatan berhasil dihapus.');
    }

    public function departemenIndex(): View
    {
        $departemen = Departemen::withCount('users')->get();
        return view('master-data.departemen', compact('departemen'));
    }

    public function departemenStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:50|unique:departemen,nama',
        ]);

        Departemen::create($validated);

        return redirect()->route('master.departemen')->with('success', 'Departemen berhasil ditambahkan.');
    }

    public function departemenUpdate(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:50|unique:departemen,nama,'.$id,
        ]);

        $departemen = Departemen::findOrFail($id);
        $departemen->update($validated);

        return redirect()->route('master.departemen')->with('success', 'Departemen berhasil diperbarui.');
    }

    public function departemenDestroy(int $id): RedirectResponse
    {
        $departemen = Departemen::findOrFail($id);
        if ($departemen->users()->exists()) {
            return back()->with('error', 'Departemen masih memiliki user, tidak bisa dihapus.');
        }
        $departemen->delete();

        return redirect()->route('master.departemen')->with('success', 'Departemen berhasil dihapus.');
    }
}
