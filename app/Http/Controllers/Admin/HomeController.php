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
use App\Models\Candidato2;
use App\Models\AnoLectivo;
use App\Models\Cabecalho;
use App\Models\Candidatura;
use App\Models\IdadedeCandidatura;
use App\Models\Matricula;
use App\Models\Turma;
use App\Models\PermissaoNota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Logger;
use Illuminate\Support\Facades\Auth;
use App\Models\AnoLectivoPublicado;

class HomeController extends Controller
{
    private $Logger;
    public function __construct()
    {
        $this->middleware('auth');
        $this->Logger = new Logger();
    }
    public function loggerData($mensagem)
    {
        $dados_Auth = Auth::user()->vc_primemiroNome . ' ' . Auth::user()->vc_apelido . ' Com o nivel de ' . Auth::user()->vc_tipoUtilizador . ' ';
        $this->Logger->Log('info', $dados_Auth . $mensagem);
    }

    public function raiz()
    {
     
        // dd('2022-08-18');
        if (Auth::user()->vc_tipoUtilizador == 'Candidato') {
            // dd("ol");
            return redirect('candidatura');
        }
        if (Auth::user()->vc_tipoUtilizador == 'Estudante') {
            return redirect()->route('painel.alunos');
        }
        //  dd(consultarRupePreCandidato_v3(13331780226));
        // $s=consultarRupe(22);
        // dd(isset($s["idOrigem"]));
        $response['cabecalho'] = fh_cabecalho()->get();
        $anolectivo = fha_ano_lectivo_publicado();
        if ($anolectivo) {
            $response['ano_lectivo'] = $anolectivo;
            // dd(   $response['ano_lectivo']);
            $data = $response['ano_lectivo']->ya_inicio . "-" . $response['ano_lectivo']->ya_fim;
            // dd($data);
            $response['AnoLectivo'] = $data;




            $response['candidaturas'] = fh_candidatos()->where('candidatos.id_ano_lectivo', $response['ano_lectivo']->id_anoLectivo)->count();
            $response['matriculas'] = Matricula::count();
            $response['idadedecandidatura'] = 0;


            /* Gráficos */
            $response['Anosgraficos'] = AnoLectivo::orderby('id', 'asc')->get();
            $response['Cursosgraficos'] = 0;

            /* ./Gráficos */

        } else {
            $response[''] = null;
        }



        return view('admin.index', $response);
    }
}