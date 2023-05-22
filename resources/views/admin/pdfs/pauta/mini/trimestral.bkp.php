<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .table {
            border-collapse: collapse;
            width: 100%;

        }

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
            <img src="<?php echo __full_path() ?>images/ensignia/<?php echo $cabecalho->vc_ensignia; ?>.png" class=""
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

    <h2 style="text-align: center;">Mini pauta de aproveitamente </h2>
    <div class="text-right">
        <h5 class="director">VISTO DO SUB-DIRECTOR PEDAGÓGICO</h5>
        <!-- linha por baixo do director de tamanho em questão, simplesmente! -->
        <?php for ($i = 0; $i < 40; $i++) {
          
        } ?>
    </div>
    <p style="text-align:right;">Professor: <strong> <?php echo $turmaProfessor->vc_primemiroNome . ' ' . $turmaProfessor->vc_apelido   ?></strong> </p>
    <br>
    <table class="style-table">
        <th>
            <tr>
                <td style="text-align: center;">Disciplina: <br> <?php echo $disciplina->vc_acronimo ?></td>

                <td style="text-align: center;">Classe: <?php echo $detalhes_turma->vc_classe ?></td>
                <td style="text-align: center;">Curso: <?php echo $detalhes_turma->vc_shortName ?></td>
                <td style="text-align: center;">Turma: <?php echo $detalhes_turma->vc_nomedaTurma ?></td>
                <td style="text-align: center;">Ano Lectivo: <?php echo $detalhes_turma->ya_inicio . '/' . $detalhes_turma->ya_fim ?></td>
                <td style="text-align: center;">Turno: <?php echo $detalhes_turma->vc_turnoTurma ?></td>
                <td style="text-align: center;">Trimestre: <?php echo $trimestre ?></td>


            </tr>


        </th>
    </table>

    <br><br>
    <table class="table">
        <thead class="">

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
        <tbody class="">
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
        </tbody>

    </table>
    <?php
    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    date_default_timezone_set('Africa/Luanda');
    ?>
    <p class="text-center" style="margin-top: 6%;"> <?php echo  strtoupper("Uíge"); ?> , AOS <?php echo strtoupper(strftime('%d de %B de %G', strtotime(date('d-m-Y', strtotime(date('Y-m-d')))))) ?></p>
    <div class="text-center">
        <p class="director">DIRECTOR GERAL</p>
        <!-- linha por baixo do director de tamanho em questão, simplesmente! -->
        <?php for ($i = 0; $i < 40; $i++) {
            // echo "_";
        } ?>


    </div>
</body>

</html>