<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PermissaoDeSelecao;
use App\Models\Logger;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
class PermissaoDeSelecaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $Logger;
    public function __construct()
    {
        $this->Logger = new Logger();
    }
    public function loggerData($mensagem){
        $dados_Auth = Auth::user()->vc_primemiroNome.' '.Auth::user()->vc_apelido.' Com o nivel de '.Auth::user()->vc_tipoUtilizador.' ';
        $this->Logger->Log('info', $dados_Auth.$mensagem);
    }

    public function index()
    {

        $dados = PermissaoDeSelecao::all();
        return view('admin/permissao_selecao/index', compact('dados'));
    }
    public function criar()
    {

        return view('admin.permissao_selecao.cadastrar.index');
    }

    public function cadastrar(Request $request)
    {
        PermissaoDeSelecao::create($request->all());
    
        return redirect()->back()->with('status', '1');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PermissaoDeSelecao  $processo
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dados = PermissaoDeSelecao::find($id);
        return view('admin.permissao_selecao.show.index', compact('dado'));
    }

    public function edit($id)
    {
  
        if ($dado = PermissaoDeSelecao::find($id)) :

            return view('admin.permissao_selecao.editar.index', compact('dado'));
        else :
            return redirect('admin.permissao_selecao.cadastrar.index')->with('dado', '1');

        endif;
    }

    public function update(Request $request, $id)
    {
  

        $updateData = $request->validate([
            'nota' => 'required',
            'dt_nascimento' => 'required'
        ]);
        try {
        
            PermissaoDeSelecao::whereId($id)->update($updateData);
            $this->loggerData('Actualizau o Permissão de seleção com  a nota de '.$request->nota.' e a data de nascimento '.$request->dt_nascimento);
        } catch (QueryException $th) {
            dd("ola");
            return redirect()->back()->with('update', '1');
        }

        return redirect('admin/permissao_selecao/index/index')->with('update', '1');
    }

    public function destroy($id)
    {
        $response = PermissaoDeSelecao::find($id);
        $response->delete();
        $this->loggerData('Eliminou a Permissão de Seleção de numero ',$id);
        return redirect('admin/permissao_selecao/index/index')->with('eliminar', '1');
    }
}