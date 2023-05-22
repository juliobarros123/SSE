<!DOCTYPE html>
<html lang="pt-pt">

<head>
    <meta charset="UTF-8">

    <title>Listas de Matriculados</title>
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
            <?php echo $cabecalho->vc_escola; ?>
            <table class="table1" style="width:40% ;">
        <tr class="tr1">
            <th class="th1" style="padding-right: 20px;"> VISTO <br>
            O DIRECTOR
          <br>
              <!--   _____________________________________ -->
              <br> <br> <br>
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
    <div class="text-center">
        <h3 class="tema">Lista dos Matriculados de <?php if ($curso!='Todos') :  echo ($curso);
                                                    else : echo "Todos os Cursos";
                                                    endif; ?></h3>
    </div>
    <div class="text-left">
        <h5 class="text-dark">
            Ano Lectivo: <?php if ($anolectivo) :  echo ($anolectivo);
                            else : echo "Todos os anos lectivos";
                            endif; ?> | Classe:
                            <?php if ($vc_classe!='Todos') :  echo ($vc_classe." ª Classe");
                            else : echo "Todas as classes";
                            endif; ?>

        </h5>
    </div>
    <table class="table table-striped  table-bodered table-hover">
        <thead>
            <tr>
                <th width="3px">Nº</th>
                <th width="90px">Nº de Inscrição</th>
                <th>NOME</th>
                <th>Idade</th>
            </tr>
        </thead>
        <tbody>

            <?php $contador = 1; ?>
            <?php foreach ($alunos as $aluno) : ?>

                <tr>
                    <td><?php echo $contador++; ?></td>
                    <td><?php echo $aluno->id ?></td>
                    <td class="text-left"><?php echo $aluno->vc_primeiroNome . " " . $aluno->vc_nomedoMeio . " " . $aluno->vc_ultimoaNome; ?></td>

                    <td><?php echo date('Y') - date('Y', strtotime($aluno->dt_dataNascimento)) ?> anos</td>
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
    <table class="table1">
        <tr class="tr1">
        <th class="th1" style="padding-left: 80px;padding-right: 100px;"><br><br> O COORDENADOR DA COMISSÃO <br>
                <!-- _____________________________________________________ -->
                <br><br><br>

            </th>
            <th class="th1"><br><br> O SUBDIRECTOR PEDAGÓGICO <br>
                <!-- ____________________________________________________ -->
                <br><br><br>

            </th>
        </tr>
        <tr class="tr1">
            <td class="td1"> <?php echo "" ?>
            </td>
            <td class="td1"> <?php echo $cabecalho->vc_nomeSubdirectorPedagogico; ?> <br>
            </td>
        </tr>

    <table class="table1" style="width:40% ;">
        <tr class="tr1">
            <th class="th1" style="padding-right: 20px;"> VISTO <br>
            O DIRECTOR
          <br>
                _____________________________________
            </th>

        </tr>
        <tr class="tr1">
            <td class="td1" style=" padding-right:10px; "> <?php echo $cabecalho->vc_nomeDirector; ?>
            </td>

        </tr>

    <table class="table1" style="width:40% ;">
        <tr class="tr1">
            <th class="th1" style="padding-right: 20px;"> VISTO <br>
            O DIRECTOR
          <br>
                _____________________________________
            </th>
        </tr>
        <tr class="tr1">
            <td class="td1" style=" padding-right:10px; "> <?php echo $cabecalho->vc_nomeDirector; ?>
            </td>

        </tr>

    </table>
       


        </tr>

    </table>

</body>

</html>
