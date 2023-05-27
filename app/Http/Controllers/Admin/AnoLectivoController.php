<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnoLectivo;
use App\Models\AnoLectivoPublicado;
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
    public function loggerData($mensagem)
    {
        $dados_Auth = Auth::user()->vc_primemiroNome . ' ' . Auth::user()->vc_apelido . ' Com o nivel de ' . Auth::user()->vc_tipoUtilizador . ' ';
        $this->Logger->Log('info', $dados_Auth . $mensagem);
    }
    public function index()
    {

        $anoslectivos = fh_anos_lectivos()->get();
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

                return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ano de inicio não pode ser maoir que o ano de fim']);

            } else {
                // dd("ol");
                $ano_lectivo = AnoLectivo::create([
                    'ya_inicio' => $request->ya_inicio,
                    'ya_fim' => $request->ya_fim,
                    'id_cabecalho' => Auth::User()->id_cabecalho
                ]);
                if (AnoLectivo::count() == 1) {

                    AnoLectivoPublicado::create(
                        [
                            'id_anoLectivo' => $ano_lectivo->id,
                            'ya_inicio' => $ano_lectivo->ya_inicio,
                            'ya_fim' => $ano_lectivo->ya_fim,
                            'id_cabecalho' => Auth::User()->id_cabecalho
                        ]
                    );
                }
                $this->loggerData("Adicionou Ano Lectivo " . $request->ya_inicio . ' ' . $request->ya_fim);
                return redirect('/admin/anolectivo')->with('status', '1');
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado, verifica os dados se estão corretos']);

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
    public function edit($slug)
    {
        $anolectivo = fh_anos_lectivos()->where('anoslectivos.slug', $slug)->first();
        if ($anolectivo):
            return view('admin.anolectivo.editar.index', compact('anolectivo'));
        else:
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado, verifica os dados se estão corretos']);


        endif;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        //
        if ($request->ya_inicio > $request->ya_fim) {

            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ano de inicio não pode ser maoir que o ano de fim']);

        } else {
            AnoLectivo::where('anoslectivos.slug', $slug)->update([
                'ya_inicio' => $request->ya_inicio,
                'ya_fim' => $request->ya_fim
            ]);
            $this->loggerData("Actualizou Ano Lectivo " . $request->ya_inicio . ' ' . $request->ya_fim);
            return redirect()->route('admin/anolectivo')->with('feedback', ['type' => 'success', 'sms' => 'Ano lectivo actualizado com sucesso']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        // dd($slug);  
        //
        // AnoLectivo::find($id)->delete();

        try {
            if (fh_anos_lectivos()->count()) {
                $ano_lectivo_maior = $this->ano_lectivo_maior();
                $response = fh_anos_lectivos()->where('anoslectivos.slug', $slug)->first();
                if ($response->ya_fim == $ano_lectivo_maior->ya_fim) {
                    return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Não podes eliminar o último ano lectivo']);
                }
                if(fha_ano_lectivo_publicado()->id_anoLectivo==$response->id){
                    AnoLectivoPublicado::create(
                        [
                            'id_anoLectivo' => $ano_lectivo_maior->id,
                            'ya_inicio' => $ano_lectivo_maior->ya_inicio,
                            'ya_fim' => $ano_lectivo_maior->ya_fim,
                            'id_cabecalho' => Auth::User()->id_cabecalho
                        ]
                    );
                }
            //   dd("ola");
                fh_anos_lectivos()->where('anoslectivos.slug', $slug)->delete();
                ;
                $this->loggerData("Eliminou Ano Lectivo " . $response->ya_inicio . ' ' . $response->ya_fim);
                return redirect()->back()->with('anolectivo.eliminar.success', '1');
            } else {
                return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Não podes eliminar todos anos lectivos']);

            }
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('anolectivo.eliminar.error', '1');
        }
    }
    public function ano_lectivo_maior()
    {
        $ano_lectivo = fh_anos_lectivos()->orderBy('anoslectivos.ya_fim', 'desc')->first();
        return $ano_lectivo;
    }


    public function purgar($id)
    {
        try {

            $response = AnoLectivo::find($id);
            $response2 = AnoLectivo::find($id)->delete();
            $this->loggerData("Purgou Ano Lectivo " . $response->ya_inicio . ' ' . $response->ya_fim);
            return redirect()->back()->with('anolectivo.purgar.success', '1');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('anolectivo.purgar.error', '1');
        }
    }

    public function eliminadas()
    {


        $response['anoslectivos'] = AnoLectivo::where([['it_estado_anoLectivo', 0]])->get();
        $response['eliminadas'] = "eliminadas";
        return view('admin.anolectivo.index', $response);
    }

    public function recuperar($id)
    {
        try {

            $response = AnoLectivo::find($id);
            $response->update(['it_estado_anoLectivo' => 1]);
            $this->loggerData("Recuperou Ano Lectivo " . $response->ya_inicio . ' ' . $response->ya_fim);
            return redirect()->back()->with('anolectivo.recuperar.success', '1');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('anolectivo.recuperar.error', '1');
        }
    }
}