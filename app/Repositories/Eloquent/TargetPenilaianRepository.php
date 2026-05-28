<?php

namespace App\Repositories\Eloquent;

use App\Models\TargetPenilaian;
use App\Repositories\Contracts\TargetPenilaianRepositoryInterface;
use Illuminate\Support\Collection;

class TargetPenilaianRepository implements TargetPenilaianRepositoryInterface
{
    public function all(): Collection
    {
        return TargetPenilaian::all();
    }

    public function find(int $id): ?TargetPenilaian
    {
        return TargetPenilaian::find($id);
    }

    public function create(array $data): TargetPenilaian
    {
        return TargetPenilaian::create($data);
    }

    public function update(int $id, array $data): ?TargetPenilaian
    {
        $model = TargetPenilaian::find($id);
        if (! $model) {
            return null;
        }
        $model->update($data);
        return $model->fresh();
    }

    public function delete(int $id): bool
    {
        return TargetPenilaian::destroy($id) > 0;
    }
}
