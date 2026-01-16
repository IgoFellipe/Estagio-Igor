<?php

namespace App\Notifications;

use App\Models\Grupo;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class GroupPhotoRemovedNotification extends Notification
{
    use Queueable;

    public function __construct(
        private Grupo $grupo
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'Imagem do Grupo Removida',
            'message' => 'A foto do seu grupo "' . $this->grupo->nome . '" foi removida pelo professor.',
            'category' => 'leader',
            'level' => 'warning',
            'icon' => 'photograph',
            'action_url' => route('grupos.index'),
            'grupo_id' => $this->grupo->id,
        ];
    }
}
