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

    @php
        $estatistica_resultados = [];
    @endphp
    <div class="text-center tamanho-font">
        <p>
            <img src="<?php echo __full_path(); ?>images/ensignia/<?php echo $cabecalho->vc_ensignia; ?>.png" class="" width="50"
                height="50">
            <br>
            <?php echo $cabecalho->vc_republica; ?>
            <br>
            <?php echo $cabecalho->vc_ministerio; ?>
            <br>

            <br>

            <?php echo $cabecalho->vc_escola; ?>

        </p>

    </div>

    <div class="visto">
        <table style="width:100% ;">
            <tr>

                <th style="font-size:27px"> VISTO <br> O DIRECTOR GERAL <br>
                    <!-- <hr> -->
                    <br><br><br>

                </th>
            </tr>
            <tr>

                <td class="text-center" style="font-size:35px">
                    <?php echo $cabecalho->vc_nomeDirector; ?> <br>
                </td>
            </tr>

        </table>
    </div>


    <h2 style="text-align: center;">MAPA DE AVALIAÇÃO ANUAL</h2>
    <table class="style-table">
        <th>
            <tr>


                <td style="text-align: center;">Classe: <?php echo $detalhes_turma->vc_classe; ?></td>
                <td style="text-align: center;">Curso: <?php echo $detalhes_turma->vc_shortName; ?></td>
                <td style="text-align: center;">Turma: <?php echo $detalhes_turma->vc_nomedaTurma; ?></td>
                <td style="text-align: center;">Ano Lectivo: <?php echo $detalhes_turma->ya_inicio . '/' . $detalhes_turma->ya_fim; ?></td>
                <td style="text-align: center;">Turno: <?php echo $detalhes_turma->vc_turnoTurma; ?></td>



            </tr>


        </th>
    </table>
    <br><br>
    <table class="table">
        <thead class="">


            @php
                
                $disciplinas = fha_disciplinas($detalhes_turma->it_idCurso, $detalhes_turma->it_idClasse);
            @endphp

            <tr>
                <th class="th" rowspan="2">Nº ORDEM</th>
                <th class="th" rowspan="2">PROCESSO</th>
                <th class="th" rowspan="2">NOME</th>
                @foreach ($disciplinas as $disciplina)
                    @php
                        
                        //   dd(  $disciplina);
                    @endphp
                    @php
                        $colspan = fha_colspan($disciplina->id, $detalhes_turma->it_idClasse, $detalhes_turma->it_idCurso);
                        // dd(   $colspan);
                    @endphp
                    <th colspan="{{ $colspan }}" rowspan="1" class="th " style="text-align: center;">
                        <?php echo $disciplina->vc_acronimo; ?></th>
                @endforeach
                <th rowspan="2" class="th">RESULTADO</th>
                <th rowspan="2" class="th">MÉDIA</th>

            <tr>
                <?php foreach ($disciplinas as $disciplina) {?>
                <th colspan="1" rowspan="1" class="th">MT1</th>
                <th colspan="1" rowspan="1" class="th">MT2</th>
                <th colspan="1" rowspan="1" class="th">MT3</th>
                <?php if (fha_disciplina_terminal($disciplina->id,$detalhes_turma->it_idClasse,$detalhes_turma->it_idCurso)) {?>
                <th colspan="1" rowspan="1" class="th">CA</th>
                <th colspan="1" rowspan="1" class="th">CFD</th>
                <th colspan="1" rowspan="1" class="th">REC</th>
                <?php } else {?>
                <th colspan="1" rowspan="1" class="th">CA</th>
                <?php }?>

                <?php }?>



            </tr>

            </tr>

        </thead>
        <tbody class="">
            @foreach ($alunos as $aluno)
                <tr class="">
                    <td class="td text-center">
                        {{ $loop->index + 1 }}
                    </td>
                    <td class="td text-center">
                        {{ $aluno->id }}
                    </td>
                    <td class="td">
                        {{ $aluno->vc_primeiroNome . ' ' . $aluno->vc_nomedoMeio . ' ' . $aluno->vc_ultimoaNome }}
                    </td>

                    <?php foreach ($disciplinas as $disciplina) {?>
                    @php
                        $mt1 = fha_media_trimestral_geral($aluno->id, $disciplina->id, ['I'], $detalhes_turma->it_idAnoLectivo);
                        $mt2 = fha_media_trimestral_geral($aluno->id, $disciplina->id, ['II'], $detalhes_turma->it_idAnoLectivo);
                        $mt3 = fha_media_trimestral_geral($aluno->id, $disciplina->id, ['III'], $detalhes_turma->it_idAnoLectivo);
                        
                        $ca = fha_media_trimestral_geral($aluno->id, $disciplina->id, ['I', 'II', 'III'], $detalhes_turma->it_idAnoLectivo);
                    @endphp
                    <td colspan="1" class="td " style="{{ $mt1 >= 10 ? 'color:blue' : 'color:red' }}">
                        {{ $mt1 }}</td>
                    <td colspan="1" class="td" style="{{ $mt2 >= 10 ? 'color:blue' : 'color:red' }}">
                        {{ $mt2 }}</td>
                    <td colspan="1" class="td" style="{{ $mt3 >= 10 ? 'color:blue' : 'color:red' }}">
                        {{ $mt3 }}</td>


                    <?php if (fha_disciplina_terminal($disciplina->id,$detalhes_turma->it_idClasse,$detalhes_turma->it_idCurso)) {?>
                    <td colspan="1" class="td" style="{{ $ca >= 10 ? 'color:blue' : 'color:red' }}">
                        {{ $ca }}</td>
                    <td colspan="1" class="td" style="{{ $ca >= 10 ? 'color:blue' : 'color:red' }}">{{ fha_cfd($aluno->id, $disciplina->id) }}</td>
                    @php
                        
                        $rec = fh_nota_recurso($aluno->id, $disciplina->id);
                    @endphp
                    <td colspan="1" class="td" style="{{ $rec >= 10 ? 'color:blue' : 'color:red' }}">
                        {{ $rec }}</td>
                    <?php } else {?>
                    <td colspan="1" class="td" style="{{ $ca >= 10 ? 'color:blue' : 'color:red' }}">
                        {{ $ca }}</td>
                    <?php }?>

                    <?php }?>
                    @php
                        $media = fhap_media_geral($aluno->id, $detalhes_turma->it_idCurso, $detalhes_turma->it_idClasse, $detalhes_turma->it_idAnoLectivo);
                    @endphp
                    @php
                        $color = 'red';
                        $resultados = fhap_aluno_resultato_pauta($aluno->id, $detalhes_turma->it_idCurso, $detalhes_turma->it_idClasse, $detalhes_turma->it_idAnoLectivo);
                        // dd(  $resultados);
                        if ($resultados[0] == 'TRANSITA' || $resultados[0] == 'TRANSITA/DEFICIÊNCIA') {
                            $color = 'blue';
                        }
                        $r = ['processo' => $aluno->id, 'genero' => $aluno->vc_genero, 'resultado' => $resultados[0]];
                        array_push($estatistica_resultados, $r);
                    @endphp
                    <td colspan="1" class="td " style="color:{{ $color }}">

                        {{ $resultados[0] }}</td>
                    <td colspan="1" class="td" style="{{ $media >= 10 ? 'color:blue' : 'color:red' }}">
                        {{ $media }}</td>
                </tr>
            @endforeach



        </tbody>

    </table>
    @php
        
        $estatistica_resultados = collect($estatistica_resultados);
        // dd(  $estatistica_resultados);
        $nao_transitados = $estatistica_resultados->where('resultado', 'N/TRANSITA')->count();
        $nao_transitados_masculino = $estatistica_resultados
            ->where('resultado', 'N/TRANSITA')
            ->where('genero', 'Masculino')
            ->count();
        $nao_transitados_feminino = $estatistica_resultados
            ->where('resultado', 'N/TRANSITA')
            ->where('genero', 'Feminino')
            ->count();
        
        $transitados = $estatistica_resultados->where('resultado', 'TRANSITA')->count();
        $transitados_masculino = $estatistica_resultados
            ->where('resultado', 'TRANSITA')
            ->where('genero', 'Masculino')
            ->count();
        $transitados_feminino = $estatistica_resultados
            ->where('resultado', 'TRANSITA')
            ->where('genero', 'Feminino')
            ->count();
        
        $recurso = $estatistica_resultados->where('resultado', 'RECURSO')->count();
        $recurso_masculino = $estatistica_resultados
            ->where('resultado', 'RECURSO')
            ->where('genero', 'Masculino')
            ->count();
        $recurso_feminino = $estatistica_resultados
            ->where('resultado', 'RECURSO')
            ->where('genero', 'Feminino')
            ->count();
        $dificiencia = $estatistica_resultados->where('resultado', 'TRANSITA/DEFICIÊNCIA')->count();
        $dificiencia_masculino = $estatistica_resultados
            ->where('resultado', 'TRANSITA/DEFICIÊNCIA')
            ->where('genero', 'Masculino')
            ->count();
        $dificiencia_feminino = $estatistica_resultados
            ->where('resultado', 'TRANSITA/DEFICIÊNCIA')
            ->where('genero', 'Feminino')
            ->count();
        
        // dd($nao_transitados,$transitados,$recurso,$dificiencia);
        
    @endphp

    <div>
        <br><br>

    </div>

    <div>
        <br><br>
        <table class="table">
            <tr>
                <th colspan="3" class="th " style="text-align: center;  border: 1px solid black;height:50px;">
                    Estatistica</th>
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
             

                foreach ($disciplinas as $disciplina) { ?>
                <th rowspan="1" class="th" style="text-align: center;background-color: green; ">
                    <?php echo $disciplina->vc_acronimo; ?>
                </th>

                <?php } ?>
            </tr>


            <tr>
                <th colspan="2" class="th">Transitados</th>
                <td class="td">
                    {{ fh_arredondar(($transitados / count($alunos)) * 100) }}%
                </td>
                <td class="td">
                    {{ $transitados_masculino }}
                </td>
                <td class="td">
                    {{ $transitados_feminino }}
                </td>
                <td class="td">Positivas</td>
                <?php foreach ($disciplinas as $disciplina) { ?>
                <td rowspan="1" class="td" style="text-align: center; ">
                    {{ fha_qt_neg_pos_disciplina($disciplina->id, $detalhes_turma->id, ['I', 'II', 'III'], $detalhes_turma->it_idAnoLectivo)['positivas'] }}

                </td>
                <?php } ?>
            </tr>
            <tr>
                <th colspan="2" class="th">Não transitados</th>
                <td class="td">
                    {{ fh_arredondar(($nao_transitados / count($alunos)) * 100) }}%
                </td>
                <td class="td">
                    {{ $nao_transitados_masculino }}
                </td>
                <td class="td">
                    {{ $nao_transitados_feminino }}
                </td>
                <td class="td">Negativas</td>

                <?php foreach ($disciplinas as $disciplina) { ?>
                <td rowspan="1" class="td" style="text-align: center; ">
                    {{ fha_qt_neg_pos_disciplina($disciplina->id, $detalhes_turma->id, ['I', 'II', 'III'], $detalhes_turma->it_idAnoLectivo)['negativas'] }}
                </td>
                <?php } ?>
            </tr>
            <tr>
                <th colspan="2" class="th">Recurso</th>
                <td class="td">
                    {{ fh_arredondar(($recurso / count($alunos)) * 100) }}%
                </td>
                <td class="td">
                    {{ $recurso_masculino }}
                </td>
                <td class="td">
                    {{ $recurso_feminino }}
                </td>

            </tr>
            <tr>
                <th colspan="2" class="th">TRANSITA/DEFICIÊNCIA</th>
                <td class="td">
                    {{ fh_arredondar(($dificiencia / count($alunos)) * 100) }}%
                </td>
                <td class="td">
                    {{ $dificiencia_masculino }}
                </td>
                <td class="td">
                    {{ $dificiencia_feminino }}
                </td>

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
    <p class="text-center" style="margin-top: 3%;">
        <?php echo strtoupper('Uíge'); ?> , AOS
        <?php echo strtoupper(strftime('%d de %B de %G', strtotime(date('d-m-Y', strtotime(date('Y-m-d')))))); ?>
    </p>
    <div>
        <table style="width:30% ; margin-left:auto;margin-right:auto;margin-top:3%">
            <tr>

                <th style="font-size:27px"> O SUBDIRECTOR PEDAGÓGICO <br>
                    <!-- <hr> --> <br><br>

                </th>
            </tr>
            <tr>

                <td class="text-center" style="font-size:35px">
                    <?php echo $cabecalho->vc_nomeSubdirectorPedagogico; ?> <br>
                </td>
            </tr>

        </table>
    </div>
    @php
        // dd("o");
    @endphp

</html>
