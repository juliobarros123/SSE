<!DOCTYPE html>
<html>

<head>
    <title>Pauta Anual</title>
    <style>
        <?php
        echo $css;
        ?>
        .visa-container.left {
    left: 340;
    bottom: 40;
  }

  .visa-container.right {
    right: 340;
    bottom: 40;
  }
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
                $estatistica_resultados = collect();
                // $disciplinas = fha_disciplinas($turma->it_idCurso, $turma->it_idClasse);
                $disciplinas = fha_turmas_disciplinas_dcc( $turma->id);
                // dd(  $disciplinas);
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
                @if (fha_disciplina_exame($turma->it_idClasse, $disciplina->id))
                    <th>MFT</th>
                    <th>EX</th>
                @endif

                <th colspan="1" rowspan="1" class="th">CA({{ $turma->vc_classe }})</th>
                @php
                    $disciplina_curso_classe_actual = fh_disciplinas_cursos_classes()
                        ->where('disciplinas_cursos_classes.it_curso', $turma->it_idCurso)
                        ->where('disciplinas.id', $disciplina->id)
                        ->where('classes.vc_classe', $turma->vc_classe)
                        ->select('classes.*', 'disciplinas.vc_nome', 'disciplinas_cursos_classes.terminal')
                        ->orderBy('classes.vc_classe', 'desc')
                        ->first();
                    
                    $classes = fh_disciplinas_cursos_classes()
                        ->where('disciplinas_cursos_classes.it_curso', $turma->it_idCurso)
                        ->where('disciplinas.id', $disciplina->id)
                        ->where('classes.vc_classe', '<', $turma->vc_classe)
                        ->select('classes.*', 'disciplinas.vc_nome', 'disciplinas_cursos_classes.terminal')
                        ->orderBy('classes.vc_classe', 'desc')
                        ->get();
                @endphp
                @if (
                    $cabecalho->vc_tipo_escola == 'Técnico' &&
                        $turma->vc_classe >= 10 &&
                        $disciplina_curso_classe_actual->terminal == 'Terminal')
                    @foreach ($classes as $classe)
                        <th colspan="1" rowspan="1" class="th">CA({{ $classe->vc_classe }})</th>
                    @endforeach

                @endif
                @if (fha_disciplina_terminal($disciplina->id, $turma->it_idClasse, $turma->it_idCurso))
                    <th colspan="1" rowspan="1" class="th">CFD</th>
                @endif
                @if (fha_disciplina_terminal($disciplina->id, $turma->it_idClasse, $turma->it_idCurso) && $turma->vc_classe > 9)
                    <th colspan="1" rowspan="1" class="th">REC</th>
                @endif

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
                        /* dd($disciplinas); */
                        $mt1 = fha_media_trimestral_geral($aluno->processo, $disciplina->id, ['I'], $turma->it_idAnoLectivo);
                        $mt2 = fha_media_trimestral_geral($aluno->processo, $disciplina->id, ['II'], $turma->it_idAnoLectivo);
                        $mt3 = fha_media_trimestral_geral($aluno->processo, $disciplina->id, ['III'], $turma->it_idAnoLectivo);
                        /* dd($aluno->processo, $disciplina->id, ['I', 'II', 'III'], $turma->it_idAnoLectivo) */
                        $ca = fha_media_trimestral_geral($aluno->processo, $disciplina->id, ['I', 'II', 'III'], $turma->it_idAnoLectivo);
                    //    dd(  $ca ); 
                    @endphp
                    <td colspan="1" class="td " style="{{ $mt1 >=  nota_positiva($turma->vc_classe) ? 'color:blue' : 'color:red' }}">
                        {{ $mt1 }}</td>
                    <td colspan="1" class="td" style="{{ $mt2 >=  nota_positiva($turma->vc_classe) ? 'color:blue' : 'color:red' }}">
                        {{ $mt2 }}</td>
                    <td colspan="1" class="td" style="{{ $mt3 >=  nota_positiva($turma->vc_classe) ? 'color:blue' : 'color:red' }}">
                        {{ $mt3 }}</td>
                    @if (fha_disciplina_exame($turma->it_idClasse, $disciplina->id))
                        @php
                            $mft = fha_mfd_sem_exame($aluno->processo, $disciplina->id, $turma->it_idAnoLectivo);
                            
                            $exame = fha_nota_exame($aluno->processo, $disciplina->id, $turma->it_idAnoLectivo);
                        @endphp
                        <td colspan="1" class="td" style="{{ $mft >=  nota_positiva($turma->vc_classe) ? 'color:blue' : 'color:red' }}">
                            {{ $mft }}</td>
                        <td colspan="1" class="td" style="{{ $exame >=  nota_positiva($turma->vc_classe) ? 'color:blue' : 'color:red' }}">
                            {{ $exame }}</td>
                    @endif

                    <td colspan="1" class="td" style="{{ $ca >=  nota_positiva($turma->vc_classe) ? 'color:blue' : 'color:red' }}">
                        {{ $ca }}</td>
                    @php
                        $disciplina_curso_classe_actual = fh_disciplinas_cursos_classes()
                            ->where('disciplinas_cursos_classes.it_curso', $turma->it_idCurso)
                            ->where('disciplinas.id', $disciplina->id)
                            ->where('classes.vc_classe', $turma->vc_classe)
                            ->select('classes.*', 'disciplinas.vc_nome', 'disciplinas_cursos_classes.terminal')
                            ->orderBy('classes.vc_classe', 'desc')
                            ->first();
                        
                        $classes = fh_disciplinas_cursos_classes()
                            ->where('disciplinas_cursos_classes.it_curso', $turma->it_idCurso)
                            ->where('disciplinas.id', $disciplina->id)
                            ->where('classes.vc_classe', '<', $turma->vc_classe)
                            ->select('classes.*', 'disciplinas.vc_nome', 'disciplinas_cursos_classes.terminal')
                            ->orderBy('classes.vc_classe', 'desc')
                            ->get();
                        /* dd(    $classes ); */
                        $ca_classe_anterior = 0;
                    @endphp

                    @if (
                        $cabecalho->vc_tipo_escola == 'Técnico' &&
                            $turma->vc_classe >= 10 &&
                            $disciplina_curso_classe_actual->terminal == 'Terminal')
                        @foreach ($classes as $classe)
                            @php
                                $ca_classe_anterior = fha_ca($aluno->processo, $disciplina->id, ['I', 'II', 'III'], $classe->id);
                            @endphp
                            <td colspan="1" class="td"
                                style="{{ $ca_classe_anterior >=  nota_positiva($turma->vc_classe) ? 'color:blue' : 'color:red' }}">
                                {{ $ca_classe_anterior }}</td>
                        @endforeach
                    @endif

                    @if (fha_disciplina_terminal($disciplina->id, $turma->it_idClasse, $turma->it_idCurso))
                        @php
                            $cfd = fha_ca($aluno->processo, $disciplina->id, ['I', 'II', 'III'], $turma->it_idClasse);
                        @endphp

                        <td colspan="1" class="td" style="{{ $cfd >=  nota_positiva($turma->vc_classe) ? 'color:blue' : 'color:red' }}">
                            {{ $cfd }}</td>
                    @endif

                    @if (fha_disciplina_terminal($disciplina->id, $turma->it_idClasse, $turma->it_idCurso) && $turma->vc_classe > 9)
                        @php
                            $rec = fh_nota_recurso($aluno->processo, $disciplina->id);
                        @endphp

                        <td colspan="1" class="td" style="{{ $rec >=  nota_positiva($turma->vc_classe) ? 'color:blue' : 'color:red' }}">
                            {{ $rec }}</td>
                    @endif
                    <?php }?>
                    @php
                        $media = fhap_media_geral($aluno->processo, $turma->it_idClasse, $turma->it_idAnoLectivo);
                    @endphp
                    @php
                        
                        $color = 'red';
                        $resultados = fhap_aluno_resultato_pauta($aluno->processo, $turma->it_idCurso, $turma->it_idClasse, $turma->it_idAnoLectivo);
                        
                        if ($resultados[0] == 'TRANSITA' || $resultados[0] == 'TRANSITA/DEFICIÊNCIA') {
                            $color = 'blue';
                        }
                        $r = ['processo' => $aluno->id, 'genero' => $aluno->vc_genero, 'resultado' => $resultados[0]];
                        $estatistica_resultados->push($r);
                        
                    @endphp
                    <td colspan="1" class="td " style="color:{{ $color }}">

                        {{ $resultados[0] }}</td>


                    <td colspan="1" class="td" style="{{ $media >=  nota_positiva($turma->vc_classe) ? 'color:blue' : 'color:red' }}">
                        {{ $media }}</td>
                </tr>
            @endforeach



        </tbody>

    </table>

  
    @include('layouts._includes.fragments.lista.footer.index')
    @section('entidadade1', 'Sub Director Pedagógico')

    @section('entidadade1-valor', $cabecalho->vc_nomeSubdirectorPedagogico)

    @section('entidadade2', ' O Director Geral')

    @section('entidadade2-valor', $cabecalho->vc_nomeDirector)
    @include('layouts._includes.fragments.lista.footer.visto-2')



</body>

</html>
