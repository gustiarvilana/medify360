<?php

namespace Database\Seeders;

use App\Models\LaporanInsiden;
use App\Models\TransaksiCendol;
use App\Models\User;
use Database\Seeders\Penilaian360Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            DepartemenSeeder::class,
            PeranSeeder::class,
        ]);

        // --- Departemen 1: Teknologi Informasi ---
        User::factory()->create(['name' => 'Admin TI',          'email' => 'admin@medify360.com',     'id_departemen' => 1, 'id_peran' => 3]);
        User::factory()->create(['name' => 'Budi Santoso',      'email' => 'budi@medify360.com',      'id_departemen' => 1, 'id_peran' => 2]);
        User::factory()->create(['name' => 'Citra Dewi',        'email' => 'citra@medify360.com',     'id_departemen' => 1, 'id_peran' => 1]);
        User::factory()->create(['name' => 'Dimas Ardiansyah',  'email' => 'dimas@medify360.com',     'id_departemen' => 1, 'id_peran' => 1]);
        User::factory()->create(['name' => 'Fitria Hasanah',    'email' => 'fitria@medify360.com',    'id_departemen' => 1, 'id_peran' => 1]);

        // --- Departemen 2: Sumber Daya Manusia ---
        User::factory()->create(['name' => 'Bambang Sutejo',    'email' => 'bambang@medify360.com',   'id_departemen' => 2, 'id_peran' => 2]);
        User::factory()->create(['name' => 'Dedi Kusnandar',    'email' => 'dedi@medify360.com',      'id_departemen' => 2, 'id_peran' => 1]);
        User::factory()->create(['name' => 'Eka Putri',         'email' => 'eka@medify360.com',       'id_departemen' => 2, 'id_peran' => 1]);
        User::factory()->create(['name' => 'Gilang Pratama',    'email' => 'gilang@medify360.com',    'id_departemen' => 2, 'id_peran' => 1]);

        // --- Departemen 3: Keuangan ---
        User::factory()->create(['name' => 'Hendra Gunawan',    'email' => 'hendra@medify360.com',    'id_departemen' => 3, 'id_peran' => 2]);
        User::factory()->create(['name' => 'Indah Lestari',     'email' => 'indah@medify360.com',     'id_departemen' => 3, 'id_peran' => 1]);
        User::factory()->create(['name' => 'Joko Susilo',       'email' => 'joko@medify360.com',      'id_departemen' => 3, 'id_peran' => 1]);
        User::factory()->create(['name' => 'Kartika Sari',      'email' => 'kartika@medify360.com',   'id_departemen' => 3, 'id_peran' => 1]);

        // --- Departemen 4: Operasional ---
        User::factory()->create(['name' => 'Lutfi Hidayat',     'email' => 'lutfi@medify360.com',     'id_departemen' => 4, 'id_peran' => 2]);
        User::factory()->create(['name' => 'Maya Anggraini',    'email' => 'maya@medify360.com',      'id_departemen' => 4, 'id_peran' => 1]);
        User::factory()->create(['name' => 'Nanda Pratama',     'email' => 'nanda@medify360.com',     'id_departemen' => 4, 'id_peran' => 1]);
        User::factory()->create(['name' => 'Oscar Wirawan',     'email' => 'oscar@medify360.com',     'id_departemen' => 4, 'id_peran' => 1]);

        // --- Departemen 5: Pemasaran ---
        User::factory()->create(['name' => 'Putri Wulandari',   'email' => 'putri@medify360.com',     'id_departemen' => 5, 'id_peran' => 2]);
        User::factory()->create(['name' => 'Rian Putra',        'email' => 'rian@medify360.com',      'id_departemen' => 5, 'id_peran' => 1]);
        User::factory()->create(['name' => 'Siska Putri',       'email' => 'siska@medify360.com',     'id_departemen' => 5, 'id_peran' => 1]);
        User::factory()->create(['name' => 'Ani Wijaya',        'email' => 'ani@medify360.com',       'id_departemen' => 5, 'id_peran' => 1]);

        // --- Existing seeding ---
        $this->call(Penilaian360Seeder::class);
        $this->call(DataPenilaianSeeder::class);

        TransaksiCendol::factory()->count(25)->create();
        LaporanInsiden::factory()->count(10)->create();
    }
}
