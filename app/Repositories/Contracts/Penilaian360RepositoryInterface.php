<?php

namespace App\Repositories\Contracts;

use App\Models\Penilaian360;
use Illuminate\Support\Collection;

interface Penilaian360RepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): ?Penilaian360;

    public function create(array $data): Penilaian360;

    public function update(int $id, array $data): ?Penilaian360;

    public function delete(int $id): bool;
}
