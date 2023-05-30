<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AnoLectivo;
use App\Models\Cabecalho;
use App\Models\Classe;
use App\Models\Curso;
use App\Models\Nota;
use App\Models\Melhor_Aluno;
use Illuminate\Support\Facades\DB;
use App\Models\Logger;
use Illuminate\Support\Facades\Auth;

class Melhores_AlunosController extends Controller
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
    public function search()
    {
        // dd("ola");
        $response['anoslectivos'] = AnoLectivo::where([['it_estado_anoLectivo', 1]])->get();
        $response['classes'] = Classe::where([['it_estado_classe', 1]])->get();
        $response['trimestres'] = Nota::where([['it_estado_nota', 1]])->get();
        return view('admin.Melhores_Alunos.search.index', $response);
    }
    public function recebeAlunoMelhor(Request $request)
    {
        $classe = $request->classe;
        $anoLectivo = $request->vc_anolectivo;
        $trimestre = $request->vc_nomeT;
        $formato = $request->papel;
        $nota = $request->nota?$request->nota:14;
        $nota2 = $request->nota2?$request->nota2:20;
        return redirect("/ver/melhor/$classe/$trimestre/$anoLectivo/$formato/$nota/$nota2");
    }
    public function index($classe, $trimestre, $id_ano_lectivo, $formato,$nota,$nota2, Melhor_Aluno $alunos)
    {
        // dd($nota2);
        $anolectivo = AnoLectivo::find($id_ano_lectivo);
        $alunnos = $alunos->AlunoForShow($id_ano_lectivo, $classe, $trimestre);
        // dd( $alunnos);
        if ($alunnos->isNotEmpty()) {
// dd($classe);
            $data['alunos'] = $alunnos;
            $data['nota'] = $nota;
            $data['nota2'] = $nota2;
            // dd(  $data['nota']);
            $data['anoLectivo'] =  $anolectivo->ya_inicio . '-' . $anolectivo->ya_fim;
            $data['trimestre'] =  $trimestre;
            $data['cabecalho'] = Cabecalho::find(1);
            $data['classe'] = Classe::find($classe)->vc_classe;
            $data['id_classe'] =$classe;
            $data["bootstrap"] = file_get_contents('css/Aluno_melhor/bootstrap.min.css');
            if ($formato == 'A3') {
                $data["css"] = file_get_contents('css/Aluno_melhor/A3.css');
                $mpdf = new \Mpdf\Mpdf([
                    'mode' => 'utf-8', 'margin_top' => 0,
                    'margin_left' => 5,
                    'margin_right' => 0, 'margin_bottom' => 0, 'format' => [297, 420]
                ]);

                $mpdf->SetFont("arial");
                $mpdf->setHeader();
                $mpdf->AddPage('L');
                $this->Logger->Log('info', 'Imprimiu a lista dos melhores alunos ');
                $html = view("admin/pdfs/Melhores_Alunos/alunos", $data);
                $mpdf->writeHTML($html);
                $mpdf->Output("Melhores Alunos.pdf", "I");
            } else {
                $data["css"] = file_get_contents('css/Aluno_melhor/style.css');
                $mpdf = new \Mpdf\Mpdf([
                    'mode' => 'utf-8', 'margin_top' => 0,
                    'margin_left' => 5,
                    'margin_right' => 0, 'margin_bottom' => 0, 'format' => [210, 297]
                ]);

                $mpdf->SetFont("arial");
                $mpdf->setHeader();
                $mpdf->AddPage('L');
                $this->Logger->Log('info', 'Imprimiu a lista dos melhores alunos ');
                $html = view("admin/pdfs/Melhores_Alunos/alunos", $data);
                $mpdf->writeHTML($html);
                $mpdf->Output("Melhores Alunos.pdf", "I");
            }
        } else {
            return redirect()->back()->with('aviso', '1');
        }
    }
}
