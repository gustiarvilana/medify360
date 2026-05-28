<?php

namespace App\Repositories\Json;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    private Collection $users;

    private string $filePath;

    public function __construct()
    {
        $this->filePath = storage_path('app/data/users.json');
        $this->users = $this->load();
    }

    private function load(): Collection
    {
        if (! file_exists($this->filePath)) {
            return collect([]);
        }
        $data = json_decode(file_get_contents($this->filePath), true);
        return collect(array_map(fn ($item) => new User((array) $item), $data));
    }

    private function save(): void
    {
        file_put_contents(
            $this->filePath,
            $this->users->map(fn (User $user) => $user->toArray())->toJson(JSON_PRETTY_PRINT)
        );
    }

    public function all(): Collection
    {
        return $this->users;
    }

    public function find(int $id): ?User
    {
        return $this->users->firstWhere('id', $id);
    }

    public function create(array $data): User
    {
        $data['id'] = ($this->users->max('id') ?? 0) + 1;
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        $user = new User($data);
        $this->users->push($user);
        $this->save();
        return $user;
    }

    public function update(int $id, array $data): ?User
    {
        $user = $this->find($id);
        if (! $user) {
            return null;
        }
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        $user->fill($data);
        $this->save();
        return $user;
    }

    public function delete(int $id): bool
    {
        $found = $this->find($id);
        if (! $found) {
            return false;
        }
        $this->users = $this->users->reject(fn (User $user) => $user->id === $id);
        $this->save();
        return true;
    }

    public function findByEmail(string $email): ?User
    {
        return $this->users->firstWhere('email', $email);
    }
}
