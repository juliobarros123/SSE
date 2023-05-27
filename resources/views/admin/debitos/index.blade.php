@extends('layouts.admin')

@section('titulo', 'Lista de Saídas')

 @section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Lista de Saídas</h3>
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
                <th>DESTINO</th>
                <th>MÊS</th>
                <th>ANO</th>
                <th>VALOR DE SAÍDA</th>
                <th>ACÇÕES</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            @if ($debitos)
                @foreach ($debitos as $debito)
                    <tr class="text-center">
                        <td>{{$debito->id}}</td>
                        <td>{{$debito->vc_debito }}</td>
                        <td>{{$debito->vc_nome }}</td>
                        <td>{{$debito->ya_ano }}</td>
                        <td>{{$debito->dc_valor }}</td>
                        @csrf
                        @method('delete')
                        <td>

                            @if (Auth::user()->vc_tipoUtilizador != 'Visitante')
                            <div class="dropdown">
                                <button class="btn btn-dark btn-sm dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-clone fa-sm" aria-hidden="true"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a href="{{ route('verEditarDebito', $debito->id) }}"
                                        class="dropdown-item">Editar</a>
                                    <a href="{{ route('eliminarDebito', $debito->id) }}" class="dropdown-item"
                                    data-confirm="Tem certeza que deseja eliminar?">Eliminar</a>
                                </div>
                            </div>

                            @endif

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
                        '<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog" role="document"><div class="modal-content"> <div class="modal-header"> <h5 class="modal-title" id="exampleModalLabel">Eliminar os debitos</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body">Tem certeza que pretende eliminar?</div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button> <a  class="btn btn-info" id="dataConfirmOk">Eliminar</a> </div></div></div></div>'
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

