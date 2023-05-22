<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Municipio;
use App\Models\Provincia;
use Illuminate\Http\Request;
use App\Models\Logger;
use Illuminate\Support\Facades\Auth;

class MunicipioController extends Controller
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

        $municipios = Municipio::join('provincias','municipios.it_id_provincia','provincias.id')->select('provincias.vc_nome as vc_nomeProvincia','municipios.*')->where([['it_estado_municipio', 1]])->get();
        return view('admin.municipio.index', compact('municipios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $dados['provincias'] = Provincia::where([['it_estado_provincia', 1]])->get();
        return view('admin.municipio.cadastrar.index',$dados);
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
                Municipio::create([
                    'vc_nome' => $request->vc_nome,
                    'it_id_provincia' => $request->it_id_provincia,
                    
                ]);
                $this->loggerData("Adicionou o municipio ".$request->vc_nome);

                return redirect()->route('admin.municipio')->with('municipio.cadastrar.success', 1);
            
        } catch (\Exception $exception) {
            return redirect()->back()->with('municipio.cadastrar.error', 1);
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
        //$Municipio = Municipio::where([['it_estado_municipio', 1]])->get();
        $municipio = Municipio::join('provincias','municipios.it_id_provincia','provincias.id')->select('provincias.vc_nome as vc_nomeProvincia','municipios.*')->find($id);
        
        return view('admin.municipio.visualizar.index', compact('municipio'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ($dados['municipio'] = Municipio::join('provincias','municipios.it_id_provincia','provincias.id')->select('provincias.vc_nome as vc_nomeProvincia','municipios.*')->where([['it_estado_municipio', 1]])->find($id)) :
            $dados['provincias'] = Provincia::where([['it_estado_provincia', 1]])->get();
            return view('admin.municipio.editar.index', $dados);
        else :
            return redirect('admin.municipio.cadastrar')->with('Municipio', '1');

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
            
            Municipio::find($id)->update([
                'vc_nome' => $request->vc_nome,
                'it_id_provincia' => $request->it_id_provincia,
                
            ]);
            $this->loggerData("Actualizou o municipio ".$request->vc_nome);
            return redirect()->route('admin.municipio')->with('municipio.actualizar.success',1);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('municipio.actualizar.error',1);
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
        // Municipio::find($id)->delete();
      try {
        
        $response = Municipio::find($id);
        $response->update(['it_estado_municipio' => 0]);
        $this->loggerData("Eliminou o municipio ".$response->vc_nome);
        return redirect()->route('admin.municipio')->with('municipio.eliminar.success',1);
      } catch (\Throwable $th) {
        //throw $th;
        return redirect()->back()->with('municipio.eliminar.error',1);
      }
    }


    public function purgar($id)
    {
        try {
         
            $response = Municipio::find($id);
            $response2 = Municipio::find($id)->delete();
            $this->loggerData("Purgou o municipio ".$response->vc_nome);
            return redirect()->back()->with('municipio.purgar.success', '1');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('municipio.purgar.error', '1');
        }
    }

    public function eliminadas()
    {
      

        $response['municipios'] =Municipio::join('provincias','municipios.it_id_provincia','provincias.id')->select('provincias.vc_nome as vc_nomeProvincia','municipios.*')->where([['it_estado_municipio', 0]])->get();
        $response['eliminadas']="eliminadas";
        return view('admin.municipio.index',  $response);
    }

    public function recuperar($id)
    {
        try {
        
            $response = Municipio::find($id);
            $response->update(['it_estado_municipio' => 1]);
            $this->loggerData("Recuperou o Municipio ".$response->vc_nome);
            return redirect()->route('admin.municipio')->with('municipio.recuperar.success',1);
          } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('municipio.recuperar.error',1);
          }
    }
}
