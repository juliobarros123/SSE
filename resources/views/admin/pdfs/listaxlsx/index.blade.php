
<div>
    jsd
</div>


<table>
    <tr>
        <td>{{$turma->vc_classeTurma}}</td>
        <td>{{$turma->vc_nomedaTurma}}</td>
    </tr>

    @foreach ($alunos as $aluno)

    <tr>


        <td>
            {{$aluno->vc_primeiroNome.' '.$aluno->vc_nomedoMeio.' '.$aluno->vc_ultimoaNome}}
        </td>
        <td>
            {{$aluno->id}}
        </td>

    </tr>
    @endforeach


</table>

