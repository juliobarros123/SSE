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
        $turmas = fh_turmas();
        if ($request->id_ano_lectivo) {

            $turmas = $turmas->where('turmas.it_idAnoLectivo', $request->id_ano_lectivo);
        }

        if ($request->id_curso) {
            // dd(  $turmas->get(),$request->id_curso);
            $turmas = $turmas->where('turmas.it_idCurso', $request->id_curso);
        }
        $response['turmas'] = $turmas->get();
        // $anolectivo = fh_anos_lectivos()->where('anoslectivos.id', $request->id_ano_lectivo)->first();
        $anolectivo = fha_ano_lectivo_publicado();
        //    dd( $response['anolectivo']);
        $response['anolectivo'] = "$anolectivo->ya_inicio/$anolectivo->ya_fim";
        return view('admin.turmas.index', $response);


        // return redirect("/turmas/listarTurmas/$anoLectivo/$curso");
    }

    public function listarTurmas($anoLectivo, $curso)
    {


        if ($request->id_ano_lectivo) {

            $alunos = $alunos->where('candidatos.id_ano_lectivo', $request->id_ano_lectivo);
        }

        if ($request->id_curso) {
            // dd( $alunos->get(),$request->id_curso);
            $alunos = $alunos->where('candidatos.id_curso', $request->id_curso);
        }
        $response['anolectivo'] = $anoLectivo;

        $turmas = collect();

        if (Auth::user()->vc_tipoUtilizador == 'Professor') {

            $response['turmas'] = $this->turmas_professor->turmasCoodernador();

            if ($anoLectivo != '') {

                $response['turmas'] = $response['turmas']->where('turmas.vc_anoLectivo', $anoLectivo);
            }
            if ($curso != '') {
                $response['turmas'] = $response['turmas']->where('turmas.vc_cursoTurma', $curso);
            }

            $response['turmas'] = $response['turmas']->get();

            return view('admin.coordenador_curso.turmas_curso.index', $response);
        }



        if ($anoLectivo && $curso) {
            $response['turmas'] = Turma::where([
                ['it_estado_turma', 1],
                ['vc_anoLectivo', '=', $anoLectivo],
                ['vc_cursoTurma', '=', $curso]
            ])->get();
        } elseif ($anoLectivo && !$curso) {
            $response['turmas'] = Turma::where([
                ['it_estado_turma', 1],
                ['vc_anoLectivo', '=', $anoLectivo]
            ])->get();
        } elseif (!$anoLectivo && $curso) {
            $response['turmas'] = Turma::where([
                ['it_estado_turma', 1],
                ['vc_cursoTurma', '=', $curso]
            ])->get();
        } else {
            $response['turmas'] = Turma::where([['it_estado_turma', 1]])->get();
        }

        return view('admin.turmas.index', $response);
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
       
        Turma::where('turmas.slug',$slug)->update(
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
                'mode' => 'utf-8', 'margin_top' => 5,
                
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


    public function gerarcaderneta(Estudante $estudantes, $id)
    {
        $c = $estudantes->StudentForClassroom($id);
        // dd($c);

        if ($c->count()):
            //Metodo que gera as cadernetas do alunos
            $data['turma'] = Turma::where([['it_estado_turma', 1]])->find($id);
            $data['alunos'] = $c;
            $data['cabecalho'] = Cabecalho::find(1);
            /*     $data["bootstrap"] = file_get_contents("css/caderneta/bootstrap.min.css");
                $data["css"] = file_get_contents("css/caderneta/style.css"); */


            if ($data['cabecalho']->vc_nif == "5000298182") {

                //$url = 'cartões/CorMarie/aluno.png';
                $data["css"] = file_get_contents('css/caderneta/style.css');
                $data["bootstrap"] = file_get_contents('css/caderneta/bootstrap.min.css');

            } else if ($data['cabecalho']->vc_nif == "7301002327") {

                //$url = 'cartões/InstitutoPolitécnicodoUIGE/aluno.png';
                $data["css"] = file_get_contents('css/caderneta/style.css');
                $data["bootstrap"] = file_get_contents('css/caderneta/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000303399") {

                //$url = 'cartões/negage/aluno.png';
                $data["css"] = file_get_contents('css/caderneta/style.css');
                $data["bootstrap"] = file_get_contents('css/caderneta/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000820440") {

                //$url = 'cartões/Quilumosso/aluno.png';
                $data["css"] = file_get_contents('css/caderneta/style.css');
                $data["bootstrap"] = file_get_contents('css/caderneta/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000305308") {

                //$url = 'cartões/Foguetao/aluno.png';
                $data["css"] = file_get_contents('css/caderneta/style.css');
                $data["bootstrap"] = file_get_contents('css/caderneta/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "7301002572") {

                //$url = 'cartões/LiceuUíge/aluno.png';
                $data["css"] = file_get_contents('css/caderneta/style.css');
                $data["bootstrap"] = file_get_contents('css/caderneta/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "7301003617") {

                //$url = 'cartões/ldc/aluno.png';
                $data["css"] = file_get_contents('css/caderneta/style.css');
                $data["bootstrap"] = file_get_contents('css/caderneta/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000300926") {

                //$url = 'cartões/imagu/aluno.png';
                $data["css"] = file_get_contents('css/caderneta/style.css');
                $data["bootstrap"] = file_get_contents('css/caderneta/bootstrap.min.css');
            } else {
                //$url = 'images/cartao/aluno.jpg';
                $data["css"] = file_get_contents('css/caderneta/style.css');
                $data["bootstrap"] = file_get_contents('css/caderneta/bootstrap.min.css');
            }

            $mpdf = new \Mpdf\Mpdf([
                'mode' => 'utf-8',
                'margin_top' => 10,
                'margin_left' => 10,
                'margin_right' => 10,
                'margin_bottom' => 10,
            ]);

            $mpdf->SetFont("arial");
            $mpdf->setHeader();
            $mpdf->AddPage('L');
            $this->loggerData("Gerou Caderneta da turma " . $data['turma']->vc_nomedaTurma);
            $html = view("admin/pdfs/caderneta/index", $data);
            $mpdf->writeHTML($html);
            $mpdf->Output("caderneta.pdf", "I");
        else:
            return redirect('turmas/pesquisar')->with('aviso', 'Não existe nenhum Aluno nesta turma');
        endif;
    }

    public function eliminadas()
    {
        $response['anolectivo'] = '';
        $response['turmas'] = Turma::where('it_estado_turma', 0)->get();
        $response['eliminadas'] = "eliminadas";

        return view('admin.turmas.index', $response);

    }
    public function recuperar($id)
    {

        $response = Turma::find($id);
        $response->update(['it_estado_turma' => 1]);
        $this->loggerData('Recuperou Uma Turmas');
        return redirect()->back()->with('feedback', ['status' => '1', 'sms' => 'Turmas recuperada com sucesso']);

    }
    public function eliminar($slug)
    {
        // dd($id);
        try {
            $response = Turma::where('turmas.slug',$slug)->delete();
            $this->loggerData('Eliminou  turma'.$response->vc_nomedaTurma);
            return redirect()->back()->with('feedback', ['type' => 'success', 'sms' => 'Turmas eliminada com sucesso']);
            // return redirect()->back();

        } catch (\Exception $ex) {
        return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Erro,possivelmente essa turma está relacionada com algum professor']);
          
        }

    }
}