<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alunno;
use App\Models\Municipio;
use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\Classe;
use App\Models\AnoLectivo;
use App\Models\Disciplinas;
use App\Models\Turma;
use App\Models\Disciplina_Curso_Classe;
use App\Models\Matricula;
use Exception;
use Illuminate\Support\Facades\DB;


class DynamicSearch extends Controller
{


    public function searchGradeSubject(Request $request)
    {
        $classesEscolas = [];
        if ($request->has('q')) {
            $buscar = $request->q;
            $classesEscolas = Escola::select("id", "vc_escola")
                ->where('vc_escola', 'LIKE', "%$buscar%")->get();
        }

        return response()->json($classesEscolas);
    }

    public function searchClassAtrib(Request $request)
    {
        $turmasAtrib = [];
        if ($request->has('q')) {
            $buscar = $request->id;
            $turmasAtrib = DB::table("turmas")
                ->join("classes", "turmas.it_idClasse", "classes.id")
                ->join("cursos", "turmas.it_idCurso", "cursos.id")
                ->where('vc_escola', 'LIKE', "%$buscar%")
                ->get();
        } else {

            $turmasAtrib = DB::table("turmas")
                ->join("classes", "turmas.it_idClasse", "classes.id")
                ->join("cursos", "turmas.it_idCurso", "cursos.id")
                ->get();
        }
        return response()->json($turmasAtrib);
    }

    public function  searchSubjectAtrib(Request $request)
    {

        $turmasAtrib = [];
        if ($request->has('q')) {
            $buscar = $request->id;
            $turmasAtrib = DB::table("disciplinas_curso_classe")
                ->where('vc_escola', 'LIKE', "%$buscar%")
                ->get();
        } else {

            $turmasAtrib = DB::table("turmas")
                ->join("classes", "turmas.it_idClasse", "classes.id")
                ->join("cursos", "turmas.it_idCurso", "cursos.id")
                ->get();
        }
        return response()->json($turmasAtrib);
    }

    public function searchClass(Request $request)
    {
        $turmas = [];
        if ($request->has('q')) {
            $buscar = $request->q;
            $turmas = Turma::select("id", "vc_nomeDaTurma")
                ->where('vc_escola', 'LIKE', "%$buscar%")->get();
        }

        return response()->json($turmas);
    }
    public function searchProcess(Request $request)
    {
        try{
        $alunos = [];
        if ($request->has('q')) {
            $buscar = $request->q;
            $m = Matricula::where('id_aluno', $buscar)->count();
            if($m){
                $alunos = Alunno::leftJoin('matriculas','matriculas.it_idAluno','alunnos.id')->
                select("alunnos.id", "matriculas.vc_imagem as foto","alunnos.vc_primeiroNome","alunnos.vc_nomedoMeio","alunnos.vc_ultimoaNome","matriculas.id as id_m")
                    ->where('alunnos.id', 'LIKE', "%$buscar%")->limit(1)->get();
            }else{
                $alunos =   Alunno::
                select("id", "foto","vc_primeiroNome","vc_nomedoMeio","vc_ultimoaNome")
                    ->where('id', 'LIKE', "%$buscar%")->limit(1)->get();
            }
        }

        return response()->json($alunos);
    }catch(Exception $ex){
        return response()->json($ex->getMessage());
    }
    }

    public function searchCourse(Request $request)
    {
        $cursos = [];
        if ($request->has('q')) {
            $buscar = $request->q;
            $cursos = Curso::select("id", "vc_nomeCurso")
                ->where('vc_nomeCurso', 'LIKE', "%$buscar%")->get();
        } else {

            $cursos = DB::select('select * from cursos ');
        }

        return response()->json($cursos);
    }

    public function searchJob(Request $request)
    {
        $profissoes = [];
        if ($request->has('q')) {
            $buscar = $request->q;
            $profissoes = Curso::select("id", "vc_nomeCurso")
                ->where('vc_nomeCurso', 'LIKE', "%$buscar%")->get();
        } else {
            $profissoes = DB::select('select * from cursos');
        }

        return response()->json($profissoes);
    }

    public function searchSubject(Request $request)
    {
        $disciplinas = [];
        if ($request->has('q')) {
            $buscar = $request->q;
            $disciplinas = Disciplinas::select("id", "vc_nome")
                ->where('vc_nome', 'LIKE', "%$buscar%")->get();
        } else {
            $disciplinas = DB::select('select * from disciplinas');
        }

        return response()->json($disciplinas);
    }

    public function searchGrade(Request $request)
    {
        $classes = [];
        if ($request->has('q')) {
            $buscar = $request->q;
            $classes = Classe::select("id", "vc_classe")
                ->where('vc_classe', 'LIKE', "%$buscar%")->get();
        } else {
            $classes = DB::select('select * from classes');
        }
        return response()->json($classes);
    }


    public function searchProvince(Request $request)
    {
        $provincias = [];
        if ($request->has('q')) {
            $buscar = $request->q;
            $provincias = Provincia::select("id", "vc_nome")
                ->where('vc_nome', 'LIKE', "%$buscar%")->get();
        } else {
            $provincias = DB::select('select * from provincias');
        }
        return response()->json($provincias);
    }


    public function searchMunicipe($id_provincia)
    {
        $municipios = [];
        
            $municipios = Municipio::select("id", "vc_nome")
                ->where('it_id_provincia',  $id_provincia)->get();
       
        return response()->json($municipios);
    }

    public function searchClassRegistration(Request $request)
    {
        $turmas = [];
        $anoLectivo = AnoLectivo::where([['it_estado_anoLectivo', 1]])->orderby('id', 'desc')->first();

        if ($request->has('q')) {
            $buscar = $request->q;
            $turmas = Turma::where('it_estado_turma', 1)->get();
        } else {
            $turmas = Turma::where('it_estado_turma', 1)->get();
        }
        return response()->json($turmas);
    }



    public function searchYear(Request $request)
    {
        $anoslectivos = [];
        if ($request->has('q')) {
            $buscar = $request->q;
            $anoslectivos = AnoLectivo::select("id", "ya_inicio", "ya_fim")
                ->where('ya_fim', 'LIKE', "%$buscar%")->get();
        }

        return response()->json($anoslectivos);
    }
}
