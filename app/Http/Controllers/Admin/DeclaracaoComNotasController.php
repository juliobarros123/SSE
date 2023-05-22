<?php

namespace App\Http\Controllers\Admin;

use App\Models\DeclaracaoComNotas;
use App\Models\Classe;
use App\Models\Disciplinas;
use App\Http\Controllers\Controller;
use App\Models\Cabecalho;
use App\Models\Logger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use  App\Http\Requests\declaracaoComNotas\declaracao;
use App\Models\Disciplina_Curso_Classe;
use Illuminate\Support\Facades\Auth;

class DeclaracaoComNotasController extends Controller
{
  private $Logger;
    public function __construct()
    {
        $this->Logger = new Logger();
    }
    public function loggerData($mensagem){
      $dados_Auth = Auth::user()->vc_primemiroNome.' '.Auth::user()->vc_apelido.' Com o nivel de '.Auth::user()->vc_tipoUtilizador.' ';
      $this->Logger->Log('info', $dados_Auth.$mensagem);
  }
  public function home()
  {
    $classes = Classe::all();
    return view('admin.declaracaoComNotas.index', compact('classes'));
  }
  //

  public $bprocesso;
  public $AlClasse;
  public  $trimestre;
  public   $disciplinaId;
  public $id_classe;
  public function buscarDadosDoAluno(Request $bi, $disciplinaId)
  {
   

    $this->disciplinaId = $disciplinaId;
    $this->processo = $bi->idAluno;
    $this->AlClasse = $bi->AlClasse;
    $vc_classe=DB::table('classes')->where('classes.id','=',$this->AlClasse )->select('classes.id')->get();
  
   $this->id_classe = $vc_classe['0']->id;

    $DadosDoAluno = DB::table('alunnos')
      ->join('matriculas', function ($join) {
        $join->on('matriculas.it_idAluno', '=', 'alunnos.id')
          ->where([['matriculas.it_idAluno', '=', $this->processo], ['matriculas.it_idClasse', '=', $this->AlClasse]]);
      })->join('notas', function ($join) {
        $join->on('notas.it_idAluno', '=', 'alunnos.id')
          ->where('alunnos.id', '=', $this->processo);
      })->join('disciplinas_cursos_classes', function ($join) {
        $join->on('notas.it_disciplina', '=', 'disciplinas_cursos_classes.id');
     
     })
     ->join('disciplinas', 'disciplinas_cursos_classes.it_disciplina', '=', 'disciplinas.id')
      ->where([['notas.id_classe', '=', $this->id_classe],['notas.it_disciplina', '=',$this->disciplinaId]])
      ->get();

    return $DadosDoAluno;
  }


  public function buscarAluno(declaracao  $bi)
  {

    $trimestres[0] = "I";
    $trimestres[1] = "II";
    $trimestres[2] = "III";
    $cont = 0;

    $desciplinas =  Disciplina_Curso_Classe::all();
  
    foreach ($desciplinas as  $desciplina) {

      $DadoGeral[$cont] = $this->buscarDadosDoAluno($bi, $desciplina->id);
      $cont++;
    }


    if (isset($DadoGeral))
      if (sizeof($DadoGeral[0]) == 3) {
        $DadosDoAluno1 =  $DadoGeral;
        $dadosDaEscola = Cabecalho::find(1);
        foreach ($DadoGeral as  $DadosDoAluno) {
          foreach ($DadosDoAluno as  $DadosDoAluno) {

            $filtroDadosDoAlunoeDaEscola =
              [
                'nome_do_aluno' => $DadosDoAluno->vc_primeiroNome . ' ' . $DadosDoAluno->vc_nomedoMeio . ' ' . $DadosDoAluno->vc_ultimoaNome,
                'curso' => $DadosDoAluno->vc_nomeCurso,
                'nome_da_escola' => $dadosDaEscola->vc_escola,
                'vc_anoLectivo' => $DadosDoAluno->vc_anoLectivo,
                'it_classe' => $DadosDoAluno->it_idClasse,
                'vc_logo' => $dadosDaEscola->vc_logo,
                'vc_escola' => $dadosDaEscola->vc_escola,
                'vc_acronimo' => $dadosDaEscola->vc_acronimo,
                'vc_nif' => $dadosDaEscola->vc_nif,
                'vc_republica' => $dadosDaEscola->vc_republica,
                'vc_ministerio' => $dadosDaEscola->vc_ministerio,
                'vc_endereco' => $dadosDaEscola->vc_endereco,
                'it_telefone' => $dadosDaEscola->it_telefone,
                'ano_de_estudo' => $DadosDoAluno->it_classe

              ];
          }
        }

        $date = date("Y") . '-' . date("m") . '-' . date("d");
        $dec = DeclaracaoComNotas::where([['id_aluno', $bi->idAluno], ['classe', $bi->AlClasse]])->get();

        if (sizeof($dec) == 0) {
          DeclaracaoComNotas::insert(
            [
              'id_aluno' => $bi->idAluno,
              'dt_DataDeEmissaoDeDeclaracao' => $date,
              'classe' => $this->AlClasse
            ]
          );
        } else {
          DeclaracaoComNotas::where([['id_aluno', $bi->idAluno], ['classe', $bi->AlClasse . 'ªclasse']])->update(
            [
              'dt_DataDeEmissaoDeDeclaracao' => $date,
            ]
          );
        }
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetFont("times new roman");
        $id = DB::table('declaracao_com_notas')->select('id')->where([['id_aluno', $bi->idAluno], ['classe', $bi->AlClasse]])->get();
        global  $ref;
        foreach ($id as $idref)
          $ref = $idref->id;
        
        $html = view('admin.declaracaoComNotas.buscarAluno.index', compact('DadosDoAluno1', 'ref'), ['filtroDadosDoAlunoeDaEscola' => $filtroDadosDoAlunoeDaEscola]);
        //return PDF::loadView('admin.declaracaoComNotas.buscarAluno.index',compact('DadosDoAluno1'),[ 'filtroDadosDoAlunoseDaEscola'=>$filtroDadosDoAlunoseDaEscola])->setPaper('A4')->stream('pdf_file.pdf');
       /*  $css = file_get_contents(__full_path().'css/Declaração/declaracao.css'); */
       $response['cabecalho'] = $this->cabecalho;
        // dd($response);
        if ($response['cabecalho'] != null) {

            $mpdf = new \Mpdf\Mpdf();
            /* $response['stylesheet'] = file_get_contents(__full_path().'css/Declaração/declaracao.css'); */
            if ($response['cabecalho']->vc_nif == "5000298182") {

                //$url = 'cartões/CorMarie/aluno.png';
               $css = file_get_contents(__full_path().'css/Declaração/declaracao.css');

            } else if ($response['cabecalho']->vc_nif == "7301002327") {

                //$url = 'cartões/InstitutoPolitécnicodoUIGE/aluno.png';
               $css = file_get_contents(__full_path().'css/Declaração/declaracao.css');
            } else if ($response['cabecalho']->vc_nif == "5000303399") {

                //$url = 'cartões/negage/aluno.png';
               $css = file_get_contents(__full_path().'css/Declaração/declaracao.css');
            } else if ($response['cabecalho']->vc_nif == "5000820440") {
            
                //$url = 'cartões/Quilumosso/aluno.png';
               $css = file_get_contents(__full_path().'css/Declaração/declaracao.css');
            } else if ($response['cabecalho']->vc_nif == "5000305308") {

                //$url = 'cartões/Foguetao/aluno.png';
               $css = file_get_contents(__full_path().'css/Declaração/declaracao.css');
            } else if ($response['cabecalho']->vc_nif == "7301002572") {

                //$url = 'cartões/LiceuUíge/aluno.png';
               $css = file_get_contents(__full_path().'css/Declaração/declaracao.css');
             } else if ($response['cabecalho']->vc_nif == "7301003617") {

              //$url = 'cartões/ldc/aluno.png';
             $css = file_get_contents(__full_path().'css/Declaração/declaracao.css');
          } else if ($response['cabecalho']->vc_nif == "5000300926") {

                //$url = 'cartões/imagu/aluno.png';
               $css = file_get_contents(__full_path().'css/Declaração/declaracao.css');
            }  else {
                //$url = 'images/cartao/aluno.jpg';
               $css = file_get_contents(__full_path().'css/Declaração/declaracao.css');
            }
          }else {
              return redirect('declaracao');
          }
        $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);
        $mpdf->Output();
      } else {

        $bi->merge([
          'idAluno' => "",
        ]);

        $bi->validate([
          'idAluno' => 'required'
        ], [
          'idAluno.required' => 'Aluno Não Existe Ou Não Tem Nota'

        ]);
      }
    else {

      $bi->merge([
        'idAluno' => "",
      ]);

      $bi->validate([
        'idAluno' => 'required'
      ], [
        'idAluno.required' => 'Aluno Não Existe Ou Não Tem Nota'
      ]);
    }
  }



  public function declaracoesEmitidas()
  {
    $DadosDoAlunoDeDeclaracao = DB::table('alunnos')
      ->join('declaracao_com_notas', function ($join) {
        $join->on('declaracao_com_notas.it_idAluno', '=', 'alunnos.id');
      })->get();
      $this->Logger->Log('info','Emitiu Uma Declaração Com Nota');
    return view('admin.declaracaoComNotas.gerarDeclaracao.index', compact('DadosDoAlunoDeDeclaracao'));
  }
}