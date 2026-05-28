<?php

namespace Database\Seeders;

use App\Models\BobotRelasi;
use App\Models\DimensiPenilaian;
use Illuminate\Database\Seeder;

class Penilaian360Seeder extends Seeder
{
    public function run(): void
    {
        $dimensi = [
            ['nama' => 'Kepemimpinan', 'deskripsi' => 'Kemampuan memimpin dan mengarahkan tim', 'urutan' => 1],
            ['nama' => 'Kerjasama', 'deskripsi' => 'Kemampuan bekerja dalam tim', 'urutan' => 2],
            ['nama' => 'Komunikasi', 'deskripsi' => 'Kemampuan menyampaikan ide dan informasi', 'urutan' => 3],
            ['nama' => 'Inisiatif', 'deskripsi' => 'Kemampuan bertindak proaktif', 'urutan' => 4],
            ['nama' => 'Kualitas Kerja', 'deskripsi' => 'Ketelitian dan mutu hasil kerja', 'urutan' => 5],
        ];

        foreach ($dimensi as $item) {
            DimensiPenilaian::create($item);
        }

        $bobot = [
            ['id_peran_penilai' => 1, 'id_peran_dinilai' => 1, 'bobot' => 1.00],
            ['id_peran_penilai' => 1, 'id_peran_dinilai' => 2, 'bobot' => 0.80],
            ['id_peran_penilai' => 1, 'id_peran_dinilai' => 3, 'bobot' => 0.60],
            ['id_peran_penilai' => 2, 'id_peran_dinilai' => 1, 'bobot' => 1.50],
            ['id_peran_penilai' => 2, 'id_peran_dinilai' => 2, 'bobot' => 1.00],
            ['id_peran_penilai' => 2, 'id_peran_dinilai' => 3, 'bobot' => 0.80],
            ['id_peran_penilai' => 3, 'id_peran_dinilai' => 1, 'bobot' => 1.50],
            ['id_peran_penilai' => 3, 'id_peran_dinilai' => 2, 'bobot' => 1.20],
            ['id_peran_penilai' => 3, 'id_peran_dinilai' => 3, 'bobot' => 1.00],
        ];

        foreach ($bobot as $item) {
            BobotRelasi::create($item);
        }
    }
}
