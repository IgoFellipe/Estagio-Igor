<?php

namespace App\Notifications;

use App\Models\Hackathon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewHackathonNotification extends Notification
{
    use Queueable;

    public function __construct(
        private Hackathon $hackathon
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => '🚀 Novo Hackathon!',
            'message' => 'O hackathon "' . $this->hackathon->nome . '" foi criado! Inscreva-se e forme seu grupo.',
            'category' => 'general',
            'level' => 'info',
            'icon' => 'megaphone',
            'action_url' => route('aluno.hackathons.index'),
            'hackathon_id' => $this->hackathon->id,
        ];
    }
}
