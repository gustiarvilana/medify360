<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DimensiPenilaian extends Model
{
    protected $table = 'dimensi_penilaian';

    protected $fillable = ['nama', 'deskripsi', 'urutan'];

    public function skor(): HasMany
    {
        return $this->hasMany(SkorPenilaian::class, 'id_dimensi');
    }
}
