<?php

namespace App\Notifications;

use App\Models\TransaksiCendol;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CendolReceived extends Notification
{
    use Queueable;

    public function __construct(
        public TransaksiCendol $transaksi,
    ) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'cendol',
            'id_transaksi' => $this->transaksi->id,
            'pengirim' => $this->transaksi->pengirim->name ?? 'User',
            'kategori' => $this->transaksi->kategori,
            'pesan' => $this->transaksi->pesan,
        ];
    }
}
