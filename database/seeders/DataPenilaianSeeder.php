<?php

namespace Database\Seeders;

use App\Models\DimensiPenilaian;
use App\Models\Penilaian360;
use App\Models\SkorPenilaian;
use App\Models\TargetPenilaian;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DataPenilaianSeeder extends Seeder
{
    public function run(): void
    {
        $dimensi = DimensiPenilaian::all()->keyBy('nama');
        $tgl = Carbon::now()->subDays(rand(1, 30));

        // --- TI: Budi (Manajer) nilai staff ---
        $budi = User::where('email', 'budi@stitch360.com')->first();
        $staffTi = User::whereIn('email', ['citra@stitch360.com', 'dimas@stitch360.com', 'fitria@stitch360.com'])->get();

        foreach ($staffTi as $staff) {
            $this->buatPenilaian($budi, $staff, $dimensi, $tgl, 'Baik, terus pertahankan.');
            $tgl = $tgl->addDay();
        }

        // --- TI: Staff nilai staff ---
        $citra = User::where('email', 'citra@stitch360.com')->first();
        $dimas = User::where('email', 'dimas@stitch360.com')->first();
        $fitria = User::where('email', 'fitria@stitch360.com')->first();

        $this->buatPenilaian($citra, $dimas, $dimensi, $tgl, 'Kompak dalam kerja tim.');
        $tgl = $tgl->addDay();
        $this->buatPenilaian($citra, $fitria, $dimensi, $tgl, 'Cekatan dan rapi.');
        $tgl = $tgl->addDay();
        $this->buatPenilaian($dimas, $citra, $dimensi, $tgl, 'Komunikatif dan solutif.');
        $tgl = $tgl->addDay();
        $this->buatPenilaian($dimas, $fitria, $dimensi, $tgl, 'Kerja keras dan disiplin.');
        $tgl = $tgl->addDay();

        // --- TI: Budi nilai Citra lebih awal (ada 2 penilaian buat Citra) ---
        $this->buatPenilaian($budi, $citra, $dimensi, $tgl, 'Potensi besar untuk dikembangkan.');
        $tgl = $tgl->addDay();

        // --- SDM: Bambang (Manajer) nilai staff ---
        $bambang = User::where('email', 'bambang@stitch360.com')->first();
        $staffSdm = User::whereIn('email', ['dedi@stitch360.com', 'eka@stitch360.com', 'gilang@stitch360.com'])->get();

        foreach ($staffSdm as $staff) {
            $this->buatPenilaian($bambang, $staff, $dimensi, $tgl, 'Sudah menunjukkan perkembangan.');
            $tgl = $tgl->addDay();
        }

        // --- SDM: Staff nilai staff ---
        $dedi = User::where('email', 'dedi@stitch360.com')->first();
        $eka = User::where('email', 'eka@stitch360.com')->first();
        $gilang = User::where('email', 'gilang@stitch360.com')->first();

        $this->buatPenilaian($dedi, $eka, $dimensi, $tgl, 'Teliti dan bertanggung jawab.');
        $tgl = $tgl->addDay();
        $this->buatPenilaian($dedi, $gilang, $dimensi, $tgl, 'Mudah diajak kerja sama.');
        $tgl = $tgl->addDay();
        $this->buatPenilaian($eka, $dedi, $dimensi, $tgl, 'Pengalaman dan wawasan luas.');
        $tgl = $tgl->addDay();
        $this->buatPenilaian($eka, $gilang, $dimensi, $tgl, 'Cepat belajar hal baru.');
        $tgl = $tgl->addDay();

        // --- Keuangan: Hendra nilai staff ---
        $hendra = User::where('email', 'hendra@stitch360.com')->first();
        $staffKeu = User::whereIn('email', ['indah@stitch360.com', 'joko@stitch360.com', 'kartika@stitch360.com'])->get();

        foreach ($staffKeu as $staff) {
            $this->buatPenilaian($hendra, $staff, $dimensi, $tgl, 'Akurat dan tepat waktu.');
            $tgl = $tgl->addDay();
        }

        // --- Keuangan: Staff nilai staff ---
        $indah = User::where('email', 'indah@stitch360.com')->first();
        $joko = User::where('email', 'joko@stitch360.com')->first();
        $this->buatPenilaian($indah, $joko, $dimensi, $tgl, 'Solid dalam tim.');
        $tgl = $tgl->addDay();
        $this->buatPenilaian($joko, $indah, $dimensi, $tgl, 'Rapi dan sistematis.');
        $tgl = $tgl->addDay();

        // --- Operasional: Lutfi nilai staff ---
        $lutfi = User::where('email', 'lutfi@stitch360.com')->first();
        $this->buatPenilaian($lutfi, User::where('email', 'maya@stitch360.com')->first(), $dimensi, $tgl, 'Sigap di lapangan.');
        $tgl = $tgl->addDay();
        $this->buatPenilaian($lutfi, User::where('email', 'nanda@stitch360.com')->first(), $dimensi, $tgl, 'Disiplin dan teratur.');
        $tgl = $tgl->addDay();
        // Oscar belum dinilai — biar ada variasi

        // --- Pemasaran: Staff nilai staff ---
        $rian = User::where('email', 'rian@stitch360.com')->first();
        $siska = User::where('email', 'siska@stitch360.com')->first();
        $ani = User::where('email', 'ani@stitch360.com')->first();
        $this->buatPenilaian($rian, $siska, $dimensi, $tgl, 'Kreatif dan inovatif.');
        $tgl = $tgl->addDay();
        $this->buatPenilaian($siska, $ani, $dimensi, $tgl, 'Komunikasi pemasaran bagus.');
        $tgl = $tgl->addDay();
        $this->buatPenilaian($ani, $rian, $dimensi, $tgl, 'Analisa pasar tajam.');
        $tgl = $tgl->addDay();
    }

    protected function buatPenilaian(User $penilai, User $dinilai, $dimensi, Carbon $tgl, string $catatan): void
    {
        $target = TargetPenilaian::firstOrCreate(
            ['id_penilai' => $penilai->id, 'id_dinilai' => $dinilai->id],
            ['status' => 'selesai']
        );

        TargetPenilaian::where('id_penilai', $penilai->id)
            ->where('id_dinilai', $dinilai->id)
            ->update(['status' => 'selesai']);

        $penilaian = Penilaian360::create([
            'id_target' => $target->id,
            'id_penilai' => $penilai->id,
            'id_dinilai' => $dinilai->id,
            'skor_akhir' => 0,
            'catatan' => $catatan,
            'tanggal_selesai' => $tgl,
        ]);

        $totalSkor = 0;
        $urutan = [1, 2, 3, 4, 5];
        foreach ($urutan as $i) {
            $skor = rand(2, 5);
            $namaDimensi = match ($i) {
                1 => 'Kepemimpinan',
                2 => 'Kerjasama',
                3 => 'Komunikasi',
                4 => 'Inisiatif',
                5 => 'Kualitas Kerja',
            };
            SkorPenilaian::create([
                'id_penilaian' => $penilaian->id,
                'id_dimensi' => $dimensi[$namaDimensi]->id,
                'skor' => $skor,
            ]);
            $totalSkor += $skor;
        }

        $rataRata = $totalSkor / 5;
        $bobotRelasi = \App\Models\BobotRelasi::where('id_peran_penilai', $penilai->id_peran)
            ->where('id_peran_dinilai', $dinilai->id_peran)
            ->first();
        $bobot = $bobotRelasi?->bobot ?? 1.00;

        $penilaian->update(['skor_akhir' => round($rataRata * $bobot, 2)]);
    }
}
