<?php

namespace App\Http\Controllers;

use App\Models\Hackathon;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth; // É importante adicionar este 'use'

class HackathonController extends Controller
{
    /**
     * Exibe uma lista de hackathons.
     */
    public function index(): View
    {
        // Busca todos os hackathons, ordenando pelos mais recentes primeiro
        $hackathons = Hackathon::latest()->get();

        // Retorna a view 'hackathons.index' e passa a coleção de hackathons
        // e o usuário autenticado para ela.
        return view('hackathons.index', [
            'hackathons' => $hackathons,
            'user' => Auth::user()
        ]);
    }

    /**
     * Mostra o formulário para criar um novo hackathon.
     */
    public function create()
    {
        // Este método não é necessário, pois usamos um modal.
    }

    /**
     * Armazena um novo hackathon no banco de dados.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validar os dados recebidos do formulário
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
        ]);

        // 2. Criar e salvar o novo hackathon no banco de dados
        Hackathon::create($validatedData);

        // 3. Redirecionar de volta para o dashboard do professor com uma mensagem de sucesso
        return redirect()->route('dashboard.professor')->with('success', 'Hackathon criado com sucesso!');
    }

    /**
     * Exibe um hackathon específico.
     */
    public function show(Hackathon $hackathon)
    {
        // Lógica para mostrar um hackathon (futura implementação)
    }

    /**
     * Mostra o formulário para editar um hackathon.
     */
    public function edit(Hackathon $hackathon)
    {
        // Lógica para a view de edição (futura implementação)
    }

    /**
     * Atualiza um hackathon no banco de dados.
     */
    public function update(Request $request, Hackathon $hackathon)
    {
        // Lógica para atualizar (futura implementação)
    }

    /**
     * Remove um hackathon do banco de dados.
     */
    public function destroy(Hackathon $hackathon)
    {
        // Lógica para deletar (futura implementação)
    }
}