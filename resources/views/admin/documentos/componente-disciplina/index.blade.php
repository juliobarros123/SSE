@extends('layouts.admin')

@section('titulo', 'Lista de componentes disciplinas')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Lista de componentes disciplinas</h3>
        </div>
    </div>

    @if (Auth::user()->vc_tipoUtilizador == 'Administrador' ||
            Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
            Auth::user()->vc_tipoUtilizador == 'Cordenação Pedagógica' ||
            Auth::user()->vc_tipoUtilizador == 'Preparador')
        <div class="d-flex justify-content-end mb-3">
            <a class="btn btn-dark" href="{{ route('admin.documentos.componentes-disciplinas.criar') }}">
                <strong class="text-light">Cadastrar componente</strong>
            </a>
        </div>
    @endif
    <table id="example" class="display table table-hover">
           <thead class="">
            <tr class="text-center">
                <th>ID</th>
                <th>CURSO</th>
                <th>CLASSE</th>
\
                <th>COMPONENTE</th>
                <th>DISCIPLINA</th>
                <th>AÇÕES</th>
            </tr>
        </thead>
        <tbody class="bg-white">

            @foreach ($componente_disciplinas as $componente)
                <tr class="text-center">
                    <td>{{ $componente->id }}</td>
                    <th>{{ $componente->vc_nomeCurso }}</th>
                    <th>{{ $componente->vc_classe }}.ª Classe</th>

                    <th>{{ $componente->vc_componente }}</th>
                    <th>{{ $componente->vc_nome }}</th>

                    <td>
                        @if (Auth::user()->vc_tipoUtilizador != 'Visitante')
                            <div class="dropdown">
                                <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-clone" aria-hidden="true"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    @if (Auth::user()->vc_tipoUtilizador != 'Professor')
                                        <a href="{{ route('admin.documentos.componentes-disciplinas.editar', $componente->slug) }}"
                                            class="dropdown-item">Editar</a>
                                        <a href="{{ route('admin.documentos.componentes-disciplinas.eliminar', ['slug' => $componente->slug]) }}"
                                            class="dropdown-item"
                                            data-confirm="Tem certeza que deseja eliminar?">Eliminar</a>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>


    <script src="{{ asset('/js/datatables/jquery-3.5.1.js') }}"></script>
    <!-- sweetalert -->
    <script src="{{ asset('/js/sweetalert2.all.min.js') }}"></script>

    @if (session('cadastrado'))
        <script>
            Swal.fire(
                'Dados cadastrado com sucesso',
                '',
                'success'
            )
        </script>
    @endif
    @if (session('actualizado'))
        <script>
            Swal.fire(
                'Dados actualizado com sucesso',
                '',
                'success'
            )
        </script>
    @endif
    @if (session('existe'))
        <script>
            Swal.fire(
                'Dados já existem',
                '',
                'error'
            )
        </script>
    @endif


    @if (session('eliminado'))
        <script>
            Swal.fire(
                'Dados eliminado com sucesso',
                '',
                'success'
            )
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire(
                'Houve algum  erro',
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
                        '<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog" role="document"><div class="modal-content"> <div class="modal-header"> <h5 class="modal-title" id="exampleModalLabel">Eliminar os dados</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body">Tem certeza que pretende elimInar?</div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button> <a  class="btn btn-info" id="dataConfirmOk">Eliminar</a> </div></div></div></div>'
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
