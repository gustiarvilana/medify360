<?php

namespace App\Repositories\Eloquent;

use App\Models\Peran;
use App\Repositories\Contracts\PeranRepositoryInterface;
use Illuminate\Support\Collection;

class PeranRepository implements PeranRepositoryInterface
{
    public function all(): Collection
    {
        return Peran::all();
    }

    public function find(int $id): ?Peran
    {
        return Peran::find($id);
    }

    public function create(array $data): Peran
    {
        return Peran::create($data);
    }

    public function update(int $id, array $data): ?Peran
    {
        $peran = Peran::find($id);
        if (! $peran) {
            return null;
        }
        $peran->update($data);
        return $peran->fresh();
    }

    public function delete(int $id): bool
    {
        return Peran::destroy($id) > 0;
    }
}
