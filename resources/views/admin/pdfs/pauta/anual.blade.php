<!DOCTYPE html>
<html>

<head>
    <title>Pauta Anual</title>
    <style>
        <?php
        echo $css;
        ?>
    </style>
</head>

<body>
    @include('layouts._includes.fragments.lista.header')

    <div class="title">
        Pauta Anual
    </div>
    <div class="dates">
        <strong>Turma:</strong>
        {{ $turma->vc_nomedaTurma }}
        &nbsp;
        <strong>Turno:</strong>
        {{ $turma->vc_turnoTurma }}
        &nbsp;
        <strong>Classe:</strong>
        {{ $turma->vc_classe }}ª
        &nbsp;
        <strong>Curso:</strong>
        {{ $turma->vc_shortName }}
        &nbsp;
        <strong>Qt. Alunos:</strong>
        {{ $turma->it_qtMatriculados }}
        &nbsp;
        <strong>Ano Lectivo:</strong>
        {{ $turma->ya_inicio . '/' . $turma->ya_fim }}

    </div>
    <table class="table">
        <thead>


            @php
                $estatistica_resultados=collect();
                $disciplinas = fha_disciplinas($turma->it_idCurso, $turma->it_idClasse);
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
                        $colspan = fha_colspan($disciplina->id, $turma->it_idClasse, $turma->it_idCurso);
                        // dd(   $colspan);
                    @endphp
                    <th colspan="{{ $colspan }}" rowspan="1" class="th " style="text-align: center;">
                        <?php echo $disciplina->vc_acronimo; ?></th>
                @endforeach
                <th rowspan="2" class="th">OBS</th>
                <th rowspan="2" class="th">MÉDIA</th>
            <tr>
                <?php foreach ($disciplinas as $disciplina) {?>
                <th colspan="1" rowspan="1" class="th">MT1</th>
                <th colspan="1" rowspan="1" class="th">MT2</th>
                <th colspan="1" rowspan="1" class="th">MT3</th>
                <?php if (fha_disciplina_terminal($disciplina->id,$turma->it_idClasse,$turma->it_idCurso)) {?>
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
        <tbody>
            @foreach ($alunos as $aluno)
                <tr>
                    <td class="td text-center">
                        {{ $loop->index + 1 }}
                    </td>
                    <td class="td text-center">
                        {{ $aluno->processo }}
                    </td>
                    <td class="td">
                        {{ $aluno->vc_primeiroNome . ' ' . $aluno->vc_nomedoMeio . ' ' . $aluno->vc_apelido }}
                    </td>

                    <?php foreach ($disciplinas as $disciplina) {?>
                    @php
                        $mt1 = fha_media_trimestral_geral($aluno->processo, $disciplina->id, ['I'], $turma->it_idAnoLectivo);
                        $mt2 = fha_media_trimestral_geral($aluno->processo, $disciplina->id, ['II'], $turma->it_idAnoLectivo);
                        $mt3 = fha_media_trimestral_geral($aluno->processo, $disciplina->id, ['III'], $turma->it_idAnoLectivo);
                        
                        $ca = fha_media_trimestral_geral($aluno->processo, $disciplina->id, ['I', 'II', 'III'], $turma->it_idAnoLectivo);
                    @endphp
                    <td colspan="1" class="td " style="{{ $mt1 >= 10 ? 'color:blue' : 'color:red' }}">
                        {{ $mt1 }}</td>
                    <td colspan="1" class="td" style="{{ $mt2 >= 10 ? 'color:blue' : 'color:red' }}">
                        {{ $mt2 }}</td>
                    <td colspan="1" class="td" style="{{ $mt3 >= 10 ? 'color:blue' : 'color:red' }}">
                        {{ $mt3 }}</td>


                    <?php if (fha_disciplina_terminal($disciplina->id,$turma->it_idClasse,$turma->it_idCurso)) {?>
                    <td colspan="1" class="td" style="{{ $ca >= 10 ? 'color:blue' : 'color:red' }}">
                        {{ $ca }}</td>
                    <td colspan="1" class="td" style="{{ $ca >= 10 ? 'color:blue' : 'color:red' }}">
                        {{ fha_cfd($aluno->processo, $disciplina->id) }}</td>
                    @php
                        
                        $rec = fh_nota_recurso($aluno->processo, $disciplina->id);
                    @endphp
                    <td colspan="1" class="td" style="{{ $rec >= 10 ? 'color:blue' : 'color:red' }}">
                        {{ $rec }}</td>
                    <?php } else {?>
                    <td colspan="1" class="td" style="{{ $ca >= 10 ? 'color:blue' : 'color:red' }}">
                        {{ $ca }}</td>
                    <?php }?>

                    <?php }?>
                    @php
                        $media = fhap_media_geral($aluno->processo, $turma->it_idClasse, $turma->it_idAnoLectivo);
                    @endphp
                    @php
                        
                        $color = 'red';
                        $resultados = fhap_aluno_resultato_pauta($aluno->processo, $turma->it_idCurso, $turma->it_idClasse, $turma->it_idAnoLectivo);
                        /* dd($resultados); */
                        if ($resultados[0] == 'TRANSITA' || $resultados[0] == 'TRANSITA/DEFICIÊNCIA') {
                            $color = 'blue';
                        }
                        $r = ['processo' => $aluno->id, 'genero' => $aluno->vc_genero, 'resultado' => $resultados[0]];
                       $estatistica_resultados->push($r);
                        
                    @endphp
                    <td colspan="1" class="td " style="color:{{ $color }}">

                        {{ $resultados[0] }}</td>


                    <td colspan="1" class="td" style="{{ $media >= 10 ? 'color:blue' : 'color:red' }}">
                        {{ $media }}</td>
                </tr>
            @endforeach



        </tbody>

    </table>
    @include('layouts._includes.fragments.lista.footer.index')
    @include('layouts._includes.fragments.lista.footer.visto')



</body>

</html>
