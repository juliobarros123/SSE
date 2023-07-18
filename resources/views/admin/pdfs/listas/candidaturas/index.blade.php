<!DOCTYPE html>
<html>

<head>
    <title> Lista de candidatos</title>
    <style>
        <?php
        echo $css;
        ?>
    </style>
</head>

<body>
    @include('layouts._includes.fragments.lista.header')

    <div class="title">
        Lista de candidatos
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
            <th>Nº</th>
            <th>Nº de Inscrição</th>
            <th>NOME</th>
            <th>Idade</th>
            </tr>
        </thead>
        <tbody>
        <tbody>

            <?php $contador = 1; ?>
            <?php foreach ($candidatos as $candidato) : ?>

            <tr>
                <td><?php echo $contador++; ?></td>
                <td><?php echo $candidato->id; ?></td>
                <td class="text-left"><?php echo $candidato->vc_primeiroNome . ' ' . $candidato->vc_nomedoMeio . ' ' . $candidato->vc_apelido; ?></td>

                <td>{{calcularIdade($candidato->dt_dataNascimento)}} anos</td>
            </tr>

            
            <?php endforeach; ?>

            <br>
        </tbody>
        </tbody>
    </table>
    @php
   $funcionario=fh_funcionarios()->where('funcionarios.vc_funcao','Chefe da Comissão Geral')->first();
    @endphp
    @include('layouts._includes.fragments.lista.footer.index')
    @section('entidadade1', 'O COORDENADOR DA COMISSÃO')
    @if ($funcionario)
        @section('entidadade1-valor', fha_coordenador_comissao())
    @else
        @section('entidadade1-valor', fha_coordenador_comissao())
    @endif
    @section('entidadade2', 'O SUBDIRECTOR PEDAGÓGICO')
    @section('entidadade2-valor', $cabecalho->vc_nomeSubdirectorPedagogico)
    @include('layouts._includes.fragments.lista.footer.visto-2')



</body>

</html>
