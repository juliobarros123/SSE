<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AnoLectivo;
use App\Models\Curso;
use App\Models\Turma;
use App\Models\Alunno;
use App\Models\Nota;
use App\Models\Disciplinas;
use App\Models\Classe;
use App\Models\Logger;
use Illuminate\Support\Facades\DB;
use App\Models\Cabecalho;
use App\Http\Controllers\Admin\NotaDinamca;
use App\Models\Matricula;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Response;
use App\Models\CandeadoPauta;
use App\Models\CadeadoGeralPauta;

class PautaFinalController extends Controller
{
    private $Logger;
    private $notaDinamca;
    private $notas;
    protected $turma;
    protected $curso;
    public function __construct(Nota $notas, Turma $turma, Curso $curso)
    {
        $this->Logger = new Logger();

        $this->notas = $notas;
        $this->turma = $turma;
        $this->curso = $curso;
    }
    public function pegarDisciplinas($id_turma)
    {
        $id_curso = Turma::find($id_turma)->it_idCurso;
        $id_classe = Turma::find($id_turma)->it_idClasse;
        $disciplinas = $this->fh_disciplinas_cursos_classes()->where('classes.id', $id_classe)
            ->where('cursos.id', $id_curso);
        return $disciplinas;
    }

    public function gerar($slug_turma, $formato)
    {
        try {
            // dd($slug_turma);
            $turma = fh_turmas_2()->where('turmas.slug', $slug_turma)->first();

            if ($turma):

                //   dd( $turma->id);
                $turma_alunos = fha_turma_alunos($slug_turma);
                $data['disciplinas'] = fha_turmas_disciplinas_dcc($turma->id);

                //  dd( $disciplinas );
                $data['turma'] = $turma;
                // dd(  $data['turma']);
                $data['cabecalho'] = fh_cabecalho();
                $data['alunos'] = $turma_alunos;

                if(fh_cabecalho()->vc_tipo_escola=="Técnico"){
                    $data['alunos'] = $turma_alunos->take(7);

                }
                
                // dd( $data['turma_alunos']);
                // dd( $data['cabecalho']);
                // /*   $data['bootstrap'] = file_get_contents('css/listas/bootstrap.min.css');
                $data['css'] = file_get_contents('css/lista/style-2.css');
                // Dados para a tabela
                $data['titulo'] = "Pauta Anual" . $data['turma']->vc_nomedaTurma . '-' . $data['turma']->vc_classe . 'ª Classe' . '-' . $data['turma']->vc_shortName . '-' . $data['turma']->ya_inicio . '_' . $data['turma']->ya_fim;
                $mpdf = new \Mpdf\Mpdf([
                    'mode' => 'utf-8',
                    'margin_top' => 5,
                    'format' => "$formato-L"
                ]);
                // dd(   $data['titulo']);
                $mpdf->SetFont("arial");
                $mpdf->setHeader();
                $this->Logger->Log('info', 'Imprimiu Pauta Anual com o título ' . $data['titulo']);
                // dd($response);
                // if ( $data['turma']->vc_classe <= 9 && $data['cabecalho']->vc_tipo_escola == "Geral") {
                //     $html = view("admin.pdfs.pauta.anual", $data);
                // } else if($data['turma']->vc_classe >=10 && $data['cabecalho']->vc_tipo_escola == "Técnico")  {
                if ($turma->vc_classe == 13) {
                    $html = view("admin.pdfs.pauta.tecnico.anual_13", $data);
                } else {
                    // dd("1");
                    $html = view("admin.pdfs.pauta.tecnico.anual", $data);

                }


                // } 
                ini_set("pcre.backtrack_limit", "2000000");
                $mpdf->writeHTML($html);

                $mpdf->Output("Pauta final " . $data['titulo'] . ".pdf", "I");
            else:
                return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado']);


            endif;
            // return view('admin.pdfs.pauta_final.index',$response);
        } catch (Exception $ex) {
            dd($ex);
            return redirect()->back()->with('error', 1);
        }
    }






    public function minhaPauta($processo, $id_turma)
    {
        try {

            $response['disciplinas'] = $this->pegarDisciplinas($id_turma)
                ->orderBy('disciplinas.id', 'asc')
                ->select('disciplinas.*')
                ->get();
            // $response['disciplinas'] = $this->pegarDisciplinas($id_turma)
            //     ->orderBy('disciplinas.id', 'asc')
            //     ->select('disciplinas.*')
            //     ->get();

            // dd(    $response['disciplinas']);
            // $response['disciplinas']=$this->turma->turmasDisciplinas($id_turma)->get();
            // dd(   $response['disciplinas']);
            // $response['disciplinas_terminas'] = $this->turma->disciplinas_terminas($id_turma)->get();
            $response['disciplinas_terminas'] = $this->turma->disciplinas_terminas($id_turma)->get();


            $response['alunos'] = $this->turma->alunos($id_turma);
            $response['alunos'] = $response['alunos']->where('id_aluno', $processo);
            //    $response['alunos']=   $response['alunos']->where()
            //   dd($id_turma);
            $response['notas'] = $this->notas->notasGeral($id_turma)->get();
            // dd($response['notas']);
            // dd(  $response['notas']);
            //  dd($response['notas']->where('id_disciplina',25)->where('vc_tipodaNota','I')->where('id_aluno',13381)->first()->fl_media);
            $response['cabecalho'] = Cabecalho::find(1);
            // dd($response['cabecalho']);
            $response['detalhes_turma'] = $this->turma->detalhes_turma($id_turma);
            // dd( $response['detalhes_turma']);
            $response['disciplinas'] = $this->curso->disciplinas($response['detalhes_turma']->it_idCurso)
                ->distinct()
                ->where('classes.vc_classe', '<=', $response['detalhes_turma']->vc_classe)
                ->orderBy('disciplinas.id', 'asc')
                ->select('disciplinas.*')
                ->get();
            //    $response["bootstrap"] = file_get_contents("css/pauta/bootstrap.min.css");
            //    $response["css"] = file_get_contents("css/pauta/style.css");
            //    $response['titulo']=$response['detalhes_turma']->vc_nomedaTurma.'-'.$response['detalhes_turma']->vc_classe.'ª Classe'.'-'.$response['detalhes_turma']->vc_shortName.'-'.$response['detalhes_turma']->ya_inicio . '_' . $response['detalhes_turma']->ya_fim;
            //    $mpdf = new \Mpdf\Mpdf(['format' => 'A1-L']);

            //    $mpdf->SetFont("arial");
            //    $mpdf->setHeader();
            //    $this->Logger->Log('info', 'Imprimiu Pauta Final ');
            //    $html = view("admin/pdfs/pauta_final/aluno", $response);

            //    $mpdf->writeHTML($html);

            $response['notas'] = $this->gerarVetorNotas($response);
            // dd($response['notas']);
            return $response;
            //    $mpdf->Output("Pauta final ".$response['titulo'].".pdf", "I");
            // return view('admin.pdfs.pauta_final.index',$response);
        } catch (Exception $ex) {
            dd($ex);
            return redirect()->back()->with('error', 1);
        }
    }


    public function gerarVetorNotas($dados)
    {
        // dd($dados);


        $disciplinas = $dados['disciplinas'];

        $disciplinas_terminas = $dados['disciplinas_terminas'];
        $detalhes_turma = $dados['detalhes_turma'];


        $processos = [];
        ;
        $contador = 1;
        $contadorDisciplinas = 0;
        $qtDisciplinaNegativa = 0;
        $qtMasculinosTransitados = array();
        $qtFemininoTransitados = array();
        $qtMasculinosNTransitados = array();
        $qtFemininoNTransitados = array();
        $somaAcs = 0;
        $ttlReprovados = 0;
        $disciplinasNegativas = array();
        ;
        $disciplinasNotas = array();
        ;
        $disciplinasPositivas = array();
        $dataOutrosAnos = array();
        $arrayNotasClasses = array();
        $disciplinasNegativasIndividual = array();

        $mft = "sem";
        $mfd = "sem";
        $cfd = "";
        foreach ($dados['alunos'] as $aluno) {
            if (!in_array($aluno->id, $processos)) {




                foreach ($dados['disciplinas'] as $disciplina) {
                    $cfd = "";
                    // if($disciplina->vc_acronimo=="EMP"){
                    //     dd($cfd);
                    //    }
                    // $disciplinasNotas->push(collect($disciplina->vc_acronimo));
                    // dd($disciplinasNotas[$contadorDisciplinas]);
                    $rec = notaRecurso($aluno->id, $disciplina->id);

                    if (!temDCCNestaClasse($disciplina->id, $detalhes_turma->it_idClasse, $detalhes_turma->it_idCurso)) {
                        $cfd = buscarCDF($aluno->id, $disciplina->id);
                        if ($disciplina->vc_acronimo == 'T.R.E.I') {
                            // dd($cfd,"O",$disciplina);

                        }
                        if ("$cfd" != "null" && $cfd < 10) {


                            if ($rec != -1 && $rec < 10) {
                                array_push($disciplinasNegativasIndividual, ['disciplina' => $disciplina->vc_acronimo, 'terminal' => 1, 'nota' => $rec, 'id_aluno' => $aluno->id, 'tipo_nota' => 'cfd']);
                            } else if ($rec == -1) {

                                array_push($disciplinasNegativasIndividual, ['disciplina' => $disciplina->vc_acronimo, 'terminal' => 1, 'nota' => $cfd, 'id_aluno' => $aluno->id, 'tipo_nota' => 'cfd']);
                            }
                        }
                        if ($rec != -1) {
                            array_push(
                                $disciplinasNotas,
                                array(
                                    $disciplina->vc_acronimo => array(
                                        [

                                            "cfd" => $cfd,
                                            "rec" => $rec
                                        ]
                                    )
                                )

                            );
                        } else {
                            array_push(
                                $disciplinasNotas,
                                array(
                                    $disciplina->vc_acronimo => array(
                                        [

                                            "cfd" => $cfd

                                        ]
                                    )
                                )

                            );
                        }
                    } else {

                        $mat1 = isset($dados['notas']->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'I')->where('id_aluno', $aluno->id)->first()->fl_media) ? $dados['notas']->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'I')->where('id_aluno', $aluno->id)->first()->fl_media : 0;
                        $mat2 = isset($dados['notas']->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'II')->where('id_aluno', $aluno->id)->first()->fl_media) ? $dados['notas']->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'II')->where('id_aluno', $aluno->id)->first()->fl_media : 0;
                        $mat3 = isset($dados['notas']->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'III')->where('id_aluno', $aluno->id)->first()->fl_media) ? $dados['notas']->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'III')->where('id_aluno', $aluno->id)->first()->fl_media : 0;
                        $mat1 = round($mat1, 0, PHP_ROUND_HALF_UP);
                        $mat2 = round($mat2, 0, PHP_ROUND_HALF_UP);
                        $mat3 = round($mat3, 0, PHP_ROUND_HALF_UP);
                        $mft = isset($dados['notas']->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'III')->where('id_aluno', $aluno->id)->first()->fl_media) ?
                            $dados['notas']->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'III')->where('id_aluno', $aluno->id)->first()->fl_nota1 + $dados['notas']->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'III')->where('id_aluno', $aluno->id)->first()->fl_mac : 0;
                        if (($detalhes_turma->vc_classe == 12 || $detalhes_turma->vc_classe == 13)) {
                            if (isset($dados['notas']->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'III')->where('id_aluno', $aluno->id)->first()->fl_nota2)) {
                                $exame = $dados['notas']->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'III')->where('id_aluno', $aluno->id)->first()->fl_nota2;
                            } else {
                                $exame = 0;
                            }
                        }
                        $mft = round(($mft / 2), 0, PHP_ROUND_HALF_UP);
                        $mfd = round((($mat1 + $mat2 + $mft) / 3), 0, PHP_ROUND_HALF_UP);
                        // dd($disciplinas_terminas);
                        if ($disciplinas_terminas->where('id', $disciplina->id)->count()) {
                            $dataOutrosAnos = mediaDosAnos($aluno->id, $disciplina->id, "''", $detalhes_turma->it_idClasse);

                            if (isset($dataOutrosAnos['ACS'])) {
                                // dd($dataOutrosAnos);
                                for ($cont = $detalhes_turma->vc_classe - 1; $cont >= 10; $cont--) {

                                    if (count($dataOutrosAnos['ACS'])) {
                                        for ($i = 0; $i < count($dataOutrosAnos['ACS']); $i++) {
                                            if (isset($dataOutrosAnos['ACS'][$i])) {
                                                $nota = isset($dataOutrosAnos['ACS'][$i]['ca']) ? $dataOutrosAnos['ACS'][$i]['ca'] : 0;
                                                // if($aluno->id=='13518'){
                                                //     dd($dataOutrosAnos['ACS'],$cont,$i,$cont==$dataOutrosAnos['ACS'][$i]['vc_classe']);
                                                //   }
                                                if ($cont == $dataOutrosAnos['ACS'][$i]['vc_classe'] && temDisciplinaNoClasseAnterior($disciplina->id, $detalhes_turma->vc_classe, $detalhes_turma->it_idCurso)) {
                                                    //  if($nota>=10){
                                                    $cls = $dataOutrosAnos['ACS'][$i]['vc_classe'];
                                                    //   dd("Ola");
                                                    array_push(
                                                        $arrayNotasClasses,
                                                        array(
                                                            "$cls" . "classe" => $nota
                                                        )
                                                    );



                                                    //  }else{
                                                    // echo "<td colspan='1' style='red' rowspan='1' class='td'>$nota 102";
                                                    //  }

                                                } else {
                                                    // echo "<td colspan='1' rowspan='1' class='td'  >0";
                                                }
                                            }
                                        }
                                    } elseif (temDisciplinaNoClasseAnterior($disciplina->id, $detalhes_turma->vc_classe, $detalhes_turma->it_idCurso)) {
                                        // $diferenfaClasse = $detalhes_turma->vc_classe - (10 + count($dataOutrosAnos['ACS']));
                                        // for ($contNotaFake = 1; $contNotaFake <= $diferenfaClasse; $contNotaFake++) {

                                        // }
                                    }
                                }
                            }

                            $cfd = $dataOutrosAnos['media'];
                        }
                        $ac = round((($mat1 + $mat2 + $mat3) / 3), 0, PHP_ROUND_HALF_UP);

                        if ($rec != -1) {
                            if ($rec >= 10) {
                                array_push($disciplinasPositivas, $disciplina->id);
                            } else {
                                array_push($disciplinasNegativas, $disciplina->id);
                            }
                        } else {
                            if (isset($cfd) && $cfd != 0 && temDisciplinaNoClasseAnterior($disciplina->id, $detalhes_turma->vc_classe, $detalhes_turma->it_idCurso)) {
                                if ($cfd >= 10) {
                                    array_push($disciplinasPositivas, $disciplina->id);
                                } else {
                                    array_push($disciplinasNegativas, $disciplina->id);
                                }
                                $somaAcs += $cfd;
                            } else {
                                if ($ac >= 10) {
                                    array_push($disciplinasPositivas, $disciplina->id);
                                } else {
                                    array_push($disciplinasNegativas, $disciplina->id);
                                }
                                $somaAcs += $ac;
                            }
                        }

                        if ($disciplinas_terminas->where('id', $disciplina->id)->count() && ($detalhes_turma->vc_classe == '12' || $detalhes_turma->vc_classe == '13')) {
                            ;
                        } else {
                        }
                        ;

                        if ($disciplinas_terminas->where('id', $disciplina->id)->count() && temDisciplinaNoClasseAnterior($disciplina->id, $detalhes_turma->vc_classe, $detalhes_turma->it_idCurso)) {

                            $ac = round(($mat1 + $mat2 + $mat3) / 3, 0, PHP_ROUND_HALF_UP);

                            // if($disciplina->vc_acronimo=='QUI'){
                            $cfd = round(($dataOutrosAnos['media'] + $ac) / 2, 0, PHP_ROUND_HALF_UP);
                            // $cfd=round(  $cfd, 0, PHP_ROUND_HALF_UP);
                            //                     dd( $ac ,$cfd);
                            // }


                            if (($detalhes_turma->vc_classe == 12 || $detalhes_turma->vc_classe == 13)) {
                                // dd( $cfd);
                                $ac = round((($mfd * 0.6) + ($exame * 0.4)), 0, PHP_ROUND_HALF_UP);

                                $i = temDisciplinaNoClasseAnterior($disciplina->id, $detalhes_turma->vc_classe, $detalhes_turma->it_idCurso) + 1;
                                // $cfd =;
                                $cfd = round((($dataOutrosAnos['media'] + $ac) / 2), 0, PHP_ROUND_HALF_UP);
                            }

                            // dd( $cfd);
                            if ($cfd < 10) {
                                $qtDisciplinaNegativa++;
                            }
                        } else if ($disciplinas_terminas->where('id', $disciplina->id)->count() && !temDisciplinaNoClasseAnterior($disciplina->id, $detalhes_turma->vc_classe, $detalhes_turma->it_idCurso)) {

                            if (($detalhes_turma->vc_classe == 12 || $detalhes_turma->vc_classe == 13)) {

                                $ac = round((($mfd * 0.6) + ($exame * 0.4)), 0, PHP_ROUND_HALF_UP);
                            }
                            $cfd = $ac;
                            if ($ac < 10) {
                                $qtDisciplinaNegativa++;
                            }
                        } else {


                            if ($ac < 10) {
                                $qtDisciplinaNegativa++;
                            }
                            ;
                        }

                        if ($rec != -1 && $rec < 10) {
                            array_push($disciplinasNegativasIndividual, ['disciplina' => $disciplina->vc_acronimo, 'terminal' => $disciplinas_terminas->where('id', $disciplina->id)->count(), 'nota' => $rec, 'id_aluno' => $aluno->id, 'tipo_nota' => 'cfd']);
                        } else if ($rec == -1) {

                            //         if($disciplina->vc_acronimo=='P.A.P.'){
                            //             dd($rec != -1,$rec , -1,  "$cfd" != "null","$ac" != "null" );
                            //    ;
                            //         }
                            if ("$cfd" != "null" && $cfd < 10) {

                                array_push($disciplinasNegativasIndividual, ['disciplina' => $disciplina->vc_acronimo, 'terminal' => $disciplinas_terminas->where('id', $disciplina->id)->count(), 'nota' => $cfd, 'id_aluno' => $aluno->id, 'tipo_nota' => 'cfd']);
                            } else if ("$ac" != "null" && $ac < 10 && "$cfd" == "null") {

                                array_push($disciplinasNegativasIndividual, ['disciplina' => $disciplina->vc_acronimo, 'terminal' => $disciplinas_terminas->where('id', $disciplina->id)->count(), 'nota' => $ac, 'id_aluno' => $aluno->id, 'tipo_nota' => 'ac']);
                            }
                        }
                        //  if ($cfd!="sem" ) {
                        //     $cfd  >= 10 ? '' : $qtDisciplinaNegativa++;
                        // } else if($ac!="sem" ){

                        //     $ac  >= 10 ? '' : $qtDisciplinaNegativa++;
                        // }


                        if ($rec != -1) {



                            if ($detalhes_turma->vc_classe == 10) {

                                array_push(
                                    $disciplinasNotas,
                                    array(
                                        $disciplina->vc_acronimo => array(
                                            [
                                                "mt1" => $mat1,
                                                "mt2" => $mat2,
                                                "mt3" => $mat3,
                                                "ca" => $ac,
                                                "rec" => $rec,
                                                //"cfd" => $cfd,
                                                "outrosAnos" => $arrayNotasClasses
                                            ]
                                        )
                                    )

                                );
                            } elseif ($detalhes_turma->vc_classe == 11) {
                                if ($disciplina->vc_acronimo == "DES. TÉC.") {
                                    array_push(
                                        $disciplinasNotas,
                                        array(
                                            $disciplina->vc_acronimo => array(
                                                [
                                                    "mt1" => $mat1,
                                                    "mt2" => $mat2,
                                                    "mt3" => $mat3,
                                                    "ca" => $ac,
                                                    "rec" => $rec,
                                                    "outrosAnos" => $arrayNotasClasses
                                                ]
                                            )
                                        )

                                    );
                                } else {
                                    array_push(
                                        $disciplinasNotas,
                                        array(
                                            $disciplina->vc_acronimo => array(
                                                [
                                                    "mt1" => $mat1,
                                                    "mt2" => $mat2,
                                                    "mt3" => $mat3,
                                                    "ca" => $ac,
                                                    "rec" => $rec,
                                                    "cfd" => ($disciplina->vc_acronimo != "EMP" && $disciplina->vc_acronimo != "FÍS" && $disciplina->vc_acronimo != "MAT" && $disciplina->vc_acronimo != "SIST . INF." && $disciplina->vc_acronimo != "D.C.A." && $disciplina->vc_acronimo != "TEC. MULT" && $disciplina->vc_acronimo != "S.E.A.C." && $disciplina->vc_acronimo != "T.L.P." && $disciplina->vc_acronimo != "SIST. DIG." && $disciplina->vc_acronimo != "E. ELECTR." && $disciplina->vc_acronimo != "TEC. TELECOM." && $disciplina->vc_acronimo != "P.O.L." && $disciplina->vc_acronimo != "DES. TÉC.") ? $cfd : '',
                                                    //"mfd" => $mfd,
                                                    "outrosAnos" => $arrayNotasClasses
                                                ]
                                            )
                                        )

                                    );
                                }
                            } elseif (($detalhes_turma->vc_classe == 12 || $detalhes_turma->vc_classe == 13)) {
                                if (($detalhes_turma->vc_classe == 13)) {
                                    array_push(
                                        $disciplinasNotas,
                                        array(
                                            $disciplina->vc_acronimo => array(
                                                [
                                                    "ca" => $ac,
                                                    "cfd" => $cfd,
                                                    // "mfd" => $mfd,
                                                    "outrosAnos" => $arrayNotasClasses
                                                ]
                                            )
                                        )

                                    );
                                } else {
                                    array_push(
                                        $disciplinasNotas,
                                        array(
                                            $disciplina->vc_acronimo => array(
                                                [
                                                    "mt1" => $mat1,
                                                    "mt2" => $mat2,
                                                    "mt3" => $mat3,
                                                    "ca" => $ac,

                                                    "cfd" => ($disciplina->vc_acronimo != "PROJ. TECN.") ? $cfd : '',
                                                    // "mfd" => $mfd,
                                                    "rec" => $rec,
                                                    "outrosAnos" => $arrayNotasClasses
                                                ]
                                            )
                                        )

                                    );
                                }
                            } else {
                                array_push(
                                    $disciplinasNotas,
                                    array(
                                        $disciplina->vc_acronimo => array(
                                            [
                                                "mt1" => $mat1,
                                                "mt2" => $mat2,
                                                "mt3" => $mat3,
                                                "ca" => $ac,

                                                "mfd" => $mfd,
                                                //"cfd" => $cfd,
                                                "rec" => $rec,
                                                "outrosAnos" => $arrayNotasClasses
                                            ]
                                        )
                                    )

                                );
                            }
                            $rec = -1;
                        } else {
                            if ($detalhes_turma->vc_classe == 10) {

                                array_push(
                                    $disciplinasNotas,
                                    array(
                                        $disciplina->vc_acronimo => array(
                                            [
                                                "mt1" => $mat1,
                                                "mt2" => $mat2,
                                                "mt3" => $mat3,
                                                "ca" => $ac,

                                                //"cfd" => $cfd,
                                                "outrosAnos" => $arrayNotasClasses
                                            ]
                                        )
                                    )

                                );
                            } elseif ($detalhes_turma->vc_classe == 11) {
                                if ($disciplina->vc_acronimo == "DES. TÉC.") {
                                    array_push(
                                        $disciplinasNotas,
                                        array(
                                            $disciplina->vc_acronimo => array(
                                                [
                                                    "mt1" => $mat1,
                                                    "mt2" => $mat2,
                                                    "mt3" => $mat3,
                                                    "ca" => $ac,
                                                    "outrosAnos" => $arrayNotasClasses
                                                ]
                                            )
                                        )

                                    );
                                } else {
                                    array_push(
                                        $disciplinasNotas,
                                        array(
                                            $disciplina->vc_acronimo => array(
                                                [
                                                    "mt1" => $mat1,
                                                    "mt2" => $mat2,
                                                    "mt3" => $mat3,
                                                    "ca" => $ac,
                                                    "cfd" => ($disciplina->vc_acronimo != "EMP" && $disciplina->vc_acronimo != "FÍS" && $disciplina->vc_acronimo != "MAT" && $disciplina->vc_acronimo != "SIST . INF." && $disciplina->vc_acronimo != "D.C.A." && $disciplina->vc_acronimo != "TEC. MULT" && $disciplina->vc_acronimo != "S.E.A.C." && $disciplina->vc_acronimo != "T.L.P." && $disciplina->vc_acronimo != "SIST. DIG." && $disciplina->vc_acronimo != "E. ELECTR." && $disciplina->vc_acronimo != "TEC. TELECOM." && $disciplina->vc_acronimo != "P.O.L." && $disciplina->vc_acronimo != "DES. TÉC.") ? $cfd : '',
                                                    //"mfd" => $mfd,
                                                    "outrosAnos" => $arrayNotasClasses
                                                ]
                                            )
                                        )

                                    );
                                }
                            } elseif (($detalhes_turma->vc_classe == 12 || $detalhes_turma->vc_classe == 13)) {
                                if ($detalhes_turma->vc_classe == 13) {
                                    array_push(
                                        $disciplinasNotas,
                                        array(
                                            $disciplina->vc_acronimo => array(
                                                [
                                                    "ca" => $ac,
                                                    "cfd" => $cfd,
                                                    // "mfd" => $mfd,
                                                    "outrosAnos" => $arrayNotasClasses
                                                ]
                                            )
                                        )

                                    );
                                } else {
                                    array_push(
                                        $disciplinasNotas,
                                        array(
                                            $disciplina->vc_acronimo => array(
                                                [
                                                    "mt1" => $mat1,
                                                    "mt2" => $mat2,
                                                    "mt3" => $mat3,
                                                    "ca" => $ac,

                                                    "cfd" => ($disciplina->vc_acronimo != "PROJ. TECN.") ? $cfd : '',
                                                    // "mfd" => $mfd,
                                                    "outrosAnos" => $arrayNotasClasses
                                                ]
                                            )
                                        )

                                    );
                                }
                            } else {
                                array_push(
                                    $disciplinasNotas,
                                    array(
                                        $disciplina->vc_acronimo => array(
                                            [
                                                "mt1" => $mat1,
                                                "mt2" => $mat2,
                                                "mt3" => $mat3,
                                                "ca" => $ac,

                                                "mfd" => $mfd,
                                                //"cfd" => $cfd,
                                                "outrosAnos" => $arrayNotasClasses
                                            ]
                                        )
                                    )

                                );
                            }
                        }
                        $mft = "sem";
                        $mfd = "sem";
                        $cfd = "null";
                        $ac = "null";
                        $rec = -1;
                        $arrayNotasClasses = array();
                    }
                }
                ;

                $disciplinasNegativasIndividualC = collect($disciplinasNegativasIndividual);
                // dump($disciplinasNegativasIndividualC );
                // $c2 = CadeadoGeralPauta::where('it_estado_activacao', 1)->count();
                $c2 = true;
                if ($c2) {
                    if (
                        $detalhes_turma->vc_classe == '13' &&
                        $disciplinasNegativasIndividualC
                            ->where('terminal', 1)
                            ->where('id_aluno', $aluno->id)
                            ->count() > 0
                    ) {
                        $estadoResultado = 'N/TRANSITA';
                        $result = 0;
                    } elseif (
                        ($disciplinasNegativasIndividualC->where('terminal', 0)->where('id_aluno', $aluno->id)->count() +
                            $disciplinasNegativasIndividualC->where('terminal', 1)->where('id_aluno', $aluno->id)->count()) >= 3
                        && $detalhes_turma->vc_classe == "12" && !temCadeirasDoAnoAnterior($disciplinasNegativasIndividualC, $detalhes_turma)
                    ) {
                        $estadoResultado = "RECURSO";
                        $result = 0;
                    } else if (temCadeirasDoAnoAnterior($disciplinasNegativasIndividualC, $detalhes_turma) && $detalhes_turma->vc_classe == "12") {

                        $estadoResultado = "N/TRANSITA";
                        $result = 0;
                    } else
                        if (($disciplinasNegativasIndividualC->where('terminal', 0)->where('id_aluno', $aluno->id)->count() + $disciplinasNegativasIndividualC->where('terminal', 1)->where('id_aluno', $aluno->id)->count()) >= 3) {
                            $estadoResultado = "N/TRANSITA";
                            $result = 0;
                        } else if ($disciplinasNegativasIndividualC->where('terminal', 0)->where('id_aluno', $aluno->id)->count() >= 1 && $detalhes_turma->vc_classe == "12") {

                            $estadoResultado = "RECURSO";
                            $result = 0;
                        } else if ($disciplinasNegativasIndividualC->where('terminal', 1)->where('id_aluno', $aluno->id)->count()) {
                            if (
                                $detalhes_turma->vc_shortName == "Info e Sistemas Multimédia" &&
                                $detalhes_turma->vc_classe == "11" &&
                                $disciplinasNegativasIndividualC->where('terminal', 0)->where('id_aluno', $aluno->id)->count() == 2
                                && $disciplinasNegativasIndividualC->where("disciplina", "DES. TÉC.")->where('id_aluno', $aluno->id)->count()
                            ) {
                                $estadoResultado = "N/TRANSITA";
                                $result = 0;
                            } else {
                                if (($detalhes_turma->vc_classe == 12 || $detalhes_turma->vc_classe == 13) && temCadeirasDoAnoAnterior($disciplinasNegativasIndividualC, $detalhes_turma)) {

                                    $estadoResultado = "N/TRANSITA";
                                    $result = 0;
                                } else {
                                    //    dd(deixouCadeiraDesteAno($disciplinasNegativasIndividualC,$detalhes_turma));

                                    if (deixouCadeiraDesteAno($disciplinasNegativasIndividualC, $detalhes_turma)) {

                                        $estadoResultado = "RECURSO";
                                        $result = 0;
                                    } else {

                                        if ($disciplinasNegativasIndividualC->where('terminal', 1)->where('id_aluno', $aluno->id)->count()) {
                                            if (
                                                $disciplinasNegativasIndividualC->where('terminal', 1)->where('id_aluno', $aluno->id)->count() == 1
                                                && $detalhes_turma->vc_classe == "11" && $detalhes_turma->vc_shortName == "Info e Sistemas Multimédia"
                                            ) {
                                                $estadoResultado = "TRANSITA";
                                                $result = 1;
                                            } else {
                                                $estadoResultado = "RECURSO";

                                                $result = 0;
                                            }
                                        } else {
                                            if ($disciplinasNegativasIndividualC->where('terminal', 1)->where('id_aluno', $aluno->id)->count() <= 1) {
                                                $estadoResultado = "TRANSITA";
                                                $result = 1;
                                            } else {
                                                $estadoResultado = "RECURSO";
                                                $result = 0;
                                            }
                                        }
                                    }
                                }
                            }
                        } else {


                            $estadoResultado = "TRANSITA";
                            $result = 1;
                        }

                    // start activar somente depois do recurso
                    // if($aluno->id==13409){
                    //     dd($estadoResultado, temNegativaDeRecurso($aluno->id));
                    // }
                    if ($detalhes_turma->vc_classe == "12" && $estadoResultado == "RECURSO") {
                        if (
                            temNegativaDeRecurso($aluno->id) +
                            $disciplinasNegativasIndividualC->where('terminal', 0)->where('id_aluno', $aluno->id)->count()
                            + $disciplinasNegativasIndividualC->where('terminal', 0)->where('id_aluno', $aluno->id)->count()
                        ) {

                            $estadoResultado = "N/TRANSITA";
                            $result = 0;
                        }
                    } else {
                        if (
                            $detalhes_turma->vc_classe != "12" &&
                            $estadoResultado == "RECURSO" &&
                            (temNegativaDeRecurso($aluno->id) +
                                $disciplinasNegativasIndividualC->where('terminal', 0)->where('id_aluno', $aluno->id)->count()) > 2
                        ) {


                            $estadoResultado = "N/TRANSITA";
                            $result = 0;
                        } else if ($estadoResultado == "RECURSO" && temNegativaDeRecurso($aluno->id) <= 2) {

                            $estadoResultado = "TRANSITA";
                            $result = 1;
                        }
                    }
                    // end activar somente depois do recurso

                    array_push($disciplinasNotas, ['resultado' => $estadoResultado]);
                }

                $disciplinasNegativasIndividualC = array();
                $disciplinasNegativasIndividual = array();

                round(($somaAcs / $disciplinas->count()), 0, PHP_ROUND_HALF_UP);
                $somaAcs = 0;
                ;
            }

            array_push($processos, $aluno->id);
        }
        return $disciplinasNotas;
    }

    public function alunoPautaFinal(Request $processo)
    {


        try {

            $header = $processo->header('Authorization');

            if ($header == "Basic d3MuYWRtY2F6ZW5nYTptZm4zNDYwODIwMjI=") {
                $processo = $processo["processo"];

                // dd($processo);
                $matricula = Matricula::join('classes', 'classes.id', 'matriculas.it_idClasse')
                    ->where('id_aluno', $processo)
                    ->orderBy('classes.vc_classe', 'desc')->first();
                $linha = CandeadoPauta::where('vc_tipo_pauta', 'FINAL')->where('it_curso', $matricula->it_idCurso)
                    ->where('it_classe', $matricula->it_idClasse)->where('it_estado_activacao', 1)->count();

                if ($linha) {
                    $result = $this->minhaPauta($processo, $matricula->it_idTurma);
                    return response()->json($result);
                } else {
                    return response()->json([
                        "message" => "Non-Authoritative Information",
                        "status" => 0
                    ], 203);
                }
            } else {
                return response()->json([
                    "message" => "Non-Authoritative Information"
                ], 203);
            }
        } catch (Exception $ex) {
            return response()->json($ex->getMessage());
        }
    }
    public function alunoPauta_array($processo)
    {
        try {
            $matricula = Matricula::join('classes', 'classes.id', 'matriculas.it_idClasse')
                ->where('id_aluno', $processo)
                ->orderBy('classes.vc_classe', 'desc')->first();
            return $this->minhaPauta($processo, $matricula->it_idTurma);
            ;
        } catch (\Exception $ex) {
            return response()->json("Pendente");
        }
    }
    public function alunoPauta($processo)
    {
        try {
            $matricula = Matricula::join('classes', 'classes.id', 'matriculas.it_idClasse')
                ->where('id_aluno', $processo)
                ->orderBy('classes.vc_classe', 'desc')->first();
            $p = $this->minhaPauta($processo, $matricula->it_idTurma);
            // dd($p);
            return response()->json($p);
        } catch (\Exception $ex) {
            return response()->json("Pendente");
        }
    }
    public function index()
    {
    }
    public function loggerData($mensagem)
    {
        $dados_Auth = Auth::user()->vc_primemiroNome . ' ' . Auth::user()->vc_apelido . ' Com o nivel de ' . Auth::user()->vc_tipoUtilizador . ' ';
        $this->Logger->Log('info', $dados_Auth . $mensagem);
    }

    public function getGeneratePautaFinal()
    {
        $data['anoslectivos'] = AnoLectivo::all();
        $data['cursos'] = Curso::all();
        $data['classes'] = Classe::all();

        //dd($data);
        return view('admin.pauta_final.pesquisar.index', $data);
    }

    public function getListPautaFinal(Request $request)
    { //dd($request->vc_anolectivo);
        return redirect('/pauta-final/listar/' . $request->vc_anolectivo . '/' . $request->vc_curso . '/' . $request->vc_classe);
    }

    public function getListasPautaFinal($ano_lectivo, $curso, $classe)
    {


        $data['dados'] = DB::table('turmas')->where('it_idAnoLectivo', $ano_lectivo)
            ->where('it_idAnoLectivo', $classe)
            ->where('it_idCurso', $curso)
            ->join('classes', 'turmas.it_idClasse', 'classes.id')->get();
        // dd($data['dados']);


        $data['alunos'] = Alunno::all();
        $data['notas'] = Nota::all();
        $data['disciplinas'] = Disciplinas::all();
        $data['ano_lectivo'] = $ano_lectivo;
        $data['curso'] = $curso;
        $data['classe'] = $classe;

        return view('admin.pauta_final.index', $data);
    }

    public function getViewPautaFinal($id)
    {


        $data['cabecalho'] = Cabecalho::find(1);
        $ResponseTurma = Turma::find($id);
        $data['disciplinas'] = Disciplinas::all();
        $data['turma'] = $ResponseTurma;
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
        $html = view("admin/pdfs/pauta_final/index", $data);
        $mpdf->writeHTML($html);
        $mpdf->Output($id . ".pdf", "I");
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
}