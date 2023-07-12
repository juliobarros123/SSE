@extends('layouts.admin')
@section('titulo', 'Provincia/Listar')
@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Lista de Províncias</h3>
        </div>
    </div>


    @if (Auth::user()->vc_tipoUtilizador != 'Visitante')
        <div class="d-flex justify-content-end mb-3">
            <a class="btn btn-dark" href="{{ route('admin.provincia.cadastrar') }}">
                <strong class="text-light">Cadastrar Provincia</strong>
            </a>

            @if (Auth::user()->vc_tipoUtilizador == 'Administrador' ||
            Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
            Auth::user()->vc_tipoUtilizador == 'Coordenação Pedagógica' ||
            Auth::user()->vc_tipoUtilizador == 'Preparador')
           
    
                
    
        @endif
        </div>
    @endif

  <div class="table-responsive">
    <table id="example" class="display table table-hover">
           <thead class="">
            <tr class="text-center">
                <th>ID</th>
                <th>NOME</th>
                <th>ACÇÕES</th>
            </tr>
        </thead>
        <tbody class="bg-white text-center">
            @foreach ($provincias as $provincia)
                <tr>

                    <td>{{ $provincia->id }}</td>
                    <td>{{ $provincia->vc_nome }}</td>


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
                                <a href="{{ route('admin.provincia.recuperar', $provincia->id) }}"
                                    class="dropdown-item ">Recuperar</a>
                                <a href="{{ route('admin.provincia.purgar', $provincia->id) }}"
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
                                        href="{{ route('admin.provincia.editar', $provincia->id) }}">Editar </a>
                                    <a class="dropdown-item"
                                        href="{{ route('admin.provincia.visualizar', $provincia->id) }}">Visualizar</a>


                                    <a class="dropdown-item" href="{{ route('admin.provincia.eliminar', $provincia->id) }}"
                                        data-confirm="Tem certeza que deseja eliminar?">Eliminar </a>

                                      
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
    @if (session('provincia.cadastrar.success'))
        <script>
            Swal.fire(
                'Provincia Cadastrada Com Sucesso! ',
                '',
                'success'
            )
        </script>
    @endif

    @if (session('provincia.actualizar.success'))
    <script>
        Swal.fire(
            'Provincia Actualizada Com Sucesso! ',
            '',
            'success'
        )
    </script>
@endif

@if (session('provincia.eliminar.success'))
<script>
    Swal.fire(
        'Provincia Eliminada Com Sucesso! ',
        '',
        'success'
    )
</script>
@endif
@if (session('provincia.eliminar.error'))
<script>
    Swal.fire(
        'Erro ao Eliminar Província! ',
        '',
        'error'
    )
</script>
@endif


@if (session('provincia.purgar.success'))
<script>
    Swal.fire(
        'Provincia Purgada Com Sucesso! ',
        '',
        'success'
    )
</script>
@endif
@if (session('provincia.purgar.error'))
<script>
    Swal.fire(
        'Erro ao Purgar Província! ',
        '',
        'error'
    )
</script>
@endif

@if (session('provincia.recuperar.success'))
<script>
    Swal.fire(
        'Provincia Recuperada Com Sucesso! ',
        '',
        'success'
    )
</script>
@endif
@if (session('provincia.recuperar.error'))
<script>
    Swal.fire(
        'Erro ao Recuperar Província! ',
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
