<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SkorPenilaian extends Model
{
    protected $table = 'skor_penilaian';

    protected $fillable = ['id_penilaian', 'id_dimensi', 'skor'];

    protected function casts(): array
    {
        return [
            'skor' => 'integer',
        ];
    }

    public function penilaian(): BelongsTo
    {
        return $this->belongsTo(Penilaian360::class, 'id_penilaian');
    }

    public function dimensi(): BelongsTo
    {
        return $this->belongsTo(DimensiPenilaian::class, 'id_dimensi');
    }
}
