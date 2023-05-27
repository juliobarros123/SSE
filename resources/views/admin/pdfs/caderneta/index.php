<table>
<?php $contador = 1 ?>

<html lang="pt-br">

<head>
    <meta chasrset="utf-8" />
    <title>Cadernetas</title>

    <style>
        * {
            margin: 0px;
            padding: 0px;
        }

        <?php echo $bootstrap;
        echo $css; ?>
    </style>
</head>

<body>
    <?php foreach ($alunos as $aluno) : ?>
        <?php

if ($cabecalho->vc_nif == "5000298182") {
   $aluno->vc_imagem = .''.$aluno->vc_imagem;
} else if ($cabecalho->vc_nif == "7301002327") {
    $aluno->vc_imagem = .''.$aluno->vc_imagem;
} else if ($cabecalho->vc_nif == "5000303399") {
    $aluno->vc_imagem = .''.$aluno->vc_imagem;;

} else if ($cabecalho->vc_nif == "5000820440") {

    $aluno->vc_imagem = .''.$aluno->vc_imagem;
} else if ($cabecalho->vc_nif == "5000305308") {
    $aluno->vc_imagem = .''.$aluno->vc_imagem;
} else if ($cabecalho->vc_nif == "7301002572") {
 $aluno->vc_imagem = .''.$aluno->vc_imagem;
} else if ($cabecalho->vc_nif == "7301003617") {
    $aluno->vc_imagem = .''.$aluno->vc_imagem;

} else if ($cabecalho->vc_nif == "5000300926") {
    $aluno->vc_imagem = .''.$aluno->vc_imagem;
}else {
   $aluno->vc_imagem = .''.$aluno->vc_imagem;
} ?>
        <div class="div-top">
            <div class="header-principal">

                <p><?php echo $cabecalho->vc_escola; ?></p>
                <p>Caderneta de Aluno</p>

                <div class="header-footer-img">
                    <div class="header-footer-img1">
                        <br><br>
                    </div>

                </div>
            </div>
            <div class="foto-aluno">
                <img width="110" height="100" src="<?php echo $aluno->vc_imagem; ?>" />
            </div>

            <div id="container2">
                <div id="box-1" class="box">

                    <h5 id="nome"><strong>Nome: </strong><a><?php echo $aluno->vc_primeiroNome . " " . $aluno->vc_ultimoaNome; ?></a></h5>
                    <h5 id="email"><strong>Nº de Ordem: </strong><a><?php echo $contador++ ?></a></h5>

                </div>
                <div id="box-2" class="box">
                    <h5 id="processo"><strong>Processo: </strong><a><?php echo $aluno->id ?></a></h5>
                    <h5 id="telefone"><strong>Telefone: </strong><a><?php echo $aluno->it_telefone ?></a></h5>
                </div>

                <h5 id="turma"><strong>Turma: </strong><a><?php echo $turma->vc_nomedaTurma . "-" . $turma->vc_turnoTurma; ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a><?php echo $turma->vc_classeTurma; ?><strong>ªClasse</strong></a></h5>


                <h5 id="disciplina"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Disciplina:&nbsp;&nbsp;&nbsp; </strong><a></a></h5>
                <h5 id="ano"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ano Lectivo: </strong><a><?php echo $turma->vc_anoLectivo; ?></a></h5>

            </div>



            <div id="container">
                <img src="images/caderneta/caderneta.jpg" />

            </div>
            <div id="container1">
                <img style="width:98% !important; height: 90px !important;" src="images/caderneta/cadernetabottom.jpg" />

            </div>
        </div>

        </div>
        <div class="tabledata">
            <table class="tabela">
                <!-- <tr></tr> -->
                <tr>
                    <td class="text-left"><strong><a>Nome do Enc. de Educação: </a></strong><?php if ($aluno->vc_namePai) : echo $aluno->vc_namePai;
                                                                                            else : echo $aluno->vc_nameMae;
                                                                                            endif ?></td>

                </tr>

                <!-- <tr></tr> -->
            </table>
        </div>
        <h5><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;OBS:_______________________________________________________________________________________________________________________________________________</strong></h5>
        </div><!-- <br><br><br><br><br> -->
        <div class="text-center" style="line-height: 1x; margin-top: 10px;">
        <p class="director">O PROFESSOR</p>
        <!-- linha por baixo do professor de tamanho em questão, simplesmente! -->
        <?php for ($i = 0; $i < 40; $i++) {
            echo "_";
        } ?>


    </div>
    <?php endforeach; ?>
</body>

</html>

</table>
