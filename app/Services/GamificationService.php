<?php

namespace App\Services;

use App\Models\GamificationEvent;
use App\Models\User;
use App\Models\UserPointsLedger;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GamificationService
{
    /**
     * Tabela de XP por nível (progressão exponencial)
     * Nível 1: 0 XP
     * Nível 2: 500 XP
     * Nível 3: 1200 XP
     * etc.
     */
    private const LEVEL_THRESHOLDS = [
        1 => 0,
        2 => 500,
        3 => 1200,
        4 => 2100,
        5 => 3200,
        6 => 4500,
        7 => 6000,
        8 => 7700,
        9 => 9600,
        10 => 11700,
        11 => 14000,
        12 => 16500,
        13 => 19200,
        14 => 22100,
        15 => 25200,
        16 => 28500,
        17 => 32000,
        18 => 35700,
        19 => 39600,
        20 => 43700,
    ];

    /**
     * Conceder pontos a um usuário
     *
     * @param User $user Usuário que receberá os pontos
     * @param string $eventKey Chave do evento (ex: 'presence_confirmed')
     * @param Model|null $entity Entidade relacionada (ex: Hackathon, AttendanceRecord)
     * @param string|null $notes Observações opcionais
     * @return UserPointsLedger|null Registro criado ou null se evento não existir
     */
    public function awardPoints(User $user, string $eventKey, ?Model $entity = null, ?string $notes = null): ?UserPointsLedger
    {
        $event = GamificationEvent::findByKey($eventKey);
        
        if (!$event) {
            return null;
        }

        return DB::transaction(function () use ($user, $event, $entity, $notes) {
            // Criar registro no ledger
            $ledgerEntry = UserPointsLedger::create([
                'user_id' => $user->id,
                'event_id' => $event->id,
                'points_amount' => $event->points,
                'related_entity_type' => $entity ? get_class($entity) : null,
                'related_entity_id' => $entity?->id,
                'notes' => $notes,
                'created_at' => now(),
            ]);

            // Atualizar cache do usuário
            $newXp = $user->current_xp + $event->points;
            $newLevel = $this->calculateLevel($newXp);

            $user->update([
                'current_xp' => $newXp,
                'current_level' => $newLevel,
            ]);

            return $ledgerEntry;
        });
    }

    /**
     * Calcular nível baseado no XP total
     */
    public function calculateLevel(int $xp): int
    {
        $level = 1;
        
        foreach (self::LEVEL_THRESHOLDS as $lvl => $threshold) {
            if ($xp >= $threshold) {
                $level = $lvl;
            } else {
                break;
            }
        }

        return $level;
    }

    /**
     * Obter XP necessário para um nível específico
     */
    public function getXpForLevel(int $level): int
    {
        return self::LEVEL_THRESHOLDS[$level] ?? self::LEVEL_THRESHOLDS[20];
    }

    /**
     * Obter XP necessário para o próximo nível
     */
    public function getXpForNextLevel(int $currentLevel): int
    {
        $nextLevel = min($currentLevel + 1, 20);
        return $this->getXpForLevel($nextLevel);
    }

    /**
     * Calcular progresso percentual até o próximo nível
     */
    public function getLevelProgress(int $currentXp, int $currentLevel): float
    {
        $currentLevelXp = $this->getXpForLevel($currentLevel);
        $nextLevelXp = $this->getXpForNextLevel($currentLevel);
        
        if ($nextLevelXp <= $currentLevelXp) {
            return 100.0; // Nível máximo
        }

        $xpInCurrentLevel = $currentXp - $currentLevelXp;
        $xpNeededForNext = $nextLevelXp - $currentLevelXp;

        return min(100, ($xpInCurrentLevel / $xpNeededForNext) * 100);
    }

    /**
     * Obter ranking de usuários
     *
     * @param int $limit Número de usuários a retornar
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRanking(int $limit = 20)
    {
        return User::where('tipo', 'aluno')
            ->where('current_xp', '>', 0)
            ->orderByDesc('current_xp')
            ->orderByDesc('current_level')
            ->limit($limit)
            ->get();
    }

    /**
     * Obter posição do usuário no ranking
     */
    public function getUserRankPosition(User $user): int
    {
        return User::where('tipo', 'aluno')
            ->where('current_xp', '>', $user->current_xp)
            ->count() + 1;
    }

    /**
     * Recalcular XP e nível de um usuário baseado no ledger
     * (Útil para correções ou migrações)
     */
    public function recalculateUserStats(User $user): void
    {
        $totalXp = UserPointsLedger::where('user_id', $user->id)->sum('points_amount');
        $level = $this->calculateLevel($totalXp);

        $user->update([
            'current_xp' => $totalXp,
            'current_level' => $level,
        ]);
    }

    /**
     * Obter histórico de pontos do usuário
     */
    public function getUserHistory(User $user, int $limit = 10)
    {
        return UserPointsLedger::where('user_id', $user->id)
            ->with('event')
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get();
    }
}
