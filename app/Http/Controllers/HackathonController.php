<?php

namespace App\Http\Controllers;

use App\Models\Hackathon;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HackathonController extends Controller
{
    /**
     * Exibe a lista de hackathons para o PROFESSOR (com opções de editar/excluir).
     */
    public function index(): View
    {
        $hackathons = Hackathon::latest()->get();
        
        return view('hackathons.professor.index', [
            'hackathons' => $hackathons,
            'user' => Auth::user()
        ]);
    }

    /**
     * Exibe a lista de hackathons para o ALUNO (apenas visualização/inscrição).
     */
    public function alunoIndex(): View
    {
        // Busca hackathons que ainda não terminaram
        $hackathons = Hackathon::where('data_fim', '>=', now())
                                ->orderBy('data_inicio', 'asc')
                                ->get();

        // CORREÇÃO AQUI: Aponta para a pasta hackathons/aluno/index.blade.php
        return view('hackathons.aluno.index', [
            'hackathons' => $hackathons,
            'user' => Auth::user()->load('grupos')
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('banner') && $request->file('banner')->isValid()) {
            $validatedData['banner'] = $request->banner->store('hackathons', 'public');
        }

        Hackathon::create($validatedData);

        return redirect()->route('dashboard.professor')->with('success', 'Hackathon criado com sucesso!');
    }

    // Métodos placeholders
    public function create() {}
    public function show(Hackathon $hackathon) {}
    public function edit(Hackathon $hackathon) {}
    public function update(Request $request, Hackathon $hackathon)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('banner') && $request->file('banner')->isValid()) {
            // Delete old banner if exists
            if ($hackathon->banner && Storage::disk('public')->exists($hackathon->banner)) {
                Storage::disk('public')->delete($hackathon->banner);
            }
            $validatedData['banner'] = $request->banner->store('hackathons', 'public');
        }

        $hackathon->update($validatedData);

        return redirect()->route('dashboard.professor')->with('success', 'Hackathon atualizado com sucesso!');
    }
    public function destroy(Hackathon $hackathon) {}
}