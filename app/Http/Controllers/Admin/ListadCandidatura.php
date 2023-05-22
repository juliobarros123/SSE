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
use App\Models\AnoLectivo;
use App\Models\Cabecalho;
use App\Models\Candidatura;
use App\Models\Curso;
use Illuminate\Http\Request;
use App\Models\Logger;
use Illuminate\Support\Facades\Auth;

class ListadCandidatura extends Controller
{
    private $Logger;
    public function __construct()
    {
        $this->Logger = new Logger();
    }
    public function loggerData($mensagem){
        $dados_Auth = Auth::user()->vc_primemiroNome.' '.Auth::user()->vc_apelido.' Com o nivel de '.Auth::user()->vc_tipoUtilizador.' ';
        $this->Logger->Log('info', $dados_Auth.$mensagem);
    }
    //
    public function pesquisar()
    {
        $response['anoslectivos'] = AnoLectivo::where([['it_estado_anoLectivo', 1]])->get();
        $response['cursos'] = Curso::where([['it_estado_curso', 1]])->get();
        return view('admin/candidatura/listas/index', $response);
    }
    public function recebeCandidaturas(Request $request)
    {
        $anoLectivo =  $request->vc_anolectivo;
        $curso = $request->vc_curso;

        return redirect("Admin/listas/candidaturas/$anoLectivo/$curso");
    }
    public function index(Candidatura $Rcandidatos, $anoLectivo, $curso)
    {
        if ($anoLectivo == 'Todos') {
            $anoLectivo = '';
        }
        if ($curso == 'Todos') {
            $curso = '';
        }
        $c =  $Rcandidatos->CandidaturasListas($anoLectivo, $curso);
        $data['alunos'] = $c->get();
        $data['anolectivo'] = $anoLectivo;
        $data['curso'] = $curso;


        $data['cabecalho'] = Cabecalho::find(1);
        /* $data["bootstrap"] = file_get_contents("css/listas/bootstrap.min.css");
        $data["css"] = file_get_contents("css/listas/style.css"); */

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
        }  else {
            //$url = 'images/cartao/aluno.jpg';
            $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
            $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
        }
  

        $mpdf = new \Mpdf\Mpdf();

        $mpdf->SetFont("arial");
        $mpdf->setHeader();
        $mpdf->defaultfooterline = 0;
        $mpdf->setFooter('{PAGENO}');
        $this->loggerData('Imprimiu Lista de Candidatura');
        $html = view("admin/pdfs/listas/candidaturas/index", $data);
        $mpdf->writeHTML($html);
        $mpdf->Output("listasdCandidaturas.pdf", "I");
    }


    public function purgar($id)
    {
        try {
            //User::find($id)->delete();
            $response = User::find($id);
            $response2 = User::find($id)->delete();
            $this->loggerData("Purgou o Utilizador");
            return redirect()->back()->with('user.purgar.success', '1');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('user.purgar.error', '1');
        }
    }

}
