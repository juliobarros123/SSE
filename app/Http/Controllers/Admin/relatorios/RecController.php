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

namespace App\Http\Controllers\Admin\relatorios;

use App\Http\Controllers\Controller;
use App\Models\AnoLectivo;
use App\Models\Cabecalho;
use App\Models\Estatistica;
use Illuminate\Http\Request;
use App\Models\Logger;

class RecController extends Controller
{
    //
    private $Logger;
    public function __construct()
    {
        $this->Logger = new Logger();
    }

    public function pesquisar()
    {
        $response['anoslectivos'] = fh_anos_lectivos()->get();
        return view('admin/relatorios/candidatura/index', $response);
    }

    public function recebeRec(Request $request)
    {

        if ($request->data_inicio == null ) {
            $anoLectivo = $request->vc_anolectivo;
            return redirect("Admin/lista/Rec/$anoLectivo");
        } else {
            return redirect("Admin/relatorio/diario/buscar/$request->vc_anolectivo/$request->data_inicio/");
        }
    }
    public function lista(Estatistica $as, $anoLectivo)
    {
       
       /*  $response["bootstrap"] = file_get_contents("css/relatorio/bootstrap.min.css");
        $response["style"] = file_get_contents("css/relatorio/style.css"); */

// dd("ola");
        $response['cabecalho'] = Cabecalho::first();
        if ($response['cabecalho']->vc_nif == "5000298182") {

            //$url = 'cartões/CorMarie/aluno.png';
            $response["style"] = file_get_contents('css/relatorio/style.css');
           $response['bootstrap'] = file_get_contents('css/relatorio/bootstrap.min.css');

        } else if ($response['cabecalho']->vc_nif == "7301002327") {

            //$url = 'cartões/InstitutoPolitécnicodoUIGE/aluno.png';
            $response["style"] = file_get_contents('css/relatorio/style.css');
           $response['bootstrap'] = file_get_contents('css/relatorio/bootstrap.min.css');
        } else if ($response['cabecalho']->vc_nif == "5000303399") {

            //$url = 'cartões/negage/aluno.png';
            $response["style"] = file_get_contents('css/relatorio/style.css');
           $response['bootstrap'] = file_get_contents('css/relatorio/bootstrap.min.css');
        } else if ($response['cabecalho']->vc_nif == "5000820440") {
        
            //$url = 'cartões/Quilumosso/aluno.png';
            $response["style"] = file_get_contents('css/relatorio/style.css');
           $response['bootstrap'] = file_get_contents('css/relatorio/bootstrap.min.css');
        } else if ($response['cabecalho']->vc_nif == "5000305308") {

            //$url = 'cartões/Foguetao/aluno.png';
            $response["style"] = file_get_contents('css/relatorio/style.css');
           $response['bootstrap'] = file_get_contents('css/relatorio/bootstrap.min.css');
        } else if ($response['cabecalho']->vc_nif == "7301002572") {

            //$url = 'cartões/LiceuUíge/aluno.png';
            $response["style"] = file_get_contents('css/relatorio/style.css');
           $response['bootstrap'] = file_get_contents('css/relatorio/bootstrap.min.css');
        } else if ($response['cabecalho']->vc_nif == "7301003617") {

            //$url = 'cartões/ldc/aluno.png';
            $response["style"] = file_get_contents('css/relatorio/style.css');
           $response['bootstrap'] = file_get_contents('css/relatorio/bootstrap.min.css');
        }else if ($response['cabecalho']->vc_nif == "5000300926") {

            //$url = 'cartões/imagu/aluno.png';
            $response["style"] = file_get_contents('css/relatorio/style.css');
           $response['bootstrap'] = file_get_contents('css/relatorio/bootstrap.min.css');
        } else {
            //$url = 'images/cartao/aluno.jpg';
            $response["style"] = file_get_contents('css/relatorio/style.css');
           $response['bootstrap'] = file_get_contents('css/relatorio/bootstrap.min.css');
        }
        $response['titulo'] = "Estatística das Candidaturas";
        $response['data'] = $anoLectivo;


        $response['totalGeral'] = $as->Rec($anoLectivo)->count();
        $response['totalM'] = $as->Rec($anoLectivo)->where([['vc_genero', '=', "Masculino"]])->count();
        $response['totalF']  = $as->Rec($anoLectivo)->where([['vc_genero', '=', "Feminino"]])->count();

        $response['seds'] = $as->Rec($anoLectivo)->get('vc_genero');


        $mpdf = new \Mpdf\Mpdf();
        $mpdf->defaultfooterline = 0;
        $mpdf->setFooter('{PAGENO}');
        $this->Logger->Log('info', 'Imprimiu a Lista da Estatística das Candidaturas');
        $html = view("admin/pdfs/candidatura/relatorio", $response);
        $mpdf->writeHTML($html);
        $mpdf->Output("candidatura.pdf", "I");
    }

        public function buscar_diario(Estatistica $as,$anoLectivo, $data_inicio)
    {

        $response["bootstrap"] = file_get_contents("css/relatorio/bootstrap.min.css");
        $response["style"] = file_get_contents("css/relatorio/style.css");


        $response['cabecalho'] = Cabecalho::first();
        $response['titulo'] = "Estatística das Candidaturas";
        $response['data'] = $anoLectivo;

        $response['totalGeral'] = $as->Rec($anoLectivo)->whereDate('created_at', $data_inicio)->count();
        $response['totalM'] = $as->Rec($anoLectivo)->where([['vc_genero', '=', "Masculino"]])->whereDate('created_at', $data_inicio)->count();
        $response['totalF']  = $as->Rec($anoLectivo)->where([['vc_genero', '=', "Feminino"]])->whereDate('created_at', $data_inicio)->count();

        $response['seds'] = $as->Rec($anoLectivo)->whereDate('created_at', $data_inicio)->get('vc_genero');

        $response['data_inicio']=$data_inicio;
        // $response['data_final']=$data_final;
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->defaultfooterline = 0;
        $mpdf->setFooter('{PAGENO}');
        $this->Logger->Log('info', 'Imprimiu a Lista da Estatística das Candidaturas');
        $html = view("admin/pdfs/candidatura/relatorio_por_data", $response);
        $mpdf->writeHTML($html);
        $mpdf->Output("candidatura.pdf", "I");
    }
}
