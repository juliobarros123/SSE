<!DOCTYPE html>
<html lang="pt-pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Candidatura</title>
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
            li{
                font-size: 12px;
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
        </p>

    </div>
    <br><h2 style="text-align: center;" >Lista de professores </h2>
   <br>

    <table class="style-table">
        <th>
            <tr>
            
              
                <td style="text-align: center;">Classe: <?php echo $detalhes_turma->vc_classe?></td>
                <td style="text-align: center;">Curso:  <?php echo $detalhes_turma->vc_shortName?></td>
                <td style="text-align: center;">Turma:  <?php echo $detalhes_turma->vc_nomedaTurma?></td>
                <td style="text-align: center;">Ano Lectivo:  <?php echo $detalhes_turma->ya_inicio.'/'.$detalhes_turma->ya_fim?></td>
                <td style="text-align: center;">Turno:  <?php echo $detalhes_turma->vc_turnoTurma?></td>
              
              

            </tr>

            
        </th>
    </table>
    <ul>
        @foreach ($professores as $item)
        <li> <strong> {{$item->vc_primemiroNome . ' ' . $item->vc_apelido }} / </strong>   
             @foreach ($disciplinas as $discplina)
            @if ($discplina->it_idUser == $item->it_idUser)
                {{ $discplina->disciplina }}
               
            @endif
        @endforeach</li>
      
        @endforeach
      
    </ul>
    <br>

</body>

</html>
