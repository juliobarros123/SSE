
<div style="text-align:center"><img src="<?php __full_path()?>images/ensignia/<?php echo $pegaCabecalho->vc_ensignia?>.png" width="100" height="100" class="logo" /></div>
		<p><div style="text-align:center"><?php echo $pegaCabecalho->vc_republica ?></div>
        <div style="text-align:center"><?php echo $pegaCabecalho->vc_ministerio?></div>
        <div style="text-align:center"><?php echo $pegaCabecalho->vc_escola.' '.$pegaCabecalho->vc_acronimo?></div>
        <div style="text-align:left"><img src="images/logotipo/logo.png" width="50" height="50" class="logo" /></div>
        <div style="text-align:center">GABINETE DA SUBDIRECTORA ADM E FINANCEIRA</div></p>

        <h1><div style="text-align:center">FOLHA DE SALÁRIO DOS FUNCIONÁRIOS</div></h1>

 <table class="table tabelaStyle text-center">
 <thead> 
            <tr class="text-center">
                <th>ID</th>
                <th>Nº BI</th>
                <th>NOME</th>
                {{--<th>Genero</th>--}}
                <th>Funçao</th>
                <th>Salário Líquido + Descontos </th>         
            </tr>
        </thead>
        <tbody>
            @if ($folhaSalarioFuncionarios)
                @foreach ($folhaSalarioFuncionarios as $funcionario)
                    <tr class="text-center">
                        <th>{{$funcionario->id}}</th>
                        <td>{{$funcionario->vc_bi }}</td> 
                        <th>{{$funcionario->vc_primeiroNome}} {{$funcionario->vc_ultimoNome}}</th>
                        {{--<th>{{$funcionario->vc_genero }}</th>--}}
                        <td>{{$funcionario->vc_funcao}}</td>
                        <td>{{$funcionario->dc_salarioLiquido}}</td>                        
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
