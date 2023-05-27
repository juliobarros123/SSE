@extends('layouts.admin')

@section('titulo', 'Lista de Entradas')

 @section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Lista de Entradas</h3>
        </div>
    </div>



  <!-- sweetalert -->
  <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
  @if (session('status'))
      <script>
          Swal.fire(
              'creditos Actualizados com sucesso',
              '',
              'success'
          )

      </script>
  @endif
    <table id="example" class="display table table-hover">
        <thead class="sidebar-dark-primary  text-white">
            <tr class="text-center">
                <th>ID</th>
                <th>FONTE</th>
                <th>MÊS</th>
                <th>ANO</th>
                <th>VALOR DE ENTRADA</th>
                <th>ACÇÕES</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            @if ($creditos)
                @foreach ($creditos as $credito)
                    <tr class="text-center">
                        <td>{{$credito->id}}</td>
                        <td>{{$credito->vc_credito }}</td>
                        <td>{{$credito->vc_nome }}</td>
                        <td>{{$credito->ya_ano }}</td>
                        <td>{{$credito->dc_valor }}</td>
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
                                    <a href="{{ route('verEditarDebito', $credito->id) }}"
                                        class="dropdown-item">Editar</a>
                                    <a href="{{ route('eliminarDebito', $credito->id) }}" class="dropdown-item"
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
                        '<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog" role="document"><div class="modal-content"> <div class="modal-header"> <h5 class="modal-title" id="exampleModalLabel">Eliminar os creditos</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body">Tem certeza que pretende eliminar?</div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button> <a  class="btn btn-info" id="dataConfirmOk">Eliminar</a> </div></div></div></div>'
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

