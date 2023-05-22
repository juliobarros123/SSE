<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activador_da_candidatura;
use Illuminate\Http\Request;
use App\Models\Logger;
use Illuminate\Support\Facades\Auth;


class ActivadordaCandidaturaController extends Controller
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
        //
        $activadores = Activador_da_candidatura::all();
        return view('admin.activador.index', compact('activadores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.activador.cadastrar.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        try {

            Activador_da_candidatura::create([
                'it_estado' => $request->it_estado,
            ]);
            $this->loggerData("adicionou Activador candidatura");
            return redirect('/admin/activador')->with('status', '1');
        } catch (\Exception $exception) {
            return redirect()->back()->with('aviso', '1');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $activador = Activador_da_candidatura::find($id);
        return view('admin.activador.visualizar.index', compact('activador'));
  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
   
        $c = Activador_da_candidatura::find($id);
        if($response['activador'] = Activador_da_candidatura::find($id)):
        $activador = Activador_da_candidatura::find($id);
       
        return view('admin.activador.editar.index', compact('activador'));
     
    else:
         return redirect('/admin/activador/cadastrar')->with('Activador', 'Activador Inexistente');
       
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
        //
        try{
        Activador_da_candidatura::find($id)->update([
            'it_estado' => $request->it_estado,
        ]);
        $this->loggerData("Actualizou o Activador candidatura");
        return redirect()->route('admin/activador')->with('status', '1');
         } catch(\Exception $exception)
        {
        return redirect()->back()->with('aviso', '1');
         }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Activador_da_candidatura::find($id)->delete();
        $this->loggerData("Eliminou o Activador candidatura");
        return redirect()->route('admin/activador');
    }
}
