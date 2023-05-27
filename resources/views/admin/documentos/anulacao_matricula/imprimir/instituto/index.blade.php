<!DOCTYPE html>
<html lang="pt-pt">
    @php
    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    date_default_timezone_set('Africa/Luanda');
@endphp
<head>
    <meta charset="UTF-8">

    <title>PEDIDO DE ANULAÇÃO DE MATRÍCULAS</title>
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
        #titulo{
             font-family: 'Times New Roman', Times, serif;
            font-size: 17pt;

            /* font castellar 16 */
        }

        .dados{
            margin-top: 25px;
            font-family:"Calibri", sans-serif;
            font-size: 11pt;
            /* font calibir 12 */
           
        }
        #p1, #p2, #p3, #p4, #p5, #p6, {
           /*  line-height: 1px */
        }
        #p7{
            margin-top: 55px;
        }
        #p8{
            margin-top: 55px;
            font-size: 10pt;
        }

        #p10{
            margin-top: 45px;
            text-align: center;
        }
 
        #p11{
            text-align: right;
            
        }

        #nota{
            position: absolute;
            bottom: 35px;
            left: 35px;
             font-family: 'Times New Roman', Times, serif;
            font-style: italic;
            font-weight: bold;
            font-size: 9.5pt;
        

        }
        #nome_escola2{
            position: absolute;
            bottom: 265px;
           /*  border: 1px solid red; */
            text-align: center;
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            left: 47px;
            width: 700px;
            max-width: 700px;
            text-transform: uppercase;
          
        }
        #talao{
            position: absolute;
            bottom: 230px;
           /*  border: 1px solid red; */
            text-align: center;
            font-family: 'Times New Roman', Times, serif;
            font-size: 15pt;
            left: 47px;
            width: 700px;
            max-width: 700px;
          
        }
        #pb1{
            font-size: 12pt;
            font-family: 'Times New Roman', Times, serif;
            position: absolute;
            bottom: 135px;
            left: 35px;
            width: 720px;
            max-width: 720px;
            height: 80px;
            line-height: 30px;
        }

        #pb2{
            font-size: 12pt;
            font-family: 'Times New Roman', Times, serif;
            position: absolute;
            bottom: 160px;
            left: 35px;
            width: 720px;
            max-width: 720px;
        }
        #pb3{
            font-size: 12pt;
            font-family: 'Times New Roman', Times, serif;
            position: absolute;
            bottom: 135px;
            left: 35px;
            width: 720px;
            max-width: 720px;
           
        }
        #pb4{
            font-size: 12pt;
            font-family: 'Times New Roman', Times, serif;
            position: absolute;
            bottom: 110px;
            left: 35px;
          /*   border: 1px solid red; */
            width: 360px;
            max-width: 360px;
        }
        #pb5{
            font-size: 12pt;
            font-family: 'Times New Roman', Times, serif;
            position: absolute;
            bottom: 60px;
            right: 35px;
          /*   border: 1px solid red; */
            width: 360px;
            max-width: 360px;
            text-align: right
        }
        
    </style>
</head>

<body
    style="background-image: url('<?php echo ; ?>images/anulacao_matricula/instituto/anulacao_matricula.png');background-position: top left;
background-repeat: no-repeat;
background-image-resize: 2;
background-image-resolution: from-image;">
    <div class="cab-doc">

        <br> 
        <br>
        <span id="republica"><?php echo $cabecalho->vc_republica; ?></span>
        <br>
       <span id="ministerio"> <?php echo $cabecalho->vc_ministerio; ?></span>
        <br>
        <span id="nome_escola"><?php echo $cabecalho->vc_escola." DO UÍGE"; ?></span>
     
      <br><br>

      <span id="titulo"> <strong> PEDIDO DE ANULAÇÃO DE MATRÍCULAS</strong> </span>
    </div>

    <div class="dados">
        <p id="p1">NOME: {{$aluno->vc_primeiroNome." ".$aluno->vc_nomedoMeio." ".$aluno->vc_ultimoaNome}},
        filho(a) de {{$aluno->vc_namePai}} e de {{$aluno->vc_nameMae}},
        nascido(a) aos {{date('d',strtotime($aluno->dt_dataNascimento))}} de <span style="text-transform: capitalize;">{{ strftime('%B', date('m',strtotime($aluno->dt_dataNascimento))) }}</span> de {{date('Y',strtotime($aluno->dt_dataNascimento))}}, natural de {{$aluno->vc_naturalidade}},
        Município do {{$aluno->vc_naturalidade}}, Província do {{$aluno->vc_provincia}} Portador do
        B.I./Passaporte nº {{$aluno->vc_bi}}, passado pelo sector de identificação 
        do {{$aluno->vc_localEmissao}}, aos {{date('d',strtotime($aluno->dt_emissao))}} de <span style="text-transform: capitalize;">{{ strftime('%B', date('m',strtotime($aluno->dt_emissao))) }}</span> de {{date('Y',strtotime($aluno->dt_emissao))}}. </p>

        <p id="p7">
            Aluno matriculado sob o nº {{$aluno->id}} frequentou(a) a {{$matricula->vc_classeTurma}}ª classe na 
            Turma {{$matricula->vc_nomedaTurma}}, na sala {{$matricula->vc_salaTurma}} no curso de <span style="text-transform: capitalize;">{{$matricula->vc_nomeCurso}}</span> período 
            <span style="text-transform: capitalize;">{{$matricula->vc_turnoTurma}}</span> ano lectivo {{$ano_lectivo->ya_inicio}}/{{$ano_lectivo->ya_fim}}
        </p>
        <p id="p8">
            Vem mui respeitosamente solicitar ao Senhor(a) Subdiretor(a) Pedagógico(a) se digne <br> autorizar. 
        </p>

        <p id="p9">
            ………………………………………………………………………………………..<br>
            ………………………………………………………………………………………………………………..<br>
            ………………………………………………………………………………………………………………..<br>
        </p>

        <p id="p10">Uíge, {{date('d')}} de <span style="text-transform: capitalize;">{{ strftime('%B', date('m')) }}</span> de {{date('Y')}}</p>
          
        <p id="p11"> O requerente &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <br><br>…………………………………..</p>
        
    </div>

   
        <p id="nome_escola2"><?php echo $cabecalho->vc_escola." DO UÍGE"; ?></p>
        <p id="talao">Talão de Anulação de Matriculas</p>
        <p id="pb1">Nome {{$aluno->vc_primeiroNome." ".$aluno->vc_nomedoMeio." ".$aluno->vc_ultimoaNome}},
        Classe {{$matricula->vc_classeTurma}}ª, Turma {{$matricula->vc_nomedaTurma}}, na sala {{$matricula->vc_salaTurma}} no curso de
        <span style="text-transform: capitalize;">{{$matricula->vc_nomeCurso}}</span>, período  <span style="text-transform: capitalize;">{{$matricula->vc_turnoTurma}}</span>, Ano lectivo {{$ano_lectivo->ya_inicio}}/{{$ano_lectivo->ya_fim}}</p>
        <p id="pb4">Uíge, {{date('d')}} de <span style="text-transform: capitalize;">{{ strftime('%B', date('m')) }}</span> de {{date('Y')}}</p>
        <p id="pb5">Pela secretaria &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br> ………………………………………</p>
        <p id="nota">Nota: conservar o talão para apresentar na próxima confirmação</p>

     
   
</body>

</html>
