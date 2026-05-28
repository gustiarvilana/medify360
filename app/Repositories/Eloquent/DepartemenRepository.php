<?php

namespace App\Repositories\Eloquent;

use App\Models\Departemen;
use App\Repositories\Contracts\DepartemenRepositoryInterface;
use Illuminate\Support\Collection;

class DepartemenRepository implements DepartemenRepositoryInterface
{
    public function all(): Collection
    {
        return Departemen::all();
    }

    public function find(int $id): ?Departemen
    {
        return Departemen::find($id);
    }

    public function create(array $data): Departemen
    {
        return Departemen::create($data);
    }

    public function update(int $id, array $data): ?Departemen
    {
        $departemen = Departemen::find($id);
        if (! $departemen) {
            return null;
        }
        $departemen->update($data);
        return $departemen->fresh();
    }

    public function delete(int $id): bool
    {
        return Departemen::destroy($id) > 0;
    }
}
