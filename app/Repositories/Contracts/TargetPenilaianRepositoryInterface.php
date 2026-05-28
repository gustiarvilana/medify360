<?php

namespace App\Repositories\Contracts;

use App\Models\TargetPenilaian;
use Illuminate\Support\Collection;

interface TargetPenilaianRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): ?TargetPenilaian;

    public function create(array $data): TargetPenilaian;

    public function update(int $id, array $data): ?TargetPenilaian;

    public function delete(int $id): bool;
}
