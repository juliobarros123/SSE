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

        
        // Verifica se o usuário está autenticado
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Verifica se o tipo de usuário é 'Candidato'
        if (Auth::User()->vc_tipoUtilizador === 'Candidato') {
            // Verifica se a rota atual não é 'candidatura'
            if ($request->route()->getName() !== 'candidatura') {
                abort(403, 'Acesso não autorizado');
            }
        }

        return $next($request);
    }

}