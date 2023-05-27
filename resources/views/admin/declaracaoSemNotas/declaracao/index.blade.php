<div style="display: flex;">
    <div style="width: 46.5%; float:left">
         <img src="images/logotipo/logo.png" width="55" height="55" class="logo" />
    </div>
    <div style="width: 50%; float:left">
        <img src="<?php ?>images/ensignia/<?php echo $pegaCabecalho->vc_ensignia?>.png" width="50" height="50" class="logo" />
    </div>

    <div style="clear:both"></div>
</div>


        <p><div style="text-align:center"><?php echo $pegaCabecalho->vc_escola ?></div>
        <div style="text-align:center"><?php echo $pegaCabecalho->vc_ministerio?></div>
        <div style="text-align:center"><?php echo $pegaCabecalho->vc_escola.' - '.$pegaCabecalho->vc_acronimo?></div></p>

        <div style="text-align:center"><h2><?php echo $pegaDeclaracao->vc_tipoDeclaracao?></h2></div>

        <p>Para efeitos <strong><?php echo $pegaDeclaracao->vc_efeito?></strong> declara-se que  <strong><?php echo $nome?></strong> filho(a) de 
        <strong><?php echo $pegaAluno->vc_namePai?></strong> e de <strong><?php echo $pegaAluno->vc_nameMae?>
        </strong> nascido aos <strong><?php echo $pegaAluno->dt_dataNascimento?>
        </strong> portador do Bilhete de Identidade nº <strong><?php echo $pegaAluno->vc_bi?></strong> 
         passado pelo arquivo de identificação de(o) <strong><?php echo $pegaAluno->vc_localEmissao?></strong> aos <strong><?php echo $pegaAluno->dt_emissao?></strong>
         sob o processo nº <strong><?php echo $pegaAluno->id?></strong>, <?php echo $frequencia?> 
         <p>
         Por ser verdade e me ter sido solicitado, mandei passar a presente Declaração que vai
         por mim assinada e autenticada com o carimbo a óleo em uso nesta escola.</p>
         <p>
         Luanda, <strong><?php echo $pegaDeclaracao->dt_declaracao?></strong></p>



        <div style="display: flex; margin-top:150px;">
            <div style="width: 35%; float:left ; margin:0px auto;">
                <p class="" style="text-align: center;">O Direitor (a)</p>
                <p class="" style="text-align: center;">________________________________</p>
                <p style="text-align: center;"><?php echo $pegaCabecalho->vc_nomeDirector ?></p>
            </div>
                
            <div style="clear:both"></div>
        </div>