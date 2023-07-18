<!DOCTYPE html>
<html>

<head>
    <title>Lista de Alunos</title>
    <style>
        <?php 
        echo $css;
        ?>
    </style>
</head>

<body>
   @include('layouts._includes.fragments.lista.header')

    <div class="title">
        Lista de alunos
    </div>
    <div class="dates">
        <strong>Turma:</strong>
        {{$turma->vc_nomedaTurma}}
        &nbsp;
        <strong>Turno:</strong>
        {{$turma->vc_turnoTurma}}
        &nbsp;
        <strong>Classe:</strong>
        {{$turma->vc_classe}}ª
        &nbsp;
        <strong>Curso:</strong>
        {{$turma->vc_shortName}}
        &nbsp;
        <strong>Qt. Alunos:</strong>
        {{$turma->it_qtMatriculados}}
        &nbsp;
        <strong>Ano Lectivo:</strong>
        {{$turma->ya_inicio.'/'.$turma->ya_fim}}
        
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
               
   
            <tr>
                <td>
                    {{$loop->index+1}}
                </td>
                <td>
                    {{$aluno->processo}}
                </td>
                <td>
                    {{ $aluno->vc_primeiroNome . ' ' . $aluno->vc_nomedoMeio . ' ' . $aluno->vc_apelido }}
                </td>
                <td>
                    {{$aluno->vc_genero}} 
                </td>
                <td>
                    {{ date('d/m/Y', strtotime($aluno->dt_dataNascimento)) }}
                </td>
                <td>
                    {{ calcularIdade($aluno->dt_dataNascimento)}} 
                </td>
                <td>
                    {{-- <?php echo $aluno['email']; ?> --}}
                </td>
              

            </tr>
            @endforeach
        </tbody>
    </table>
    @include('layouts._includes.fragments.lista.footer.index')
    @section('entidadade1', 'O Director de Turma')
    @if (fha_director_turma($turma->id))
        @section('entidadade1-valor', fha_director_turma($turma->id))
    @else
        @section('entidadade1-valor', '---------------------')
    @endif
    @section('entidadade2', 'O Director Geral')
    @section('entidadade2-valor', $cabecalho->vc_nomeSubdirectorPedagogico)
    @include('layouts._includes.fragments.lista.footer.visto-2')

   

   
</body>

</html>
