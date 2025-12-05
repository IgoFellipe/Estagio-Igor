<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Hackathon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GrupoController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Carrega os grupos do usuário com o hackathon associado
        $grupos = $user->grupos()->with('hackathon')->get();

        return view('grupos.aluno.index', compact('grupos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'hackathon_id' => 'required|exists:hackathons,id',
        ]);

        // Verifica se o usuário já está em um grupo deste hackathon
        $user = Auth::user();
        $existingGroup = $user->grupos()->where('hackathon_id', $request->hackathon_id)->first();

        if ($existingGroup) {
            return back()->withErrors(['msg' => 'Você já está em um grupo para este hackathon.']);
        }

        $grupo = Grupo::create([
            'nome' => $request->nome,
            'hackathon_id' => $request->hackathon_id,
            'lider_id' => $user->id,
            'codigo' => strtoupper(Str::random(6)),
        ]);

        // Adiciona o líder como membro
        $grupo->membros()->attach($user->id);

        return redirect()->route('aluno.hackathons.index')->with('success', 'Grupo criado com sucesso! Código: ' . $grupo->codigo);
    }

    public function join(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|exists:grupos,codigo',
        ]);

        $grupo = Grupo::where('codigo', $request->codigo)->firstOrFail();
        $user = Auth::user();

        // Verifica se o usuário já está em um grupo deste hackathon
        $existingGroup = $user->grupos()->where('hackathon_id', $grupo->hackathon_id)->first();

        if ($existingGroup) {
            return back()->withErrors(['msg' => 'Você já está em um grupo para este hackathon.']);
        }

        $grupo->membros()->attach($user->id);

        return redirect()->route('aluno.hackathons.index')->with('success', 'Você entrou no grupo ' . $grupo->nome . ' com sucesso!');
    }
}
