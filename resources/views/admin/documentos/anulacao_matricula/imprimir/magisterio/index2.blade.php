{{-- <!DOCTYPE html>
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
            line-height: 1px
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
          
        }
        #talao{
            position: absolute;
            bottom: 220px;
           /*  border: 1px solid red; */
            text-align: center;
            font-family: 'Times New Roman', Times, serif;
            font-size: 14pt;
            left: 47px;
            width: 700px;
            max-width: 700px;
          
        }
        #pb1{
            font-size: 12pt;
            font-family: 'Times New Roman', Times, serif;
            position: absolute;
            bottom: 185px;
            left: 35px;
            width: 720px;
            max-width: 720px;
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
    style="background-image: url('<?php echo __full_path(); ?>images/anulacao_matricula/magisterio/anulacao_matricula.png');background-position: top left;
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
        <p id="p1">NOME: {{$aluno->vc_primeiroNome." ".$aluno->vc_nomedoMeio." ".$aluno->vc_ultimoaNome}},</p>
        <p id="p2">filho(a) de {{$aluno->vc_namePai}} e de {{$aluno->vc_nameMae}},</p>
        <p id="p3">nascido(a) aos {{date('d',strtotime($aluno->dt_dataNascimento))}} de <span style="text-transform: capitalize;">{{ strftime('%B', date('m',strtotime($aluno->dt_dataNascimento))) }}</span> de {{date('Y',strtotime($aluno->dt_dataNascimento))}}, natural de{{$aluno->vc_naturalidade}},</p>
        <p id="p4">Município do {{$aluno->vc_naturalidade}}, Província do {{$aluno->vc_provincia}} Portador do</p>
        <p id="p5">B.I./Passaporte nº {{$aluno->vc_bi}}, passado pelo sector de identificação </p>
        <p id="p6">do {{$aluno->vc_localEmissao}}, aos {{date('d',strtotime($aluno->dt_emissao))}} de <span style="text-transform: capitalize;">{{ strftime('%B', date('m',strtotime($aluno->dt_emissao))) }}</span> de {{date('Y',strtotime($aluno->dt_emissao))}}. </p>

        <p id="p7">
            Aluno matriculado sob o nº  {{$aluno->id}} frequentou(a) a {{$matricula->vc_classeTurma}}ª classe na <br>
            Turma {{$matricula->vc_nomedaTurma}}, na sala {{$matricula->vc_salaTurma}} no curso de <span style="text-transform: capitalize;">{{$matricula->vc_nomeCurso}}</span>  período <br>
            {{$matricula->vc_turnoTurma}} ano lectivo {{$ano_lectivo->ya_inicio}}/{{$ano_lectivo->ya_fim}}
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
        <p id="pb1">Nome Nome {{$aluno->vc_primeiroNome." ".$aluno->vc_nomedoMeio." ".$aluno->vc_ultimoaNome}}.</p>
        <p id="pb2">Classe {{$matricula->vc_classeTurma}}ª Turma {{$matricula->vc_nomedaTurma}}, na sala {{$matricula->vc_salaTurma}} no curso de</p>
        <p id="pb3"><span style="text-transform: capitalize;">{{$matricula->vc_nomeCurso}}</span> período <span style="text-transform: capitalize;">{{$matricula->vc_turnoTurma}}</span>. Ano lectivo {{$ano_lectivo->ya_inicio}}/{{$ano_lectivo->ya_fim}}</p>
        <p id="pb4">Uíge, {{date('d')}} de <span style="text-transform: capitalize;">{{ strftime('%B', date('m')) }}</span> de {{date('Y')}}</p>
        <p id="pb5">Pela secretaria &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br> ………………………………………</p>
        <p id="nota">Nota: conservar o talão para apresentar na próxima confirmação</p>

     
   
</body>

</html>
 --}}
 harset="UTF-8">

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

        #titulo {
            font-family: 'Times New Roman', Times, serif;
            font-size: 17pt;

            /* font castellar 16 */
        }

        .dados {
            margin-top: 25px;
            font-family: "Calibri", sans-serif;
            font-size: 11pt;
            /* font calibir 12 */

        }

        #p1,
        #p2,
        #p3,
        #p4,
        #p5,
        #p6,
            {
            line-height: 1px
        }

        #p7 {
            margin-top: 55px;
        }

        #p8 {
            margin-top: 55px;
            font-size: 10pt;
        }

        #p10 {
            margin-top: 45px;
            text-align: center;
        }

        #p11 {
            text-align: right;

        }

        #nota {
            position: absolute;
            bottom: 35px;
            left: 35px;
            font-family: 'Times New Roman', Times, serif;
            font-style: italic;
            font-weight: bold;
            font-size: 9.5pt;


        }

        #nome_escola2 {
            position: absolute;
            bottom: 265px;
            /*  border: 1px solid red; */
            text-transform: uppercase;
            text-align: center;
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            left: 47px;
            width: 700px;
            max-width: 700px;

        }

        #talao {
            position: absolute;
            bottom: 220px;
            /*  border: 1px solid red; */
            text-align: center;
            font-family: 'Times New Roman', Times, serif;
            font-size: 14pt;
            left: 47px;
            width: 700px;
            max-width: 700px;

        }

        #pb1 {
            font-size: 12pt;
            font-family: 'Times New Roman', Times, serif;
            position: absolute;
            bottom: 185px;
            left: 35px;
            width: 720px;
            max-width: 720px;
        }

        #pb2 {
            font-size: 12pt;
            font-family: 'Times New Roman', Times, serif;
            position: absolute;
            bottom: 160px;
            left: 35px;
            width: 720px;
            max-width: 720px;
        }

        #pb3 {
            font-size: 12pt;
            font-family: 'Times New Roman', Times, serif;
            position: absolute;
            bottom: 135px;
            left: 35px;
            width: 720px;
            max-width: 720px;
        }

        #pb4 {
            font-size: 12pt;
            font-family: 'Times New Roman', Times, serif;
            position: absolute;
            bottom: 110px;
            left: 35px;
            /*   border: 1px solid red; */
            width: 360px;
            max-width: 360px;
        }

        #pb5 {
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

        #pre_nome {
            position: absolute;
            top: 235px;
            left: 160px;
            width: 515px;
            max-width: 515px;
            text-align: center;
            padding: 0;

        }

        #pre_pai {
            position: absolute;
            top: 257px;
            left: 185px;
            width: 210px;
            max-width: 210px;
            text-align: center;
            padding: 0;

        }

        #pre_mae {
            position: absolute;
            top: 257px;
            left: 445px;
            width: 230px;
            max-width: 230px;
            text-align: center;
            padding: 0;

        }

        #pre_nascimento {
            position: absolute;
            top: 278px;
            left: 215px;
            width: 230px;
            max-width: 230px;
            text-align: center;
            padding: 0;

        }

        #pre_natural {
            position: absolute;
            top: 278px;
            right: 117px;
            width: 145px;
            max-width: 145px;
            text-align: center;
            padding: 0;

        }

        #pre_municipio {
            position: absolute;
            top: 300px;
            left: 200px;
            width: 120px;
            max-width: 120px;
            text-align: center;
            padding: 0;

        }

        #pre_provincia {
            position: absolute;
            top: 300px;
            left: 420px;
            width: 175px;
            max-width: 175px;
            text-align: center;
            padding: 0;

        }

        #pre_bi {
            position: absolute;
            top: 322px;
            left: 235px;
            width: 190px;
            max-width: 190px;
            text-align: center;
            padding: 0;


        }

        #pre_identificacao {
            position: absolute;
            top: 344px;
            left: 130px;
            width: 105px;
            max-width: 105px;
            text-align: center;
            padding: 0;

        }

        #pre_data_bi {
            position: absolute;
            top: 343px;
            left: 278px;
            width: 280px;
            max-width: 280px;
            text-align: center;
            padding: 0;

        }

        #pre_processo {
            position: absolute;
            top: 413px;
            left: 295px;
            width: 100px;
            max-width: 100px;
            text-align: center;
            padding: 0;

        }

        #pre_classe {
            position: absolute;
            top: 413px;
            left: 510px;
            width: 50px;
            max-width: 50px;
            text-align: center;
            padding: 0;

        }

        #pre_turma {
            position: absolute;
            top: 434px;
            left: 160px;
            width: 70px;
            max-width: 70px;
            text-align: center;
            padding: 0;

        }

        #pre_sala {
            position: absolute;
            top: 434px;
            left: 290px;
            width: 65px;
            max-width: 65px;
            text-align: center;
            padding: 0;

        }

        #pre_curso {
            position: absolute;
            top: 434px;
            left: 450px;
            width: 150px;
            max-width: 150px;
            text-align: center;
            padding: 0;

        }

        #pre_periodo {
            position: absolute;
            top: 453px;
            left: 110px;
            width: 140px;
            max-width: 140px;
            text-align: center;
            padding: 0;

        }

        #pre_ano_lectivo {
            position: absolute;
            top: 453px;
            left: 337px;
            width: 120px;
            max-width: 120px;
            text-align: left;
            padding: 0;

        }

        #talao_nome {
            position: absolute;
            bottom: 205px;
            left: 80px;
            width: 590px;
            max-width: 590px;
            text-align: center;
            padding: 0;
            font-size: 12pt;
            font-family: 'Times New Roman', Times, serif;
        }

        #talao_classe {
            position: absolute;
            bottom: 180px;
            left: 80px;
            width: 90px;
            max-width: 90px;
            text-align: center;
            padding: 0;
            font-size: 12pt;
            font-family: 'Times New Roman', Times, serif;
        }

        #talao_turma {
            position: absolute;
            bottom: 180px;
            left: 220px;
            width: 90px;
            max-width: 90px;
            text-align: center;
            padding: 0;
            font-size: 12pt;
            font-family: 'Times New Roman', Times, serif;
        }

        #talao_sala {
            position: absolute;
            bottom: 180px;
            left: 370px;
            width: 70px;
            max-width: 70px;
            text-align: center;
            padding: 0;
            font-size: 12pt;
            font-family: 'Times New Roman', Times, serif;
        }

        #talao_curso {
            position: absolute;
            bottom: 152px;
            left: 35px;
            width: 210px;
            max-width: 210px;
            text-align: center;
            padding: 0;
            font-size: 12pt;
            font-family: 'Times New Roman', Times, serif;
        }

        #talao_periodo {
            position: absolute;
            bottom: 152px;
            left: 315px;
            width: 100px;
            max-width: 100px;
            text-align: center;
            padding: 0;
            font-size: 12pt;
            font-family: 'Times New Roman', Times, serif;
        }

        #talao_ano_lectivo {
            position: absolute;
            bottom: 152px;
            left: 510px;
            width: 190px;
            max-width: 190px;
            text-align: left;
            padding: 0;
            font-size: 12pt;
            font-family: 'Times New Roman', Times, serif;
        }
    </style>
</head>

<body
    style="background-image: url('<?php echo __full_path(); ?>images/anulacao_matricula/magisterio/anulacao_matricula.png');background-position: top left;
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
        <span id="nome_escola"><?php echo $cabecalho->vc_escola . ' DO UÍGE'; ?></span>

        <br><br>

        <span id="titulo"> <strong> PEDIDO DE ANULAÇÃO DE MATRÍCULAS</strong> </span>
    </div>

    <div class="dados">
        <p id="p1">NOME: ……………………………………………………………………………………….………….....,</p>
        <p id="p2">filho(a) de ……………..………………………...... e de ………………..……....………………......,</p>
        <p id="p3">nascido(a) aos ……......…………………..........……....., natural de ……………………….......,</p>
        <p id="p4">Município do ……………….…......, Província do ………………….………........... Portador do</p>
        <p id="p5">B.I./Passaporte nº ………………………..…............., passado pelo sector de identificação </p>
        <p id="p6">do …………………..., aos ……….......………………...……........……………. </p>

        <p id="p7">
            Aluno matriculado sob o nº………………...... frequentou(a) a ……....... classe na <br>
            Turma………………, na sala…………… no curso de ……………...……………… período <br>
            ……………………………ano lectivo…………….……..…
        </p>
        <p id="p8">
            Vem mui respeitosamente solicitar ao Senhor(a) Subdiretor(a) Pedagógico(a) se digne <br> autorizar.
        </p>

        <p id="p9">
            ………………………………………………………………………………………..<br>
            ………………………………………………………………………………………………………………..<br>
            ………………………………………………………………………………………………………………..<br>
        </p>

        <p id="p10">Uíge, {{ date('d') }} de <span
                style="text-transform: capitalize;">{{ strftime('%B', date('m')) }}</span> de {{ date('Y') }}</p>

        <p id="p11"> O requerente &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <br><br>…………………………………..
        </p>

    </div>


    <p id="nome_escola2"><?php echo $cabecalho->vc_escola . ' DO UÍGE'; ?></p>
    <p id="talao">Talão de Anulação de Matriculas</p>
    <p id="pb1">Nome………………………………………………………………………………………………………..………..........</p>
    <p id="pb2">Classe …….………..... Turma………………..., na sala……………... no curso de</p>
    <p id="pb3">………………...…………………… período…………………. Ano lectivo…………….……..……</p>
    <p id="pb4">Uíge, {{ date('d') }} de <span
            style="text-transform: capitalize;">{{ strftime('%B', date('m')) }}</span> de {{ date('Y') }}</p>
    <p id="pb5">Pela secretaria &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br>
        ………………………………………</p>
    <p id="nota">Nota: conservar o talão para apresentar na próxima confirmação</p>


    <div id="pre_nome"> {{ $aluno->vc_primeiroNome . ' ' . $aluno->vc_nomedoMeio . ' ' . $aluno->vc_ultimoaNome }}
    </div>
    <div id="pre_pai">{{ $aluno->vc_namePai }}</div>
    <div id="pre_mae">{{ $aluno->vc_nameMae }}</div>
    <div id="pre_nascimento">{{ date('d', strtotime($aluno->dt_dataNascimento)) }} de <span
            style="text-transform: capitalize;">{{ strftime('%B', date('m', strtotime($aluno->dt_dataNascimento))) }}</span>
        de {{ date('Y', strtotime($aluno->dt_dataNascimento)) }}</div>
    <div id="pre_natural">{{ $aluno->vc_naturalidade }}</div>
    <div id="pre_municipio">{{ $aluno->vc_naturalidade }}</div>
    <div id="pre_provincia">{{ $aluno->vc_provincia }}</div>
    <div id="pre_bi">{{ $aluno->vc_bi }}</div>
    <div id="pre_identificacao">{{ $aluno->vc_localEmissao }}</div>
    <div id="pre_data_bi">{{ date('d', strtotime($aluno->dt_emissao)) }} de <span
            style="text-transform: capitalize;">{{ strftime('%B', date('m', strtotime($aluno->dt_emissao))) }}</span>
        de
        {{ date('Y', strtotime($aluno->dt_emissao)) }}</div>
    <div id="pre_processo">{{ $aluno->id }}</div>
    <div id="pre_classe">{{ $matricula->vc_classeTurma }}ª</div>
    <div id="pre_turma">{{ $matricula->vc_nomedaTurma }}</div>
    <div id="pre_sala">{{ $matricula->vc_salaTurma }}</div>
    <div id="pre_curso"><span style="text-transform: uppercase;">{{ $matricula->vc_shortName }}</span></div>
    <div id="pre_periodo" style="text-transform: capitalize">{{ $matricula->vc_turnoTurma }}</div>
    <div id="pre_ano_lectivo">{{ $ano_lectivo->ya_inicio }}/{{ $ano_lectivo->ya_fim }}</div>


    <div id="talao_nome"> {{ $aluno->vc_primeiroNome . ' ' . $aluno->vc_nomedoMeio . ' ' . $aluno->vc_ultimoaNome }}
    </div>
    <div id="talao_classe">{{ $matricula->vc_classeTurma }}ª</div>
    <div id="talao_turma">{{ $matricula->vc_nomedaTurma }}</div>
    <div id="talao_sala">{{ $matricula->vc_salaTurma }}</div>
    <div id="talao_curso"><span style="text-transform: uppercase;">{{ $matricula->vc_shortName }}</span></div>
    <div id="talao_periodo" style="text-transform: capitalize">{{ $matricula->vc_turnoTurma }}</div>
    <div id="talao_ano_lectivo">{{ $ano_lectivo->ya_inicio }}/{{ $ano_lectivo->ya_fim }}</div>

</body>

</html>
