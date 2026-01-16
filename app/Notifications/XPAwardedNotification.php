<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class XPAwardedNotification extends Notification
{
    use Queueable;

    public function __construct(
        private int $xpAmount,
        private string $eventName,
        private ?int $newLevel = null
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        // Se subiu de nível
        if ($this->newLevel) {
            return [
                'title' => '🎮 Subiu de Nível!',
                'message' => 'Parabéns! Você alcançou o Nível ' . $this->newLevel . '! Continue participando para evoluir ainda mais.',
                'category' => 'individual',
                'level' => 'success',
                'icon' => 'star',
                'action_url' => route('aluno.ranking'),
                'xp_amount' => $this->xpAmount,
                'new_level' => $this->newLevel,
            ];
        }

        // Apenas XP
        return [
            'title' => '+' . $this->xpAmount . ' XP!',
            'message' => 'Você ganhou ' . $this->xpAmount . ' XP por: ' . $this->eventName,
            'category' => 'individual',
            'level' => 'success',
            'icon' => 'sparkles',
            'action_url' => route('aluno.ranking'),
            'xp_amount' => $this->xpAmount,
        ];
    }
}
