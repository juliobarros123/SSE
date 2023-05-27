<!DOCTYPE html>
<html lang="en">
@php
    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    date_default_timezone_set('Africa/Luanda');
@endphp

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PEDIDO DE DESPENSA ADMINISTRATIVA</title>
    <style>
        .container {
            width: 100%;
            margin: 0 auto;
            background: white;

        }

        .container p {
            margin: 5px;
        }

        .cab-doc {
            text-align: center;
            /* font-size: 11pt; */
        }

        .cab-doc .titles {
            font-size: 14px;
            text-align: center;
            line-height: 10px;
            padding: 0;

        }

        .cab-doc .logo {
            width: 25px !important;
            border: 1px solid red;
        }

        .container .text-center {
            text-align: center;
        }

        .container .title {
            margin-top: 20px;
            font-weight: bold;
            font-size: 22px;
        }

        .dados {
            padding-left: -5px;
            padding-bottom: 5px;
            padding-top: 15px;
            width: 695px;
            max-width: 695px;
            border: 1.5px solid black;
            margin-bottom: 40px;
            margin-left: 2px;
            line-height: 28px;
            font-family: Arial;
        }

        .corpo {
            width: 590px;
            margin: 0 auto;
            margin-top: 70px !important;
            text-align: justify;
            padding: 0;
            font-family: Arial;
            font-size: 11pt;

        }

        .corpo .mb-0 p {
            margin: 5px;
            padding: 0;
        }

        .corpo .text-right p {
            margin: 5px;
            padding: 0;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            width: 90%;
            margin: 0 auto;
            padding: 0 40px 40px 40px;

        }

        .footer hr {
            border: 1px solid rgba(54, 51, 51, 0.6);
            margin: 1px;

        }

        .footer .linhas {
            width: 600px;
            overflow: hidden;
            padding: 20px;
            padding-top: 0;
            margin: 0 auto;

        }

        .footer .linhas p {
            margin: 3px 0;
            padding: 0;
        }

        .footer .text-right {
            overflow: hidden;


        }

        #pre_nome {
            position: absolute;
            top: 224px;
            left: 115px;
            width: 615px;
            max-width: 615px;
            text-align: left;
            padding: 0 0 0 5px;
           /*  border: 1px solid red; */
        }

        #pre_area_trabalho {
            position: absolute;
            top: 258px;
            left: 185px;
            width: 540px;
            max-width: 540px;
            text-align: left;
            padding: 0 0 0 5px;
           /*  border: 1px solid red; */
        }

        #pre_periodo {
            position: absolute;
            top: 542px;
            left: 200px;
            width: 45px;
            max-width: 45px;
            text-align: center;
            padding: 0 0 0 5px;
           /*  border: 1px solid red; */
        }
        #pre_datas {
            position: absolute;
            top: 542px;
            left: 370px;
            width: 310px;
            max-width: 310px;
            text-align: left;
            padding: 0 0 0 5px;
           /*  border: 1px solid red; */
        }

        #pre_motivos{
            position: absolute;
            top: 385px;
            left: 108px;
            width: 575px;
            max-width: 575px;
            text-align: justify;
            padding: 0;
           /*  border: 1px solid red; */
            line-height: 35px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="cab-doc">
            <img src="<?php echo ; ?>images/insignia.png" alt="" class="logo" width="100px" height="70px"
                style="margin-top: -50px;">

            <p class="titles">
                REPÚBLICA DE ANGOLA
            </p>
            <p class="titles">
                MINISTÉRIO DA EDUCAÇÃO
            </p>
            <p class="titles" style="text-transform: uppercase;">
                <?php echo $cabecalho->vc_escola . ' DO UÍGE'; ?>
            </p>
        </div>

        <p class="title text-center">PEDIDO DE DISPENSA ADMINISTRATIVA</p>
        <br>
        <div class="dados">
            <p>&nbsp;&nbsp;&nbsp;NOME: {{ $funcionario->vc_primeiroNome . ' ' . $funcionario->vc_ultimoNome }}</p>
            <p>&nbsp;&nbsp;&nbsp;Área de trabalho: {{ $area_trabalho }}
            </p>
        </div>
        <div class="corpo">
            <div class="mb-0" style="line-height: 35px;">
                {{-- <p>………………………………………………………………………………………………........................</p>
                <p>………………………………………………………………………………………………........................</p>
                <p>………………………………………………………………………………………………........................</p>
                <p>………………………………………………………………………………………………........................</p>
                <p>………………………………………………………………………………………………........................
                <p>
                <p>………………………………………………………………………………………………........................</p>
                <p style="margin-bottom: 20px;">………………………………………………………………………………………………........................</p> --}}
                <p style="margin-bottom: 20px;">Vai ausentar se por motivos de {{$motivo}}</p>
            </div>

            <p> No periodo de {{ $diferencaEmDias }} dias, a contar de {{ date('d / m / Y', strtotime($data1)) }}&nbsp; a {{ date('d / m / Y', strtotime($data2)) }}.{{-- ……..../……..../…….../ a …….../………..../……….... --}}</p>

            <p style="margin-top: 25px;"><strong><i>Documentos comprovativos em anexo?</i> </strong></p>
            <p>SIM <input type="checkbox" name="" id="" {{($comprovativo == 1)?"checked='checked'":""}}>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NÃO <input type="checkbox"
                    name="" id=""  {{($comprovativo == 0)?"checked='checked'":""}}></p>

            <p style="margin-top: 25px;">Espera deferimento</p>

            <p class="text-center" style="margin-top: 22px;">
                Uige, {{ date('d') }} de <span
                style="text-transform: capitalize;">{{ strftime('%B', date('m')) }}</span> de {{ date('Y') }}
            </p>
            <div>
                <div class="text-right">
                    <p>O Professor(a)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </p>
                    <p style="font-weight: lighter;">________________________________&nbsp;&nbsp;&nbsp;</p>

                </div>
                <br>
            </div>
        </div>
        <div class="footer">
            <div
                style="border-bottom: 1.5px solid black;border-top: 1.5px solid black; width: 100%!important;height: 4px;">
            </div>
            <br>
            <div class="linhas" style="font-family: Arial; font-size: 11pt;">
                <p>Parecer da direção: </p>
                <p>……………………………………………………………………………………………….......................</p>
                <p>……………………………………………………………………………………………….......................</p>
                <p>……………………………………………………………………………………………….......................</p>
                <p>……………………………………………………………………………………………….......................</p>
                <p>……………………………………………………………………………………………….......................</p>

                <p class="text-right" style="margin-top: 16px;">…………………………………………</p>
            </div>
        </div>
    </div>
  {{--   <div id="pre_nome">
        {{ $funcionario->vc_primeiroNome . ' ' . $funcionario->vc_ultimoNome }}
    </div>
    <div id="pre_area_trabalho">
        {{ $area_trabalho }}
    </div> --}}
    
</body>

</html>
