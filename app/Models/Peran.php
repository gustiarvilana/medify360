<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Peran extends Model
{
    use HasFactory;

    protected $table = 'peran';

    protected $fillable = ['nama', 'batas_whistleblow'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'id_peran');
    }
}
