<!DOCTYPE html>
<html>

<head>
    <title> Relatório de Propinas por aluno</title>
    <style>
        <?php
        echo $css;
        
        ?>
    </style>
</head>

<body>
    @php
        $ttl_classes = 0;
    @endphp
    @include('layouts._includes.fragments.lista.header')

    <div class="title">
        Relatório de Propinas por aluno
    </div>
    <div class="dates">
        <strong>Ano Lectivo:</strong>
        {{ $ano_lectivo }}
        &nbsp;
        <strong>Classe:</strong>
        {{ $classe }}ª 
        &nbsp;
        <strong>Mês:</strong>
        {{ $mes }}
        &nbsp;

    </div>
    @php
        $cont = 0;
    @endphp
    <table>

        <tr>
            <th>Mês</th>
            <th>Nº de Alunos</th>
            <th>Total(Akz)</th>

        </tr>

        @if ($mes == 'Todos')
            @foreach (fh_meses() as $mes)
                @php
                    
                    $cont = $pagamentos->where('mes', $mes)->count();
                    
                @endphp
                <tr>
                    <td style="text-align: center">
                        {{ $mes }}
                    </td>
                    <td style="text-align: center">

                        {{ $pagamentos->where('mes', $mes)->count() }}
                    </td>
                    <td style="text-align: center">

                        {{ $pagamentos->where('mes', $mes)->sum('valor_final') }}
                    </td>

                </tr>
            @endforeach
        @else
            <tr>
                <td style="text-align: center">
                    {{ $mes }}
                </td>
                <td style="text-align: center">

                    {{ $pagamentos->where('mes', $mes)->count() }}
                </td>
                <td style="text-align: center">

                    {{ $pagamentos->where('mes', $mes)->sum('valor_final') }}
                </td>

            </tr>
        @endif




        <tr>
                <td style="text-align: center">
                   Total
                </td>
                <td style="text-align: center">

                    {{ $pagamentos->count() }}
                </td>
                <td style="text-align: center">

                    {{ $pagamentos->sum('valor_final') }}
                </td>

            </tr>
    </table>


    @include('layouts._includes.fragments.lista.footer.index')



</body>

</html>
