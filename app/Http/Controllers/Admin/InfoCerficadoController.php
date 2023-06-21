<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classe;

use Auth;
use Illuminate\Http\Request;
use App\Models\Logger;
use App\Models\InfoCerficado;

// use 
class InfoCerficadoController extends Controller
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
        return view('admin.info-certificados.cadastrar.index', $response);

    }
    public function cadastrar(Request $request)
    {

        try {
            // dd($request);

                $response['id_classe'] = $request->id_classe;
                $classe=fh_classes()->find($request->id_classe);
                // dd(  $classe);
                if (!$this->tem_registro_cadastrar($response)) {
                    InfoCerficado::create($request->except(['_token', '_method']));
                } else {
                    return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Registro já existe para a '.$classe->vc_classe.'ª Classe']);

        
            }
            return redirect()->route('admin.documentos.infos_certificado')->with('feedback', ['type' => 'success', 'sms' => 'Informações cadastradas com sucesso']);

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
          

            InfoCerficado::where('slug', $slug)->update(
                $request->except(['_token', '_method'])
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
        $info_certificado  = fh_infos_certificado()->where('info_cerficados.slug', $slug)->first();
        if ($info_certificado ):
            // dd($info_certificado );
            $response['info_certificado'] = $info_certificado ;
        



            // dd(  $data['n_negativa'] );
            return view('admin.info-certificados.editar.index', $response);
        else:
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado']);


        endif;
    }

    public function tem_registro($request)
    {
        return fh_infos_certificado()->where($request->except(['_token', '_method']))->count();
    }
    public function tem_registro_cadastrar($request)
    {
        // dd(fh_infos_certificado()->where('info_cerficados.id_classe',$request['id_classe'])->count());
        return fh_infos_certificado()->where('info_cerficados.id_classe', $request['id_classe'])->count();
    }
    public function eliminar($slug)
    {


        $info_cerficados = fh_infos_certificado()->where('info_cerficados.slug', $slug)->first();
        if ($info_cerficados):
            // dd($info_cerficados);
            InfoCerficado::where('slug', $slug)->delete();
            $this->loggerData('Eliminou  Informações da ' . $info_cerficados->vc_classe . 'ª Classe');
            return redirect()->back()->with('feedback', ['status' => '1', 'sms' => 'Registro eliminado com sucesso']);
        else:
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado']);


        endif;


    }

    public function index()
    {
        $data['infos_certificado'] = fh_infos_certificado()->get();


        //  dd($data);
        return view('admin.info-certificados.index', $data);
    }
}