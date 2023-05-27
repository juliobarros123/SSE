<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php

            use App\Models\NotaRecurso;

            echo $titulo ?></title>
</head>

<body>
    <style>
        .table {
            border-collapse: collapse;
            width: 100%;

        }

        .th,
        .td {
            padding: 6px;
            text-align: left;
            border: 1px solid #ddd;

            color: black;
        }

        .logotipo {
            position: absolute;
            margin-top: -100px;
            margin-right: -110px;
            float: left;
            z-index: 1;
        }

        /* .tb{
                position: absolute;
                margin-top: 10px;
                margin-right: -110px;
                float: left;
                z-index: 1;
            } */
        .visto {
            width: 530px;
            height: 100px;
            /* background-color: red; */
            /* position: absolute;
            left: 50px;
            margin-left: 300px; */
            left: 50px;
            margin-left: 300px;
            margin-top: -30px;
            font-size: 100px;
        }
        .logo {
            width: 500px;
            height: 100px;
            /* background-color: red; */
            /* position: absolute;
            left: 50px;
            margin-left: 300px; */
            left: 50px;
            margin-left: 30px;
            margin-top: -170px;
            font-size: 100px;
        }

        .text-center {
            text-align: center;
        }

        .tamanho-font {
            font-size: 20px;
        }

        .style-table {
            width: 100%;
            /* border: 2px solid #ccc; */
        }

        /* .table1,
        .tr1,
        .td1,
        .th1 {
            border: none;
        } */
    </style>

    <div class="text-center tamanho-font">
        <p>
           <img src="<?php echo ?>images/ensignia/<?php echo $cabecalho->vc_ensignia; ?>.png" class="" width="50" height="50">
            <br>
            <?php echo $cabecalho->vc_republica; ?>
            <br>
            <?php echo $cabecalho->vc_ministerio; ?>
            <br>

            <br>
           
            <?php echo $cabecalho->vc_escola; ?>

        </p>

    </div>
    <div class="logo">
                <!-- <img src="<?php /*echo $cabecalho->vc_logo*/?>" class="logotipo" width="100" height="100"> -->
    </div>
    <div class="visto">
<table style="width:100% ;">
        <tr >
            
            <th  style="font-size:27px"> VISTO <br> O DIRECTOR GERAL <br>
              <!-- <hr> -->
              <br><br><br>

            </th>
        </tr>
        <tr >
          
            <td class="text-center" style="font-size:35px"> <?php echo $cabecalho->vc_nomeDirector; ?> <br>
            </td>
        </tr>

    </table>
    </div>


    <h2 style="text-align: center;">MAPA DE AVALIAÇÃO ANUAL</h2>
    <br>
    <table class="style-table">
        <th>
            <tr>
                <td style="text-align: center;">Ano Lectivo: <?php echo $detalhes_turma->ya_inicio . '/' . $detalhes_turma->ya_fim ?></td>
                <td style="text-align: center;">Curso: <?php echo $detalhes_turma->vc_shortName ?></td>
                <td style="text-align: center;">Classe: <?php echo $detalhes_turma->vc_classe ?></td>

                <td style="text-align: center;">Turma: <?php echo $detalhes_turma->vc_nomedaTurma ?></td>

                <td style="text-align: center;">Turno: <?php echo $detalhes_turma->vc_turnoTurma ?></td>



            </tr>


        </th>
    </table>
    <br><br>
    <?php
    $disciplinas2 = $disciplinas;
    if ($detalhes_turma->vc_classe == 13) {
        foreach ($disciplinas as $disciplina) {
            if ($disciplinas_terminas->where('id', $disciplina->id)->count()) {
                $index = $disciplinas->search($disciplina);
                $disciplinas = $disciplinas->except([$index]);
            }
        }
    
        foreach ($disciplinas2 as $disciplina) {
            if (!$disciplinas_terminas->where('id', $disciplina->id)->count()) {
                $index = $disciplinas->search($disciplina);
                $disciplinas2 = $disciplinas2->except([$index]);
            }
        }
    } else {
        $disciplinas2 = collect();
    }
    // dd( $disciplinas2);
    ?>
    <table class="table">
        <thead class="">





            <tr>
                <th class="th th-ordem" rowspan="2">Nº ORDEM</th>
                <th class="th" rowspan="2">PROCESSO</th>
                <th class="th th-nome" rowspan="2">NOME</th>

                <?php foreach ($disciplinas as $disciplina) { ?>

                <?php if ($disciplinas_terminas->where('id', $disciplina->id)->count()) {
                        $QtDeClasses = 0;
                        $qtClassesAnterior = temDisciplinaNoClasseAnterior($disciplina->id, $detalhes_turma->vc_classe, $detalhes_turma->it_idCurso);
                    ?>

                <?php for ($cont = $detalhes_turma->vc_classe - 1; $cont >= $detalhes_turma->vc_classe - $qtClassesAnterior; $cont--) { ?>
                <?php $QtDeClasses++; ?> <?php } ?>
                <?php if ($disciplinas_terminas->where('id', $disciplina->id)->count() && ($detalhes_turma->vc_classe == '12' || $detalhes_turma->vc_classe == '13') &&  $disciplina->vc_acronimo == "SIST. DIG.") { ?>
                <th colspan="<?php echo 9; ?>" rowspan="1" class="th " style="text-align: center;">
                    <?php echo $disciplina->vc_acronimo; ?></th>
                <?php } else if ($disciplinas_terminas->where('id', $disciplina->id)->count() && ($detalhes_turma->vc_classe == '12' || $detalhes_turma->vc_classe == '13') && temDisciplinaNoClasseAnterior($disciplina->id, $detalhes_turma->vc_classe, $detalhes_turma->it_idCurso)) { ?>
                <th colspan="<?php echo 8 + $QtDeClasses; ?>" rowspan="1" class="th " style="text-align: center;">
                    <?php echo $disciplina->vc_acronimo; ?></th>
                <?php } else if ($disciplinas_terminas->where('id', $disciplina->id)->count() && ($detalhes_turma->vc_classe == '12' || $detalhes_turma->vc_classe == '13') && !temDisciplinaNoClasseAnterior($disciplina->id, $detalhes_turma->vc_classe, $detalhes_turma->it_idCurso)) { ?>
                <th colspan="<?php echo 8 + temDisciplinaNoClasseAnterior($disciplina->id, $detalhes_turma->vc_classe, $detalhes_turma->it_idCurso); ?>" rowspan="1" class="th " style="text-align: center;">
                    <?php echo $disciplina->vc_acronimo; ?></th>
                <?php } else if ($disciplinas_terminas->where('id', $disciplina->id)->count() && !temDisciplinaNoClasseAnterior($disciplina->id, $detalhes_turma->vc_classe, $detalhes_turma->it_idCurso)) { ?>
                <th colspan="<?php echo 6 + temDisciplinaNoClasseAnterior($disciplina->id, $detalhes_turma->vc_classe, $detalhes_turma->it_idCurso); ?>" rowspan="1" class="th " style="text-align: center;">
                    <?php echo $disciplina->vc_acronimo; ?></th>

                <?php } else { ?>
                <th colspan="<?php echo 6 + temDisciplinaNoClasseAnterior($disciplina->id, $detalhes_turma->vc_classe, $detalhes_turma->it_idCurso); ?>" rowspan="1" class="th " style="text-align: center;">
                    <?php echo $disciplina->vc_acronimo; ?></th>
                <?php } ?>
                <?php } else if (!temDCCNestaClasse($disciplina->id, $detalhes_turma->it_idClasse, $detalhes_turma->it_idCurso)) { ?>
                <th colspan="2" rowspan="1" class="th w-2" style="text-align: center;"><?php echo $disciplina->vc_acronimo; ?></th>
                <?php } else { ?>
                <th colspan="4" rowspan="1" class="th w-2" style="text-align: center;"><?php echo $disciplina->vc_acronimo; ?></th>
                <?php } ?>



                <?php } ?>




                <?php foreach ($disciplinas2 as $disciplina) { ?>



                <?php if ($disciplinas_terminas->where('id', $disciplina->id)->count() && temDisciplinaNoClasseAnterior($disciplina->id, $detalhes_turma->vc_classe, $detalhes_turma->it_idCurso) ) {
                    $QtDeClasses = temDCCNestaClasse($disciplina->id, $detalhes_turma->it_idClasse, $detalhes_turma->it_idCurso);
                    $qtClassesAnterior = temDisciplinaNoClasseAnterior($disciplina->id, $detalhes_turma->vc_classe, $detalhes_turma->it_idCurso);
                ?>



                <th colspan="<?php echo 1 + $QtDeClasses + $qtClassesAnterior; ?>" rowspan="1" class="th " style="text-align: center;">
                    <?php echo $disciplina->vc_acronimo; ?></th>





                <?php } else{?>
                <?php
                $QtDeClasses = temDCCNestaClasse($disciplina->id, $detalhes_turma->it_idClasse, $detalhes_turma->it_idCurso);
                $qtClassesAnterior = temDisciplinaNoClasseAnterior($disciplina->id, $detalhes_turma->vc_classe, $detalhes_turma->it_idCurso);
                ?>



                <th colspan="<?php echo $QtDeClasses + $qtClassesAnterior; ?>" rowspan="1" class="th " style="text-align: center;">
                    <?php echo $disciplina->vc_acronimo; ?></th>





                <?php } ?>
                <?php } ?>


                <th rowspan="2" class="th">RESULTADO</th>
                <th rowspan="2" class="th">MÉDIA</th>

            <tr>
                <?php foreach ($disciplinas as $disciplina) { ?>
                <?php if ($disciplinas_terminas->where('id', $disciplina->id)->count() && temDisciplinaNoClasseAnterior($disciplina->id, $detalhes_turma->vc_classe, $detalhes_turma->it_idCurso)) { ?>

                <?php if ($disciplinas_terminas->where('id', $disciplina->id)->count() && ($detalhes_turma->vc_classe == '12' || $detalhes_turma->vc_classe == '13') &&  $disciplina->vc_acronimo == "SIST. DIG.") { ?>
                <th colspan="1" rowspan="1" class="th"> <?php echo 11; ?>ª CA</th>
                <?php } else { ?>

                <?php
                            $qtClassesAnterior = temDisciplinaNoClasseAnterior($disciplina->id, $detalhes_turma->vc_classe, $detalhes_turma->it_idCurso);
                            for ($cont = $detalhes_turma->vc_classe - 1; $cont >= $detalhes_turma->vc_classe - $qtClassesAnterior; $cont--) { ?>
                <th colspan="1" rowspan="1" class="th"> <?php echo $cont; ?>ª CA</th>
                <?php } ?>
                <?php } ?>
                <?php } ?>
                <?php if (!temDCCNestaClasse($disciplina->id, $detalhes_turma->it_idClasse, $detalhes_turma->it_idCurso)) { ?>
                <th colspan="1" rowspan="1" class="th">CFD</th>
                <th colspan="1" rowspan="1" class="th">REC</th>
                <?php } else { ?>
                <th colspan="1" rowspan="1" class="th">MT1</th>
                <th colspan="1" rowspan="1" class="th">MT2</th>
                <?php if ($disciplinas_terminas->where('id', $disciplina->id)->count() && ($detalhes_turma->vc_classe == '12' || $detalhes_turma->vc_classe == '13')) { ?>
                <th colspan="1" rowspan="1" class="th">MFT</th>
                <th colspan="1" rowspan="1" class="th">EX</th>
                <th colspan="1" rowspan="1" class="th">MFD</th>
                <?php } else { ?>
                <th colspan="1" rowspan="1" class="th">MT3</th>
                <?php } ?>
                <?php if ($disciplinas_terminas->where('id', $disciplina->id)->count() && temDisciplinaNoClasseAnterior($disciplina->id, $detalhes_turma->vc_classe, $detalhes_turma->it_idCurso)) { ?>
                <th colspan="1" rowspan="1" class="th">CA</th>
                <th colspan="1" rowspan="1" class="th">CFD</th>
                <th colspan="1" rowspan="1" class="th">REC</th>
                <?php
                            // Caso não tiver essa CA no ano anterior ou não irá continuar noutras classes futuras
                        } else if ($disciplinas_terminas->where('id', $disciplina->id)->count() && !temDisciplinaNoClasseAnterior($disciplina->id, $detalhes_turma->vc_classe, $detalhes_turma->it_idCurso)) { ?>
                <th colspan="1" rowspan="1" class="th">CA</th>
                <th colspan="1" rowspan="1" class="th">CFD</th>
                <th colspan="1" rowspan="1" class="th">REC</th>
                <?php } else { ?>
                <th colspan="1" rowspan="1" class="th">CA</th>
                <?php } ?>
                <?php } ?>

                <?php } ?>

                <?php foreach ($disciplinas2 as $disciplina) { ?>
                <?php if ($disciplinas_terminas->where('id', $disciplina->id)->count() && temDisciplinaNoClasseAnterior($disciplina->id, $detalhes_turma->vc_classe, $detalhes_turma->it_idCurso)) { ?>

                <?php if ($disciplinas_terminas->where('id', $disciplina->id)->count() && ($detalhes_turma->vc_classe == '12' || $detalhes_turma->vc_classe == '13') &&  $disciplina->vc_acronimo == "SIST. DIG.") { ?>
                <th colspan="1" rowspan="1" class="th"> <?php echo 11; ?>ª CA</th>
                <?php } else { ?>

                <?php
                            $qtClassesAnterior = temDisciplinaNoClasseAnterior($disciplina->id, $detalhes_turma->vc_classe, $detalhes_turma->it_idCurso);
                            for ($cont = $detalhes_turma->vc_classe - 1; $cont >= $detalhes_turma->vc_classe - $qtClassesAnterior; $cont--) { ?>
                <th colspan="1" rowspan="1" class="th"> <?php echo $cont; ?>ª CA</th>
                <?php } ?>
                <?php } ?>
                <?php } ?>
                <?php if ($disciplinas_terminas->where('id', $disciplina->id)->count() && temDisciplinaNoClasseAnterior($disciplina->id, $detalhes_turma->vc_classe, $detalhes_turma->it_idCurso) ) {?>
                <th colspan="1" rowspan="1" class="th">CA</th>
                <th colspan="1" rowspan="1" class="th">CFD</th>
                <?php }  else{ ?>
                <th colspan="1" rowspan="1" class="th">CFD</th>
                {{-- <th colspan="1" rowspan="1" class="th">REC</th> --}}
                <?php } ?>

                <?php } ?>


            </tr>

            </tr>







        </thead>
        <tbody class="">
            <?php $processos = [];
            
            ?>
            <?php $contador = 1; ?>
            <?php $qtDisciplinaNegativa = 0; ?>
            <?php $disciplinasNegativasIndividual = []; ?>
            <?php $alunosResultado = collect(); ?>
            <?php $qtMasculinosTransitados = []; ?>
            <?php $qtFemininoTransitados = []; ?>
            <?php $qtMasculinosNTransitados = []; ?>
            <?php $qtFemininoNTransitados = []; ?>
            <?php $somaAcs = 0; ?>
            <?php $ttlReprovados = 0; ?>
            <?php $disciplinasNegativas = []; ?>
            <?php $disciplinasPositivas = [];
            $cfd = 'p';
            $ac = 'p';
            $disciplinasNotas = [];
            $dataOutrosAnos = []; ?>
            <?php foreach ($alunos as $aluno) {


                if (!in_array($aluno->id, $processos)) { ?>


            <tr class="">
                <td class="td text-center"><?php echo $contador++; ?> </td>
                <td class="td text-center"> <?php echo $aluno->id; ?> </td>
                <td class="td"> <?php echo $aluno->vc_primeiroNome . ' ' . $aluno->vc_nomedoMeio . ' ' . $aluno->vc_ultimoaNome; ?> </td>
                <?php foreach ($disciplinas as $disciplina) {
                            // $rec = -1;
                            if (!temDCCNestaClasse($disciplina->id, $detalhes_turma->it_idClasse, $detalhes_turma->it_idCurso)) {

                                $cfd = buscarCDF($aluno->id, $disciplina->id);
                                // dd($cfd);
                                $ex = notaRecurso($aluno->id, $disciplina->id);
                                $ex = $ex == -1 ? '' : $ex;

                                    if ( $disciplina->vc_acronimo == "T.I.C.") {
                                        // dd($cfd,$ex,$disciplina->id);
                                    }
                                echo "<td colspan='1' style='red' rowspan='1' class='td'>$cfd </td>";
                                echo "<td colspan='1' style='red' rowspan='1' class='td'>$ex</td>";
                                // echo "<td colspan='1' style='red' rowspan='1' class='td'>" . . "</td>";
                                $cfd = $ex == -1 ? $cfd : $ex;
                              
                            } else {

                                $mat1 = isset($notas->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'I')->where('id_aluno', $aluno->id)->first()->fl_media) ? $notas->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'I')->where('id_aluno', $aluno->id)->first()->fl_media : 0;
                                $mat2 = isset($notas->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'II')->where('id_aluno', $aluno->id)->first()->fl_media) ? $notas->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'II')->where('id_aluno', $aluno->id)->first()->fl_media : 0;
                                $mat3 = isset($notas->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'III')->where('id_aluno', $aluno->id)->first()->fl_media) ? $notas->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'III')->where('id_aluno', $aluno->id)->first()->fl_media : 0;
                                if (($detalhes_turma->vc_classe == 12 || $detalhes_turma->vc_classe==13) ) {
                                    if (isset($notas->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'III')->where('id_aluno', $aluno->id)->first()->fl_nota2)) {
                                        $exame = $notas->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'III')->where('id_aluno', $aluno->id)->first()->fl_nota2;
                                    } else {
                                        $exame = 0;
                                    }
                                }
                                // $mat1 = ceil($mat1);
                                $mat1 = round(($mat1), 0, PHP_ROUND_HALF_UP);
                                // $mat2 = ceil($mat2);
                                $mat2 = round(($mat2), 0, PHP_ROUND_HALF_UP);
                                // $mat3 = ceil($mat3);
                                $mat3 = round(($mat3), 0, PHP_ROUND_HALF_UP);
                                $mft = isset($notas->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'III')->where('id_aluno', $aluno->id)->first()->fl_media) ?
                                    $notas->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'III')->where('id_aluno', $aluno->id)->first()->fl_nota1 + $notas->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'III')->where('id_aluno', $aluno->id)->first()->fl_mac : 0;

                                // $mft = ceil($mft / 2);
                                $mft = round(($mft / 2), 0, PHP_ROUND_HALF_UP);
                                // $mfd = ceil(($mat1 + $mat2 + $mft) / 3);
                                $mfd = round((($mat1 + $mat2 + $mft) / 3), 0, PHP_ROUND_HALF_UP);
                                // dd($disciplinas_terminas);
                                
                                if ($disciplinas_terminas->where('id', $disciplina->id)->count()) {
                                    $dataOutrosAnos = mediaDosAnos($aluno->id, $disciplina->id, "''", $detalhes_turma->it_idClasse);
        //                             if ($disciplina->vc_acronimo == "FÍS" ) {
        //     // dd("la",$dataOutrosAnos);
        // }
                                    if (isset($dataOutrosAnos['ACS'])) {
                                        $control = 0;
                                        for ($cont = $detalhes_turma->vc_classe - 1; $cont >= 10; $cont--) {

                                            if (count($dataOutrosAnos['ACS'])) {
                                                for ($i = 0; $i < count($dataOutrosAnos['ACS']); $i++) {
                                                    if (isset($dataOutrosAnos['ACS'][$i])) {
                                                        $nota = isset($dataOutrosAnos['ACS'][$i]['ca']) ? $dataOutrosAnos['ACS'][$i]['ca'] : 0;
                                                        // if($disciplina->vc_acronimo=='QUI'){
                                                        //     // dd($dataOutrosAnos);
                                                        //   }
                                                        if ($cont == $dataOutrosAnos['ACS'][$i]['vc_classe'] && temDisciplinaNoClasseAnterior($disciplina->id, $detalhes_turma->vc_classe, $detalhes_turma->it_idCurso)) {
                                                            //  if($nota>=10){
                                                            if ($disciplinas_terminas->where('id', $disciplina->id)->count() && ($detalhes_turma->vc_classe == '12' || $detalhes_turma->vc_classe == '13') &&  $disciplina->vc_acronimo == "SIST. DIG.") {
                                                                echo "<td colspan='1' style='red' rowspan='1' class='td'>$nota </td>";
                                                                $control = 1;
                                                                break;
                                                            } else {
                                                                echo "<td colspan='1' style='red' rowspan='1' class='td'>$nota </td>";
                                                            }
                                                            //  }else{
                                                            // echo "<td colspan='1' style='red' rowspan='1' class='td'>$nota 102</td>";
                                                            //  }

                                                        } else {
                                                            // echo "<td colspan='1' rowspan='1' class='td'  >0</td>";
                                                        }
                                                    }
                                                }
                                            } elseif (temDisciplinaNoClasseAnterior($disciplina->id, $detalhes_turma->vc_classe, $detalhes_turma->it_idCurso)) {
                                                // $diferenfaClasse = $detalhes_turma->vc_classe - (10 + count($dataOutrosAnos['ACS']));
                                                // for ($contNotaFake = 1; $contNotaFake <= $diferenfaClasse; $contNotaFake++) {
                                                echo "<td colspan='1' rowspan='1' class='td'  >0</td>";
                                                // }
                                            }
                                            if ($control == 1) {
                                                break;
                                            }
                                        }
                                    }

                                    $cfd = $dataOutrosAnos['media'];
                    
                                }
                                // $ac = ceil(($mat1 + $mat2 + $mat3) / 3);
                                $ac = round((($mat1 + $mat2 + $mat3) / 3), 0, PHP_ROUND_HALF_UP);


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

                        ?>

                <td colspan="1" rowspan="1" class="td" style=" color:<?php echo $mat1 >= 10 ? 'blue' : 'red'; ?>">
                    <?php echo $mat1; ?></td>
                <td colspan="1" rowspan="1" class="td" style=" color:<?php echo $mat2 >= 10 ? 'blue' : 'red'; ?>">
                    <?php echo $mat2; ?></td>
                <?php if ($disciplinas_terminas->where('id', $disciplina->id)->count() && ($detalhes_turma->vc_classe == '12' || $detalhes_turma->vc_classe == '13')) { ?>
                <td colspan="1" rowspan="1" class="td" style=" color:<?php echo $mft >= 10 ? 'blue' : 'red'; ?>">
                    <?php echo $mft; ?></td>
                <td colspan="1" rowspan="1" class="td" style=" color:<?php echo $exame >= 10 ? 'blue' : 'red'; ?>">
                    <?php echo $exame; ?></td>
                <td colspan="1" rowspan="1" class="td" style=" color:<?php echo $mfd >= 10 ? 'blue' : 'red'; ?>">
                    <?php echo $mfd;
                    
                    ?></td>
                <?php } else { ?>
                <td colspan="1" rowspan="1" class="td" style=" color:<?php echo $mat3 >= 10 ? 'blue' : 'red'; ?>">
                    <?php echo $mat3; ?></td>
                <?php } ?>

                <?php if ($disciplinas_terminas->where('id', $disciplina->id)->count() && temDisciplinaNoClasseAnterior($disciplina->id, $detalhes_turma->vc_classe, $detalhes_turma->it_idCurso)) { ?>
                <?php $ac = round(($mat1 + $mat2 + $mat3) / 3, 0, PHP_ROUND_HALF_UP);
                
                // if($disciplina->vc_acronimo=='QUI'){
                $cfd = round(($dataOutrosAnos['media'] + $ac) / 2, 0, PHP_ROUND_HALF_UP);
                // $cfd=round(  $cfd, 0, PHP_ROUND_HALF_UP);
                //                     dd( $ac ,$cfd);
                // }
                ?>
                <?php

                                    if (($detalhes_turma->vc_classe == 12 || $detalhes_turma->vc_classe==13)) {
                                        // dd( $cfd);
                                        $ac = round((($mfd * 0.6) + ($exame * 0.4)), 0, PHP_ROUND_HALF_UP);
                             
                                        $i=temDisciplinaNoClasseAnterior($disciplina->id, $detalhes_turma->vc_classe, $detalhes_turma->it_idCurso)+1;
                                        // $cfd =;
                                        $cfd=round(   (($dataOutrosAnos['media']+$ac)/2), 0, PHP_ROUND_HALF_UP);
                                      
                                        // dd( $cfd);
                                    ?>
                <td colspan="1" rowspan="1" class="td" style=" color:<?php echo $ac >= 10 ? 'blue' : 'red'; ?>">
                    <?php echo $ac; ?></td>
                <td colspan="1" rowspan="1" class="td" style=" color:<?php echo $cfd >= 10 ? 'blue' : 'red'; ?>">
                    <?php echo $cfd;
                    if ($aluno->id == 13683 && $disciplina->vc_acronimo == 'O.G.I.') {
                        dd($dataOutrosAnos['media'], $ac, $cfd);
                    } ?></td>

                <td colspan="1" rowspan="1" class="td" style=" color:<?php echo notaRecurso($aluno->id, $disciplina->id) >= 10 ? 'blue' : 'red'; ?>">
                    <?php $rec = notaRecurso($aluno->id, $disciplina->id);
                    echo $rec != -1 ? $rec : '';
                    $cfd = $rec != -1 ? $rec : $cfd;
                    $rec = -1; ?></td>
                <?php } else { ?>
                <td colspan="1" rowspan="1" class="td" style=" color:<?php echo $ac >= 10 ? 'blue' : 'red'; ?>">
                    <?php echo $ac; ?></td>
                <td colspan="1" rowspan="1" class="td" style=" color:<?php echo $cfd >= 10 ? 'blue' : 'red'; ?>">
                    <?php echo $cfd; ?>
                <td colspan="1" rowspan="1" class="td" style=" color:<?php echo notaRecurso($aluno->id, $disciplina->id) >= 10 ? 'blue' : 'red'; ?>">
                    <?php $rec = notaRecurso($aluno->id, $disciplina->id);
                    echo $rec != -1 ? $rec : '';
                    $cfd = $rec != -1 ? $rec : $cfd;
                    $rec = -1; ?></td>
                <?php } ?> </td>
                <?php
                
                if ($cfd < 10) {
                    $qtDisciplinaNegativa++;
                    array_push($disciplinasPositivas, $disciplina->id);
                } ?>

                <?php } else if ($disciplinas_terminas->where('id', $disciplina->id)->count() && !temDisciplinaNoClasseAnterior($disciplina->id, $detalhes_turma->vc_classe, $detalhes_turma->it_idCurso)) { ?>

                <?php   

                                    if (($detalhes_turma->vc_classe == 12 || $detalhes_turma->vc_classe==13)) {

                                        $ac = round((($mfd * 0.6) + ($exame * 0.4)), 0, PHP_ROUND_HALF_UP);
                                        // dd(   $mfd * 0.6) + ($exame * 0.4));

                                    ?>
                <?php } ?>

                <td colspan="1" rowspan="1" class="td" style=" color:<?php echo $ac >= 10 ? 'blue' : 'red'; ?>">
                    <?php echo $ac; ?></td>
                <td colspan="1" rowspan="1" class="td" style=" color:<?php echo $ac >= 10 ? 'blue' : 'red'; ?>">
                    <?php echo $cfd = $ac; ?></td>
                <td colspan="1" rowspan="1" class="td" style=" color:<?php echo notaRecurso($aluno->id, $disciplina->id) >= 10 ? 'blue' : 'red'; ?>">
                    <?php $rec = notaRecurso($aluno->id, $disciplina->id);
                    echo $rec != -1 ? $rec : '';
                    $cfd = $rec != -1 ? $rec : $cfd;
                    $rec = -1; ?></td>
                <?php
                if ($ac < 10) {
                    $qtDisciplinaNegativa++;
                } ?>

                <?php } else { ?>
                <!-- Caso não tiver essa CA no ano anterior ou não irá continuar noutras classes futuras -->
                <td colspan="1" rowspan="1" class="td" style=" color:<?php echo $ac >= 10 ? 'blue' : 'red'; ?>">
                    <?php echo $ac; ?></td>
                <?php
                if ($ac < 10) {
                    $qtDisciplinaNegativa++;
                } ?>
                <?php }
                            } ?>




                <?php
                
                if (!temDCCNestaClasse($disciplina->id, $detalhes_turma->it_idClasse, $detalhes_turma->it_idCurso)) {
                    $cfd = buscarCDF($aluno->id, $disciplina->id);
                    $ex = notaRecurso($aluno->id, $disciplina->id);
                    $cfd = $ex == -1 ? $cfd : $ex;
                
                    if ($cfd < 10) {
                        array_push($disciplinasNegativasIndividual, ['disciplina' => $disciplina->vc_acronimo, 'terminal' => 1, 'nota' => buscarCDF($aluno->id, $disciplina->id), 'id_aluno' => $aluno->id, 'tipo_nota' => 'cfd']);
                    }
                } elseif ($cfd != 'p' && $cfd < 10) {
                    array_push($disciplinasNegativasIndividual, ['disciplina' => $disciplina->vc_acronimo, 'terminal' => $disciplinas_terminas->where('id', $disciplina->id)->count(), 'nota' => $cfd, 'id_aluno' => $aluno->id, 'tipo_nota' => 'cfd']);
                } elseif ($ac != 'p' && $ac < 10 && $cfd == 'p') {
                    array_push($disciplinasNegativasIndividual, ['disciplina' => $disciplina->vc_acronimo, 'terminal' => $disciplinas_terminas->where('id', $disciplina->id)->count(), 'nota' => $ac, 'id_aluno' => $aluno->id, 'tipo_nota' => 'ac']);
                }
                if (!temDCCNestaClasse($disciplina->id, $detalhes_turma->it_idClasse, $detalhes_turma->it_idCurso)) {
                    $cfd = buscarCDF($aluno->id, $disciplina->id);
                    $ex = notaRecurso($aluno->id, $disciplina->id);
                    $cfd = $ex == -1 ? $cfd : $ex;
                    $somaAcs += $cfd;
                    array_push($disciplinasNotas, ['disciplina' => $disciplina->vc_acronimo, 'terminal' => 1, 'nota' => buscarCDF($aluno->id, $disciplina->id), 'id_aluno' => $aluno->id, 'tipo_nota' => 'cfd']);
                } elseif ($cfd != 'p') {
                    array_push($disciplinasNotas, ['disciplina' => $disciplina->vc_acronimo, 'terminal' => $disciplinas_terminas->where('id', $disciplina->id)->count(), 'nota' => $cfd, 'id_aluno' => $aluno->id, 'tipo_nota' => 'cfd']);
                } elseif ($ac != 'p' && $ac >= $cfd) {
                    array_push($disciplinasNotas, ['disciplina' => $disciplina->vc_acronimo, 'terminal' => $disciplinas_terminas->where('id', $disciplina->id)->count(), 'nota' => $ac, 'id_aluno' => $aluno->id, 'tipo_nota' => 'ac']);
                }
                
                $cfd = 'p';
                $ac = 'p';
                
                ?>

                <?php


                        }

                    

                      

                        ?>


                {{-- --------------------------- END 13ª CLASSE --------------------------- --}}

                <?php foreach ($disciplinas2 as $disciplina) {
    // $rec = -1;
    if (!temDCCNestaClasse($disciplina->id, $detalhes_turma->it_idClasse, $detalhes_turma->it_idCurso)) {

        $cfd = buscarCDF($aluno->id, $disciplina->id);

        $ex = notaRecurso($aluno->id, $disciplina->id);
        $ex = $ex == -1 ? '' : $ex;


        echo "<td colspan='1' style='red' rowspan='1' class='td'>$cfd </td>";
        echo "<td colspan='1' style='red' rowspan='1' class='td'>$ex</td>";
        // echo "<td colspan='1' style='red' rowspan='1' class='td'>" . . "</td>";
        $cfd = $ex == -1 ? $cfd : $ex;
      
    } else {
                      if ($disciplina->vc_acronimo == "PROJ. TECN.") {
            // dd($notas->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'I')->where('id_aluno', $aluno->id));
        }



        $mat1 = isset($notas->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'I')->where('id_aluno', $aluno->id)->first()->fl_media) ? $notas->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'I')->where('id_aluno', $aluno->id)->first()->fl_media : 0;
        $mat2 = isset($notas->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'II')->where('id_aluno', $aluno->id)->first()->fl_media) ? $notas->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'II')->where('id_aluno', $aluno->id)->first()->fl_media : 0;
        $mat3 = isset($notas->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'III')->where('id_aluno', $aluno->id)->first()->fl_media) ? $notas->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'III')->where('id_aluno', $aluno->id)->first()->fl_media : 0;
        if (($detalhes_turma->vc_classe == 12|| $detalhes_turma->vc_classe == 13)) {
            if (isset($notas->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'III')->where('id_aluno', $aluno->id)->first()->fl_nota2)) {
                $exame = $notas->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'III')->where('id_aluno', $aluno->id)->first()->fl_nota2;
            } else {
                $exame = 0;
            }
        }
        // $mat1 = ceil($mat1);
        $mat1 = round(($mat1), 0, PHP_ROUND_HALF_UP);
        // $mat2 = ceil($mat2);
        $mat2 = round(($mat2), 0, PHP_ROUND_HALF_UP);
        // $mat3 = ceil($mat3);
        $mat3 = round(($mat3), 0, PHP_ROUND_HALF_UP);
        $mft = isset($notas->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'III')->where('id_aluno', $aluno->id)->first()->fl_media) ?
            $notas->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'III')->where('id_aluno', $aluno->id)->first()->fl_nota1 + $notas->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'III')->where('id_aluno', $aluno->id)->first()->fl_mac : 0;
// dd(   $mat1);
        // $mft = ceil($mft / 2);
        $mft = round(($mft / 2), 0, PHP_ROUND_HALF_UP);
        // $mfd = ceil(($mat1 + $mat2 + $mft) / 3);
        $mfd = round((($mat1 + $mat2 + $mft) / 3), 0, PHP_ROUND_HALF_UP);
        // dd($disciplinas_terminas);
        if ($disciplinas_terminas->where('id', $disciplina->id)->count()) {
            $dataOutrosAnos = mediaDosAnos($aluno->id, $disciplina->id, "''", $detalhes_turma->it_idClasse);
// dd( $dataOutrosAnos);
            if (isset($dataOutrosAnos['ACS'])) {
                if ($disciplina->vc_acronimo == "PROJ. TECN.") {
            // dd($dataOutrosAnos);
        }
                $control = 0;
        
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
                                    if ($disciplinas_terminas->where('id', $disciplina->id)->count() && ($detalhes_turma->vc_classe == '12' || $detalhes_turma->vc_classe == '13') &&  $disciplina->vc_acronimo == "SIST. DIG.") {
                                        echo "<td colspan='1' style='red' rowspan='1' class='td'>$nota </td>";
                                        $control = 1;
                                        break;
                                    } else {
                                        echo "<td colspan='1' style='red' rowspan='1' class='td'>$nota </td>";
                                    }
                                    //  }else{
                                    // echo "<td colspan='1' style='red' rowspan='1' class='td'>$nota 102</td>";
                                    //  }

                                } else {
                                    // echo "<td colspan='1' rowspan='1' class='td'  >0</td>";
                                }
                            }
                        }
                    } elseif (temDisciplinaNoClasseAnterior($disciplina->id, $detalhes_turma->vc_classe, $detalhes_turma->it_idCurso)) {
                        // $diferenfaClasse = $detalhes_turma->vc_classe - (10 + count($dataOutrosAnos['ACS']));
                        // for ($contNotaFake = 1; $contNotaFake <= $diferenfaClasse; $contNotaFake++) {
                        echo "<td colspan='1' rowspan='1' class='td'  >0</td>";
                        // }
                        
                    }
                    // elseif (temDCCNestaClasse($disciplina->id, $detalhes_turma->it_idClasse, $detalhes_turma->it_idCurso)) {
                    //     // $diferenfaClasse = $detalhes_turma->vc_classe - (10 + count($dataOutrosAnos['ACS']));
                    //     // for ($contNotaFake = 1; $contNotaFake <= $diferenfaClasse; $contNotaFake++) {
                    //     echo "<td colspan='1' rowspan='1' class='td'  >0</td>";
                    //     // }
                        
                    // }
        //             if ($disciplina->vc_acronimo == "PROJ. TECN.") {
        //     dd($dataOutrosAnos['ACS']);
        // }
                    if ($control == 1) {
                        break;
                    }
                }
            }
// dd($dataOutrosAnos['media']);
            $cfd = $dataOutrosAnos['media'];
        }
        // $ac = ceil(($mat1 + $mat2 + $mat3) / 3);
        $ac = round((($mat1 + $mat2 + $mat3) / 3), 0, PHP_ROUND_HALF_UP);


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

?>



                <?php if ($disciplinas_terminas->where('id', $disciplina->id)->count() && temDisciplinaNoClasseAnterior($disciplina->id, $detalhes_turma->vc_classe, $detalhes_turma->it_idCurso)) { ?>
                <?php $ac = round(($mat1 + $mat2 + $mat3) / 3, 0, PHP_ROUND_HALF_UP);
                
                ?>

                <td colspan="1" rowspan="1" class="td" style=" color:<?php echo $ac >= 10 ? 'blue' : 'red'; ?>">
                    <?php echo $ac; ?></td>
                <td colspan="1" rowspan="1" class="td" style="color:<?php echo notaRecurso($aluno->id, $disciplina->id) >= 10 ? 'blue' : ($cfd >= 10 ? 'blue' : 'red'); ?>">
                    <?php $rec = notaRecurso($aluno->id, $disciplina->id);
                    echo $rec != -1 ? $rec : $cfd;
                    $cfd = $rec != -1 ? $rec : $cfd;
                    $rec = -1; ?></td>

                <?php
                
                if ($cfd < 10) {
                    $qtDisciplinaNegativa++;
                    array_push($disciplinasPositivas, $disciplina->id);
                } ?>

                <?php } else if ($disciplinas_terminas->where('id', $disciplina->id)->count() && !temDisciplinaNoClasseAnterior($disciplina->id, $detalhes_turma->vc_classe, $detalhes_turma->it_idCurso)) { ?>


                <?php $cfd = $ac; ?>
                <td colspan="1" rowspan="1" class="td" style=" color:<?php echo notaRecurso($aluno->id, $disciplina->id) >= 10 ? 'blue' : ($cfd >= 10 ? 'blue' : 'red'); ?>">
                    <?php $rec = notaRecurso($aluno->id, $disciplina->id);
                    echo $rec != -1 ? $rec : $cfd;
                    $cfd = $rec != -1 ? $rec : $cfd;
                    $rec = -1; ?></td>
                <?php
                if ($ac < 10) {
                    $qtDisciplinaNegativa++;
                } ?>

                <?php } 
    } ?>




                <?php
                
                if ($aluno->id != 13422 && $disciplina->vc_acronimo == 'P.A.P.') {
                }
                
                if (!temDCCNestaClasse($disciplina->id, $detalhes_turma->it_idClasse, $detalhes_turma->it_idCurso)) {
                    $cfd = buscarCDF($aluno->id, $disciplina->id);
                    // dd(  $cfd);
                    $ex = notaRecurso($aluno->id, $disciplina->id);
                
                    $cfd = $ex == -1 ? $cfd : $ex;
                    if ($cfd < 10) {
                        array_push($disciplinasNegativasIndividual, ['disciplina' => $disciplina->vc_acronimo, 'terminal' => 1, 'nota' => buscarCDF($aluno->id, $disciplina->id), 'id_aluno' => $aluno->id, 'tipo_nota' => 'cfd']);
                    }
                } elseif ("$cfd" != 'p' && $cfd < 10) {
                    array_push($disciplinasNegativasIndividual, ['disciplina' => $disciplina->vc_acronimo, 'terminal' => $disciplinas_terminas->where('id', $disciplina->id)->count(), 'nota' => $cfd, 'id_aluno' => $aluno->id, 'tipo_nota' => 'cfd']);
                    // dd("o",!temDCCNestaClasse($disciplina->id, $detalhes_turma->it_idClasse, $detalhes_turma->it_idCurso));
                } elseif ("$ac" != 'p' && $ac < 10 && "$cfd" == 'p') {
                    array_push($disciplinasNegativasIndividual, ['disciplina' => $disciplina->vc_acronimo, 'terminal' => $disciplinas_terminas->where('id', $disciplina->id)->count(), 'nota' => $ac, 'id_aluno' => $aluno->id, 'tipo_nota' => 'ac']);
                }
                if (!temDCCNestaClasse($disciplina->id, $detalhes_turma->it_idClasse, $detalhes_turma->it_idCurso)) {
                    $cfd = buscarCDF($aluno->id, $disciplina->id);
                    $ex = notaRecurso($aluno->id, $disciplina->id);
                    $cfd = $ex == -1 ? $cfd : $ex;
                    $somaAcs += $cfd;
                    array_push($disciplinasNotas, ['disciplina' => $disciplina->vc_acronimo, 'terminal' => 1, 'nota' => buscarCDF($aluno->id, $disciplina->id), 'id_aluno' => $aluno->id, 'tipo_nota' => 'cfd']);
                } elseif ("$cfd" != 'p') {
                    array_push($disciplinasNotas, ['disciplina' => $disciplina->vc_acronimo, 'terminal' => $disciplinas_terminas->where('id', $disciplina->id)->count(), 'nota' => $cfd, 'id_aluno' => $aluno->id, 'tipo_nota' => 'cfd']);
                } elseif ("$ac" != 'p' && $ac >= $cfd) {
                    array_push($disciplinasNotas, ['disciplina' => $disciplina->vc_acronimo, 'terminal' => $disciplinas_terminas->where('id', $disciplina->id)->count(), 'nota' => $ac, 'id_aluno' => $aluno->id, 'tipo_nota' => 'ac']);
                }
                
                $cfd = 'p';
                $ac = 'p';
                
                ?>

                <?php


}
// --------------------------- END 13ª CLASSE ---------------------------

// if($aluno->id!=13422){
// dd( $disciplinasNegativasIndividual,"ol");
// }?>
                // {{-- @include('admin.pdfs.pauta_final.fragment-13-notas'); --}}
                <?php $disciplinasNegativasIndividualC = collect($disciplinasNegativasIndividual);
                // if($aluno->id!=13422){
                // dd( $disciplinasNegativasIndividual,"ol");
                ?>






                <!-- 13 Classe -->


                <!-- end 13 classe -->
                <?php
                // if(13030==$aluno->id){
                // dd();
                // }
                $estadoResultado;
                if (
                    $detalhes_turma->vc_classe == '13' &&
                    $disciplinasNegativasIndividualC
                        ->where('terminal', 1)
                        ->where('id_aluno', $aluno->id)
                        ->count() > 0
                ) {
                    $estadoResultado = 'N/TRANSITA';
                    $result = 0;
                    $alunosResultado->push(['id_aluno' => $aluno->id, 'genero' => $aluno->vc_genero, 'resultado' => 'N/TRANSITA']);
                } elseif (
                    $disciplinasNegativasIndividualC
                        ->where('terminal', 0)
                        ->where('id_aluno', $aluno->id)
                        ->count() +
                        $disciplinasNegativasIndividualC
                            ->where('terminal', 1)
                            ->where('id_aluno', $aluno->id)
                            ->count() >=
                        3 &&
                    ($detalhes_turma->vc_classe == '12' || $detalhes_turma->vc_classe == '13') &&
                    !temCadeirasDoAnoAnterior($disciplinasNegativasIndividualC, $detalhes_turma)
                ) {
                    $estadoResultado = 'RECURSO';
                    $result = 0;
                    $alunosResultado->push(['id_aluno' => $aluno->id, 'genero' => $aluno->vc_genero, 'resultado' => 'RECURSO']);
                } elseif (temCadeirasDoAnoAnterior($disciplinasNegativasIndividualC, $detalhes_turma) && ($detalhes_turma->vc_classe == '12' || $detalhes_turma->vc_classe == '13')) {
                    $estadoResultado = 'N/TRANSITA';
                    $result = 0;
                    $alunosResultado->push(['id_aluno' => $aluno->id, 'genero' => $aluno->vc_genero, 'resultado' => 'N/TRANSITA']);
                } elseif (
                    $disciplinasNegativasIndividualC
                        ->where('terminal', 0)
                        ->where('id_aluno', $aluno->id)
                        ->count() +
                        $disciplinasNegativasIndividualC
                            ->where('terminal', 1)
                            ->where('id_aluno', $aluno->id)
                            ->count() >=
                    3
                ) {
                    $estadoResultado = 'N/TRANSITA';
                    $result = 0;
                    $alunosResultado->push(['id_aluno' => $aluno->id, 'genero' => $aluno->vc_genero, 'resultado' => 'N/TRANSITA']);
                } elseif (
                    $disciplinasNegativasIndividualC
                        ->where('terminal', 0)
                        ->where('id_aluno', $aluno->id)
                        ->count() >= 1 &&
                    ($detalhes_turma->vc_classe == '12' || $detalhes_turma->vc_classe == '13')
                ) {
                    $estadoResultado = 'RECURSO';
                    $result = 0;
                    $alunosResultado->push(['id_aluno' => $aluno->id, 'genero' => $aluno->vc_genero, 'resultado' => 'RECURSO']);
                } elseif (
                    $disciplinasNegativasIndividualC
                        ->where('terminal', 1)
                        ->where('id_aluno', $aluno->id)
                        ->count()
                ) {
                    if (
                        $detalhes_turma->vc_shortName == 'Info e Sistemas Multimédia' &&
                        $detalhes_turma->vc_classe == '11' &&
                        $disciplinasNegativasIndividualC
                            ->where('terminal', 0)
                            ->where('id_aluno', $aluno->id)
                            ->count() == 2 &&
                        $disciplinasNegativasIndividualC
                            ->where('disciplina', 'DES. TÉC.')
                            ->where('id_aluno', $aluno->id)
                            ->count()
                    ) {
                        $estadoResultado = 'N/TRANSITA';
                        $result = 0;
                        $alunosResultado->push(['id_aluno' => $aluno->id, 'genero' => $aluno->vc_genero, 'resultado' => 'N/TRANSITA']);
                    } else {
                        if (($detalhes_turma->vc_classe == 12 || $detalhes_turma->vc_classe == 13) && temCadeirasDoAnoAnterior($disciplinasNegativasIndividualC, $detalhes_turma)) {
                            $estadoResultado = 'N/TRANSITA';
                            $result = 0;
                            $alunosResultado->push(['id_aluno' => $aluno->id, 'genero' => $aluno->vc_genero, 'resultado' => 'N/TRANSITA']);
                        } else {
                            //    dd(deixouCadeiraDesteAno($disciplinasNegativasIndividualC,$detalhes_turma));
                
                            if (deixouCadeiraDesteAno($disciplinasNegativasIndividualC, $detalhes_turma)) {
                                $estadoResultado = 'RECURSO';
                                $result = 0;
                                $alunosResultado->push(['id_aluno' => $aluno->id, 'genero' => $aluno->vc_genero, 'resultado' => 'RECURSO']);
                            } else {
                                if (
                                    $disciplinasNegativasIndividualC
                                        ->where('terminal', 1)
                                        ->where('id_aluno', $aluno->id)
                                        ->count()
                                ) {
                                    if (
                                        $disciplinasNegativasIndividualC
                                            ->where('terminal', 1)
                                            ->where('id_aluno', $aluno->id)
                                            ->count() == 1 &&
                                        $detalhes_turma->vc_classe == '11' &&
                                        $detalhes_turma->vc_shortName == 'Info e Sistemas Multimédia'
                                    ) {
                                        $estadoResultado = 'TRANSITA';
                                        $result = 1;
                                        $alunosResultado->push(['id_aluno' => $aluno->id, 'genero' => $aluno->vc_genero, 'resultado' => 'TRANSITA']);
                                    } else {
                                        $estadoResultado = 'RECURSO';
                
                                        $result = 0;
                                        $alunosResultado->push(['id_aluno' => $aluno->id, 'genero' => $aluno->vc_genero, 'resultado' => 'RECURSO']);
                                    }
                                } else {
                                    if (
                                        $disciplinasNegativasIndividualC
                                            ->where('terminal', 1)
                                            ->where('id_aluno', $aluno->id)
                                            ->count() <= 1
                                    ) {
                                        $estadoResultado = 'TRANSITA';
                                        $result = 1;
                                        $alunosResultado->push(['id_aluno' => $aluno->id, 'genero' => $aluno->vc_genero, 'resultado' => 'TRANSITA']);
                                    } else {
                                        $estadoResultado = 'RECURSO';
                                        $result = 0;
                                        $alunosResultado->push(['id_aluno' => $aluno->id, 'genero' => $aluno->vc_genero, 'resultado' => 'RECURSO']);
                                    }
                                }
                            }
                        }
                    }
                } else {
                    $alunosResultado->push(['id_aluno' => $aluno->id, 'genero' => $aluno->vc_genero, 'resultado' => 'TRANSITA']);
                    $estadoResultado = 'TRANSITA';
                    $result = 1;
                }
                // start activar somente depois do recurso
                // if($aluno->id==13409){
                //     dd($estadoResultado, temNegativaDeRecurso($aluno->id));
                // }
                if (($detalhes_turma->vc_classe == '12' || $detalhes_turma->vc_classe == '13') && $estadoResultado == 'RECURSO') {
                    if (
                        temNegativaDeRecurso($aluno->id) +
                        $disciplinasNegativasIndividualC
                            ->where('terminal', 0)
                            ->where('id_aluno', $aluno->id)
                            ->count() +
                        $disciplinasNegativasIndividualC
                            ->where('terminal', 0)
                            ->where('id_aluno', $aluno->id)
                            ->count()
                    ) {
                        $alunosResultado = eliminarElement(['id_aluno' => $aluno->id, 'genero' => $aluno->vc_genero, 'resultado' => 'RECURSO'], $alunosResultado);
                        $estadoResultado = 'N/TRANSITA';
                        $result = 0;
                        $alunosResultado->push(['id_aluno' => $aluno->id, 'genero' => $aluno->vc_genero, 'resultado' => 'N/TRANSITA']);
                    }
                } else {
                    if (
                        $detalhes_turma->vc_classe != '12' &&
                        $detalhes_turma->vc_classe != '13' &&
                        $estadoResultado == 'RECURSO' &&
                        temNegativaDeRecurso($aluno->id) +
                            $disciplinasNegativasIndividualC
                                ->where('terminal', 0)
                                ->where('id_aluno', $aluno->id)
                                ->count() >
                            2
                    ) {
                        $alunosResultado = eliminarElement(['id_aluno' => $aluno->id, 'genero' => $aluno->vc_genero, 'resultado' => 'RECURSO'], $alunosResultado);
                
                        $estadoResultado = 'N/TRANSITA';
                        $result = 0;
                        $alunosResultado->push(['id_aluno' => $aluno->id, 'genero' => $aluno->vc_genero, 'resultado' => 'N/TRANSITA']);
                    } elseif ($estadoResultado == 'RECURSO' && temNegativaDeRecurso($aluno->id) <= 2) {
                        $alunosResultado = eliminarElement(['id_aluno' => $aluno->id, 'genero' => $aluno->vc_genero, 'resultado' => 'RECURSO'], $alunosResultado);
                        $estadoResultado = 'TRANSITA';
                        $result = 1;
                        $alunosResultado->push(['id_aluno' => $aluno->id, 'genero' => $aluno->vc_genero, 'resultado' => 'TRANSITA']);
                    }
                }
                // end activar somente depois do recurso
                
                $disciplinasNegativasIndividualC = [];
                $disciplinasNegativasIndividual = [];
                
                if ($qtDisciplinaNegativa >= 3) {
                    if ($aluno->vc_genero == 'Masculino') {
                        array_push($qtMasculinosNTransitados, $aluno->vc_genero);
                    } else {
                        array_push($qtFemininoNTransitados, $aluno->vc_genero);
                    }
                
                    $ttlReprovados++;
                    $qtDisciplinaNegativa = 0;
                } else {
                    if ($aluno->vc_genero == 'Masculino') {
                        array_push($qtMasculinosTransitados, $aluno->vc_genero);
                    } else {
                        array_push($qtFemininoTransitados, $aluno->vc_genero);
                    }
                
                    $qtDisciplinaNegativa = 0;
                }
                
                ?>
                <td colspan="1" rowspan="1" class="td" style=" color:<?php echo $result ? 'black' : 'red'; ?>">
                    <?php echo $estadoResultado; ?>
                </td>
                <td colspan="1" rowspan="1" class="td" style=" color:<?php echo round($somaAcs / $disciplinas->count(), 0, PHP_ROUND_HALF_UP) >= 10 ? 'blue' : 'red'; ?>">
                    <?php echo round($somaAcs / $disciplinas->count(), 0, PHP_ROUND_HALF_UP);
                    $somaAcs = 0; ?></td>

            </tr>
            <?php }
                // if($aluno->id==13400){
                //     dd("ola");
                // }
             

                array_push($processos, $aluno->id);
            }

            ?>
        </tbody>

    </table>



    <div>
        <br><br>
        <table class="table">
            <tr>
                <th colspan="3" class="th " style="text-align: center;  border: 1px solid black;height:50px;">Estatistica</th>
            </tr>


        </table>
        <br><br>
        <table class="table">



            <tr>
                <th colspan="3" class="th " style="text-align: center;">Percentagem</th>
                <th class="th " style="text-align: center;">MASCULINO</th>
                <th class="th " style="text-align: center;">FEMININO</th>
                <th class="th " style="text-align: center;">DISCIPLINAS</th>

                <?php
                $disciplinasNotas = collect($disciplinasNotas);

                foreach ($disciplinas as $disciplina) { ?>
                    <th rowspan="1" class="th" style="text-align: center;background-color: green; "><?php echo $disciplina->vc_acronimo ?></th>

                <?php } ?>
            </tr>


            <tr>
                <th colspan="2" class="th">Transitados</th>
                <td class="td"><?php if ($alunos->count() > 0) { echo round(((($alunosResultado->where("resultado", "TRANSITA")->count()) / $alunos->count()) * 100), 0, PHP_ROUND_HALF_UP) . '%';} ?></td>
                <td class="td"><?php echo $alunosResultado->where("resultado", "TRANSITA")->where("genero", "Masculino")->count() ?></td>
                <td class="td"><?php echo $alunosResultado->where("resultado", "TRANSITA")->where("genero", "Feminino")->count() ?></td>
                <td class="td">Positivas</td>
                <?php foreach ($disciplinas as $disciplina) { ?>
                    <td rowspan="1" class="td" style="text-align: center; "> <?php echo $disciplinasNotas->where("disciplina", $disciplina->vc_acronimo)->where("nota", ">=", 10)->count(); ?></td>
                <?php } ?>
            </tr>
            <tr>
                <th colspan="2" class="th">Não transitados</th>
                <td class="td"><?php if ($alunos->count() > 0) {echo round(((($alunosResultado->where("resultado", "N/TRANSITA")->count()) / $alunos->count()) * 100), 0, PHP_ROUND_HALF_UP) . '%';} ?></td>
                <td class="td"><?php echo $alunosResultado->where("resultado", "N/TRANSITA")->where("genero", "Masculino")->count() ?></td>
                <td class="td"><?php echo $alunosResultado->where("resultado", "N/TRANSITA")->where("genero", "Feminino")->count() ?></td>
                <td class="td">Negativas</td>

                <?php foreach ($disciplinas as $disciplina) { ?>
                    <td rowspan="1" class="td" style="text-align: center; "> <?php
                                                                                echo $disciplinasNotas->where("disciplina", $disciplina->vc_acronimo)->where("nota", "<", 10)->count(); ?></td>
                <?php } ?>
            </tr>
            <tr>
                <th colspan="2" class="th">Recurso</th>
                <td class="td"><?php if ($alunos->count() > 0) {echo round(((($alunosResultado->where("resultado", "RECURSO")->count()) / $alunos->count()) * 100), 0, PHP_ROUND_HALF_UP) . '%';} ?></td>
                <td class="td"><?php echo $alunosResultado->where("resultado", "RECURSO")->where("genero", "Masculino")->count() ?></td>
                <td class="td"><?php echo $alunosResultado->where("resultado", "RECURSO")->where("genero", "Feminino")->count() ?></td>

            </tr>
            <tr>
                <th colspan="2" class="th">Desistentes</th>
                <td class="td"></td>
            </tr>

        </table>





    </div>
    <?php
    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    date_default_timezone_set('Africa/Luanda');
    ?>
    <p class="text-center" style="margin-top: 3%;"> <?php echo  strtoupper("Uíge"); ?> , AOS <?php echo strtoupper(strftime('%d de %B de %G', strtotime(date('d-m-Y', strtotime(date('Y-m-d')))))) ?></p>
<div >
    <table style="width:30% ; margin-left:auto;margin-right:auto;margin-top:3%" >
        <tr >
            
            <th  style="font-size:27px"> O SUBDIRECTOR PEDAGÓGICO <br>
              <!-- <hr> --> <br><br>

            </th>
        </tr>
        <tr >
          
            <td class="text-center" style="font-size:35px"> <?php echo $cabecalho->vc_nomeSubdirectorPedagogico; ?> <br>
            </td>
        </tr>

    </table>
    </div>
</body>

</html>