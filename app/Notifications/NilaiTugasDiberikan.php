<?php
namespace App\Notifications;

use App\Models\Tugas;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;

class NilaiTugasDiberikan extends Notification
{
    use Queueable;

    protected $tugas;
    protected $nilai;

    public function __construct(Tugas $tugas, $nilai)
    {
        $this->tugas = $tugas;
        $this->nilai = $nilai;
    }

    public function via($notifiable)
    {
        return ['database']; // Simpan di DB
    }
    public function toArray($notifiable)
    {
        return [
            'pesan' => 'Guru Menilai Tugas.',
            'url' => route('forum.show', ['id' => $this->forumId]) // opsional
        ];
    }
    public function toDatabase($notifiable)
    {
        return [
            'judul' => 'Nilai Tugas Anda Telah Diberikan',
            'pesan' => "Nilai untuk tugas '{$this->tugas->judul}' adalah {$this->nilai}.",
            'tugas_id' => $this->tugas->id,
        ];
    }
}
