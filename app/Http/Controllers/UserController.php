<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $tipo = $request->input('tipo');
        $query = User::query();

        if ($tipo && in_array($tipo, ['aluno', 'professor'])) {
            $query->where('tipo', $tipo);
        }

        $users = $query->get();
        return view('users.index', compact('users'));
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
            'matricula' => $request->tipo === 'aluno' ? 'required|string|unique:users' : 'nullable',
            'tipo' => 'required|in:aluno,professor',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'matricula' => $request->tipo === 'aluno' ? $request->matricula : null,
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
            'tipo' => 'required|in:aluno,professor',
            'matricula' => $request->tipo === 'aluno' ? 'required|string|unique:users,matricula,' . $user->id : 'nullable',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'matricula' => $request->tipo === 'aluno' ? $request->matricula : null,
            'tipo' => $request->tipo,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuário excluído com sucesso!');
    }
}