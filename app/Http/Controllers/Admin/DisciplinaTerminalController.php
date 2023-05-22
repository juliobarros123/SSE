<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classe;
use Illuminate\Http\Request;
use App\Models\Disciplina_Terminal as DT;
use App\Models\Disciplinas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Curso;
class DisciplinaTerminalController extends Controller
{
    public function setDisciplinaTerminal(Request $request)
    {   
        $dt=$request->except(['_method','_token']);
      
        if($this->tem_registro($dt)){
            return redirect()->route('admin.disciplinaTerminal.list.get')->with("error", 1);
        }

        DT::create([
            'it_estado' => 1, 
            'id_disciplina' => $request->id_disciplina, 
            'id_classe' => $request->id_classe, 

            'it_idCurso' => $request->it_idCurso, 
        ]);
        return redirect()->back()->with('DTCreate',1);
    }
    public function loggerData($mensagem){
        $dados_Auth = Auth::user()->vc_primemiroNome.' '.Auth::user()->vc_apelido.' Com o nivel de '.Auth::user()->vc_tipoUtilizador.' ';
        $this->Logger->Log('info', $dados_Auth.$mensagem);
    }

    public function getViewDisciplinaTerminal()
    {
        $data['cursos'] = Curso::all();
      
        $data['diciplinas'] = Disciplinas::all();
       // dd($data['diciplinas']);
        $data['classe'] = Classe::all();

        return view('admin.disciplina_terminal.cadastrar.index',$data);
    }

    public function getListDisciplinaTerminal()
    {
        $dados['dt'] =  DB::table('disciplina__terminals')
        ->join('classes','disciplina__terminals.id_classe','classes.id')
      
        ->join('disciplinas','disciplina__terminals.id_disciplina','disciplinas.id')
        ->leftJoin('cursos', 'disciplina__terminals.it_idCurso', '=', 'cursos.id')
        ->select('disciplinas.vc_acronimo','disciplinas.vc_nome','disciplina__terminals.*','classes.vc_classe','cursos.vc_nomeCurso')
        ->where('disciplina__terminals.it_estado',1)
      
        ->get();
       
       return view('admin.disciplina_terminal.index',$dados);
    }

    public function setDeleteDisciplinaTerminal($id)
    {
        DT::find($id)->delete();
        return redirect()->back()->with('DtDelete', 0);
    }

    public function setDestroyDisciplinaTerminal($id)
    {
        DB::table('disciplina__terminals')->where('id',$id)->update(['it_estado' => 0]);
        
        return redirect()->back()->with("DTDestroy", 0);

    }

    public function setEditDisciplinaTerminal(Request $request , $id)
    
    {  
        $dt=$request->except(['_method','_token']);
       
      
        if($this->tem_registro($dt)){
            return redirect()->route('admin.disciplinaTerminal.list.get')->with("error", 1);
        }
        DB::table('disciplina__terminals')->where('id',$id)->update($dt);
     
       return redirect()->back()->with("DTEdit", 1);

    }

    public function getEditDisciplinaTerminal($id)
    {
        $data['cursos'] = Curso::all();
       
        $data['dt']=    DB::table('disciplina__terminals')
                            ->join('classes','disciplina__terminals.id_classe','classes.id')
                          
                            ->join('disciplinas','disciplina__terminals.id_disciplina','disciplinas.id')
                            ->leftJoin('cursos', 'disciplina__terminals.it_idCurso', '=', 'cursos.id')
                            ->select('disciplinas.vc_acronimo','disciplinas.vc_nome','disciplina__terminals.*','classes.vc_classe','cursos.vc_nomeCurso')
                            ->where('disciplina__terminals.it_estado',1)
                            ->where('disciplina__terminals.id',$id)
                            ->first();
    
                            return view('admin.disciplina_terminal.editar.index',$data);

    }
  
        public function tem_registro($array){
         
            return DT::where($array)->where('it_estado',1)->count();
            
          
          }

    
}
