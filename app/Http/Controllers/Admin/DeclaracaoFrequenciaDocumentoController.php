<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnoLectivo;
use App\Models\Estudante;
use Illuminate\Http\Request;
use App\Models\Alunno;
use App\Models\Cabecalho;
use App\Models\Curso;
use App\Models\Logger;
use App\Models\Matricula;
use App\Models\Turma;
use App\Models\Disciplinas;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class DeclaracaoFrequenciaDocumentoController extends Controller
{
    //
    private $Logger;
    public function __construct()
    {
        $this->Logger = new Logger();
    }
    public function emitir()
    {
        $data['desd'] = DB::table('turmas_users')
            ->join('disciplinas', 'disciplinas.id', '=', 'turmas_users.it_idDisciplina')
            ->join('users', 'users.id', '=', 'turmas_users.it_idUser')
            ->leftJoin('turmas', 'turmas.id', '=', 'turmas_users.it_idTurma')
            ->select('disciplinas.id', 'turmas.vc_cursoTurma', 'turmas.vc_classeTurma', 'disciplinas.vc_nome', 'disciplinas.vc_acronimo')
            ->where('turmas_users.it_idUser', Auth::user()->id)->distinct()
            ->get();

        $data['disciplinas'] = Disciplinas::where([['it_estado_disciplina', 1]])->get();
        return view('admin.documentos.declaracao_frequencia.index', $data);
    }
    public function imprimir(Request $request, Estudante $estudantes)
    {
        /* try { */
        $data['cabecalho'] = Cabecalho::find(1);
        $data['aluno'] = Alunno::find($request->processo);

        if (isset($request->processo) && (!$data['aluno'])) {
            return redirect()->back()->with('declaracao_frequencia.aluno.inexistente', 1);
        }

        if (isset($request->processo) && $data['aluno']) {
            $data["matricula"] = Matricula::join('classes', 'classes.id', 'matriculas.it_idClasse')
                ->join('turmas', 'matriculas.it_idTurma', 'turmas.id')
                ->join('cursos', 'matriculas.it_idCurso', 'cursos.id')
                ->select('matriculas.it_idAluno', 'matriculas.vc_anoLectivo', 'turmas.*', 'cursos.vc_nomeCurso', 'matriculas.it_idTurma')
                ->where('matriculas.it_idAluno', $request->processo)
                ->where('matriculas.it_estado_matricula', 1)
                ->orderBy('matriculas.it_idTurma', 'desc')->first();

            $data['ano_lectivo'] = AnoLectivo::find($data['matricula']->it_idAnoLectivo);
            //dd($data["matricula"]->it_idTurma );

            $c = $estudantes->StudentForClassroom($data["matricula"]->it_idTurma);
            $contador = 0;
            /*  dd( $c); */
            foreach ($c as $aluno) {
                $contador++;
                if ($aluno->id == $request->processo) {
                    break;
                }
            }
        }

        $data['efeito'] = $request->efeito;
        if (isset($request->processo) && $data['aluno']) {
        $data['n_ordem'] = $contador;
        }

        $data["css"] = file_get_contents(__full_path() . 'css/pauta/style.css');
        $mpdf = new \Mpdf\Mpdf([
            'format' => 'A4',
            'margin_right' => 28,
            'margin_left' => 28
        ]);
        /* 'margin_right' => 8,
              'margin_left' => 8 */
        //$mpdf->SetFont("times new roman");
        $mpdf->setHeader();
        $this->Logger->Log('info', "Imprimiu uma declaração de frequência do aluno com processo $request->processo ");
        $html = "";

       if ($data['cabecalho']->vc_tipo_escola == "Instituto") {


            if ($request->modelo == "Dinâmico") {
                $html = view("admin.documentos.declaracao_frequencia.imprimir.instituto.index", $data);
            } elseif ($request->modelo == "Puro") {
                $html = view("admin.documentos.declaracao_frequencia.imprimir.instituto.index3", $data);
            } else {
                $html = view("admin.documentos.declaracao_frequencia.imprimir.instituto.index2", $data);
            }
        }else {
            return redirect()->back()->with('declaracao_frequencia.imprimir.error',1);
        }
        // return   $html;


        $mpdf->writeHTML($html);

        $mpdf->Output("declaracao_frequencia $request->processo", "I");

        /*  } catch (\Throwable $th) {
             return redirect()->back()->with('declaracao_frequencia.imprimir.error',1);
         } */
    }
}