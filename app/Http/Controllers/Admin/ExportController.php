<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\cadernetaExport;
use App\Models\Estudante;
use App\Models\Classe;
use App\Models\Curso;
use App\Models\Turma;
use App\Models\TurmaUser;
use App\Models\AnoLectivo;
use App\Http\Requests\turmaRequests\CadastrarEEditarTurmaRequest;
use App\Models\Cabecalho;
use Illuminate\Support\Facades\DB;
use App\Models\Logger;
use Illuminate\Support\Facades\Auth;
use Turmas;
class ExportController extends Controller
{

    public function exports(Estudante $estudantes, $id){

        $c = $estudantes->StudentForClassroom($id);
       // dd($c);

        if ($c->count()) :
            //Metodo que gera as cadernetas do alunos
            $data['turma'] = Turma::where([['it_estado_turma', 1]])->find($id);
            $data['alunos'] =  $c;
            $data['cabecalho'] = Cabecalho::find(1);
           /*  $data["bootstrap"] = file_get_contents("css/caderneta/bootstrap.min.css");
            $data["css"] = file_get_contents("css/caderneta/style.css"); */
            if ($data['cabecalho']->vc_nif == "5000298182") {

                //$url = 'cartões/CorMarie/aluno.png';
                $data["css"] = file_get_contents('css/caderneta/style.css');
                $data["bootstrap"] = file_get_contents('css/caderneta/bootstrap.min.css');

            } else if ($data['cabecalho']->vc_nif == "7301002327") {

                //$url = 'cartões/InstitutoPolitécnicodoUIGE/aluno.png';
                $data["css"] = file_get_contents('css/caderneta/style.css');
                $data["bootstrap"] = file_get_contents('css/caderneta/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000303399") {

                //$url = 'cartões/negage/aluno.png';
                $data["css"] = file_get_contents('css/caderneta/style.css');
                $data["bootstrap"] = file_get_contents('css/caderneta/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000820440") {
            
                //$url = 'cartões/Quilumosso/aluno.png';
                $data["css"] = file_get_contents('css/caderneta/style.css');
                $data["bootstrap"] = file_get_contents('css/caderneta/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000305308") {

                //$url = 'cartões/Foguetao/aluno.png';
                $data["css"] = file_get_contents('css/caderneta/style.css');
                $data["bootstrap"] = file_get_contents('css/caderneta/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "7301002572") {

                //$url = 'cartões/LiceuUíge/aluno.png';
                $data["css"] = file_get_contents('css/caderneta/style.css');
                $data["bootstrap"] = file_get_contents('css/caderneta/bootstrap.min.css');
             }else if ($data['cabecalho']->vc_nif == "7301003617") {

                //$url = 'cartões/ldc/aluno.png';
                $data["css"] = file_get_contents('css/caderneta/style.css');
                $data["bootstrap"] = file_get_contents('css/caderneta/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000300926") {

                //$url = 'cartões/imagu/aluno.png';
                $data["css"] = file_get_contents('css/caderneta/style.css');
                $data["bootstrap"] = file_get_contents('css/caderneta/bootstrap.min.css');
            } else {
                //$url = 'images/cartao/aluno.jpg';
                $data["css"] = file_get_contents('css/caderneta/style.css');
                $data["bootstrap"] = file_get_contents('css/caderneta/bootstrap.min.css');
            }


        return Excel::download(new cadernetaExport ($data) , 'caderneta.xlsx');

        else :
            return redirect('turmas/pesquisar')->with('aviso', 'Não existe nenhum Aluno nesta turma');
        endif;

    }

    public function exportsView(Estudante $estudantes, $id){

        $c = $estudantes->StudentForClassroom($id);
       // dd($c);

        if ($c->count()) :
            //Metodo que gera as cadernetas do alunos
            $data['turma'] = Turma::where([['it_estado_turma', 1]])->find($id);
            $data['alunos'] =  $c;
            $data['cabecalho'] = Cabecalho::find(1);
           /*  $data["bootstrap"] = file_get_contents("css/caderneta/bootstrap.min.css");
            $data["css"] = file_get_contents("css/caderneta/style.css"); */
            if ($data['cabecalho']->vc_nif == "5000298182") {

                //$url = 'cartões/CorMarie/aluno.png';
                $data["css"] = file_get_contents('css/caderneta/style.css');
                $data["bootstrap"] = file_get_contents('css/caderneta/bootstrap.min.css');

            } else if ($data['cabecalho']->vc_nif == "7301002327") {

                //$url = 'cartões/InstitutoPolitécnicodoUIGE/aluno.png';
                $data["css"] = file_get_contents('css/caderneta/style.css');
                $data["bootstrap"] = file_get_contents('css/caderneta/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000303399") {

                //$url = 'cartões/negage/aluno.png';
                $data["css"] = file_get_contents('css/caderneta/style.css');
                $data["bootstrap"] = file_get_contents('css/caderneta/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000820440") {
            
                //$url = 'cartões/Quilumosso/aluno.png';
                $data["css"] = file_get_contents('css/caderneta/style.css');
                $data["bootstrap"] = file_get_contents('css/caderneta/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000305308") {

                //$url = 'cartões/Foguetao/aluno.png';
                $data["css"] = file_get_contents('css/caderneta/style.css');
                $data["bootstrap"] = file_get_contents('css/caderneta/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "7301002572") {

                //$url = 'cartões/LiceuUíge/aluno.png';
                $data["css"] = file_get_contents('css/caderneta/style.css');
                $data["bootstrap"] = file_get_contents('css/caderneta/bootstrap.min.css');
             }else if ($data['cabecalho']->vc_nif == "7301003617") {

                //$url = 'cartões/ldc/aluno.png';
                $data["css"] = file_get_contents('css/caderneta/style.css');
                $data["bootstrap"] = file_get_contents('css/caderneta/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000300926") {

                //$url = 'cartões/imagu/aluno.png';
                $data["css"] = file_get_contents('css/caderneta/style.css');
                $data["bootstrap"] = file_get_contents('css/caderneta/bootstrap.min.css');
            } else {
                //$url = 'images/cartao/aluno.jpg';
                $data["css"] = file_get_contents('css/caderneta/style.css');
                $data["bootstrap"] = file_get_contents('css/caderneta/bootstrap.min.css');
            }


        return view('admin.pdfs.cadernetaxlsx.index',$data);

        else :
            return redirect('turmas/pesquisar')->with('aviso', 'Não existe nenhum Aluno nesta turma');
        endif;

    }
}
