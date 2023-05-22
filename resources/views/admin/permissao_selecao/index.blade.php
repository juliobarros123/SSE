@extends('layouts.admin')

@section('titulo', 'Permissões')

@section('conteudo')

    <div class="card mt-3">
        <div class="card-body">
            <h3>Lista de permissões</h3>
        </div>
    </div>



    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if (Auth::user()->vc_tipoUtilizador == 'Administrador' || Auth::user()->vc_tipoUtilizador == 'Director Geral' || Auth::user()->vc_tipoUtilizador == 'Cordenação Pedagógica' || Auth::user()->vc_tipoUtilizador == 'Preparador')
        <div class="d-flex justify-content-end mb-3">
            <a class="btn btn-dark" href="{{ route('permissao_selecao.criar') }}">
                <strong class="text-light">Cadastrar Permissão</strong>
            </a>
        </div>
    @endif

    <table id="example" class="display table table-hover">
        <thead class="thead-dark text-center">
            <tr>

                <th>ID</th>
                <th>NOTA</th>
                <th>NASCIMENTO </th>
                <th>ACÇÕES</th>
            </tr>
        </thead>
        <tbody class="bg-white text-center">
            @foreach ($dados as $dado)
                <tr>

                    <td>{{ $dado->id }}</td>
                    <td>{{ $dado->nota }}</td>
                    <td>{{ $dado->dt_nascimento }}</td>
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
                                        data-target=".bd-example-modal-lg-{{ $dado->id }}">Expandir Dados</a>

                                    <a class="dropdown-item"
                                        href="{{ url('admin/permissao_selecao/edit/index', $dado->id) }}">@lang('Editar')
                                    </a>
                                    <a class="dropdown-item"
                                        href="{{ url('admin/permissao_selecao/destroy/index', $dado->id) }}">@lang('Eliminar')
                                    </a>



                                </div>
                            </div>
                        @endif

                    </td>
                </tr>


                <div class="modal fade bd-example-modal-lg-{{ $dado->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">ID do dado: <b>{{ $dado->id }}</b></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <h5 class="text-left mt-2 ml-2"><b>Dados do Processo de
                                        {{ $dado->nota }}</b>
                                </h5>
                                <p class="ml-4">
                                    <b>Permissões: </b>
                                    {{ $dado->nota }}<br>
                                    <b>Data de Criação: </b>
                                    {{ date('d-m-Y', strtotime($dado->created_at)) }}<br>
                                    <b>Data de Atualização: </b>
                                    {{ date('d-m-Y', strtotime($dado->updated_at)) }}
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
                'Permissão adicionada com sucesso',
                '',
                'success'
            )
        </script>
    @endif
    @if (session('update'))
        <script>
            Swal.fire(
                'Permissão editada com sucesso',
                '',
                'success'
            )
        </script>
    @endif
    @if (session('eliminar'))
        <script>
            Swal.fire(
                'Permissão eliminada com sucesso',
                '',
                'success'
            )
        </script>
    @endif


    <!-- Footer-->
    @include('admin.layouts.footer')
@endsection
