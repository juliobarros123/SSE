<?php

namespace App\Http\Controllers\Admin\relatorios;

use App\Http\Controllers\Controller;
use App\Models\AnoLectivo;
use App\Models\Cabecalho;
use App\Models\Estatistica;
use Illuminate\Http\Request;
use App\Models\Logger;
use App\Models\Matricula;
use App\Models\Curso;
use App\Models\Classe;
use Illuminate\Support\Facades\DB;
class RemController extends Controller
{
    //

    private $Logger;
    public function __construct()
    {
        $this->Logger = new Logger();
    }
    public function pesquisar()
    {
        $response['anoslectivos'] = AnoLectivo::where([['it_estado_anoLectivo', 1]])->get();
        return view('admin/relatorios/matricula/index', $response);
    }

    public function recebeRem(Request $request)
    {
        $anoLectivo = $request->vc_anolectivo;

        return redirect("Admin/lista/Rem/$anoLectivo");
    }


    public function lista(Estatistica $as, $anoLectivo)
    {
        /* $response["bootstrap"] = file_get_contents("css/relatorio/bootstrap.min.css");
        $response["style"] = file_get_contents("css/relatorio/style.css"); */


        
        $response['cabecalho'] = Cabecalho::first();
        if ($response['cabecalho']->vc_nif == "5000298182") {

            //$url = 'cartões/CorMarie/aluno.png';
            $response["style"] = file_get_contents(__full_path().'css/relatorio/style.css');
           $response['bootstrap'] = file_get_contents(__full_path().'css/relatorio/bootstrap.min.css');

        } else if ($response['cabecalho']->vc_nif == "7301002327") {

            //$url = 'cartões/InstitutoPolitécnicodoUIGE/aluno.png';
            $response["style"] = file_get_contents(__full_path().'css/relatorio/style.css');
           $response['bootstrap'] = file_get_contents(__full_path().'css/relatorio/bootstrap.min.css');
        } else if ($response['cabecalho']->vc_nif == "5000303399") {

            //$url = 'cartões/negage/aluno.png';
            $response["style"] = file_get_contents(__full_path().'css/relatorio/style.css');
           $response['bootstrap'] = file_get_contents(__full_path().'css/relatorio/bootstrap.min.css');
        } else if ($response['cabecalho']->vc_nif == "5000820440") {
        
            //$url = 'cartões/Quilumosso/aluno.png';
            $response["style"] = file_get_contents(__full_path().'css/relatorio/style.css');
           $response['bootstrap'] = file_get_contents(__full_path().'css/relatorio/bootstrap.min.css');
        } else if ($response['cabecalho']->vc_nif == "5000305308") {

            //$url = 'cartões/Foguetao/aluno.png';
            $response["style"] = file_get_contents(__full_path().'css/relatorio/style.css');
           $response['bootstrap'] = file_get_contents(__full_path().'css/relatorio/bootstrap.min.css');
        } else if ($response['cabecalho']->vc_nif == "7301002572") {

            //$url = 'cartões/LiceuUíge/aluno.png';
            $response["style"] = file_get_contents(__full_path().'css/relatorio/style.css');
           $response['bootstrap'] = file_get_contents(__full_path().'css/relatorio/bootstrap.min.css');
        } else if ($response['cabecalho']->vc_nif == "7301003617") {

            //$url = 'cartões/ldc/aluno.png';
            $response["style"] = file_get_contents(__full_path().'css/relatorio/style.css');
           $response['bootstrap'] = file_get_contents(__full_path().'css/relatorio/bootstrap.min.css');
        }else if ($response['cabecalho']->vc_nif == "5000300926") {

            //$url = 'cartões/imagu/aluno.png';
            $response["style"] = file_get_contents(__full_path().'css/relatorio/style.css');
           $response['bootstrap'] = file_get_contents(__full_path().'css/relatorio/bootstrap.min.css');
        } else {
            //$url = 'images/cartao/aluno.jpg';
            $response["style"] = file_get_contents(__full_path().'css/relatorio/style.css');
           $response['bootstrap'] = file_get_contents(__full_path().'css/relatorio/bootstrap.min.css');
        }
        $response['titulo'] = "Estatística dos Alunos matriculados";
        $response['data'] = $anoLectivo;


        $response['totalGeral'] = $as->Rem($anoLectivo)->count();
        $response['totalD']  = $as->Rem($anoLectivo)->where([['alunnos.vc_dificiencia', '=', "Sim"]])->count();
        $response['totalM'] = $as->Rem($anoLectivo)->where([['alunnos.vc_genero', '=', "Masculino"]])->count();
        $response['totalF']  = $as->Rem($anoLectivo)->where([['alunnos.vc_genero', '=', "Feminino"]])->count();


        $mpdf = new \Mpdf\Mpdf();
        $mpdf->defaultfooterline = 0;
        $mpdf->setFooter('{PAGENO}');
        $this->Logger->Log('info', 'Imprimiu a Lista da Estatística dos Alunos matriculados');
        $html = view("admin/pdfs/matricula/relatorio", $response);
        $mpdf->writeHTML($html);
        $mpdf->Output("matricula.pdf", "I");
    }

    

    public function relatorio_matricula_pesquisar(Request $dados)
    {
        $response['classes'] = Classe::where([['it_estado_classe', 1]])->get();
      
        $response['anoslectivos'] = AnoLectivo::where([['it_estado_anoLectivo', 1]])->get();
        $response['cursos'] = Curso::where([['it_estado_curso', 1]])->get();

        return view('admin.relatorios.matricula.pesquisar.index', $response);
    }
    public function relatorio_matricula(Request $request, Estatistica $as)
    {
     
        $anoLectivo = $request->vc_anolectivo;
        $curso = $request->vc_curso;
        $dia= $request->data;
        if ($anoLectivo == 'Todos') {
            $anoLectivo = '';
        }
        if ($curso == 'Todos') {
            $curso = '';
        }
        if ($anoLectivo && $curso) {

            $resultCurso = Curso::where('vc_nomeCurso', $curso)->first();
            $response['id_curso'] = $resultCurso ->id;
            $response['vc_curso'] = $resultCurso ->vc_nomeCurso;
            $response['matriculados'] =  $as->Rem($anoLectivo, $dia)->where('vc_anoLectivo', '=', $anoLectivo)
            ->where('id_curso', '=', $resultCurso->id)->where('it_estado_aluno', 1
            )->where('it_estado_matricula', 1);
        } elseif ($anoLectivo && !$curso) {
       
            $response['matriculados'] =  $as->Rem($anoLectivo, $dia)
            ->where('vc_anoLectivo', '=', $anoLectivo)
            ->where('it_estado_matricula', 1);
            
        } elseif (!$anoLectivo && $curso) {
            
            $resultCurso = Curso::where('vc_nomeCurso', $curso)->first();
            $response['id_curso'] = $resultCurso ->id;
            $response['vc_curso'] = $resultCurso ->vc_nomeCurso;
            $response['matriculados'] = $as->Rem($anoLectivo, $dia)->where('id_curso', $resultCurso->id)
           ->where('it_estado_matricula', 1);
        
        } else if($dia!=null){
  
            $response['matriculados'] = DB::table('matriculas')
            ->join('turmas', 'matriculas.it_idTurma', '=', 'turmas.id')
            ->join('classes', 'matriculas.it_idClasse', '=', 'classes.id')
            ->join('cursos', 'matriculas.it_idCurso', '=', 'cursos.id')
            ->join('alunnos', 'matriculas.it_idAluno', '=', 'alunnos.id')
            ->where('matriculas.it_estado_matricula', 1)
            ->select('matriculas.*','cursos.*','cursos.id as id_curso','turmas.*','classes.*','alunnos.*')
            ->whereDate('matriculas.created_at', $dia)
            ->get();
          
        }else {
            $response['matriculados'] = DB::table('matriculas')
            ->join('turmas', 'matriculas.it_idTurma', '=', 'turmas.id')
            ->join('classes', 'matriculas.it_idClasse', '=', 'classes.id')
            ->join('cursos', 'matriculas.it_idCurso', '=', 'cursos.id')
            ->join('alunnos', 'matriculas.it_idAluno', '=', 'alunnos.id')
            ->where('matriculas.it_estado_matricula', 1)
            ->select('matriculas.*','cursos.*','cursos.id as id_curso','turmas.*','classes.*','alunnos.*')
            ->get();
        }
      if(isset($request->data)){
        $response['dia']=$request->data;
        $curso = $request->vc_curso;
    
       /*  $response["bootstrap"] = file_get_contents("css/relatorio/bootstrap.min.css");
        $response["style"] = file_get_contents("css/relatorio/style.css"); */
        $response['cabecalho'] = Cabecalho::first();
        if ($response['cabecalho']->vc_nif == "5000298182") {

            //$url = 'cartões/CorMarie/aluno.png';
            $response["style"] = file_get_contents(__full_path().'css/relatorio/style.css');
           $response['bootstrap'] = file_get_contents(__full_path().'css/relatorio/bootstrap.min.css');

        } else if ($response['cabecalho']->vc_nif == "7301002327") {

            //$url = 'cartões/InstitutoPolitécnicodoUIGE/aluno.png';
            $response["style"] = file_get_contents(__full_path().'css/relatorio/style.css');
           $response['bootstrap'] = file_get_contents(__full_path().'css/relatorio/bootstrap.min.css');
        } else if ($response['cabecalho']->vc_nif == "5000303399") {

            //$url = 'cartões/negage/aluno.png';
            $response["style"] = file_get_contents(__full_path().'css/relatorio/style.css');
           $response['bootstrap'] = file_get_contents(__full_path().'css/relatorio/bootstrap.min.css');
        } else if ($response['cabecalho']->vc_nif == "5000820440") {
        
            //$url = 'cartões/Quilumosso/aluno.png';
            $response["style"] = file_get_contents(__full_path().'css/relatorio/style.css');
           $response['bootstrap'] = file_get_contents(__full_path().'css/relatorio/bootstrap.min.css');
        } else if ($response['cabecalho']->vc_nif == "5000305308") {

            //$url = 'cartões/Foguetao/aluno.png';
            $response["style"] = file_get_contents(__full_path().'css/relatorio/style.css');
           $response['bootstrap'] = file_get_contents(__full_path().'css/relatorio/bootstrap.min.css');
        } else if ($response['cabecalho']->vc_nif == "7301002572") {

            //$url = 'cartões/LiceuUíge/aluno.png';
            $response["style"] = file_get_contents(__full_path().'css/relatorio/style.css');
           $response['bootstrap'] = file_get_contents(__full_path().'css/relatorio/bootstrap.min.css');
        } else if ($response['cabecalho']->vc_nif == "7301003617") {

            //$url = 'cartões/ldc/aluno.png';
            $response["style"] = file_get_contents(__full_path().'css/relatorio/style.css');
           $response['bootstrap'] = file_get_contents(__full_path().'css/relatorio/bootstrap.min.css');
        }else if ($response['cabecalho']->vc_nif == "5000300926") {

            //$url = 'cartões/imagu/aluno.png';
            $response["style"] = file_get_contents(__full_path().'css/relatorio/style.css');
           $response['bootstrap'] = file_get_contents(__full_path().'css/relatorio/bootstrap.min.css');
        } else {
            //$url = 'images/cartao/aluno.jpg';
            $response["style"] = file_get_contents(__full_path().'css/relatorio/style.css');
           $response['cabecalho'] = file_get_contents(__full_path().'css/relatorio/bootstrap.min.css');
        }

        $response['cabecalho'] = Cabecalho::first();
        $response['titulo'] = "Estatística dos Alunos matriculados";
        $response['data'] = $anoLectivo;
        $resultCurso = Curso::where('vc_nomeCurso', $curso)->first();

        if( $request->vc_classe==null || $request->vc_classe == 'Todos'){
     
        }else{
          $response['matriculados']=$response['matriculados']->where('vc_classe',$request->vc_classe);
          $response['matriculados']->all();
          $response['vc_classe']=$request->vc_classe;
        }


        $response['totalGeral'] =  $response['matriculados']->count();
      
        $response['totalD']  =  $response['matriculados']->where('vc_dificiencia', '=', "Sim")->count();
        $response['totalM'] = $response['matriculados']->where('vc_genero', '=', "Masculino")->count();
        $response['totalF']  =  $response['matriculados']->where('vc_genero', '=', "Feminino")->count();

      if( $request->vc_classe==null){
     
      }else{
        $response['matriculados']=$response['matriculados']->where('vc_classe',$request->vc_classe);
        $response['matriculados']->all();
        $response['vc_classe']=$request->vc_classe;
      }

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->defaultfooterline = 0;
        $mpdf->setFooter('{PAGENO}');
        $this->Logger->Log('info', 'Imprimiu a Lista da Estatística dos Alunos matriculados');
        $html = view("admin/pdfs/matricula/relatorio", $response);
        $mpdf->writeHTML($html);
        $mpdf->Output("matricula.pdf", "I");
      }else{
      
        $curso = $request->vc_curso;
      /*   $response["bootstrap"] = file_get_contents("css/relatorio/bootstrap.min.css");
        $response["style"] = file_get_contents("css/relatorio/style.css"); */
        $response['cabecalho'] = Cabecalho::first();
        if ($response['cabecalho']->vc_nif == "5000298182") {

            //$url = 'cartões/CorMarie/aluno.png';
            $response["style"] = file_get_contents(__full_path().'css/relatorio/style.css');
           $response['bootstrap'] = file_get_contents(__full_path().'css/relatorio/bootstrap.min.css');

        } else if ($response['cabecalho']->vc_nif == "7301002327") {

            //$url = 'cartões/InstitutoPolitécnicodoUIGE/aluno.png';
            $response["style"] = file_get_contents(__full_path().'css/relatorio/style.css');
           $response['bootstrap'] = file_get_contents(__full_path().'css/relatorio/bootstrap.min.css');
        } else if ($response['cabecalho']->vc_nif == "5000303399") {

            //$url = 'cartões/negage/aluno.png';
            $response["style"] = file_get_contents(__full_path().'css/relatorio/style.css');
           $response['bootstrap'] = file_get_contents(__full_path().'css/relatorio/bootstrap.min.css');
        } else if ($response['cabecalho']->vc_nif == "5000820440") {
        
            //$url = 'cartões/Quilumosso/aluno.png';
            $response["style"] = file_get_contents(__full_path().'css/relatorio/style.css');
           $response['bootstrap'] = file_get_contents(__full_path().'css/relatorio/bootstrap.min.css');
        } else if ($response['cabecalho']->vc_nif == "5000305308") {

            //$url = 'cartões/Foguetao/aluno.png';
            $response["style"] = file_get_contents(__full_path().'css/relatorio/style.css');
           $response['bootstrap'] = file_get_contents(__full_path().'css/relatorio/bootstrap.min.css');
        } else if ($response['cabecalho']->vc_nif == "7301002572") {

            //$url = 'cartões/LiceuUíge/aluno.png';
            $response["style"] = file_get_contents(__full_path().'css/relatorio/style.css');
           $response['bootstrap'] = file_get_contents(__full_path().'css/relatorio/bootstrap.min.css');
        } else if ($response['cabecalho']->vc_nif == "7301003617") {

            //$url = 'cartões/ldc/aluno.png';
            $response["style"] = file_get_contents(__full_path().'css/relatorio/style.css');
           $response['bootstrap'] = file_get_contents(__full_path().'css/relatorio/bootstrap.min.css');
        }else if ($response['cabecalho']->vc_nif == "5000300926") {

            //$url = 'cartões/imagu/aluno.png';
            $response["style"] = file_get_contents(__full_path().'css/relatorio/style.css');
           $response['bootstrap'] = file_get_contents(__full_path().'css/relatorio/bootstrap.min.css');
        } else {
            //$url = 'images/cartao/aluno.jpg';
            $response["style"] = file_get_contents(__full_path().'css/relatorio/style.css');
           $response['cabecalho'] = file_get_contents(__full_path().'css/relatorio/bootstrap.min.css');
        }

        $response['cabecalho'] = Cabecalho::first();
        $response['titulo'] = "Estatística dos Alunos matriculados";
        $response['data'] = $anoLectivo;
        $resultCurso = Curso::where('vc_nomeCurso', $curso)->first();
        if( $request->vc_classe==null || $request->vc_classe == 'Todos'){
     
        }else{
         
          $response['matriculados']=$response['matriculados']->where('vc_classe',$request->vc_classe);
          $response['matriculados']->all();
         
          $response['vc_classe']=$request->vc_classe;
        }

        $response['totalGeral'] =  $response['matriculados']->count();
      
        $response['totalD']  =  $response['matriculados']->where('vc_dificiencia', '=', "Sim")->count();
        $response['totalM'] = $response['matriculados']->where('vc_genero', '=', "Masculino")->count();
        $response['totalF']  =  $response['matriculados']->where('vc_genero', '=', "Feminino")->count();

       
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->defaultfooterline = 0;
        $mpdf->setFooter('{PAGENO}');
        $this->Logger->Log('info', 'Imprimiu a Lista da Estatística dos Alunos matriculados');
        $html = view("admin/pdfs/matricula/relatorio_total", $response);
        $mpdf->writeHTML($html);
        $mpdf->Output("matricula.pdf", "I");
      }
       
    }
}
