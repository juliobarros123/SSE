<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnoLectivo;
use Illuminate\Http\Request;
use App\Models\Alunno;
use App\Models\Cabecalho;
use App\Models\Curso;
use App\Models\Logger;
use App\Models\Matricula;
use App\Models\Turma;
use Disciplinas;
use Illuminate\Support\Facades\Http;

class AnulacaoMatriculaDocumentoController extends Controller
{
    //
    private $Logger;
    public function __construct()
    {
        $this->Logger = new Logger();
    }
    public function emitir()
    {
        return view('admin.documentos.anulacao_matricula.index');
    }
    public function imprimir(Request $request)
    {
        try {
        $data['cabecalho'] = Cabecalho::find(1);
        $data['aluno'] = Alunno::find($request->processo);

        if (! $data['aluno']) {
            return redirect()->back()->with('anulacao_matricula.aluno.inexistente',1);
        }
        $data["matricula"] = Matricula::join('classes', 'classes.id', 'matriculas.it_idClasse')
            ->join('turmas', 'matriculas.it_idTurma', 'turmas.id')
            ->join('cursos', 'matriculas.it_idCurso', 'cursos.id')
            ->select('matriculas.it_idAluno','matriculas.vc_anoLectivo','turmas.*','cursos.vc_nomeCurso','cursos.vc_shortName')
            ->where('matriculas.it_idAluno', $request->processo)
            ->where('matriculas.it_estado_matricula', 1)
            ->orderBy('matriculas.it_idTurma', 'desc')->first();
        $data['ano_lectivo'] = AnoLectivo::find($data['matricula']->it_idAnoLectivo);
        //dd( $data['ano_lectivo']);
        $data["css"] = file_get_contents(__full_path() . 'css/pauta/style.css');
        $mpdf = new \Mpdf\Mpdf([
            'format' => 'A4',
            'margin_right' => 30,
               'margin_left' => 30 
        ]);
         /* 'margin_right' => 8,
               'margin_left' => 8 */
        //$mpdf->SetFont("times new roman");
        $mpdf->setHeader();
        $this->Logger->Log('info', "Imprimiu a anulação de matricula do aluno com processo $request->processo ");
        $html = "";
  
        if ($data['cabecalho']->vc_tipo_escola == "Liceu") {
            
            if ($request->modelo == "Dinâmico") {
                $html = view("admin.documentos.anulacao_matricula.imprimir.liceu.index", $data);
            }elseif ($request->modelo == "Puro") {
                $html = view("admin.documentos.anulacao_matricula.imprimir.liceu.index3", $data);
            }else {
                $html = view("admin.documentos.anulacao_matricula.imprimir.liceu.index2", $data);
            }
        } else if ($data['cabecalho']->vc_tipo_escola == "Magistério") {
            if ($request->modelo == "Dinâmico") {
                $html = view("admin.documentos.anulacao_matricula.imprimir.magisterio.index", $data);
            }elseif ($request->modelo == "Puro") {
                $html = view("admin.documentos.anulacao_matricula.imprimir.magisterio.index3", $data);
            }else {
                $html = view("admin.documentos.anulacao_matricula.imprimir.magisterio.index2", $data);
            }
            
        } else if ($data['cabecalho']->vc_tipo_escola == "Instituto") {
         
           
            if ($request->modelo == "Dinâmico") {
                $html = view("admin.documentos.anulacao_matricula.imprimir.instituto.index", $data);
            }elseif ($request->modelo == "Puro") {
                $html = view("admin.documentos.anulacao_matricula.imprimir.instituto.index3", $data);
            }else {
                $html = view("admin.documentos.anulacao_matricula.imprimir.instituto.index2", $data);
            }
        }
        // return   $html;
        $mpdf->writeHTML($html);

        $mpdf->Output("anulacao_matricula $request->processo", "I");

        } catch (\Throwable $th) {
            return redirect()->back()->with('anulacao_matricula.imprimir.error',1);
        }
    }
}