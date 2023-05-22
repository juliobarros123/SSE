
 <style>
     <?php echo $stylesheet; ?>
     .style-table{
         width: 100%;
         border: 2px solid #ccc;
     }
 </style>

<?php

if ($cabecalho->vc_nif == "5000298182") {
   $cabecalho->vc_logo = __full_path().'css/'.$cabecalho->vc_logo;
} else if ($cabecalho->vc_nif == "7301002327") {
    $cabecalho->vc_logo = __full_path().'css/'.$cabecalho->vc_logo;
} else if ($cabecalho->vc_nif == "5000303399") {
    $cabecalho->vc_logo = __full_path().'css/'.$cabecalho->vc_logo;;

} else if ($cabecalho->vc_nif == "5000820440") {

    $cabecalho->vc_logo = __full_path().'css/'.$cabecalho->vc_logo;
} else if ($cabecalho->vc_nif == "5000305308") {
    $cabecalho->vc_logo = __full_path().'css/'.$cabecalho->vc_logo;
} else if ($cabecalho->vc_nif == "7301002572") {
 $cabecalho->vc_logo = __full_path().''.$cabecalho->vc_logo;
} else if ($cabecalho->vc_nif == "7301003617") {
    $cabecalho->vc_logo = __full_path().''.$cabecalho->vc_logo;

} else if ($cabecalho->vc_nif == "5000300926") {
    $cabecalho->vc_logo = __full_path().'css/'.$cabecalho->vc_logo;
}else {
   $cabecalho->vc_logo = __full_path().'css/'.$cabecalho->vc_logo;
} ?>

 <div id="ficha">
 <img src="<?php echo $cabecalho->vc_logo; ?>" width="100" height="100" class="logo" />
    <div style="text-align: center;">
    <br>
    <p></p>
    <p><!-- Republica de Angola --> <?php echo $cabecalho->vc_republica; ?></p>
    <p><!-- Ministerio das Telecomunicações e Tecnologias de Informação --><?php echo $cabecalho->vc_ministerio; ?> </p>
<!--     <p>Ministerio da Educação</p> -->
    <p><!-- Instituto de Telecomunicações --><?php echo $cabecalho->vc_escola; ?></p>
</div>  
<div style=" " >
<?php if($alunno->foto != null){?>
 <img src="confirmados/<?php echo $alunno->foto; ?>" style="float: right;" width="100" height="100" class="logo" />
<?php }?>
 <div style="clear: both;"></div>
</div>


<div style="margin-top: 10px;">
<div >
</div>
<div >

</div>
    <table class="style-table">
        <th>
            <tr>
                <td style="text-align: center;">Curso:</td>
                <td style="text-align: center;">Classe:</td>
                <td style="text-align: center;">Ano Lectivo:</td>
                <td style="text-align: center;">Processo:</td>
                <td style="text-align: center;">Ultima turma:</td>

            </tr>

            <tr>
                <td style="text-align: center;"> <?= $alunno->vc_nomeCurso ?></td>
                <td style="text-align: center;"><?= $alunno->it_classe?$alunno->it_classe:'Sem classe' ?></td>
                <td style="text-align: center;"><?= $alunno->vc_anoLectivo ?></td>
                <td style="text-align: center;"><?= $alunno->processo ?></td>
                <td style="text-align: center;"><?= $alunno->vc_nomedaTurma?$alunno->vc_nomedaTurma:'Sem turma' ?></td>


            </tr>
        </th>
    </table>

    <div style="margin-top: 20px;">
        <p><strong>Nome Completo:</strong> <?= $alunno->vc_primeiroNome.' '.$alunno->vc_nomedoMeio.' '.$alunno->vc_ultimoaNome  ?></p>
        <p><strong>Data de Nascimento:</strong> <?= $alunno->dt_dataNascimento  ?></p>
        <p><strong>Genero:</strong> <?= $alunno->vc_genero  ?></p>
        <p><strong>Natural de </strong> <?= $alunno->vc_naturalidade  ?> Provincia de </strong> <?= $alunno->vc_provincia  ?> Nacionalidade Angolana </p>
        <p><strong>Filiação de :</strong> <?= $alunno->vc_namePai  ?> e de <?= $alunno->vc_nameMae  ?></p>
        <p><strong>Localidade:</strong> <?= $alunno->vc_residencia  ?></p>
        <p><strong>Telefone:</strong> <?php if($alunno->it_telefone !=null )  echo $alunno->it_telefone  ?></p>
        <p><strong>BI:</strong> <?php if($alunno->it_telefone !=null )  echo $alunno->vc_bi  ?></p>
        <p><strong>Estabelecimento de ensino que frequentou no ano anterior :</strong> <?php if($alunno->vc_EscolaAnterior !=null )  echo $alunno->it_telefone  ?></p>

    </div>

</div>
     <!-- <p class="aviso">No caso de se verificar que o candidato tenha prestado falsas declarações será eliminado da lista de inscrição.</p> -->
 <div>




