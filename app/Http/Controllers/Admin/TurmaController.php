<?php
/* Este sistema esta protegido pelos direitos autoriais do Instituto de Telecomunicações criado ao
abrigo do decreto executivo conjunto nº29/85 de 29 de Abril,
dos Ministérios da Educação e dos Transportes e Comunicações,
publicado no Diário da República, 1ª série nº 35/85, nos termos
do artigo 62º da Lei Constitucional.

contactos:
site:www.itel.gov.ao
Telefone I: +244 931 313 333
Telefone II: +244 997 788 768
Telefone III: +244 222 381 640
Email I: secretariaitel@hotmail.com
Email II: geral@itel.gov.ao*/

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Turma;
use App\Models\TurmaUser;
use App\Models\AnoLectivo;
use App\Models\Curso;
use App\Http\Requests\turmaRequests\CadastrarEEditarTurmaRequest;
use App\Models\Cabecalho;
use Illuminate\Support\Facades\DB;
use App\Models\Classe;
use App\Models\DireitorTurma;
use App\Models\Estudante;
use App\Models\Logger;
use Illuminate\Support\Facades\Auth;
use Turmas;

class TurmaController extends Controller
{
    private $Logger, $turmas_professor;
    public function __construct(TurmaUser $turmas_professor)
    {
        $this->Logger = new Logger();
        $this->turmas_professor = $turmas_professor;
    }

    public function turmasProfessor($id)
    {


        $data['anolectivo'] = '';

        $data['turmas'] = DB::table('turmas_users')
            ->join('turmas', 'turmas_users.it_idTurma', '=', 'turmas.id')
            ->join('users', 'turmas_users.it_idUser', '=', 'users.id')
            ->join('classes', 'turmas.it_idClasse', '=', 'classes.id')
            ->join('cursos', 'turmas.it_idCurso', '=', 'cursos.id')
            ->join('disciplinas', 'turmas_users.it_idDisciplina', '=', 'disciplinas.id')
            ->select('turmas.id as id_turma', 'turmas.*', 'classes.*', 'cursos.*', 'disciplinas.*', 'disciplinas.id as id_disciplina');

        if (Auth::user()->vc_tipoUtilizador == 'Professor') {
            $data['turmas'] = $data['turmas']->where([['turmas_users.it_estado_turma_user', 1], ['turmas_users.it_idUser', $id]])->get();
        } else {
            $data['turmas'] = $data['turmas']->get();
        }


        $id_user = (int) $id;
        $data['turma_id'] = '';

        $turma_dt = DB::table("direitor_turmas")->where('id_user', $id_user)->offset(0)->limit(1)->get();
        if (count($turma_dt) > 0) {
            $data['turma_id'] = $turma_dt[0]->id;
        }


        return view('admin.turmas.professor.index', $data);
    }




    public function turmas()
    {
        $data['anolectivo'] = '';
        $data['turmas'] = DB::table('turmas')->select('turmas.id as id_turma', 'turmas.*');


        // if(Auth::user()->vc_tipoUtilizador=='Professor'){
        //     $data['turmas']=   $data['turmas']->where([['turmas_users.it_estado_turma_user', 1], ['turmas_users.it_idUser', $id]])->get();
        // }else{
        $data['turmas'] = $data['turmas']->where('it_estado_turma', 1)->get();
        // }

        // $id_user = (int) $id;
        // $data['turma_id'] = '';

        // $turma_dt  =  DB::table("direitor_turmas")->where('id_user', $id_user)->offset(0)->limit(1)->get();
        // if (count($turma_dt) > 0) {
        //     $data['turma_id'] = $turma_dt[0]->id;
        // }

        return view('admin.turmas.index', $data);
    }

    public function loggerData($mensagem)
    {
        $dados_Auth = Auth::user()->vc_primemiroNome . ' ' . Auth::user()->vc_apelido . ' Com o nivel de ' . Auth::user()->vc_tipoUtilizador . ' ';
        $this->Logger->Log('info', $dados_Auth . $mensagem);
    }

    public function pesquisar()
    {

        $response['anoslectivos'] = fh_anos_lectivos()->get();
        $response['cursos'] = fh_cursos()->get();
        return view('admin/turmas/pesquisar/index', $response);
    }

    public function ver(Request $request)
    {
        if (session()->get('filtro_turma')) {
            if (!$request->id_curso) {
                $filtro_turma = session()->get('filtro_turma');
                $request->id_curso = $filtro_turma['id_curso'];
            }
            if (!$request->id_ano_lectivo) {
                $filtro_turma = session()->get('filtro_turma');
                $request->id_ano_lectivo = $filtro_turma['id_ano_lectivo'];
            }
        }
        $turmas = fh_turmas();
        if ($request->id_ano_lectivo != 'Todos' && $request->id_ano_lectivo) {

            $turmas = $turmas->where('turmas.it_idAnoLectivo', $request->id_ano_lectivo);
        }

        if ($request->id_curso != 'Todos' && $request->id_curso) {
            // dd(  $turmas->get(),$request->id_curso);
            $turmas = $turmas->where('turmas.it_idCurso', $request->id_curso);
        }
        $response['turmas'] = $turmas->get();
        // $anolectivo = fh_anos_lectivos()->where('anoslectivos.id', $request->id_ano_lectivo)->first();
        $anolectivo = fha_ano_lectivo_publicado();
        $data = [
            'id_ano_lectivo' => $request->id_ano_lectivo,
            'id_curso' => $request->id_curso,
        ];
        storeSession('filtro_turma', $data);
        //    dd( $response['anolectivo']);
        $response['anolectivo'] = "$anolectivo->ya_inicio/$anolectivo->ya_fim";
        return view('admin.turmas.index', $response);


        // return redirect("/turmas/listarTurmas/$anoLectivo/$curso");
    }



    public function cadastrar()
    {
        $dados['classes'] = fh_classes()->get();
        // $dados['anos'] = AnoLectivo::where([['it_estado_anoLectivo', 1]])->get();
        $dados['cursos'] = fh_cursos()->get();
        $dados['ano_letivos'] = fh_anos_lectivos()->get();


        return view('admin.turmas.cadastrar.index', $dados);
    }

    //inserir dados na tabela de turmas
    public function inserir(CadastrarEEditarTurmaRequest $request)
    {

        // $this->buscarIdPorAnoLectivo($request);
        //Turma::create($request->all());

        $anoLectivo = AnoLectivo::find($request->id_ano_lectivo);
        //dd($it_idAnoLectivo->ya_inicio);
        //dd($request);


        // $turmas = Turma::where([
        // ['vc_nomedaTurma', '=', $request->vc_nomedaTurma],
        // ['vc_classeTurma', '=', $request->vc_classeTurma]
        // ] )->first();

        // if($turmas === null){

        //     //dd($turmas);

        // $curso = $request->vc_cursoTurma;
        $cursoTurma = Curso::find($request->vc_cursoTurma)->vc_nomeCurso;
        // dd($request);
        $turma = Turma::create([
            'vc_nomedaTurma' => $request->vc_nomedaTurma,
            'it_qtdeAlunos' => $request->it_qtdeAlunos,
            'vc_salaTurma' => $request->vc_salaTurma,
            'vc_turnoTurma' => $request->vc_turnoTurma,
            'it_idAnoLectivo' => $anoLectivo->id,
            'it_idClasse' => $request->vc_classeTurma,
            'it_idCurso' => $request->vc_cursoTurma,
            'id_cabecalho' => Auth::User()->id_cabecalho
        ]);
        // dd($turma);
        //$curso = $request->vc_cursoTurma;
        // $anoLectivo = $request->vc_anoLectivo;
        $this->loggerData('Adicionou Turma ' . $request->vc_nomedaTurma);
        return redirect()->back()->with('feedback', ['type' => 'success', 'sms' => 'Turma cadastrada com sucesso']);


        // }else{
        //     return redirect()->back()->with("turma","1");
        // }
    }
    public function buscar_ano_lectivo($id_anoLectivo)
    {
        $ano_lectivo = AnoLectivo::find($id_anoLectivo);
        return $ano_lectivo->ya_inicio . '-' . $ano_lectivo->ya_fim;
    }

    public function editar($slug)
    {
        $turma = fh_turmas_slug($slug)->first();
        // dd($c);
        if ($turma):
            $dados['turma'] = $turma;
            $dados['classes'] = fh_classes()->get();
            // $dados['anos'] = AnoLectivo::where([['it_estado_anoLectivo', 1]])->get();
            $dados['cursos'] = fh_cursos()->get();
            $dados['ano_letivos'] = fh_anos_lectivos()->get();


            return view('admin.turmas.editar.index', $dados);
        else:
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado']);


        endif;
    }

    public function actualizar(Request $request, $slug)
    {

        Turma::where('turmas.slug', $slug)->update(
            [
                'vc_nomedaTurma' => $request->vc_nomedaTurma,
                'it_qtdeAlunos' => $request->it_qtdeAlunos,
                'vc_salaTurma' => $request->vc_salaTurma,
                'vc_turnoTurma' => $request->vc_turnoTurma,
                'it_idClasse' => $request->vc_classeTurma,
                'it_idCurso' => $request->vc_cursoTurma
            ]

        );

        $this->loggerData('Actualizou Turma ' . $request->vc_nomedaTurma);
        return redirect()->back()->with('feedback', ['type' => 'success', 'sms' => 'Turma actualizada com sucesso']);

    }


    //

    public function imprimir_alunos(Estudante $estudantes, $slug)
    {
        $turma_alunos = fha_turma_alunos($slug);
        //    dd($turma_alunos);


        //Metodo que gera as listas da turmas
        $data['turma'] = fh_turmas_slug($slug)->first();
        // dd(  $data['turma']);
        $data['cabecalho'] = fh_cabecalho();
        $data['turma_alunos'] = $turma_alunos;
        // dd( $data['turma_alunos']);
        // dd( $data['cabecalho']);
        // /*   $data['bootstrap'] = file_get_contents('css/listas/bootstrap.min.css');
        $data['css'] = file_get_contents('css/lista/style-2.css');
        // Dados para a tabela

        // Carregar a view


        // Parâmetros da view

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'margin_top' => 5,

        ]);

        $mpdf->SetFont("arial");
        $mpdf->setHeader();
        $mpdf->defaultfooterline = 0;

        $mpdf->setFooter('{PAGENO}');

        $this->loggerData("Imprimiu Lista da Turma " . $data['turma']->vc_nomedaTurma);

        $html = view("admin/pdfs/listas/alunos-turma/index", $data);
        // return  $html;
        $mpdf->writeHTML($html);

        $mpdf->Output("lista-turma.pdf", "I");

    }





    public function eliminar($slug)
    {
        // dd($id);
        try {
            $response = Turma::where('turmas.slug', $slug)->delete();
            $this->loggerData('Eliminou  turma' . $response->vc_nomedaTurma);
            return redirect()->back()->with('feedback', ['type' => 'success', 'sms' => 'Turmas eliminada com sucesso']);
            // return redirect()->back();

        } catch (\Exception $ex) {
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Erro,possivelmente essa turma está relacionada com algum professor']);

        }

    }
}