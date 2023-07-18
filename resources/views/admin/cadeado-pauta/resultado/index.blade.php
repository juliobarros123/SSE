@extends('layouts.admin')

@section('titulo', 'Lista de cadeado de pautas')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Lista de cadeado de pautas(Resultado)</h3>
        </div>
    </div>


    <table id="example" class="display table table-hover table-bordered">
        <thead class="">
            <tr class="text-center">
                <th>ID</th>


                <th>ESTADO</th>

                <th>ACÇÕES</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            @if ($cadeados)
                @foreach ($cadeados as $cadeado)
                    <tr class="text-center">
                        <th>{{ $cadeado->id }}</th>



                        <td>
                            @if ($cadeado->it_estado_activacao)
                                <small>ACTIVADO</small>
                            @else
                                <small>DESACTIVADO</small>
                            @endif
                        </td>
                        <td>

                            @if (Auth::user()->vc_tipoUtilizador != 'Visitante')
                                <div class="dropdown">
                                    <button class="btn btn-dark btn-sm dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="fa fa-clone fa-sm" aria-hidden="true"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        @if ($cadeado->it_estado_activacao)
                                            <a href="{{ route('admin.cadeado-pautas.resultado.mudar_estado',['id'=>$cadeado->id,'estado'=>0])}}"
                                                class="dropdown-item">Desativar</a>
                                        @else
                                            <a href="{{ route('admin.cadeado-pautas.resultado.mudar_estado',['id'=>$cadeado->id,'estado'=>1]) }}"
                                                class="dropdown-item"
                                               >Activar</a>
                                        @endif


                                    </div>
                                </div>
                            @endif

                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    <script src="/js/datatables/jquery-3.5.1.js"></script>

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


    <script src="/js/sweetalert2.all.min.js"></script>
    @if (session('status'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Configuração realizada com sucesso',
            })
        </script>
    @endif
    @if (session('delete'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Configuração eliminada com sucesso',
            })
        </script>
    @endif
    @if (session('actualizado'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Configuração actualizada com sucesso',
            })
        </script>
    @endif


    <!-- Footer-->
    @include('admin.layouts.footer')


@endsection
