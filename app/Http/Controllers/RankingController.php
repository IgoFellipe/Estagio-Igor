<?php

namespace App\Http\Controllers;

use App\Services\GamificationService;
use Illuminate\View\View;

class RankingController extends Controller
{
    public function __construct(
        private GamificationService $gamificationService
    ) {}

    /**
     * Exibe a página de ranking
     */
    public function index(): View
    {
        $ranking = $this->gamificationService->getRanking(20);

        return view('ranking.index', [
            'ranking' => $ranking,
        ]);
    }
}
