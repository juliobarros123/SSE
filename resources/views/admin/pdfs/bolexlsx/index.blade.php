{{-- <div>
    jsd
</div> --}}

<style>
    .table{
               border-collapse: collapse;
               width: 100%;

           }

           .th,
           .td {
               padding: 6px;
               text-align: left;
               border: 1px solid #ddd;

               color: black;
           }



   </style>

<table>
    <tr>
        <td>{{$turma->vc_cursoTurma}}</td>

        <td>{{$turma->vc_classeTurma}}ªclasse</td>
        <td>{{$turma->vc_nomedaTurma}}</td>
        <td>{{$trimestre}}</td>

    </tr>
    <tr>
        <td>Processo</td>
        <td>Nome</td>
        @foreach ($disciplinas as $disciplina )
        <td>{{$disciplina->vc_acronimo }}</td>
    @endforeach
    </tr>

    <tr>
        @foreach ($notas as $item )
        <tr>
        <td>{{$item['id_aluno']}} </td>
        <td>{{$item['nome']}} </td>

        @foreach ($disciplinas as $disciplina )
        <td>
               @php
                   $nota_collect=collect($item['notas'] );
                    $array= $nota_collect->where('vc_nome',$disciplina->vc_nome);
                        if( $array->isNotEmpty()){
                           echo  $array->first()->fl_nota1.'ABC'.$array->first()->fl_nota2.'ABC'.$array->first()->fl_mac.'ABC'.$array->first()->fl_media;

                        }
               @endphp

    </td>
    @endforeach
    <tr>
    @endforeach



    <tr>


</table>
