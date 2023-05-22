<!DOCTYPE html>
<html lang="pt-pt">

<head>
    <meta charset="UTF-8">

    <title>Listas de funcionários</title>
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
               <!--  _____________________________________ -->
               <br>
               <br> <br>
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
        <h3 class="tema">Lista de Funcionários</h3>
    </div>

    <table class="table table-striped  table-bodered table-hover">
        <thead>
            <tr>
                <th width="3px">Nº</th>
                <th>NOME</th>
                <th>BILHETE DE IDENTIDADE</th>
                <th>FUNÇÃO</th>
                <th>IDADE</th>
            </tr>
        </thead>
        <tbody>

            <?php $contador = 1; ?>
            <?php foreach ($funcionarios as $row) : ?>

                <tr>
                    <td><?php echo $contador++; ?></td>

                    <td class="text-left"><?php echo $row->vc_primeiroNome . " " . $row->vc_ultimoNome ?></td>
                    <td><?php echo $row->vc_bi ?></td>
                    <td><?php echo $row->vc_funcao ?></td>
                    <td><?php echo calcularIdade($row->dt_nascimento)  ?> anos</td>
                </tr>

            <?php endforeach; ?>

            <br>
        </tbody>
    </table>


</body>

</html>