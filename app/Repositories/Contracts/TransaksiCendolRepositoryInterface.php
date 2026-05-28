<?php

namespace App\Repositories\Contracts;

use App\Models\TransaksiCendol;
use Illuminate\Support\Collection;

interface TransaksiCendolRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): ?TransaksiCendol;

    public function create(array $data): TransaksiCendol;

    public function delete(int $id): bool;

    public function findByPengirim(int $idPengirim): Collection;

    public function findByPenerima(int $idPenerima): Collection;
}
