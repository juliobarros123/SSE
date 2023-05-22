@extends('layouts.admin')
@section('titulo', 'Municipio/Listar')
@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Lista de Municipio</h3>
        </div>
    </div>


    @if (Auth::user()->vc_tipoUtilizador != 'Visitante')
        <div class="d-flex justify-content-end mb-3">
            <a class="btn btn-dark" href="{{ route('admin.municipio.cadastrar') }}">
                <strong class="text-light">Cadastrar Municipio</strong>
            </a>

            @if (Auth::user()->vc_tipoUtilizador == 'Administrador' ||
            Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
            Auth::user()->vc_tipoUtilizador == 'Cordenação Pedagógica' ||
            Auth::user()->vc_tipoUtilizador == 'Preparador')
           
    
                <a class="btn btn-dark ml-1" href="{{route('admin.municipio.eliminadas')}}">
                    <strong class="text-light">Eliminados</strong>
                </a>
    
        @endif
        </div>
    @endif

  <div class="table-responsive">
    <table id="example" class="display table table-hover">
           <thead class="">
            <tr class="text-center">
                <th>ID</th>
                <th>NOME</th>
                <th>PROVÍNCIA</th>
                <th>ACÇÕES</th>
            </tr>
        </thead>
        <tbody class="bg-white text-center">
            @foreach ($municipios as $municipio)
                <tr>

                    <td>{{ $municipio->id }}</td>
                    <td>{{ $municipio->vc_nome }}</td>
                    <td>{{ $municipio->vc_nomeProvincia }}</td>


                    <td>


                        @if (Auth::user()->vc_tipoUtilizador != 'Visitante')

                        @if (isset($eliminadas))
                        <div class="dropdown">
                            <button class="btn btn-dark btn-sm dropdown-toggle" type="button"
                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="fa fa-clone fa-sm" aria-hidden="true"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a href="{{ route('admin.municipio.recuperar', $municipio->id) }}"
                                    class="dropdown-item ">Recuperar</a>
                                <a href="{{ route('admin.municipio.purgar', $municipio->id) }}"
                                    class="dropdown-item " data-confirm="Tem certeza que deseja eliminar?">Purgar</a>
                            </div>
                        </div>
                         @else
                            <div class="dropdown">
                                <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-clone" aria-hidden="true"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                    <a class="dropdown-item"
                                        href="{{ route('admin.municipio.editar', $municipio->id) }}">Editar </a>
                                    <a class="dropdown-item"
                                        href="{{ route('admin.municipio.visualizar', $municipio->id) }}">Visualizar</a>


                                    <a class="dropdown-item" href="{{ route('admin.municipio.eliminar', $municipio->id) }}"
                                        data-confirm="Tem certeza que deseja eliminar?">Eliminar </a>

                                        <a href="{{ route('admin.municipio.purgar', $municipio->id) }}"
                                            class="dropdown-item " data-confirm="Tem certeza que deseja eliminar?">Purgar</a>
                                </div>
                            </div>
                        @endif
                        @endif

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
  </div>
    <script src="{{ asset('/js/datatables/jquery-3.5.1.js') }}"></script>
    <!-- sweetalert -->
    <script src="{{ asset('/js/sweetalert2.all.min.js') }}"></script>
    @if (session('municipio.cadastrar.success'))
        <script>
            Swal.fire(
                'Municipio Cadastrado Com Sucesso! ',
                '',
                'success'
            )
        </script>
    @endif

    @if (session('municipio.actualizar.success'))
    <script>
        Swal.fire(
            'Municipio Actualizado Com Sucesso! ',
            '',
            'success'
        )
    </script>
@endif

@if (session('municipio.eliminar.success'))
<script>
    Swal.fire(
        'Municipio Eliminado Com Sucesso! ',
        '',
        'success'
    )
</script>
@endif
@if (session('municipio.eliminar.error'))
<script>
    Swal.fire(
        'Erro ao Eliminar Municipio! ',
        '',
        'error'
    )
</script>
@endif


@if (session('municipio.purgar.success'))
<script>
    Swal.fire(
        'Municipio Purgado Com Sucesso! ',
        '',
        'success'
    )
</script>
@endif
@if (session('municipio.purgar.error'))
<script>
    Swal.fire(
        'Erro ao Purgar Municipio! ',
        '',
        'error'
    )
</script>
@endif

@if (session('municipio.recuperar.success'))
<script>
    Swal.fire(
        'Municipio Recuperado Com Sucesso! ',
        '',
        'success'
    )
</script>
@endif
@if (session('municipio.recuperar.error'))
<script>
    Swal.fire(
        'Erro ao Recuperar Municipio! ',
        '',
        'error'
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
    @include('admin.layouts.footer')

@endsection
