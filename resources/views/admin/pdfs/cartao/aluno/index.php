<!DOCTYPE html>
<html lang="pt-pt">

<head>
    <meta charset="UTF-8">

    <title>Cartão de Estudante</title>
    <style>
        <?php echo $bootstrap;
        echo $css; ?>
    </style>
</head>

<?php
$ur = '';
if ($cabecalho->vc_nif == "5000298182") {
    $url =  . 'cartões/CorMarie/aluno.png';
} else if ($cabecalho->vc_nif == "7301002327") {
    $url =  . 'cartões/InstitutoPolitécnicodoUIGE/aluno.png';
} else if ($cabecalho->vc_nif == "7301000626") {
    $url =  . 'cartões/negage/aluno.png';
} else if ($cabecalho->vc_nif == "5000820440") {

    $url =  . 'cartões/Quilumosso/aluno.png';
} else if ($cabecalho->vc_nif == "5000305308") {
    $url =  . 'cartões/Foguetao/aluno.png';
} else if ($cabecalho->vc_nif == "7301002572") {
    $url =  . 'cartões/LiceuUíge/aluno.png';
} else if ($cabecalho->vc_nif == "7301003617") {
    $url =  . 'cartões/ldc/aluno.png';
} else if ($cabecalho->vc_nif == "5000300926") {
    $url =  . 'cartões/imagu/aluno.png';
} else {
    $path =  ;
    // echo $parent_directory; // Output: "cecnhq"
    $parent_directory = basename(dirname($path));
    if (is_dir( . "cartões/$parent_directory/")) {
        $url =  . "cartões/$parent_directory";
    } else {
        $url =  . "cartões/" . strtoupper($parent_directory);
    }
    $url =  $url . "/aluno.png";
} ?>






<body style="background-image: url(<?php echo $url ?>);background-position: top left; background-repeat: no-repeat;
             background-image-resize: 2;
             background-image-resolution: from-image;">
    <?php foreach ($alunos as $aluno) : ?>

        <?php

        if ($cabecalho->vc_nif == "5000298182") {
            $aluno->vc_imagem =  . '' . $aluno->vc_imagem;
        } else if ($cabecalho->vc_nif == "7301002327") {
            $aluno->vc_imagem =  . '' . $aluno->vc_imagem;
        } else if ($cabecalho->vc_nif == "5000303399") {
            $aluno->vc_imagem =  . '' . $aluno->vc_imagem;;
        } else if ($cabecalho->vc_nif == "5000820440") {

            $aluno->vc_imagem =  . '' . $aluno->vc_imagem;
        } else if ($cabecalho->vc_nif == "5000305308") {
            $aluno->vc_imagem =  . '' . $aluno->vc_imagem;
        } else if ($cabecalho->vc_nif == "7301002572") {
            $aluno->vc_imagem =  . '' . $aluno->vc_imagem;
        } else if ($cabecalho->vc_nif == "7301003617") {
            $aluno->vc_imagem =  . '' . $aluno->vc_imagem;
        } else if ($cabecalho->vc_nif == "5000300926") {
            $aluno->vc_imagem =  . '' . $aluno->vc_imagem;
        } else {
            $aluno->vc_imagem =  . '' . $aluno->vc_imagem;
        } ?>
        <div class="position-relative">

            <section class="content">

                <img src="<?php echo $aluno->vc_imagem; ?>" class="foto">

                <div> <b></b></div>
                <div class="proc"> <b><?php echo $aluno->id ?></b></div>
                <div class="anolectivo"><?php echo $aluno->vc_anoLectivo; ?></div>
                <div class="nome">
                    <b>
                        <?php
                        $myvalue = $aluno->vc_primeiroNome;
                        $arr = explode(' ', trim($myvalue));

                        echo substr($arr[0] . " " . $aluno->vc_ultimoaNome, 0, 20);
                        ?>
                    </b>
                </div>
                <div class="turma"><b style="color:white!important;"><?php echo $aluno->vc_nomedaTurma; ?></b></div>
                <div class="classe" style="margin-left:144px;margin-top:-4.5px"><b><?php echo date('Y') + ((isset($anoValidade->it_qtAno) ? $anoValidade->it_qtAno : 0) + 11) - $aluno->vc_classe;  ?> <?php echo " " ?></b></div>
                <div class="curso"><b><?php echo substr($aluno->vc_shortName, 0, 33); ?></b></div>

            </section>


        </div>
    <?php endforeach; ?>

</body>

</html>