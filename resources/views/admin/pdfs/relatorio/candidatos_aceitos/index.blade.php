<!DOCTYPE html>
<html>

<head>
    <title> Relatório de Candidatos Aceitos</title>
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
        Relatório de Candidatos Aceitos
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
        <caption>Candidatos por Ciclo</caption>
        <tr>
            <th>Ciclo</th>
            <th>Número de Candidatos</th>
        </tr>

        @if ($ciclo == 'Todos')
            <tr>
                <td style="text-align: center">

                    Ensino Primário
                </td>
                <td style="text-align: center">

                    {{ $alunos->whereBetween('vc_classe', [1, 6])->count() }}
                </td>
            </tr>
            <tr>
                <td style="text-align: center">
                    Ensino Secundário (1º Ciclo)

                </td>
                <td style="text-align: center">

                    {{ $alunos->whereBetween('vc_classe', [7, 9])->count() }}

                </td>
            </tr>
            <tr>
                <td style="text-align: center">
                    Ensino Secundário (2º Ciclo)

                </td>
                <td style="text-align: center">

                    {{ $alunos->whereBetween('vc_classe', [10, 13])->count() }}

                </td>
            </tr>
        @else
            <tr>
                <td style="text-align: center">
                    {{ $ciclo }}
                </td>
                <td style="text-align: center">
                    @if ('Ensino Primário' == $ciclo)
                        {{ $alunos->whereBetween('vc_classe', [1, 6])->count() }}
                    @elseif('Ensino Secundário (1º Ciclo)' == $ciclo)
                        {{ $alunos->whereBetween('vc_classe', [7, 9])->count() }}
                    @elseif('Ensino Secundário (2º Ciclo)' == $ciclo)
                        {{ $alunos->whereBetween('vc_classe', [10, 13])->count() }}
                    @endif
                </td>
            </tr>
        @endif




        <tr>
            <th>Total</th>
            <th>{{ $alunos->count() }}</th>
        </tr>
    </table>

    <table>
  
        <caption>
            
            Candidatos por Curso</caption>
        <tr>
            <th>Curso</th>
            <th>Número de Candidatos</th>
        </tr>
        @foreach ($cursos as $curso)
            <tr>
                <td style="text-align: center">{{ $curso->vc_nomeCurso }}</td>
                <td style="text-align: center"> {{ $alunos->where('id_curso', $curso->id)->count() }}</td>
            </tr>
        @endforeach


        <tr>
            <th>Total</th>
            <th>{{ $alunos->count()}}</th>
        </tr>
    </table>

    <table>
        <caption>Candidatos por Classe</caption>
        <tr>
            <th>Classe</th>
            <th>Número de Candidatos</th>
        </tr>
        @foreach($classes as $classe)
        <tr>
         
            <td style="text-align: center">{{$classe->vc_classe}}ª Classe</td>
            <td style="text-align: center">
                @php
                $ttl_classes+=$alunos->where('id_classe', $classe->id)->count();
                @endphp
                {{ $alunos->where('id_classe', $classe->id)->count() }}</td>
        </tr>
        @endforeach
     

        <tr>
            <th>Total</th>
            <th>{{$ttl_classes}}</th>
        </tr>
    </table>

    <table>
        <caption>Candidatos por Gênero</caption>
        <tr>
            <th>Gênero</th>
            <th>Número de Candidatos</th>
        </tr>
        <tr>
            <td style="text-align: center">Masculino</td>
            <td style="text-align: center">{{ $alunos->where('vc_genero', 'Masculino')->count() }}</td>
        </tr>

        <tr>
            <td style="text-align: center">Feminino</td>
            <td style="text-align: center">{{ $alunos->where('vc_genero', 'Feminino')->count() }}</td>
        </tr>

        <tr>
            <th>Total</th>
            <th>{{ $alunos->count() }}</th>
        </tr>
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