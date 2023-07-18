<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Nota;
use App\Models\Disciplinas;
use App\Models\Classe;
use App\Models\Turma;
use App\Models\AnoLectivo;
use App\Models\Curso;
use App\Models\Logger;
use App\Models\TurmaUser;
use App\Models\Estudante;
use App\Models\PermissaoUnicaNota;
use App\Models\PermissaoNota;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Disciplina_Curso_Classe;


use Exception;
use Illuminate\Support\Facades\Redirect;

class NotaDinamca extends Controller
{
    //

    private $Logger;
    public function __construct()
    {
        $this->Logger = new Logger();
    }
    public function loggerData($mensagem)
    {
        $dados_Auth = Auth::user()->vc_primemiroNome . ' ' . Auth::user()->vc_apelido . ' Com o nivel de ' . Auth::user()->vc_tipoUtilizador . ' ';
        $this->Logger->Log('info', $dados_Auth . $mensagem);
    }

    public function buscar_alunos(Estudante $estudantes)
    {

        $dados = $this->buscar_alunos_dados();
        dd($dados['turmasUser']);

        return view('admin.nota_em_carga.buscar_alunos.index', $dados);
        // if($this->verificar_permissoes())
        // return view('admin.nota_em_carga.buscar_alunos.index',$dados);
        // else
        // return redirect()->back()->with('semPermissoes', '1');
    }



    public function buscar_alunos_dados()
    {
        $dados['turmasUser'] = $turmaUser = DB::table('turmas_users')
            ->join('turmas', 'turmas_users.it_idTurma', '=', 'turmas.id')
            ->join('users', 'turmas_users.it_idUser', '=', 'users.id')
            ->join('classes', 'turmas.it_idClasse', '=', 'classes.id')
            ->join('cursos', 'turmas.it_idCurso', '=', 'cursos.id')
            ->join('disciplinas', 'turmas_users.it_idDisciplina', '=', 'disciplinas.id')
            ->select('turmas.id as id_turma', 'turmas.*', 'classes.*', 'cursos.*', 'disciplinas.*', 'disciplinas.id as id_disciplina', 'turmas_users.id as id_turma_user');
        if (Auth::user()->vc_tipoUtilizador == 'Professor') {
            $dados['turmasUser'] = $dados['turmasUser']->where([['turmas_users.it_estado_turma_user', 1], ['turmas_users.it_idUser', Auth::id()]])->get();
        } else {
            $dados['turmasUser'] = $dados['turmasUser']->get();
        }

        $dados['permissoesNota'] = PermissaoNota::all();
        $dados['disciplinas'] = Disciplinas::where('it_estado_disciplina', 1)->get();
        $dados['classes'] = Classe::where('it_estado_classe', 1)->get();
        $dados['turmas'] = Turma::where('it_estado_turma', 1)->get();
        $dados['cursos'] = Curso::where('it_estado_curso', 1)->get();
        $dados['anoslectivos'] = AnoLectivo::orderby('id', 'asc')->where('it_estado_anoLectivo', 1)->get();

        return $dados;
        // if($this->verificar_permissoes())
        // return view('admin.nota_em_carga.buscar_alunos.index',$dados);
        // else
        // return redirect()->back()->with('semPermissoes', '1');
    }

    public function verificar_permissoes()
    {
        $estado_permissoesNota = DB::table('permissao_notas')
            ->where('permissao_notas.vc_trimestre', '!=', 'T')
            ->where('permissao_notas.estado', '=', '1')
            ->count();

        return $estado_permissoesNota;
    }
    public function mostrar_alunos(Request $request)
    {



        $dados['turmasUser'] = $turmaUser = $this->turmasProfessor();

        $dados['turmasUser'] = $dados['turmasUser']->where('id_turma_user', $request->id_turma_user);

        $dados['turmasUser']->all();


        $turma_user = $dados['turmasUser'];

        foreach ($turma_user as $turma_user) {
            $id_turmaUser = $turma_user->id_turma_user;
            $it_idCurso = $turma_user->it_idCurso;
            $it_idClasse = $turma_user->it_idClasse;
            $it_idTurma = $turma_user->id_turma;
            $it_disciplina = $turma_user->id_disciplina;
            $id_anoLectivo = $request->id_anoLectivo;
            $vc_tipodaNota = $request->vc_tipodaNota;


            $detalhes['it_idCurso'] = $turma_user->it_idCurso;
            $detalhes['it_idClasse'] = $turma_user->it_idClasse;
            $detalhes['it_idTurma'] = $turma_user->id_turma;

            $detalhes['it_disciplina'] = $turma_user->id_disciplina;
            $detalhes['id_anoLectivo'] = $request->id_anoLectivo;
            $detalhes['vc_tipodaNota'] = $request->vc_tipodaNota;
        }


        $ano_lectivo = $this->buscar_ano_lectivo($request->id_anoLectivo);
        // dd( $ano_lectivo);
        $alunos3 = $this->returnar_alunos_com_tri($it_idCurso, $it_idClasse, $it_idTurma, $ano_lectivo, $vc_tipodaNota, $id_turmaUser);

        $alunos = $this->returnar_alunos($it_idCurso, $it_idClasse, $it_idTurma, $ano_lectivo);
        // dd( $alunos,'a');
        // dd($alunos);
        // $alunos1=$alunos->where('vc_tipodaNota', $vc_tipodaNota);

        // if ($alunos1->count()) {
        //     $alunos=$alunos1;
        // } else {
        //     $alunos=$alunos3;
        // }

        $alunos = $this->filtrar_alunos($alunos3, $alunos);

        //   dd(  $alunos);
        $detalhes['estados_de_notas_unica'] = $this->buscar_notas_ativadas($vc_tipodaNota);
        //   dd(  $detalhes['estados_de_notas_unica']);
        return view('admin.nota_em_carga.mostrar_alunos.index', compact('alunos'), $detalhes);
    }




    public function alunos($slug_turma_user, $trimestre)
    {
        // dd("ola");
        try {
            $turma_professor = fh_turmas_professores()->where('turmas_users.slug', $slug_turma_user)->first();
            // dd( $turma_professor);
            $turma = fh_turmas_2()->where('turmas.id', $turma_professor->id_turma)->first();

            $alunos = fha_turma_alunos($turma->slug);

            // $nota=fhap_media_geral(113, $turma_professor->it_idClasse,$turma_professor->id_ano_lectivo);
            // dd(  $nota );
            $response['trimestre'] = $trimestre;
            $response['alunos'] = $alunos;
            $response['turma'] = $turma;
            $response['turma_professor'] = $turma_professor;


            return view('admin.nota_em_carga.mostrar_alunos.index', $response);
        } catch (Exception $ex) {
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado']);



        }
    }
    public function filtrar_alunos($alunos_filtrado, $alunos)
    {
        $collection = collect();
        $m = collect();
        foreach ($alunos as $aluno) {
            $resultSet = $alunos_filtrado->where('id_aluno', $aluno->id_aluno);

            if ($resultSet->count()) {
                $collection->push($resultSet->min());
            } else {
                $collection->push($aluno);
                $collection->all();
            }
        }

        return $collection;
    }

    public function buscar_ano_lectivo($id_anoLectivo)
    {
        $ano_lectivo = AnoLectivo::find($id_anoLectivo);
        return $ano_lectivo->ya_inicio . '-' . $ano_lectivo->ya_fim;
    }

    public function buscar_notas_ativadas($vc_tipodaNota)
    {
        return DB::table('permissao_unica_notas')
            ->join('permissao_notas', 'permissao_unica_notas.id_permissao_notas', '=', 'permissao_notas.id')
            ->where('permissao_notas.vc_trimestre', $vc_tipodaNota)
            ->select('permissao_unica_notas.estado')
            ->get();
    }



    public function inserir(Request $request)
    {

        $turma_professor = fh_turmas_professores()->where('turmas_users.slug', $request->slug_turma_professor)->first();
        $turma = Turma::find($turma_professor->id_turma);

        $alunos = fha_turma_alunos($turma->slug);
        // dd( $turma_professor->it_idClasse);
        $disciplina_curso_classe = fh_disciplinas_cursos_classes()
            ->where('disciplinas_cursos_classes.it_disciplina', $turma_professor->id_disciplina)
            ->where('disciplinas_cursos_classes.it_curso', $turma_professor->it_idCurso)
            ->where('disciplinas_cursos_classes.it_classe', $turma_professor->it_idClasse)
            ->select('disciplinas_cursos_classes.*')->first();
        // dd($disciplina_curso_classe);
        // dd($alunos);
        try {
            if (!$disciplina_curso_classe) {
                return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Faça o relacionamento de  Disciplina\Curso\Classe']);
            }
            foreach ($alunos as $aluno) {
                $notas = $request->all();
                // dd( $notas);
                if (isset($notas["fl_nota1_$aluno->processo"])) {
                    $nota1 = fh_arredondar($notas["fl_nota1_$aluno->processo"]);
                    $nota2 = fh_arredondar($notas["fl_nota2_$aluno->processo"]);
                    $mac = fh_arredondar($notas["fl_mac_$aluno->processo"]);
                    $mediana = fh_arredondar((($nota1 + $nota2 + $mac) / 3));

                    $linha = Nota::join('alunnos', 'alunnos.id', 'notas.id_aluno')
                        ->where('id_classe', $turma_professor->it_idClasse)
                        ->where('id_disciplina_curso_classe', $disciplina_curso_classe->id)
                        ->where('id_turma', $turma_professor->id_turma)
                        ->where('vc_tipodaNota', $request->trimestre)
                        ->where('alunnos.processo', $aluno->processo)
                        ->where('id_ano_lectivo', $turma_professor->id_ano_lectivo)
                        ->select('notas.*')
                        ->where('notas.id_cabecalho', Auth::User()->id_cabecalho)

                        ->first();

                    if ($linha) {
                        Nota::where('id', $linha->id)->update([
                            'fl_nota1' => $nota1,
                            'fl_nota2' => $nota2,
                            'fl_mac' => $mac,
                            'fl_media' => $mediana,

                        ]);

                    } else {
                        Nota::create([
                            'id_classe' => $turma_professor->it_idClasse,
                            'id_disciplina_curso_classe' => $disciplina_curso_classe->id,
                            'id_turma' => $turma_professor->id_turma,
                            'vc_tipodaNota' => $request->trimestre,
                            'fl_nota1' => $nota1,
                            'fl_nota2' => $nota2,
                            'fl_mac' => $mac,
                            'id_aluno' => $aluno->id_aluno,
                            'fl_media' => $mediana,
                            'id_ano_lectivo' => $turma_professor->id_ano_lectivo,
                            'id_cabecalho' => Auth::User()->id_cabecalho
                        ]);
                    }
                }
            }

            // dd("Ola");
            $slug_turma_user = $request->slug_turma_professor;
            $trimestre = $request->trimestre;
            $slug_disciplina_curso_classe = $disciplina_curso_classe->slug;
            return redirect('admin/pautas/mini/disciplina/' . $slug_turma_user . '/' . $trimestre . '/' . $slug_disciplina_curso_classe);

        } catch (Exception $ex) {
            dd($ex);
            //  dd( $ex);
            return redirect()->back()->with('error', '1');

        }
    }


    public function vrf_valor_nota($nota, $detalhes, $cont)
    {
        $notas = DB::table('notas')
            ->where('id_ano_lectivo', $detalhes['id_anoLectivo'])
            ->where('id_turma', $detalhes['id_turma'])
            ->where('id_aluno', $detalhes['id_aluno'])
            ->where('vc_tipodaNota', $detalhes['vc_tipodaNota'])
            ->where('it_disciplina', $detalhes['it_disciplina'])
            ->where('fl_nota' . $cont, '==', 0.00)
            ->get();
        if ($notas == null) {
            return 0;
        } elseif (isset($notas['fl_nota' . $cont])) {
            return $notas['fl_nota' . $cont];
        }
    }


    public function vrf_valor_nota_mac($nota, $detalhes)
    {
        $notas = DB::table('notas')
            ->where('id_ano_lectivo', $detalhes['id_anoLectivo'])
            ->where('id_turma', $detalhes['id_turma'])
            ->where('id_aluno', $detalhes['id_aluno'])
            ->where('vc_tipodaNota', $detalhes['vc_tipodaNota'])
            ->where('it_disciplina', $detalhes['it_disciplina'])
            ->where('fl_mac', '==', 0.00)
            ->get();
        if ($notas == null) {
            return 0;
        } elseif (isset($notas['fl_mac'])) {
            return $notas['fl_mac'];
        }
    }

    public function insert($nota, $detalhes)
    {

    }





    public function returnar_alunos_com_tri($it_idCurso, $it_idClasse, $it_idTurma, $vc_anoLectivo, $vc_tipodaNota, $id_turmaUser)
    {
        // dd($vc_anoLectivo);
        $dados['turmasUser'] = $turmaUser = $this->turmasProfessor();
        $dados['turmasUser'] = $dados['turmasUser']->where('id_turma_user', $id_turmaUser)->min();
        // dd($dados['turmasUser']->vc_nome);
        $resultSet = DB::table('matriculas')
            ->join('turmas', 'matriculas.it_idTurma', '=', 'turmas.id')
            ->join('classes', 'matriculas.it_idClasse', '=', 'classes.id')
            ->join('cursos', 'matriculas.it_idCurso', '=', 'cursos.id')
            ->join('alunnos', 'matriculas.it_idAluno', '=', 'alunnos.id')
            ->join('turmas_users', 'turmas_users.it_idTurma', '=', 'turmas.id')
            ->leftJoin('notas', 'notas.it_idAluno', '=', 'alunnos.id')
            ->leftJoin('anoslectivos', 'notas.id_ano_lectivo', '=', 'anoslectivos.id')
            ->join('disciplinas_cursos_classes', 'disciplinas_cursos_classes.id', '=', 'notas.id_disciplina_curso_classe')
            ->join('disciplinas', 'disciplinas.id', '=', 'disciplinas_cursos_classes.it_disciplina')
            ->orderby('alunnos.vc_primeiroNome', 'asc')
            ->orderby('alunnos.vc_nomedoMeio', 'asc')
            ->orderby('alunnos.vc_ultimoaNome', 'asc')
            ->where([['matriculas.it_idCurso', $it_idCurso]])
            ->where([['matriculas.it_idClasse', $it_idClasse]])
            ->where([['matriculas.it_idTurma', $it_idTurma]])
            ->where([['matriculas.vc_anoLectivo', $vc_anoLectivo]])
            ->where([['matriculas.it_estado_matricula', 1]])
            ->where([['notas.vc_tipodaNota', $vc_tipodaNota]])
            ->where([['turmas_users.id', $id_turmaUser]])
            ->where([['disciplinas.vc_nome', $dados['turmasUser']->vc_nome]])
            ->select('matriculas.*', 'turmas.*', 'disciplinas.vc_nome as disciplina', 'turmas_users.id as id_turmas_user', 'classes.vc_classe', 'cursos.*', 'alunnos.*', 'matriculas.id as id_matricula', 'matriculas.it_idAluno as id_aluno', 'matriculas.vc_anoLectivo as anolectivo', 'turmas_users.id as id_tu', 'disciplinas.vc_nome', 'notas.*', 'anoslectivos.*')
            ->distinct()->get();
        //  dd($resultSet,$it_idTurma);

        $resultSet = $this->existeNotasComPropreidades($resultSet, $it_idCurso, $it_idClasse, $it_idTurma, $vc_anoLectivo, $vc_tipodaNota, $id_turmaUser, $dados['turmasUser']->vc_nome);
        //    dd( $resultSet);
        return $resultSet;
    }
    public function existeNotasComPropreidades($notas, $it_idCurso, $it_idClasse, $it_idTurma, $vc_anoLectivo, $vc_tipodaNota, $id_turmaUser, $disciplina)
    {
        // dd($vc_tipodaNota);
        $id_ano_lectivo = $this->trazerIDAnoLectivo($vc_anoLectivo);
        $notas = $notas->where('it_idCurso', $it_idCurso)
            ->where('it_idClasse', $it_idClasse)
            ->where('it_idTurma', $it_idTurma)
            ->where('id_ano_lectivo', $id_ano_lectivo)
            ->where('it_estado_matricula', 1)
            ->where('vc_tipodaNota', $vc_tipodaNota)
            ->where('id_turmas_user', $id_turmaUser)
            ->where('disciplina', $disciplina)

        ;
        //    dd(  $notas,"o",$id_ano_lectivo) ;
        return $notas;
    }
    public function trazerIDAnoLectivo($vc_anoLectivo)
    {

        $anos = explode("-", $vc_anoLectivo);
        // dd( $anos);
        return AnoLectivo::where('ya_inicio', $anos[0])->where('ya_fim', $anos[1])->where('it_estado_anoLectivo', 1)->select('id')->first()->id;
    }
    public function returnar_alunos($it_idCurso, $it_idClasse, $it_idTurma, $vc_anoLectivo)
    {
        return DB::table('matriculas')
            ->join('turmas', 'matriculas.it_idTurma', '=', 'turmas.id')
            ->join('classes', 'matriculas.it_idClasse', '=', 'classes.id')
            ->join('cursos', 'matriculas.it_idCurso', '=', 'cursos.id')
            ->join('alunnos', 'matriculas.it_idAluno', '=', 'alunnos.id')
            ->orderby('alunnos.vc_primeiroNome', 'asc')
            ->orderby('alunnos.vc_nomedoMeio', 'asc')
            ->orderby('alunnos.vc_ultimoaNome', 'asc')
            ->where([['matriculas.it_idCurso', $it_idCurso]])
            ->where([['matriculas.it_idClasse', $it_idClasse]])
            ->where([['matriculas.it_idTurma', $it_idTurma]])
            ->where([['matriculas.vc_anoLectivo', $vc_anoLectivo]])
            ->where([['matriculas.it_estado_matricula', 1]])
            ->select('matriculas.*', 'turmas.*', 'classes.*', 'cursos.*', 'alunnos.*', 'matriculas.id as id_matricula', 'matriculas.it_idAluno as id_aluno')
            ->get();
    }


    public function dados_turma_professor()
    {
        return DB::table('turmas_users')
            ->join('turmas', 'turmas_users.it_idTurma', '=', 'turmas.id')
            ->join('users', 'turmas_users.it_idUser', '=', 'users.id')
            ->join('classes', 'turmas.it_idClasse', '=', 'classes.id')
            ->join('cursos', 'turmas.it_idCurso', '=', 'cursos.id')
            ->join('disciplinas', 'turmas_users.it_idDisciplina', '=', 'disciplinas.id');
    }

    public function turmasProfessor()
    {
        $resultSet = collect();

        if (Auth::user()->vc_tipoUtilizador != 'Administrador' && Auth::user()->vc_tipoUtilizador != 'Director Geral' && Auth::user()->vc_tipoUtilizador != 'Chefe de Departamento Pedagógico') {

            $resultSet = $this->dados_turma_professor()->where([['turmas_users.it_estado_turma_user', 1], ['turmas_users.it_idUser', Auth::Id()]])
                ->select('users.*', 'turmas.*', 'classes.*', 'disciplinas.*', 'disciplinas.id as id_disciplina', 'turmas_users.id as id_turma_user', 'cursos.*', 'turmas.id as id_turma')->get();

        } else {

            $resultSet = $this->dados_turma_professor()->where([['turmas_users.it_estado_turma_user', 1]])
                ->select('users.*', 'turmas.*', 'classes.*', 'disciplinas.*', 'disciplinas.id as id_disciplina', 'turmas_users.id as id_turma_user', 'cursos.*', 'turmas.id as id_turma')->get();
        }
        return $resultSet;

    }

    public function filtrar_nota($dados, $matricula)
    {
        $notas = array();

        if (isset($dados['fl_nota1_' . $matricula->id_aluno])) {
            $notas['fl_nota1'] = $dados['fl_nota1_' . $matricula->id_aluno];
        }
        if (isset($dados['fl_nota2_' . $matricula->id_aluno])) {
            $notas['fl_nota2'] = $dados['fl_nota2_' . $matricula->id_aluno];
        }
        if (isset($dados['fl_mac_' . $matricula->id_aluno])) {
            $notas['fl_mac'] = $dados['fl_mac_' . $matricula->id_aluno];
        }


        return $notas;

        //   }/ }else if(count($notas)==0 || count($notas)<3){
//     //      return count($notas);
//     // }
    }



    public function pesquisar(Nota $disciplina)
    {

        $dados['turmasUser'] = $turmaUser = $this->turmasProfessor();

        $dados['permissoesNota'] = PermissaoNota::all();
        $dados['disciplinas'] = Disciplinas::where('it_estado_disciplina', 1)->get();
        $dados['classes'] = Classe::where('it_estado_classe', 1)->get();
        $dados['turmas'] = Turma::where('it_estado_turma', 1)->get();
        $dados['cursos'] = Curso::where('it_estado_curso', 1)->get();
        $dados['anoslectivos'] = AnoLectivo::orderby('id', 'desc')->where('it_estado_anoLectivo', 1)->get();

        // $response['anoslectivos'] = AnoLectivo::where([['it_estado_anoLectivo', 1]])->get();
        // $response['disciplinas'] = $disciplina->RDisciplinasJoins();

        // $response['classes'] = Classe::where([['it_estado_classe', 1]])->get();
        // $response['trimestres'] = Nota::where([['it_estado_nota', 1]])->get();
        // /* Trás as turmas do ano lectivo actual */
        // $anoLectivo = AnoLectivo::where([['it_estado_anoLectivo', 1]])->orderby('id', 'desc')->first();
        // $response['turmas'] = Turma::where([['it_estado_turma', 1], ['vc_anoLectivo', $anoLectivo->ya_inicio . "-" . $anoLectivo->ya_fim]])->get();
        return view('admin.nota_em_carga.pesquisar.index', $dados);
    }



    public function ver(Request $request)
    {


        $dados['turmasUser'] = $turmaUser = $this->turmasProfessor();

        $dados['turmasUser'] = $dados['turmasUser']->where('id_turma_user', $request->id_turma_user);
        $dados['turmasUser']->all();


        $turma_user = $dados['turmasUser'];

        foreach ($turma_user as $turma_user) {
            $id_turmaUser = $turma_user->id_turma_user;
            $it_idCurso = $turma_user->it_idCurso;
            $it_idClasse = $turma_user->it_idClasse;
            $it_idTurma = $turma_user->id_turma;
            $it_disciplina = $turma_user->id_disciplina;
            $id_anoLectivo = $request->id_anoLectivo;
            $vc_tipodaNota = $request->vc_tipodaNota;


            $detalhes['it_idCurso'] = $turma_user->it_idCurso;
            $detalhes['it_idClasse'] = $turma_user->it_idClasse;
            $detalhes['it_idTurma'] = $turma_user->id_turma;

            $detalhes['it_disciplina'] = $turma_user->id_disciplina;
            $detalhes['id_anoLectivo'] = $request->id_anoLectivo;
            $detalhes['vc_tipodaNota'] = $request->vc_tipodaNota;
        }

        //   dd($id_anoLectivo);
        $ano_lectivo = $this->buscar_ano_lectivo($id_anoLectivo);

        $detalhes['notas'] = $this->notas($it_idCurso, $it_idClasse, $it_idTurma, $ano_lectivo, $vc_tipodaNota, $id_turmaUser, $request->id_anoLectivo);
        // dd(  $detalhes['notas']);
        // $alunos= $this->returnar_alunos($it_idCurso, $it_idClasse, $it_idTurma, $ano_lectivo);

        // $alunos1=$alunos->where('vc_tipodaNota', $vc_tipodaNota);

        // if ($alunos1->count()) {
        //     $alunos=$alunos1;
        // } else {
        //     $alunos=$alunos3;
        // }



        $detalhes['estados_de_notas_unica'] = $this->buscar_notas_ativadas($vc_tipodaNota);

        return view('admin.nota_em_carga.index', $detalhes);
    }

    public function notas($it_idCurso, $it_idClasse, $it_idTurma, $ano_lectivo, $vc_tipodaNota, $id_turmaUser, $id_anoLectivo)
    {
        $alunos3 = $this->returnar_alunos_com_tri($it_idCurso, $it_idClasse, $it_idTurma, $ano_lectivo, $vc_tipodaNota, $id_turmaUser);

        // $alunos= $this->returnar_alunos($it_idCurso, $it_idClasse, $it_idTurma, $ano_lectivo);

        // $alunos1=$alunos->where('vc_tipodaNota', $vc_tipodaNota);

        // if ($alunos1->count()) {
        //     $alunos=$alunos1;
        // } else {
        //     $alunos=$alunos3;
        // }

        $detalhes['notas'] = $this->filtrar_alunos($alunos3, $alunos3);
        return $detalhes['notas'];
    }
}