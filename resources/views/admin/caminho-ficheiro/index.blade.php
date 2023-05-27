@extends('layouts.admin')
@section('titulo', 'Lista de caminhos')
@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Lista de caminhos</h3>
        </div>
    </div>





    <table id="example" class="display table table-hover">
           <thead class="">
            <tr class="text-center">
                <th>ID</th>
                <th>CAMINHO</th>
                <th>ACÇÕES</th>
            </tr>
        </thead>
        <tbody class="bg-white">

    
                @foreach ($caminhos as $caminho)
                    <tr class="text-center">
                        <td>{{ $caminho->id }}</td>
                        <td>{{ $caminho->vc_caminho }}</td>
                       
                        <td>

                            @if (Auth::user()->vc_tipoUtilizador != 'Visitante')
                            <div class="dropdown">
                                <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-clone" aria-hidden="true"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                    <a class="dropdown-item"
                                        href="{{ route('caminho-files.editar', $caminho->id) }}">Editar </a>
                                    
                                    <a class="dropdown-item" href="{{ route('caminho-files.eliminar', $caminho->id) }}"
                                        data-confirm="Tem certeza que deseja eliminar?">Eliminar </a>
                                </div>
                            </div>

                            @endif

                        </td>
                    </tr>
                @endforeach
         
        </tbody>
    </table>
    <script src="{{asset('/js/datatables/jquery-3.5.1.js')}}"></script>
    <!-- sweetalert -->
    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>

    @if (session('cadastrada'))
        <script>
            Swal.fire(
                'Caminho cadastrado com sucesso ',
                '',
                'success'
            )

        </script>
    @endif

    @if (session('eliminado'))
    <script>
        Swal.fire(
            'Caminho eliminado com sucesso ',
            '',
            'success'
        )

    </script>
@endif
@if (session('editada'))
<script>
    Swal.fire(
        'Caminho editado com sucesso ',
        '',
        'success'
    )

</script>
@endif
    <script>
        $(document).ready(function() {

            //start delete
            $('a[data-confirm]').click(function(ev) {
                var href = $(this).attr('href');
                if (!$('#confirm-delete').length) {
                    $('table').append(
                        '<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog" role="document"><div class="modal-content"> <div class="modal-header"> <h5 class="modal-title" id="exampleModalLabel">Eliminar os dados</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body">Tem certeza que pretende eliminar?</div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button> <a  class="btn btn-info" id="dataConfirmOk">Eliminar</a> </div></div></div></div>'
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
