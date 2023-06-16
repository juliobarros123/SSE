<!DOCTYPE html>
<html>

<head>
    <title>Lista de Propinas por Turma(Alunos)</title>
    <style>
        <?php
        echo $css;
        ?>
    </style>
</head>

<body>
    @include('layouts._includes.fragments.lista.header')

    <div class="title">
        Lista de Propinas por Turma(Alunos)
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
        <br>

        <strong>Mês:</strong>
        {{ $propinas_turma_aluno_lista['mes'] }}
        &nbsp;

        <strong>Estado:</strong>
        {{ $propinas_turma_aluno_lista['estado'] }}

    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Nº de ordem</th>
                <th>Processo</th>
                <th>Nome completo</th>
                <th>Gênero</th>
                <th>Dt. Nascimento</th>
                <th>Idade</th>
                <th>Observações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($turma_alunos as $aluno)
                @php
                /* dd($aluno); */
                    $cont = $pagamentos = fh_pagamentos()
                        ->where('pagamentos.mes', $propinas_turma_aluno_lista['mes'])
                        ->where('pagamentos.id_aluno',$aluno->id_aluno)
                        ->count();
                @endphp
                @if ($propinas_turma_aluno_lista['estado'] == 'Pagas')
                    @if ($cont)
                        <tr>
                            <td>
                                {{ $loop->index + 1 }}
                            </td>
                            <td>
                                {{ $aluno->processo }}
                            </td>
                            <td>
                                {{ $aluno->vc_primeiroNome . ' ' . $aluno->vc_nomedoMeio . ' ' . $aluno->vc_apelido }}
                            </td>
                            <td>
                                {{ $aluno->vc_genero }}
                            </td>
                            <td>
                                {{ date('d/m/Y', strtotime($aluno->dt_dataNascimento)) }}
                            </td>
                            <td>
                                {{ calcularIdade($aluno->dt_dataNascimento) }}
                            </td>
                            <td>
                                @php
                                    
                                @endphp
                            </td>


                        </tr>
                    @endif
                @else
                    @if (!$cont)
                        <tr>
                            <td>
                                {{ $loop->index + 1 }}
                            </td>
                            <td>
                                {{ $aluno->processo }}
                            </td>
                            <td>
                                {{ $aluno->vc_primeiroNome . ' ' . $aluno->vc_nomedoMeio . ' ' . $aluno->vc_apelido }}
                            </td>
                            <td>
                                {{ $aluno->vc_genero }}
                            </td>
                            <td>
                                {{ date('d/m/Y', strtotime($aluno->dt_dataNascimento)) }}
                            </td>
                            <td>
                                {{ calcularIdade($aluno->dt_dataNascimento) }}
                            </td>
                            <td>
                                @php
                                    
                                @endphp
                            </td>


                        </tr>
                    @endif
                @endif
            @endforeach
        </tbody>
    </table>
    @include('layouts._includes.fragments.lista.footer.index')




</body>

</html>
