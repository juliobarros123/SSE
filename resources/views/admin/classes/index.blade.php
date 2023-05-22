@extends('layouts.admin')
@section('titulo', 'Classe/Listar')
@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Lista de classes</h3>
        </div>
    </div>




    @if (Auth::user()->vc_tipoUtilizador == 'Administrador' ||
            Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
            Auth::user()->vc_tipoUtilizador == 'Cordenação Pedagógica' ||
            Auth::user()->vc_tipoUtilizador == 'Preparador')
        <div class="d-flex justify-content-end mb-3">
            <a class="btn btn-dark" href="{{ url('/admin/classes/cadastrar') }}">
                <strong class="text-light">Cadastrar Classe</strong>
            </a>

            @if (Auth::user()->vc_tipoUtilizador == 'Administrador' ||
                    Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
                    Auth::user()->vc_tipoUtilizador == 'Cordenação Pedagógica' ||
                    Auth::user()->vc_tipoUtilizador == 'Preparador')
                <a class="btn btn-dark ml-1" href="{{ route('admin.classes.eliminadas') }}">
                    <strong class="text-light">Eliminadas</strong>
                </a>
            @endif
        </div>
    @endif
    <div class="responsive-table">
        <table id="example" class="display table table-hover">
               <thead class="">
                <tr class="text-center">
                    <th>ID</th>
                    <th>CLASSE</th>
                    <th>DATA DE CADASTRO</th>

                    <th>ACÇÕES</th>
                </tr>
            </thead>
            <tbody class="bg-white">

                @if (Auth::user()->vc_tipoUtilizador == 'Professor')

                    @foreach ($class as $classe)
                        <tr class="text-center">
                            <td>{{ $classe->id }}</td>
                            <td>{{ $classe->vc_classeTurma }}ªclasse</td>
                            <td>{{ date('d-m-Y', strtotime($classe->created_at)) }}</td>
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
                                                <a href="{{ route('admin.classes.recuperar', $classe->id) }}"
                                                    class="dropdown-item ">Recuperar</a>
                                                <a href="{{ route('admin.classes.purgar', $classe->id) }}"
                                                    class="dropdown-item "
                                                    data-confirm="Tem certeza que deseja eliminar?">Purgar</a>
                                            </div>
                                        </div>
                                    @else
                                        <div class="dropdown">
                                            <button class="btn btn-dark dropdown-toggle" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <i class="fa fa-clone" aria-hidden="true"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                                <a class="dropdown-item"
                                                    href="{{ route('admin/classes/editar', $classe->id) }}">Editar </a>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin/classes/visualizar', $classe->id) }}">Visualizar</a>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin/classes/eliminar', $classe->id) }}"
                                                    data-confirm="Tem certeza que deseja eliminar?">Eliminar </a>

                                                <a href="{{ route('admin.classes.purgar', $classe->id) }}"
                                                    class="dropdown-item "
                                                    data-confirm="Tem certeza que deseja eliminar?">Purgar</a>
                                            </div>
                                        </div>
                                    @endif
                                @endif

                            </td>
                        </tr>
                    @endforeach
                @else
                    @foreach ($classes as $classe)
                        <tr class="text-center">
                            <td>{{ $classe->id }}</td>
                            <td>{{ $classe->vc_classe }}ªclasse</td>
                            <td>{{ date('d-m-Y', strtotime($classe->created_at)) }}</td>
                            <td>
                                @if (isset($eliminadas))
                                        <div class="dropdown">
                                            <button class="btn btn-dark btn-sm dropdown-toggle" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <i class="fa fa-clone fa-sm" aria-hidden="true"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a href="{{ route('admin.classes.recuperar', $classe->id) }}"
                                                    class="dropdown-item ">Recuperar</a>
                                                <a href="{{ route('admin.classes.purgar', $classe->id) }}"
                                                    class="dropdown-item "
                                                    data-confirm="Tem certeza que deseja eliminar?">Purgar</a>
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
                                            href="{{ route('admin/classes/editar', $classe->id) }}">Editar </a>
                                        <a class="dropdown-item"
                                            href="{{ route('admin/classes/visualizar', $classe->id) }}">Visualizar</a>
                                        <a class="dropdown-item" href="{{ route('admin/classes/eliminar', $classe->id) }}"
                                            data-confirm="Tem certeza que deseja eliminar?">Eliminar </a>
                                            <a href="{{ route('admin.classes.purgar', $classe->id) }}"
                                                class="dropdown-item "
                                                data-confirm="Tem certeza que deseja eliminar?">Purgar</a>
                                    </div>
                                </div>
                            @endif
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
    <script src="{{ asset('/js/datatables/jquery-3.5.1.js') }}"></script>
    <!-- sweetalert -->
    <script src="{{ asset('/js/sweetalert2.all.min.js') }}"></script>

    @if (session('status'))
        <script>
            Swal.fire(
                'Classe adicionada ',
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


    @if (session('classe.eliminar.success'))
        <script>
            Swal.fire(
                'Classe Eliminada Com Sucesso! ',
                '',
                'success'
            )
        </script>
    @endif
    @if (session('classe.eliminar.error'))
        <script>
            Swal.fire(
                'Erro ao Eliminar Classe! ',
                '',
                'error'
            )
        </script>
    @endif

    @if (session('classe.purgar.success'))
        <script>
            Swal.fire(
                'Classe Purgada Com Sucesso! ',
                '',
                'success'
            )
        </script>
    @endif
    @if (session('classe.purgar.error'))
        <script>
            Swal.fire(
                'Erro ao Purgar Classe! ',
                '',
                'error'
            )
        </script>
    @endif

    @if (session('classe.recuperar.success'))
        <script>
            Swal.fire(
                'Classe Recuperada Com Sucesso! ',
                '',
                'success'
            )
        </script>
    @endif
    @if (session('classe.recuperar.error'))
        <script>
            Swal.fire(
                'Erro ao Recuperar Classe! ',
                '',
                'error'
            )
        </script>
    @endif
    <!-- Footer-->
    @include('admin.layouts.footer')

@endsection
