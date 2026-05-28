<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaporanInsiden extends Model
{
    use HasFactory;

    protected $table = 'laporan_insiden';

    protected $fillable = ['id_pelapor', 'id_penerima', 'tipe', 'deskripsi', 'status', 'adalah_anonim'];

    protected $casts = [
        'adalah_anonim' => 'boolean',
    ];

    public function pelapor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_pelapor');
    }

    public function penerima(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_penerima');
    }
}
