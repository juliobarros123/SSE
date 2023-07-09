<!DOCTYPE html>
<html lang="pt-pt">

<head>
    <meta charset="UTF-8">

    <title>Cartão de Estudante</title>
    <style>
        <?php echo $bootstrap;
        echo $css; ?>
    </style>
</head>

<body
    >
             <div class="header">
    <img src="images/insignia-certificado.png"  class="logo">
   
  
    <h3 class="info-cabecalho">{{$cabecalho->vc_republica}} <br>{{$cabecalho->vc_ministerio}} 
        <br>{{$cabecalho->vc_escola}} 
       
        
    </h3>
  

</div>
<div class="box-logo-escola">
    <img src="{{ $cabecalho->vc_logo }}" alt="" class="logo-escola">
    </div>
<div class="titulo">Cartão de Estudante</div>

    <div class="nome">Nome: <span class="valor">{{ $matricula->vc_primeiroNome }}
            {{ $matricula->vc_nomedoMeio }}
            {{ $matricula->vc_apelido }}</span>

    </div>
    <div class="classe">Classe:<span class="valor">{{ $matricula->vc_classe }}ª
        </span> </div>
    <div class="sala">Sala:<span class="valor">{{ $matricula->vc_salaTurma }}
        </span> </div>
        <div class="turma">Turma:<span class="valor">{{ $matricula->vc_nomedaTurma }}
        </span> </div>
    <div class="turno">Turno:<span class="valor">{{ $matricula->vc_turnoTurma }}
        </span> </div>

    <div class="box-imagem"><img src="<?php echo $matricula->vc_imagem; ?>" class="foto"> </div>
    <div class="ano_lectivo">Ano lectivo:<span class="valor">{{ $matricula->ya_inicio }}/{{ $matricula->ya_fim }}
        </span> </div>
    <div class="validade">Validade:<span class="valor">{{ $request['validade'] }}
        </span> </div>
        <div class="curso">Curso:<span class="valor">{{ $matricula->vc_nomeCurso }}
        </span> </div>
    <div class="box-imagem"><img src="<?php echo $matricula->vc_imagem; ?>" class="foto"> </div>


    <div class="visa-container " >
      
        <div>O(A) Director(a) </div>
        <div class="box-assinatura-director">
      <img src="{{$cabecalho->assinatura_director}}" class="assinatura-director" alt="">
            </div>
        <hr class="hr-custom">

        <div>
            <i>{{ $cabecalho->vc_nomeDirector }} </i>

        </div>
    </div>
</body>

</html>
