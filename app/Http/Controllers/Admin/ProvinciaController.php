<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Provincia;
use Illuminate\Http\Request;
use App\Models\Logger;
use Illuminate\Support\Facades\Auth;

class ProvinciaController extends Controller
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

        $provincias = Provincia::where([['it_estado_provincia', 1]])->get();
        return view('admin.provincia.index', compact('provincias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.provincia.cadastrar.index');
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
                Provincia::create([
                    'vc_nome' => $request->vc_nome,
                    
                ]);
                $this->loggerData("Adicionou a província ".$request->vc_nome);

                return redirect()->route('admin.provincia')->with('provincia.cadastrar.success', 1);
            
        } catch (\Exception $exception) {
            return redirect()->back()->with('provincia.cadastrar.error', 1);
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
        //$provincia = Provincia::where([['it_estado_provincia', 1]])->get();
        $provincia = Provincia::find($id);
        
        return view('admin.provincia.visualizar.index', compact('provincia'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ($provincia = Provincia::where([['it_estado_provincia', 1]])->find($id)) :
            return view('admin.provincia.editar.index', compact('provincia'));
        else :
            return redirect('admin.provincia.cadastrar')->with('provincia', '1');

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
        try {
            
            Provincia::find($id)->update([
                'vc_nome' => $request->vc_nome,
                
            ]);
            $this->loggerData("Actualizou a província ".$request->vc_nome);
            return redirect()->route('admin.provincia')->with('provincia.actualizar.success',1);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('provincia.actualizar.error',1);
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
        // Provincia::find($id)->delete();
      try {
        
        $response = Provincia::find($id);
        Provincia::find($id)->delete();
        $this->loggerData("Eliminou a província ".$response->vc_nome);
        return redirect()->route('admin.provincia')->with('provincia.eliminar.success',1);
      } catch (\Throwable $th) {
        //throw $th;
        return redirect()->back()->with('provincia.eliminar.error',1);
      }
    }


    public function purgar($id)
    {
        try {
         
            $response = Provincia::find($id);
            $response2 = Provincia::find($id)->delete();
            $this->loggerData("Purgou a Província");
            return redirect()->back()->with('provincia.purgar.success', '1');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('provincia.purgar.error', '1');
        }
    }

    public function eliminadas()
    {
      

        $response['provincias'] =Provincia::where([['it_estado_provincia', 0]])->get();
        $response['eliminadas']="eliminadas";
        return view('admin.provincia.index',  $response);
    }

    public function recuperar($id)
    {
        try {
        
            $response = Provincia::find($id);
            $response->update(['it_estado_provincia' => 1]);
            $this->loggerData("Recuperou a província ".$response->vc_nome);
            return redirect()->route('admin.provincia')->with('provincia.recuperar.success',1);
          } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('provincia.recuperar.error',1);
          }
    }
}
