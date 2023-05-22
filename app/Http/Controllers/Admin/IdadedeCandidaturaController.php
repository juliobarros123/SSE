<?php
/* Este sistema esta protegido pelos direitos autoriais do Instituto de Telecomunicações criado ao
 abrigo do decreto executivo conjunto nº29/85 de 29 de Abril,
 dos Ministérios da Educação e dos Transportes e Comunicações,
publicado no Diário da República, 1ª série nº 35/85, nos termos
 do artigo 62º da Lei Constitucional.

contactos:
site:www.itel.gov.ao
Telefone I: +244 931 313 333
Telefone II: +244 997 788 768
Telefone III: +244 222 381 640
Email I: secretariaitel@hotmail.com
Email II: geral@itel.gov.ao*/

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnoLectivo;
use App\Models\IdadedeCandidatura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Logger;
use Illuminate\Support\Facades\Auth;

class IdadedeCandidaturaController extends Controller
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
        $idadesdecandidaturas = IdadedeCandidatura::get();
        return view('admin.idadedecandidatura.visualizar.index', compact('idadesdecandidaturas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $anoslectivos = AnoLectivo::where([['it_estado_anoLectivo', 1]])->get();
        return view('admin.idadedecandidatura.cadastrar.index', compact('anoslectivos'));
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

        if ($request->dt_limitemaxima >= $request->dt_limiteaesquerda) {
            return redirect()->back()->with('aviso', '1');
        } else {
            $response = IdadedeCandidatura::create([
                'dt_limiteaesquerda' => $request->dt_limiteaesquerda,
                'dt_limitemaxima' => $request->dt_limitemaxima,
                'vc_anolectivo' => $request->vc_anolectivo
            ]);
            if ($response) {
                $this->loggerData('adicionou idade de candidatura');
                return redirect('/admin/idadedecandidatura')->with('status', '1');;
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ($response['idadedecandidatura'] = IdadedeCandidatura::where([['it_estado_idadedecandidatura', 1]])->find($id)) :
            /*      $response['idadedecandidatura'] = IdadedeCandidatura::find($id); */
            $response['anoslectivos'] = AnoLectivo::where([['it_estado_anoLectivo', 1]])->get();
            return view('admin.idadedecandidatura.editar.index', $response);
        else :
            return redirect('/admin/idadedecandidatura/cadastrar')->with('idade', '1');

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
        IdadedeCandidatura::find($id)->update([
            'dt_limiteaesquerda' => $request->dt_limiteaesquerda,
            'dt_limitemaxima' => $request->dt_limitemaxima,
            'vc_anolectivo' => $request->vc_anolectivo
        ]);
        $this->loggerData('Editou idade de candidatura de id '.$id);
        return redirect()->route('admin/idadedecandidatura');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        //IdadedeCandidatura::find($id)->delete();
        $response = IdadedeCandidatura::find($id)->delete();

        $this->loggerData('Eliminou idade de candidatura de id '.$id);
        return redirect()->route('admin/idadedecandidatura');
    }
}
