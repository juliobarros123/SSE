<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Classe;
use App\Models\DisciplinaExame;
use Auth;
use App\Models\Curso;
use App\Models\Disciplinas;
use App\Models\CriterioDisciplina;
use App\Models\Logger;
class CriterioDisciplinaController extends Controller
{
    //
     //
     //
    //
    public function __construct()
    {
        $this->Logger = new Logger();

    }
    //
    public function loggerData($mensagem)
    {

        $dados_Auth = Auth::user()->vc_primemiroNome . ' ' . Auth::user()->vc_apelido . ' Com o nivel de ' . Auth::user()->vc_tipoUtilizador . ' ';
        $this->Logger->Log('info', $dados_Auth . $mensagem);
    }
    public function criar()
    {
        $response['cursos'] = fh_cursos()->get();
        $response['classes'] = fh_classes()->get();
        $response['disciplinas'] = fh_disciplinas()->get();
        return view('admin.criterio-disciplina.cadastrar.index', $response);

    }
    public function cadastrar(Request $request)
    {

        try {
            // dd($request);
            $cont=0;
            foreach ($request->id_disciplina as $id_disciplina) {
                $response['id_disciplina'] = $id_disciplina;
                $response['id_classe'] = $request->id_classe;
                $response['id_curso'] = $request->id_curso;
                $disciplina=Disciplinas::find($id_disciplina);
                $curso= Curso::find($request->id_curso);
              
                if (!$this->tem_registro_cadastrar($response)) {
                    CriterioDisciplina::create([
                        'id_disciplina'=>$id_disciplina,
                        'id_curso'=>$request->id_curso,
                        'id_classe'=>$request->id_classe,
                        'resultado'=>$request->resultado,
                        'valor_inicial'=>$request->valor_inicial,
                        'valor_final'=>$request->valor_final
                    ]);
                }else{
                    $cont++;
                }
            }
            return redirect()->route('configuracoes.pautas.criterio_disciplinas')->with('feedback', ['type' => 'success', 'sms' => "Critérios cadastrados com sucesso(Tentativa de repetição de critérios($cont))"]);

        } catch (Exception $e) {

            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado, verifica os dados se estão corretos']);


        }
    }


    public function actualizar(Request $request, $slug)
    {
        // dd($request,$slug);

        try {
            //  $request->all();
if(count($request->id_disciplina)>1 || count($request->id_disciplina)==0){
    return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Actualiza para apenas uma disciplina']);

}
            if ($this->tem_registro($request)) {
                return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Registro para esta classe já existe']);
            }

            $data['id_classe'] = $request->id_classe;
            $data['id_disciplina'] = $request->id_disciplina[0];

            DisciplinaExame::where('slug', $slug)->update(
                $data
            );
            return redirect()->back()->with('feedback', ['type' => 'success', 'sms' => 'Registro actualizado com sucesso']);

        } catch (Exception $e) {
            // dd($e);
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado, verifica os dados se estão corretos']);


        }
    }
    //
    public function editar($slug)
    {
        $disciplina_exame = fh_criterio_disciplinas()->where('disciplina_exames.slug', $slug)->first();
        if ($disciplina_exame):
            // dd($disciplina_exame);
            $response['disciplina_exame'] = $disciplina_exame;
            $response['classes'] = fh_classes()->get();
            $response['disciplinas'] = fh_disciplinas()->get();



            // dd(  $data['n_negativa'] );
            return view('admin.criterio-disciplina.editar.index', $response);
        else:
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado']);


        endif;
    }

    public function tem_registro($request)
    {
        return fh_criterio_disciplinas()->where($request->except(['_token', '_method']))->count();
    }
    public function tem_registro_cadastrar($request)
    {
        // dd(fh_criterio_disciplinas()->where('disciplinas_exames.id_classe',$request['id_classe'])->count());
        return fh_criterio_disciplinas()->where($request)->count();
    }
    public function eliminar($slug)
    {
// dd($slug);
        $criterio_disciplina = fh_criterio_disciplinas()->where('criterio_disciplinas.slug', $slug)->first();
        if ($criterio_disciplina):
            // dd($criterio_disciplina);
            CriterioDisciplina::where('slug', $slug)->delete();
            $this->loggerData('Eliminou  Disciplinas  '.$criterio_disciplina->vc_nome.' no critério de notas para aprovação da ' . $criterio_disciplina->vc_classe . 'ª Classe');
            return redirect()->back()->with('feedback', ['status' => '1', 'sms' => 'Registro eliminado com sucesso']);
        else:
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado']);
        endif;


    }

    public function index()
    {
        // dd("ol");
        $data['criterio_disciplinas'] = fh_criterio_disciplinas()->get();


        //  dd($data);
        return view('admin.criterio-disciplina.index', $data);
    }
}
