



<!DOCTYPE html>
<html>

<head>
    <title> Lista de Candidatos Aceitos</title>
    <style>
        <?php
        echo $css;
        ?>
    </style>
</head>

<body>
    @include('layouts._includes.fragments.lista.header')

    <div class="title">
        Lista de Candidatos Aceitos
    </div>
    <div class="dates">
        <strong>Ano Lectivo:</strong>
        {{ $ano_lectivo }}
        &nbsp;
        <strong>Curso:</strong>
        {{ $curso }}
        &nbsp;
        <strong>Classe:</strong>
        {{ $classe }}ª
        &nbsp;
    </div>
    <table class="table">
        <thead>
            <tr>
            <th >Nº de ordem</th>
                <th >Processo</th>
                <th>Nome</th>
                <th>B.I/CÉDULA Nº</th>
                <th width="50px">Idade</th>
            </tr>
        </thead>
        <tbody>
        <tbody>
        <?php $contador = 1; ?>
            <?php foreach ($alunos as $aluno): ?>
                <tr>
                    <td>
                        <?php echo $contador++; ?>
                    </td>
                    <td>
                        <?php echo $aluno->processo ?>
                    </td>
                    <td class="text-left">
                        <?php echo $aluno->vc_primeiroNome . " " . $aluno->vc_nomedoMeio . " " . $aluno->vc_apelido; ?>
                    </td>
                    <td>
                        <?php echo $aluno->vc_bi ?>
                    </td>
                    <td>

                    
                        <?php calcularIdade($aluno->dt_dataNascimento) ?>

                    </td>
                </tr>

            <?php endforeach; ?>

            <br>
        </tbody>
        </tbody>
    </table>
    @include('layouts._includes.fragments.lista.footer.index')
    @section('entidadade1', 'O COORDENADOR DA COMISSÃO')
    @if (0)
        @section('entidadade1-valor', 'xxxxxxxxxx')
    @else
        @section('entidadade1-valor', '-----------------------')
    @endif
    @section('entidadade2', 'O SUBDIRECTOR PEDAGÓGICO')
    @section('entidadade2-valor', $cabecalho->vc_nomeSubdirectorPedagogico)
    @include('layouts._includes.fragments.lista.footer.visto-2')



</body>

</html>
