<?php

namespace App\Repositories\Eloquent;

use App\Models\Penilaian360;
use App\Repositories\Contracts\Penilaian360RepositoryInterface;
use Illuminate\Support\Collection;

class Penilaian360Repository implements Penilaian360RepositoryInterface
{
    public function all(): Collection
    {
        return Penilaian360::all();
    }

    public function find(int $id): ?Penilaian360
    {
        return Penilaian360::find($id);
    }

    public function create(array $data): Penilaian360
    {
        return Penilaian360::create($data);
    }

    public function update(int $id, array $data): ?Penilaian360
    {
        $model = Penilaian360::find($id);
        if (! $model) {
            return null;
        }
        $model->update($data);
        return $model->fresh();
    }

    public function delete(int $id): bool
    {
        return Penilaian360::destroy($id) > 0;
    }
}
