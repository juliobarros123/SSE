<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PermissaoProfessorNota;
use App\Models\User;
use Exception;
class PermissaoProfessorNotaController extends Controller
{
    //~
    public function permitir(){
      $professores=  User::where('vc_tipoUtilizador','Professor')->get();
      return view('admin.permissao-nota-professor.permitir.index',compact('professores'));
    }
    public function index(){
      
    $permissoes=  PermissaoProfessorNota::join('users', 'permissao_professor_notas.id_user', '=', 'users.id')
    ->select('permissao_professor_notas.*','users.vc_primemiroNome','users.vc_apelido')
    ->get();
        return view('admin.permissao-nota-professor.index',compact('permissoes'));
       
    }
    public function cadastrar(Request $request){
        // dd($request);
        if(!$this->tem_registro($request)){
            PermissaoProfessorNota::create($request->all());
            return redirect()->route('permissoes.nota.professor.permitir')->with('permissao_professor',1);
        }else{
            return redirect()->route('permissoes.nota.professor.permitir')->with('permissao_erro',1);
        }
      

    }
    public function eliminar($id){
        PermissaoProfessorNota::find($id)->delete();
        return redirect()->route('permissoes.nota.professor.permitir')->with('permissao_eliminada',1);
    }
    public function tem_registro($array){
    
        $array_limpo = $array->except('_token','_method');
    
        $estado=PermissaoProfessorNota::where($array_limpo)->count();
        if($estado){
           return $estado;
           }
      
      }
}
