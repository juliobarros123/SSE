<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
            margin-top: -60px;
            margin-right: -110px;
            float: left;
            z-index: 1;
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
    </style>

    <div class="text-center tamanho-font">
        <p>
           <img src="<?php echo __full_path()?>images/ensignia/<?php echo $cabecalho->vc_ensignia; ?>.png" class="" width="50" height="50">
            <br>
            <?php echo $cabecalho->vc_republica; ?>
            <br>
            <?php echo $cabecalho->vc_ministerio; ?>
            <br>
                      <!--  <img src="<?php /*echo $cabecalho->vc_logo;*/ ?>" class="logotipo" width="100" height="100"> -->
            <?php echo $cabecalho->vc_escola; ?>
        </p>

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
    <table class="table">
        <thead class="">





            <tr>
                <th class="th" rowspan="2">Nº ORDEM</th>
                <th class="th" rowspan="2">PROCESSO</th>
                <th class="th" rowspan="2">NOME</th>


                <?php foreach ($disciplinas as $disciplina) { ?>

                    <?php if ($disciplinas_terminas->where('id', $disciplina->id)->count()) {
                        $QtDeClasses = 0; ?>
                        <?php for ($cont = $detalhes_turma->vc_classe - 1; $cont >= 10; $cont--) { ?>
                            <?php $QtDeClasses++; ?> <?php } ?> <th colspan="<?php echo 5 + $QtDeClasses ?>" rowspan="1" class="th " style="text-align: center;"><?php echo $disciplina->vc_acronimo ?></th>
                            <?php } else { ?>
                                <th colspan="4" rowspan="1" class="th " style="text-align: center;"><?php echo $disciplina->vc_acronimo ?></th>
                            <?php } ?>


                            <?php if ($disciplinas->max('id') == $disciplina->id) { ?>
                                <th rowspan="2" class="th">RESULTADO</th>
                                <th rowspan="2" class="th">MÉDIA</th>
                            <?php } ?>
                        <?php } ?>



            <tr>
                <?php foreach ($disciplinas as $disciplina) { ?>
                    <?php if ($disciplinas_terminas->where('id', $disciplina->id)->count()) { ?>
                        <?php for ($cont = $detalhes_turma->vc_classe - 1; $cont >= 10; $cont--) { ?>
                            <th colspan="1" rowspan="1" class="th"> <?php echo $cont; ?>ª CA</th>
                        <?php } ?>
                    <?php } ?>

                    <th colspan="1" rowspan="1" class="th">MT1</th>
                    <th colspan="1" rowspan="1" class="th">MT2</th>
                    <th colspan="1" rowspan="1" class="th">MT3</th>
                    <?php if ($disciplinas_terminas->where('id', $disciplina->id)->count()) { ?>
                        <th colspan="1" rowspan="1" class="th">CA</th>
                        <th colspan="1" rowspan="1" class="th">CFD</th>
                    <?php } else { ?>
                        <th colspan="1" rowspan="1" class="th">CA</th>
                    <?php } ?>

                <?php } ?>



            </tr>

            </tr>







        </thead>
        <tbody class="">
            <?php $processos = [];

            ?>
            <?php $contador = 1 ?>
            <?php $qtDisciplinaNegativa = 0 ?>
            <?php $qtMasculinosTransitados = array() ?>
            <?php $qtFemininoTransitados = array() ?>
            <?php $qtMasculinosNTransitados = array() ?>
            <?php $qtFemininoNTransitados = array() ?>
            <?php $somaAcs = 0 ?>
            <?php $ttlReprovados = 0 ?>
            <?php $disciplinasNegativas = array(); ?>
            <?php $disciplinasPositivas = array();
            $dataOutrosAnos = array() ?>
            <?php foreach ($alunos as $aluno) {


                if (!in_array($aluno->id, $processos)) { ?>


                    <tr class="">
                        <td class="td"><?php echo $contador++ ?> </td>
                        <td class="td"> <?php echo $aluno->id ?> </td>
                        <td class="td"> <?php echo $aluno->vc_primeiroNome . ' ' . $aluno->vc_nomedoMeio . ' ' . $aluno->vc_ultimoaNome ?> </td>
                        <?php foreach ($disciplinas as $disciplina) {

                            $mat1 = isset($notas->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'I')->where('id_aluno', $aluno->id)->first()->fl_media) ? $notas->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'I')->where('id_aluno', $aluno->id)->first()->fl_media : 0;
                            $mat2 = isset($notas->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'II')->where('id_aluno', $aluno->id)->first()->fl_media) ? $notas->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'II')->where('id_aluno', $aluno->id)->first()->fl_media : 0;
                            $mat3 = isset($notas->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'III')->where('id_aluno', $aluno->id)->first()->fl_media) ? $notas->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'III')->where('id_aluno', $aluno->id)->first()->fl_media : 0;
                            // dd($disciplinas_terminas);
                            if ($disciplinas_terminas->where('id', $disciplina->id)->count()) {
                                $dataOutrosAnos = mediaDosAnos($aluno->id, $disciplina->id, "''", $detalhes_turma->it_idClasse);

                                if (isset($dataOutrosAnos['ACS'])) {

                                    for ($cont = $detalhes_turma->vc_classe - 1; $cont >= 10; $cont--) {

                                        if (count($dataOutrosAnos['ACS'])) {
                                            for ($i = 0; $i < count($dataOutrosAnos['ACS']); $i++) {
                                                if (isset($dataOutrosAnos['ACS'][$i])) {
                                                    $nota = isset($dataOutrosAnos['ACS'][$i]['ca']) ? $dataOutrosAnos['ACS'][$i]['ca'] : 0;
                                                    // if($aluno->id=='13518'){
                                                    //     dd($dataOutrosAnos['ACS'],$cont,$i,$cont==$dataOutrosAnos['ACS'][$i]['vc_classe']);
                                                    //   }
                                                    if ($cont == $dataOutrosAnos['ACS'][$i]['vc_classe']) {

                                                        echo "<td colspan='1' rowspan='1' class='td'>$nota</td>";
                                                    } else {
                                                        // echo "<td colspan='1' rowspan='1' class='td'  >0</td>";
                                                    }
                                                }
                                            }
                                        } else {
                                            // $diferenfaClasse = $detalhes_turma->vc_classe - (10 + count($dataOutrosAnos['ACS']));
                                            // for ($contNotaFake = 1; $contNotaFake <= $diferenfaClasse; $contNotaFake++) {
                                            echo "<td colspan='1' rowspan='1' class='td'  >0</td>";
                                            // }
                                        }
                                    }
                                }

                                $cfd = $dataOutrosAnos['media'];
                            }
                            $ac = round((($mat1 + $mat2 + $mat3) / 3), 0, PHP_ROUND_HALF_UP);


                            if (isset($cfd) && $cfd != 0) {
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

                            <td colspan="1" rowspan="1" class="td" style=" color:<?php echo $mat1 >= 10 ? 'blue' : 'red' ?>"><?php echo $mat1; ?></td>
                            <td colspan="1" rowspan="1" class="td" style=" color:<?php echo $mat2 >= 10 ? 'blue' : 'red' ?>"><?php echo $mat2; ?></td>
                            <td colspan="1" rowspan="1" class="td" style=" color:<?php echo $mat3 >= 10 ? 'blue' : 'red' ?>"><?php echo $mat3; ?></td>

                            <?php if ($disciplinas_terminas->where('id', $disciplina->id)->count()) { ?>
                                <?php $ac = round((($mat1 + $mat2 + $mat3) / 3), 0, PHP_ROUND_HALF_UP); ?>
                                <td colspan="1" rowspan="1" class="td" style=" color:<?php echo $ac >= 10 ? 'blue' : 'red' ?>"><?php echo $ac ?></td>
                                <td colspan="1" rowspan="1" class="td" style=" color:<?php echo $ac >= 10 ? 'blue' : 'red' ?>"><?php echo $cfd;
                                                                                                                                $cfd = 0 ?></td>
                            <?php } else { ?>
                                <td colspan="1" rowspan="1" class="td" style=" color:<?php echo $ac >= 10 ? 'blue' : 'red' ?>"><?php echo $ac ?></td>
                            <?php } ?>
                            <?php $ac  >= 10 ? '' : $qtDisciplinaNegativa++ ?>


                        <?php } ?>
                        <td colspan="1" rowspan="1" class="td" style=" color:<?php echo $qtDisciplinaNegativa >= 3 ? 'red' : 'black' ?>">

                            <?php if ($qtDisciplinaNegativa >= 3) {

                                if ($aluno->vc_genero == 'Masculino') {
                                    array_push($qtMasculinosNTransitados, $aluno->vc_genero);
                                } else {
                                    array_push($qtFemininoNTransitados, $aluno->vc_genero);
                                }
                                echo 'N/TRANSITA';

                                $ttlReprovados++;
                            } else {
                                if ($aluno->vc_genero == 'Masculino') {
                                    array_push($qtMasculinosTransitados, $aluno->vc_genero);
                                } else {
                                    array_push($qtFemininoTransitados, $aluno->vc_genero);
                                }
                                echo 'TRANSITA';
                            }

                            ?></td>

                        <td colspan="1" rowspan="1" class="td" style=" color:<?php echo round(($somaAcs / $disciplinas->count()), 0, PHP_ROUND_HALF_UP) >= 10 ? 'blue' : 'red' ?>"><?php echo round((($somaAcs / $disciplinas->count())), 0, PHP_ROUND_HALF_UP);
                                                                                                                                                            $somaAcs = 0; ?></td>

                    </tr>
            <?php }

                array_push($processos, $aluno->id);

                $qtDisciplinaNegativa = 0;
            } ?>
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

                <?php foreach ($disciplinas as $disciplina) { ?>
                    <th rowspan="1" class="th" style="text-align: center;background-color: green; "><?php echo $disciplina->vc_acronimo ?></th>

                <?php } ?>
            </tr>


            <tr>
                <th colspan="2" class="th">Transitados</th>
                <td class="td"><?php echo round(((($alunos->count() - $ttlReprovados) / $alunos->count()) * 100) . '%' ?></td>
                <td class="td"><?php echo count($qtMasculinosTransitados) ?></td>
                <td class="td"><?php echo count($qtFemininoTransitados) ?></td>
                <td class="td">Positivas</td>
                <?php foreach ($disciplinas as $disciplina) { ?>
                    <td rowspan="1" class="td" style="text-align: center; "> <?php $cont = 0;
                                                                                foreach (collect($disciplinasPositivas) as $i) {
                                                                                    if ($i == $disciplina->id) {
                                                                                        $cont++;
                                                                                    }
                                                                                }
                                                                                echo $cont; ?></td>
                <?php } ?>
            </tr>
            <tr>
                <th colspan="2" class="th">Não transitados</th>
                <td class="td"><?php echo round((($ttlReprovados / $alunos->count()) * 100) . '%' ?></td>
                <td class="td"><?php echo count($qtMasculinosNTransitados) ?></td>
                <td class="td"><?php echo count($qtFemininoNTransitados) ?></td>
                <td class="td">Negativas</td>

                <?php foreach ($disciplinas as $disciplina) { ?>
                    <td rowspan="1" class="td" style="text-align: center; "> <?php $cont = 0;
                                                                                foreach (collect($disciplinasNegativas) as $i) {
                                                                                    if ($i == $disciplina->id) {
                                                                                        $cont++;
                                                                                    }
                                                                                }
                                                                                echo $cont; ?></td>
                <?php } ?>
            </tr>
            <tr>
                <th colspan="2" class="th">Desistentes</th>
                <td class="td"></td>
            </tr>

        </table>





    </div>

    <p style="text-align:center"> Uíge aos <?php echo date('d') ?> de <?php echo date('m') ?> de <?php echo date('Y') ?> </p>
</body>

</html>