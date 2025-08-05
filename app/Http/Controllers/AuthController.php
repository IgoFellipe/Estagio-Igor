<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginForm() {
        return view('auth.login');
    }

    public function showRegisterForm() {
        return view('auth.register');
    }

public function login(Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
        'tipo' => 'required|in:aluno,professor',
    ]);

    $user = User::where('email', $request->email)
                ->where('tipo', $request->tipo)
                ->first();

    // valida matrícula se tipo for aluno
    if ($user && $request->tipo === 'aluno') {
        if ($user->matricula !== $request->matricula) {
            return back()->withErrors(['matricula' => 'Matrícula incorreta para o usuário informado.']);
        }
    }

    if ($user && Hash::check($request->password, $user->password)) {
        Auth::login($user);
        return redirect($user->tipo === 'aluno' ? '/dashboard/aluno' : '/dashboard/professor')
               ->with('success', 'Login realizado com sucesso.');
    }

    return back()->withErrors(['email' => 'Credenciais inválidas.']);
}

public function register(Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'matricula' => 'required|string|unique:users',
        'password' => 'required|string|min:6|confirmed',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'matricula' => $request->matricula,
        'tipo' => 'aluno', // aqui pode ajustar depois se quiser deixar dinâmico
        'password' => Hash::make($request->password),
    ]);

    Auth::login($user);
    return redirect('/login')->with('success', 'Cadastro realizado e login efetuado com sucesso.');
}


    public function logout() {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Logout realizado com sucesso.');
    }
}