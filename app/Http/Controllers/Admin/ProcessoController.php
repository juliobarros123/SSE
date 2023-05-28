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
    public function loggerData($mensagem)
    {
        $dados_Auth = Auth::user()->vc_primemiroNome . ' ' . Auth::user()->vc_apelido . ' Com o nivel de ' . Auth::user()->vc_tipoUtilizador . ' ';
        $this->Logger->Log('info', $dados_Auth . $mensagem);
    }
    public function index()
    {

        $processos = fh_processo_actual()->get();
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
        // $storeData = $request->validate([
        //     'it_processo' => 'required'

        // ]);

        //$processos = Processo::where('vc_nomeProcesso', '=',  $request->vc_nomeProcesso)->first();
        //if($processos === null){
        try {
            // dd($request);
            $processo = fh_processo_actual()->count();
            if ($processo) {
                return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Já existe um processo actual']);

            } else {
                Processo::create([
                    'id_cabecalho' => Auth::User()->id_cabecalho,
                    'it_processo' => $request->it_processo
                ]);
                return redirect()->back()->with('feedback', ['type' => 'success', 'sms' => 'Processo cadastrado com sucesso']);

            }
            // $show = Processo::create($storeData);
            // $this->loggerData('Adicionou o Processo '.$request->it_processo);
        }
        //}else{
        catch (QueryException $th) {
            // dd($th);
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado']);

        }


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
    public function edit($slug)
    {
        $processo = fh_processo_actual()->where('processos.slug', $slug)->first();
        if ($processo):

            return view('admin/processos/edit/index', compact('processo'));
        else:
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado']);


        endif;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Processo  $processo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {

      

        try {
        fh_processo_actual()->where('processos.slug',$slug)->update( $request->except(['_token','_method']));
            $this->loggerData('Actualizou o Processo actual para ' . $request->it_processo);
            return redirect()->back()->with('feedback', ['type' => 'success', 'sms' => 'Processo actualizado com sucesso']);
        
        } catch (QueryException $th) {
            // dd($th->getMessage());
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado']);
            
        }

      
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
  
}