<!DOCTYPE html>
<html lang="pt-pt">

<head>
    <meta charset="UTF-8">

    <title>Mini Pauta de Aproveitamento</title>
    <style>
        <?php echo $bootstrap;
        echo $css;
        ?>
      /*   .table {
            border-collapse: collapse;
            width: 100%;

        } */

        .th,
        .td {
            padding: 6 px;
            text-align: left;
            border: 1px solid #ddd;

            color: black;
        }

        .logotipo {
            position: absolute;
            margin-top: -60px;
            margin-right: -110px;
            float: left;
            z-index: 1;
        }

        .text-center {
            text-align: center;
        }

        .tamanho-font {
            font-size: 20px;
        }

        .style-table {
            width: 100%;
            /* border: 2px solid #ccc; */
        }

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
            <img src="<?php echo  ?>images/ensignia/<?php echo $cabecalho->vc_ensignia; ?>.png" class=""
                width="50" height="50">
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
                    <!--  _____________________________________ -->
                    <br>
                    <br> <br>
                </th>

            </tr>
            <tr class="tr1">
                <td class="td1" style=" padding-right:10px; ">
                    <?php echo $cabecalho->vc_nomeDirector; ?>
                </td>

            </tr>

        </table>

        </p>

    </div>
    <br>
    <div class="text-center">
        <h3 class="tema">Mini pauta de aproveitamente</h3>
    </div>
   
    <table class="table1" style="border: none !important;">
        <th>
            <tr class="tr1">
                <td class="td1" style="text-align: center;">Disciplina: <?php echo $disciplina->vc_acronimo ?></td>

                <td class="td1" style="text-align: center;">Classe: <?php echo $detalhes_turma->vc_classe ?></td>
                <td class="td1" style="text-align: center;">Curso: <?php echo $detalhes_turma->vc_shortName ?></td>
                <td class="td1" style="text-align: center;">Turma: <?php echo $detalhes_turma->vc_nomedaTurma ?></td>
                <td class="td1" style="text-align: center;">Ano Lectivo: <?php echo $detalhes_turma->ya_inicio . '/' . $detalhes_turma->ya_fim ?></td>
                <td class="td1" style="text-align: center;">Turno: <?php echo $detalhes_turma->vc_turnoTurma ?></td>
                <td class="td1" style="text-align: center;">Trimestre: <?php echo $trimestre ?></td>


            </tr>


        </th>
    </table>
    <table class="table table-striped  table-bodered table-hover">
        <thead>
            <tr>
                 <th class="th">Nº ORDEM</th>
                <th class="th">PROCESSO</th>
                <th class="th">NOME COMPLETO</th>
                <th class="th">MAC</th>
                <th class="th">NPP</th>
                <th class="th">NPT</th>
                <th class="th">MT</th>
            </tr>
           
        </thead>
        <tbody>

        <?php $contador = 1  ?>
            <?php foreach ($notas as $nota) { ?>
                <tr class="">
                    <td class="td"><?php echo $contador++  ?> </td>
                    <td class="td"> <?php echo $nota->it_idAluno  ?> </td>
                    <td class="td"> <?php echo $nota->vc_primeiroNome . ' ' . $nota->vc_nomedoMeio . ' ' . $nota->vc_ultimoaNome  ?> </td>
                    <td class="td" style="color:<?php echo $nota->fl_mac >= 10 ? 'blue' : 'red' ?>"><?php echo $nota->fl_mac ?> </td>
                    <td class="td " style=" color:<?php echo $nota->fl_nota1 >= 10 ? 'blue' : 'red' ?>"> <?php echo $nota->fl_nota1 ?> </td>
                    <td class="td" style="color:<?php echo $nota->fl_nota2 >= 10 ? 'blue' : 'red' ?>"><?php echo $nota->fl_nota2 ?> </td>
                    <td class="td" style="color:<?php echo $nota->fl_media >= 10 ? 'blue' : 'red' ?>"><?php echo $nota->fl_media ?></td>

                </tr>
            <?php } ?>

            <br>
        </tbody>
    </table>

    <?php
    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    date_default_timezone_set('Africa/Luanda');
    ?>
    <p class="text-center" style="margin-top: 6%;">
        <?php echo strtoupper("Uíge"); ?> , AOS
        <?php echo strtoupper(strftime('%d de %B de %G', strtotime(date('d-m-Y', strtotime(date('Y-m-d')))))) ?>
    </p>
    <table class="table1">
        <tr class="tr1">
            <th class="th1" style="padding-left: 100px;padding-right: 180px;">
                <br> O PROFESSOR <br>
                <!-- _____________________________________________________ -->
                <br>
                <br> <br>

            </th>
            <th class="th1"><br>
                O SUBDIRECTOR PEDAGÓGICO <br>
                <!-- ____________________________________________________ -->
                <br>
                <br> <br>

            </th>
        </tr>
        <tr class="tr1">
            <td class="td1">
                <?php echo "" ?>
            </td>
            <td class="td1">
                <?php echo $cabecalho->vc_nomeSubdirectorPedagogico; ?> <br>
            </td>
        </tr>

    </table>

</body>

</html>