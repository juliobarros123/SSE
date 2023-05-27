<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ListaXlsSite as ListaExport;
use App\Exports\BoletimExport;
use App\Models\Estudante;
use App\Models\Classe;

use App\Models\TurmaUser;
use App\Models\AnoLectivo;
use App\Http\Requests\turmaRequests\CadastrarEEditarTurmaRequest;
use App\Models\Cabecalho;
use Illuminate\Support\Facades\DB;
use App\Models\Logger;
use Illuminate\Support\Facades\Auth;
use Turmas;
use App\Models\Curso;
use App\Models\Pauta;
use App\Models\Turma;
use App\Models\Nota;
use App\Models\Disciplina_Curso_Classe;
class ListaCadastroSiteController extends Controller
{
    //
    public function create(Pauta $ResponseAlunos, $id, $trimestre)
    {


        $data['cabecalho'] = Cabecalho::find(1);
        $ResponseTurma = Turma::find($id);
        $data['turma'] = $ResponseTurma;
        $data['trimestres'] = $trimestre;

        /* Acessando os dados da turma */
        $vc_anoLectivo = $ResponseTurma->vc_anoLectivo;
        $vc_cursoTurma = $ResponseTurma->vc_cursoTurma;
        $vc_classeTurma = $ResponseTurma->vc_classeTurma;
        /* end-acesso */

        /* joins apartir do model */
        $data['cabecalhoNotas'] =   $ResponseAlunos->HeaderNoteforPauta($vc_cursoTurma, $vc_classeTurma)->get();

        $AlunoRes = $ResponseAlunos->AlunosforPauta($vc_anoLectivo, $ResponseTurma->id)->get();
        $data['alunos'] = $AlunoRes;
        /* endjoins */
    }


    public function exports($turma_id)
    {   $data['turma'] = Turma::find($turma_id);
        $data['alunos'] = DB::table('matriculas')->select("*")->where("it_idTurma",$turma_id)->join("alunnos","matriculas.it_idAluno","alunnos.id")->get();
      //  dd($data);

        if($data):

            return Excel::download(new ListaExport($data), 'Lista'.$data['turma']->vc_nomedaTurma.'_'.$data['turma']->vc_classeTurma.'_'.date(DATE_RFC2822).'.xls');

        else :
            return redirect('turmas/pesquisar')->with('aviso', 'Não existe nenhum Aluno nesta turma');
        endif;
    }

    public function exportsView(Estudante $estudantes, $id)
    {

        $c = $estudantes->StudentForClassroom($id);


        if ($c->count()) :
            //Metodo que gera as cadernetas do alunos
            $data['turma'] = Turma::where([['it_estado_turma', 1]])->find($id);
            $data['alunos'] =  $c;
            $data['cabecalho'] = Cabecalho::find(1);
           /*  $data["bootstrap"] = file_get_contents("css/caderneta/bootstrap.min.css");
            $data["css"] = file_get_contents("css/caderneta/style.css");
 */

            if ($data['cabecalho']->vc_nif == "5000298182") {

                //$url = 'cartões/CorMarie/aluno.png';
                $data["css"] = file_get_contents(.'css/caderneta/style.css');
                $data["bootstrap"] = file_get_contents(.'css/caderneta/bootstrap.min.css');

            } else if ($data['cabecalho']->vc_nif == "7301002327") {

                //$url = 'cartões/InstitutoPolitécnicodoUIGE/aluno.png';
                $data["css"] = file_get_contents(.'css/caderneta/style.css');
                $data["bootstrap"] = file_get_contents(.'css/caderneta/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000303399") {

                //$url = 'cartões/negage/aluno.png';
                $data["css"] = file_get_contents(.'css/caderneta/style.css');
                $data["bootstrap"] = file_get_contents(.'css/caderneta/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000820440") {
            
                //$url = 'cartões/Quilumosso/aluno.png';
                $data["css"] = file_get_contents(.'css/caderneta/style.css');
                $data["bootstrap"] = file_get_contents(.'css/caderneta/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000305308") {

                //$url = 'cartões/Foguetao/aluno.png';
                $data["css"] = file_get_contents(.'css/caderneta/style.css');
                $data["bootstrap"] = file_get_contents(.'css/caderneta/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "7301002572") {

                //$url = 'cartões/LiceuUíge/aluno.png';
                $data["css"] = file_get_contents(.'css/caderneta/style.css');
                $data["bootstrap"] = file_get_contents(.'css/caderneta/bootstrap.min.css');
             }else if ($data['cabecalho']->vc_nif == "7301003617") {

                //$url = 'cartões/ldc/aluno.png';
                $data["css"] = file_get_contents(.'css/caderneta/style.css');
                $data["bootstrap"] = file_get_contents(.'css/caderneta/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000300926") {

                //$url = 'cartões/imagu/aluno.png';
                $data["css"] = file_get_contents(.'css/caderneta/style.css');
                $data["bootstrap"] = file_get_contents(.'css/caderneta/bootstrap.min.css');
            } else {
                //$url = 'images/cartao/aluno.jpg';
                $data["css"] = file_get_contents(.'css/caderneta/style.css');
                $data["bootstrap"] = file_get_contents(.'css/caderneta/bootstrap.min.css');
            }


            return view('admin.pdfs.cadernetaxlsx.index', $data);

        else :
            return redirect('turmas/pesquisar')->with('aviso', 'Não existe nenhum Aluno nesta turma');
        endif;
    }
}
