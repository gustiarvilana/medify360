<?php

namespace App\Repositories\Json;

use App\Models\Departemen;
use App\Repositories\Contracts\DepartemenRepositoryInterface;
use Illuminate\Support\Collection;

class DepartemenRepository implements DepartemenRepositoryInterface
{
    private Collection $items;
    private string $filePath;

    public function __construct()
    {
        $this->filePath = storage_path('app/data/departemen.json');
        $this->items = $this->load();
    }

    private function load(): Collection
    {
        if (! file_exists($this->filePath)) {
            return collect([]);
        }
        $data = json_decode(file_get_contents($this->filePath), true);
        return collect(array_map(fn ($item) => new Departemen($item), $data));
    }

    private function save(): void
    {
        file_put_contents(
            $this->filePath,
            $this->items->map(fn (Departemen $m) => $m->toArray())->toJson(JSON_PRETTY_PRINT)
        );
    }

    public function all(): Collection
    {
        return $this->items;
    }

    public function find(int $id): ?Departemen
    {
        return $this->items->firstWhere('id', $id);
    }

    public function create(array $data): Departemen
    {
        $data['id'] = ($this->items->max('id') ?? 0) + 1;
        $model = new Departemen($data);
        $this->items->push($model);
        $this->save();
        return $model;
    }

    public function update(int $id, array $data): ?Departemen
    {
        $model = $this->find($id);
        if (! $model) return null;
        $model->fill($data);
        $this->save();
        return $model;
    }

    public function delete(int $id): bool
    {
        $found = $this->find($id);
        if (! $found) return false;
        $this->items = $this->items->reject(fn (Departemen $m) => $m->id === $id);
        $this->save();
        return true;
    }
}
