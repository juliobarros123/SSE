<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Servicos;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
class ServicoController extends Controller
{
    public function loggerData($mensagem){
        $dados_Auth = Auth::user()->vc_primemiroNome.' '.Auth::user()->vc_apelido.' Com o nivel de '.Auth::user()->vc_tipoUtilizador.' ';
        $this->Logger->Log('info', $dados_Auth.$mensagem);
    }
    public function paginaListar()
    {
        $dados = Servicos::all();

        return view('admin.servicos.index', compact('dados'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paginaCadastrar()
    {
        return view('admin.servicos.cadastrar.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function cadastrar(Request $request)
    {

        
        try {
            $dados = $request->all();
            //dd($dados);

            Validator::make($dados, [ //vc_nomeFuncionario,vc_bI,vc_genero,vc_funcao
                'vc_nome' => ['required', 'string', 'min:3'],
            ])->validate();
            Servicos::create($dados);
            return redirect()->back()->with('status', '1');
        } catch (\Throwable $th) {
            return redirect()->back()->with('aviso', '1');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function paginaVer($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function paginaEditar($id)
    {
        if ($response['curso'] = Servicos::find($id)) :
            $this->dados = Servicos::find($id);
            $dados = $this->dados;
            return  view('admin.servicos.editar.index', compact('dados'));
        else :
            return redirect('admin.servicos.index')->with('teste', '1');

        endif;
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
        $dados[]=$request;

        Servicos::find($id)->update([
            'vc_nome'=>$request->input('vc_nome'),
        ]);
        return redirect()->route('listarServico')->with('status', '1');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function eliminar($id)
    {
        Servicos::find($id)->delete();
        return redirect()->back();
    }
}
