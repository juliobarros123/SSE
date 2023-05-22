<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Cabecalho;
Use App\Models\Classe;
Use App\Models\Disciplinas;
Use App\Models\User;
Use App\Models\AnoLectivo;
Use App\Models\Curso;
Use App\Models\Turma;
use Illuminate\Support\Facades\DB;
Use App\Models\Candidatura;
use App\Models\URLEstatistica;
Use App\Models\Candidato2;

Use App\Models\Alunno;

class ApiController extends Controller
{
    //

    public function upload(){

        try {



                $dados = [];
                $dados['escola'] = Cabecalho:: leftjoin('municipios','cabecalhos.it_id_municipio','municipios.id')
                ->select('municipios.vc_nome as vc_nomeMunicipio','cabecalhos.*')->get()->first();

               // dd($dados['escola']);

                $dados['curso'] = Curso::where([['it_estado_curso', 1]])->get();
                $dados['classe'] = Classe::where([['it_estado_classe', 1]])->get();
                $dados['disciplina'] = Disciplinas::where([['it_estado_disciplina', 1]])->get();
                $dados['professor'] = User::where([['it_estado_user', 1], ['vc_tipoUtilizador', 'Professor']])->get();
                $dados['ano_lectivo'] = AnoLectivo::where([['it_estado_anoLectivo', 1]])->get();
                $dados['turma'] = Turma::where([['it_estado_turma', 1]])->get();
                $dados['candidato'] = Candidatura::where([['it_estado_candidato', 1]])->get();
                $dados['selecionado'] = Candidato2::where([['it_estado_aluno', 1]])->get();
                $dados['aluno'] = Alunno::where([['it_estado_aluno', 1]])->get();
                $dados['classe_escola'] = DB::table('turmas_users')
                    ->join('turmas', 'turmas_users.it_idTurma', 'turmas.id')
                    ->join('users', 'turmas_users.it_iduser', 'users.id')
                    ->join('classes', 'turmas_users.it_idClasse', 'classes.id')
                    ->join('disciplinas', 'turmas_users.it_idDisciplina', 'disciplinas.id')
                    ->where('users.vc_tipoUtilizador','Professor')
                    ->select('turmas_users.id', 'users.vc_primemiroNome','users.it_n_agente', 'users.vc_apelido', 'turmas.vc_nomedaTurma', 'classes.vc_classe', 'disciplinas.vc_nome')
                    ->where([['it_estado_turma_user', 1]])->get();
                    dd(          $dados['classe_escola']);
                $dados['matricula'] = DB::table('matriculas')
                    ->join('alunnos', 'matriculas.it_idAluno', 'alunnos.id')
                    ->join('turmas', 'matriculas.it_idTurma', 'turmas.id')
                    ->join('classes', 'matriculas.it_idClasse', 'classes.id')
                    ->join('cursos', 'matriculas.it_idCurso', 'cursos.id')
                    ->select('matriculas.id', 'matriculas.vc_anoLectivo', 'alunnos.vc_bi', 'turmas.vc_nomedaTurma', 'classes.vc_classe', 'cursos.vc_nomeCurso')
                    ->where([['it_estado_matricula', 1]])->get();
                $url=  URLEstatistica::orderBy('id','desc')->first();


                    $response = Http::post(''.$url->url, $dados);

                return redirect('/')->with('status', '1');

        } catch (\Throwable $th) {

            return redirect('/')->with('status', '0');
        }
    }



}
