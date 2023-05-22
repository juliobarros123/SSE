<html lang="pt-br">
    <head>
        <meta charset="utf-8" />

    </head>
    <body>
    <div id="cabecalho" >
    <caption>
        <img src="<?php echo isset($filtroDadosDoAlunoeDaEscola) ? "images/logotipo/".$filtroDadosDoAlunoeDaEscola['vc_logo'].".png": ' ' ?>"
            alt="">
    </caption>
    <p  id="vc_ministerio" >
        <?php echo isset($filtroDadosDoAlunoeDaEscola) ? $filtroDadosDoAlunoeDaEscola['vc_ministerio'] : ' ' ?>
    </p>
    <p >
        <?php echo isset($filtroDadosDoAlunoeDaEscola) ? $filtroDadosDoAlunoeDaEscola['vc_escola'] : ' ' ?>
    </p>
    <p >
        <?php echo isset($filtroDadosDoAlunoeDaEscola) ? $filtroDadosDoAlunoeDaEscola['vc_endereco'] : ' ' ?>
        <?php echo isset($filtroDadosDoAlunoeDaEscola) ? $filtroDadosDoAlunoeDaEscola['it_telefone'] : ' '?>
    </p>
</div>
<div>




    <div id="declaracao">

        <div>
           <strong>Declaração</strong>
        </div>
    </div>

    <div id="referencia" >
        <div>
            <p  id="n_ref">N/Ref.Nº  <?php echo $ref; ?>
                <?php echo isset($filtroDadosDoAlunoeDaEscola) ? $filtroDadosDoAlunoeDaEscola['vc_escola'] : ' ' ; ?>/<?php echo $filtroDadosDoAlunoeDaEscola['vc_anoLectivo']  ?>
            </p>

        </div>
    </div>
</div>

<div>
    <div>
        <div  id="texto">

            <p style="">
                Para os devidos efeitos se declara que  <?php echo $filtroDadosDoAlunoeDaEscola['nome_do_aluno'] ; ?>, estudante
                do
                <?php echo isset($filtroDadosDoAlunoeDaEscola) ? $filtroDadosDoAlunoeDaEscola['it_classe'] : ' ' ; ?>º
                ano no curso de  <?php echo $filtroDadosDoAlunoeDaEscola['curso'] ; ?>
                na escola  <?php echo isset($filtroDadosDoAlunoeDaEscola) ? $filtroDadosDoAlunoeDaEscola['vc_escola'] : ' ' ?>.

                O rendimento pedagógico e respectivas disciplinas concluídas no
                <?php echo  isset($filtroDadosDoAlunoeDaEscola) ? $filtroDadosDoAlunoeDaEscola['it_classe'] : ' ' ?>º ano na
                escola,
                são resumidas na tabela que se segue:
            </p>
        </div>
    </div>


    <table  id="table">
        <thead>
            <tr>
                <th>Ord</th>
                <th>Disciplinas </th>
                <th>Classificações(Valores)</th>
            </tr>
        </thead>
   
        <tbody style=" ">
            <?php echo $id = 1;  ?>
         
            <?php  foreach ($DadosDoAluno1 as $DadosDoAluno1): ?>
            <?php  if(sizeof($DadosDoAluno1)==3):?>
                    <tr >
                        <td  > <?php echo $id ?></td>
                        <td ><?php echo $DadosDoAluno1[0]->vc_nome ?></td>
                        <td ><?php echo round((($DadosDoAluno1[0]->fl_media+$DadosDoAluno1[1]->fl_media+$DadosDoAluno1[2]->fl_media)/3), 0, PHP_ROUND_HALF_UP) ?>
                        </td>
                    </tr>
                    <?php endif;?>
                   
                    <?php $id++ ?>
             
                    <?php endforeach;?>


        </tbody>

    </table>




    <div  id="div_dep_table">
        <p>E por ser verdade, passou-se a presente declaração, que foi por mim assinada e
            carimbada a tinta de óleo em uso nesta escola.
        </p>
    </div>



    <p  id="data">
        <?php echo isset($filtroDadosDoAlunoeDaEscola) ? $filtroDadosDoAlunoeDaEscola['vc_endereco'] : ' ';?> , aos
        <?php echo date('d') ;?> de <?php echo date('m') ;?> de <?php echo  date('Y') ;?>
    </p>



    <div>
        <div  id="mestre">
            <p>O Chefe De Departamento</p>

            <p>__________________________</p>
            <p>
            <pre>(Mestre              )</pre>
            </p>
        </div>



        <div id="directora">
            <p>A Directora Adjunta Pedagógica </p>

            <p>__________________________</p>
            <p>
            <pre>(Mestre              )</pre>
            </p>
        </div>

    </div>



</div>
    </body>
</html>






