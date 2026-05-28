<?php

namespace App\Repositories\Json;

use App\Models\TransaksiCendol;
use App\Repositories\Contracts\TransaksiCendolRepositoryInterface;
use Illuminate\Support\Collection;

class TransaksiCendolRepository implements TransaksiCendolRepositoryInterface
{
    private Collection $items;
    private string $filePath;

    public function __construct()
    {
        $this->filePath = storage_path('app/data/transaksi_cendol.json');
        $this->items = $this->load();
    }

    private function load(): Collection
    {
        if (! file_exists($this->filePath)) {
            return collect([]);
        }
        $data = json_decode(file_get_contents($this->filePath), true);
        return collect(array_map(fn ($item) => new TransaksiCendol($item), $data));
    }

    private function save(): void
    {
        file_put_contents(
            $this->filePath,
            $this->items->map(fn (TransaksiCendol $m) => $m->toArray())->toJson(JSON_PRETTY_PRINT)
        );
    }

    public function all(): Collection
    {
        return $this->items;
    }

    public function find(int $id): ?TransaksiCendol
    {
        return $this->items->firstWhere('id', $id);
    }

    public function create(array $data): TransaksiCendol
    {
        $data['id'] = ($this->items->max('id') ?? 0) + 1;
        $model = new TransaksiCendol($data);
        $this->items->push($model);
        $this->save();
        return $model;
    }

    public function delete(int $id): bool
    {
        $found = $this->find($id);
        if (! $found) return false;
        $this->items = $this->items->reject(fn (TransaksiCendol $m) => $m->id === $id);
        $this->save();
        return true;
    }

    public function findByPengirim(int $idPengirim): Collection
    {
        return $this->items->where('id_pengirim', $idPengirim);
    }

    public function findByPenerima(int $idPenerima): Collection
    {
        return $this->items->where('id_penerima', $idPenerima);
    }
}
