<?php

namespace App\Providers;

use App\Repositories\Contracts\BobotRelasiRepositoryInterface;
use App\Repositories\Contracts\DepartemenRepositoryInterface;
use App\Repositories\Contracts\DimensiPenilaianRepositoryInterface;
use App\Repositories\Contracts\LaporanInsidenRepositoryInterface;
use App\Repositories\Contracts\Penilaian360RepositoryInterface;
use App\Repositories\Contracts\PeranRepositoryInterface;
use App\Repositories\Contracts\SkorPenilaianRepositoryInterface;
use App\Repositories\Contracts\TargetPenilaianRepositoryInterface;
use App\Repositories\Contracts\TransaksiCendolRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Eloquent\BobotRelasiRepository;
use App\Repositories\Eloquent\DepartemenRepository;
use App\Repositories\Eloquent\DimensiPenilaianRepository;
use App\Repositories\Eloquent\LaporanInsidenRepository;
use App\Repositories\Eloquent\Penilaian360Repository;
use App\Repositories\Eloquent\PeranRepository;
use App\Repositories\Eloquent\SkorPenilaianRepository;
use App\Repositories\Eloquent\TargetPenilaianRepository;
use App\Repositories\Eloquent\TransaksiCendolRepository;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(DepartemenRepositoryInterface::class, DepartemenRepository::class);
        $this->app->bind(PeranRepositoryInterface::class, PeranRepository::class);
        $this->app->bind(TransaksiCendolRepositoryInterface::class, TransaksiCendolRepository::class);
        $this->app->bind(LaporanInsidenRepositoryInterface::class, LaporanInsidenRepository::class);
        $this->app->bind(DimensiPenilaianRepositoryInterface::class, DimensiPenilaianRepository::class);
        $this->app->bind(BobotRelasiRepositoryInterface::class, BobotRelasiRepository::class);
        $this->app->bind(TargetPenilaianRepositoryInterface::class, TargetPenilaianRepository::class);
        $this->app->bind(Penilaian360RepositoryInterface::class, Penilaian360Repository::class);
        $this->app->bind(SkorPenilaianRepositoryInterface::class, SkorPenilaianRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
