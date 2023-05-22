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
 
    public  function get_DCC()
    {
        $datas = DB::table('disciplinas_cursos_classes')
            ->join('disciplinas', 'disciplinas_cursos_classes.it_disciplina', '=', 'disciplinas.id')
            ->join('cursos', 'disciplinas_cursos_classes.it_curso', '=', 'cursos.id')
            ->join('classes', 'disciplinas_cursos_classes.it_classe', '=', 'classes.id')
            ->where([['disciplinas_cursos_classes.it_estado_dcc', 1]])
            ->select('disciplinas_cursos_classes.*', 'disciplinas.vc_nome', 'disciplinas.vc_acronimo', 'cursos.vc_nomeCurso', 'classes.vc_classe');

        return $datas;
    }
    public function inserir($id_turma)
    {



        $response['id_turma'] = $id_turma;
        $response['turma'] = Turma::find($id_turma);
        $curso = Curso::find($response['turma']->it_idCurso);
        $response['disciplinas'] = $this->pegarDisciplinas($id_turma);

        $orderDisciplinas = $this->orderDisciplinas($curso->vc_shortName, $response['turma']->vc_classeTurma);
        // dd($orderDisciplinas,  $response['disciplinas'] );
        $response['alunos'] = $this->turma->alunos($id_turma);
        // dd($orderDisciplinas->count());
        if ($orderDisciplinas->count()) {
            $response['disciplinas'] = $this->orgDisciplinas($orderDisciplinas, $response['disciplinas']);
            // dd(    $response['disciplinas'] );
        } else {
            $response['disciplinas'] =   $response['disciplinas'];
            return view('admin.nota-seca.inserir.indexSemFormato', $response);
        }


        //   dd( $disciplinas);


        return view('admin.nota-seca.inserir.index', $response);
    }
    public function orgDisciplinas($padraoDisciplinas, $dccs)
    {
        $cont = 0;
        $novaOrdem = collect();
        foreach ($dccs as $dcc) {

            $result = $padraoDisciplinas->where("disc", $dcc->vc_acronimo);

            if ($result->count()) {

                $novaOrdem->push([
                    "id" => $dcc->id,
                    "it_disciplina" => $dcc->it_disciplina,
                    "it_curso" => $dcc->it_curso,
                    "it_classe" => $dcc->it_classe,
                    "it_estado_dcc" => $dcc->it_estado_dcc,
                    "created_at" => $dcc->created_at,
                    "updated_at" => $dcc->updated_at,
                    "vc_nome" => $dcc->vc_nome,
                    "vc_acronimo" => $dcc->vc_acronimo,
                    "vc_nomeCurso" => $dcc->vc_nomeCurso,
                    "vc_classe" => $dcc->vc_classe,
                    "position" => $result[$result->keys()[0]]["position"]

                ]);
                $novaOrdem->all();
                $cont++;
            }
        }



        $sorted = $novaOrdem->sortBy([
            ["position", "asc"],

        ]);
        $sorted->values()->all();
        return $sorted;
    }
    public function orderDisciplinas($abbrCurso, $classe)
    {
        if ($abbrCurso == "Informática" && $classe == 11) {
            $discOrg = [
                ['disc' => 'L. PORT', 'position' => 1],
                ['disc' => 'L. ING', 'position' => 2],
                ['disc' => 'F.A.I.', 'position' => 3],
                ['disc' => 'MAT', 'position' => 4],
                ['disc' => 'QUI', 'position' => 5],
                ['disc' => 'FÍS', 'position' => 6],
                ['disc' => 'ELECTR', 'position' => 7],
                ['disc' => 'EMP', 'position' => 8],
                ['disc' => 'T.L.P.', 'position' => 9],
                ['disc' => 'S.E.A.C.', 'position' => 10],
                ['disc' => 'T.I.C.', 'position' => 11],
                ['disc' => 'DES. TÉC.', 'position' => 12]

            ];
        } else if ($abbrCurso == "Informática" && $classe == 10) {
            // dd("ola");
            $discOrg = [
                ['disc' => 'L. PORT', 'position' => 1],
                ['disc' => 'L. ING', 'position' => 2],
                ['disc' => 'F.A.I.', 'position' => 3],
                ['disc' => 'MAT', 'position' => 4],
                ['disc' => 'QUI', 'position' => 5],
                ['disc' => 'FÍS', 'position' => 6],
                ['disc' => 'ELECTR', 'position' => 7],
                ['disc' => 'EMP', 'position' => 8],
                ['disc' => 'T.L.P.', 'position' => 9],
                ['disc' => 'S.E.A.C.', 'position' => 10],
                ['disc' => 'T.I.C.', 'position' => 11]


            ];
        } else if ($abbrCurso == "Informática" && $classe == 12) {
            // dd($abbrCurso == "Informática" && $classe == 12);
            $discOrg = [
                ['disc' => 'MAT', 'position' => 1],
                ['disc' => 'FÍS', 'position' => 2],
                ['disc' => 'O.G.I.', 'position' => 3],
                ['disc' => 'EMP', 'position' => 4],
                ['disc' => 'T.L.P.', 'position' => 5],
                ['disc' => 'T.R.E.I.', 'position' => 6],
                ['disc' => 'S.E.A.C.', 'position' => 7],
                ['disc' => 'PROJ. TECN.', 'position' => 8],
                ['disc' => 'ING. TEC', 'position' => 9],

            ];
        } else if ($abbrCurso == "Electrónica e Telecomunicações" && $classe == 10) {
            $discOrg = [
                ['disc' => 'L. PORT', 'position' => 1],
                ['disc' => 'L. ING', 'position' => 2],
                ['disc' => 'F.A.I.', 'position' => 3],
                ['disc' => 'MAT', 'position' => 4],
                ['disc' => 'QUI', 'position' => 5],
                ['disc' => 'FÍS', 'position' => 6],
                ['disc' => 'INF', 'position' => 7],
                ['disc' => 'EMP', 'position' => 8],
                ['disc' => 'E. ELECTR.', 'position' => 9],
                ['disc' => 'TEC. TELECOM.', 'position' => 10],
                ['disc' => 'P.O.L.', 'position' => 11],


            ];
        } else if ($abbrCurso == "Electrónica e Telecomunicações" && $classe == 11) {
            $discOrg = [
                ['disc' => 'L. PORT', 'position' => 1],
                ['disc' => 'L. ING', 'position' => 2],
                ['disc' => 'F.A.I.', 'position' => 3],
                ['disc' => 'MAT', 'position' => 4],
                ['disc' => 'QUI', 'position' => 5],
                ['disc' => 'FÍS', 'position' => 6],
                ['disc' => 'INF', 'position' => 7],
                ['disc' => 'EMP', 'position' => 8],
                ['disc' => 'DES. TÉC.', 'position' => 9],
                ['disc' => 'E. ELECTR.', 'position' => 10],
                ['disc' => 'SIST. DIG.', 'position' => 11],
                ['disc' => 'TEC. TELECOM.', 'position' => 12],
                ['disc' => 'P.O.L.', 'position' => 13],

            ];
        } else if ($abbrCurso == "Electrónica e Telecomunicações" && $classe == 12) {
            $discOrg = [
                ['disc' => 'MAT', 'position' => 1],
                ['disc' => 'FÍS', 'position' => 2],
                ['disc' => 'O.G.I.', 'position' => 3],
                ['disc' => 'EMP', 'position' => 4],
                ['disc' => 'E. ELECTR.', 'position' => 5],
                ['disc' => 'SIST. DIG.', 'position' => 6],
                ['disc' => 'TELCOM', 'position' => 7],
                ['disc' => 'TEC. TELECOM.', 'position' => 8],
                ['disc' => 'P.O.L.', 'position' => 9],
                ['disc' => 'PROJ. TECN.', 'position' => 10],
                ['disc' => 'ING. TEC', 'position' => 11],
            ];
        } else if ($abbrCurso == "Info e Sistemas Multimédia" && $classe == 10) {

            $discOrg = [
                ['disc' => 'L. PORT', 'position' => 1],
                ['disc' => 'L. ING', 'position' => 2],
                ['disc' => 'F.A.I.', 'position' => 3],
                ['disc' => 'MAT', 'position' => 4],
                ['disc' => 'INF', 'position' => 5],
                ['disc' => 'FÍS', 'position' => 6],
                ['disc' => 'EMP', 'position' => 7],
                ['disc' => 'DES. TÉC.', 'position' => 8],
                ['disc' => 'SIST . INF.', 'position' => 9],
                ['disc' => 'D.C.A.', 'position' => 10],
                ['disc' => 'TEC. MULT', 'position' => 11],


            ];
        } else if ($abbrCurso == "Info e Sistemas Multimédia" && $classe == 11) {
            $discOrg = [
                ['disc' => 'L. PORT', 'position' => 1],
                ['disc' => 'L. ING', 'position' => 2],
                ['disc' => 'F.A.I.', 'position' => 3],
                ['disc' => 'MAT', 'position' => 4],
                ['disc' => 'INF', 'position' => 5],
                ['disc' => 'FÍS', 'position' => 6],
                ['disc' => 'EMP', 'position' => 7],

                ['disc' => 'SIST . INF.', 'position' => 8],
                ['disc' => 'D.C.A.', 'position' => 9],
                ['disc' => 'TEC. MULT', 'position' => 10],


            ];
        } else if ($abbrCurso == "Info e Sistemas Multimédia" && $classe == 12) {
            $discOrg = [
                ['disc' => 'MAT', 'position' => 1],
                ['disc' => 'FÍS', 'position' => 2],
                ['disc' => 'O.G.I.', 'position' => 3],
                ['disc' => 'EMP', 'position' => 4],
                ['disc' => 'SIST . INF.', 'position' => 5],
                ['disc' => 'D.C.A.', 'position' => 6],
                ['disc' => 'TEC. MULT', 'position' => 7],
                ['disc' => 'P.P.M.', 'position' => 8],
                ['disc' => 'PROJ. TECN.', 'position' => 9],
                ['disc' => 'ING. TEC', 'position' => 10],
            ];
        } else if ($classe == 13) {
            $discOrg = [
                ['disc' => 'PROJ. TECN.', 'position' => 1],
                ['disc' => 'P.A.P.', 'position' => 2],
                ['disc' => 'E.C.S.', 'position' => 3]
            ];
        } else {
            $discOrg = collect();
        }
        return collect($discOrg);
    }
    public function pegar($id_turma)
    {
    }
    public function pegarDisciplinas($id_turma)
    {
        $id_curso = Turma::find($id_turma)->it_idCurso;
        $id_classe = Turma::find($id_turma)->it_idClasse;
        $disciplinas = $this->get_DCC()->where('classes.id',     $id_classe)
            ->where('cursos.id',  $id_curso)->get();
        return     $disciplinas;
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
            $dcc = $this->get_DCC()->where('classes.id',    $classe->id)
                ->where('disciplinas.id',   $nota->disciplina)
                ->where('cursos.id', $turma->it_idCurso)->first();
            $this->updateNota($nota->processo, $nota,  $turma->it_idClasse,  $turma->it_idAnoLectivo,   $dcc->id, $turma->id);
        }
        // $divisor = $this->acharDivisor($nota->classe);
        // $mts = $this->dividirNota($nota->nota, $divisor);
    }
    public function quantosClasses($id_disciplina, $id_turma, $estado, $processoAluno, $classe)
    {
        $classes = array();
        if ($estado == 1) {
            $processosAluno = $this->matricula->processosAluno($processoAluno)->where('classes.vc_classe', '<', $classe)->get();;
        } else {
            $processosAluno = $this->matricula->processosAluno($processoAluno)->get();
        }


        $tllClassesInseridas = 0;
        foreach ($processosAluno as $processo) {

            $dcc = $this->get_DCC()->where('classes.id',    $processo->it_idClasse)
                ->where('cursos.id', $processo->it_idCurso)
                ->where('disciplinas.id',   $id_disciplina)
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
    public function cadastrar(Request $request, $id_turma)
    {

        $disciplinas = $this->pegarDisciplinas($id_turma);
        $alunos = $this->turma->alunos($id_turma);
        $turma = Turma::find($id_turma);
        $id_curso = $turma->it_idCurso;
        $id_classe = $turma->it_idClasse;
        $it_idAnoLectivo = $turma->it_idAnoLectivo;
        foreach ($alunos as $aluno) {
            foreach ($disciplinas as $item) {

                if (isset($request["idDCC_$item->id" . "_" . "$aluno->id_aluno"])) {
                    $this->updateNota($aluno->id_aluno, $request["idDCC_$item->id" . "_" . "$aluno->id_aluno"],   $id_classe,  $it_idAnoLectivo,  $item->id, $id_turma);
                }
            }
        }

        return redirect()->back()->with('status', '1');

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
        return   $percentualDecimal;
    }
    public function eliminarElement($element, $collection)
    {

        $keys = $collection->keys();
        $keys->all();
        foreach ($keys as $key) {
            if ($collection[$key] == $element) {
                $collection =  $collection->except([$key]);
                return  $collection;
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

        return [floor($fl_nota1),floor($fl_nota2+1),floor($fl_mac)];
    }
    public function updateNota($processo, $nota, $id_classe, $id_anoLectivo, $id_CCD, $it_idTurma)
    {

        $trimestre = "I";


        while ($trimestre != "IIII") {
            $notas = $this->gerarNotasTrimestral($nota);


            $mediana = (($notas[0] + $notas[1] + $notas[0]) / 3 );
            $linha =  Nota::where('id_aluno', $processo)
                ->where('id_classe', $id_classe)
                ->where('it_disciplina', $id_CCD)
                ->where('id_turma', $it_idTurma)
                ->where('vc_tipodaNota', $trimestre)
                ->where('id_ano_lectivo', $id_anoLectivo)->count();
            if ($linha) {
                Nota::where('id_aluno', $processo)
                    ->where('id_classe', $id_classe)
                    ->where('it_disciplina', $id_CCD)
                    ->where('vc_tipodaNota', $trimestre)
                    ->where('id_ano_lectivo', $id_anoLectivo)
                    ->where('id_turma', $it_idTurma)
                    ->update([
                        'fl_nota1' => $nota,
                        'fl_nota2' =>  $nota,
                        'fl_mac' => $nota,
                        'fl_media' => $nota,

                    ]);
            } else {
                Nota::create([
                    'id_aluno' => $processo,
                    'id_classe' => $id_classe,
                    'it_disciplina' => $id_CCD,
                    'vc_tipodaNota' => $trimestre,
                    'id_turma' => $it_idTurma,
                    'id_ano_lectivo' => $id_anoLectivo,
                    'fl_nota1' => $nota,
                    'fl_nota2' => $nota,
                    'fl_mac' =>$nota,
                    'fl_media' =>$nota,
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
                $response['disciplinas'] = $this->get_DCC()->where('disciplinas_cursos_classes.it_curso', $response['processosAluno']->it_idCurso)
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
                    $response['disciplinas']["classe$i"] = $this->get_DCC()->where('disciplinas_cursos_classes.it_curso', $response['processosAluno']->it_idCurso)
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
