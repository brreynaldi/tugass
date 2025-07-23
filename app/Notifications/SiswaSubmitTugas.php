<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SiswaSubmitTugas extends Notification
{
    use Queueable;

    protected $siswa;
    protected $tugas;

    public function __construct($siswa, $tugas)
    {
        $this->siswa = $siswa;
        $this->tugas = $tugas;
    }

    public function via($notifiable)
    {
        return ['database']; // atau ['mail', 'database'] jika ingin kirim email juga
    }

    public function toArray($notifiable)
    {
        return [
            'pesan' => "{$this->siswa->name} telah mengumpulkan tugas '{$this->tugas->judul}'"
        ];
    }
}
