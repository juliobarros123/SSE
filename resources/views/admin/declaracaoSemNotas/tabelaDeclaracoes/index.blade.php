@extends('layouts.admin')

@section('titulo', 'Home')

 @section('conteudo')
 <div class="card mt-3">
 <div class="card-body">
  <h3>Visualizar Declarações</h3>

 </div>
 </div>


 <div class="d-flex justify-content-end mb-3">
    <a class="btn btn-dark" href=" {{ url('Declaracoes/paginaCadastrar') }}">
        <strong class="text-light">Cadastrar Declaração</strong>
    </a>
</div>
    <table id="example" class="display table table-hover">
           <thead class="">
            <tr>
                <th>Declaração</th>
                <th>Número de processo do aluno</th>
                <th>Classe</th>
                <th>Data</th>
                <th>Efeito</th>
                <th>Tipo de declaração</th>
                <th>Acções</th>

            </tr>
        </thead>

        @foreach ($declaracaosemnotas as $declaracaosemnota)
            <tr>

                <td>{{ $declaracaosemnota->id }}</td>
                <td>{{ $declaracaosemnota->it_id_processoAluno }}</td>
                <td>{{ $declaracaosemnota->classe }}</td>
                <td>{{ $declaracaosemnota->dt_declaracao }}</td>
                <td>{{ $declaracaosemnota->vc_efeito }}</td>
                <td>{{ $declaracaosemnota->vc_tipoDeclaracao }}</td>
                <td class="text-center">
                    <div class="dropdown">
                        <button class="btn btn-dark btn-sm dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-clone fa-sm" aria-hidden="true"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a href="{{ route('paginaEditar', $declaracaosemnota->id) }}" class="dropdown-item"
                                name="aluno">Editar</a>
                            <a href="{{ route('eliminar', $declaracaosemnota->id) }}" class="dropdown-item"
                                onclick="return confirm('Tens certeza que pretende eliminar?');">Eliminar</a>
                            <a href="{{ route('paginaDeclaracao', $declaracaosemnota->id) }}" class="dropdown-item">Gerar
                                declaração</a>

                        </div>
                    </div>
                </td>



            </tr>
        @endforeach
    </table>
    <script src="{{asset('/js/datatables/jquery-3.5.1.js')}}"></script>

    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });

    </script>
    <!-- Footer-->
    @include('admin.layouts.footer')


@endsection


