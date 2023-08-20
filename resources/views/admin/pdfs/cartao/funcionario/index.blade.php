        <!DOCTYPE html>
        <html lang="pt-pt">

        <head>
            <meta charset="UTF-8">

            <title>Cartão de Funcionario</title>
            <style>
                <?php
                echo $css; ?>
            </style>
        </head>



        <body
            style="background-image: url(<?php echo fha_fundo('Funcionario')?fha_fundo('Funcionario'):'images/cartao/funcionario/cartao.jpg';?>);
            background-position: top left;
        background-repeat: no-repeat;
        background-image-resize: 1;
        background-image-resolution: from-image;">
            <div class="header">
                <img src="images/insignia-certificado.png" class="logo">


                <h3 class="info-cabecalho">{{ $cabecalho->vc_republica }} <br>{{ $cabecalho->vc_ministerio }}
                    <br>{{ $cabecalho->vc_escola }}


                </h3>


            </div>
            <div class="titulo">Passe de funcionário</div>

            <div class="losango"
                style="background-image: url(<?php echo $funcionario->vc_foto; ?>);  background-size: cover;  border:4px solid #1151a0;">

            </div>

            <div class="nome"><span class="info-funcionario">Nome</span> : <span
                    class="valor">{{ $funcionario->vc_primeiroNome . ' ' . $funcionario->vc_ultimoNome }}</span></div>
            <div class="funcao"><span class="info-funcionario">Função</span> : <span
                    class="valor">{{ $funcionario->vc_funcao }}</span></div>
            <div class="contacto"><span class="info-funcionario">Contacto</span> : <span
                    class="valor">{{ $funcionario->vc_telefone }}</span></div>

            <div class="validade"><span class="info-funcionario">Validade</span> : <span
                    class="valor">{{ $funcionario->ya_anoValidade }}</span></div>
            <div class="visa-container ">

                <div>O(A) Director(a) </div>
                <div class="box-assinatura-director">
                    <img src="{{ $cabecalho->assinatura_director }}" class="assinatura-director" alt="">
                </div>
                <hr class="hr-custom">

                <div class="director">
                    {{ $cabecalho->vc_nomeDirector }}

                </div>
            </div>
        </body>

        </html>
