@extends('layouts.admin')

@section('titulo', 'Processo/Listar')

@section('conteudo')

    <div class="card mt-3">
        <div class="card-body">
            <h3>Lista de processo</h3>
        </div>
    </div>



    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    @if (Auth::user()->vc_tipoUtilizador != 'Visitante')
        <div class="d-flex justify-content-end mb-3">
            <a class="btn btn-dark" href="{{ url('Admin/processos/create/index') }}">
                <strong class="text-light">Cadastrar Processo</strong>
            </a>
        </div>
    @endif

    <table id="example" class="display table table-hover">
        <thead class="thead-dark text-center">
            <tr>

                <th>ID</th>
                <th>Processo</th>
                <th>ESTADO </th>
                <th>ACÇÕES</th>
            </tr>
        </thead>
        <tbody class="bg-white text-center">
            @foreach ($processos as $processo)
                <tr>

                    <td>{{ $processo->id }}</td>
                    <td>{{ $processo->it_processo }}</td>
                    <td>
                        @if ($processo->it_estado_processo == 1)
                            <b class="text-primary">ACTIVADO</b>
                        @else
                            <b class="text-danger">DESACTIVADO</b>
                        @endif
                    </td>
                    <td>





                        @if (Auth::user()->vc_tipoUtilizador != 'Visitante')
                            <div class="dropdown">
                                <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-clone" aria-hidden="true"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#" type="button" data-toggle="modal"
                                        data-backdrop="static"
                                        data-target=".bd-example-modal-lg-{{ $processo->id }}">Expandir Dados</a>

                                    <a class="dropdown-item"
                                        href="{{ url('Admin/processos/edit/index', $processo->id) }}">@lang('Editar')
                                    </a>
                                    <a class="dropdown-item"
                                        href="{{ url('Admin/processos/destroy/index', $processo->id) }}">@lang('Eliminar')
                                    </a>



                                </div>
                            </div>
                        @endif

                    </td>
                </tr>


                <div class="modal fade bd-example-modal-lg-{{ $processo->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">ID do processo: <b>{{ $processo->id }}</b></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <h5 class="text-left mt-2 ml-2"><b>Dados do Processo de
                                        {{ $processo->it_processo }}</b>
                                </h5>
                                <p class="ml-4">
                                    <b>Processo: </b>
                                    {{ $processo->it_processo }}<br>
                                    <b>Data de Criação: </b>
                                    {{ date('d-m-Y', strtotime($processo->created_at)) }}<br>
                                    <b>Data de Atualização: </b>
                                    {{ date('d-m-Y', strtotime($processo->updated_at)) }}
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

    @if (session('processoCadastrado'))
        <script>
            Swal.fire(
                'Dados de Processo adicionado com sucesso',
                '',
                'success'
            )
        </script>
    @endif
    @if (session('processoUP'))
        <script>
            Swal.fire(
                'Dados de Processo actualizados com sucesso ',
                '',
                'success'
            )
        </script>
    @endif
    @if (session('processoEliminado'))
        <script>
            Swal.fire(
                'Dados de Processo eliminados com sucesso ',
                '',
                'success'
            )
        </script>
    @endif




    <!-- Footer-->
    @include('admin.layouts.footer')
@endsection
