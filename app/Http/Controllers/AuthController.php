<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
            'tipo' => 'required|in:aluno,professor,adm',
        ]);

        $credentials = [];
        if ($request->tipo === 'aluno' || $request->tipo === 'professor') {
            $request->validate(['email' => 'required|email']);
            $credentials = [
                'email' => $request->email,
                'password' => $request->password,
                'tipo' => $request->tipo,
            ];
        } elseif ($request->tipo === 'adm') {
            $request->validate(['name' => 'required|string']);
            $credentials = [
                'name' => $request->name,
                'password' => $request->password,
                'tipo' => $request->tipo,
            ];
        }

        if ($request->tipo === 'aluno') {
            $user = User::where('email', $request->email)
                ->where('tipo', $request->tipo)
                ->first();

            if ($user && $user->matricula !== $request->matricula) {
                return back()->withErrors(['matricula' => 'Matrícula incorreta para o usuário informado.']);
            }
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->tipo === 'aluno' || $user->tipo === 'professor') {
                return redirect()->route('dashboard.aluno')->with('success', 'Login realizado com sucesso.');
            } elseif ($user->tipo === 'adm') {
                return redirect()->route('users.index')->with('success', 'Login de ADM realizado com sucesso.');
            }
        }

        return back()->withErrors(['geral' => 'Credenciais inválidas.']);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'matricula' => 'required|int|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'matricula' => $request->matricula,
            'tipo' => 'aluno',
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);
        return redirect('/dashboard/aluno')->with('success', 'Cadastro realizado com sucesso.');
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Logout realizado com sucesso.');
    }
}
