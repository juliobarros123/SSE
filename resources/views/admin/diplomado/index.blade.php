@extends('layouts.admin')

@section('titulo', 'Lista de Diplomados')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Lista de Diplomados</h3>
        </div>
    </div>



    <!-- sweetalert -->
    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
    @if (session('status'))
        <script>
            Swal.fire(
                'Dados Actualizados com sucesso',
                '',
                'success'
            )
        </script>
    @endif

    @if (session('transferidos')==null || session('transferidos'))
    <script>
        Swal.fire(
            'Alunos transferidos com sucesso',
            '',
            'success'
        )
    </script>
@endif
    <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">BIs não encontrados</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="list-group">
                        @if (session('transferidos'))
                            @foreach (session('transferidos') as $item)
                                <li class="list-group-item">{{ $item }}</li>
                            @endforeach
                        @endif


                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>

                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-end py-4   1">

        @if (session('transferidos'))
            <a class="btn-sm btn-warning" href="{{ route('admin.diplomadoParaAluno') }}" data-toggle="modal"
                data-target="#exampleModal">BIs não encontrados</a>
        @endif


        <a class="btn-sm btn-primary" href="{{ route('admin.diplomadoParaAluno') }}">Transfirir para alunos</a>
    </div>
    <table id="example" class="display table table-hover">
           <thead class="">
            <tr class="text-center">
                <th>ID</th>
                <th>Processo</th>
                <th>NOME</th>
                <th>CURSO</th>
                <th>Data de Nascimento</th>
                <th>Estado</th>
                <th>ACÇÕES</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            @if ($diplomados)
                @foreach ($diplomados as $diplomado)
                    <tr class="text-center">
                        <th>{{ $diplomado->id }}</th>
                        <th>{{ $diplomado->it_id_aluno }}</th>
                        <th>{{ $diplomado->vc_primeiroNome . ' ' . $diplomado->vc_nomeMeio . ' ' . $diplomado->vc_ultimoNome }}
                        </th>
                        <td>{{ $diplomado->id_curso }}</td>
                        <td>{{ $diplomado->dt_dataNascimento }}</td>
                        <th>{{ $diplomado->it_estado == 1 ? 'Ativado' : 'Desativado' }}</th>
                        @csrf
                        <td>

                            @if (Auth::user()->vc_tipoUtilizador != 'Visitante')
                                <div class="dropdown">
                                    <button class="btn btn-dark btn-sm dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="fa fa-clone fa-sm" aria-hidden="true"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a href="{{ route('admin.diplomados.editar', $diplomado->id) }}"
                                            class="dropdown-item">Editar</a>

                                        @if (Auth::user()->vc_tipoUtilizador != 'Estagiario')
                                            <a href="{{ route('admin.diplomados.excluir', $diplomado->id) }}"
                                                class="dropdown-item"
                                                data-confirm="Tem certeza que deseja eliminar?">Eliminar</a>
                                            <a href="{{ route('admin.nota-diplomados.cadastrar', $diplomado->id) }}"
                                                class="dropdown-item">Enserir Nota</a>
                                            <a href="{{ route('admin.diplomados.visualizar', $diplomado->id) }}"
                                                class="dropdown-item">Vizualizar</a>
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
    <script src="{{asset('/js/datatables/jquery-3.5.1.js')}}"></script>

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
    <!-- Footer-->
    @include('admin.layouts.footer')


@endsection
