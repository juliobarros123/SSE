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
        $response['anoslectivos'] = fh_anos_lectivos()->get();
        $response['cursos'] = fh_cursos()->get();
        return view('admin/atribuicoes/pesquisar/index', $response);

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


    public function index(Request $request)
    {

        $response['anoslectivos'] = fha_ano_lectivo_publicado();
        //dd();
        $anoLectivoPublicado = $response['anoslectivos']->ya_inicio . "-" . $response['anoslectivos']->ya_fim;

        $atribuicoes = fh_turmas_professores();
        $response['disciplinas'] = fh_professores_disciplinas()->get();
        if (session()->get('filtro_turma_user')) {
            if (!$request->id_curso) {
                $filtro_turma_user = session()->get('filtro_turma_user');
                $request->id_curso = $filtro_turma_user['id_curso'];
            }
            if (!$request->id_ano_lectivo) {
                $filtro_turma_user = session()->get('filtro_turma_user');
                $request->id_ano_lectivo = $filtro_turma_user['id_ano_lectivo'];
            }
        }
        if ($request->id_ano_lectivo != 'Todos' && $request->id_ano_lectivo) {

            $atribuicoes = $atribuicoes->where('turmas.it_idAnoLectivo', $request->id_ano_lectivo);
        }

        if ($request->id_curso != 'Todos' && $request->id_curso) {
            // dd(  $atribuicoes->get(),$request->id_curso);
            $atribuicoes = $atribuicoes->where('turmas.it_idCurso', $request->id_curso);
        }
        $data = [
            'id_ano_lectivo' => $request->id_ano_lectivo,
            'id_curso' => $request->id_curso,
        ];
        storeSession('filtro_turma_user', $data);
        $response['atribuicoes'] = $atribuicoes->get();
        // dd( $response['atribuicoes']);
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
        $response['anoslectivos'] = fha_ano_lectivo_publicado();
        //dd();
        $response['anoLectivoPublicado'] = $response['anoslectivos']->ya_inicio . "-" . $response['anoslectivos']->ya_fim;
        $response['turmas'] = fh_turmas()->get();
        // dd(  $response['turmas'] );
        $response['disciplinas'] = fh_disciplinas()->get();
        $response['classes'] = fh_classes()->get();
        $response['users'] = fh_professores()->get();
        return view('admin.atribuicoes.cadastrar.index', $response);
    }
    public function tem_registro($array)
    {

        /*   dd($array); */

        return fh_turmas_professores()->where($array)->count();


    }
    public function salvar(Request $request)
    {
        try {


            //TurmaUser::create($request->all());
            $array['it_idDisciplina'] = $request->it_idDisciplina;
            $array['it_idTurma'] = $request->it_idTurma;

            if ($this->tem_registro($array)) {
                return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Atribuição existe']);

            }
            TurmaUser::create([
                'it_idTurma' => $request->it_idTurma,
                'it_idUser' => $request->it_idUser,
                //'it_idClasse'=>$request->it_idClasse,
                'it_idClasse' => Turma::find($request->it_idTurma)->it_idClasse,
                'it_idDisciplina' => $request->it_idDisciplina,
                'id_cabecalho' => Auth::User()->id_cabecalho

            ]);


            $this->loggerData("Adicionou Turma ao Utilizador " . User::find($request->it_idUser)->vc_nomeUtilizador);
            return redirect()->back()->with('feedback', ['type' => 'success', 'sms' => 'Professor foi atribuido a turma com sucesso']);

        } catch (\Exception $exception) {
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado, verifica os dados se estão corretos']);


        }
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
    public function editar($slug)
    {
        //try {
        try {
            $turma_professor = fh_turmas_professores()->where('turmas_users.slug', $slug)->first();
            // dd($c);
            if ($turma_professor):
                // dd($turma_professor);
// dd( $turma_professor);
                $atribuicao = $turma_professor;
                $turma = fh_turmas()->where('turmas.id', $turma_professor->it_idTurma)->first();

                $alp = fha_ano_lectivo_publicado();

                $turmas = fh_turmas()->where('turmas.it_idAnoLectivo', $alp->id_anoLectivo)->get();
                $classe = Classe::find($atribuicao->it_idClasse);
                $classes = fh_classes()->get();
                $disciplinas = fh_disciplinas()->get();
                $disciplina = Disciplinas::find($atribuicao->it_idDisciplina);
                // dd(  $disciplina );
                $user = User::find($atribuicao->it_idUser);
                $users = fh_professores()->get();
                $dados['atribuicao'] = $atribuicao;
                $dados['turma'] = $turma;
                $dados['turmas'] = $turmas;
                $dados['classe'] = $classe;
                $dados['classes'] = $classes;
                $dados['disciplinas'] = $disciplinas;
                $dados['disciplina'] = $disciplina;
                $dados['user'] = $user;
                $dados['users'] = $users;
                $dados['turma'] = $turma;
                $dados['classes'] = fh_classes()->get();
                // $dados['anos'] = AnoLectivo::where([['it_estado_anoLectivo', 1]])->get();
                $dados['cursos'] = fh_cursos()->get();
                $dados['ano_letivos'] = fh_anos_lectivos()->get();
                // dd( $dados['classes']);

                return view("admin.atribuicoes.editar.index", $dados);

            else:
                return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado']);


            endif;
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado']);
        }




        /*} catch (\Exception $exception) {
        return redirect()->back()->with('aviso', '1');
        }*/
    }




    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TurmaUser  $curso
     * @return \Illuminate\Http\Response
     */
    public function atualizar(Request $request, $slug)
    {

        $dados = $request->all();
        $array['it_idDisciplina'] = $request->it_idDisciplina;
        $array['it_idTurma'] = $request->it_idTurma;
        $array['it_idUser'] = $request->it_idUser;


        if ($this->tem_registro($array)) {
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Atribuição já existe']);

        }
        $cf = TurmaUser::where('slug', $slug)->first();
        $tem = $this->disciplina_tem_professor($request);
        if (!$tem) {
            $cf->update($dados);
        } else {
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Disciplina já está sendo lecciona por outro professor nesta turma']);

        }


        $this->loggerData("Actualizou Turma do Utilizador " . User::find($cf->it_idUser)->vc_nomeUtilizador);
        $this->Logger->Log('info', 'Actualizou Turma a um Utilizador ');
        return redirect()->back()->with('status', 1);
    }

    public function disciplina_tem_professor($request)
    {
        return TurmaUser::where('it_idTurma', $request->it_idTurma)
            ->where('it_idDisciplina', $request->it_idDisciplina)
            ->where('id_cabecalho', Auth::User()->id_cabecalho)
            ->where('it_idUser', $request->it_idUser)->count();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TurmaUser  $curso
     * @return \Illuminate\Http\Response
     */
    public function excluir($slug)
    {
        try {
            // dd("ola");
            $turma_professor = fh_turmas_professores()->where('turmas_users.slug', $slug)->first();
            if ($turma_professor):
                //dd(TurmaUser::find($id));
                $user = User::find($turma_professor->it_idUser);
                //    $d= fh_turmas_professores()->where('turmas_users.slug', $slug)->first();
                // dd($d);
                TurmaUser::where('slug', $slug)->delete();
                $this->loggerData("Eliminou professor da turma com nome de " . $user->vc_nomeUtilizador);
                return redirect()->back()->with('feedback', ['type' => 'success', 'sms' => 'Atribuição eliminada com sucesso']);

            else:
                return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado']);


            endif;
        } catch (\Exception $e) {

            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado']);
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


}