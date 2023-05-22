<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnoLectivo;
use Illuminate\Http\Request;
use App\Models\Logger;
use Illuminate\Support\Facades\Auth;

class AnoLectivoController extends Controller
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

        $anoslectivos = AnoLectivo::where([['it_estado_anoLectivo', 1]])->get();
        return view('admin.anolectivo.index', compact('anoslectivos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.anolectivo.cadastrar.index');
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


            if ($request->ya_inicio > $request->ya_fim) {
                return redirect()->back()->with('aviso', '1');
            } else {

                AnoLectivo::create([
                    'ya_inicio' => $request->ya_inicio,
                    'ya_fim' => $request->ya_fim
                ]);
                $this->loggerData("Adicionou Ano Lectivo ".$request->ya_inicio.' '.$request->ya_fim);
                return redirect('/admin/anolectivo')->with('status', '1');
            }
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
        //$anolectivo = AnoLectivo::where([['it_estado_anoLectivo', 1]])->get();
        $anolectivo = AnoLectivo::find($id);
        
        return view('admin.anolectivo.visualizar.index', compact('anolectivo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ($anolectivo = AnoLectivo::where([['it_estado_anoLectivo', 1]])->find($id)) :
            return view('admin.anolectivo.editar.index', compact('anolectivo'));
        else :
            return redirect('/admin/anolectivo/cadastrar')->with('ano', '1');

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
        AnoLectivo::find($id)->update([
            'ya_inicio' => $request->ya_inicio,
            'ya_fim' => $request->ya_fim
        ]);
        $this->loggerData("Actualizou Ano Lectivo ".$request->ya_inicio.' '.$request->ya_fim);
        return redirect()->route('admin/anolectivo');
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
        // AnoLectivo::find($id)->delete();
       
        try {
            
            $response = AnoLectivo::find($id);
            $response->update(['it_estado_anoLectivo' => 0]);
            $this->loggerData("Eliminou Ano Lectivo ".$response->ya_inicio.' '.$response->ya_fim);
            return redirect()->back()->with('anolectivo.eliminar.success', '1');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('anolectivo.eliminar.error', '1');
        }
    }


    public function purgar($id)
    {
        try {
            
            $response = AnoLectivo::find($id);
            $response2 = AnoLectivo::find($id)->delete();
            $this->loggerData("Purgou Ano Lectivo ".$response->ya_inicio.' '.$response->ya_fim);
            return redirect()->back()->with('anolectivo.purgar.success', '1');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('anolectivo.purgar.error', '1');
        }
    }

    public function eliminadas()
    {


        $response['anoslectivos'] = AnoLectivo::where([['it_estado_anoLectivo', 0]])->get();
        $response['eliminadas']="eliminadas";
        return view('admin.anolectivo.index',  $response);
    }

    public function recuperar($id)
    {
        try {
            
            $response = AnoLectivo::find($id);
            $response->update(['it_estado_anoLectivo' => 1]);
            $this->loggerData("Recuperou Ano Lectivo ".$response->ya_inicio.' '.$response->ya_fim);
            return redirect()->back()->with('anolectivo.recuperar.success', '1');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('anolectivo.recuperar.error', '1');
        }
    }
}
