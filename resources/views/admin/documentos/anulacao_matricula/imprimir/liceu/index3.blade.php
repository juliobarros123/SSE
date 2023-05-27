<!DOCTYPE html>
<html lang="pt-pt">

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
           text-transform: uppercase;
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
    style="background-image: url('<?php echo ; ?>images/anulacao_matricula/liceu/anulacao_matricula.png');background-position: top left;
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
        <p id="p1">NOME: ……………………………………………………………………………………….………….....,</p>
        <p id="p2">filho(a) de ……………..………………………...... e de ………………..……....………………......,</p>
        <p id="p3">nascido(a) aos …….. de ………………….. de ……....., natural de ……………………….......,</p>
        <p id="p4">Município do ……………….…......, Província do ………………….………........... Portador do</p>
        <p id="p5">B.I./Passaporte nº ………………………..…............., passado pelo sector de identificação </p>
        <p id="p6">do …………………..., aos ……… de ………………...……. de ……………. </p>

        <p id="p7">
            Aluno matriculado sob o nº………………...... frequentou(a) a ……......ª classe na <br>
            Turma………………, na sala…………… no curso de ……………../……………… período <br>
            ……………………………ano lectivo……………/……..…
        </p>
        <p id="p8">
            Vem mui respeitosamente solicitar ao Senhor(a) Subdiretor(a) Pedagógico(a) se digne <br> autorizar. 
        </p>

        <p id="p9">
            ………………………………………………………………………………………..<br>
            ………………………………………………………………………………………………………………..<br>
            ………………………………………………………………………………………………………………..<br>
        </p>

        <p id="p10">Uíge, ……. de ……………………… de 20……</p>
          
        <p id="p11"> O requerente &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <br><br>…………………………………..</p>
        
    </div>

   
        <p id="nome_escola2"><?php echo $cabecalho->vc_escola." DO UÍGE"; ?></p>
        <p id="talao">Talão de Anulação de Matriculas</p>
        <p id="pb1">Nome………………………………………………………………………………………………………..………..........</p>
        <p id="pb2">Classe …….………....ª Turma………………..., na sala……………... no curso de</p>
        <p id="pb3">………………../…………………… período…………………. Ano lectivo……………/……..……</p>
        <p id="pb4">Uíge, ……. de ……………………de 20…….</p>
        <p id="pb5">Pela secretaria &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br> ………………………………………</p>
        <p id="nota">Nota: conservar o talão para apresentar na próxima confirmação</p>

     
   
</body>

</html>
