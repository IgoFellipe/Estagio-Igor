<?php

namespace App\Services;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Support\Collection;

class NotificationService
{
    /**
     * Obter todas as notificações do usuário (pessoais + anúncios globais)
     * 
     * @param User $user
     * @param bool $unreadOnly
     * @param int $limit
     * @return Collection
     */
    public function getUserNotifications(User $user, bool $unreadOnly = false, int $limit = 20): Collection
    {
        // Buscar notificações pessoais (do banco notifications)
        $personalNotifications = $this->getPersonalNotifications($user, $unreadOnly, $limit);

        // Buscar anúncios globais não lidos
        $announcements = $this->getAnnouncements($user, $unreadOnly, $limit);

        // Mesclar e ordenar por data
        $merged = $personalNotifications->concat($announcements)
            ->sortByDesc('created_at')
            ->take($limit)
            ->values();

        return $merged;
    }

    /**
     * Buscar notificações pessoais do usuário
     */
    private function getPersonalNotifications(User $user, bool $unreadOnly, int $limit): Collection
    {
        $query = $user->notifications();

        if ($unreadOnly) {
            $query = $user->unreadNotifications();
        }

        return $query->take($limit)->get()->map(function ($notification) {
            $data = $notification->data;
            
            return (object) [
                'id' => $notification->id,
                'type' => 'notification',
                'title' => $data['title'] ?? 'Notificação',
                'message' => $data['message'] ?? '',
                'category' => $data['category'] ?? 'individual',
                'level' => $data['level'] ?? 'info',
                'icon' => $data['icon'] ?? 'bell',
                'action_url' => $data['action_url'] ?? null,
                'is_read' => $notification->read_at !== null,
                'is_urgent' => $data['urgent'] ?? false,
                'created_at' => $notification->created_at,
            ];
        });
    }

    /**
     * Buscar anúncios globais
     */
    private function getAnnouncements(User $user, bool $unreadOnly, int $limit): Collection
    {
        $query = Announcement::active()->latest();

        if ($unreadOnly) {
            $query->unreadBy($user);
        }

        return $query->take($limit)->get()->map(function ($announcement) use ($user) {
            return (object) [
                'id' => $announcement->id,
                'type' => 'announcement',
                'title' => $announcement->title,
                'message' => $announcement->body,
                'category' => $announcement->category,
                'level' => $announcement->type,
                'icon' => $announcement->icon,
                'action_url' => $announcement->action_url,
                'is_read' => $announcement->isReadBy($user),
                'is_urgent' => false,
                'created_at' => $announcement->created_at,
            ];
        });
    }

    /**
     * Contar notificações não lidas
     */
    public function getUnreadCount(User $user): int
    {
        $personalCount = $user->unreadNotifications()->count();
        $announcementCount = Announcement::active()->unreadBy($user)->count();

        return $personalCount + $announcementCount;
    }

    /**
     * Marcar notificação como lida
     */
    public function markAsRead(User $user, string $id, string $type): bool
    {
        if ($type === 'announcement') {
            $announcement = Announcement::find($id);
            if ($announcement) {
                $announcement->markAsReadBy($user);
                return true;
            }
        } else {
            $notification = $user->notifications()->where('id', $id)->first();
            if ($notification) {
                $notification->markAsRead();
                return true;
            }
        }

        return false;
    }

    /**
     * Marcar todas as notificações como lidas
     */
    public function markAllAsRead(User $user): void
    {
        // Marcar notificações pessoais
        $user->unreadNotifications()->update(['read_at' => now()]);

        // Marcar anúncios globais
        $unreadAnnouncements = Announcement::active()->unreadBy($user)->get();
        foreach ($unreadAnnouncements as $announcement) {
            $announcement->markAsReadBy($user);
        }
    }

    /**
     * Obter notificações formatadas para JSON (API)
     */
    public function getNotificationsJson(User $user, ?string $category = null): array
    {
        $notifications = $this->getUserNotifications($user, false, 30);

        // Filtrar por categoria se especificado
        if ($category && $category !== 'all') {
            $notifications = $notifications->filter(fn($n) => $n->category === $category);
        }

        return [
            'notifications' => $notifications->values()->toArray(),
            'unread_count' => $this->getUnreadCount($user),
        ];
    }
}
