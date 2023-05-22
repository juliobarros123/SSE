<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Debito;
use App\Models\Mes;
use Illuminate\Support\Facades\Auth;

class DebitoController extends Controller
{
    public $debito;
    public function paginaListar(Debito $debito)
    {
        $this->debitos = $debito;
        $debitos=$this->debitos->listarDebitos();
        

        return view('admin.debitos.index', compact('debitos'));
    }
    public function loggerData($mensagem){
        $dados_Auth = Auth::user()->vc_primemiroNome.' '.Auth::user()->vc_apelido.' Com o nivel de '.Auth::user()->vc_tipoUtilizador.' ';
        $this->Logger->Log('info', $dados_Auth.$mensagem);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paginaCadastrar()
    {
        $meses=Mes::all();
        return view('admin.debitos.cadastrar.index',compact('meses'));
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
            //*$dados = $request->all();
            //dd($dados);

           /* Validator::make($dados, [ //vc_debitoFuncionario,vc_bI,vc_genero,vc_funcao
                'vc_debito' => ['required', 'string', 'min:3'],
            ])->validate();
            Debitos::create($dados);*/
            Debito::create([
                'it_id_mes'=>$request->it_id_mes,
                'dc_valor'=>$request->dc_valor,
                'vc_debito'=>$request->vc_debito,
                'vc_descricao'=>$request->vc_descricao,
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
        if ($debito = Debito::find($id)) :
            //$this->dados = Debito::find($id);
            //$dados = $this->dados;
            $mes=Mes::find($debito->it_id_mes);
            $meses=Mes::all();
            $dados['meses']=$meses;
            $dados['mes']=$mes;
            $dados['debito']=$debito;
            return  view('admin.debitos.editar.index', $dados);
        else :
            return redirect('admin.debitos.index')->with('teste', '1');

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

        Debito::find($id)->update([
            'it_id_mes'=>$request->it_id_mes,
            'dc_valor'=>$request->dc_valor,
            'vc_debito'=>$request->vc_debito,
            'vc_descricao'=>$request->vc_descricao,
            'ya_ano'=>$request->ya_ano
            
        ]);
        return redirect()->route('listarDebito')->with('status', '1');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function eliminar($id)
    {
        Debito::find($id)->delete();
        return redirect()->back();
    }
}
