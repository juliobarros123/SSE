<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Alunno;
use Illuminate\Http\Request;
use App\Models\Disciplinas;
use App\Models\Turma;
use App\Models\Classe;
use App\Models\Matricula;
use App\Models\Nota;
use App\Models\NotaRecurso;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Logger;

class NotaRecursoController extends Controller
{
    //
    private $matricula;
    private $turma;
    private $Logger;
    public $retorno = [
        'status' => 1,
        'message' => 'Turma Indisponível',
    ];


    public function loggerData($mensagem)
    {
        $dados_Auth = Auth::user()->vc_primemiroNome . ' ' . Auth::user()->vc_apelido . ' Com o nivel de ' . Auth::user()->vc_tipoUtilizador . ' ';
        $this->Logger->Log('info', $dados_Auth . $mensagem);
    }
    public function __construct()
    {
        $this->Logger = new Logger();
        $this->matricula = new Matricula();
        $this->turma = new Turma();
    }
    public function index()
    {
        $response['notas'] = fh_notas_recurso()
            ->orderBy('nota_recursos.id', 'asc')
            ->get();
        // dd(  $response['notas']);
        return view('admin.nota-recurso.index', $response);
    }
    public function eliminar($slug)
    {
        try {
            NotaRecurso::where('slug', $slug)->delete();
            // dd($id);
            $this->Logger->Log('info', 'Eliminou nota recurso ');
            return redirect()->back()->with('feedback', ['type' => 'success', 'sms' => 'Nota eliminada']);
        } catch (Exception $ex) {
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado']);



        }

    }
    public function inserir()
    {
        $response['disciplinas'] = fh_disciplinas()->get();
        return view('admin.nota-recurso.inserir.index', $response);
    }
    public function cadastrar(Request $req)
    {
        // dd($req);
        // dd($req);
        $keys = $req->keys();
        $processos = array();

        foreach ($keys as $key) {
            $arraySplitkey = explode('-', $key);


            if ($arraySplitkey[0] == "processo") {


                if (isset($req["processo-$arraySplitkey[1]"])) {
                    $aluno = fh_alunos()->where('alunnos.processo', $arraySplitkey[1])->first();
                    // $matricula = fh_matriculas()->where('alunnos.processo', $arraySplitkey[1])->first();
                    // dd(  $matricula);

                    $dcc = fh_disciplinas_cursos_classes()
                        ->where('disciplinas.id', $req->id_disciplina)
                        ->where('cursos.id', $aluno->id_curso)->first();
                    // dd($dcc);
                    if ($dcc) {

                        NotaRecurso::create([
                            'id_aluno' => $aluno->id,
                            'id_disciplina' => $req->id_disciplina,
                            'nota' => ($req["notaProcesso-$arraySplitkey[1]"]),
                            'id_cabecalho' => Auth::User()->id_cabecalho
                        ]);
                        $this->Logger->Log('info', "Adicionou nota recurso para o aluno com processo $arraySplitkey[1]");
                    } else {
                        array_push($processos, $arraySplitkey[1]);
                    }
                }
            }
        }
        if ($processos) {
            return redirect()->back()->with('processos', $processos);
        } else {
            return redirect()->back()->with('status', 1);
        }
    }

    // $divisor = $this->acharDivisor($nota->classe);
    // $mts = $this->dividirNota($nota->nota, $divisor);
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
    public function updateNota($processo, $nota, $id_classe, $id_anoLectivo, $id_CCD, $it_idTurma)
    {

        $trimestre = "I";


        while ($trimestre != "IIII") {




            $linha = Nota::where('id_aluno', $processo)
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
                        'fl_nota2' => $nota,
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
                    'fl_mac' => $nota,
                    'fl_media' => $nota,
                ]);
            }
            $this->Logger->Log('info', 'Actualizou nota recurso ');
            $trimestre = $trimestre . 'I';
        }
    }
    public function alunoProcesso($processo)
    {


        try {
            // if ($estudando == 0) {
            $response['processosAluno'] = fh_matriculas()->where('alunnos.processo', $processo)->first();
            // $response['disciplinas'] = $this->fh_disciplinas_cursos_classes()->where('disciplinas_cursos_classes.it_curso', $response['processosAluno']->it_idCurso)
            //     ->select("disciplinas.vc_nome", "disciplinas.id")
            //     ->distinct()
            //     ->pluck("disciplinas.vc_nome", "disciplinas.id");
            // return response()->json($response);
            // } else {
            //     $ultimoProcesso = $this->matricula->processosAluno($processo)->first();
            //     $limit = $ultimoProcesso->vc_classe - 10;
            //     $response['processosAluno'] = $this->matricula->processosAluno($processo)->limit($limit)->get()->max();
            //     $response['disciplinas'] = array();

            //     for ($i = 10; $i <= $ultimoProcesso->vc_classe - 1; $i++) {
            //         $response['disciplinas']["classe$i"] = $this->fh_disciplinas_cursos_classes()->where('disciplinas_cursos_classes.it_curso', $response['processosAluno']->it_idCurso)
            //             ->where('classes.vc_classe', $i)
            //             ->select("disciplinas.vc_nome", "disciplinas.id")
            //             ->pluck("disciplinas.vc_nome", "disciplinas.id");
            //         // array_push($response['disciplinas'], $r);
            //     }
            return response()->json($response);
            // }
        } catch (\Exception $ex) {
            return response()->json($ex->getMessage());
        }
    }
}