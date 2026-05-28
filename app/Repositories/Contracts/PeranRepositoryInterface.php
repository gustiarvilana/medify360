<?php

namespace App\Repositories\Contracts;

use App\Models\Peran;
use Illuminate\Support\Collection;

interface PeranRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): ?Peran;

    public function create(array $data): Peran;

    public function update(int $id, array $data): ?Peran;

    public function delete(int $id): bool;
}
