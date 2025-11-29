<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Hackathon; // Importe o modelo Hackathon

class DashboardController extends Controller
{
    public function aluno()
    {
        $user = Auth::user();
        
        // Busca hackathons ativos (data de fim futura) e ordena pelos mais próximos de acabar
        // Você pode ajustar a lógica conforme sua regra de negócio (ex: só os abertos para inscrição)
        $hackathons = Hackathon::where('data_fim', '>=', now())
                                ->orderBy('data_inicio', 'asc')
                                ->get();

        return view('dashboard.aluno', [
            'user' => $user,
            'hackathons' => $hackathons
        ]);
    }

    public function professor()
    {
        $user = Auth::user();
        return view('dashboard.professor', ['user' => $user]);
    }
}