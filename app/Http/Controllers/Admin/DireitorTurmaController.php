<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AnoLectivo;
use App\Models\AnoLectivoPublicado;
use App\Models\Classe;
use App\Models\Curso;
use App\Models\User;
use App\Models\Turma;
use App\Models\DireitorTurma;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Exception;

class DireitorTurmaController extends Controller
{
    private $director_turma;
    public function __construct()
    {
        $this->director_turma = new DireitorTurma();


    }

    public function criar()
    {
        $response['anoslectivos'] = fh_anos_lectivos_publicado()->first();
        $anoLectivoPublicado = $response['anoslectivos']->ya_inicio . "-" . $response['anoslectivos']->ya_fim;

        $data['users'] = fh_professores()->get();

        $data['turmas'] = fh_turmas()->get();


        return view('admin.direitores-turmas.cadastrar.index', $data);
        //dd($data);


    }
    public function cadastrar(Request $request)
    {
        // dd($request);

        try {
            $data = $request->all();

            if ($this->tem_registro($request)) {
                return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'O professor já é diretor desta turma.']);

            }
            //
            if ($this->turma_tem_director($request->id_turma)) {
                return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Esta turma já possui um diretor']);

            }



            DireitorTurma::create(
                [
                    'id_turma' => $request->id_turma,
                    'id_user' => $request->id_user,
                    'id_cabecalho' => Auth::User()->id_cabecalho
                ]
            );
            return redirect()->back()->with('feedback', ['type' => 'success', 'sms' => 'Director de turma cadastrado com sucesso']);




        } catch (Exception $e) {

            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado, verifica os dados se estão corretos']);


        }
    }


    public function actualizar(Request $request, $slug)
    {
        // dd($request);

        try {
            $data = $request->all();

            if ($this->tem_registro($request)) {
                return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'O professor já é diretor desta turma.']);

            }
            //




            DireitorTurma::where('slug', $slug)->update(
                [
                    'id_turma' => $request->id_turma,
                    'id_user' => $request->id_user,

                ]
            );
            return redirect()->back()->with('feedback', ['type' => 'success', 'sms' => 'Director de turma actualizado com sucesso']);




        } catch (Exception $e) {
            // dd($e);
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado, verifica os dados se estão corretos']);


        }
    }
    //
    public function editar($slug)
    {
        $director_turma = fh_directores_turmas()->where('direitor_turmas.slug', $slug)->first();
        if ($director_turma):
            // dd($director_turma);
            $data['director_turma'] = $director_turma;
            $data['users'] = fh_professores()->get();

            $data['turmas'] = fh_turmas()->get();

            return view('admin.direitores-turmas.editar.index', $data);
        else:
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado']);


        endif;
    }

    public function tem_registro($array)
    {
        $array_limpo = $array->except(['_token', '_method']);
        return DireitorTurma::where($array_limpo)->count();
        // if($estado){
        //     throw new Exception('Registro já existe!');
        //    }

    }
    public function turma_tem_director($id_turma)
    {

        return DireitorTurma::where('id_turma', $id_turma)->count();


    }
    public function cadastro_existe($dados)
    {
        return DB::table('coordenador_cursos')
            ->join('users', 'users.id', 'coordenador_cursos.id_user')
            ->join('cursos', 'cursos.id', 'coordenador_cursos.id_curso')
            ->where('coordenador_cursos.id_user', $dados->id_user)
            ->where('coordenador_cursos.id_curso', $dados->id_curso)
            ->count();
    }



    public function eliminar($slug)
    {


        $director_turma = fh_directores_turmas()->where('direitor_turmas.slug', $slug)->first();
        if ($director_turma):
            fh_directores_turmas()->where('direitor_turmas.slug', $slug)->delete();
            // $this->loggerData('Eliminou  director de turma com id  ', $director_turma->id);
            return redirect()->back()->with('feedback', ['status' => '1', 'sms' => 'Atribuição eliminada com sucesso']);
        else:
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado']);


        endif;


    }
public function meus(){
   $response['directores']= fha_meus_director_turmas();
   return view('admin.direitores-turmas.meus.index', $response);

}
    public function index()
    {
        $data['directores'] = fh_directores_turmas()->get();


        //  dd($data);
        return view('admin.direitores-turmas.index', $data);
    }

}