<?php

namespace App\Repositories\Eloquent;

use App\Models\DimensiPenilaian;
use App\Repositories\Contracts\DimensiPenilaianRepositoryInterface;
use Illuminate\Support\Collection;

class DimensiPenilaianRepository implements DimensiPenilaianRepositoryInterface
{
    public function all(): Collection
    {
        return DimensiPenilaian::all();
    }

    public function find(int $id): ?DimensiPenilaian
    {
        return DimensiPenilaian::find($id);
    }

    public function create(array $data): DimensiPenilaian
    {
        return DimensiPenilaian::create($data);
    }

    public function update(int $id, array $data): ?DimensiPenilaian
    {
        $model = DimensiPenilaian::find($id);
        if (! $model) {
            return null;
        }
        $model->update($data);
        return $model->fresh();
    }

    public function delete(int $id): bool
    {
        return DimensiPenilaian::destroy($id) > 0;
    }
}
