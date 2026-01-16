<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GamificationEvent extends Model
{
    protected $fillable = [
        'key',
        'name',
        'points',
        'icon',
        'description',
    ];

    /**
     * Registros de pontos associados a este evento
     */
    public function ledgerEntries(): HasMany
    {
        return $this->hasMany(UserPointsLedger::class, 'event_id');
    }

    /**
     * Buscar evento por chave
     */
    public static function findByKey(string $key): ?self
    {
        return static::where('key', $key)->first();
    }
}
