<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Hashing;
use App\Models\notaDiplomado;
use App\Models\Curso;
use App\Models\Diplomados;
use App\Models\Disciplinas;
use App\Models\Classe;
use Illuminate\Support\Facades\DB;
use Mpdf\Tag\Br;
use Illuminate\Support\Facades\Auth;
class NotaDiplomadoController extends Controller


{

    public function loggerData($mensagem){
        $dados_Auth = Auth::user()->vc_primemiroNome.' '.Auth::user()->vc_apelido.' Com o nivel de '.Auth::user()->vc_tipoUtilizador.' ';
        $this->Logger->Log('info', $dados_Auth.$mensagem);
    }
    
    public function cadastrar($id)
    {
        $dip = Diplomados::find($id);

        $data['id_diplomado'] = $dip->id;
            $users = DB::table('disciplinas_cursos_classes')
                ->join('cursos', 'disciplinas_cursos_classes.it_curso', '=', 'cursos.id')
                ->join('classes', 'disciplinas_cursos_classes.it_classe', '=', 'classes.id')
                ->join('disciplinas', 'disciplinas_cursos_classes.it_disciplina', '=', 'disciplinas.id')
                ->where("it_curso","=",$dip->id_curso)
                ->get();
            $data['disciplinas'] = $users;
        return view('admin.notaDiplomado.cadastrar.index', $data);
    }
    public function store(Request $request)
    {
        $data = $request->all();
      //  dd($data);
        DB::table('nota_diplomados')
        ->updateOrInsert([
            'id_disciplina'=> $request->id_disciplina,
            'id_diplomado'=> $request->id_diplomado,
            'it_estado'=> $request->it_estado,
            'fl_classe'=> $request->fl_classe,

        ],
        [
            'fl_mfd'=> $request->fl_mfd,
            'fl_cfd'=> $request->fl_cfd,

        ]);
        return redirect()->back();

    }

    public function editar(Request $request, $id)
    {
        $updates = $request->all();
        notaDiplomado::find($id)->update($updates);
        return redirect()->route('admin.diplomados.listar');
    }

    public function listar()
    {
        $diplomados =  DB::table('notadiplomados')->get();
    }
}
