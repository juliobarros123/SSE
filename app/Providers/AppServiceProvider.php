<?php

namespace App\Providers;
use App\Models\Cabecalho;
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
            $response['cabecalho'] = Cabecalho::orderby('id', 'desc')->first();
            
                $view->with('caminhoLogo', $response['cabecalho']->vc_logo);
           
            $cabecalhos=$response['cabecalho'];
            $cabe=session()->get('cabecalhos', $cabecalhos);     
            $cab = $cabe; 
            session()->has('cabecalhos') ? session()->get('cabecalhos'):[''];
            $view->with('cab', $cab);

            // $response['permissao_nota'] = PermissaoNota::find(1);
            // $estadoPermissaoNota=$response['permissao_nota']->estado;
            // $view->with('estado_permissao_nota', $estadoPermissaoNota);
            $anoslectivos = AnoLectivo::get();
            //dd($anoslectivos);
            if ($anoslectivos->count()==1) {
                # code...
                $anoLectivoP=   AnoLectivoPublicado::all();
                if($anoLectivoP->count()==0){
                    AnoLectivoPublicado::create([
                        'id_anoLectivo'=>$anoslectivos[0]->id,
                        'ya_inicio'=>$anoslectivos[0]->ya_inicio, 
                        'ya_fim'=>$anoslectivos[0]->ya_fim,
                        'id_cabecalho'=>id_first_cabecalho()
                    ]
                    );
                }
            }
            $response['ano_lectivo']=fha_ano_lectivo_publicado();
            // dd( $response['ano_lectivo']);
            if(isset($response['ano_lectivo']->id_anoLectivo)){
                $view->with('id_anoLectivo_publicado',$response['ano_lectivo']->id_anoLectivo);
                $view->with('ano_lectivo_publicado',$response['ano_lectivo']->ya_inicio . '-' . $response['ano_lectivo']->ya_fim);
            }
                $coordenadorCurso=CoordenadorCurso::where('it_estado_coordenador_curso',1)->get();
                $view->with('coordenadorCurso' ,$coordenadorCurso);

                $coordenador_turno_composer=CoordenadorTurno::where('estado_coordenador_turno',1)->get();
                $view->with('coordenador_turno_composer' ,$coordenador_turno_composer);
                $director_turma_composer=DireitorTurma::get();
                $view->with('director_turma_composer' ,$director_turma_composer);
                
        });
    }
}
