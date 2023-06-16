<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Classe;
use App\Models\DisciplinaExame;
use Auth;

use App\Models\Disciplinas;
use Illuminate\Http\Request;
use App\Models\Logger;



class DisciplinaExameController extends Controller
{
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
        $response['classes'] = fh_classes()->get();
        $response['disciplinas'] = fh_disciplinas()->get();
        return view('admin.disciplina-exame.cadastrar.index', $response);

    }
    public function cadastrar(Request $request)
    {

        try {
            // dd($request);
            foreach ($request->id_disciplina as $id_disciplina) {
                $response['id_disciplina'] = $id_disciplina;
                $response['id_classe'] = $request->id_classe;

                $disciplina=Disciplinas::find($id_disciplina);
                if (!$this->tem_registro_cadastrar($response)) {
                    DisciplinaExame::create($response);
                } else {
                    return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Para essa classe, já existe a disciplina de  '.$disciplina->vc_nome]);


                }
            }
            return redirect()->route('configuracoes.pautas.disciplinas_exames')->with('feedback', ['type' => 'success', 'sms' => ' Disciplinas para Exames cadastradas com sucesso']);

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
        $disciplina_exame = fh_disciplinas_exames()->where('disciplina_exames.slug', $slug)->first();
        if ($disciplina_exame):
            // dd($disciplina_exame);
            $response['disciplina_exame'] = $disciplina_exame;
            $response['classes'] = fh_classes()->get();
            $response['disciplinas'] = fh_disciplinas()->get();



            // dd(  $data['n_negativa'] );
            return view('admin.disciplina-exame.editar.index', $response);
        else:
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado']);


        endif;
    }

    public function tem_registro($request)
    {
        return fh_disciplinas_exames()->where($request->except(['_token', '_method']))->count();
    }
    public function tem_registro_cadastrar($request)
    {
        // dd(fh_disciplinas_exames()->where('disciplinas_exames.id_classe',$request['id_classe'])->count());
        return fh_disciplinas_exames()->where($request)->count();
    }
    public function eliminar($slug)
    {

        $disciplina_exames = fh_disciplinas_exames()->where('disciplina_exames.slug', $slug)->first();
        if ($disciplina_exames):
            // dd($disciplina_exames);
            DisciplinaExame::where('slug', $slug)->delete();
            $this->loggerData('Eliminou  Disciplinas  '.$disciplina_exames->vc_nome.' para Exame  na  ' . $disciplina_exames->vc_classe . 'ª Classe');
            return redirect()->back()->with('feedback', ['status' => '1', 'sms' => 'Registro eliminado com sucesso']);
        else:
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado']);
        endif;


    }

    public function index()
    {
        // dd("ol");
        $data['disciplinas_exames'] = fh_disciplinas_exames()->get();


        //  dd($data);
        return view('admin.disciplina-exame.index', $data);
    }
}
