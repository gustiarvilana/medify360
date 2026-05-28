<?php

namespace App\Repositories\Contracts;

use App\Models\Departemen;
use Illuminate\Support\Collection;

interface DepartemenRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): ?Departemen;

    public function create(array $data): Departemen;

    public function update(int $id, array $data): ?Departemen;

    public function delete(int $id): bool;
}
