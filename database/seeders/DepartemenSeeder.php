<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartemenSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('departemen')->insert([
            ['nama' => 'Teknologi Informasi'],
            ['nama' => 'Sumber Daya Manusia'],
            ['nama' => 'Keuangan'],
            ['nama' => 'Operasional'],
            ['nama' => 'Pemasaran'],
        ]);
    }
}
