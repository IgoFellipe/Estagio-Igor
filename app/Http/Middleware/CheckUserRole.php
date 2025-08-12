<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Verifica se o usuário está logado e se o tipo dele corresponde ao papel necessário
        if (! Auth::check() || Auth::user()->tipo !== $role) {
            // Se o usuário não está autenticado ou não tem a permissão correta,
            // redireciona para a tela de login com uma mensagem de erro.
            return redirect()->route('login')->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        return $next($request);
    }
}
