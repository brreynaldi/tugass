<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ResponBimbinganDariGuru extends Notification
{
    use Queueable;

    protected $bimbingan;
    protected $status;

    public function __construct($bimbingan, $status)
    {
        // Pastikan relasi guru sudah dimuat
        $bimbingan->loadMissing('guru');
        $this->bimbingan = $bimbingan;
        $this->status = $status;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $guruName = $this->bimbingan->guru->name ?? 'Guru';

        return [
            'title' => 'Respon Bimbingan',
            'pesan' => $guruName.' telah '.$this->status.' permintaan bimbingan.',
            'url' => route('bimbingan.chat', $this->bimbingan->id),
        ];
    }
}
