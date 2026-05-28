<?php

namespace App\Repositories\Contracts;

use App\Models\BobotRelasi;
use Illuminate\Support\Collection;

interface BobotRelasiRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): ?BobotRelasi;

    public function create(array $data): BobotRelasi;

    public function update(int $id, array $data): ?BobotRelasi;

    public function delete(int $id): bool;
}
