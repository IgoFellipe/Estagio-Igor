<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Hackathon;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HackathonController extends Controller
{
    /**
     * Lista hackathons para o professor.
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
     * Lista hackathons para o aluno.
     */
    public function alunoIndex(): View
    {
        // Hackathons ativos
        $hackathons = Hackathon::where('data_fim', '>=', now())
                                ->orderBy('data_inicio', 'asc')
                                ->get();


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

        $hackathon = Hackathon::create($validatedData);

        // Criar anúncio global para todos os alunos
        Announcement::create([
            'title' => '🚀 Novo Hackathon: ' . $hackathon->nome,
            'body' => 'O hackathon "' . $hackathon->nome . '" foi criado! Inscreva-se e forme seu grupo para participar.',
            'icon' => 'megaphone',
            'type' => 'info',
            'category' => 'general',
            'action_url' => route('aluno.hackathons.index'),
            'expires_at' => $hackathon->data_fim,
        ]);

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
            // Remove banner antigo
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