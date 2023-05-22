<?php

namespace App\Http\Controllers\Admin\relatorios;

use App\Http\Controllers\Controller;
use App\Models\AnoLectivo;
use App\Models\Cabecalho;
use App\Models\Estatistica;
use Illuminate\Http\Request;
use App\Models\Logger;
use App\Models\Curso;

class ResController extends Controller
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
        $response['cursos'] = Curso::where([['it_estado_curso', 1]])->get();
        return view('admin/relatorios/seleccao/index', $response);
    }

    public function recebeRes(Request $request)
    {
    
        $anoLectivo = $request->vc_anolectivo;
        $vc_curso = $request->vc_curso;
        $data = $request->data;
      if($data)
        return redirect("Admin/lista/Res/$anoLectivo/$vc_curso/$data");
        else
        return redirect("Admin/lista/Res/$anoLectivo/$vc_curso/' '");
    }
    public function lista(Estatistica $as, $anoLectivo,$vc_curso,$data)
    {
        /* $response["bootstrap"] = file_get_contents("css/relatorio/bootstrap.min.css");
        $response["style"] = file_get_contents("css/relatorio/style.css"); */


        $response['cabecalho'] = Cabecalho::first();
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
        $response['titulo'] = "Estatística da Selecção de candidatos à Matricula";
        $response['data'] = $anoLectivo;
        $response['vc_curso']=$vc_curso;

        $response['totalGeral'] = $as->candidatos2($anoLectivo,$vc_curso)->count();
        $response['totalM'] = $as->candidatos2($anoLectivo,$vc_curso)->where([['vc_genero', '=', "Masculino"]])->count();
        $response['totalF']  = $as->candidatos2($anoLectivo,$vc_curso)->where([['vc_genero', '=', "Feminino"]])->count();
     
        if($data!="' '"){
           
                $response['totalGeral'] = $as->candidatos2($anoLectivo,$vc_curso)->whereDate('created_at', $data)->count();
                $response['totalM'] = $as->candidatos2($anoLectivo,$vc_curso)->where([['vc_genero', '=', "Masculino"]])->whereDate('created_at', $data)->count();
                $response['totalF']  = $as->candidatos2($anoLectivo,$vc_curso)->where([['vc_genero', '=', "Feminino"]])->whereDate('created_at', $data)->count();
                $response['dia']=$data;
                $mpdf = new \Mpdf\Mpdf();
                $this->Logger->Log('info', 'Imprimiu a Lista da Estatística da Selecção de candidatos à Matricula');
                $html = view("admin/pdfs/seleccao/relatorio_diario", $response);
                $mpdf->writeHTML($html);
                $mpdf->Output("seleccao.pdf", "I");


            }

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->defaultfooterline = 0;
        $mpdf->setFooter('{PAGENO}');
        $this->Logger->Log('info', 'Imprimiu a Lista da Estatística da Selecção de candidatos à Matricula');
        $html = view("admin/pdfs/seleccao/relatorio", $response);
        $mpdf->writeHTML($html);
        $mpdf->Output("seleccao.pdf", "I");
    }
}
