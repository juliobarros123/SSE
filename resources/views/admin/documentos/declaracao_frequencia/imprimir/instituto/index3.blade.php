<!DOCTYPE html>
<html lang="pt-pt">
@php
    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    date_default_timezone_set('Africa/Luanda');
@endphp

<head>
    <meta charset="UTF-8">

    <title>DECLARAÇÃO DE FREQUÊNCIA</title>
    <style type="text/css">
        .cab-doc {
            /* background-color: red; */
            /* padding-left: 20px; */
            text-transform: uppercase;
            font-size: 11pt;
            /*
            font-weight: bold; */

            text-align: center;
            /* padding-top: 1600px; */
            /* height: 100px; */

        }

        #titulo {
            font-family: 'Times New Roman', Times, serif;
            font-size: 13pt;
            margin-top: 30px;

            /* font castellar 16 */
        }

        .dados {
            margin-top: 35px;
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            padding: 0;
            /* padding-top: -25px; */
           

        }

        #p2 {
            /* padding-top: -9px !important; */
            margin-top: 20px!important;
            line-height: 15px;
        }

        #p3 {
            padding-top: -9px !important;
            line-height: 15px;
        }

        #p4,
        #p5,
        #p6, #p7, #p8, #p9, #p10, #p11, #p13, #p14 {
            padding-top: -9px !important;
            line-height: 15px;
        }
        #p12{
            padding-top: 2px;
            line-height: 15px;
        }

        .data {

            width: 550px;
            max-width: 550px;
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            text-align: center;
            position: absolute;
            top: 760px;
            left: 100px;
           /*  border: 1px solid red; */
           padding-right: 0;

        }

        .encarregado {

            width: 610px;
            max-width: 610px;
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            text-align: center;
            position: absolute;
            top: 450px;
            left: 252px;

        }

        .parecer {
            width: 932px;
            max-width: 932px;
            font-size: 11pt;
            position: absolute;
            top: 465px;
            /*    border: 1px solid black; */
        }

        #pp1 {
            font-family: Arial;
        }

        #pp6 {
            padding-top: 16px;

        }

        .subdirector {

            width: 400px;
            max-width: 400px;
            font-size: 11pt;
            text-align: center;
            position: absolute;
            top: 630px;
            left: 360px;
            font-family: Arial;

        }
    </style>
</head>

<body
    style="background-image: url('<?php echo ; ?>images/declaracao_frequencia/declaracao_frequencia.png');background-position: top left;
background-repeat: no-repeat;
background-image-resize: 2;
background-image-resolution: from-image;">
    <div class="cab-doc">

        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <p id="republica" style="line-height: 9px;"><?php echo $cabecalho->vc_republica; ?></p>

        <p id="ministerio" style="line-height: 9px;"> <?php echo $cabecalho->vc_ministerio; ?></p>

        <p id="nome_escola" style="line-height: 9px;"><?php echo $cabecalho->vc_escola . ' do Uíge'; ?></p>

        <p id="titulo"> <b>DECLARAÇÃO DE FREQUÊNCIA</b> </p>
    </div>

    <div class="dados">
        <p id="p1">Para efeitos de ________________________________________________________declara-se que</p>
        <p id="p2">______________________________________________________________________________, filho de </p>
        <p id="p3">_______________________________________ e de _________________________________________, </p>
        <p id="p4">natural de ___________________________, Província de _____________________, nascido aos </p>
        <p id="p5">_______ de _______________ de ___________ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; portador &nbsp; do &nbsp; Bilhete &nbsp; de &nbsp;Identidade nº </p>
        <p id="p6">_______________________,</p>
        <p id="p7">Passado pelo Arquivo de &nbsp; Identificação &nbsp; de &nbsp; ______________, aos ______ de ________ de </p>
        <p id="p8">_________, matriculado sob nº ____________, frequenta no ano lectivo __________o curso </p>
        <p id="p9">________________________________ da Área &nbsp; de &nbsp; formação &nbsp; de ______________________, da </p>
        <p id="p10">formação profissional média em regime <b>Diurno/Nocturno</b>, na turma &nbsp; ___ &nbsp; com o nº </p>
        <p id="p11">______, </p>
        <p id="p12">Por ser verdade e me ter sido solicitado, mandei passar a presente declaração, que vai </p>
        <p id="p13">por mim assinada e autenticada com o carimbo a selo branco/óleo em uso neste </p>
        <p id="p14">Instituto.</p>
    </div>

    <div class="data">
        <strong>INSTITUTO__________________________, AOS ___ DE ________ DE _______.</strong>
        <br>
        <br>
        <br>
        <br>

        <p style="text-align: left;padding-left: 10px;font-family: Arial;">Conferido por:_________________</p>
        <br>

        <p style="text-align: left;padding-top: -5px;font-family: Arial;">
            <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; O Subdirector Pedagógico</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span> O Director</span>
        </p>
        <p style="text-align: left;padding-top: 15px;font-family: Arial;padding-right: -10px;">
            &nbsp;&nbsp;_______________________________ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;______________________________
        </p>
    </div>
   



</body>

</html>
