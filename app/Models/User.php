<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'username', 'email', 'password', 'id_departemen', 'id_peran',
        'notif_cendol', 'notif_bata', 'foto',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'notif_cendol' => 'boolean',
            'notif_bata' => 'boolean',
        ];
    }

    public function departemen(): BelongsTo
    {
        return $this->belongsTo(Departemen::class, 'id_departemen');
    }

    public function peran(): BelongsTo
    {
        return $this->belongsTo(Peran::class, 'id_peran');
    }

    public function cendolDiterima(): HasMany
    {
        return $this->hasMany(TransaksiCendol::class, 'id_penerima');
    }

    public function cendolDikirim(): HasMany
    {
        return $this->hasMany(TransaksiCendol::class, 'id_pengirim');
    }

    public function laporanInsiden(): HasMany
    {
        return $this->hasMany(LaporanInsiden::class, 'id_pelapor');
    }

    public function penilaianDiterima(): HasMany
    {
        return $this->hasMany(Penilaian360::class, 'id_dinilai');
    }

    public function sisaBatasWhistleblow(): int
    {
        $batas = $this->peran?->batas_whistleblow;
        if (is_null($batas)) {
            return -1;
        }

        $bulanIni = now()->startOfMonth();
        $terpakai = LaporanInsiden::where('id_pelapor', $this->id)
            ->where('created_at', '>=', $bulanIni)
            ->count();

        return max(0, $batas - $terpakai);
    }

    public function batasWhistleblowTerpakai(): int
    {
        $batas = $this->peran?->batas_whistleblow;
        if (is_null($batas)) {
            return 0;
        }

        return LaporanInsiden::where('id_pelapor', $this->id)
            ->where('created_at', '>=', now()->startOfMonth())
            ->count();
    }
}
