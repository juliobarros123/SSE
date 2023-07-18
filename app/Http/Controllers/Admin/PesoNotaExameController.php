<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classe;
use App\Models\PesoNotaExame;
use Auth;
use Illuminate\Http\Request;
use App\Models\Logger;
use App\Models\negativa;

class PesoNotaExameController extends Controller
{
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
        ;
        return view('admin.peso-nota-exame.cadastrar.index');

    }
    public function cadastrar(Request $request)
    {
        // dd($request);

        try {
            $data = $request->all();
            // dd($this->tem_registro());
            if ($this->tem_registro()) {
                return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Peso já existe']);
            }

            PesoNotaExame::create($request->all());
            $this->loggerData('Cadastrou  peso de notas para exames');

            return redirect()->route('configuracoes.pautas.pesos_notas_exames')->with('feedback', ['type' => 'success', 'sms' => 'Pesos de Notas para Exames Cadastrado com Sucesso']);

        } catch (Exception $e) {

            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado, verifica os dados se estão corretos']);


        }
    }


    public function actualizar(Request $request, $slug)
    {
        // dd($request,$slug);

        try {
          


            PesoNotaExame::where('slug', $slug)->update(
                $request->except(['_token', '_method'])
            );
            $this->loggerData('Editou  peso de notas para exames');

            return redirect()->route('configuracoes.pautas.pesos_notas_exames')->with('feedback', ['type' => 'success', 'sms' => 'Pesos actualizados com sucesso']);

        } catch (Exception $e) {
            // dd($e);
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado, verifica os dados se estão corretos']);


        }
    }
    //
    public function editar($slug)
    {
        $peso_nota_exame = fh_pesos_notas_exames()->where('peso_nota_exames.slug', $slug)->first();
        if ($peso_nota_exame):

            $data['peso_nota_exame'] = $peso_nota_exame;
    
            return view('admin.peso-nota-exame.editar.index', $data);
        else:
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado']);


        endif;
    }

    public function tem_registro()
    {
        return fh_pesos_notas_exames()->count();
        // if($estado){
        //     throw new Exception('Registro já existe!');
        //    }

    }
  


    public function eliminar($slug)
    {


        $peso_nota_exame = PesoNotaExame::where('peso_nota_exames.slug', $slug)->first();
        if ($peso_nota_exame):
            PesoNotaExame::where('peso_nota_exames.slug', $slug)->delete();
            $this->loggerData('Eliminou  peso de notas para exames');
            return redirect()->back()->with('feedback', ['status' => '1', 'sms' => 'Peso  eliminado com sucesso']);
        else:
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado']);


        endif;


    }

    public function index()
    {
        $data['pesos_notas_exames'] = fh_pesos_notas_exames()->get();


        //  dd($data);
        return view('admin.peso-nota-exame.index', $data);
    }
}
