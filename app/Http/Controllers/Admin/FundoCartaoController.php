<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FundoCartao;

use function GuzzleHttp\Promise\all;
use App\Models\Logger;

class FundoCartaoController extends Controller
{
    //
    private $Logger;
    public function __construct()
    {
        $this->Logger = new Logger();

    }

    public function loggerData($mensagem)
    {

        $request_Auth = Auth::user()->vc_primemiroNome . ' ' . Auth::user()->vc_apelido . ' Com o nivel de ' . Auth::user()->vc_tipoUtilizador . ' ';
        $this->Logger->Log('info', $request_Auth . $mensagem);
    }
    public function index()
    {
        // dd("o");
        $response['fundos_cartoes'] = fh_fundos_cartoes()->get();
        return view('admin.fundo-cartao.index', $response);
    }
    public function criar()
    {

        return view('admin.fundo-cartao.criar.index');
    }
    public function cadastrar(Request $request)
    {
        // dd( $request);

        $path = upload_img_sem_storage($request, 'fundo', 'images/fundos_cartoes');
        $request = $request->all();
        $request['fundo'] = $path;

        FundoCartao::create($request);
        return redirect()->route('admin.fundos_cartoes')->with('feedback', ['type' => 'success', 'sms' => 'Fundo cadastrado com sucesso!']);


    }
    public function editar($slug)
    {

        $response['fundo_cartao'] = fh_fundos_cartoes()->where('fundo_cartaos.slug', $slug)->first();

        if ($response['fundo_cartao']):
            return view('admin.fundo-cartao.editar.index', $response);

        else:
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado']);



        endif;
    }
    public function actualizar(Request $request, $slug)
    {
        $path = upload_img_sem_storage($request, 'fundo', 'images/fundos_cartoes');
        $request = $request->except(['_token','_method']);
        if ($path) {
            $request['fundo'] = $path;
        }
        FundoCartao::where('fundo_cartaos.slug', $slug)->update($request);
        return redirect()->route('admin.fundos_cartoes')->with('feedback', ['type' => 'success', 'sms' => 'Fundo actualizado com sucesso!']);



    }
    public function eliminar($slug)
    {
        $response['fundo_cartao'] = fh_fundos_cartoes()->where('fundo_cartaos.slug', $slug)->first();
        if ($response['fundo_cartao']) {
            // dd(     $response['fundo_cartao']);
            FundoCartao::where('fundo_cartaos.slug', $slug)->delete();
            return redirect()->back()->with('feedback', ['type' => 'success', 'sms' => 'Fundo eliminado com sucesso!']);

        } else {
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Fundo já existe!']);



        }
    }







    //
}