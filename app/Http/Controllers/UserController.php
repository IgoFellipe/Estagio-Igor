<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Hackathon; // Import Hackathon model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $tipo = $request->input('filtro');
        $query = User::query();

        if ($tipo && in_array($tipo, ['aluno', 'professor', 'adm'])) {
            $query->where('tipo', $tipo);
        }

        $users = $query->get();
        $user = Auth::user(); 
        
        // Fix: Pass all hackathons or an empty collection to avoid "Undefined variable" error in the view
        $hackathons = Hackathon::all(); 

        return view('users.index', compact('users', 'user', 'hackathons'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'tipo' => 'required|in:aluno,professor,adm',
            'matricula' => 'nullable|string|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $matricula = ($request->tipo === 'aluno') ? $request->matricula : null;

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'matricula' => $matricula,
            'tipo' => $request->tipo,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'Usuário cadastrado com sucesso!');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'tipo' => 'required|in:aluno,professor,adm',
            'matricula' => 'nullable|string|unique:users,matricula,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $matricula = ($request->tipo === 'aluno') ? $request->matricula : null;
        $password = $request->password ? Hash::make($request->password) : $user->password;

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'matricula' => $matricula,
            'tipo' => $request->tipo,
            'password' => $password,
        ]);

        return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuário excluído com sucesso!');
    }
}