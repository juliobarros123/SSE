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
            ->select('turmas.id as id_turma','turmas.*','classes.*','cursos.*','disciplinas.*','disciplinas.id as id_disciplina');
      
            if(Auth::user()->vc_tipoUtilizador=='Professor'){
                $data['turmas']=   $data['turmas']->where([['turmas_users.it_estado_turma_user', 1], ['turmas_users.it_idUser', $id]])->get();
            }else{
                $data['turmas']=    $data['turmas']->get();
            }
         

        $id_user = (int) $id;
        $data['turma_id'] = '';

        $turma_dt  =  DB::table("direitor_turmas")->where('id_user', $id_user)->offset(0)->limit(1)->get();
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
        $data['turmas'] =    $data['turmas']->where('it_estado_turma', 1)->get();
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

        $response['anoslectivos'] = AnoLectivo::where([['it_estado_anoLectivo', 1]])->get();
        $response['cursos'] = Curso::where([['it_estado_curso', 1]])->get();
        return view('admin/turmas/pesquisar/index', $response);
    }

    public function recebeturma(Request $request)
    {
        $anoLectivo =  $request->vc_anolectivo;
        $curso = $request->vc_curso;
        return redirect("/turmas/listarTurmas/$anoLectivo/$curso");
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

        $turmas=collect();
        
        if(Auth::user()->vc_tipoUtilizador=='Professor')
        {
            
            $response['turmas']=$this->turmas_professor->turmasCoodernador();
    
            if($anoLectivo!=''){

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
                ['it_estado_turma', 1], ['vc_anoLectivo', '=', $anoLectivo], ['vc_cursoTurma', '=', $curso]
            ])->get();
        } elseif ($anoLectivo && !$curso) {
            $response['turmas'] = Turma::where([
                ['it_estado_turma', 1], ['vc_anoLectivo', '=', $anoLectivo]
            ])->get();
        } elseif (!$anoLectivo && $curso) {
            $response['turmas'] = Turma::where([
                ['it_estado_turma', 1], ['vc_cursoTurma', '=', $curso]
            ])->get();
        } else {
            $response['turmas'] = Turma::where([['it_estado_turma', 1]])->get();
        }

        return view('admin.turmas.index', $response);
    }

    public function cadastrarTurmas()
    {
        $dados['classes'] = Classe::where([['it_estado_classe', 1]])->get();
        $dados['anos'] = AnoLectivo::where([['it_estado_anoLectivo', 1]])->get();
        $dados['cursos'] = Curso::where([['it_estado_curso', 1], ['it_estadodoCurso', 1]])->get();
        $dados['ano_letivos'] =  AnoLectivo::where([['it_estado_anoLectivo', 1]])->orderby('id', 'desc')->get();
      
    

        return view('admin.turmas.cadastrar.index', $dados);
    }

    //inserir dados na tabela de turmas
    public function efectuarCadastroDaTurma(CadastrarEEditarTurmaRequest $request)
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

        Turma::create([
            'vc_nomedaTurma' => $request->vc_nomedaTurma,
            'vc_classeTurma' => Classe::find($request->vc_classeTurma)->vc_classe,
            'vc_cursoTurma' => Curso::find($request->vc_cursoTurma)->vc_nomeCurso,
            'vc_anoLectivo' => $anoLectivo->ya_inicio . "-" . $anoLectivo->ya_fim,
            'it_qtdeAlunos' => $request->it_qtdeAlunos,
            'vc_salaTurma'=> $request->vc_salaTurma,
            'vc_turnoTurma' => $request->vc_turnoTurma,
            'it_idAnoLectivo' => $anoLectivo->id,
            'it_idClasse' => $request->vc_classeTurma,
            'it_idCurso' => $request->vc_cursoTurma

        ]);

        //$curso = $request->vc_cursoTurma;
        $anoLectivo = $request->vc_anoLectivo;
        $this->loggerData('Adicionou Turma ' . $request->vc_nomedaTurma);
        return redirect()->back()->with('status', '1');

        // }else{
        //     return redirect()->back()->with("turma","1");
        // }
    }
    public function buscar_ano_lectivo($id_anoLectivo)
    {
        $ano_lectivo=AnoLectivo::find($id_anoLectivo);
        return $ano_lectivo->ya_inicio . '-' . $ano_lectivo->ya_fim;
    }

    public function editarTurmas($id)
    {
        $c = Turma::find($id);
        // dd($c);
        if ($turma = Turma::find($id)) :
            $dados['classes'] = Classe::where([['it_estado_classe', 1]])->get();
            $dados['anos'] = AnoLectivo::where([['it_estado_anoLectivo', 1]])->get();
            $dados['cursos'] = Curso::where([['it_estado_curso', 1], ['it_estadodoCurso', 1]])->get();
            $dados['ano_letivos'] =  AnoLectivo::where([['it_estado_anoLectivo', 1]])->orderby('id', 'desc')->get();
          
        
            return view('admin.turmas.editar.index', compact('turma'),$dados);
        else :
            return redirect('turmas/cadastrarTurmas')->with('turma', '1');

        endif;
    }

    public function efectuarEdicaoDeTurma(Request $request, $id)
    {
        // dd($request);
         //Turma::find($id)->update($request->all());
        // $it_idAnoLectivo = AnoLectivo::where([['it_estado_anoLectivo', 1]])->max('id');
        // $it_id_anoLectivo = $it_idAnoLectivo;
        $it_idAnoLectivo = AnoLectivo::find($request->id_ano_lectivo);
        $curso=Curso::find($request->vc_cursoTurma);
        // dd( $curso);
        Turma::find($id)->update(
            [
                'vc_nomedaTurma' => $request->vc_nomedaTurma,
                'vc_classeTurma' => Classe::find($request->vc_classeTurma)->vc_classe,
                'vc_cursoTurma' => $curso->vc_nomeCurso,
                'vc_anoLectivo' => $it_idAnoLectivo->ya_inicio . "-" . $it_idAnoLectivo->ya_fim,
                'it_qtdeAlunos' => $request->it_qtdeAlunos,
                'vc_turnoTurma' => $request->vc_turnoTurma,
                'it_idCurso' => $request->vc_cursoTurma,
                'it_idClasse'=>$request->vc_classeTurma,
                'vc_salaTurma'=> $request->vc_salaTurma,
            ]

        );
        $curso = $request->vc_nomeCurso;
        $anoLectivo = $request->vc_anoLectivo;
        $this->loggerData('Actualizou Turma ' . $request->vc_nomedaTurma);
        return redirect()->back()->with('update',1);
    }

    public function deletarTurmas($id)
    {
        //Turma::find($id)->delete();

        $response = Turma::find($id);
        $response->update(['it_estado_turma' => 0]);
        $this->loggerData("Eliminou Turma " . $response->vc_nomedaTurma);
        return redirect()->back();
    }
    //

    public function gerarlista(Estudante $estudantes, $id)
    {
     

        $c = $estudantes->StudentForClassroom($id);

        if ($c->count()) :
            //Metodo que gera as listas da turmas
            $data['turma'] = Turma::where([['it_estado_turma', 1]])->find($id);
            $data['alunos'] =  $c;
            $data['cabecalho'] = Cabecalho::find(1);
          /*   $data['bootstrap'] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
            $data['css'] = file_get_contents(__full_path().'css/listas/style.css'); */

            
            if ($data['cabecalho']->vc_nif == "5000298182") {

                //$url = 'cartões/CorMarie/aluno.png';
                $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
                $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');

            } else if ($data['cabecalho']->vc_nif == "7301002327") {

                //$url = 'cartões/InstitutoPolitécnicodoUIGE/aluno.png';
                $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
                $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000303399") {

                //$url = 'cartões/negage/aluno.png';
                $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
                $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000820440") {
            
                //$url = 'cartões/Quilumosso/aluno.png';
                $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
                $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000305308") {

                //$url = 'cartões/Foguetao/aluno.png';
                $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
                $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "7301002572") {

                //$url = 'cartões/LiceuUíge/aluno.png';
                $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
                $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
             } else if ($data['cabecalho']->vc_nif == "7301003617") {

                //$url = 'cartões/ldc/aluno.png';
                $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
                $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000300926") {

                //$url = 'cartões/imagu/aluno.png';
                $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
                $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
            } else {
                //$url = 'images/cartao/aluno.jpg';
                $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
                $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
            }

            $mpdf = new \Mpdf\Mpdf();

            $mpdf->SetFont("arial");
            $mpdf->setHeader();
            $mpdf->defaultfooterline = 0;
            $mpdf->setFooter('{PAGENO}');
            $this->loggerData("Imprimiu Lista da Turma " . $data['turma']->vc_nomedaTurma);

            $html = view("admin/pdfs/listas/alunosdaTurma/index", $data);
            $mpdf->writeHTML($html);
            $mpdf->Output("listasDturma.pdf", "I");
        else :
   
            return redirect()->back()->with('aviso', '1');
        endif;
    }


    public function gerarcaderneta(Estudante $estudantes, $id)
    {
        $c = $estudantes->StudentForClassroom($id);
        // dd($c);

        if ($c->count()) :
            //Metodo que gera as cadernetas do alunos
            $data['turma'] = Turma::where([['it_estado_turma', 1]])->find($id);
            $data['alunos'] =  $c;
            $data['cabecalho'] = Cabecalho::find(1);
        /*     $data["bootstrap"] = file_get_contents("css/caderneta/bootstrap.min.css");
            $data["css"] = file_get_contents("css/caderneta/style.css"); */

            
            if ($data['cabecalho']->vc_nif == "5000298182") {

                //$url = 'cartões/CorMarie/aluno.png';
                $data["css"] = file_get_contents(__full_path().'css/caderneta/style.css');
                $data["bootstrap"] = file_get_contents(__full_path().'css/caderneta/bootstrap.min.css');

            } else if ($data['cabecalho']->vc_nif == "7301002327") {

                //$url = 'cartões/InstitutoPolitécnicodoUIGE/aluno.png';
                $data["css"] = file_get_contents(__full_path().'css/caderneta/style.css');
                $data["bootstrap"] = file_get_contents(__full_path().'css/caderneta/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000303399") {

                //$url = 'cartões/negage/aluno.png';
                $data["css"] = file_get_contents(__full_path().'css/caderneta/style.css');
                $data["bootstrap"] = file_get_contents(__full_path().'css/caderneta/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000820440") {
            
                //$url = 'cartões/Quilumosso/aluno.png';
                $data["css"] = file_get_contents(__full_path().'css/caderneta/style.css');
                $data["bootstrap"] = file_get_contents(__full_path().'css/caderneta/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000305308") {

                //$url = 'cartões/Foguetao/aluno.png';
                $data["css"] = file_get_contents(__full_path().'css/caderneta/style.css');
                $data["bootstrap"] = file_get_contents(__full_path().'css/caderneta/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "7301002572") {

                //$url = 'cartões/LiceuUíge/aluno.png';
                $data["css"] = file_get_contents(__full_path().'css/caderneta/style.css');
                $data["bootstrap"] = file_get_contents(__full_path().'css/caderneta/bootstrap.min.css');
             }else if ($data['cabecalho']->vc_nif == "7301003617") {

                //$url = 'cartões/ldc/aluno.png';
                $data["css"] = file_get_contents(__full_path().'css/caderneta/style.css');
                $data["bootstrap"] = file_get_contents(__full_path().'css/caderneta/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000300926") {

                //$url = 'cartões/imagu/aluno.png';
                $data["css"] = file_get_contents(__full_path().'css/caderneta/style.css');
                $data["bootstrap"] = file_get_contents(__full_path().'css/caderneta/bootstrap.min.css');
            } else {
                //$url = 'images/cartao/aluno.jpg';
                $data["css"] = file_get_contents(__full_path().'css/caderneta/style.css');
                $data["bootstrap"] = file_get_contents(__full_path().'css/caderneta/bootstrap.min.css');
            }

            $mpdf = new \Mpdf\Mpdf([
                'mode' => 'utf-8', 'margin_top' => 10,
                'margin_left' => 10,
                'margin_right' => 10, 'margin_bottom' => 10,
            ]);

            $mpdf->SetFont("arial");
            $mpdf->setHeader();
            $mpdf->AddPage('L');
            $this->loggerData("Gerou Caderneta da turma " . $data['turma']->vc_nomedaTurma);
            $html = view("admin/pdfs/caderneta/index", $data);
            $mpdf->writeHTML($html);
            $mpdf->Output("caderneta.pdf", "I");
        else :
            return redirect('turmas/pesquisar')->with('aviso', 'Não existe nenhum Aluno nesta turma');
        endif;
    }

    public function eliminadas(){
        $response['anolectivo']='';
        $response['turmas']  = Turma::where('it_estado_turma',0)->get();
        $response['eliminadas']="eliminadas";
        
        return view('admin.turmas.index', $response);
     
      }
      public function recuperar($id){
        
        $response = Turma::find($id);
        $response->update(['it_estado_turma' => 1]);
        $this->loggerData('Recuperou Uma Turmas');
        return redirect()->back()->with('feedback', ['status'=>'1','sms'=>'Turmas recuperada com sucesso']);
     
      }
      public function purgar($id){
        // dd($id);
        try{
          $response = Turma::find($id)->delete();
          $this->loggerData('Purgou Uma turma');
          return redirect()->back()->with('feedback', ['status'=>'1','sms'=>'Turmas purgada com sucesso']);
          // return redirect()->back();
        }catch(\Exception $ex){
          return redirect()->back()->with('feedback', ['error'=>'1','sms'=>'Erro,possivelmente essa turma está relacionada com algum professor']);
        }
        
      }
}
