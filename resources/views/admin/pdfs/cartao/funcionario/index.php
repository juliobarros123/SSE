        <!DOCTYPE html>
        <html lang="pt-pt">

        <head>
            <meta charset="UTF-8">

            <title>Cartão de Funcionario</title>
            <style>
                <?php



                echo $bootstrap;
                echo $css; ?>
            </style>
        </head>

        <?php
        $ur = '';
        if ($cabecalho->vc_nif == "5000298182") {
            $url = __full_path() . 'cartões/CorMarie/funcionario.png';
        } else if ($cabecalho->vc_nif == "7301002327") {
            $url = __full_path() . 'cartões/InstitutoPolitécnicodoUIGE/funcionario.png';
        } else if ($cabecalho->vc_nif == "7301000626") {
            $url = __full_path() . 'cartões/negage/funcionario.png';
        } else if ($cabecalho->vc_nif == "5000820440") {
            $url = __full_path() . 'cartões/Quilumosso/funcionario.png';
        } else if ($cabecalho->vc_nif == "5000305308") {
            $url = __full_path() . 'cartões/Foguetao/funcionario.png';
        } else if ($cabecalho->vc_nif == "7301002572") {
            $url = __full_path() . 'cartões/LiceuUíge/funcionario.png';
        } else if ($cabecalho->vc_nif == "7301003617") {
            $url = __full_path() . 'cartões/ldc/funcionario.png';
        } else if ($cabecalho->vc_nif == "5000300926") {
            $url = __full_path() . 'cartões/imagu/funcionario.png';
        } else {
            $path =  __full_path();
            // echo $parent_directory; // Output: "cecnhq"
            $parent_directory = basename(dirname($path));
            if (is_dir(__full_path() . "cartões/$parent_directory/")) {
                $url = __full_path() . "cartões/$parent_directory";
            } else {
                $url = __full_path() . "cartões/" . strtoupper($parent_directory);
            }
            $url =  $url . "/funcionario.png";
        } ?>


        <?php

        if ($cabecalho->vc_nif == "5000298182") {
            $response->vc_foto = __full_path() . '' . $response->vc_foto;
        } else if ($cabecalho->vc_nif == "7301002327") {
            $response->vc_foto = __full_path() . '' . $response->vc_foto;
        } else if ($cabecalho->vc_nif == "5000303399") {
            $response->vc_foto = __full_path() . '' . $response->vc_foto;
        } else if ($cabecalho->vc_nif == "5000820440") {

            $response->vc_foto = __full_path() . '' . $response->vc_foto;
        } else if ($cabecalho->vc_nif == "5000305308") {
            $response->vc_foto = __full_path() . '' . $response->vc_foto;
        } else if ($cabecalho->vc_nif == "7301002572") {
            $response->vc_foto = __full_path() . '' . $response->vc_foto;
        } else if ($cabecalho->vc_nif == "7301003617") {
            $response->vc_foto = __full_path() . '' . $response->vc_foto;
        } else if ($cabecalho->vc_nif == "5000300926") {
            $response->vc_foto = __full_path() . '' . $response->vc_foto;
        } else {
            $response->vc_foto = __full_path() . '' . $response->vc_foto;
        } ?>

        <body style="background-image: url(<?php echo $url ?>);background-position: top left;
                background-repeat: no-repeat;
                background-image-resize: 1;
                background-image-resolution: from-image;">

            <p>
            <div>
                <img src="<?php echo $response->vc_foto ?>" width="120" height="120" class="foto">

            </div>
            <section>
                <div class="data">
                    <div class="nome" style="margin-left:40px;"><?php echo substr(' ' . explode(' ', trim($response->vc_primeiroNome))[0] . ' ' . ' ' . explode(' ', trim($response->vc_ultimoNome))[count(explode(' ', trim($response->vc_ultimoNome))) - 1], 0, 27); ?></div>
                    <div class="funcao" style="margin-left:47px;"><?php echo  substr($response->vc_funcao, 0, 24); ?></div>
                    <div class="bi" style="margin-left:77px; margin-top:0.1px;"><?php echo $response->vc_agente ? $response->vc_agente : "pendente" ?></div>
                    <div class="bi" style="margin-left:54px;   margin-top:-3px"><?php echo $response->ya_anoValidade ?></div>
                </div>
                </div>
            </section>
            </p>
        </body>

        </html>