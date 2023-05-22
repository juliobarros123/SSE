<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnoLectivoPublicado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Cabecalho;
use App\Models\Classe;
use App\Models\Disciplinas;
use App\Models\User;
use App\Models\AnoLectivo;
use App\Models\Curso;
use App\Models\Turma;
use Illuminate\Support\Facades\DB;
use App\Models\Candidatura;
use App\Models\URLEstatistica;
use App\Models\Candidato2;

use App\Models\Alunno;

class GPEUController extends Controller
{
    //

    public function uploadToGPEU()
    {

        try {


            // $response['anoslectivos'] = AnoLectivoPublicado::find(1);
            // $anoLectivoPublicado = $response['anoslectivos']->ya_inicio . "-" . $response['anoslectivos']->ya_fim;
            $dados = [];
            $dados['escola'] = Cabecalho::leftjoin('municipios','cabecalhos.it_id_municipio','municipios.id')
            ->select('municipios.vc_nome as vc_nomeMunicipio','cabecalhos.*')->get()->first();

            //dd($dados['escola']);
            $dados['curso'] = Curso::where([['it_estado_curso', 1]])->get();
            $dados['classe'] = Classe::where([['it_estado_classe', 1]])->get();
            $dados['disciplina'] = Disciplinas::where([['it_estado_disciplina', 1]])->get();
            // dd( $dados['disciplina']);
            $dados['professor'] = User::where([['it_estado_user', 1], ['vc_tipoUtilizador', 'Professor']])->get();
            $dados['ano_lectivo'] = AnoLectivo::where([['it_estado_anoLectivo', 1]])->get();
            $dados['turma'] = Turma::where([['it_estado_turma', 1]])->get();
            /*    $dados['candidato'] = Candidatura::where([['it_estado_candidato', 1]])->get(); */
            $dados['candidato'] = $this->recebecandidaturas();
            //dd($dados['candidato']);
            $dados['selecionado'] = Candidato2::where([['it_estado_aluno', 1]])->get();
            $dados['aluno'] = Alunno::where([['it_estado_aluno', 1]])
            
            ->get();
            // dd(count($dados['aluno']))
            $dados['classe_escola'] = DB::table('turmas_users')
                ->join('turmas', 'turmas_users.it_idTurma', 'turmas.id')
                ->join('users', 'turmas_users.it_iduser', 'users.id')
                ->join('classes', 'turmas_users.it_idClasse', 'classes.id')
                ->join('disciplinas', 'turmas_users.it_idDisciplina', 'disciplinas.id')
                ->select('turmas_users.id', 'users.vc_primemiroNome', 'users.it_n_agente', 'users.vc_apelido', 'turmas.vc_nomedaTurma', 'turmas.vc_anoLectivo', 'classes.vc_classe', 'disciplinas.vc_nome')
                ->where('users.vc_tipoUtilizador', 'Professor')
                ->where('disciplinas.vc_nome', '!=', null)
                ->where([['it_estado_turma_user', 1]])->get();
            //dd($dados['selecionado']);

            $dados['matricula'] = DB::table('matriculas')
                ->join('alunnos', 'matriculas.it_idAluno', 'alunnos.id')
                ->join('turmas', 'matriculas.it_idTurma', 'turmas.id')
                ->join('classes', 'matriculas.it_idClasse', 'classes.id')
                ->join('cursos', 'matriculas.it_idCurso', 'cursos.id')
                ->select('matriculas.id','matriculas.it_idAluno', 'matriculas.vc_anoLectivo', 'alunnos.vc_bi', 'turmas.vc_nomedaTurma', 'classes.vc_classe', 'cursos.vc_nomeCurso')
                ->where([['it_estado_matricula', 1],['it_estado_turma', 1],['alunnos.it_estado_aluno',1]])->distinct()->get();
            $url = URLEstatistica::orderBy('id', 'desc')->first();
            //  dd( $dados['matricula']->where('vc_anoLectivo','=','2022-2023'));
            //dd($dados['matricula']);
            $dados['url'] = url('/');
            //dd( $dados['url']);
            if ($url) {
                // dd("ola");
                /*  $response = Http::post(''.$url->url, $dados); */
                $response = Http::withHeaders([
                    'Authorization' => 'Basic d3MuYWRtY2F6ZW5nYTptZm4zNDYwODIwMjI='

                ])->post('' . $url->url, $dados);
                
              
                $resp = json_decode($response->body(), true);
                // dd(   $resp);
                if ($resp = "Certo") {

                    return redirect('/')->with('succes', '1');
                } else {
                    return redirect('/')->with('error_limite_requisicao', '1');
                }
            } else {

                return redirect('/')->with('url_404', '1');
            }



        } catch (\Exception $th) {
            dd($th);
            return redirect('/')->with('error_limite_requisicao', '1');
        }
    }
    public function recebecandidaturas()
    {
        $anoLectivo = 'Todos';
        $curso = 'Todos';

        $response = $this->index($anoLectivo, $curso);
        //dd($response);
        return $response["candidatos"];

        //dd($response);
        ;
    }
    public function index($anoLectivo, $curso)
    {

        if ($anoLectivo == 'Todos') {
            $anoLectivo = '';
        }
        if ($curso == 'Todos') {
            $curso = '';
        }
        if ($anoLectivo && $curso) {
            $response['candidatos'] = Candidatura::where([
                ['it_estado_candidato', 1],
                ['vc_anoLectivo', '=', $anoLectivo],
                ['vc_nomeCurso', '=', $curso]
            ])->get();
        } elseif ($anoLectivo && !$curso) {
            $response['candidatos'] = Candidatura::where([
                ['it_estado_candidato', 1],
                ['vc_anoLectivo', '=', $anoLectivo]
            ])->get();
        } elseif (!$anoLectivo && $curso) {
            $response['candidatos'] = Candidatura::where([
                ['it_estado_candidato', 1],
                ['vc_nomeCurso', '=', $curso]
            ])->get();
        } else {

            $response['candidatos'] = collect(DB::table('candidatos')->where('it_estado_candidato', 1)->get());
        }


        return $response;
    }


}