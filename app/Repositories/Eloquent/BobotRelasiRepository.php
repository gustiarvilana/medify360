<?php

namespace App\Repositories\Eloquent;

use App\Models\BobotRelasi;
use App\Repositories\Contracts\BobotRelasiRepositoryInterface;
use Illuminate\Support\Collection;

class BobotRelasiRepository implements BobotRelasiRepositoryInterface
{
    public function all(): Collection
    {
        return BobotRelasi::all();
    }

    public function find(int $id): ?BobotRelasi
    {
        return BobotRelasi::find($id);
    }

    public function create(array $data): BobotRelasi
    {
        return BobotRelasi::create($data);
    }

    public function update(int $id, array $data): ?BobotRelasi
    {
        $model = BobotRelasi::find($id);
        if (! $model) {
            return null;
        }
        $model->update($data);
        return $model->fresh();
    }

    public function delete(int $id): bool
    {
        return BobotRelasi::destroy($id) > 0;
    }
}
