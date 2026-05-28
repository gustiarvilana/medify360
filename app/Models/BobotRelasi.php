<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BobotRelasi extends Model
{
    protected $table = 'bobot_relasi';

    protected $fillable = ['id_peran_penilai', 'id_peran_dinilai', 'bobot'];

    public function peranPenilai(): BelongsTo
    {
        return $this->belongsTo(Peran::class, 'id_peran_penilai');
    }

    public function peranDinilai(): BelongsTo
    {
        return $this->belongsTo(Peran::class, 'id_peran_dinilai');
    }
}
