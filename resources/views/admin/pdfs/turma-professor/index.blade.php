
<!DOCTYPE html>
<html>

<head>
    <title>Lista de professores-turma</title>
    <style>
        <?php 
        echo $css;
        ?>
    </style>
</head>

<body>
   @include('layouts._includes.fragments.lista.header')

    <div class="title">
        Lista de professores
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
        <strong>Ano Lectivo:</strong>
        {{$turma->ya_inicio.'/'.$turma->ya_fim}}
        
    </div>
    <ul>
        @foreach ($professores as $item)
        <li> <strong> {{$item->vc_primemiroNome . ' ' . $item->vc_apelido }} / </strong>   
          
                {{ $item->disciplina }}
        
    </li>
      
        @endforeach
      
    </ul>
    @include('layouts._includes.fragments.lista.footer.index')
    @include('layouts._includes.fragments.lista.footer.visto')
   

   
</body>

</html>
