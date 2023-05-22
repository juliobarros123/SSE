<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Turma;
use Illuminate\Support\Facades\DB;
class ProfessorController extends Controller
{
    public function loggerData($mensagem){
        $dados_Auth = Auth::user()->vc_primemiroNome.' '.Auth::user()->vc_apelido.' Com o nivel de '.Auth::user()->vc_tipoUtilizador.' ';
        $this->Logger->Log('info', $dados_Auth.$mensagem);
    }

    public function listarTurmas($id_user){
        $data['turmas'] = DB::table("turmas_users")
        ->join("classes","turmas_users.it_idClasse","classes.id")
        ->join("disciplinas","turmas_users.it_idDisciplina","disciplinas.id")
        ->join("turmas","turmas_users.it_idTurma","turmas.id")
        ->where("it_idUser",$id_user)->get();

         return view("admin.turmas.professor.index",$data);

    }
}
