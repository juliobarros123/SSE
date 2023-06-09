<?php
/* Ideializado por Paulo Alexandre Fernandes dos Santos
    email: tecnicopaulo@outlook.pt
    LinkedIn: Chandinho
*/
/* Incluindo a conexão com a BD */

use Illuminate\Support\Facades\DB;
?>
<!DOCTYPE html>
<html lang="pt-pt">

<head>
    <meta charset="UTF-8">

    <title>Pauta da Turma <?php echo $detalhes_turma->vc_nomedaTurma; ?></title>
    <style>
        <?php 
        echo $bootstrap;
        echo $css;
        ?>
    </style>
</head>

<body>
    <div class="text-center">
        <p>
            <img src="images/ensignia/<?php echo $cabecalho->vc_ensignia; ?>.png" class="" width="50" height="50">
            <br>
            <?php echo $cabecalho->vc_republica; ?>
            <br>
            <?php echo $cabecalho->vc_ministerio; ?>
            <br>
            <img src="images/logotipo/<?php echo $cabecalho->vc_logo; ?>.png" class="logotipo" width="100" height="100">
            <?php echo $cabecalho->vc_escola; ?>
        </p>

    </div>
    <div class="text-center">
        <h5 class="text-dark">Curso: <?php echo $detalhes_turma->vc_cursoTurma; ?> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $detalhes_turma->vc_classeTurma; ?>ªClasse &nbsp;&nbsp;&nbsp;&nbsp;
            <?php
            // if ($tipos == "PA") {
            //     echo "Pauta Final";
            // }
            /*  else {
                echo "Pauta do Exame Especial";
            } */

            ?> &nbsp;&nbsp;&nbsp;&nbsp; Ano Lectivo: <?php echo $detalhes_turma->vc_anoLectivo; ?></h5>
    </div>
    <h3 class="tema Maiusculas">Mapa de avaliação Anual da Turma <?php echo $detalhes_turma->vc_nomedaTurma; ?> - <?php echo $detalhes_turma->vc_classeTurma; ?>ª classe</h3>

    <div class="text-right">
        <h5 class="director">VISTO DO SUB-DIRECTOR PEDAGÓGICO</h5>
        <!-- linha por baixo do director de tamanho em questão, simplesmente! -->
        <?php for ($i = 0; $i < 40; $i++) {
            echo "_";
        } ?>
    </div>
    <br><br>
    <table class="table table-striped  table-bodered table-hover">
        <thead>
            <tr>
                <th style="width:10px;">Nº</th>
                <th style="width:10px;">PROCESSO</th>
                <th style="width:300px;">NOME</th>
                <th style="width:9px;">S<br>E<br>X<br>O<br></th>
                <!-- chamando os nomes das disciplinas da turma em questão para o cabeçalho -->
                <?php foreach ($cabecalhoNotas as $item) : ?>

                    <th class="Maiusculas" rowspan="4">
                        <p><?= $item->vc_acronimo; ?></p>
                        <!-- <p class="text-success">CA</p>
                    <p class="text-primary">CFD</p>
                    <p class="bg-green">EX</p>
                    <p class="text-danger">EE</p> -->

                    </th>

                <?php endforeach; ?>


            </tr>


        </thead>
        <tbody>
            <!-- contador para numerar os alunos, simplesmente -->
            <?php $contador = 1; ?>
            <!-- Alunos da turma em questão -->
            <?php foreach ($alunos as $aluno) : ?>
                <tr>
                    <td><?= $contador++ ?></td>
                    <td><?= $aluno->id ?></td>
                    <td class=" text-left"><?= $aluno->vc_primeiroNome . " " . $aluno->vc_nomedoMeio . " " . $aluno->vc_ultimoaNome  ?></td>
                    <td>
                        <?php
                        if ($aluno->vc_genero == 'Masculino') :
                            echo 'M';
                        else :
                            echo 'F';
                        endif; ?>
                    </td>

                    <!-- voltando a chamar o nome das disciplinas para pegar o id de cada disciplina do cabecalho -->
                    <?php foreach ($cabecalhoNotas as $item) : ?>
                        <td>
                            <?php
                            /* pegando as notas de cada aluno da turma em questão e do trimestre em questão */

                            $corpoNotas = DB::table('notas')
                                ->where([['notas.it_idAluno', $aluno->id]])
                                ->where([['notas.vc_anolectivo', $detalhes_turma->vc_anoLectivo]])
                                ->where([['notas.vc_nomedaTurma', $detalhes_turma->vc_nomedaTurma]])
                                ->where([['notas.it_classe', $detalhes_turma->vc_classeTurma]])
                                // ->where([['notas.vc_nomeT', $tipos]])
                                ->join('disciplinas', 'notas.vc_disciplina', '=', 'disciplinas.id')
                                ->orderby('disciplinas.vc_nome', 'asc')
                                ->select(
                                    'notas.fl_media',
                                    'notas.vc_disciplina'

                                )->get();

                            foreach ($corpoNotas as $key) :
                                /* comparando o id da disciplina do cabecalho com o id da chave estrangueira da disciplina na nota,
                                para atribuir na celúla  
                                */
                                if ($item->id == $key->vc_disciplina) :
                                    /* se a nota for maior que 10 então a cor da nota é a em questão, caso não for tem a sua cor também! */
                                    if ($key->fl_media >= 10) :
                                        echo "<b class='color-blue'>" . round($key->fl_media) . "</b>";
                                    else :
                                        echo "<b class='color-red'>" . round($key->fl_media) . "</b>";
                                    endif;
                                endif;
                            endforeach;
                            ?>
                        </td>
                    <?php endforeach; ?>


                    <!--  -->
                    <!-- voltando a chamar o nome das disciplinas para pegar o id de cada disciplina do cabecalho -->
                    <?php foreach ($cabecalhoNotas as $item) : ?>
                        <td>
                            <?php
                            /* pegando as notas de cada aluno da turma em questão e do trimestre em questão */

                            $corpoNotas = DB::table('notas')
                                ->where([['notas.it_idAluno', $aluno->id]])
                                ->where([['notas.vc_anolectivo', $detalhes_turma->vc_anoLectivo]])
                                ->where([['notas.vc_nomedaTurma', $detalhes_turma->vc_nomedaTurma]])
                                ->where([['notas.it_classe', $detalhes_turma->vc_classeTurma]])
                                ->where([['notas.vc_nomeT', $tipos]])
                                ->join('disciplinas', 'notas.vc_disciplina', '=', 'disciplinas.id')
                                ->orderby('disciplinas.vc_nome', 'asc')
                                ->select(
                                    'notas.fl_media',
                                    'notas.vc_disciplina'

                                )->get();

                            foreach ($corpoNotas as $key) :
                                /* comparando o id da disciplina do cabecalho com o id da chave estrangueira da disciplina na nota,
                                para atribuir na celúla  
                                */
                                if ($item->id == $key->vc_disciplina) :
                                    /* se a nota for maior que 10 então a cor da nota é a em questão, caso não for tem a sua cor também! */
                                    if ($key->fl_media >= 10) :
                                        echo "<b class='color-blue'>" . round($key->fl_media) . "</b>";
                                    else :
                                        echo "<b class='color-red'>" . round($key->fl_media) . "</b>";
                                    endif;
                                endif;
                            endforeach;
                            ?>
                        </td>
                    <?php endforeach; ?>
                    <!--  -->
                    
                </tr>

            <?php endforeach ?>
            <br>
        </tbody>
    </table>

    <div class="text-center">
        <p class="director">DIRECTOR GERAL</p>
        <!-- linha por baixo do director de tamanho em questão, simplesmente! -->
        <?php for ($i = 0; $i < 40; $i++) {
            echo "_";
        } ?>


    </div>


</body>

</html>