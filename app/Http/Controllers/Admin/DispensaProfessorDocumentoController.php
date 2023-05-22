<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnoLectivo;
use App\Models\Funcionario;
use Illuminate\Http\Request;
use App\Models\Alunno;
use App\Models\Cabecalho;
use App\Models\Curso;
use App\Models\Logger;
use App\Models\Matricula;
use App\Models\Turma;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\Disciplinas;

class DispensaProfessorDocumentoController extends Controller
{
    //
    private $Logger;
    public function __construct()
    {
        $this->Logger = new Logger();
    }
    public function emitir()
    {
        $data['funcionarios'] = Funcionario::where('it_estado_funcionario',1)->where('vc_funcao','Docente')->get();
        $data['cursos'] = Curso::where([['it_estado_curso', 1], ['it_estadodoCurso', 1]])->get();
        $data['disciplinas'] = Disciplinas::where([['it_estado_disciplina', 1]])->get();
        return view('admin.documentos.dispensa_professor.index', $data);
    }
    public function imprimir(Request $request)
    {
        /* try { */
        $data['cabecalho'] = Cabecalho::find(1);
        $data['funcionario'] = Funcionario::find($request->id_funcionario);
        if (isset($request->id_funcionario)) {
            # code...
            if (!$data['funcionario']) {
                return redirect()->back()->with('dispensa_professor.funcionario.inexistente', 1);
            }
        }
        $data['disciplina'] = isset($request->disciplina) ? Disciplinas::find($request->disciplina)->vc_nome : null;
        $data['classe'] = isset($request->classe) ? $request->classe : null;
        $data['curso'] = isset($request->curso) ? $request->curso : null;
        $data['periodo'] = isset($request->periodo) ? $request->periodo : null;
        $data['data1'] = isset($request->data1) ? $request->data1 : null;
        $data['data2'] = isset($request->data2) ? $request->data2 : null;
        $data['motivo'] = isset($request->motivo) ? $request->motivo : null;
        $data['comprovativo'] = isset($request->comprovativo) ? $request->comprovativo : null;
        $data1 = Carbon::parse($data['data1']);
        $data2 = Carbon::parse($data['data2']);

        $diferencaEmDias = $data1->diffInDays($data2);
        $data['diferencaEmDias'] = $diferencaEmDias;
        //dd($data['funcionario']);
        $data["css"] = file_get_contents(__full_path() . 'css/pauta/style.css');
        $mpdf = new \Mpdf\Mpdf([
            'format' => 'A4',
            'margin_right' => 13,
            'margin_left' => 13
        ]);
        /* 'margin_right' => 8,
        'margin_left' => 8 */
        //$mpdf->SetFont("times new roman");
        $mpdf->setHeader();
        $this->Logger->Log('info', "Imprimiu a dispensa  do Professor com id $request->id_funcionario ");
        $html = "";

        if ($data['cabecalho']->vc_tipo_escola == "Liceu") {

            if ($request->modelo == "Dinâmico") {
                $html = view("admin.documentos.dispensa_professor.imprimir.liceu.index", $data);
            } elseif ($request->modelo == "Puro") {
                $html = view("admin.documentos.dispensa_professor.imprimir.liceu.index3", $data);
            } else {
                $html = view("admin.documentos.dispensa_professor.imprimir.liceu.index2", $data);
            }
        } else if ($data['cabecalho']->vc_tipo_escola == "Magistério") {
            if ($request->modelo == "Dinâmico") {
                $html = view("admin.documentos.dispensa_professor.imprimir.magisterio.index", $data);
            } elseif ($request->modelo == "Puro") {
                $html = view("admin.documentos.dispensa_professor.imprimir.magisterio.index3", $data);
            } else {
                $html = view("admin.documentos.dispensa_professor.imprimir.magisterio.index2", $data);
            }

        } else if ($data['cabecalho']->vc_tipo_escola == "Instituto") {


            if ($request->modelo == "Dinâmico") {
                $html = view("admin.documentos.dispensa_professor.imprimir.instituto.index", $data);
            } elseif ($request->modelo == "Puro") {
                $html = view("admin.documentos.dispensa_professor.imprimir.instituto.index3", $data);
            } else {
                $html = view("admin.documentos.dispensa_professor.imprimir.instituto.index2", $data);
            }
        }
        // return   $html;
        $mpdf->writeHTML($html);

        $mpdf->Output("dispensa_professor $request->processo", "I");

        /*  } catch (\Throwable $th) {
        return redirect()->back()->with('dispensa_professor.imprimir.error',1);
        } */
    }
}