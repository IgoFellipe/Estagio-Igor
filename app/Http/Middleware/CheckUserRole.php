<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Trata a requisição recebida.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Valida autenticação e papel do usuário
        if (! Auth::check() || Auth::user()->tipo !== $role) {
            // Acesso negado
            return redirect()->route('login')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        return $next($request);
    }
}
