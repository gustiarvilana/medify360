<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TargetPenilaian extends Model
{
    protected $table = 'target_penilaian';

    protected $fillable = ['id_penilai', 'id_dinilai', 'status'];

    protected function casts(): array
    {
        return [
            'status' => 'string',
        ];
    }

    public function penilai(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_penilai');
    }

    public function dinilai(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_dinilai');
    }

    public function penilaian(): HasOne
    {
        return $this->hasOne(Penilaian360::class, 'id_target');
    }
}
