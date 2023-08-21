<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Nota;
use App\Models\Disciplinas;
use App\Models\Classe;
use App\Models\Turma;
use App\Models\AnoLectivo;
use App\Models\Estudante;
use App\Models\Matricula;
use App\Models\Logger;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class NotaController extends Controller
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

  public function pesquisar(Nota $disciplina)
  {
    $response['anoslectivos'] = AnoLectivo::where([['it_estado_anoLectivo', 1]])->get();
    $response['disciplinas'] = $disciplina->RDisciplinasJoins();
    $response['classes'] = Classe::where([['it_estado_classe', 1]])->get();
    $response['trimestres'] = Nota::where([['it_estado_nota', 1]])->get();

    /* Trás as turmas do ano lectivo actual */
    $anoLectivo = AnoLectivo::where([['it_estado_anoLectivo', 1]])->orderby('id', 'desc')->first();
    $response['turmas'] = Turma::where([['it_estado_turma', 1], ['vc_anoLectivo', $anoLectivo->ya_inicio . "-" . $anoLectivo->ya_fim]])->get();

    return view('admin.notas.pesquisar.index', $response);
  }
  public function recebePesquisaNotas(Request $request)
  {
    $anoLectivo = $request->vc_anolectivo;
    $disciplina = $request->vc_disciplina;
    $classe = $request->classe;
    $trimestre = $request->vc_nomeT;
    $turma = $request->vc_nomedaTurma;
   // dd($request);
    return redirect("nota/ver/$anoLectivo/$trimestre/$classe/$disciplina/$turma");
    //return redirect()->route('admin.notas.index',[$anoLectivo,$anoLectivo,$trimestre,$classe,$disciplina,$turma]);
  }

  public function index(Nota $Rnotas, $anoLectivo, $trimestre, $classe, $disciplina, $turma)
  {

    $response['titulo_anoLectivo'] = $anoLectivo;
    $response['titulo_trimestre'] = $trimestre;
    $response['titulo_classe'] = $classe;
    $response['titulo_disciplina'] = $disciplina;
    $response['titulo_turma'] = $turma;
   // dd($classe);

    $response['notas'] = $Rnotas->NotaForSearch($anoLectivo, $disciplina, $classe, $turma, $trimestre);
    //dd($response);
    return view('admin.notas.index',  $response);
  }

  public function create()
  {

    $anoactual = AnoLectivo::orderby('id', 'desc')->first();
    if ($anoactual) {
      $anoslectivos = AnoLectivo::where([['it_estado_anoLectivo', 1]])->get();
      $disciplinas = Disciplinas::where([['it_estado_disciplina', 1]])->get();
      $classes = Classe::where([['it_estado_classe', 1]])->get();
      $notas = Nota::where([['it_estado_nota', 1]])->get();
      $turmas = Turma::where([['it_estado_turma', 1]])->get();

      return view('admin.notas.cadastrar.index', compact('notas', 'disciplinas', 'classes', 'turmas', 'anoslectivos', 'anoactual'));
    } else {
      return redirect('/home')->with('aviso', '1');
    }
  }
  public function store(Request $request)
  {

 /*    try {
 */
      /* Procura se existe esse dado que esta sendo introduzido na BD, 
      se não existe pode introduzir, se existe não introduza */
      $ExistData = Nota::where([
        ['vc_anolectivo', $request->vc_anolectivo],
        ['vc_nomedaTurma', $request->vc_nomedaTurma],
        ['id_aluno', $request->it_idAluno],
        ['vc_tipodaNota', $request->vc_tipodaNota],
        ['it_disciplina', $request->it_disciplina],
      ])->count();


      if ($ExistData == 0) {


        $mediana = (($request->fl_nota1 + $request->fl_nota2 + $request->fl_mac) / 3);
        Nota::create([
          'it_classe' => $request->classe,
          'it_disciplina' => $request->it_disciplina,
          'vc_nomedaTurma' => $request->vc_nomedaTurma,
          'vc_tipodaNota' => $request->vc_tipodaNota,
          'fl_nota1' => $request->fl_nota1,
          'fl_nota2' => $request->fl_nota2,
          'fl_mac' => $request->fl_mac,
          'id_aluno' => $request->it_idAluno,
          'fl_media' => $mediana,
          'vc_anolectivo' => $request->vc_anolectivo,
        ]);
        $this->Logger->Log('info', 'Adicionou Nota');
        return redirect('/nota')->with('status', '1');
      } else {
        /* redirecionar e informar que a nota já foi introduzida */
        return redirect('nota')->with('ExisteNota', '1');
      }
   /*  } catch (\Exception $exception) {
      return redirect()->back()->with('danger', 'Preencher todos os campos');
    } */
  }
   public function edit(Estudante $estudantes, $id)
  {
    $anoslectivos = AnoLectivo::where([['it_estado_anoLectivo', 1]])->get();
    $classes = Classe::where([['it_estado_classe', 1]])->get();
    $turmas = Turma::where([['it_estado_turma', 1]])->get();
    $notas = Nota::findOrFail($id);
    $searchs = $estudantes->StudentForNota($id);
    $disciplinas  = DB::table('notas')
      ->join('disciplinas', 'disciplinas.id', '=', 'notas.id_disciplina_curso_classe')
      ->select('disciplinas.vc_nome')
      ->where([['it_estado_nota', 1]])
      ->where([['notas.id', $id]])
      ->get();


    return view('admin.notas.editar.index', compact('notas', 'searchs', 'disciplinas', 'classes', 'turmas', 'anoslectivos'));
  }
  
  public function update(Request $request, $id)
  {
    $notas = Nota::findOrFail($id)->update([
      'fl_nota1' => $request->fl_nota1,
      'fl_nota2' => $request->fl_nota2,
      'fl_mac' => $request->fl_mac,
      'fl_media' => ($request->fl_nota1 + $request->fl_nota2 + $request->fl_mac) / 3,

    ]);

    if ($notas) {
      //$response['notas'] = $Rnotas->NotaForSearch($anoLectivo, $disciplina, $classe, $turma, $trimestre);
      //return redirect()->route('admin.notas.index');
      $this->Logger->Log('info', 'Actualizou Nota ');
      return redirect()->back()->with('status',1);
      
    }
  } 
  public function delete($id)
  {
    //Nota::find($id)->delete();
    $response = Nota::find($id);
    $response->update(['it_estado_nota' => 0]);
    $this->Logger->Log('info', 'Eliminou Nota ');
    return redirect()->back();
  }


  public function recebeAluno(Request $request)
  {
    $id = $request->it_idAluno;
    $anoletivo = $request->vc_anoletivo;
    return redirect("/admin/nota/search/$id/$anoletivo");
  }

  public function search(Estudante $estudantes, $id, $anoletivo)
  {
    $anoactual = AnoLectivo::where([['it_estado_anoLectivo', 1]])->orderby('id', 'desc')->first();
    try {
      $E = Matricula::where([['id_aluno', $id], ['vc_anoLectivo', $anoletivo]])->first();
      $idClasse = $E->it_idClasse;
      $idCurso = $E->it_idCurso;
      $disciplinas = $estudantes->SubjectForClass($idClasse, $idCurso);
      $searchs = $estudantes->StudentForNota($id);

      if ($searchs->count()) {
        return view('admin/notas/cadastrar/index', compact('searchs', 'disciplinas', 'anoactual'));
      } else {
        return redirect("/nota")->back()->with('danger', "Número de processo não encontrado no ano lectivo $anoletivo");
      }
    } catch (\Exception $exception) {
      return redirect("/nota")->with('danger', "Número de processo não encontrado no ano lectivo $anoletivo");
    }
  }
}
