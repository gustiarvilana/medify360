<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransaksiCendol extends Model
{
    use HasFactory;

    protected $table = 'transaksi_cendol';

    protected $fillable = ['id_pengirim', 'id_penerima', 'kategori', 'pesan', 'waktu_transaksi'];

    protected $casts = [
        'waktu_transaksi' => 'datetime',
    ];

    public function pengirim(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_pengirim');
    }

    public function penerima(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_penerima');
    }
}
