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
    public function cadastrarDireitor()
    {
        $response['anoslectivos'] = AnoLectivoPublicado::find(1);
        $anoLectivoPublicado = $response['anoslectivos']->ya_inicio."-".$response['anoslectivos']->ya_fim;
        
        $data['users'] = User::where('vc_tipoUtilizador', '=', 'professor')->get();
        $data['turmas'] = Turma::where('it_estado_turma', 1)->where('vc_anoLectivo',$anoLectivoPublicado)->get();
        $data['cursos'] = Curso::where('it_estado_curso', 1)->get();
        $data['classes'] = Classe::where('it_estado_classe', 1)->get();
        $data['ano_letivos'] = AnoLectivo::where('it_estado_anoLectivo', 1)->get();

        return view('admin.direitor-turma.cadastrar.index', $data);
        //dd($data);


    }
    //
    public function efectuarCadastroDireitor(Request $request)
    {
       // dd($request);

       try{
        $data  = $request->all();
       
        $this->director_turma->tem_registro($request);
        $this->director_turma->turma_tem_director($request->id_turma);
     
 
            DireitorTurma::create(
                [
                    'id_turma' => $request->id_turma,
                    'id_user' => $request->id_user,
                    'id_anoLectivo' => $request->id_anoLectivo,
                    'it_estado_dt' => 1
                ]);
                return redirect()->back()->with('status','1');

    

       }catch(Exception $e){
 
        return redirect()->back()->with('mensagem_dinamica', ''.$e->getMessage())->with('tipo', 'error')->with('obs', 'Provavelmente este registro já existe!');
            
    }
}
    public function cadastro_existe($dados){
        return   DB::table('coordenador_cursos')
           ->join('users', 'users.id','coordenador_cursos.id_user')
           ->join('cursos', 'cursos.id','coordenador_cursos.id_curso')
           ->where('coordenador_cursos.id_user',$dados->id_user)
           ->where('coordenador_cursos.id_curso',$dados->id_curso)
           ->count();
       }

    public function listarDireitores()
    {
        $data['direitores'] = DB::table('direitor_turmas')
        ->where('direitor_turmas.it_estado_dt',1)
        ->join('turmas','direitor_turmas.id_turma','turmas.id')
        ->join('users','direitor_turmas.id_user','users.id')
        ->join('cursos','turmas.it_idCurso','cursos.id')
        ->select('users.vc_primemiroNome','users.vc_apelido','direitor_turmas.id','users.vc_email','turmas.vc_nomedaTurma','turmas.vc_classeTurma','cursos.vc_nomeCurso')
       ->get();
      //  dd($data);
        return view('admin.direitor-turma.index',$data);
    }

    public function editarDireitor()
    {

    }

    public function deletarDireitor($id)
    {
        $data = DireitorTurma::find($id);
       // dd($data);
        $data->update([
            'it_estado_dt' => 0
        ]);
        return redirect()->back();

    }

    public function purgar($id){

        DireitorTurma::find($id)->delete();
        return redirect()->back();

    }
    public function efectuarEdicaoDireitor()
    {
       

    }
    public function consultar_turmas(){
     $response['anoslectivos'] = AnoLectivo::where([['it_estado_anoLectivo', 1]])->get();
     $response['cursos'] = $this->dados()->where('id_user',Auth::user()->id)
     ->select('cursos.vc_nomeCurso' ,'cursos.id')->get();
     return view('admin/turmas/coordenador/pesquisar/index', $response);
    }
    public function turmas(Request $dados){
      

        $anolectivo=$dados->id_anolectivo!="Todos"?AnoLectivo::find($dados->id_anolectivo):"Todos";
        if( $anolectivo!="Todos"){
            $anolectivo=$anolectivo->ya_inicio . '-' . $anolectivo->ya_fim ;
        }else{
            $anolectivo="Todos" ;
        }
      
     $turmas= $this->dados()->where('direitor_turmas.id_user',Auth::user()->id);


     if($dados->id_anolectivo!="Todos"){
        $turmas= $turmas->where('direitor_turmas.id_anoLectivo',$dados->id_anolectivo);
     }
 
     if($dados->vc_curso!="Todos"){
        $turmas=    $turmas->where('cursos.vc_nomeCurso',$dados->vc_curso);
     }
    
  
     $turmas=  $turmas->select('turmas.id as id_turma','turmas.*','classes.*','cursos.*')->get();
     $response['turmas']= $turmas;
     $response['anolectivo']= $anolectivo;
     return view('admin.turmas.coordenador.index', $response);

    }
    public function dados(){
        return   DB::table('direitor_turmas')
           ->join('turmas', 'turmas.id','direitor_turmas.id_turma')
           ->join('cursos', 'cursos.id','turmas.it_idCurso')
           ->join('classes', 'turmas.it_idClasse', '=', 'classes.id')
           ->where('direitor_turmas.it_estado_dt',1);
     
       }
      
}
