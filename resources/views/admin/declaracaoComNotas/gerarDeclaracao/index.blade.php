
@extends('layouts.admin')

@section('titulo', 'Declarações/Listar')

 @section('conteudo')
<div class="card mt-3">
    <div class="card-body">
    <h3>Listar Declarações Geradas</h3>
</div>
</div> 


 

    <table id="example" class="display table table-hover">
           <thead class="">
<tr>
<th>ID</th>
<th>PROCESSO DO ALUNO</th>
<th>NOME DO ALUNO </th>
<th>CLASSE</th>
 <th>DATA DE EMISSÃO</th>
 
</tr>
</thead>
<tbody class="bg-white">
    <?php global $id;
    $id=1;?>
@foreach($DadosDoAlunoDeDeclaracao as $DadosDoAlunoDeDeclaracao)

<tr>
<td>{{ $id}}</td>
<td>{{ $DadosDoAlunoDeDeclaracao->it_idAluno}}</td>
<td>{{ $DadosDoAlunoDeDeclaracao->vc_primeiroNome }} {{ $DadosDoAlunoDeDeclaracao->vc_nomedoMeio }} {{$DadosDoAlunoDeDeclaracao->vc_ultimoaNome}}</td>
<td>{{ $DadosDoAlunoDeDeclaracao->classe}}</td>
<td>{{ $DadosDoAlunoDeDeclaracao->dt_DataDeEmissaoDeDeclaracao}}</td>

<?php 
$id++;?>
</tr>
@endforeach
</tbody>

</table>



@endsection
