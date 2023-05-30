<!DOCTYPE html>
<html>

<head>
    <title>Pauta Trimestral</title>
    <style>
        <?php
        echo $css;
        ?>
    </style>
</head>

<body>
    @include('layouts._includes.fragments.lista.header')

    <div class="title">
        Pauta Trimestral
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

        <strong>Ano Lectivo:</strong>
        {{ $turma->ya_inicio . '/' . $turma->ya_fim }}
        <strong>Trimestre:</strong>
        {{ $trimestre }}

    </div>
    <table class="table">
        <thead>
            <tr>
            <tr>
                <th>Nº ORDEM</th>
                <th>PROCESSO</th>
                <th>NOME COMPLETO</th>

                @foreach ($disciplinas as $disciplina)
                    <th>
                        {{ $disciplina->vc_acronimo }}
                    </th>
                @endforeach
                <th>MT</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($alunos as $aluno)
                <tr>
                    <td>{{ $loop->index + 1 }} </td>
                    <td>{{ $aluno->processo }}</td>
                    <td>
                        {{ $aluno->vc_primeiroNome . ' ' . $aluno->vc_nomedoMeio . ' ' . $aluno->vc_apelido }} </td>

                    @foreach ($disciplinas as $disciplina)
                        @php
                            $media = fha_media_trimestre_por_ano($aluno->processo, $disciplina->id, $trimestre, $turma->it_idAnoLectivo);
                        @endphp
                        <td style="color:<?php echo $media >= 10 ? 'blue' : 'red'; ?>">{{ $media }} </td>
                    @endforeach
                    @php
                        $media = fhap_media_trimestre_disciplinas($aluno->processo, $trimestre, $turma->it_idClasse, $turma->it_idAnoLectivo);
                    @endphp
                    <td style="color:<?php echo $media >= 10 ? 'blue' : 'red'; ?>">{{ $media }} </td>

                   

                </tr>
            @endforeach
        </tbody>
    </table>
    @include('layouts._includes.fragments.lista.footer.index')
    @section('entidadade1', 'O DIRECTOR DE TURMA')
    @if($director_turma)
    @section('entidadade1-valor', $director_turma->vc_primemiroNome . ' ' . $director_turma->vc_apelido)
    @else
    @section('entidadade1-valor', '-----------------------')

    @endif
    @section('entidadade2', 'O SUBDIRECTOR PEDAGÓGICO')
    @section('entidadade2-valor', $cabecalho->vc_nomeSubdirectorPedagogico)
    @include('layouts._includes.fragments.lista.footer.visto-2')



</body>

</html>
