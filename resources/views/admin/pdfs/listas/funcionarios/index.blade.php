




<!DOCTYPE html>
<html>

<head>
    <title>Lista de Funcionários</title>
    <style>
        <?php
        echo $css;
        ?>
    </style>
</head>

<body>
    @include('layouts._includes.fragments.lista.header')

    <div class="title">
       Lista de Funcionários
    </div>
 
    <table class="table">
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
        </tbody>
    </table>




</body>

</html>
