<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classe;
use App\Models\NNegativa;
use Auth;
use Illuminate\Http\Request;
use App\Models\Logger;
use App\Models\negativa;

// use 
class NNegativaController extends Controller
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
        $response['classes'] = fh_classes()->get();
        //  dd($response['classes']);
        return view('admin.n-negativas.cadastrar.index', $response);

    }
    public function cadastrar(Request $request)
    {

        try {
            // dd($request);
            foreach ($request->id_classe as $id_classe) {
                $response['id_classe'] = $id_classe;
                $classe=Classe::find($id_classe);
                $response['n'] = $request->n;
                if (!$this->tem_registro_cadastrar($response)) {
                    NNegativa::create($response);
                } else {
                    return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Registro já existe para a '.$classe->vc_classe.'ª Classe']);


                }
            }
            return redirect()->back()->with('feedback', ['type' => 'success', 'sms' => 'Números de negativas admintidas cadastradas com sucesso']);

        } catch (Exception $e) {

            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado, verifica os dados se estão corretos']);


        }
    }


    public function actualizar(Request $request, $slug)
    {
        // dd($request,$slug);

        try {
            //  $request->all();
// dd( $request);
            if ($this->tem_registro($request)) {
                return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Registro para esta classe já existe']);
            }
            $data['n'] = $request->n;
            $data['id_classe'] = $request->id_classe[0];

            NNegativa::where('slug', $slug)->update(
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
        $n_negativa = fh_n_negativas()->where('n_negativas.slug', $slug)->first();
        if ($n_negativa):
            // dd($n_negativa);
            $response['n_negativa'] = $n_negativa;
            $response['classes'] = fh_classes()->get();



            // dd(  $data['n_negativa'] );
            return view('admin.n-negativas.editar.index', $response);
        else:
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado']);


        endif;
    }

    public function tem_registro($request)
    {
        return fh_n_negativas()->where($request->except(['_token', '_method']))->count();
    }
    public function tem_registro_cadastrar($request)
    {
        // dd(fh_n_negativas()->where('n_negativas.id_classe',$request['id_classe'])->count());
        return fh_n_negativas()->where('n_negativas.id_classe', $request['id_classe'])->count();
    }
    public function eliminar($slug)
    {


        $n_negativas = fh_n_negativas()->where('n_negativas.slug', $slug)->first();
        if ($n_negativas):
            // dd($n_negativas);
            NNegativa::where('slug', $slug)->delete();
            $this->loggerData('Eliminou  números de negativas admintidas da ' . $n_negativas->vc_classe . 'ª Classe');
            return redirect()->back()->with('feedback', ['status' => '1', 'sms' => 'Registro eliminado com sucesso']);
        else:
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado']);


        endif;


    }

    public function index()
    {
        $data['n_negativas'] = fh_n_negativas()->get();


        //  dd($data);
        return view('admin.n-negativas.index', $data);
    }
}