@foreach($matriculaEscolhida as $matricula)
turma {{$matricula->vc_nomedaTurma}}
classe {{$matricula->vc_classe}}
curso {{$matricula->vc_nomeCurso}}
ano lectivo {{$matricula->vc_anoLectivo}}

<br>
@endforeach