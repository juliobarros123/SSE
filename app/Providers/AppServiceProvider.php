<?php

namespace App\Providers;

use App\Models\Cabecalho;
use Auth;
use Illuminate\Support\ServiceProvider;
use App\Models\PermissaoNota;
use App\Models\AnoLectivoPublicado;
use App\Models\AnoLectivo;
use App\Models\CoordenadorCurso;
use App\Models\CoordenadorTurno;
use App\Models\DireitorTurma;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {

            $response['cabecalho'] = Cabecalho::find(1);

            $view->with('caminhoLogo', $response['cabecalho']->vc_logo);

            $cabecalhos = $response['cabecalho'];
            $cabe = session()->get('cabecalhos', $cabecalhos);
            $cab = $cabe;
            session()->has('cabecalhos') ? session()->get('cabecalhos') : [''];
            $view->with('cab', $cab);

            // $response['permissao_nota'] = PermissaoNota::find(1);
            // $estadoPermissaoNota=$response['permissao_nota']->estado;
            // $view->with('estado_permissao_nota', $estadoPermissaoNota);
            if (Auth::User()) {
                $anoslectivos = AnoLectivo::get();
                //dd($anoslectivos);
                if ($anoslectivos->count() == 1) {
                    # code...
                    $anoLectivoP = AnoLectivoPublicado::all();
                    if ($anoLectivoP->count() == 0) {
                        AnoLectivoPublicado::create(
                            [
                                'id_anoLectivo' => $anoslectivos[0]->id,
                                'ya_inicio' => $anoslectivos[0]->ya_inicio,
                                'ya_fim' => $anoslectivos[0]->ya_fim,
                                'id_cabecalho' => id_first_cabecalho()
                            ]
                        );
                    }
                }
                //  dd();
                $response['ano_lectivo'] = fha_ano_lectivo_publicado();
                // dd( $response['ano_lectivo']);
                if (isset($response['ano_lectivo']->id_anoLectivo)) {
                    $view->with('id_anoLectivo_publicado', $response['ano_lectivo']->id_anoLectivo);
                    $view->with('ano_lectivo_publicado', $response['ano_lectivo']->ya_inicio . '-' . $response['ano_lectivo']->ya_fim);
                }

            }
        });
    }
}