<!DOCTYPE html>
<html>

<head>
    <title> Relatório de Alunos Matriculados</title>
    <style>
        <?php
        echo $css;
        
        ?>
    </style>
</head>

<body>
    @php
    $ttl_classes=0;
    @endphp
    @include('layouts._includes.fragments.lista.header')

    <div class="title">
        Relatório de Alunos Matriculados
    </div>
    <div class="dates">
        <strong>Ano Lectivo:</strong>
        {{ $ano_lectivo }}
        &nbsp;
        <strong>Curso:</strong>
        {{ $curso }}
        &nbsp;
        <strong>Ciclo:</strong>
        {{ $ciclo }}
        &nbsp;

    </div>

    <table>
        <caption>Alunos Matriculados por Ciclo</caption>
        <tr>
            <th>Ciclo</th>
            <th>Número de Alunos Matriculados</th>
        </tr>

        @if ($ciclo == 'Todos')
            <tr>
                <td style="text-align: center">

                    Ensino Primário
                </td>
                <td style="text-align: center">

                    {{ $matriculados->whereBetween('vc_classe', [1, 6])->count() }}
                </td>
            </tr>
            <tr>
                <td style="text-align: center">
                    Ensino Secundário (1º Ciclo)

                </td>
                <td style="text-align: center">

                    {{ $matriculados->whereBetween('vc_classe', [7, 9])->count() }}

                </td>
            </tr>
            <tr>
                <td style="text-align: center">
                    Ensino Secundário (2º Ciclo)

                </td>
                <td style="text-align: center">

                    {{ $matriculados->whereBetween('vc_classe', [10, 13])->count() }}

                </td>
            </tr>
        @else
            <tr>
                <td style="text-align: center">
                    {{ $ciclo }}
                </td>
                <td style="text-align: center">
                    @if ('Ensino Primário' == $ciclo)
                        {{ $matriculados->whereBetween('vc_classe', [1, 6])->count() }}
                    @elseif('Ensino Secundário (1º Ciclo)' == $ciclo)
                        {{ $matriculados->whereBetween('vc_classe', [7, 9])->count() }}
                    @elseif('Ensino Secundário (2º Ciclo)' == $ciclo)
                        {{ $matriculados->whereBetween('vc_classe', [10, 13])->count() }}
                    @endif
                </td>
            </tr>
        @endif




        <tr>
            <th>Total</th>
            <th>{{ $matriculados->count() }}</th>
        </tr>
    </table>

    <table>
  
        <caption>
            
            Alunos Matriculados por Curso</caption>
        <tr>
            <th>Curso</th>
            <th>Número de Alunos Matriculados</th>
        </tr>
        @foreach ($cursos as $curso)
            <tr>
                <td style="text-align: center">{{ $curso->vc_nomeCurso }}</td>
                <td style="text-align: center"> {{ $matriculados->where('id_curso', $curso->id)->count() }}</td>
            </tr>
        @endforeach


        <tr>
            <th>Total</th>
            <th>{{ $matriculados->count()}}</th>
        </tr>
    </table>

    <table>
        <caption>Alunos Matriculados por Classe</caption>
        <tr>
            <th>Classe</th>
            <th>Número de Alunos Matriculados</th>
        </tr>
        @foreach($classes as $classe)
        <tr>
         
            <td style="text-align: center">{{$classe->vc_classe}}ª Classe</td>
            <td style="text-align: center">
                @php
                $ttl_classes+=$matriculados->where('id_classe', $classe->id)->count();
                @endphp
                {{ $matriculados->where('id_classe', $classe->id)->count() }}</td>
        </tr>
        @endforeach
     

        <tr>
            <th>Total</th>
            <th>{{$ttl_classes}}</th>
        </tr>
    </table>

    <table>
        <caption>Alunos Matriculados por Gênero</caption>
        <tr>
            <th>Gênero</th>
            <th>Número de Alunos Matriculados</th>
        </tr>
        <tr>
            <td style="text-align: center">Masculino</td>
            <td style="text-align: center">{{ $matriculados->where('vc_genero', 'Masculino')->count() }}</td>
        </tr>

        <tr>
            <td style="text-align: center">Feminino</td>
            <td style="text-align: center">{{ $matriculados->where('vc_genero', 'Feminino')->count() }}</td>
        </tr>

        <tr>
            <th>Total</th>
            <th>{{ $matriculados->count() }}</th>
        </tr>
    </table>
  
    @include('layouts._includes.fragments.lista.footer.index')
    @section('entidadade1', 'O COORDENADOR DA COMISSÃO')
    @if (0)
        @section('entidadade1-valor', fha_coordenador_comissao())
    @else
        @section('entidadade1-valor', fha_coordenador_comissao())
    @endif
    @section('entidadade2', 'O SUBDIRECTOR PEDAGÓGICO')
    @section('entidadade2-valor', $cabecalho->vc_nomeSubdirectorPedagogico)
    @include('layouts._includes.fragments.lista.footer.visto-2')



</body>

</html>
