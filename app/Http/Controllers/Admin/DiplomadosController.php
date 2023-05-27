<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Diplomados;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Return_;
use App\Models\Logger;
use App\Models\Curso;
use App\Models\notaDiplomado;
use App\Models\Cabecalho;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Alunno;
use Exception;
use Illuminate\Support\Arr;
use Mpdf\Tag\Tr;

class DiplomadosController extends Controller
{
    private $Logger;
    public function __construct()
    {
        $this->Logger = new Logger();
    }

    public function Site()
    {
        $data['cursos'] = DB::table('cursos')->where("it_estado_curso", 1)->get();

        return view('site.diplomado', $data);
    }

    public function loggerData($mensagem)
    {
        $dados_Auth = Auth::user()->vc_primemiroNome . ' ' . Auth::user()->vc_apelido . ' Com o nivel de ' . Auth::user()->vc_tipoUtilizador . ' ';
        $this->Logger->Log('info', $dados_Auth . $mensagem);
    }
    public function cadastrar()
    {

        $cursos = DB::select('select * from cursos');
        return view('admin.diplomado.cadastrar.index', ['cursos' => $cursos]);
    }

    public function store(Request $request)
    {
        $diplomado[0] = $request->all();
        // dd($data['diplomado']);
        try {
            Diplomados::create($request->all());
            $this->loggerData('Adicionou Diplomado');
            return redirect()->route('admin.diplomados.listar')->with('status', '1');
        } catch (\Throwable $th) {

            $cursos = DB::select('select * from cursos');
            return view('admin.diplomado.cadastrar.index', ['cursos' => $cursos, 'diplomado' => $diplomado]);
        }
    }

    public function editar($id)
    {
        $data['cursos'] = DB::select('select * from cursos');
        $data['diplomado'] = DB::table('diplomados')->where('id', '=', $id)->get();

        return view('admin.diplomado.editar.index', $data);
    }

    public function listar()
    {
        $data['diplomados'] = DB::table('diplomados')->where([['it_estado', 1]])->get();

        return view('admin.diplomado.index', $data);
    }
    public function update($id, Request $request)
    {
        $data = $request->all();
        try {
            Diplomados::find($id)->update($request->all());
            $this->Logger->Log('info', 'Editou diplomado Diplomado');
            return redirect()->route('admin.diplomados.listar')->with('status', '1');
        } catch (\Throwable $th) {
            return redirect()->route('admin.diplomados.editar', $id);
        }
    }
    public function excluir($id)
    {
        $response = Diplomados::find($id);
        $response->update(['it_estado' => 0]);
        $this->Logger->Log('info', 'Eliminou diplomado Diplomado');
        return redirect()->route('admin.diplomados.listar')->with('status', '1');
    }

    public function visualizar($id)
    {
        $data['disciplinas'] = DB::table('nota_diplomados')
            ->join("disciplinas", "nota_diplomados.id_disciplina", "disciplinas.id")
            ->where("id_diplomado", "=", $id)
            ->select("disciplinas.*", "nota_diplomados.*")
            ->get();

        // dd($data);

        return view("admin.diplomado.visualizar.index", $data);
    }

    public function imprimir()
    {
        $data['cabecalho'] = Cabecalho::find(1);
      /*   $data["bootstrap"] = file_get_contents("css/listas/bootstrap.min.css");
        $data["css"] = file_get_contents("css/listas/style.css"); */


            if ($data['cabecalho']->vc_nif == "5000298182") {

                //$url = 'cartões/CorMarie/aluno.png';
                $data["css"] = file_get_contents('css/listas/style.css');
                $data["bootstrap"] = file_get_contents('css/listas/bootstrap.min.css');

            } else if ($data['cabecalho']->vc_nif == "7301002327") {

                //$url = 'cartões/InstitutoPolitécnicodoUIGE/aluno.png';
                $data["css"] = file_get_contents('css/listas/style.css');
                $data["bootstrap"] = file_get_contents('css/listas/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000303399") {

                //$url = 'cartões/negage/aluno.png';
                $data["css"] = file_get_contents('css/listas/style.css');
                $data["bootstrap"] = file_get_contents('css/listas/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000820440") {
            
                //$url = 'cartões/Quilumosso/aluno.png';
                $data["css"] = file_get_contents('css/listas/style.css');
                $data["bootstrap"] = file_get_contents('css/listas/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000305308") {

                //$url = 'cartões/Foguetao/aluno.png';
                $data["css"] = file_get_contents('css/listas/style.css');
                $data["bootstrap"] = file_get_contents('css/listas/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "7301002572") {

                //$url = 'cartões/LiceuUíge/aluno.png';
                $data["css"] = file_get_contents('css/listas/style.css');
                $data["bootstrap"] = file_get_contents('css/listas/bootstrap.min.css');
             } else if ($data['cabecalho']->vc_nif == "7301003617") {

                //$url = 'cartões/ldc/aluno.png';
                $data["css"] = file_get_contents('css/listas/style.css');
                $data["bootstrap"] = file_get_contents('css/listas/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000300926") {

                //$url = 'cartões/imagu/aluno.png';
                $data["css"] = file_get_contents('css/listas/style.css');
                $data["bootstrap"] = file_get_contents('css/listas/bootstrap.min.css');
            } else {
                //$url = 'images/cartao/aluno.jpg';
                $data["css"] = file_get_contents('css/listas/style.css');
                $data["bootstrap"] = file_get_contents('css/listas/bootstrap.min.css');
            }
            $mpdf = new \Mpdf\Mpdf([
                'mode' => 'utf-8', 'margin_top' => 0,
                'margin_left' => 5,
                'margin_right' => 0, 'margin_bottom' => 0, 'format' => [54, 84]
            ]);
        $data['diplomados'] = Diplomados::where([['it_estado', 1]])->orderby('it_id_aluno', 'asc')->get();
        $mpdf = new \Mpdf\Mpdf();

        $mpdf->SetFont("arial");
        $mpdf->setHeader();
        $this->Logger->Log('info', 'Imprimiu Lista dos Diplomados');
        $html = view("admin/pdfs/listas/diplomados/index", $data);
        $mpdf->writeHTML($html);
        $mpdf->Output("listasdDiplomados.pdf", "I");
    }
    public function diplomadoParaAluno()
    {
        $diplomados = Diplomados::all();
        $bisNaoEncontrados = [];
        
        foreach ($diplomados as  $diplomado) {

            $estado = $this->transferirDiplomadoAluno($diplomado->it_id_aluno);
            if ($estado != 'true') {
                array_push($bisNaoEncontrados, $estado);
            }
        }
       
        return redirect()->back()->with('transferidos',  $bisNaoEncontrados);
    }
    public function transferirDiplomadoAluno($processo)
    {
      
        $diplomado = Diplomados::where('it_id_aluno', $processo)->first();
        $linha = Alunno::find($diplomado->it_id_aluno);

        try {
    
            if (!$linha) {
                
                $response = Http::get("https://api.gov.ao/consultarBI/v2/?bi=$diplomado->vc_nBI");
                $response = $response->json();
                $curso = Curso::find($diplomado->id_curso)->vc_nomeCurso;
                $aluno = Alunno::create([
                    'id' => $diplomado->it_id_aluno,
                    'vc_primeiroNome' =>  $diplomado->vc_primeiroNome,
                    'vc_nomedoMeio' =>  $diplomado->vc_nomeMeio,
                    'vc_ultimoaNome' =>  $diplomado->vc_ultimoNome,
                    'it_classe' =>  13,
                    'dt_emissao' =>  $response[0]['ISSUE_DATE'],
                    'dt_dataNascimento' => $response[0]['BIRTH_DATE'],
                    'vc_naturalidade' =>  $response[0]['BIRTH_PROVINCE_NAME'],
                    'vc_provincia' =>  $response[0]['BIRTH_PROVINCE_NAME'],
                    'vc_namePai' => $response[0]['FATHER_FIRST_NAME'] . ' ' . $response[0]['FATHER_LAST_NAME'],
                    'vc_nameMae' =>  $response[0]['MOTHER_FIRST_NAME'] . ' ' . $response[0]['MOTHER_LAST_NAME'],
                    'vc_dificiencia' =>  '',
                    'vc_estadoCivil' =>  $response[0]['MOTHER_FIRST_NAME'],
                    'vc_genero' =>  $response[0]['GENDER_NAME'],
                    'it_telefone' =>  $diplomado->it_telefone,
                    'vc_email' => 'sem',
                    'foto' =>   isset($dados['foto']) ? $dados['foto'] : 'sem',
                    'vc_residencia' =>  $response[0]['RESIDENCE_ADDRESS'],
                    'vc_bi' =>  $response[0]['ID_NUMBER'],
                    'id' =>  $diplomado->it_id_aluno,
                    'vc_nomeCurso' =>   $curso,
                    'vc_anoLectivo' => (date('Y') - 1) . '-' . date('Y'),
                    'it_classe' =>  13,
                    'vc_localEmissao' =>  $diplomado->vc_localEmissao,
                    'tokenKey' => 'DIPLOMADO',
                    'it_estado_aluno' => '1'

                ]);
                return  true;
            }
            return  true;
        } catch (Exception $ex) {
            return $diplomado->vc_nBI;
        }
    }
}
