<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
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

        .logotipo {
     position: absolute;
     margin-top: -60px;
     margin-right: -110px;
     float: left;
     z-index: 1;
 }
.text-center{
    text-align:center;
}
.tamanho-font{
    font-size:20px;
}

.style-table{
         width: 100%;
         /* border: 2px solid #ccc; */
     }
</style>

<div class="text-center tamanho-font">
        <p>
           <img src="<?php echo ?>images/ensignia/<?php echo $cabecalho->vc_ensignia; ?>.png" class="" width="50" height="50">
            <br>
            <?php echo $cabecalho->vc_republica; ?>
            <br>
            <?php echo $cabecalho->vc_ministerio; ?>
            <br>
                      <!--  <img src="<?php /*echo $cabecalho->vc_logo;*/ ?>" class="logotipo" width="100" height="100"> -->
            <?php echo $cabecalho->vc_escola; ?>
        </p>

    </div>
 
<h2 style="text-align: center;" >Mini pauta geral de aproveitamente </h2>
<br>
    <table class="style-table">
        <th>
            <tr>
            <td style="text-align: center;">Disciplina: <?php echo $disciplina->vc_acronimo?></td>
              
                <td style="text-align: center;">Classe: <?php echo $detalhes_turma->vc_classe?></td>
                <td style="text-align: center;">Curso:  <?php echo $detalhes_turma->vc_shortName?></td>
                <td style="text-align: center;">Turma:  <?php echo $detalhes_turma->vc_nomedaTurma?></td>
                <td style="text-align: center;">Ano Lectivo:  <?php echo $detalhes_turma->ya_inicio.'/'.$detalhes_turma->ya_fim?></td>
                <td style="text-align: center;">Turno:  <?php echo $detalhes_turma->vc_turnoTurma?></td>
                <td style="text-align: center;">Trimestre:  <?php echo $trimestre?></td>
              

            </tr>

            
        </th>
    </table>
    <br><br>
<table class="table">
    <thead class="">
    
        <tr >
        <th class="th">Nº ORDEM</th>
        <th class="th">PROCESSO</th>
            <th class="th">NOME</th>
         
            <th class="th">MÉDIA</th>
        </tr>


    </thead>
    <tbody class="">
    <?php $contador=1  ?>
    <?php foreach($notas as $nota){  ?>
        <tr class="">
        <td class="td"><?php echo $contador++  ?> </td>
            <td  class="td" > <?php echo $nota['id_aluno']  ?> </td>
            <td  class="td"> <?php echo $nota['nome_aluno']  ?> </td>
            <td  class="td " style=" color:<?php echo $nota['media_geral']>=10?'blue':'red'?>"> <?php echo $nota['media_geral']  ?> </td>
            

        </tr>
        <?php }?>
    </tbody>

</table>

<p style="text-align:center"> Uíge aos <?php echo date('d') ?> de  <?php echo date('m')?> de <?php echo date('Y')  ?> </p>

</body>
</html>