<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Hackathon;

class DashboardController extends Controller
{
    public function aluno()
    {
        $user = Auth::user();
        
        // Hackathons ativos
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