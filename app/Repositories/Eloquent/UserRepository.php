<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Collection;

class UserRepository implements UserRepositoryInterface
{
    public function all(): Collection
    {
        return User::with(['departemen', 'peran'])->get();
    }

    public function find(int $id): ?User
    {
        return User::with(['departemen', 'peran'])->find($id);
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function update(int $id, array $data): ?User
    {
        $user = User::find($id);
        if (! $user) {
            return null;
        }
        $user->update($data);
        return $user->fresh()->load(['departemen', 'peran']);
    }

    public function delete(int $id): bool
    {
        return User::destroy($id) > 0;
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }
}
