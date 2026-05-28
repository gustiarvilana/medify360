<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Penilaian360 extends Model
{
    protected $table = 'penilaian_360';

    protected $fillable = ['id_target', 'id_penilai', 'id_dinilai', 'skor_akhir', 'catatan', 'tanggal_selesai'];

    protected function casts(): array
    {
        return [
            'tanggal_selesai' => 'datetime',
            'skor_akhir' => 'decimal:2',
        ];
    }

    public function target(): BelongsTo
    {
        return $this->belongsTo(TargetPenilaian::class, 'id_target');
    }

    public function penilai(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_penilai');
    }

    public function dinilai(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_dinilai');
    }

    public function skor(): HasMany
    {
        return $this->hasMany(SkorPenilaian::class, 'id_penilaian');
    }
}
