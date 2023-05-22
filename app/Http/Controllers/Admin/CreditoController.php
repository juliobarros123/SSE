<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Credito;
use App\Models\Mes;
use Illuminate\Support\Facades\Auth;

class CreditoController extends Controller
{
    public $creditos;
    public function loggerData($mensagem){
        $dados_Auth = Auth::user()->vc_primemiroNome.' '.Auth::user()->vc_apelido.' Com o nivel de '.Auth::user()->vc_tipoUtilizador.' ';
        $this->Logger->Log('info', $dados_Auth.$mensagem);
    }
    public function paginaListar(Credito $credito)
    {
        $this->creditos=$credito;
        $creditos = $this->creditos->listarCreditos();
        //listarCreditos

        return view('admin.creditos.index', compact('creditos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paginaCadastrar()
    {
        $meses=Mes::all();
        return view('admin.creditos.cadastrar.index',compact('meses'));
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
           /* $dados = $request->all();
            //dd($dados);

            Validator::make($dados, [ //vc_nomeFuncionario,vc_bI,vc_genero,vc_funcao
                'vc_nome' => ['required', 'string', 'min:3'],
            ])->validate();
            Creditos::create($dados);*/

            Credito::create([
                'it_id_mes'=>$request->it_id_mes,
                'dc_valor'=>$request->dc_valor,
                'vc_credito'=>$request->vc_credito,
                //'vc_descricao'=>$request->vc_descricao,
                'ya_ano'=>$request->ya_ano
            ]);
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
        if ($credito = Credito::find($id)) :
            $mes=Mes::find($credito->it_id_mes);
            $meses=Mes::all();
            $dados['meses']=$meses;
            $dados['mes']=$mes;
            $dados['credito']=$credito;
            //$this->dados = Credito::find($id);
            //$dados = $this->dados;
            return  view('admin.creditos.editar.index', $dados);
        else :
            return redirect('admin.creditos.index')->with('teste', '1');

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

        Credito::find($id)->update([
            'it_id_mes'=>$request->it_id_mes,
            'dc_valor'=>$request->dc_valor,
            'vc_credito'=>$request->vc_credito,
            //'vc_descricao'=>$request->vc_descricao,
            'ya_ano'=>$request->ya_ano
        ]);
        return redirect()->route('listarCredito')->with('status', '1');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function eliminar($id)
    {
        Credito::find($id)->delete();
        return redirect()->back();
    }
}
