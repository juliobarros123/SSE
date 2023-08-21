<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alunno;
use App\Models\AnoLectivo;
use App\Models\Cabecalho;
use App\Models\Curso;
use App\Models\Estudante;
use Illuminate\Http\Request;
use App\Models\Logger;
use Illuminate\Support\Facades\Auth;
use App\Models\Classe;
class ListadSelecionado extends Controller
{
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
        $response['anoslectivos'] = fh_anos_lectivos()->get();
        $response['cursos'] = fh_cursos()->get();
        $response['classes'] = fh_classes()->get();
        return view('admin/alunos/listas/index', $response);
    }
    public function recebeSelecionados(Request $request)
    {
        if (!$request->id_curso) {
            $filtro_aluno_lista = session()->get('filtro_aluno_lista');
            $request->id_curso = $filtro_aluno_lista['id_curso'];
        }
        if (!$request->id_ano_lectivo) {
            $filtro_aluno_lista = session()->get('filtro_aluno_lista');
            $request->id_ano_lectivo = $filtro_aluno_lista['id_ano_lectivo'];
        }
        if (!$request->id_classe) {
            $filtro_aluno_lista = session()->get('filtro_aluno_lista');
            $request->id_classe = $filtro_aluno_lista['id_classe'];
        }
        $data['ano_lectivo'] = 'Todos';
        $data['curso'] = 'Todos';
        $data['classe'] = 'Todas';

        // dd($request);
    
       $alunos = fh_alunos();
    //    dd(   $alunos->get());
    // dd($request->id_ano_lectivo != 'Todos' && $request->id_ano_lectivo);
        if ($request->id_ano_lectivo != 'Todos' && $request->id_ano_lectivo) {
            $ano_lectivo = fh_anos_lectivos()->find($request->id_ano_lectivo);
            $data['ano_lectivo'] = $ano_lectivo->ya_inicio . '/' . $ano_lectivo->ya_fim;
            // dd(  $data['anolectivo']);
           $alunos =$alunos->where('candidatos.id_ano_lectivo', $request->id_ano_lectivo);
        }

        if ($request->id_curso != 'Todos' && $request->id_curso) {
            // dd($candidados->get(),$request->id_curso);
            $data['curso'] = Curso::find($request->id_curso)->vc_nomeCurso;

           $alunos =$alunos->where('candidatos.id_curso', $request->id_curso);
        }
        if ($request->id_classe != 'Todas' && $request->id_classe) {
            // dd($candidados->get(),$request->id_classe);
            $data['classe'] =   Classe::find($request->id_classe)->vc_classe;

           $alunos =$alunos->where('candidatos.id_classe', $request->id_classe);
        }
        $filtro_aluno_lista = [
            'id_ano_lectivo' => $request->id_ano_lectivo,
            'id_curso' => $request->id_curso,
            'id_classe' => $request->id_classe,
        ];

        storeSession('filtro_aluno_lista', $filtro_aluno_lista);
        $data['alunos'] =$alunos->get();
        // dd(  $data);
        $data["css"] = file_get_contents('css/lista/style-2.css');
        $data['cabecalho'] = fh_cabecalho();
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'margin_top' => 5,

        ]);
 
        $mpdf->setHeader();
        $this->loggerData('Imprimiu Lista dos Selecionados a Matricula');
        $html = view("admin/pdfs/listas/selecionados/index", $data);

        $mpdf->writeHTML($html);
        $mpdf->Output("candidatos-aceitos-$data[curso]- $data[classe].pdf", "I");
     
    }
    // public function index(Estudante $Ralunos, $anoLectivo, $curso)
    // {
    //     if ($anoLectivo == 'Todos') {
    //         $anoLectivo = '';
    //     }
    //     if ($curso == 'Todos') {
    //         $curso = '';
    //     }
    //     $c =  $Ralunos->SelecionadosListas($anoLectivo, $curso);
    //     $data['alunos'] = $c->get();
    //     $data['anolectivo'] = $anoLectivo;
    //     $data['curso'] = $curso;


    //     $data['cabecalho'] = Cabecalho::find(1);
    //    /*  $data["bootstrap"] = file_get_contents("css/listas/bootstrap.min.css");
    //     $data["css"] = file_get_contents("css/listas/style.css"); */

    //     if ($data['cabecalho']->vc_nif == "5000298182") {

    //         //$url = 'cartões/CorMarie/aluno.png';
    //         $data["css"] = file_get_contents('css/listas/style.css');
    //         $data["bootstrap"] = file_get_contents('css/listas/bootstrap.min.css');

    //     } else if ($data['cabecalho']->vc_nif == "7301002327") {

    //         //$url = 'cartões/InstitutoPolitécnicodoUIGE/aluno.png';
    //         $data["css"] = file_get_contents('css/listas/style.css');
    //         $data["bootstrap"] = file_get_contents('css/listas/bootstrap.min.css');
    //     } else if ($data['cabecalho']->vc_nif == "5000303399") {

    //         //$url = 'cartões/negage/aluno.png';
    //         $data["css"] = file_get_contents('css/listas/style.css');
    //         $data["bootstrap"] = file_get_contents('css/listas/bootstrap.min.css');
    //     } else if ($data['cabecalho']->vc_nif == "5000820440") {
        
    //         //$url = 'cartões/Quilumosso/aluno.png';
    //         $data["css"] = file_get_contents('css/listas/style.css');
    //         $data["bootstrap"] = file_get_contents('css/listas/bootstrap.min.css');
    //     } else if ($data['cabecalho']->vc_nif == "5000305308") {

    //         //$url = 'cartões/Foguetao/aluno.png';
    //         $data["css"] = file_get_contents('css/listas/style.css');
    //         $data["bootstrap"] = file_get_contents('css/listas/bootstrap.min.css');
    //     } else if ($data['cabecalho']->vc_nif == "7301002572") {

    //         //$url = 'cartões/LiceuUíge/aluno.png';
    //         $data["css"] = file_get_contents('css/listas/style.css');
    //         $data["bootstrap"] = file_get_contents('css/listas/bootstrap.min.css');
    //     } else if ($data['cabecalho']->vc_nif == "7301003617") {

    //         //$url = 'cartões/ldc/aluno.png';
    //         $data["css"] = file_get_contents('css/listas/style.css');
    //         $data["bootstrap"] = file_get_contents('css/listas/bootstrap.min.css');
    //     } else if ($data['cabecalho']->vc_nif == "5000300926") {

    //         //$url = 'cartões/imagu/aluno.png';
    //         $data["css"] = file_get_contents('css/listas/style.css');
    //         $data["bootstrap"] = file_get_contents('css/listas/bootstrap.min.css');
    //     }  else {
    //         //$url = 'images/cartao/aluno.jpg';
    //         $data["css"] = file_get_contents('css/listas/style.css');
    //         $data["bootstrap"] = file_get_contents('css/listas/bootstrap.min.css');
    //     }

    //     $mpdf = new \Mpdf\Mpdf();

    //     $mpdf->SetFont("arial");
    //     $mpdf->setHeader();
    //     $mpdf->defaultfooterline = 0;
    //     $mpdf->setFooter('{PAGENO}');
      
    //     $mpdf->writeHTML($html);
    //     $mpdf->Output("listasdSelecionados.pdf", "I");
    // }
}
