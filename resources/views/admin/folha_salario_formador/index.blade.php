@extends('layouts.admin')

@section('titulo', 'Folha de Salário dos Formadores')

 @section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Folha de Salário dos Formadores de {{$data['mes']}}/{{$data['ano']}}</h3>
        </div>
        <div class=" col-3">
                <a class="btn btn-dark" href="{{ route('ImprimirFolhaSalarioFormador',[$data['m1'],$data['ano']]) }}"> Gerar Pdf
                </a>
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
                        @csrf
                        @method('delete')
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

