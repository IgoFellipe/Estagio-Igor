<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPointsLedger extends Model
{
    /**
     * Desabilitar timestamps automáticos (usamos apenas created_at)
     */
    public $timestamps = false;

    protected $table = 'user_points_ledger';

    protected $fillable = [
        'user_id',
        'event_id',
        'points_amount',
        'related_entity_type',
        'related_entity_id',
        'notes',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Usuário que recebeu os pontos
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Evento de gamificação associado
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(GamificationEvent::class, 'event_id');
    }

    /**
     * Entidade relacionada (polimórfico manual)
     */
    public function relatedEntity(): ?Model
    {
        if ($this->related_entity_type && $this->related_entity_id) {
            return $this->related_entity_type::find($this->related_entity_id);
        }
        return null;
    }
}
