<?php

namespace Database\Factories;

use App\Models\LaporanInsiden;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LaporanInsidenFactory extends Factory
{
    protected $model = LaporanInsiden::class;

    public function definition(): array
    {
        $users = User::pluck('id')->toArray();
        $tipe = fake()->randomElement(['Ketidakhadiran', 'Ketidakjujuran', 'Perilaku', 'Infrastruktur', 'Lainnya']);

        return [
            'id_pelapor' => fake()->randomElement($users),
            'id_penerima' => $tipe === 'Infrastruktur' ? null : fake()->randomElement($users),
            'tipe' => $tipe,
            'deskripsi' => fake()->paragraph(),
            'status' => fake()->randomElement(['menunggu', 'ditinjau', 'selesai', 'ditolak']),
            'adalah_anonim' => fake()->boolean(20),
        ];
    }
}
