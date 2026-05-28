<?php

namespace Database\Factories;

use App\Models\TransaksiCendol;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransaksiCendolFactory extends Factory
{
    protected $model = TransaksiCendol::class;

    public function definition(): array
    {
        $users = User::pluck('id')->toArray();

        return [
            'id_pengirim' => fake()->randomElement($users),
            'id_penerima' => function (array $attrs) use ($users) {
                $others = array_values(array_filter($users, fn($id) => $id !== $attrs['id_pengirim']));
                return fake()->randomElement($others);
            },
            'kategori' => fake()->randomElement(['Kolaborasi', 'Semangat', 'Inovasi', 'Integritas', 'Ketelitian', 'Disiplin']),
            'pesan' => fake()->sentence(),
            'waktu_transaksi' => fake()->dateTimeBetween('-3 months', 'now'),
        ];
    }
}
