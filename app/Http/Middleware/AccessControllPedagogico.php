<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AccessControllPedagogico
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(auth()->user()->vc_tipoUtilizador=='Administrador'){
            return $next($request);
 
        }else if(auth()->user()->vc_tipoUtilizador=='Cordenação Pedagógica'){
            return $next($request);
        }
        else if(auth()->user()->vc_tipoUtilizador=='Chefe de Departamento Pedagógico'){
            return $next($request);
        }
          else if(auth()->user()->vc_tipoUtilizador=='Gabinete Pedagógico'){
            return $next($request);
        }
        else if(auth()->user()->vc_tipoUtilizador=='Sub Directoria Pedagógica'){
            return $next($request);
    }else{
        return redirect()->back()->with('permissao', '1');
    }
}
}