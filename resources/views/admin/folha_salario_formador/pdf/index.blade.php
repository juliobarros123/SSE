
<div style="text-align:center"><img src="<?php ?>images/ensignia/<?php echo $pegaCabecalho->vc_ensignia?>.png" width="100" height="100" class="logo" /></div>
		<p><div style="text-align:center"><?php echo $pegaCabecalho->vc_republica ?></div>
        <div style="text-align:center"><?php echo $pegaCabecalho->vc_ministerio?></div>
        <div style="text-align:center"><?php echo $pegaCabecalho->vc_escola.' '.$pegaCabecalho->vc_acronimo?></div>
        <div style="text-align:left"><img src="images/logotipo/logo.png" width="50" height="50" class="logo" /></div>
        <div style="text-align:center">GABINETE DA SUBDIRECTORA ADM E FINANCEIRA</div></p>

        <h1><div style="text-align:center">FOLHA DE SALÁRIO DOS FORMADORES</div></h1>

        <table id="example" class="display table table-hover">
        <thead class="sidebar-dark-primary  text-white">
            <tr class="text-center">
                <th>ID</th>
                <th>Nº BI</th>
                <th>NOME</th>
                <th>Genero</th>
                <th>SAlÁRIO COMISSÃO</th>             
            </tr>
        </thead>
        <tbody class="bg-white">
            @if ($folhaSalarioformador)
                @foreach ($folhaSalarioformador as $formador)
                    <tr class="text-center">
                        <td>{{$formador->id}}</td>
                        <td>{{$formador->vc_bI }}</td> 
                        <td>{{$formador->vc_nome}}</td>
                        <td>{{$formador->vc_genero }}</td>
                        <td>{{$formador->dc_salario_comissao}}</td>                        
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
