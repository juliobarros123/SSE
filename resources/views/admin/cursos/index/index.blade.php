@extends('layouts.admin')

@section('titulo', 'Curso/Listar')

@section('conteudo')

    <div class="card mt-3">
        <div class="card-body">
            <h3>Lista de curso</h3>
        </div>
    </div>



    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if (Auth::user()->vc_tipoUtilizador != 'Visitante')
        <div class="d-flex justify-content-end mb-3">
            <a class="btn btn-dark" href="{{ url('Admin/cursos/create/index') }}">
                <strong class="text-light">Cadastrar Curso</strong>
            </a>
            @if (Auth::user()->vc_tipoUtilizador == 'Administrador' ||
            Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
            Auth::user()->vc_tipoUtilizador == 'Cordenação Pedagógica' ||
            Auth::user()->vc_tipoUtilizador == 'Preparador')
           
    
                <a class="btn btn-dark ml-1" href="{{route('admin.cursos.eliminadas')}}">
                    <strong class="text-light">Eliminados</strong>
                </a>
    
        @endif
        </div>
    @endif
    <table id="example" class="display table table-hover">
        <thead class="thead-dark text-center">
            <tr>

                <th>ID</th>
                <th>CURSO</th>
                <th>FORMA CURTA</th>
                <th>DESCRIÇÃO</th>
                <th>ESTADO</th>
                <th>ACÇÕES</th>
            </tr>
        </thead>
        <tbody class="bg-white text-center">
            @foreach ($cursos as $curso)
                <tr>

                    <td>{{ $curso->id }}</td>
                    <td>{{ $curso->vc_nomeCurso }}</td>
                    <td>{{ $curso->vc_shortName }}</td>
                    <td>{{ $curso->vc_descricaodoCurso }}</td>
                    <td>
                        @if ($curso->it_estadodoCurso == 1)
                            <b class="text-primary">ACTIVADO</b>
                        @else
                            <b class="text-danger">DESACTIVADO</b>
                        @endif
                    </td>
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
                                    <a href="{{ route('admin.cursos.recuperar', $curso->id) }}"
                                        class="dropdown-item ">Recuperar</a>
                                    <a href="{{ route('admin.cursos.purgar', $curso->id) }}"
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
                                    <a class="dropdown-item" href="#" type="button" data-toggle="modal"
                                        data-backdrop="static"
                                        data-target=".bd-example-modal-lg-{{ $curso->id }}">Expandir Dados</a>

                                    <a class="dropdown-item"
                                        href="{{ url('Admin/cursos/edit/index', $curso->id) }}">@lang('Editar')
                                    </a>
                                    <a class="dropdown-item"
                                        href="{{ route('cursos.destroy', $curso->id) }}">@lang('Eliminar')
                                    </a>
                                    <a href="{{ route('admin.cursos.purgar', $curso->id) }}"
                                        class="dropdown-item " data-confirm="Tem certeza que deseja eliminar?">Purgar</a>



                                </div>
                            </div>
                        @endif
                        @endif

                    </td>
                </tr>


                <div class="modal fade bd-example-modal-lg-{{ $curso->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">ID do curso: <b>{{ $curso->id }}</b></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <h5 class="text-left mt-2 ml-2"><b>Dados do Curso de {{ $curso->vc_nomeCurso }}</b></h5>
                                <p class="ml-4">
                                    <b>Curso: </b>
                                    {{ $curso->vc_nomeCurso }}<br>
                                    <b>Descrição: </b>
                                    {{ $curso->vc_descricaodoCurso }}<br>
                                    <b>Data de Criação: </b>
                                    {{ date('d-m-Y', strtotime($curso->created_at)) }}<br>
                                    <b>Data de Atualização: </b>
                                    {{ date('d-m-Y', strtotime($curso->updated_at)) }}
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach


        </tbody>

    </table>
    <script src="{{ asset('/js/datatables/jquery-3.5.1.js') }}"></script>
    <!-- sweetalert -->
    <script src="{{ asset('/js/sweetalert2.all.min.js') }}"></script>

    @if (session('status'))
        <script>
            Swal.fire(
                'Dados de Curso adicionado ',
                '',
                'success'
            )
        </script>
    @endif




@if (session('curso.eliminar.success'))
<script>
    Swal.fire(
        'Curso Eliminado Com Sucesso! ',
        '',
        'success'
    )
</script>
@endif
@if (session('curso.eliminar.error'))
<script>
    Swal.fire(
        'Erro ao Eliminar Curso! ',
        '',
        'error'
    )
</script>
@endif

@if (session('curso.purgar.success'))
<script>
    Swal.fire(
        'Curso Purgado Com Sucesso! ',
        '',
        'success'
    )
</script>
@endif
@if (session('curso.purgar.error'))
<script>
    Swal.fire(
        'Erro ao Purgar Curso! ',
        '',
        'error'
    )
</script>
@endif

@if (session('curso.recuperar.success'))
<script>
    Swal.fire(
        'Curso Recuperado Com Sucesso! ',
        '',
        'success'
    )
</script>
@endif
@if (session('curso.recuperar.error'))
<script>
    Swal.fire(
        'Erro ao Recuperar Curso! ',
        '',
        'error'
    )
</script>
@endif


    <!-- Footer-->
    @include('admin.layouts.footer')
@endsection
