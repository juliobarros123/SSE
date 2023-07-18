<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestrictCandidatoAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // dd("o");
        // Verifica se o usuário está autenticado
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Verifica se o tipo de usuário é 'Candidato'
        if (Auth::User()->vc_tipoUtilizador === 'Candidato') {
            // dd($request->route()->getName() !== 'candidatura');
            // Verifica se a rota atual não é 'candidatura'
            if ($request->route()->getName() !== 'candidatura') {
                abort(403, 'Acesso não autorizado');
            }
        }
        if (Auth::User()->vc_tipoUtilizador === 'Estudante') {
            // dd($request->route()->getName() !== 'candidatura');
            // Verifica se a rota atual não é 'candidatura'
        // dd("o");
                return redirect()->route('painel.alunos');
            
        }

        return $next($request);
    }

}