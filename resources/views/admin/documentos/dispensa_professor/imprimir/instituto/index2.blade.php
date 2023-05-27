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
    <title>PEDIDO DE DISPENSA DO PROFESSOR </title>
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
           /*  border: 1px solid red; */
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
            padding-bottom: -2px;
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
            margin-top: 50px !important;
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
            top: 266px;
            left: 115px;
            width: 615px;
            max-width: 615px;
            text-align: left;
            padding: 0 0 0 5px;
           /*  border: 1px solid red; */
        }
        #pre_disciplina {
            position: absolute;
            top: 300px;
            left: 220px;
            width: 155px;
            max-width: 155px;
            text-align: left;
            padding: 0 0 0 5px;
           /*  border: 1px solid red; */
        }

        #pre_classe {
            position: absolute;
            top: 300px;
            left: 430px;
            width: 40px;
            max-width: 40px;
            text-align: center;
            padding: 0 0 0 5px;
           /*  border: 1px solid red; */
        }

        #pre_curso {
            position: absolute;
            top: 300px;
            left: 525px;
            width: 210px;
            max-width: 210px;
            height: 25px;
            max-height: 25px;
            text-align: left;
            padding: 0 0 0 5px;
           /*  border: 1px solid red; */
      
        }

        #pre_periodo {
            position: absolute;
            top: 334px;
            left: 115px;
            width: 120px;
            max-width: 120px;
            text-align: left;
            padding: 0 0 0 5px;
           /*  border: 1px solid red; */
        }

    </style>
</head>

<body>
    <div class="container">
        <div class="cab-doc">
            <img src="<?php echo ; ?>images/insignia.png" alt="" class="logo" width="100px" height="70px"
                style="margin-top: -10px;">

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

        <p class="title text-center">PEDIDO DE DISPENSA DO PROFESSOR</p>
        <br>
        <div class="dados">
            <p>&nbsp;&nbsp;&nbsp;NOME: …………………………………………………………………………………………………….............................</p>
            <P>&nbsp;&nbsp;&nbsp;Disciplina que lecciona:……………….................... classe………..ª
                Curso……………………..………………....</P>
            <p>&nbsp;&nbsp;&nbsp;Período………………………. </p>
        </div>
        <div class="corpo">
            <div class="mb-0" style="line-height: 16px;">
                {{--  <p >&nbsp;Vai ausentar se por motivos de.……………………………………………………………..............</p>
                <p >………………………………………………………………………………………………........................</p>
                <p >………………………………………………………………………………………………........................</p>
                <p >………………………………………………………………………………………………........................</p>
                <p >………………………………………………………………………………………………........................<p>
                <p >………………………………………………………………………………………………........................</p>
                <p  style="margin-bottom: 20px;">………………………………………………………………………………………………........................</p> --}}
                <p style="margin-bottom: 20px;">Vai ausentar se por motivos de {{ $motivo }}</p>
            </div>

            <p> No periodo de {{ $diferencaEmDias }} dias, a contar de {{ date('d / m / Y', strtotime($data1)) }}&nbsp;
                a {{ date('d / m / Y', strtotime($data2)) }}.{{-- ……..../……..../…….../ a …….../………..../……….... --}}</p>

            <p style="margin-top: 25px;"><strong><i>Documentos comprovativos em anexo?</i> </strong></p>
            <p>SIM <input type="checkbox" name="" id=""
                    {{ $comprovativo == 1 ? "checked='checked'" : '' }}>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NÃO <input type="checkbox"
                    name="" id="" {{ $comprovativo == 0 ? "checked='checked'" : '' }}></p>

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


            </div>
        </div>
    </div>
    <div id="pre_nome">
        {{ $funcionario->vc_primeiroNome . ' ' . $funcionario->vc_ultimoNome }}
    </div>
    <div id="pre_disciplina">
        {{$disciplina}}
    </div>

    <div id="pre_classe">
        {{$classe}}
    </div>

    <div id="pre_curso">
        <span style="text-transform: capitalize;">{{$curso}}</span>
    </div>

    <div id="pre_periodo">
        <span style="text-transform: capitalize;">{{$periodo}}</span>
    </div>


</body>

</html>
