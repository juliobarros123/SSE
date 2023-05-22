<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Curso;
use App\Models\CoordenadorCurso;
use Illuminate\Support\Facades\DB;
use App\Models\AnoLectivo;
use Illuminate\Support\Facades\Auth;
class CoordenadorCursoController extends Controller
{
    //

    public function index(){
        $dados['coordenadors_cursos']=  DB::table('coordenador_cursos')
        ->join('users', 'users.id','coordenador_cursos.id_user')
        ->join('cursos', 'cursos.id','coordenador_cursos.id_curso')
        // ->where('coordenador_cursos.it_estado_coordenador_curso',1)
        ->select('coordenador_cursos.id', 'cursos.vc_nomeCurso','users.vc_primemiroNome','users.vc_apelido')
        ->get();
       
      return view('admin.coordenador_curso.index',$dados);
      }

      public function meus_coordenadores(){
        $dados['coordenadors_cursos']=   DB::table('coordenador_cursos')
        ->join('users', 'users.id','coordenador_cursos.id_user')
        ->join('cursos', 'cursos.id','coordenador_cursos.id_curso')
        ->join('turmas', 'turmas.it_idCurso', '=', 'cursos.id')
        ->join('turmas_users', 'turmas_users.it_idTurma', '=', 'turmas.id')
        ->where('coordenador_cursos.it_estado_coordenador_curso',1)
        ->where('turmas_users.it_idUser',Auth::user()->id)
        ->distinct()
        ->select('coordenador_cursos.id', 'cursos.vc_nomeCurso','users.vc_primemiroNome','users.vc_apelido')
        ->get();
        return view('admin.coordenador_curso.index',$dados);
      }
    public function criar(){
        
           $dados['users']=User::all();
           $dados['cursos']=Curso::all();
        return view('admin.coordenador_curso.criar.index',$dados);
    }
    public function cadastrar(Request $dados){
        if($this->cadastra_existe($dados)){
            return redirect('/coordernadores_cursos')->with('existe','1');
        }
   $result= CoordenadorCurso::create($dados->all());  
   if($result){
    return redirect('/coordernadores_cursos')->with('cadastrado','1');
  }else{
    return redirect('/coordernadores_cursos')->with('erro','1');
}
      
    }

    public function editar($id_coord_curso){
        $dados['coordenador_curso']= DB::table('coordenador_cursos')
        ->join('users', 'users.id','coordenador_cursos.id_user')
        ->join('cursos', 'cursos.id','coordenador_cursos.id_curso')
        ->where('coordenador_cursos.id',$id_coord_curso)
        ->first();
        
        $dados['id_coord_curso']=$id_coord_curso;
        $dados['users']=User::all();
        $dados['cursos']=Curso::all();
       return view('admin.coordenador_curso.editar.index',$dados);
    }
    public function actualizar(Request $dados, $id_coord_curso){
        if($this->cadastra_existe($dados)){
            return redirect('/coordernadores_cursos')->with('existe','1');
        }
            $result=   CoordenadorCurso::find($id_coord_curso)->update($dados->all());
            if($result){
              return redirect('/coordernadores_cursos')->with('actualizado','1');
            }else{
              return redirect('/coordernadores_cursos')->with('erro','1');
          }
       
     
    }

    public function eliminar($id_coord_curso){
        $result = CoordenadorCurso::find($id_coord_curso)->detete();
        if($result){
            return redirect('/coordernadores_cursos')->with('eliminado','1');
          }else{
            return redirect('/coordernadores_cursos')->with('erro','1');
        }
    }

    public function cadastra_existe($dados){
     return   DB::table('coordenador_cursos')
        ->join('users', 'users.id','coordenador_cursos.id_user')
        ->join('cursos', 'cursos.id','coordenador_cursos.id_curso')
        ->where('coordenador_cursos.id_user',$dados->id_user)
        ->where('coordenador_cursos.id_curso',$dados->id_curso)
        ->count();
    }

    public function pesquisar_turmas()
    {
        $response['anoslectivos'] = AnoLectivo::where([['it_estado_anoLectivo', 1]])->get();
        // dd($this->dados()->get());
        $response['cursos'] = $this->dados()->where('coordenador_cursos.id_user',Auth::user()->id)
        ->get();
    

        return view('admin/turmas/pesquisar/index', $response);
    }



    public function minhas_turmas(){
       $respose['minhas_turmas']= DB::table('coordenador_cursos')
        ->join('users', 'users.id','coordenador_cursos.id_user')
        ->join('cursos', 'cursos.id','coordenador_cursos.id_curso')
        ->join('turmas', 'cursos.id','turmas.it_idCurso')
        ->where('coordenador_cursos.id_user',Auth::user()->id)
        ->count();
    }

    public function dados(){
     return   DB::table('coordenador_cursos')
        ->join('users', 'users.id','coordenador_cursos.id_user')
        ->join('cursos', 'cursos.id','coordenador_cursos.id_curso')
        // ->join('turmas', 'cursos.id','turmas.it_idCurso')
        ->where('coordenador_cursos.it_estado_coordenador_curso',1);
  
    }
}
