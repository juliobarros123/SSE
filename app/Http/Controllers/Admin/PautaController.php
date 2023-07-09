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
use App\Models\Cabecalho;
use App\Models\Curso;
use App\Models\Pauta;
use App\Models\Turma;
use App\Models\Nota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Logger;
use App\Models\Disciplinas;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\NotaDinamca;
use Illuminate\Support\Facades\Mail;
use Exception;

class PautaController extends Controller
{
    private $Logger;
    private $notas;
    private $notaDinamca;
    public function __construct(Nota $notas, NotaDinamca $notaDinamca)
    {
        $this->Logger = new Logger();
        $this->notas = $notas;
        $this->notaDinamca = $notaDinamca;
    }

    public function index()
    {
        //
        $response['anoslectivos'] = AnoLectivo::where([['it_estado_anoLectivo', 1]])->get();
        $response['cursos'] = Curso::where([['it_estado_curso', 1]])->get();
        return view('admin/pauta/pesquisar/index', $response);
    }

    public function loggerData($mensagem)
    {
        $dados_Auth = Auth::user()->vc_primemiroNome . ' ' . Auth::user()->vc_apelido . ' Com o nivel de ' . Auth::user()->vc_tipoUtilizador . ' ';
        $this->Logger->Log('info', $dados_Auth . $mensagem);
    }

    public function store(Request $request)
    {
        //
        $anoLectivo = $request->vc_anolectivo;
        $curso = $request->vc_curso;
        return redirect("/admin/pauta/listas/$anoLectivo/$curso");
    }
    public function show($anoLectivo, $curso)
    {
        if ($anoLectivo == 'Todos') {
            $anoLectivo = '';
        }
        if ($curso == 'Todos') {
            $curso = '';
        }
        if ($anoLectivo && $curso) {
            $dadosDaTabelaTurma = Turma::where([
                ['it_estado_turma', 1],
                ['vc_anoLectivo', '=', $anoLectivo],
                ['vc_cursoTurma', '=', $curso]
            ])->get();
        } elseif ($anoLectivo && !$curso) {
            $dadosDaTabelaTurma = Turma::where([
                ['it_estado_turma', 1],
                ['vc_anoLectivo', '=', $anoLectivo]
            ])->get();
        } elseif (!$anoLectivo && $curso) {
            $dadosDaTabelaTurma = Turma::where([
                ['it_estado_turma', 1],
                ['vc_cursoTurma', '=', $curso]
            ])->get();
        } else {
            $dadosDaTabelaTurma = Turma::where([['it_estado_turma', 1]])->get();
        }
        return view('admin.pauta.index', compact('dadosDaTabelaTurma'));
    }

    public function create(Pauta $ResponseAlunos, $id, $trimestre)
    {
        $data['notas'] = $this->notas->object_notas($id, $trimestre);
        dd($data['notas']);
        $data['cabecalho'] = Cabecalho::find(1);
        $data['detalhes_turma'] = $this->detalhes_turma($id);
        $data['trimestre'] = $trimestre;


        // dd( $response['notas']);
        // $data["bootstrap"] = file_get_contents("css/pauta/bootstrap.min.css");
        /*  $data["css"] = file_get_contents("css/pauta/style.css"); */
        if ($data['cabecalho']->vc_nif == "5000298182") {

            //$url = 'cartões/CorMarie/aluno.png';
            $data["css"] = file_get_contents('css/pauta/style.css');
            $data["bootstrap"] = file_get_contents('css/pauta/bootstrap.min.css');

        } else if ($data['cabecalho']->vc_nif == "7301002327") {

            //$url = 'cartões/InstitutoPolitécnicodoUIGE/aluno.png';
            $data["css"] = file_get_contents('css/pauta/style.css');
            $data["bootstrap"] = file_get_contents('css/pauta/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "5000303399") {

            //$url = 'cartões/negage/aluno.png';
            $data["css"] = file_get_contents('css/pauta/style.css');
            $data["bootstrap"] = file_get_contents('css/pauta/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "5000820440") {

            //$url = 'cartões/Quilumosso/aluno.png';
            $data["css"] = file_get_contents('css/pauta/style.css');
            $data["bootstrap"] = file_get_contents('css/pauta/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "5000305308") {

            //$url = 'cartões/Foguetao/aluno.png';
            $data["css"] = file_get_contents('css/pauta/style.css');
            $data["bootstrap"] = file_get_contents('css/pauta/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "7301002572") {

            //$url = 'cartões/LiceuUíge/aluno.png';
            $data["css"] = file_get_contents('css/pauta/style.css');
            $data["bootstrap"] = file_get_contents('css/pauta/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "7301003617") {

            //$url = 'cartões/ldc/aluno.png';
            $data["css"] = file_get_contents('css/pauta/style.css');
            $data["bootstrap"] = file_get_contents('css/pauta/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "5000300926") {

            //$url = 'cartões/imagu/aluno.png';
            $data["css"] = file_get_contents('css/pauta/style.css');
            $data["bootstrap"] = file_get_contents('css/pauta/bootstrap.min.css');
        } else {
            //$url = 'images/cartao/aluno.jpg';
            /*  $data["css"] = file_get_contents('css/pauta/style.css');
             $data["bootstrap"] = file_get_contents('css/pauta/bootstrap.min.css'); */
            if ($data['cabecalho']->vc_nif == "5000298182") {

                //$url = 'cartões/CorMarie/aluno.png';
                $data["css"] = file_get_contents('css/pauta/style.css');
                $data["bootstrap"] = file_get_contents('css/pauta/bootstrap.min.css');

            } else if ($data['cabecalho']->vc_nif == "7301002327") {

                //$url = 'cartões/InstitutoPolitécnicodoUIGE/aluno.png';
                $data["css"] = file_get_contents('css/pauta/style.css');
                $data["bootstrap"] = file_get_contents('css/pauta/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000303399") {

                //$url = 'cartões/negage/aluno.png';
                $data["css"] = file_get_contents('css/pauta/style.css');
                $data["bootstrap"] = file_get_contents('css/pauta/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000820440") {

                //$url = 'cartões/Quilumosso/aluno.png';
                $data["css"] = file_get_contents('css/pauta/style.css');
                $data["bootstrap"] = file_get_contents('css/pauta/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000305308") {

                //$url = 'cartões/Foguetao/aluno.png';
                $data["css"] = file_get_contents('css/pauta/style.css');
                $data["bootstrap"] = file_get_contents('css/pauta/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "7301002572") {

                //$url = 'cartões/LiceuUíge/aluno.png';
                $data["css"] = file_get_contents('css/pauta/style.css');
                $data["bootstrap"] = file_get_contents('css/pauta/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "7301003617") {

                //$url = 'cartões/ldc/aluno.png';
                $data["css"] = file_get_contents('css/pauta/style.css');
                $data["bootstrap"] = file_get_contents('css/pauta/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000300926") {

                //$url = 'cartões/imagu/aluno.png';
                $data["css"] = file_get_contents('css/pauta/style.css');
                $data["bootstrap"] = file_get_contents('css/pauta/bootstrap.min.css');
            } else {
                //$url = 'images/cartao/aluno.jpg';
                $data["css"] = file_get_contents('css/pauta/style.css');
                $data["bootstrap"] = file_get_contents('css/pauta/bootstrap.min.css');
            }
        }
        $mpdf = new \Mpdf\Mpdf(['format' => 'A2-L']);
        $mpdf->SetFont("arial");
        $mpdf->setHeader();
        $this->Logger->Log('info', 'Imprimiu Pauta Final ');
        $html = view("admin/pdfs/pauta/trimestral", $data);
        $mpdf->writeHTML($html);
        $mpdf->Output("pauta.pdf", "I");
    }



    public function disciplina($slug_turma_user, $trimestre, $slug_disciplina_curso_classe)
    {
        //   $n=  ;

        $turma_professor = fh_turmas_professores()->where('turmas_users.slug', $slug_turma_user)->first();
        if ($turma_professor):
            $turma = fh_turmas_2()->where('turmas.id', $turma_professor->id_turma)->first();
            // dd(  $turma_professor );
            $alunos = fha_turma_alunos($turma->slug);

            $response['trimestre'] = $trimestre;
            $response['alunos'] = $alunos;
            $response['turma'] = $turma;
            $response['turma_professor'] = $turma_professor;
            $response['trimestre'] = $trimestre;
            $response['cabecalho'] = fh_cabecalho();
            // dd($response['turma_professor']);
            $response["css"] = file_get_contents('css/lista/style-2.css');

            // $mpdf = new \Mpdf\Mpdf(['format' => [210, 297]]);
            $mpdf = new \Mpdf\Mpdf([
                'mode' => 'utf-8',
                'format' => [210, 297],
                'margin_top' => 5,

            ]);
            $mpdf->setHeader();
            $this->Logger->Log('info', 'Imprimi mini pauta');
            $html = view("admin/pdfs/pauta/mini/trimestral", $response);
            $mpdf->writeHTML($html);
            // $this->enviarEmail($mpdf, Auth::User()->vc_email, $datos, ' emails.nota.mini-pauta');
            $mpdf->Output("pauta.pdf", "I");
        else:
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado']);


        endif;

    }
    public $email;
    public $mpdf;
    public $disciplina;
    public $vc_classe;
    public $vc_shortName;
    public $vc_nomedaTurma;
    public $anoLectivo;
    public $trimestre;
    public function enviarEmail($mpdf, $distino, $dados, $view)
    {

        $this->disciplina = $dados['disciplina'];
        $this->vc_classe = $dados['detalhes_turma']->vc_classe;
        $this->vc_shortName = $dados['detalhes_turma']->vc_shortName;
        $this->vc_nomedaTurma = $dados['detalhes_turma']->vc_nomedaTurma;
        $this->anoLectivo = $dados['detalhes_turma']->ya_inicio . '/' . $dados['detalhes_turma']->ya_fim;
        $this->trimestre = $dados['trimestre'];
        $this->mpdf = $mpdf;
        try {

            $this->email = $distino;
            Mail::send($view, $dados, function ($message) {
                $message->from('vagas@itel.gov.ao', 'SGE(Sistema de Gestão do Itel)');
                $message->subject('Mini pauta geral de aproveitamente12');
                $message->to($this->email);
                $message->attachData($this->mpdf->Output('', 'S'), "Mini pauta de $this->disciplina- $this->vc_nomedaTurma-  $this->trimestre-$this->vc_classe ªClasse-$this->vc_shortName- $this->anoLectivo.pdf");
            });
            return true;
        } catch (Exception $ex) {
        }
    }

    public function disciplina_geral($id_turma, $trimestre, $id_disciplina)
    {


        $data['cabecalho'] = Cabecalho::find(1);
        $data['disciplina'] = Disciplinas::find($id_disciplina);
        $data['trimestre'] = $trimestre;
        $data['detalhes_turma'] = $this->detalhes_turma($id_turma); //    dd( $response['notas']);

        $data['notas'] = $this->notas->object_notas_disc_todos_trimestre($id_turma, $trimestre, $id_disciplina);
        // dd($data['notas']);
        // $data["bootstrap"] = file_get_contents("css/pauta/bootstrap.min.css");
        /*  $data["css"] = file_get_contents("css/pauta/style.css"); */
        if ($data['cabecalho']->vc_nif == "5000298182") {

            //$url = 'cartões/CorMarie/aluno.png';
            $data["css"] = file_get_contents('css/pauta/style.css');
            $data["bootstrap"] = file_get_contents('css/pauta/bootstrap.min.css');

        } else if ($data['cabecalho']->vc_nif == "7301002327") {

            //$url = 'cartões/InstitutoPolitécnicodoUIGE/aluno.png';
            $data["css"] = file_get_contents('css/pauta/style.css');
            $data["bootstrap"] = file_get_contents('css/pauta/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "5000303399") {

            //$url = 'cartões/negage/aluno.png';
            $data["css"] = file_get_contents('css/pauta/style.css');
            $data["bootstrap"] = file_get_contents('css/pauta/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "5000820440") {

            //$url = 'cartões/Quilumosso/aluno.png';
            $data["css"] = file_get_contents('css/pauta/style.css');
            $data["bootstrap"] = file_get_contents('css/pauta/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "5000305308") {

            //$url = 'cartões/Foguetao/aluno.png';
            $data["css"] = file_get_contents('css/pauta/style.css');
            $data["bootstrap"] = file_get_contents('css/pauta/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "7301002572") {

            //$url = 'cartões/LiceuUíge/aluno.png';
            $data["css"] = file_get_contents('css/pauta/style.css');
            $data["bootstrap"] = file_get_contents('css/pauta/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "7301003617") {

            //$url = 'cartões/ldc/aluno.png';
            $data["css"] = file_get_contents('css/pauta/style.css');
            $data["bootstrap"] = file_get_contents('css/pauta/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "5000300926") {

            //$url = 'cartões/imagu/aluno.png';
            $data["css"] = file_get_contents('css/pauta/style.css');
            $data["bootstrap"] = file_get_contents('css/pauta/bootstrap.min.css');
        } else {
            //$url = 'images/cartao/aluno.jpg';
            $data["css"] = file_get_contents('css/pauta/style.css');
            $data["bootstrap"] = file_get_contents('css/pauta/bootstrap.min.css');
        }
        $mpdf = new \Mpdf\Mpdf(['format' => 'A2-L']);
        $mpdf->SetFont("arial");
        $mpdf->setHeader();
        $this->Logger->Log('info', 'Imprimi mini pauta');
        $html = view("admin/pdfs/pauta/mini/geral", $data);
        $mpdf->writeHTML($html);
        $mpdf->Output("pauta.pdf", "I");
    }

    public function detalhes_turma($id_turma)
    {
        $resul_set = DB::table('turmas')
            ->join('classes', 'turmas.it_idClasse', '=', 'classes.id')
            ->join('cursos', 'turmas.it_idCurso', '=', 'cursos.id')
            ->Join('anoslectivos', 'turmas.it_idAnoLectivo', '=', 'anoslectivos.id')
            ->where('turmas.id', $id_turma)
            ->first();

        return $resul_set;
    }





    public function trimestral($slug_turma, $trimestre)
    {
        $turma = fh_turmas_2()->where('turmas.slug', $slug_turma)->first();
        if ($turma):
            $response['director_turma'] = fh_directores_turmas()->where('turmas.id', $turma->id)->first();
            $response['disciplinas'] = fh_turma_disciplina($slug_turma)->get();

            $alunos = fha_turma_alunos($slug_turma);
            $response['trimestre'] = $trimestre;
            $response['alunos'] = $alunos;
            $response['turma'] = $turma;
            $response['trimestre'] = $trimestre;
            $response['cabecalho'] = fh_cabecalho();

            $response["css"] = file_get_contents('css/lista/style-2.css');
            $mpdf = new \Mpdf\Mpdf([
                'mode' => 'utf-8',
                'format' => [210, 297],
                'margin_top' => 5,

            ]);
            $mpdf->setHeader();
            $this->Logger->Log('info', 'Imprimi mini pauta');
            $html = view("admin/pdfs/pauta/trimestral/index", $response);

            $mpdf->writeHTML($html);
            // $this->enviarEmail($mpdf, Auth::User()->vc_email, $datos, ' emails.nota.mini-pauta');
            $mpdf->Output("pauta.pdf", "I");
        else:
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado']);


        endif;

    }

    public function creatEnd(Pauta $ResponseAlunos, $id, $tipo)
    {


        $data['cabecalho'] = Cabecalho::find(1);
        $ResponseTurma = Turma::find($id);
        $data['turma'] = $ResponseTurma;
        $data['tipos'] = $tipo;

        /* Acenssando os dados da turma */
        $vc_anoLectivo = $ResponseTurma->vc_anoLectivo;
        $vc_cursoTurma = $ResponseTurma->vc_cursoTurma;
        $vc_classeTurma = $ResponseTurma->vc_classeTurma;
        /* end-acesso */

        /* joins apartir do model */
        $data['cabecalhoNotas'] = $ResponseAlunos->HeaderNoteforPauta($vc_cursoTurma, $vc_classeTurma)->get();
        $AlunoRes = $ResponseAlunos->AlunosforPauta($vc_anoLectivo, $ResponseTurma->id)->get();
        $data['alunos'] = $AlunoRes;
        /* endjoins */
        if ($AlunoRes->count()):
            /*   $data["bootstrap"] = file_get_contents("css/pauta/bootstrap.min.css");
              $data["css"] = file_get_contents("css/pauta/style.css"); */

            if ($data['cabecalho']->vc_nif == "5000298182") {

                //$url = 'cartões/CorMarie/aluno.png';
                $data["css"] = file_get_contents('css/pauta/style.css');
                $data["bootstrap"] = file_get_contents('css/pauta/bootstrap.min.css');

            } else if ($data['cabecalho']->vc_nif == "7301002327") {

                //$url = 'cartões/InstitutoPolitécnicodoUIGE/aluno.png';
                $data["css"] = file_get_contents('css/pauta/style.css');
                $data["bootstrap"] = file_get_contents('css/pauta/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000303399") {

                //$url = 'cartões/negage/aluno.png';
                $data["css"] = file_get_contents('css/pauta/style.css');
                $data["bootstrap"] = file_get_contents('css/pauta/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000820440") {

                //$url = 'cartões/Quilumosso/aluno.png';
                $data["css"] = file_get_contents('css/pauta/style.css');
                $data["bootstrap"] = file_get_contents('css/pauta/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000305308") {

                //$url = 'cartões/Foguetao/aluno.png';
                $data["css"] = file_get_contents('css/pauta/style.css');
                $data["bootstrap"] = file_get_contents('css/pauta/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "7301002572") {

                //$url = 'cartões/LiceuUíge/aluno.png';
                $data["css"] = file_get_contents('css/pauta/style.css');
                $data["bootstrap"] = file_get_contents('css/pauta/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "7301003617") {

                //$url = 'cartões/ldc/aluno.png';
                $data["css"] = file_get_contents('css/pauta/style.css');
                $data["bootstrap"] = file_get_contents('css/pauta/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000300926") {

                //$url = 'cartões/imagu/aluno.png';
                $data["css"] = file_get_contents('css/pauta/style.css');
                $data["bootstrap"] = file_get_contents('css/pauta/bootstrap.min.css');
            } else {
                //$url = 'images/cartao/aluno.jpg';
                $data["css"] = file_get_contents('css/pauta/style.css');
                $data["bootstrap"] = file_get_contents('css/pauta/bootstrap.min.css');
            }
            $mpdf = new \Mpdf\Mpdf(['format' => 'A3-L']);

            $mpdf->SetFont("arial");
            $mpdf->setHeader();
            $this->Logger->Log('info', 'Imprimiu Pauta Final ');
            $html = view("admin/pdfs/pauta/final", $data);
            $mpdf->writeHTML($html);
            $mpdf->Output($vc_anoLectivo . "_" . $vc_classeTurma . "_" . $vc_cursoTurma . "_" . $tipo . ".pdf", "I");
        else:
            return back()->with('aviso', 'Não existe alunos nesta turma');
        endif;
    }
}