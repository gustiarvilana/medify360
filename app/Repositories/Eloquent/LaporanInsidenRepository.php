<?php

namespace App\Repositories\Eloquent;

use App\Models\LaporanInsiden;
use App\Repositories\Contracts\LaporanInsidenRepositoryInterface;
use Illuminate\Support\Collection;

class LaporanInsidenRepository implements LaporanInsidenRepositoryInterface
{
    public function all(): Collection
    {
        return LaporanInsiden::with('pelapor')->get();
    }

    public function find(int $id): ?LaporanInsiden
    {
        return LaporanInsiden::with('pelapor')->find($id);
    }

    public function create(array $data): LaporanInsiden
    {
        return LaporanInsiden::create($data);
    }

    public function update(int $id, array $data): ?LaporanInsiden
    {
        $laporan = LaporanInsiden::find($id);
        if (! $laporan) {
            return null;
        }
        $laporan->update($data);
        return $laporan->fresh()->load('pelapor');
    }

    public function delete(int $id): bool
    {
        return LaporanInsiden::destroy($id) > 0;
    }

    public function findByPelapor(int $idPelapor): Collection
    {
        return LaporanInsiden::with('pelapor')
            ->where('id_pelapor', $idPelapor)
            ->get();
    }

    public function findByStatus(string $status): Collection
    {
        return LaporanInsiden::with('pelapor')
            ->where('status', $status)
            ->get();
    }
}
