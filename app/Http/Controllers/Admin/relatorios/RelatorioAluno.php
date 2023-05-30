<?php

namespace App\Http\Controllers\admin\relatorios;

use App\Http\Controllers\Controller;
use App\Models\AnoLectivo;
use App\Models\Cabecalho;
use App\Models\Estatistica;
use Illuminate\Http\Request;
use App\Models\Logger;
use App\Models\Estudante;
class RelatorioAluno extends Controller
{
    //
    
    //
    private $Logger;
    public function __construct()
    {
        $this->Logger = new Logger();
    }

    
    public function pesquisar()
    {
        $data['anoslectivos'] = AnoLectivo::where([['it_estado_anoLectivo', 1]])->get();
        return view('admin/relatorios/aluno/index', $data);
    }

    public function recebeRec(Request $request)
    {
     

        if ($request->data_inicio == null || $request->data_final == null ) {
            $anoLectivo = $request->vc_anolectivo;
          
            return redirect("Admin/lista/aluno/Rec/$anoLectivo");
        } else {
          
            return redirect("Admin/relatorio/aluno/diario/buscar/$request->vc_anolectivo/$request->data_inicio/$request->data_final");
        }
    }
    public function lista(Estatistica $as, $anoLectivo)
    {
      /* 
        $data["bootstrap"] = file_get_contents("css/relatorio/bootstrap.min.css");
        $data["style"] = file_get_contents("css/relatorio/style.css"); */
        $data['cabecalho'] = Cabecalho::first();
        if ($data['cabecalho']->vc_nif == "5000298182") {

            //$url = 'cartões/CorMarie/aluno.png';
            $data["style"] = file_get_contents('css/relatorio/style.css');
           $data['bootstrap'] = file_get_contents('css/relatorio/bootstrap.min.css');

        } else if ($data['cabecalho']->vc_nif == "7301002327") {

            //$url = 'cartões/InstitutoPolitécnicodoUIGE/aluno.png';
            $data["style"] = file_get_contents('css/relatorio/style.css');
           $data['bootstrap'] = file_get_contents('css/relatorio/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "5000303399") {

            //$url = 'cartões/negage/aluno.png';
            $data["style"] = file_get_contents('css/relatorio/style.css');
           $data['bootstrap'] = file_get_contents('css/relatorio/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "5000820440") {
        
            //$url = 'cartões/Quilumosso/aluno.png';
            $data["style"] = file_get_contents('css/relatorio/style.css');
           $data['bootstrap'] = file_get_contents('css/relatorio/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "5000305308") {

            //$url = 'cartões/Foguetao/aluno.png';
            $data["style"] = file_get_contents('css/relatorio/style.css');
           $data['bootstrap'] = file_get_contents('css/relatorio/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "7301002572") {

            //$url = 'cartões/LiceuUíge/aluno.png';
            $data["style"] = file_get_contents('css/relatorio/style.css');
           $data['bootstrap'] = file_get_contents('css/relatorio/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "7301003617") {

            //$url = 'cartões/ldc/aluno.png';
            $data["style"] = file_get_contents('css/relatorio/style.css');
           $data['bootstrap'] = file_get_contents('css/relatorio/bootstrap.min.css');
        }else if ($data['cabecalho']->vc_nif == "5000300926") {

            //$url = 'cartões/imagu/aluno.png';
            $data["style"] = file_get_contents('css/relatorio/style.css');
           $data['bootstrap'] = file_get_contents('css/relatorio/bootstrap.min.css');
        } else {
            //$url = 'images/cartao/aluno.jpg';
            $data["style"] = file_get_contents('css/relatorio/style.css');
           $data['bootstrap'] = file_get_contents('css/relatorio/bootstrap.min.css');
        }


        $data['cabecalho'] = Cabecalho::first();
        $data['titulo'] = "Estatística das Candidaturas";
        $data['data'] = $anoLectivo;


        $data['totalGeral'] = $as->Res($anoLectivo)->count();
        
        $data['totalM'] = $as->Res($anoLectivo)->where([['vc_genero', '=', "MASCULINO"]])->count();
        $data['totalF']  = $as->Res($anoLectivo)->where([['vc_genero', '=', "FEMININO"]])->count();

        $data['seds'] = $as->Res($anoLectivo)->get('vc_genero');



        $mpdf = new \Mpdf\Mpdf();
        $this->Logger->Log('info', 'Imprimiu a Lista da Estatística dos Alunos');
        $html = view("admin/pdfs/candidatura/relatorio_aluno_todos", $data);
        $mpdf->writeHTML($html);
        $mpdf->Output("candidatura.pdf", "I");
    }

    public function buscar_diario(Estatistica $as,$anoLectivo, $data_inicio,$data_final)
    {
             
       /*  $data["bootstrap"] = file_get_contents("css/relatorio/bootstrap.min.css");
        $data["style"] = file_get_contents("css/relatorio/style.css"); */
        $data['cabecalho'] = Cabecalho::first();
        if ($data['cabecalho']->vc_nif == "5000298182") {

            //$url = 'cartões/CorMarie/aluno.png';
            $data["style"] = file_get_contents('css/relatorio/style.css');
           $data['bootstrap'] = file_get_contents('css/relatorio/bootstrap.min.css');

        } else if ($data['cabecalho']->vc_nif == "7301002327") {

            //$url = 'cartões/InstitutoPolitécnicodoUIGE/aluno.png';
            $data["style"] = file_get_contents('css/relatorio/style.css');
           $data['bootstrap'] = file_get_contents('css/relatorio/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "5000303399") {

            //$url = 'cartões/negage/aluno.png';
            $data["style"] = file_get_contents('css/relatorio/style.css');
           $data['bootstrap'] = file_get_contents('css/relatorio/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "5000820440") {
        
            //$url = 'cartões/Quilumosso/aluno.png';
            $data["style"] = file_get_contents('css/relatorio/style.css');
           $data['bootstrap'] = file_get_contents('css/relatorio/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "5000305308") {

            //$url = 'cartões/Foguetao/aluno.png';
            $data["style"] = file_get_contents('css/relatorio/style.css');
           $data['bootstrap'] = file_get_contents('css/relatorio/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "7301002572") {

            //$url = 'cartões/LiceuUíge/aluno.png';
            $data["style"] = file_get_contents('css/relatorio/style.css');
           $data['bootstrap'] = file_get_contents('css/relatorio/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "7301003617") {

            //$url = 'cartões/ldc/aluno.png';
            $data["style"] = file_get_contents('css/relatorio/style.css');
           $data['bootstrap'] = file_get_contents('css/relatorio/bootstrap.min.css');
        }else if ($data['cabecalho']->vc_nif == "5000300926") {

            //$url = 'cartões/imagu/aluno.png';
            $data["style"] = file_get_contents('css/relatorio/style.css');
           $data['bootstrap'] = file_get_contents('css/relatorio/bootstrap.min.css');
        } else {
            //$url = 'images/cartao/aluno.jpg';
            $data["style"] = file_get_contents('css/relatorio/style.css');
           $data['bootstrap'] = file_get_contents('css/relatorio/bootstrap.min.css');
        }


        $data['cabecalho'] = Cabecalho::first();
        $data['titulo'] = "Estatística de alunos";
        $data['data'] = $anoLectivo;
        $data['data_inicio'] = $data_inicio;
        $data['data_final'] = $data_final;
        $data['totalGeral'] = $as->Res($anoLectivo)
        ->whereDate('created_at','>=', $data_inicio)
        ->whereDate('created_at','<=', $data_final)->count();

        $data['totalM'] = $as->Res($anoLectivo)->where([['vc_genero', '=', "Masculino"]])
        ->whereDate('created_at','>=', $data_inicio)
        ->whereDate('created_at','<=', $data_final)->count();

        $data['totalF']  = $as->Res($anoLectivo)->where([['vc_genero', '=', "Feminino"]])
        ->whereDate('created_at','>=', $data_inicio)
        ->whereDate('created_at','<=', $data_final)->count();

        $data['seds'] = $as->Res($anoLectivo)->whereDate('created_at','>=', $data_inicio)
        ->whereDate('created_at','<=', $data_final)
        ->get('vc_genero');

        $data['data_inicio']=$data_inicio;
        // $data['data_final']=$data_final;
        $mpdf = new \Mpdf\Mpdf();
        $this->Logger->Log('info', 'Imprimiu a Lista da Estatística das Candidaturas');
        $html = view("admin/pdfs/candidatura/relatorio_aluno", $data);
        $mpdf->writeHTML($html);
        $mpdf->Output("candidatura.pdf", "I");
    }

    public function recebeSelecionados(Request $request)
    {
     
        $anoLectivo =  $request->vc_anolectivo;
        $curso = $request->vc_curso;

        return redirect("Admin/lista/selecionados/$anoLectivo/$curso");
    }
    public function index(Estudante $Ralunos, $anoLectivo, $curso)
    {
       
        if ($anoLectivo == 'Todos') {
            $anoLectivo = '';
        }
        if ($curso == 'Todos') {
            $curso = '';
        }
        $c =  $Ralunos->SelecionadosListas($anoLectivo, $curso);
        $data['alunos'] = $c->get();
        $data['anolectivo'] = $anoLectivo;
        $data['curso'] = $curso;


        $data['cabecalho'] = Cabecalho::find(1);
        /* $data["bootstrap"] = file_get_contents("css/listas/bootstrap.min.css");
        $data["css"] = file_get_contents("css/listas/style.css"); */
        $data['cabecalho'] = Cabecalho::first();
        if ($data['cabecalho']->vc_nif == "5000298182") {

            //$url = 'cartões/CorMarie/aluno.png';
            $data["css"] = file_get_contents('css/listas/style.css');
           $data['bootstrap'] = file_get_contents('css/listas/bootstrap.min.css');

        } else if ($data['cabecalho']->vc_nif == "7301002327") {

            //$url = 'cartões/InstitutoPolitécnicodoUIGE/aluno.png';
            $data["css"] = file_get_contents('css/listas/style.css');
           $data['bootstrap'] = file_get_contents('css/listas/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "5000303399") {

            //$url = 'cartões/negage/aluno.png';
            $data["css"] = file_get_contents('css/listas/style.css');
           $data['bootstrap'] = file_get_contents('css/listas/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "5000820440") {
        
            //$url = 'cartões/Quilumosso/aluno.png';
            $data["css"] = file_get_contents('css/listas/style.css');
           $data['bootstrap'] = file_get_contents('css/listas/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "5000305308") {

            //$url = 'cartões/Foguetao/aluno.png';
            $data["css"] = file_get_contents('css/listas/style.css');
           $data['bootstrap'] = file_get_contents('css/listas/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "7301002572") {

            //$url = 'cartões/LiceuUíge/aluno.png';
            $data["css"] = file_get_contents('css/listas/style.css');
           $data['bootstrap'] = file_get_contents('css/listas/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "7301003617") {

            //$url = 'cartões/ldc/aluno.png';
            $data["css"] = file_get_contents('css/listas/style.css');
           $data['bootstrap'] = file_get_contents('css/listas/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "5000300926") {

            //$url = 'cartões/imagu/aluno.png';
            $data["css"] = file_get_contents('css/listas/style.css');
           $data['bootstrap'] = file_get_contents('css/listas/bootstrap.min.css');
        }  else {
            //$url = 'images/cartao/aluno.jpg';
            $data["css"] = file_get_contents('css/listas/style.css');
           $data['bootstrap'] = file_get_contents('css/listas/bootstrap.min.css');
        }

        $mpdf = new \Mpdf\Mpdf();

        $mpdf->SetFont("arial");
        $mpdf->setHeader();
        $mpdf->defaultfooterline = 0;
        $mpdf->setFooter('{PAGENO}');
        $this->Logger->Log('info','Imprimiu Lista dos Selecionados a Matricula');
        $html = view("admin/pdfs/listas/selecionados/index", $data);
        $mpdf->writeHTML($html);
        $mpdf->Output("listasdSelecionados.pdf", "I");
    }

   
}
