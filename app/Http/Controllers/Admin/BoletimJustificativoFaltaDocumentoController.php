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
class BoletimJustificativoFaltaDocumentoController extends Controller
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
        return view('admin.documentos.boletim_justificativo_falta.index',$data);
    }
    public function imprimir(Request $request, Estudante $estudantes)
    {
        /* try { */
        $data['cabecalho'] = Cabecalho::find(1);
        $data['aluno'] = Alunno::find($request->processo);

        if (! $data['aluno']) {
            return redirect()->back()->with('boletim_justificativo_falta.aluno.inexistente',1);
        }
        $data["matricula"] = Matricula::join('classes', 'classes.id', 'matriculas.it_idClasse')
            ->join('turmas', 'matriculas.it_idTurma', 'turmas.id')
            ->join('cursos', 'matriculas.it_idCurso', 'cursos.id')
            ->select('matriculas.it_idAluno','matriculas.vc_anoLectivo','turmas.*','cursos.vc_nomeCurso','matriculas.it_idTurma')
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
           if($aluno->id ==  $request->processo){
            break;
           }
        }
      
        $data['faltas'] = $request->faltas;
        $data['data_falta'] = $request->data;
        $data['motivo_falta'] = $request->motivo;
        $data['n_ordem'] = $contador;
        
        $data["css"] = file_get_contents(__full_path() . 'css/pauta/style.css');
        $mpdf = new \Mpdf\Mpdf([
            'format' => 'A4-L',
            'margin_right' => 25,
            'margin_left' => 25 
        ]);
         /* 'margin_right' => 8,
               'margin_left' => 8 */
        //$mpdf->SetFont("times new roman");
        $mpdf->setHeader();
        $this->Logger->Log('info', "Imprimiu um boletim de justificativo de faltas do aluno com processo $request->processo ");
        $html = "";
  
        if ($data['cabecalho']->vc_tipo_escola == "Liceu") {
            
            if ($request->modelo == "Dinâmico") {
                $html = view("admin.documentos.boletim_justificativo_falta.imprimir.liceu.index", $data);
            }elseif ($request->modelo == "Puro") {
                $html = view("admin.documentos.boletim_justificativo_falta.imprimir.liceu.index3", $data);
            }else {         
                $html = view("admin.documentos.boletim_justificativo_falta.imprimir.liceu.index2", $data);
            }
        } else if ($data['cabecalho']->vc_tipo_escola == "Magistério") {
         
            if ($request->modelo == "Dinâmico") {
          
                $html = view("admin.documentos.boletim_justificativo_falta.imprimir.magisterio.index", $data);

            }elseif ($request->modelo == "Puro") {
              
                $html = view("admin.documentos.boletim_justificativo_falta.imprimir.magisterio.index3", $data);
            }else {
              
                $html = view("admin.documentos.boletim_justificativo_falta.imprimir.magisterio.index2", $data);
            }
     
        } else if ($data['cabecalho']->vc_tipo_escola == "Instituto") {
          
           
            if ($request->modelo == "Dinâmico") {
                $html = view("admin.documentos.boletim_justificativo_falta.imprimir.instituto.index", $data);
            }elseif ($request->modelo == "Puro") {
                $html = view("admin.documentos.boletim_justificativo_falta.imprimir.instituto.index3", $data);
            }else {
                $html = view("admin.documentos.boletim_justificativo_falta.imprimir.instituto.index2", $data);
            }
        }
        // return   $html;

      
        $mpdf->writeHTML($html);

        $mpdf->Output("boletim_justificativo_falta $request->processo", "I");

       /*  } catch (\Throwable $th) {
            return redirect()->back()->with('boletim_justificativo_falta.imprimir.error',1);
        } */
    }
}
