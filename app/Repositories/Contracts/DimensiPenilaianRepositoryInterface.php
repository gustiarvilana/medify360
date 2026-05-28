<?php

namespace App\Repositories\Contracts;

use App\Models\DimensiPenilaian;
use Illuminate\Support\Collection;

interface DimensiPenilaianRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): ?DimensiPenilaian;

    public function create(array $data): DimensiPenilaian;

    public function update(int $id, array $data): ?DimensiPenilaian;

    public function delete(int $id): bool;
}
