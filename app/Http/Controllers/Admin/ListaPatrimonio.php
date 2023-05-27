<?php

namespace App\Http\Controllers\Admin;

use App\Models\AnoLectivo;
use App\Models\Patrimonios;
use App\Models\Cabecalho;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Logger;
use Illuminate\Support\Facades\Auth;

class ListaPatrimonio extends Controller
{
  //
  //
  private $Logger;
  public function __construct()
  {
    $this->Logger = new Logger();
  }
  public function loggerData($mensagem){
    $dados_Auth = Auth::user()->vc_primemiroNome.' '.Auth::user()->vc_apelido.' Com o nivel de '.Auth::user()->vc_tipoUtilizador.' ';
    $this->Logger->Log('info', $dados_Auth.$mensagem);
}
  public function pesquisar()
  {
    $response['anoslectivos'] = AnoLectivo::where([['it_estado_anoLectivo', 1]])->get();
    return view('admin/patrimonios/listas/index', $response);
  }
  public function recebePatrimonios(Request $request)
  {
    $anoLectivo =  $request->vc_anolectivo;
    return redirect("Admin/listas/patrimonios/$anoLectivo");
  }
  public function index(Patrimonios $Rpatrimonios, $anoLectivo)
  {
    if ($anoLectivo == 'Todos') {
      $anoLectivo = '';
    }

    $c =  $Rpatrimonios->PatrimoniosListas($anoLectivo);
    $data['patrimonios'] = $c->get();
    $data['anolectivo'] = $anoLectivo;


    $data['cabecalho'] = Cabecalho::find(1);
    /* $data["bootstrap"] = file_get_contents("css/lista/bootstrap.min.css");
    $data["css"] = file_get_contents("css/lista/style.css"); */
    if ($data['cabecalho']->vc_nif == "5000298182") {

      //$url = 'cartões/CorMarie/aluno.png';
      $data["css"] = file_get_contents(.'css/lista/style.css');
      $data["bootstrap"] = file_get_contents(.'css/lista/bootstrap.min.cs');

  } else if ($data['cabecalho']->vc_nif == "7301002327") {

      //$url = 'cartões/InstitutoPolitécnicodoUIGE/aluno.png';
      $data["css"] = file_get_contents(.'css/lista/style.css');
      $data["bootstrap"] = file_get_contents(.'css/lista/bootstrap.min.cs');
  } else if ($data['cabecalho']->vc_nif == "5000303399") {

      //$url = 'cartões/negage/aluno.png';
      $data["css"] = file_get_contents(.'css/lista/style.css');
      $data["bootstrap"] = file_get_contents(.'css/lista/bootstrap.min.cs');
  } else if ($data['cabecalho']->vc_nif == "5000820440") {
  
      //$url = 'cartões/Quilumosso/aluno.png';
      $data["css"] = file_get_contents(.'css/lista/style.css');
      $data["bootstrap"] = file_get_contents(.'css/lista/bootstrap.min.cs');
  } else if ($data['cabecalho']->vc_nif == "5000305308") {

      //$url = 'cartões/Foguetao/aluno.png';
      $data["css"] = file_get_contents(.'css/lista/style.css');
      $data["bootstrap"] = file_get_contents(.'css/lista/bootstrap.min.cs');
  } else if ($data['cabecalho']->vc_nif == "7301002572") {

      //$url = 'cartões/LiceuUíge/aluno.png';
      $data["css"] = file_get_contents(.'css/lista/style.css');
      $data["bootstrap"] = file_get_contents(.'css/lista/bootstrap.min.cs');
  } else if ($data['cabecalho']->vc_nif == "7301003617") {

      //$url = 'cartões/imagu/aluno.png';
      $data["css"] = file_get_contents(.'css/lista/style.css');
      $data["bootstrap"] = file_get_contents(.'css/lista/bootstrap.min.cs');
  } else {
      //$url = 'images/cartao/aluno.jpg';
      $data["css"] = file_get_contents(.'css/lista/style.css');
      $data["bootstrap"] = file_get_contents(.'css/lista/bootstrap.min.cs');
  }

    $mpdf = new \Mpdf\Mpdf([
      'mode' => 'utf-8',  'format' => [297, 320]
    ]);

    $mpdf->SetFont("arial");
    $mpdf->setHeader();
    $this->loggerData('Imprimiu a Lista de Patrimonios');
    $html = view("admin/pdfs/listas/patrimonios/index", $data);
    $mpdf->writeHTML($html);
    $mpdf->Output("listasDpatrimonios.pdf", "I");
  }
}
