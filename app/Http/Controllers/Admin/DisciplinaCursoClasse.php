<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classe;
use App\Models\Curso;
use App\Models\Disciplinas;
use App\Models\Disciplina_Curso_Classe;
use App\Models\Logger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
class DisciplinaCursoClasse extends Controller
{
    private $Logger;
    private $disciplina_Curso_Classe;
    public function __construct()
    {
        $this->Logger = new Logger();
        $this->disciplina_Curso_Classe = new Disciplina_Curso_Classe();
    }

    
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Disciplina_Curso_Classe $middle)
    {
        //
        $response['respostas'] = $middle->get_DCC()->get();
        return view('admin.disciplina_curso_classe.index', $response);
    }
    public function loggerData($mensagem)
    {
        $dados_Auth = Auth::user()->vc_primemiroNome . ' ' . Auth::user()->vc_apelido . ' Com o nivel de ' . Auth::user()->vc_tipoUtilizador . ' ';
        $this->Logger->Log('info', $dados_Auth . $mensagem);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

            $response['cursos'] = Curso::where([['it_estado_curso', 1]])->get();
            $response['disciplinas'] = Disciplinas::orderby('vc_nome', 'asc')->where([['it_estado_disciplina', 1]])->get();
            $response['classes'] = Classe::where([['it_estado_classe', 1]])->get();

        

        return view('admin.disciplina_curso_classe.cadastrar.index', $response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    
        try {
           $this->disciplina_Curso_Classe->tem_registro($request);
            
            Disciplina_Curso_Classe::create($request->all());
            $this->loggerData('Adicionou um relacionamento de Disciplina, Curso, Classe');
            return redirect()->route('admin.disciplina_curso_classe')->with('status', '1');

        } catch (Exception $e) {
            return redirect()->back()->with('mensagem_dinamica', '' . $e->getMessage())->with('tipo', 'error')->with('obs', 'Provavelmente este registro já existe!');

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

        $response['resposta'] = Disciplina_Curso_Classe::where([['it_estado_dcc', 1], ['id', $id]])->first();

        $response['cursos'] = Curso::where([['it_estado_curso', 1]])->get();
        $response['disciplinas'] = Disciplinas::orderby('vc_nome', 'asc')->where([['it_estado_disciplina', 1]])->get();
        $response['classes'] = Classe::where([['it_estado_classe', 1]])->get();
        return view('admin.disciplina_curso_classe.editar.index', $response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        try {
        
            $this->disciplina_Curso_Classe->tem_registro($request);
             
        Disciplina_Curso_Classe::find($id)->update($request->all());
        $this->Logger->Log('info', 'Actualizou Uma Disciplina');

        return redirect()->route('admin.disciplina_curso_classe');
        
    } catch (Exception $e) {
   
        return redirect()->back()->with('mensagem_dinamica', '' .$e->getMessage())->with('tipo', 'error')->with('obs', 'Provavelmente este registro já existe!');

    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
       
        try {
           
            $response = Disciplina_Curso_Classe::find($id);
            $response->update(['it_estado_dcc' => 0]);
    
            $this->loggerData('Eliminou o relacionamento de Disciplina, Curso, Classe');
            return redirect()->back()->with('disciplina_curso_classe.eliminar.success', '1');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('disciplina_curso_classe.eliminar.error', '1');
        }
    }

    public function purgar($id)
    {
        try {
           
            $response = Disciplina_Curso_Classe::find($id);
            $response2 = Disciplina_Curso_Classe::find($id)->delete();
            $this->loggerData("Purgou o relacionamento de Disciplina, Curso, Classe");
            return redirect()->back()->with('disciplina_curso_classe.purgar.success', '1');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('disciplina_curso_classe.purgar.error', '1');
        }
    }

    public function eliminadas(Disciplina_Curso_Classe $middle)
    {
      

      
        $response['respostas'] = $middle->get_DCC2()->get();
       
        $response['eliminadas']="eliminadas";
        return view('admin.disciplina_curso_classe.index', $response);
    }

    public function recuperar($id)
    {
        try {
           
            $response = Disciplina_Curso_Classe::find($id);
            $response->update(['it_estado_dcc' => 1]);
            $this->loggerData("Recuperou o relacionamento de Disciplina, Curso, Classe");
            return redirect()->back()->with('disciplina_curso_classe.recuperar.success', '1');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('disciplina_curso_classe.recuperar.error', '1');
        }
    }
}
