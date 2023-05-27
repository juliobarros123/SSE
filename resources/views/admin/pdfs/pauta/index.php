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

    <title>Pauta da Turma <?php echo $turma->vc_nomedaTurma . "-" . $turma->vc_turnoTurma; ?></title>
    <style>
        <?php echo $bootstrap;
        echo $css;
        ?>.table1,
        .tr1,
        .td1,
        .th1 {
            border: none;
        }
    </style>
    <style>
        .table {
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
            margin-top: -100px;
            margin-right: -110px;
            float: left;
            z-index: 1;
        }

        /* .tb{
                position: absolute;
                margin-top: 10px;
                margin-right: -110px;
                float: left;
                z-index: 1;
            } */
        .visto {
            width: 500px;
            height: 100px;
            /* background-color: red; */
            /* position: absolute;
            left: 50px;
            margin-left: 300px; */
            left: 50px;
            margin-left: 300px;
            margin-top: -30px;
            font-size: 100px;
        }

        .logo {
            width: 500px;
            height: 100px;
            /* background-color: red; */
            /* position: absolute;
            left: 50px;
            margin-left: 300px; */
            left: 50px;
            margin-left: 30px;
            margin-top: -170px;
            font-size: 100px;
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
    <style>
        .table {
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
            margin-top: -100px;
            margin-right: -110px;
            float: left;
            z-index: 1;
        }

        /* .tb{
                position: absolute;
                margin-top: 10px;
                margin-right: -110px;
                float: left;
                z-index: 1;
            } */
        .visto {
            width: 500px;
            height: 100px;
            /* background-color: red; */
            /* position: absolute;
            left: 50px;
            margin-left: 300px; */
            left: 50px;
            margin-left: 300px;
            margin-top: -30px;
            font-size: 100px;
        }

        .logo {
            width: 500px;
            height: 100px;
            /* background-color: red; */
            /* position: absolute;
            left: 50px;
            margin-left: 300px; */
            left: 50px;
            margin-left: 30px;
            margin-top: -170px;
            font-size: 100px;
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
            <img src="<?php echo  ?>images/ensignia/<?php echo $cabecalho->vc_ensignia; ?>.png" class="" width="50" height="50">
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
                    <br><br>
                </th>

            </tr>
            <tr class="tr1">
                <td class="td1" style=" padding-right:10px; "> <?php echo $cabecalho->vc_nomeDirector; ?>
                </td>

            </tr>

        </table>
        </p>

    </div>
    <div class="text-center">
        <h5 class="text-dark">Curso: <?php echo $turma->vc_cursoTurma; ?> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $turma->vc_classeTurma; ?>ªClasse &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $trimestres; ?>º trimestre &nbsp;&nbsp;&nbsp;&nbsp; Ano Lectivo: <?php echo $turma->vc_anoLectivo; ?></h5>
    </div>
    <h3 class="tema Maiusculas">Pauta da Turma <?php echo $turma->vc_nomedaTurma . " - " . $turma->vc_turnoTurma . " - " . $turma->vc_classeTurma; ?>ª classe</h3>
    <br>

    <?php
    $disciplinasNotas = array();
    ?>
    <?php $alunosResultado = collect() ?>
    <?php $disciplinasNegativasIndividual = array() ?>

    <table class="table table-striped  table-bodered table-hover">
        <thead>
            <tr>
                <th style="width:10px;">Nº</th>
                <th style="width:10px;">PROCESSO</th>
                <th style="width:300px;">NOME</th>
                <th style="width:9px;">S<br>E<br>X<br>O<br></th>
                <th style="width:9px;">I<br>D<br>A<br>D<br>E</th>
                <!-- chamando os nomes das disciplinas da turma em questão para o cabeçalho -->
                <?php foreach ($cabecalhoNotas as $item) : ?>

                    <th class="Maiusculas" text-rotate="90">
                        <p><?= $item->vc_acronimo; ?></p>
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
                        $c = collect();
                        if ($aluno->vc_genero == 'Masculino' || $aluno->vc_genero == 'MASCULINO') :
                            echo 'M';
                        else :
                            echo 'F';
                        endif; ?>
                    </td>
                    <td>
                        <?php
                        echo calcularIdade($aluno->dt_dataNascimento)
                        ?>
                    </td>
                    <!-- voltando a chamar o nome das disciplinas para pegar o id de cada disciplina do cabecalho -->
                    <?php foreach ($cabecalhoNotas as $item) : ?>
                        <td>
                            <?php
                            // dd( $item);
                            //  dd( $turma);
                            /* pegando as notas de cada aluno da turma em questão e do trimestre em questão */
                            //   dd($turma);
                            $corpoNotas = DB::table('notas')
                                ->where([['notas.it_idAluno', $aluno->id]])
                                ->where([['notas.id_ano_lectivo', $turma->it_idAnoLectivo]])
                                ->where([['notas.id_turma', $turma->id]])
                                ->where([['notas.id_classe', $turma->it_idClasse]])
                                ->where([['notas.vc_tipodaNota', $trimestres]])


                                /*  ->join('disciplinas', 'disciplinas_cursos_classes.it_disciplina', '=', 'disciplinas.id') */

                                ->join('disciplinas_cursos_classes', 'notas.it_disciplina', '=', 'disciplinas_cursos_classes.id')
                                ->join('disciplinas', 'disciplinas_cursos_classes.it_disciplina', '=', 'disciplinas.id')
                                ->orderby('disciplinas.vc_nome', 'asc')
                                ->select(
                                    'notas.fl_media',
                                    'notas.it_disciplina'

                                )->get();
                            // dd(  $corpoNotas );
                            foreach ($corpoNotas as $key) :
                                /* comparando o id da disciplina do cabecalho com o id da chave estrangueira da disciplina na nota,
                                para atribuir na celúla  
                                */
                                if (!$c->where("it_disciplina", $key->it_disciplina)->where("processo", $aluno->id)->count()) {
                                    if ($item->id == $key->it_disciplina) :
                                        $c->push(['it_disciplina' => $key->it_disciplina, 'id_aluno' => $aluno->id]);
                                        /* se a nota for maior que 10 então a cor da nota é a em questão, caso não for tem a sua cor também! */
                                        if ($key->fl_media >= 10) :

                                            echo "<b class='color-blue'>" .$key->fl_media. "</b>";
                                        else :
                                            echo "<b class='color-red'>" .$key->fl_media. "</b>";
                                        endif;
                                        if ($key->fl_media < 10) {
                                            array_push($disciplinasNegativasIndividual, ['disciplina' => $item->vc_acronimo, 'nota' => $key->fl_media, 'id_aluno' => $aluno->id]);
                                        }
                                        array_push($disciplinasNotas, ['disciplina' => $item->vc_acronimo, 'nota' => $key->fl_media, 'id_aluno' => $aluno->id]);
                                    endif;
                                }
                            endforeach;
                            ?>
                        </td>

                    <?php endforeach;
                    ?>
                </tr>

            <?php
                $disciplinasNegativasIndividualC = collect($disciplinasNegativasIndividual);
                if ($disciplinasNegativasIndividualC->where('id_aluno', $aluno->id)->count() >= 3) {


                    $alunosResultado->push(['id_aluno' => $aluno->id, 'genero' => $aluno->vc_genero, "resultado" => 'N/TRANSITA']);
                } else {


                    $alunosResultado->push(['id_aluno' => $aluno->id, 'genero' => $aluno->vc_genero, "resultado" => 'TRANSITA']);
                }
                $disciplinasNegativasIndividual = array();
            endforeach;

            // dd(  $alunosResultado);

            ?>
            <br>
        </tbody>
    </table>
    <div>
        <br><br>
        <table class="table">
            <tr>
                <th colspan="3" class="th " style="text-align: center;  border: 1px solid black;height:50px;">Estatistica</th>
            </tr>


        </table>
        <br><br>
        <table class="table">



            <tr>
                <th colspan="3" class="th " style="text-align: center;">Percentagem</th>
                <th class="th " style="text-align: center;">MASCULINO</th>
                <th class="th " style="text-align: center;">FEMININO</th>
                <th class="th " style="text-align: center;">DISCIPLINAS</th>

                <?php
                $disciplinasNotas = collect($disciplinasNotas);
                $disciplinas = $cabecalhoNotas;
                // $alunosResultado = collect();
                foreach ($disciplinas as $disciplina) { ?>
                    <th rowspan="1" class="th" style="text-align: center;background-color: green; "><?php echo $disciplina->vc_acronimo ?></th>

                <?php } ?>
            </tr>


            <tr>
                <th colspan="2" class="th">Total de positivas</th>
                <td class="td"><?php echo round(((($alunosResultado->where("resultado", "TRANSITA")->count()) / $alunos->count()) * 100), 0, PHP_ROUND_HALF_UP) . '%' ?></td>
                <td class="td"><?php echo $alunosResultado->where("resultado", "TRANSITA")->where("genero", "Masculino")->count() + $alunosResultado->where("resultado", "TRANSITA")->Where("genero", "MASCULINO")->count() ?></td>
                <td class="td"><?php echo $alunosResultado->where("resultado", "TRANSITA")->where("genero", "Feminino")->count() + $alunosResultado->where("resultado", "TRANSITA")->where("genero", "FEMININO")->count() ?></td>
                <td class="td">Positivas</td>
                <?php foreach ($disciplinas as $disciplina) { ?>
                    <td rowspan="1" class="td" style="text-align: center; "> <?php echo $disciplinasNotas->where("disciplina", $disciplina->vc_acronimo)->where("nota", ">=", 10)->count(); ?></td>
                <?php } ?>
            </tr>
            <tr>
                <th colspan="2" class="th">Total de negativas</th>
                <td class="td"><?php echo round(((($alunosResultado->where("resultado", "N/TRANSITA")->count()) / $alunos->count()) * 100), 0, PHP_ROUND_HALF_UP) . '%' ?></td>
                <td class="td"><?php echo $alunosResultado->where("resultado", "N/TRANSITA")->where("genero", "Masculino")->count() + $alunosResultado->where("resultado", "N/TRANSITA")->where("genero", "MASCULINO")->count()  ?></td>
                <td class="td"><?php echo $alunosResultado->where("resultado", "N/TRANSITA")->where("genero", "Feminino")->count() + $alunosResultado->where("resultado", "N/TRANSITA")->where("genero", "FEMININO")->count() ?></td>
                <td class="td">Negativas</td>

                <?php foreach ($disciplinas as $disciplina) { ?>
                    <td rowspan="1" class="td" style="text-align: center; "> <?php
                                                                                echo $disciplinasNotas->where("disciplina", $disciplina->vc_acronimo)->where("nota", "<", 10)->count(); ?></td>
                <?php } ?>
            </tr>
            <!-- <tr>
                <th colspan="2" class="th">Recurso</th>
                <td class="td"><?php echo round(((($alunosResultado->where("resultado", "RECURSO")->count()) / $alunos->count()) * 100), 0, PHP_ROUND_HALF_UP) . '%' ?></td>
                <td class="td"><?php echo $alunosResultado->where("resultado", "RECURSO")->where("genero", "Masculino")->count() ?></td>
                <td class="td"><?php echo $alunosResultado->where("resultado", "RECURSO")->where("genero", "Feminino")->count() ?></td>

            </tr> -->
            <!-- <tr>
                <th colspan="2" class="th">Desistentes</th>
                <td class="td"></td>
            </tr> -->

        </table>




        <br><br>
     

    </div>
    <?php
    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    date_default_timezone_set('Africa/Luanda');
    ?>
    <p class="text-center" style="margin-top: 6%;"> <?php echo  strtoupper("Uíge"); ?> , AOS <?php echo strtoupper(strftime('%d de %B de %G', strtotime(date('d-m-Y', strtotime(date('Y-m-d')))))) ?></p>
    <table class="table1">
        <tr class="tr1">
        <th class="th1" style="padding-left: 80px;padding-right: 100px;"><br>O DIRECTOR DE TURMA
                <!-- _____________________________________________________ -->
                <br><br><br>

            </th>
            <th class="th1"><br> O SUBDIRECTOR PEDAGÓGICO <br>
                <!-- ____________________________________________________ -->
                <br><br>    

            </th>
        </tr>
        <tr class="tr1">
            <td class="td1"> <?php echo "" ?>
            </td>
            <td class="td1"> <?php echo $cabecalho->vc_nomeSubdirectorPedagogico; ?> <br>
            </td>
        </tr>

    </table>


</body>

</html>