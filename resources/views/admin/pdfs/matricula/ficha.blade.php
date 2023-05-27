



    <!DOCTYPE html>
<html>

<head>
    <title>Lista de Alunos</title>
    <style>
        <?php 
        echo $css;
        ?>
    </style>
</head>

<body>
   @include('layouts._includes.fragments.lista.header')

    <div class="title">
    Ficha de Matrícula
    </div>
    <div class="dates">
        <strong>Turma:</strong>
        {{$matricula->vc_nomedaTurma}}
        &nbsp;
        <strong>Turno:</strong>
        {{$matricula->vc_turnoTurma}}
        &nbsp;
        <strong>Classe:</strong>
        {{$matricula->vc_classe}}ª
        &nbsp;
        <strong>Curso:</strong>
        {{$matricula->vc_shortName}}
        &nbsp;
        
        <strong>Ano Lectivo:</strong>
        {{$matricula->ya_inicio.'/'.$matricula->ya_fim}}
        <strong>Processo:</strong>
        {{$matricula->processo}}
        
    </div>
    <div style="margin-top: 20px;">
        <p><strong>Nome Completo:</strong> <?= $matricula->vc_primeiroNome.' '.$matricula->vc_nomedoMeio.' '.$matricula->vc_apelido  ?></p>
        <p><strong>Data de Nascimento:</strong> <?= $matricula->dt_dataNascimento  ?></p>
        <p><strong>Genero:</strong> <?= $matricula->vc_genero  ?></p>
        <p><strong>Natural de </strong> <?= $matricula->vc_naturalidade  ?> Provincia de </strong> <?= $matricula->vc_provincia  ?> Nacionalidade Angolana </p>
        <p><strong>Filiação de :</strong> <?= $matricula->vc_nomePai  ?> e de <?= $matricula->vc_nomeMae  ?></p>
        <p><strong>Localidade:</strong> <?= $matricula->vc_residencia  ?></p>
        <p><strong>Telefone:</strong> <?php if($matricula->it_telefone !=null )  echo $matricula->it_telefone  ?></p>
        <p><strong>BI:</strong> <?php if($matricula->it_telefone !=null )  echo $matricula->vc_bi  ?></p>
        <p><strong>Estabelecimento de ensino que frequentou no ano anterior :</strong> <?php if($matricula->vc_EscolaAnterior !=null )  echo $matricula->it_telefone  ?></p>

    </div>
    @include('layouts._includes.fragments.lista.footer.index')
    @include('layouts._includes.fragments.lista.footer.visto')
   

   
</body>

</html>
