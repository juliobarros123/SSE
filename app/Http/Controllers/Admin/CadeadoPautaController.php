<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\CadeadoPauta;
use Illuminate\Http\Request;
use App\Models\CandeadoPauta;
use App\Models\Curso;
use App\Models\Classe;
use App\Models\CadeadoGeralPauta;
use Illuminate\Support\Facades\Auth;
use App\Models\Logger;

class CadeadoPautaController extends Controller
{
    //
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
        $response['cadeados'] = cadeados_pauta()->get();
        return view('admin.cadeado-pauta.index', $response);
    }
    public function mudar_estado($estado)
    {
        CadeadoPauta::where('id_cabecalho', Auth()->User()->id_cabecalho)->update(['estado' => $estado]);
        return redirect()->back()->with('feedback', ['type' => 'success', 'sms' => 'Estado mudado com sucesso']);



    }
    public function criar()
    {
        $response['cursos'] = Curso::where([['it_estado_curso', 1]])->get();

        $response['classes'] = Classe::where([['it_estado_classe', 1]])->get();


        return view('admin.cadiado-pauta.criar.index', $response);
    }
    public function cadastrar(Request $request)
    {
        CandeadoPauta::create($request->all());
        $this->loggerData("Cadastrou cadeado de pauta");
        return redirect()->back()->with('status', '1');
    }
    public function eliminar($id)
    {

        CandeadoPauta::find($id)->delete();
        $this->loggerData("Eliminou cadeado de pauta");
        return redirect('cadeado-pautas')->with('delete', '1');
    }
    public function editar($id)
    {
        $response['cadeado'] = CandeadoPauta::join('classes', 'candeado_pautas.it_classe', '=', 'classes.id')
            ->join('cursos', 'candeado_pautas.it_curso', '=', 'cursos.id')
            ->where('candeado_pautas.id', $id)
            ->select('candeado_pautas.*', 'classes.vc_classe', 'cursos.vc_shortName')->first();
        return view('admin.cadiado-pauta.editar.index', $response);
    }
    public function actualizar(Request $request, $id)
    {
        CandeadoPauta::find($id)->update(
            $request->all()
        );
        $this->loggerData("Actualizou cadeado de pauta");
        return redirect('cadeado-pautas')->with('actualizado', '1');
    }
    public function resultado()
    {
        $response['cadeados'] = CadeadoGeralPauta::all();
        return view('admin.cadiado-pauta.resultado.index', $response);
    }
    public function resultadoMudarEstado($id, $estado)
    {

        CadeadoGeralPauta::find($id)->update(
            ['it_estado_activacao' => $estado]
        );
        return redirect('cadeado-pautas/resultado')->with('actualizado', '1');
    }
    public function mudar_estado_cadeado($id, $estado)
    {
        CandeadoPauta::find($id)->update(
            ['it_estado_activacao' => $estado]
        );
        return response()->json($estado);
    }
}