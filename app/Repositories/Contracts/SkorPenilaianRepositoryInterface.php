<?php

namespace App\Repositories\Contracts;

use App\Models\SkorPenilaian;
use Illuminate\Support\Collection;

interface SkorPenilaianRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): ?SkorPenilaian;

    public function create(array $data): SkorPenilaian;

    public function update(int $id, array $data): ?SkorPenilaian;

    public function delete(int $id): bool;
}
