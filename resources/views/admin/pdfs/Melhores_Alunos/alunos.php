<!DOCTYPE html>
<html lang="pt-pt">

<head>
    <meta charset="UTF-8">

    <title>Listas dos Melhores alunos</title>
    <style>
        <?php echo $bootstrap;
        echo $css;
        ?>
    </style>
</head>

<body>

    <div class=" text-center">
        <p class="center">
            <img src="<?php  ?>images/ensignia/<?php echo $cabecalho->vc_ensignia; ?>.png" class="ensignia">
            <br>
            <span class="Texto">
                <?php echo $cabecalho->vc_republica; ?>
                <br>
                <?php echo $cabecalho->vc_ministerio; ?> <br>
                <?php echo $cabecalho->vc_escola; ?></span>
            <br>
            <img src="<?php echo $cabecalho->vc_logo; ?>" class="logotipo">
        </p>
    </div>
    <div class=" text-center tem">
        QUADRO DE HONRA
    </div>
    <div class=" text-center tema">
        Ano Lectivo: <?php echo $anoLectivo;
                        ?> &nbsp;&nbsp;&nbsp;
        <?php echo $classe . "ª Classe";
        ?>&nbsp;&nbsp;&nbsp;
        <?php echo $trimestre . "º Trimestre";
        ?>
    </div>
    <?php $cont = 1;
    $n_cont = 0;
    $anoLectivoPublicado =  App\Models\AnoLectivoPublicado::get()->first();
    //  dd( $anoLectivoPublicado);
    $alunos_notas = collect();
    ?>

<div class="container" style="ba">
        <?php
        // dd($nota ? $nota : 14);
        if (($nota ? $nota : 14) == 14) : ?>
            <?php foreach ($alunos->unique('id') as $al) : ?>

                <?php
                // dd($classe);

                $dados = DB::table('notas')
                    ->join('alunnos', 'alunnos.id', '=', 'notas.it_idAluno')
                    ->where('alunnos.id', $al->id)
                    ->where('notas.vc_tipodaNota', $trimestre)
                    ->where('notas.id_ano_lectivo', $anoLectivoPublicado->id_anoLectivo)
                    ->where('notas.id_classe', $id_classe)

                    ->select(DB::raw('round(sum(fl_media)/count(fl_media) )as media'))->get();
                // dd(($nota?$nota:14),"ola");

                foreach ($dados as $media) :
                    // dd($nota);
                    if ($media->media >= ($nota ? $nota : 14) && $media->media <= $nota2) :

                ?>



            <?php
                        $dtd = new \stdClass();
                        $dtd->vc_imagem = $al->vc_imagem;
                        $dtd->vc_primeiroNome = $al->vc_primeiroNome;
                        $dtd->vc_ultimoaNome = $al->vc_ultimoaNome;
                        $dtd->id = $al->id;
                        $dtd->vc_nomedaTurma = $al->vc_nomedaTurma;
                        $dtd->vc_nomeCurso = $al->vc_nomeCurso;
                        $dtd->media = $media->media;
                        $alunos_notas->push($dtd);
                    endif;
                endforeach;

            endforeach;
            // dd();


            ?>

        <?php else :
        ?>
            <?php foreach ($alunos->unique('id') as $al) : ?>

                <?php
                $b = 'Electrónica e Telecomunicações';
                // dd(preg_match('/^[^A-Z]*$/', $b{0}));
                //    dd();
                // dd($nota);
                $dados = DB::table('notas')
                    ->join('alunnos', 'alunnos.id', '=', 'notas.it_idAluno')
                    ->where('alunnos.id', $al->id)
                    ->where('notas.vc_tipodaNota', $trimestre)
                    ->where('notas.id_ano_lectivo', $anoLectivoPublicado->id_anoLectivo)
                    ->where('notas.id_classe', $id_classe)
                    ->select(DB::raw('round(sum(fl_media)/count(fl_media) )as media'))->get();
                // dd(   $dados,$trimestre);
                // dd(($nota?$nota:14),"ola");
                foreach ($dados as $media) :
                    if ($media->media >= ($nota ? $nota : 14)  && $media->media <= ($nota2 ? $nota2 : 20)) :


                ?>


            <?php

                        $dtd = new \stdClass();
                        $dtd->vc_imagem = $al->vc_imagem;
                        $dtd->vc_primeiroNome = $al->vc_primeiroNome;
                        $dtd->vc_ultimoaNome = $al->vc_ultimoaNome;
                        $dtd->id = $al->id;
                        $dtd->vc_nomedaTurma = $al->vc_nomedaTurma;
                        $dtd->vc_nomeCurso = $al->vc_nomeCurso;
                        $dtd->media = $media->media;
                        $alunos_notas->push($dtd);

                    endif;
                endforeach;


            endforeach;
            // dd($alunos_notas);  
            ?>

        <?php endif ?>



        <?php
        $alunos_notas =  $alunos_notas->sortBy([['media', 'desc']]);
        foreach ($alunos_notas as $al) :  ?>

            <?php

            if ($cont == 21 || ($cont == 13  && $n_cont == 1)) {
                echo "<br><br><br><br> <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
                $n_cont = 1;
                $cont = 1;
            }
            ?>

            <div class="card">


                <div class="card-header">
                    <div class="quadro" style="background-image: url(<?php echo vrf_img($al->vc_imagem) ?>);background-position: top left;
          background-repeat: no-repeat; background-size:100% 100%;" width="100" height="100">
                    </div>
                </div>
                <div class="card-body text-left ">
                    <span>Nome: </span> <?php echo  $al->vc_primeiroNome . " " . $al->vc_ultimoaNome ?><br>
                    <span> Processo: </span> <?php echo $al->id ?><br>
                    <span> Turma: </span> <?php echo $al->vc_nomedaTurma ?><br>
                    <span> Curso: </span> <?php echo mb_strimwidth(pri_ultimo_nome($al->vc_nomeCurso)[0], 0, 4, ".") . ' '
                                                . pri_ultimo_nome($al->vc_nomeCurso)[1];  ?><br>
                    <span> Média: </span> <?php echo $al->media ?><br>
                    <img class="right" src="<?php ?>images/images.jpg" alt="">

                </div>
            </div>

        <?php
            $cont++;
        endforeach;
        ?>

    </div>
</body>



</html>