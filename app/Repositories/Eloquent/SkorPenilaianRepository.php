<?php

namespace App\Repositories\Eloquent;

use App\Models\SkorPenilaian;
use App\Repositories\Contracts\SkorPenilaianRepositoryInterface;
use Illuminate\Support\Collection;

class SkorPenilaianRepository implements SkorPenilaianRepositoryInterface
{
    public function all(): Collection
    {
        return SkorPenilaian::all();
    }

    public function find(int $id): ?SkorPenilaian
    {
        return SkorPenilaian::find($id);
    }

    public function create(array $data): SkorPenilaian
    {
        return SkorPenilaian::create($data);
    }

    public function update(int $id, array $data): ?SkorPenilaian
    {
        $model = SkorPenilaian::find($id);
        if (! $model) {
            return null;
        }
        $model->update($data);
        return $model->fresh();
    }

    public function delete(int $id): bool
    {
        return SkorPenilaian::destroy($id) > 0;
    }
}
