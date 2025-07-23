<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class ChatBimbinganBaru extends Notification
{
    use Queueable;

    protected $chat;

    public function __construct($chat)
    {
        $this->chat = $chat;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'bimbingan_id' => $this->chat->bimbingan_id,
            'pesan' => $this->chat->message,
            'pengirim' => $this->chat->sender->name,
        ];
    }
}
