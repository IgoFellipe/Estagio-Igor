<?php

namespace App\Notifications;

use App\Enums\AttendanceStatus;
use App\Models\AttendanceRecord;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PresenceValidatedNotification extends Notification
{
    use Queueable;

    public function __construct(
        private AttendanceRecord $attendance,
        private AttendanceStatus $status,
        private ?string $adminNote = null
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $isApproved = $this->status === AttendanceStatus::APPROVED;

        if ($isApproved) {
            return [
                'title' => 'Presença Confirmada! 🎉',
                'message' => 'Sua presença no hackathon "' . $this->attendance->hackathon->nome . '" foi validada! +200 XP',
                'category' => 'individual',
                'level' => 'success',
                'icon' => 'check-circle',
                'action_url' => route('aluno.ranking'),
                'hackathon_id' => $this->attendance->hackathon_id,
            ];
        }

        // Rejeitado - destaque máximo
        $motivo = $this->adminNote ?: 'Foto não atende aos critérios de validação';
        
        return [
            'title' => '⚠️ URGENTE: Foto Recusada',
            'message' => 'Sua foto de presença no hackathon "' . $this->attendance->hackathon->nome . '" foi REJEITADA. Motivo: ' . $motivo,
            'category' => 'individual',
            'level' => 'danger',
            'icon' => 'exclamation-triangle',
            'action_url' => route('aluno.presenca.create'),
            'hackathon_id' => $this->attendance->hackathon_id,
            'urgent' => true,
        ];
    }
}
