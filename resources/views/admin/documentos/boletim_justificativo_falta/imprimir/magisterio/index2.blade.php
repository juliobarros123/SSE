{{-- <!DOCTYPE html>
<html lang="pt-pt">
    @php
    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    date_default_timezone_set('Africa/Luanda');
@endphp
<head>
    <meta charset="UTF-8">

    <title>BOLETIM DE JUSTIFICATUIVO DE FALTAS</title>
    <style type="text/css">
        .cab-doc {
            /* background-color: red; */
            /* padding-left: 20px; */
            /* text-transform: capitalize; */
            font-size: 11pt;
            /*
            font-weight: bold; */

            text-align: center;
            /* padding-top: 1600px; */
            /* height: 100px; */

        }

        #titulo {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;

            /* font castellar 16 */
        }

        .dados {
            margin-top: -2px;
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            padding: 0;
            padding-top: -25px;


        }

        #p2 {
            padding-top: -9px !important;
        }

        #p3 {
            padding-top: -9px !important;
        }

        #p4,
        #p5,
        #p6 {
            padding-top: -9px !important;
        }

        .data {

            width: 400px;
            max-width: 400px;
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            text-align: center;
            position: absolute;
            top: 425px;
            left: 350px;

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
    style="background-image: url('<?php echo __full_path(); ?>images/boletim_justificativo_falta/magisterio/boletim_justificativo_falta.png');background-position: top left;
background-repeat: no-repeat;
background-image-resize: 2;
background-image-resolution: from-image;">
    <div class="cab-doc">

        <br>
        <br>
        <br>
        <br>
        <p id="republica" style="line-height: 10px;"><?php echo $cabecalho->vc_republica; ?></p>

        <p id="ministerio" style="line-height: 10px;"> <?php echo $cabecalho->vc_ministerio; ?></p>

        <p id="nome_escola" style="line-height: 10px;"><?php echo $cabecalho->vc_escola . ' do Uíge'; ?></p>

        <p id="titulo"> <strong>Boletim de justificativo de Faltas/{{date('Y')}}.</strong> </p>
    </div>

    <div class="dados">
        <p id="p1">{{$aluno->vc_primeiroNome." ".$aluno->vc_nomedoMeio." ".$aluno->vc_ultimoaNome}}, aluno (a) matriculado nesta Instituição sob o Processo nº {{$aluno->id}}, na</p>
        <p id="p2">Turma {{$matricula->vc_nomedaTurma}} Sala {{$matricula->vc_salaTurma}} da {{$matricula->vc_classeTurma}}ª Classe, com o número de Ordem {{$n_ordem}} do Curso de </p>
        <p id="p3"><span style="text-transform: capitalize;">{{$matricula->vc_nomeCurso}}</span> Tendo faltado na
            Aula/Prova de </p>
        <p id="p4">@foreach ($faltas as $key => $falta)
            @if ($key != 0 && ($key != (count($faltas) -1) ))
                , {{$falta}}
            @elseif($key == 0)
                {{$falta}}
            @else
            e {{$falta}}
            @endif
        @endforeach No dia {{date('d/m/Y',strtotime($data_falta))}} por motivos de</p>
        <p id="p5">{{$motivo_falta}}. Vem mui respeitosamente solicitar ao Senhor(a) Subdiretor(a)
            Pedagógico(a) se digne autorizar. </p>

        <p id="p6">Espera deferimento. </p>
    </div>

    <div class="data">
        <span>Data: {{date('d')}} de <span style="text-transform: capitalize;">{{ strftime('%B', date('m')) }}</span> de {{date('Y')}}</span>
    </div>
    <div class="encarregado">
        <span>O (A) Encarregado (a) ____________________________________________________________________</span>
    </div>

    <div class="parecer">
        <p id="pp1">PARECER:</p>
        <p id="pp2">
            _____________________________________________________________________________________________________________________________________________
        </p>
        <p id="pp3">
            _____________________________________________________________________________________________________________________________________________
        </p>
        <p id="pp4">
            _____________________________________________________________________________________________________________________________________________
        </p>
        <p id="pp5">
            _____________________________________________________________________________________________________________________________________________
        </p>
        <p id="pp6">
            <span style="font-family: Arial;"><?php echo $cabecalho->vc_escola; ?></span> <span
                style="font-family: Arial;">aos</span>, _____<span
                style="font-family: Arial;">de</span>_______________<span style="font-family: Arial;">de</span>
            20_______
        </p>
    </div>

    <div class="subdirector">
        <p style="padding-top: -19px;">O Subdirector Pedagógico</p>
        <p style="padding-top: 15px;">_____________________________</p>
    </div>



</body>

</html>
 --}}
 date_default_timezone_set('Africa/Luanda');
 @endphp
 
 <head>
     <meta charset="UTF-8">
 
     <title>BOLETIM DE JUSTIFICATUIVO DE FALTAS</title>
     <style type="text/css">
         .cab-doc {
             /* background-color: red; */
             /* padding-left: 20px; */
             /* text-transform: capitalize; */
             font-size: 11pt;
             /*
             font-weight: bold; */
 
             text-align: center;
             /* padding-top: 1600px; */
             /* height: 100px; */
 
         }
 
         #titulo {
             font-family: 'Times New Roman', Times, serif;
             font-size: 11pt;
 
             /* font castellar 16 */
         }
 
         .dados {
             margin-top: -2px;
             font-family: 'Times New Roman', Times, serif;
             font-size: 11pt;
             padding: 0;
             padding-top: -25px;
 
 
         }
 
         #p2 {
             padding-top: -9px !important;
         }
 
         #p3 {
             padding-top: -9px !important;
         }
 
         #p4,
         #p5,
         #p6 {
             padding-top: -9px !important;
         }
 
         .data {
 
             width: 400px;
             max-width: 400px;
             font-family: 'Times New Roman', Times, serif;
             font-size: 11pt;
             text-align: center;
             position: absolute;
             top: 425px;
             left: 350px;
 
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
 
         #pre_nome {
             position: absolute;
             top: 258px;
             left: 95px;
             width: 385px;
             max-width: 385px;
             text-align: center;
             padding: 0;
         }
 
         #pre_processo {
             position: absolute;
             top: 258px;
             right: 165px;
             width: 80px;
             max-width: 80px;
             text-align: center;
             padding: 0;
         }
 
         #pre_turma {
             position: absolute;
             top: 285px;
             left: 140px;
             width: 45px;
             max-width: 45px;
             text-align: center;
             padding: 0;
         }
 
         #pre_sala {
             position: absolute;
             top: 285px;
             left: 220px;
             width: 65px;
             max-width: 65px;
             text-align: center;
             padding: 0;
         }
 
         #pre_classe {
             position: absolute;
             top: 285px;
             left: 310px;
             width: 45px;
             max-width: 45px;
             text-align: center;
             padding: 0;
         }
 
         #pre_numero {
             position: absolute;
             top: 285px;
             left: 580px;
             width: 40px;
             max-width: 40px;
             text-align: center;
             padding: 0;
         }
 
         #pre_curso {
             position: absolute;
             top: 312px;
             left: 95px;
             width: 500px;
             max-width: 500px;
             text-align: center;
             padding: 0;
         }
 
         #pre_faltas {
             position: absolute;
             top: 339px;
             left: 95px;
             width: 620px;
             max-width: 620px;
             text-align: center;
             padding: 0;
 
         }
 
         #pre_faltas2 {
             position: absolute;
             top: 339px;
             left: 295px;
             width: 185px;
             max-width: 185px;
             text-align: center;
             padding: 0;
         }
 
         #pre_faltas3 {
             position: absolute;
             top: 339px;
             left: 505px;
             width: 210px;
             max-width: 210px;
             text-align: center;
             padding: 0;
         }
 
         #pre_data {
             position: absolute;
             top: 339px;
             left: 770;
             width: 110px;
             max-width: 110px;
             text-align: center;
             padding: 0;
         }
 
         #pre_motivos {
             position: absolute;
             top: 367px;
             left: 95px;
             width: 210px;
             max-width: 210px;
             text-align: center;
             padding: 0;
         }
     </style>
 </head>
 
 <body
     style="background-image: url('<?php echo __full_path(); ?>images/boletim_justificativo_falta/magisterio/boletim_justificativo_falta.png');background-position: top left;
 background-repeat: no-repeat;
 background-image-resize: 2;
 background-image-resolution: from-image;">
     <div class="cab-doc">
 
         <br>
         <br>
         <br>
         <br>
         <p id="republica" style="line-height: 10px;"><?php echo $cabecalho->vc_republica; ?></p>
 
         <p id="ministerio" style="line-height: 10px;"> <?php echo $cabecalho->vc_ministerio; ?></p>
 
         <p id="nome_escola" style="line-height: 10px;"><?php echo $cabecalho->vc_escola . ' do Uíge'; ?></p>
 
         <p id="titulo"> <strong>Boletim de justificativo de Faltas/20___.</strong> </p>
     </div>
 
     <div class="dados">
         <p id="p1">___________________________________________________________, aluno (a) matriculado nesta
             Instituição sob o Processo nº ____________, na</p>
         <p id="p2">Turma_______ Sala__________ da _______ Classe, com o número de Ordem ______ do Curso de </p>
         <p id="p3">____________________________________________________________________________ Tendo faltado na
             Aula/Prova de </p>
         <p id="p4">______________________________________________________________________________________________
             No dia _________________ por motivos de</p>
         <p id="p5">________________________________. Vem mui respeitosamente solicitar ao Senhor(a) Subdiretor(a)
             Pedagógico(a) se digne autorizar. </p>
 
         <p id="p6">Espera deferimento. </p>
     </div>
 
     <div class="data">
         <span>Data: {{ date('d') }} de <span
                 style="text-transform: capitalize;">{{ strftime('%B', date('m')) }}</span> de {{ date('Y') }}</span>
     </div>
     <div class="encarregado">
         <span>O (A) Encarregado (a) ____________________________________________________________________</span>
     </div>
 
     <div class="parecer">
         <p id="pp1">PARECER:</p>
         <p id="pp2">
             _____________________________________________________________________________________________________________________________________________
         </p>
         <p id="pp3">
             _____________________________________________________________________________________________________________________________________________
         </p>
         <p id="pp4">
             _____________________________________________________________________________________________________________________________________________
         </p>
         <p id="pp5">
             _____________________________________________________________________________________________________________________________________________
         </p>
         <p id="pp6">
             <span style="font-family: Arial;"><?php echo $cabecalho->vc_escola; ?></span> <span style="font-family: Arial;">aos</span>,
             _____<span style="font-family: Arial;">de</span>_______________<span style="font-family: Arial;">de</span>
             20_______
         </p>
     </div>
 
     <div class="subdirector">
         <p style="padding-top: -19px;">O Subdirector Pedagógico</p>
         <p style="padding-top: 15px;">_____________________________</p>
     </div>
 
 
 
 
 
     <div id="pre_nome">
         {{ $aluno->vc_primeiroNome . ' ' . $aluno->vc_nomedoMeio . ' ' . $aluno->vc_ultimoaNome }}
     </div>
 
     <div id="pre_processo">
         {{ $aluno->id }}
     </div>
     <div id="pre_turma">
         {{ $matricula->vc_nomedaTurma }}
     </div>
     <div id="pre_sala">
         {{ $matricula->vc_salaTurma }}
     </div>
     <div id="pre_classe">
         {{ $matricula->vc_classeTurma }}ª
     </div>
     <div id="pre_numero">
         {{ $n_ordem }}
     </div>
 
     <div id="pre_curso">
         <span style="text-transform: capitalize;">{{ $matricula->vc_nomeCurso }}</span>
     </div>
     <div id="pre_faltas">
         @foreach ($faltas as $key => $falta)
             @if ($key != 0 && $key != count($faltas) - 1)
                 , {{ $falta }}
             @elseif($key == 0)
                 {{ $falta }}
             @else
                 e {{ $falta }}
             @endif
         @endforeach
 
     </div>
     <div id="pre_data">
         {{ date('d/m/Y', strtotime($data_falta)) }}
     </div>
     <div id="pre_motivos">
         {{ $motivo_falta }}
     </div>
 
 </body>
 
 </html>
 