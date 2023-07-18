@extends('layouts.admin')
@section('titulo', 'Pautas Online')
@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Lista de Pautas Online</h3>
        </div>
    </div>



    <table id="example" class="display table table-hover">
        <thead class="">
            <tr class="text-center">
           
                <th>ESTADO</th>
                <th>ACÇÕES</th>
            </tr>
        </thead>
        <tbody class="bg-white text-center">
            @foreach ($cadeados as $cadeado)
                <tr>
                    <td>
                        {{ $cadeado->estado }}
                    </td>
                    <td>


                        <div class="dropdown">
                            <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-clone" aria-hidden="true"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">


                                @if ($cadeado->estado == 'Disponível')
                                    <a class="dropdown-item"
                                        href="{{ route('admin.pautas_online.mudar_estado', ['estado' => 'Indisponível']) }}">
                                        Indisponibilizar
                                    </a>
                                @else
                                    <a class="dropdown-item"
                                        href="{{ route('admin.pautas_online.mudar_estado', ['estado' => 'Disponível']) }}">
                                        Disponibilizar
                                    </a>
                                @endif

                            </div>
                        </div>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <script src="{{ asset('/js/datatables/jquery-3.5.1.js') }}"></script>
    <!-- sweetalert -->
    <script src="{{ asset('/js/sweetalert2.all.min.js') }}"></script>
    @if (session('status'))
        <script>
            Swal.fire(
                'Estado mudado com sucesso',
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
    @include('admin.layouts.footer')

@endsection
