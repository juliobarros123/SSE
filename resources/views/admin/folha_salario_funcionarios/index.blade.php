@extends('layouts.admin')

@section('titulo', 'Folha de Salário dos Funcionários')

 @section('conteudo')

 <div class="card mt-3">
        <div class="card-body">
            <h4>Gerar Folha de Sálario</h4>
            <form action="{{ route('cadastrarFolhaSalarioFuncionarioMensal')}}" method="post" class="row">
                @csrf
            @include('forms._formFolha_salario_funcionario.listar.index')
            <div class=" col-md-12 text-left d-flex justify-content-left ">
                    <button type="submit" class=" col-md-2 text-center btn btn-dark"> Gerar</button>
            </div>
            </form>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <h3>Folha de Salário dos Funcionários</h3>
        </div>
    </div>



  <!-- sweetalert -->
  <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
  @if (session('status'))
      <script>
          Swal.fire(
              'Dados Actualizados com sucesso',
              '',
              'success'
          )

      </script>
  @endif


    <table id="example" class="display table table-hover">
        <thead class="sidebar-dark-primary  text-white">
            <tr class="text-center">
                <th>ID</th>
                <th>Nº BI</th>
                <th>NOME</th>
             {{--   <th>Genero</th>--}}
                <th>Funçao</th>
                <th>Salário</th>
                <th>ACÇÕES</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            @if ($folhaSalarioFuncionarios)
                @foreach ($folhaSalarioFuncionarios as $funcionario)
                    <tr class="text-center">
                        <td>{{$funcionario->id}}</td>
                        <td>{{$funcionario->vc_bi }}</td>
                        <td>{{$funcionario->vc_primeiroNome}} {{$funcionario->vc_ultimoNome}}</td>
                       {{-- <td>{{$funcionario->vc_genero }}</td> --}}
                        <td>{{$funcionario->vc_funcao}}</td>
                        <td>{{$funcionario->dc_salarioLiquido}}</td>
                        @csrf
                        @method('delete')
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-dark btn-sm dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-clone fa-sm" aria-hidden="true"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a href="{{ route('verEditarFolhaSalarioFuncionario', $funcionario->id) }}"
                                        class="dropdown-item">Alterar Salário</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    <script src="{{asset('/js/datatables/jquery-3.5.1.js')}}"></script>

    <script>
        $(document).ready(function() {

            //start delete
            $('a[data-confirm]').click(function(ev) {
                var href = $(this).attr('href');
                if (!$('#confirm-delete').length) {
                    $('table').append(
                        '<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog" role="document"><div class="modal-content"> <div class="modal-header"> <h5 class="modal-title" id="exampleModalLabel">Eliminar os dados</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body">Tem certeza que pretende elimnar?</div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button> <a  class="btn btn-info" id="dataConfirmOk">Eliminar</a> </div></div></div></div>'
                    );
                }
                $('#dataConfirmOk').attr('href', href);
                $('#confirm-delete').modal({
                    shown: true
                });
                return false;

            });
            //end delete
        });

    </script>
    <!-- Footer-->
    @include('admin.layouts.footer')


@endsection

