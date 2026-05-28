<?php

namespace App\Notifications;

use App\Models\LaporanInsiden;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BataStatusUpdated extends Notification
{
    use Queueable;

    public function __construct(
        public LaporanInsiden $laporan,
    ) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'bata',
            'id_laporan' => $this->laporan->id,
            'tipe' => $this->laporan->tipe,
            'status' => $this->laporan->status,
        ];
    }
}
