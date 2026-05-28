<?php

namespace App\Repositories\Eloquent;

use App\Models\TransaksiCendol;
use App\Repositories\Contracts\TransaksiCendolRepositoryInterface;
use Illuminate\Support\Collection;

class TransaksiCendolRepository implements TransaksiCendolRepositoryInterface
{
    public function all(): Collection
    {
        return TransaksiCendol::with(['pengirim', 'penerima'])->get();
    }

    public function find(int $id): ?TransaksiCendol
    {
        return TransaksiCendol::with(['pengirim', 'penerima'])->find($id);
    }

    public function create(array $data): TransaksiCendol
    {
        return TransaksiCendol::create($data);
    }

    public function delete(int $id): bool
    {
        return TransaksiCendol::destroy($id) > 0;
    }

    public function findByPengirim(int $idPengirim): Collection
    {
        return TransaksiCendol::with(['pengirim', 'penerima'])
            ->where('id_pengirim', $idPengirim)
            ->get();
    }

    public function findByPenerima(int $idPenerima): Collection
    {
        return TransaksiCendol::with(['pengirim', 'penerima'])
            ->where('id_penerima', $idPenerima)
            ->get();
    }
}
