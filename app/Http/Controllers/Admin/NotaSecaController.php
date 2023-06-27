<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Matricula;
use App\Models\Turma;
use App\Models\Classe;
use App\Models\Curso;
use App\Models\Disciplinas;
use App\Models\Nota;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Models\Logger;
use Illuminate\Support\Arr;

class NotaSecaController extends Controller
{
    private $matricula;
    private $turma;

    public function __construct()
    {
        $this->matricula = new Matricula();
        $this->turma = new Turma();
        $this->Logger = new Logger();
    }
    public function loggerData($mensagem)
    {
        $dados_Auth = Auth::user()->vc_primemiroNome . ' ' . Auth::user()->vc_apelido . ' Com o nivel de ' . Auth::user()->vc_tipoUtilizador . ' ';
        $this->Logger->Log('info', $dados_Auth . $mensagem);
    }

    public function fh_disciplinas_cursos_classes()
    {
        $datas = DB::table('disciplinas_cursos_classes')
            ->join('disciplinas', 'disciplinas_cursos_classes.it_disciplina', '=', 'disciplinas.id')
            ->join('cursos', 'disciplinas_cursos_classes.it_curso', '=', 'cursos.id')
            ->join('classes', 'disciplinas_cursos_classes.it_classe', '=', 'classes.id')
            ->where([['disciplinas_cursos_classes.it_estado_dcc', 1]])
            ->select('disciplinas_cursos_classes.*', 'disciplinas.vc_nome', 'disciplinas.vc_acronimo', 'cursos.vc_nomeCurso', 'classes.vc_classe');

        return $datas;
    }
    public function inserir($slug_turma)
    {
        $response['turma'] = fh_turmas_slug($slug_turma)->first();

        if ($response['turma']) {
            //   dd( $response['turma']);
            $response['alunos'] = fha_turma_alunos($slug_turma);
            $response['disciplinas_cursos_classes'] = fh_disciplinas_cursos_classes()
                ->where('cursos.id', $response['turma']->it_idCurso)
                ->where('classes.id', $response['turma']->it_idClasse)->
                select('disciplinas.vc_acronimo', 'disciplinas_cursos_classes.*')->get();
            // fha_disciplinas(, $response['turma']->it_idClasse);

            // dd($response['turma']->it_idCurso);

            return view('admin.nota-seca.inserir.index', $response);
        } else {
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado!']);
        }
    }

    public function pegar($id_turma)
    {
    }
    public function pegarDisciplinas($id_turma)
    {
        $id_curso = Turma::find($id_turma)->it_idCurso;
        $id_classe = Turma::find($id_turma)->it_idClasse;
        $disciplinas = $this->fh_disciplinas_cursos_classes()->where('classes.id', $id_classe)
            ->where('cursos.id', $id_curso)->get();
        return $disciplinas;
    }
    public function vrf_disciplina_terminal($id_disciplina, $id_turma, $estado, $processoAluno, $classe)
    {
        if ($estado) {
            $classes = $this->quantosClasses($id_disciplina, $id_turma, $estado, $processoAluno, $classe);
            return response()->json($classes);
        }
    }
    public function cadastrar1(Request $nota)
    {
        // $response['processosAluno'] = $this->matricula->processosAluno($processo)->first();
        for ($cont = $nota->classe; $cont >= 10; $cont--) {
            $turma = Turma::find($nota->id_turma);
            $classe = Classe::where('vc_classe', $cont)->first();
            $dcc = $this->fh_disciplinas_cursos_classes()->where('classes.id', $classe->id)
                ->where('disciplinas.id', $nota->disciplina)
                ->where('cursos.id', $turma->it_idCurso)->first();
            $this->updateNota($nota->processo, $nota, $turma->it_idClasse, $turma->it_idAnoLectivo, $dcc->id, $turma->id);
        }
        // $divisor = $this->acharDivisor($nota->classe);
        // $mts = $this->dividirNota($nota->nota, $divisor);
    }
    public function quantosClasses($id_disciplina, $id_turma, $estado, $processoAluno, $classe)
    {
        $classes = array();
        if ($estado == 1) {
            $processosAluno = $this->matricula->processosAluno($processoAluno)->where('classes.vc_classe', '<', $classe)->get();
            ;
        } else {
            $processosAluno = $this->matricula->processosAluno($processoAluno)->get();
        }


        $tllClassesInseridas = 0;
        foreach ($processosAluno as $processo) {

            $dcc = $this->fh_disciplinas_cursos_classes()->where('classes.id', $processo->it_idClasse)
                ->where('cursos.id', $processo->it_idCurso)
                ->where('disciplinas.id', $id_disciplina)
                ->first();
            $turma = Turma::find($processo->it_idTurma);
            // dd($turma);
            if ($dcc) {

                // 
                $tllClassesInseridas++;
                array_push($classes, $processo->vc_classe);
            }
        }
        return $classes;
    }
    public function cadastrar(Request $request, $slug_turma)
    {

        $turma = fh_turmas_slug($slug_turma)->first();

        $alunos = fha_turma_alunos($slug_turma);
        $disciplinas_cursos_classes = fh_disciplinas_cursos_classes()
            ->where('cursos.id', $turma->it_idCurso)
            ->where('classes.id', $turma->it_idClasse)->
            select('disciplinas.vc_acronimo', 'disciplinas_cursos_classes.*')->get();
// dd($request);
        $id_curso = $turma->it_idCurso;
        $id_classe = $turma->it_idClasse;
        $it_idAnoLectivo = $turma->it_idAnoLectivo;
        foreach ($alunos as $aluno) {
            foreach ($disciplinas_cursos_classes as $dcc) {
                if (isset($request["idDCC_$dcc->id" . "_" . "$aluno->processo"])) {
                    if($aluno->processo==2){
                        // dd($request["idDCC_$dcc->id" . "_" . "$aluno->processo"],$aluno->processo,$dcc->id);

                    }
                    $this->updateNota($aluno->processo, $request["idDCC_$dcc->id" . "_" . "$aluno->processo"], $id_classe, $it_idAnoLectivo, $dcc->id, $turma->id);
                }
            }
        }

        return redirect()->back()->with('feedback', ['type' => 'success', 'sms' => "Notas cadastradas com sucesso"]);


        // if ($tllClassesInseridas) {
        //     
        // } {
        //     return redirect()->back()->with('error', '1');
        // }
    }
    public function dividirNota($nota, $divisor)
    {
        return $nota / $divisor;
    }

    public function gerarPencentualDecimal($number)
    {
        $percentualDecimal = $number / 100;
        return $percentualDecimal;
    }
    public function eliminarElement($element, $collection)
    {

        $keys = $collection->keys();
        $keys->all();
        foreach ($keys as $key) {
            if ($collection[$key] == $element) {
                $collection = $collection->except([$key]);
                return $collection;
            }
        }
    }

    public function gerarNotasTrimestral($nota)
    {
        $collection = collect([35, 40, 25]);

        $nEscolhido = $collection->random();
        $percentualDecimal = $this->gerarPencentualDecimal($nEscolhido);
        $fl_nota1 = $nota * $percentualDecimal;
        $collection = $this->eliminarElement($nEscolhido, $collection);
        $collection->all();


        $nEscolhido = $collection->random();
        $percentualDecimal = $this->gerarPencentualDecimal($nEscolhido);
        $fl_nota2 = $nota * $percentualDecimal;
        $collection = $this->eliminarElement($nEscolhido, $collection);




        $nEscolhido = $collection->random();
        $percentualDecimal = $this->gerarPencentualDecimal($nEscolhido);
        $fl_mac = $nota * $percentualDecimal;

        $notaComplementar = ($nota * 3 - $nota) / 3;
        $fl_nota1 += $notaComplementar;
        $fl_nota2 += $notaComplementar;
        $fl_mac += $notaComplementar;

        return [floor($fl_nota1), floor($fl_nota2 + 1), floor($fl_mac)];
    }
    public function updateNota($processo, $nota, $id_classe, $id_anoLectivo, $id_CCD, $it_idTurma)
    {

        $trimestre = "I";
        $aluno = fha_aluno_processo($processo);

        while ($trimestre != "IIII") {


            $linha = fh_notas()
                ->where('alunnos.processo', $processo)
                ->where('notas.id_classe', $id_classe)
                ->where('notas.id_disciplina_curso_classe', $id_CCD)
                ->where('notas.id_turma', $it_idTurma)
                ->where('notas.vc_tipodaNota', $trimestre)
                ->where('notas.id_ano_lectivo', $id_anoLectivo)->count();
                // dd(   $linha );
            if ($linha) {
                fh_notas()
                    ->where('alunnos.processo', $processo)
                    ->where('notas.id_classe', $id_classe)
                    ->where('notas.id_disciplina_curso_classe', $id_CCD)
                    ->where('notas.id_turma', $it_idTurma)
                    ->where('notas.vc_tipodaNota', $trimestre)
                    ->where('notas.id_ano_lectivo', $id_anoLectivo)
                    ->update([
                        'fl_nota1' => $nota,
                        'fl_nota2' => $nota,
                        'fl_mac' => $nota,
                        'fl_media' => $nota,

                    ]);
                    // if($processo==2 && $id_CCD=3){
                    // dd(  fh_notas()
                    // ->where('alunnos.processo', $processo)
                    // ->where('notas.id_classe', $id_classe)
                    // ->where('notas.id_disciplina_curso_classe', $id_CCD)
                    // ->where('notas.id_turma', $it_idTurma)
                    // ->where('notas.vc_tipodaNota', $trimestre)
                    // ->where('notas.id_ano_lectivo', $id_anoLectivo)->get());
                    // }
            } else {
                Nota::create([
                    'id_aluno' => $aluno->id,
                    'id_classe' => $id_classe,
                    'id_disciplina_curso_classe' => $id_CCD,
                    'vc_tipodaNota' => $trimestre,
                    'id_turma' => $it_idTurma,
                    'id_ano_lectivo' => $id_anoLectivo,
                    'fl_nota1' => $nota,
                    'fl_nota2' => $nota,
                    'fl_mac' => $nota,
                    'fl_media' => $nota,
                ]);
            }
            $trimestre = $trimestre . 'I';
            $this->Logger->Log('info', "Actualizou nota seca do  $trimestre trimestre para o aluno com processo  $processo  ");
        }

    }
    public function acharDivisor($classe)
    {
        $contClasse = 0;
        for ($cont = $classe; $cont >= 10; $cont--) {
            $contClasse = $contClasse + 1;
        }
        return $contClasse * 3;
    }
    public function alunoProcesso($processo, $estudando)
    {


        try {
            if ($estudando == 0) {
                $response['processosAluno'] = $this->matricula->processosAluno($processo)->first();
                $response['disciplinas'] = $this->fh_disciplinas_cursos_classes()->where('disciplinas_cursos_classes.it_curso', $response['processosAluno']->it_idCurso)
                    ->select("disciplinas.vc_nome", "disciplinas.id")
                    ->distinct()
                    ->pluck("disciplinas.vc_nome", "disciplinas.id");
                return response()->json($response);
            } else {
                $ultimoProcesso = $this->matricula->processosAluno($processo)->first();
                $limit = $ultimoProcesso->vc_classe - 10;
                $response['processosAluno'] = $this->matricula->processosAluno($processo)->limit($limit)->get()->max();
                $response['disciplinas'] = array();

                for ($i = 10; $i <= $ultimoProcesso->vc_classe - 1; $i++) {
                    $response['disciplinas']["classe$i"] = $this->fh_disciplinas_cursos_classes()->where('disciplinas_cursos_classes.it_curso', $response['processosAluno']->it_idCurso)
                        ->where('classes.vc_classe', $i)
                        ->select("disciplinas.vc_nome", "disciplinas.id")
                        ->pluck("disciplinas.vc_nome", "disciplinas.id");
                    // array_push($response['disciplinas'], $r);
                }
                return response()->json($response);
            }
        } catch (Exception $ex) {
            return response()->json($ex->getMessage());
        }
    }
    //
    public function obterDisciplinas($classes, $icurs)
    {
    }
}