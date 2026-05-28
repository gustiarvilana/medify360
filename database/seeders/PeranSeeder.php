<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeranSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('peran')->insert([
            ['nama' => 'Karyawan', 'batas_whistleblow' => 5],
            ['nama' => 'Manajer', 'batas_whistleblow' => 10],
            ['nama' => 'Admin', 'batas_whistleblow' => null],
        ]);
    }
}
