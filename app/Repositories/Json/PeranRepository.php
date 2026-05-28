<?php

namespace App\Repositories\Json;

use App\Models\Peran;
use App\Repositories\Contracts\PeranRepositoryInterface;
use Illuminate\Support\Collection;

class PeranRepository implements PeranRepositoryInterface
{
    private Collection $items;
    private string $filePath;

    public function __construct()
    {
        $this->filePath = storage_path('app/data/peran.json');
        $this->items = $this->load();
    }

    private function load(): Collection
    {
        if (! file_exists($this->filePath)) {
            return collect([]);
        }
        $data = json_decode(file_get_contents($this->filePath), true);
        return collect(array_map(fn ($item) => new Peran($item), $data));
    }

    private function save(): void
    {
        file_put_contents(
            $this->filePath,
            $this->items->map(fn (Peran $m) => $m->toArray())->toJson(JSON_PRETTY_PRINT)
        );
    }

    public function all(): Collection
    {
        return $this->items;
    }

    public function find(int $id): ?Peran
    {
        return $this->items->firstWhere('id', $id);
    }

    public function create(array $data): Peran
    {
        $data['id'] = ($this->items->max('id') ?? 0) + 1;
        $model = new Peran($data);
        $this->items->push($model);
        $this->save();
        return $model;
    }

    public function update(int $id, array $data): ?Peran
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
        $this->items = $this->items->reject(fn (Peran $m) => $m->id === $id);
        $this->save();
        return true;
    }
}
