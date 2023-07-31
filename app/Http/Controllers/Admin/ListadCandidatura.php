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
use App\Models\Classe;
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
    public function loggerData($mensagem)
    {
        $dados_Auth = Auth::user()->vc_primemiroNome . ' ' . Auth::user()->vc_apelido . ' Com o nivel de ' . Auth::user()->vc_tipoUtilizador . ' ';
        $this->Logger->Log('info', $dados_Auth . $mensagem);
    }
    //
    public function pesquisar()
    {
        $response['anoslectivos'] = fh_anos_lectivos()->get();
        $response['cursos'] = fh_cursos()->get();
        $response['classes'] = fh_classes()->get();
        return view('admin/candidatura/listas/index', $response);
    }
    public function lista_pdf(Request $request)
    {
        // dd(fh_cabecalho());


        if (!$request->id_curso) {
            $filtro_candidato_lista = session()->get('filtro_candidato_lista');
            $request->id_curso = $filtro_candidato_lista['id_curso'];
        }
        if (!$request->id_ano_lectivo) {
            $filtro_candidato_lista = session()->get('filtro_candidato_lista');
            $request->id_ano_lectivo = $filtro_candidato_lista['id_ano_lectivo'];
        }
        if (!$request->id_classe) {
            $filtro_candidato_lista = session()->get('filtro_candidato_lista');
            $request->id_classe = $filtro_candidato_lista['id_classe'];
        }
        $data['ano_lectivo'] = 'Todos';

        $data['curso'] = 'Todos';
        $data['classe'] = 'Todas';

        // $data['anolectivo'] = anoLE
        // $data['curso'] = $curso;
        // dd("s");
        // dd(session()->all());
        $candidados = fh_candidatos();
        // dd(  $candidados ->get());
        // dd($request);

        if ($request->id_ano_lectivo != 'Todos' && $request->id_ano_lectivo) {
            $ano_lectivo = fh_anos_lectivos()->find($request->id_ano_lectivo);
            $data['ano_lectivo'] = $ano_lectivo->ya_inicio . '/' . $ano_lectivo->ya_fim;
            $candidados = $candidados->where('candidatos.id_ano_lectivo', $request->id_ano_lectivo);
        }

        if ($request->id_curso != 'Todos' && $request->id_curso) {
            // dd($candidados->get(),$request->id_curso);
            $data['curso'] = Curso::find($request->id_curso)->vc_nomeCurso;

            $candidados = $candidados->where('candidatos.id_curso', $request->id_curso);
        }
        if ($request->id_classe != 'Todas' && $request->id_classe) {
            // dd($candidados->get(),$request->id_classe);
            $data['classe'] =   Classe::find($request->id_classe)->vc_classe;

            $candidados = $candidados->where('candidatos.id_classe', $request->id_classe);
        }
        $filtro_candidato_lista = [
            'id_ano_lectivo' => $request->id_ano_lectivo,
            'id_curso' => $request->id_curso,
            'id_classe' => $request->id_classe,
        ];

        storeSession('filtro_candidato_lista', $filtro_candidato_lista);
        $data['candidatos'] = $candidados->get();
        $data["css"] = file_get_contents('css/lista/style-2.css');
        $data['cabecalho'] = fh_cabecalho();

     
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'margin_top' => 5,

        ]);
        $mpdf->setHeader();
        $this->loggerData('Imprimiu Lista de Candidatura');
        $html = view("admin/pdfs/listas/candidaturas/index", $data);

        $mpdf->writeHTML($html);
     
        $mpdf->Output("listas-de-Candidaturas-$data[curso]- $data[classe].pdf", "I");
    }
    public function index(Candidatura $Rcandidatos, $anoLectivo, $curso)
    {
        if ($anoLectivo == 'Todos') {
            $anoLectivo = '';
        }
        if ($curso == 'Todos') {
            $curso = '';
        }
        $c = $Rcandidatos->CandidaturasListas($anoLectivo, $curso);
        $data['alunos'] = $c->get();
        $data['anolectivo'] = $anoLectivo;
        $data['curso'] = $curso;


        $data['cabecalho'] = Cabecalho::find(1);
        /* $data["bootstrap"] = file_get_contents("css/listas/bootstrap.min.css");
        $data["css"] = file_get_contents("css/listas/style.css"); */

        if ($data['cabecalho']->vc_nif == "5000298182") {

            //$url = 'cartões/CorMarie/aluno.png';
            $data["css"] = file_get_contents('css/listas/style.css');
            $data["bootstrap"] = file_get_contents('css/listas/bootstrap.min.css');

        } else if ($data['cabecalho']->vc_nif == "7301002327") {

            //$url = 'cartões/InstitutoPolitécnicodoUIGE/aluno.png';
            $data["css"] = file_get_contents('css/listas/style.css');
            $data["bootstrap"] = file_get_contents('css/listas/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "5000303399") {

            //$url = 'cartões/negage/aluno.png';
            $data["css"] = file_get_contents('css/listas/style.css');
            $data["bootstrap"] = file_get_contents('css/listas/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "5000820440") {

            //$url = 'cartões/Quilumosso/aluno.png';
            $data["css"] = file_get_contents('css/listas/style.css');
            $data["bootstrap"] = file_get_contents('css/listas/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "5000305308") {

            //$url = 'cartões/Foguetao/aluno.png';
            $data["css"] = file_get_contents('css/listas/style.css');
            $data["bootstrap"] = file_get_contents('css/listas/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "7301002572") {

            //$url = 'cartões/LiceuUíge/aluno.png';
            $data["css"] = file_get_contents('css/listas/style.css');
            $data["bootstrap"] = file_get_contents('css/listas/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "7301003617") {

            //$url = 'cartões/ldc/aluno.png';
            $data["css"] = file_get_contents('css/listas/style.css');
            $data["bootstrap"] = file_get_contents('css/listas/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "5000300926") {

            //$url = 'cartões/imagu/aluno.png';
            $data["css"] = file_get_contents('css/listas/style.css');
            $data["bootstrap"] = file_get_contents('css/listas/bootstrap.min.css');
        } else {
            //$url = 'images/cartao/aluno.jpg';
            $data["css"] = file_get_contents('css/listas/style.css');
            $data["bootstrap"] = file_get_contents('css/listas/bootstrap.min.css');
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