<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class TurnoProfessorController extends Controller
{
    //
    public function consultar(){
        $turnos=$this->meus_turnos();
        return view('admin.turno_professor.consultar.index',compact('turnos'));
    }
    public function meus_turnos(){
      $turnos=DB::table('coordenador_turnos')
      ->where('id_user',Auth::user()->id)
      ->select('turno')
      ->get();
      return $turnos;
    }
    public function index(Request $dados){
    $professores=  $this->dados()->where('users.vc_tipoUtilizador', '=', 'professor')
      ->where('turmas.vc_turnoTurma', '=',  $dados->turno)
      ->get();
     return view('admin.turno_professor.index',compact('professores'));
    }
    public function dados(){
        $professores= DB::table('turmas_users')
        ->join('users', 'users.id', '=', 'turmas_users.it_idUser')
        ->leftJoin('turmas', 'turmas.id', '=', 'turmas_users.it_idTurma');
        return $professores;
    }

}
