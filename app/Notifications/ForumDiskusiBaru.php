<?php
namespace App\Notifications;

use App\Models\Forum;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class ForumDiskusiBaru extends Notification
{
    use Queueable;

    protected $forum;
    protected $pengirim;

    public function __construct(Forum $forum, User $pengirim)
    {
        $this->forum = $forum;
        $this->pengirim = $pengirim;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'pesan' => "{$this->pengirim->name} mengirim pesan forum baru.",
            'tugas_id' => $this->forum->tugas_id,
            'forum_id' => $this->forum->id,
            'user_id' => $this->pengirim->id,
        ];
    }
}
