<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Processo;
use App\Models\Logger;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
class ProcessoController extends Controller
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

        $processos = Processo::all();
        return view('admin/processos/index/index', compact('processos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin/processos/create/index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $storeData = $request->validate([
            'it_processo' => 'required'

        ]);

        //$processos = Processo::where('vc_nomeProcesso', '=',  $request->vc_nomeProcesso)->first();
        //if($processos === null){
        try {
            $show = Processo::create($storeData);
            $this->loggerData('Adicionou o Processo '.$request->it_processo);
        }
        //}else{
        catch (QueryException $th) {
            return redirect()->back()->with('id_aluno', '1');
        }

        //}
        //$this->Logger->Log('info', 'Adicionou Um Processo');
        return redirect('Admin/processos/index/index')->with('processoCadastrado', '1');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Processo  $processo
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $processo = Processo::where([['it_estado_processo', 1]])->get();
        return view('admin/processos/show/index', compact('id_aluno'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Processo  $processo
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
        if ($processo = Processo::where([['it_estado_processo', 1]])->find($id)) :

            return view('admin/processos/edit/index', compact('id_aluno'));
        else :
            return redirect('admin/processos/create/index')->with('id_aluno', '1');

        endif;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Processo  $processo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $updateData = $request->validate([
            'it_processo' => 'required',
            'it_estado_processo' => 'required'
        ]);
        
        try {
            Processo::whereId($id)->update($updateData);
            $this->loggerData('Actualizou o Processo '.$request->it_processo.' para o estado '.$request->it_estado_processo);
        } catch (QueryException $th) {
            return redirect()->back()->with('id_aluno', '1');
        }

        return redirect('Admin/processos/index/index')->with('processoUP', '1');;
    }


    public function selecionar()
    {
        $response['processos'] = Processo::where([['it_estado_processo', 1]])->get();
        return view('Admin/processos_classes/create/index', $response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Processo  $processo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //$processo = Processo::findOrFail($id);
        //$processo->delete();
        $response = Processo::find($id);
        $response->delete();
        $this->loggerData('Eliminou o Processo '.$response->it_processo);
        return redirect('Admin/processos/index/index')->with('processoEliminado', '1');
    }
}