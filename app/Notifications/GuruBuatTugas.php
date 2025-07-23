<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class GuruBuatTugas extends Notification
{
    use Queueable;

    protected $guru;
    protected $tugas;

    public function __construct($guru, $tugas)
    {
        $this->guru = $guru;
        $this->tugas = $tugas;
    }

    public function via($notifiable)
    {
        return ['database'];
    }
    
    public function toArray($notifiable)
    {
        return [
            'pesan' => "{$this->guru->name} membuat tugas baru untuk kelas {$this->tugas->kelas->nama}: '{$this->tugas->judul}'",
            'tugas_id' => $this->tugas->id
        ];
    }
}
