<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Announcement extends Model
{
    protected $fillable = [
        'title',
        'body',
        'icon',
        'type',
        'category',
        'action_url',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    /**
     * Usuários que leram este anúncio
     */
    public function readers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'announcement_user')
            ->withPivot('read_at');
    }

    /**
     * Escopo para anúncios ativos (não expirados)
     */
    public function scopeActive($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expires_at')
              ->orWhere('expires_at', '>', now());
        });
    }

    /**
     * Escopo para anúncios não lidos por um usuário
     */
    public function scopeUnreadBy($query, User $user)
    {
        return $query->whereDoesntHave('readers', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        });
    }

    /**
     * Verificar se o usuário leu este anúncio
     */
    public function isReadBy(User $user): bool
    {
        return $this->readers()->where('user_id', $user->id)->exists();
    }

    /**
     * Marcar como lido por um usuário
     */
    public function markAsReadBy(User $user): void
    {
        if (!$this->isReadBy($user)) {
            $this->readers()->attach($user->id, ['read_at' => now()]);
        }
    }
}
