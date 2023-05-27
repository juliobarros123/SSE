<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Turma;
use App\Models\Curso;
use App\Models\AnoLectivo;
use App\Models\AnoLectivoPublicado;
use App\Models\TurmaUser;
use App\Models\Disciplinas;
use App\Models\Classe;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Logger;
use Illuminate\Support\Facades\Auth;
use App\Models\Cabecalho;

class TurmaUserController extends Controller
{
    private $Logger;
    private $turma;
    public $retorno = [
        'status' => 1,
        'message' => 'Turma Indisponível',
    ];

    public function loggerData($mensagem)
    {
        $dados_Auth = Auth::user()->vc_primemiroNome . ' ' . Auth::user()->vc_apelido . ' Com o nivel de ' . Auth::user()->vc_tipoUtilizador . ' ';
        $this->Logger->Log('info', $dados_Auth . $mensagem);
    }


    public function __construct(Turma $turma)
    {
        $this->turma = $turma;
        $this->retorno;
        $this->Logger = new Logger();
    }


    public function pesquisar()
    {
        $response['anoslectivos'] = AnoLectivo::where([['it_estado_anoLectivo', 1]])->get();
        $response['cursos'] = Curso::where([['it_estado_curso', 1]])->get();
        return view('admin.matriculas.pesquisarAtribuidos.index', $response);
    }
    public function professores($slug)
    {
    
        $data['professores'] = fha_turma_professores($slug)['atribuicoes'];
        $data['disciplinas'] = fha_turma_professores($slug)['disciplinas'];
        $data['turma'] = fh_turmas_slug($slug)->first();
        $data['cabecalho'] = fh_cabecalho();
        $data["css"] = file_get_contents('css/lista/style-2.css');

        // $data["css"] = file_get_contents('css/listas/style.css');
        // $data["bootstrap"] = file_get_contents('css/listas/bootstrap.min.css');
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetFont("arial");
        $mpdf->setHeader();
        $this->Logger->Log('info', 'Gerou lista de professores');
        $html = view("admin/pdfs/turma-professor/index", $data);
        $mpdf->writeHTML($html);
        $mpdf->Output("listasdDiplomados.pdf", "I");
    }
    public function index()
    {

        $response['anoslectivos'] = AnoLectivoPublicado::find(1);
        //dd();
        $anoLectivoPublicado = $response['anoslectivos']->ya_inicio . "-" . $response['anoslectivos']->ya_fim;
        //dd($anoLectivoPublicado);
        $response['atribuicoes'] = DB::table('turmas_users')
            ->join('users', 'users.id', '=', 'turmas_users.it_idUser')
            ->join('disciplinas', 'turmas_users.it_idDisciplina', '=', 'disciplinas.id')
            ->where('users.vc_tipoUtilizador', '=', 'professor')
            ->leftJoin('turmas', 'turmas.id', '=', 'turmas_users.it_idTurma')
            ->distinct()
            ->select(
                'turmas_users.it_idUser',
                'turmas_users.id as ident',
                'users.vc_primemiroNome',
                'users.vc_apelido',
                'turmas.vc_nomedaTurma',
                'turmas.vc_classeTurma',
                'turmas.vc_cursoTurma',
                'turmas.vc_salaTurma',
                'turmas.vc_anoLectivo',
                'turmas.it_qtMatriculados',
                'turmas.it_qtdeAlunos',
                'turmas.id as id_turma',
                'disciplinas.id as id_disciplina',

                'disciplinas.vc_nome as disciplina'

            )

            ->where('users.vc_tipoUtilizador', '=', 'professor')
            /* ->where('turmas.vc_anoLectivo', $anoLectivoPublicado) */
            ->where('turmas_users.it_estado_turma_user', 1)
            ->get();
        // dd(   $response['atribuicoes']);

        $response['disciplinas'] = DB::table('turmas_users')
            ->join('users', 'users.id', '=', 'turmas_users.it_idUser')
            ->join('disciplinas', 'turmas_users.it_idDisciplina', '=', 'disciplinas.id')
            ->where('users.vc_tipoUtilizador', '=', 'professor')
            ->distinct()
            ->select(
                'turmas_users.it_idUser',
                'disciplinas.vc_nome as disciplina'
            )

            ->get();


        return view('admin.atribuicoes.index', $response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cadastrar()
    {
        /* $turmas =  DB::table('anoslectivos')
        ->join('anoslectivos', 'anoslectivos.id', '=', 'turmas.vc_anoLectivo')->orderByRaw('id DESC')->limit(1)
        ->select('turmas.id', 'turmas.vc_nome')
        ->get();*/
        $response['anoslectivos'] = AnoLectivoPublicado::find(1);
        //dd();
        $anoLectivoPublicado = $response['anoslectivos']->ya_inicio . "-" . $response['anoslectivos']->ya_fim;
        $turmas = Turma::where([['it_estado_turma', 1], ['vc_anoLectivo', $anoLectivoPublicado]])->get();

        $disciplinas = Disciplinas::where([['it_estado_disciplina', 1]])->get();
        $classes = Classe::where([['it_estado_classe', 1]])->get();
        $users = User::where('vc_tipoUtilizador', '=', 'professor')->get();
        return view('admin.atribuicoes.cadastrar.index', compact('turmas', 'users', 'disciplinas', 'classes'));
    }
    public function tem_registro($array)
    {

        /*   dd($array); */

        return TurmaUser::where($array)->where('it_estado_turma_user', 1)->count();


    }
    public function salvar(Request $request)
    {
        // try {


        //TurmaUser::create($request->all());
        $array['it_idDisciplina'] = $request->it_idDisciplina;
        $array['it_idTurma'] = $request->it_idTurma;

        if ($this->tem_registro($array)) {
            return redirect()->back()->with("error_tem_registro", 1);
        }
        TurmaUser::create([
            'it_idTurma' => $request->it_idTurma,
            'it_idUser' => $request->it_idUser,
            //'it_idClasse'=>$request->it_idClasse,
            'it_idClasse' => Turma::find($request->it_idTurma)->it_idClasse,
            'it_idDisciplina' => $request->it_idDisciplina,

        ]);


        $this->loggerData("Adicionou Turma ao Utilizador " . User::find($request->it_idUser)->vc_nomeUtilizador);
        return redirect()->back()->with('status', '1');
        //} catch (\Exception $exception) {
        return redirect()->back()->with('aviso', '1');
        //}
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TurmaUser
     * @return \Illuminate\Http\Response
     */
    public function ver($id)
    {
        $atribuicao = TurmaUser::findOrFail($id);
        return view('admin.atribuicoes.ver.index', compact('atribuicao'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TurmaUser  $curso
     * @return \Illuminate\Http\Response
     */
    public function editar($id)
    {
        //try {
        $response['anoslectivos'] = AnoLectivoPublicado::find(1);
        //dd();
        $anoLectivoPublicado = $response['anoslectivos']->ya_inicio . "-" . $response['anoslectivos']->ya_fim;
        $c = TurmaUser::find($id);
        //dd($c);
        if ($response['atribuicao'] = TurmaUser::find($id)) {
            //dd($c);
            $atribuicao = TurmaUser::findOrFail($id);
            $turma = Turma::find($atribuicao->it_idTurma);
            $turmas = Turma::where([['it_estado_turma', 1]])->where('vc_anoLectivo', $anoLectivoPublicado)->get();
            $classe = Classe::find($atribuicao->it_idClasse);
            $classes = Classe::where([['it_estado_classe', 1]])->get();
            $disciplinas = Disciplinas::where([['it_estado_disciplina', 1]])->get();
            $disciplina = Disciplinas::find($atribuicao->it_idDisciplina);
            $user = User::find($atribuicao->it_idUser);
            $users = User::where('vc_tipoUtilizador', '=', 'professor')->get();
            $dados['atribuicao'] = $atribuicao;
            $dados['turma'] = $turma;
            $dados['turmas'] = $turmas;
            $dados['classe'] = $classe;
            $dados['classes'] = $classes;
            $dados['disciplinas'] = $disciplinas;
            $dados['disciplina'] = $disciplina;
            $dados['user'] = $user;
            $dados['users'] = $users;
            //$dados['']=$;
            //return view("admin.atribuicoes.editar.index", compact('atribuicao', 'turma', 'user', 'turmas', 'users', 'classe', 'classes', 'disciplina', 'disciplinas'));
            //dd($dados);
            return view("admin.atribuicoes.editar.index", $dados)->with('status', '1');
            //dd($dados);
        } else {
            return redirect('admin/atribuicoes/cadastrar')->with('atribuicao', '1');
        }

        /*} catch (\Exception $exception) {
        return redirect()->back()->with('aviso', '1');
        }*/
    }

    public function listarTurmas($anoLectivo, $curso)
    {
        if ($anoLectivo == 'Todos') {
            $anoLectivo = '';
        }
        if ($curso == 'Todos') {
            $curso = '';
        }

        $response['anolectivo'] = $anoLectivo;
        if ($anoLectivo && $curso) {
            $response['turmas'] = TurmaUser::where([
                ['it_estado_turma_user', 1],
                ['vc_anoLectivo', '=', $anoLectivo],
                ['vc_cursoTurma', '=', $curso]
            ])->get();
        } elseif ($anoLectivo && !$curso) {
            $response['turmas'] = TurmaUser::where([
                ['it_estado_turma_user', 1],
                ['vc_anoLectivo', '=', $anoLectivo]
            ])->get();
        } elseif (!$anoLectivo && $curso) {
            $response['turmas'] = TurmaUser::where([
                ['it_estado_turma_user', 1],
                ['vc_cursoTurma', '=', $curso]
            ])->get();
        } else {
            $response['turmas'] = TurmaUser::where([['it_estado_turma_user', 1]])->get();
        }
        return view('admin.turmas.index', $response);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TurmaUser  $curso
     * @return \Illuminate\Http\Response
     */
    public function atualizar(Request $request, $id)
    {

        $dados = $request->all();
        $array['it_idDisciplina'] = $request->it_idDisciplina;
        $array['it_idTurma'] = $request->it_idTurma;
        $array['it_idUser'] = $request->it_idUser;


        if ($this->tem_registro($array)) {
            return redirect()->back()->with("error_tem_registro", 1);
        }
        $cf = TurmaUser::find($id);
        $tem = $this->disciplina_tem_professor($request);
        if (!$tem) {
            $cf->update($dados);
        } else {
            return redirect()->back()->with('error', 1);
        }


        $this->loggerData("Actualizou Turma do Utilizador " . User::find($cf->it_idUser)->vc_nomeUtilizador);
        $this->Logger->Log('info', 'Actualizou Turma a um Utilizador ');
        return redirect()->back()->with('status', 1);
    }

    public function disciplina_tem_professor($request)
    {
        return TurmaUser::where('it_idTurma', $request->it_idTurma)->where('it_idDisciplina', $request->it_idDisciplina)->where('it_idUser', $request->it_idUser)->count();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TurmaUser  $curso
     * @return \Illuminate\Http\Response
     */
    public function excluir($id)
    {
        try {
            $cf = TurmaUser::find($id);
            //dd(TurmaUser::find($id));
            $user = User::find($cf->it_idUser);
            TurmaUser::find($id)->update(['it_estado_turma_user' => 0]);
            $this->loggerData("Eliminou Turma do Utilizador " . $user->vc_nomeUtilizador);
            return redirect()->back()->with('atribuicao.eliminar.success', '1');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('atribuicao.eliminar.error', '1');
        }
    }


    public function purgar($id)
    {
        try {
            //User::find($id)->delete();
            $response = TurmaUser::find($id);
            $response2 = TurmaUser::find($id)->delete();
            $this->loggerData("Purgou a Turma do Professor");
            return redirect()->back()->with('atribuicao.purgar.success', '1');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('atribuicao.purgar.error', '1');
        }
    }

    public function eliminadas()
    {
        $this->loggerData("Listou as Turma dos Professores eliminadas");

        $response['atribuicoes'] = DB::table('turmas_users')
            ->join('users', 'users.id', '=', 'turmas_users.it_idUser')
            ->join('disciplinas', 'turmas_users.it_idDisciplina', '=', 'disciplinas.id')
            ->where('users.vc_tipoUtilizador', '=', 'professor')
            ->leftJoin('turmas', 'turmas.id', '=', 'turmas_users.it_idTurma')
            ->distinct()
            ->select(
                'turmas_users.it_idUser',
                'turmas_users.id as ident',
                'users.vc_primemiroNome',
                'users.vc_apelido',
                'turmas.vc_nomedaTurma',
                'turmas.vc_classeTurma',
                'turmas.vc_cursoTurma',
                'turmas.vc_salaTurma',
                'turmas.vc_anoLectivo',
                'turmas.it_qtMatriculados',
                'turmas.it_qtdeAlunos',
                'turmas.id as id_turma',
                'disciplinas.id as id_disciplina',

                'disciplinas.vc_nome as disciplina'

            )

            ->where('users.vc_tipoUtilizador', '=', 'professor')
            /* ->where('turmas.vc_anoLectivo', $anoLectivoPublicado) */
            ->where('turmas_users.it_estado_turma_user', 0)
            ->get();

        $response['disciplinas'] = DB::table('turmas_users')
            ->join('users', 'users.id', '=', 'turmas_users.it_idUser')
            ->join('disciplinas', 'turmas_users.it_idDisciplina', '=', 'disciplinas.id')
            ->where('users.vc_tipoUtilizador', '=', 'professor')
            ->distinct()
            ->select(
                'turmas_users.it_idUser',
                'disciplinas.vc_nome as disciplina'
            )

            ->get();

        $response['eliminadas'] = "eliminadas";
        return view('admin.atribuicoes.index', $response);
    }

    public function recuperar($id)
    {
        try {
            //User::find($id)->delete();
            //User::find($id)->delete();
            $response = TurmaUser::find($id);
            $response->update(['it_estado_turma_user' => 1]);
            $this->loggerData("Recuperou Turma do Professor");
            return redirect()->back()->with('atribuicao.recuperar.success', '1');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('atribuicao.recuperar.error', '1');
        }
    }
}