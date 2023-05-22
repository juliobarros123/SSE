<!DOCTYPE html>
<html lang="pt-pt">

<head>
    <meta charset="UTF-8">

    <title>Listas de turma</title>
    <style>
        <?php echo $bootstrap;
        echo $css;
        
        ?>
        .table1,
        .tr1,
        .td1,
        .th1 {
            border: none;
        }
    </style>
</head>

<body>
    <div class="text-center">
        <p>
           <img src="<?php echo __full_path()?>images/ensignia/<?php echo $cabecalho->vc_ensignia; ?>.png" class="" width="50" height="50">
            <br>
            <?php echo $cabecalho->vc_republica; ?>
            <br>
            <?php echo $cabecalho->vc_ministerio; ?>
            <br>
                      <!--  <img src="<?php /*echo $cabecalho->vc_logo;*/ ?>" class="logotipo" width="100" height="100"> -->
            <?php echo $cabecalho->vc_escola; ?>
            <table class="table1" style="width:40% ;">
        <tr class="tr1">
            <th class="th1" style="padding-right: 20px;"> VISTO <br>
            O DIRECTOR
          <br>
                <!-- _____________________________________ -->
                <br><br><br>
            </th>
            
        </tr>
        <tr class="tr1">
            <td class="td1" style=" padding-right:10px; "> <?php echo $cabecalho->vc_nomeDirector; ?>
            </td>
            
        </tr>

    </table>
       
        </p>

    </div>
    <br>
    <div class="text-left">
        <h5 class="text-success">Curso: <?php echo $turma->vc_cursoTurma; ?> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $turma->vc_classeTurma; ?>ªClasse &nbsp;&nbsp;&nbsp;&nbsp; Turma: <?php echo $turma->vc_nomedaTurma."-".$turma->vc_turnoTurma; ?> &nbsp;&nbsp;&nbsp;&nbsp;Sala: <?php echo $turma->vc_salaTurma; ?><br><span style="text-align: left:!important;"> Ano Lectivo: <?php echo $turma->vc_anoLectivo; ?></span></h5>
    </div>
    <table class="table table-striped  table-bodered table-hover">
        <thead>
            <tr>
                <th width="1px">Nº</th>
                <th width="50px">PROCESSO</th>
                <th>NOME</th>
                <th width="50px">SEXO</th>
                <th>DATA NASC.</th>
                <th>IDADE</th>
                <th>TELEFONE</th>
            </tr>
        </thead>
        <tbody>

            <?php $contador = 1; ?>
            <?php foreach ($alunos as $aluno) : ?>

                <tr>
                    <td><?php echo $contador++; ?></td>
                    <td><?php echo $aluno->id ?></td>
                    <td class="text-left"><?php echo $aluno->vc_primeiroNome . " " . $aluno->vc_nomedoMeio . " " . $aluno->vc_ultimoaNome; ?></td>
                    <td><?php echo $aluno->vc_genero ?></td>
                    <td><?php echo date('d-m-Y', strtotime($aluno->dt_dataNascimento)) ?></td>
                    <td><?php echo date('Y') - date('Y', strtotime($aluno->dt_dataNascimento)) ?></td>
                    <td><?php echo $aluno->it_telefone ?></td>
                </tr>

            <?php endforeach; ?>

            <br>
        </tbody>
    </table>
    <?php
    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    date_default_timezone_set('Africa/Luanda');
    ?>
    <p class="text-center" style="margin-top: 6%;"> <?php echo  strtoupper("Uíge"); ?> , AOS <?php echo strtoupper(strftime('%d de %B de %G', strtotime(date('d-m-Y', strtotime(date('Y-m-d')))))) ?></p>
    <div class="text-center">
        <p class="director"><br> O SUBDIRECTOR PEDAGÓGICO <br>
        <!-- linha por baixo do director de tamanho em questão, simplesmente! -->
        <!-- <?php/*  for ($i = 0; $i < 40; $i++) {
            echo "_";
        } */ ?> -->
        <br>
      
        </p>
        <p><?php echo $cabecalho->vc_nomeSubdirectorPedagogico; ?></p>

    </div>
   
    





</body>

</html>