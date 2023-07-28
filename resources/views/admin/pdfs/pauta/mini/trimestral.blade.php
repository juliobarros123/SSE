<!DOCTYPE html>
<html>

<head>
    <title>Mini pauta de aproveitamente</title>
    <style>
        <?php
        echo $css;
        ?>
    </style>
</head>

<body>
    @include('layouts._includes.fragments.lista.header')

    <div class="title">
        Mini pauta de aproveitamente
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
        <strong>Disciplina:</strong>
        {{ $turma_professor->disciplina }}
    </div>
    
    <table class="table">
        <thead>
            <tr>
            <tr>
                <th>Nº ORDEM</th>
                <th>PROCESSO</th>
                <th>NOME COMPLETO</th>
                <th>MAC</th>
                <th>NPP</th>
                @if(fha_disciplina_exame($turma->it_idClasse,$turma_professor->id_disciplina) && $trimestre=='III' )
                
                <th>EX</th>
                @else
                <th>NPT</th>

                @endif
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
                    @php
                        $mac = fha_mac_trimestre_por_ano($aluno->processo, $turma_professor->id_disciplina, $trimestre, $turma->it_idAnoLectivo);
                        $nota1 = fha_nota1_trimestre_por_ano($aluno->processo, $turma_professor->id_disciplina, $trimestre, $turma->it_idAnoLectivo);
                        $nota2 = fha_nota2_trimestre_por_ano($aluno->processo, $turma_professor->id_disciplina, $trimestre, $turma->it_idAnoLectivo);
                        /* $media = fha_media_trimestre_por_ano($aluno->processo, $turma_professor->id_disciplina, $trimestre, $turma->it_idAnoLectivo); */
                        $media = fha_media_trimestral_geral($aluno->processo, $turma_professor->id_disciplina, [ $trimestre], $turma->it_idAnoLectivo);
                    @endphp
                    <td style="color:<?php echo $mac >= nota_positiva($turma->vc_classe) ? 'blue' : 'red'; ?>">{{ $mac }}</td>
                    <td style="color:<?php echo $nota1 >= nota_positiva($turma->vc_classe) ? 'blue' : 'red'; ?>">{{ $nota1 }} </td>
                    <td style="color:<?php echo $nota2 >= nota_positiva($turma->vc_classe) ? 'blue' : 'red'; ?>">{{ $nota2 }} </td>
                    <td style="color:<?php echo $media >= nota_positiva($turma->vc_classe) ? 'blue' : 'red'; ?>">{{ $media }} </td>

                </tr>
            @endforeach
        </tbody>
    </table>
    @include('layouts._includes.fragments.lista.footer.index')
    @section('entidadade1', 'O PROFESSOR')
    @section('entidadade1-valor', $turma_professor->vc_primemiroNome . ' ' . $turma_professor->vc_apelido)
    @section('entidadade2', 'O SUBDIRECTOR PEDAGÓGICO')
    @section('entidadade2-valor', $cabecalho->vc_nomeSubdirectorPedagogico)
    @include('layouts._includes.fragments.lista.footer.visto-2')



</body>

</html>
