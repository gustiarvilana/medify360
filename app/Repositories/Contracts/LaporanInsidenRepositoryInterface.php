<?php

namespace App\Repositories\Contracts;

use App\Models\LaporanInsiden;
use Illuminate\Support\Collection;

interface LaporanInsidenRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): ?LaporanInsiden;

    public function create(array $data): LaporanInsiden;

    public function update(int $id, array $data): ?LaporanInsiden;

    public function delete(int $id): bool;

    public function findByPelapor(int $idPelapor): Collection;

    public function findByStatus(string $status): Collection;
}
