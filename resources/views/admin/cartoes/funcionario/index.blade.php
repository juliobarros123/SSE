@extends('layouts.admin')

@section('titulo', 'Lista de funcionarios')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Lista de Funcionarios</h3>
        </div>
    </div>



    <!-- sweetalert -->
    <script src="{{ asset('/js/sweetalert2.all.min.js') }}"></script>
    @if (session('status'))
        <script>
            Swal.fire(
                'Dados Actualizados com sucesso',
                '',
                'success'
            )
        </script>
    @endif
    @if (Auth::user()->vc_tipoUtilizador != 'Visitante')
        <div class="d-flex justify-content-end mb-3">
            <a class="btn btn-dark" href="{{ url('/admin/funcionario/cadastrar') }}">
                <strong class="text-light">Cadastrar Funcionário</strong>
            </a>

            @if (Auth::user()->vc_tipoUtilizador == 'Administrador' ||
            Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
            Auth::user()->vc_tipoUtilizador == 'Cordenação Pedagógica' ||
            Auth::user()->vc_tipoUtilizador == 'Preparador')
           
    
                <a class="btn btn-dark ml-1" href="{{route('admin.funcionario.eliminadas')}}">
                    <strong class="text-light">Eliminados</strong>
                </a>
    
        @endif
        </div>
    @endif


    <table id="example" class="display table table-hover">
        <thead class="">
            <tr class="text-center">
                <th>ID</th>
                <th>FOTOGRAFIA</th>
                <th>NOME</th>
                <th>BI</th>
                <th>FUNÇÃO</th>
                <th>ANO DE VALIDADE</th>
                <th>Data de Nascimento</th>
                <th>ACÇÕES</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            @if ($funcionarios)
                @foreach ($funcionarios as $funcionario)
                    <tr class="text-center">
                        <th>{{ $funcionario->id }}</th>
                        <th>
                            {{-- <img src="{{asset('/{{$funcionario->vc_foto}}" id="myImg" alt="" width="50px" > --}}
                            <img src="{{ asset('/' . $funcionario->vc_foto) }}" id="myImg" alt=""
                                width="50px">

                        </th>
                        <th>{{ $funcionario->vc_primeiroNome . ' ' . $funcionario->vc_ultimoNome }}</th>
                        <th>{{ $funcionario->vc_bi }}</th>
                        <td>{{ $funcionario->vc_funcao }}</td>
                        <td>{{ $funcionario->ya_anoValidade }}</td>
                        <td>{{ $funcionario->dt_nascimento }}</td>
                        @csrf
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
                                    <a href="{{ route('admin.funcionario.recuperar', $funcionario->id) }}"
                                        class="dropdown-item ">Recuperar</a>
                                    <a href="{{ route('admin.funcionario.purgar', $funcionario->id) }}"
                                        class="dropdown-item " data-confirm="Tem certeza que deseja eliminar?">Purgar</a>
                                </div>
                            </div>
                             @else
                                <div class="dropdown">
                                    <button class="btn btn-dark btn-sm dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="fa fa-clone fa-sm" aria-hidden="true"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a href="{{ route('admin/funcionario/editar', $funcionario->id) }}"
                                            class="dropdown-item">Editar</a>

                                        <a data-confirm="Tem certeza que deseja eliminar?"
                                            href="{{ route('admin/funcionario/eliminar', $funcionario->id) }}"
                                            class="dropdown-item">Eliminar</a>

                                            <a href="{{ route('admin.funcionario.purgar', $funcionario->id) }}"
                                                class="dropdown-item " data-confirm="Tem certeza que deseja eliminar?">Purgar</a>
                                    </div>
                                </div>
                            @endif
                            @endif

                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    <script src="{{ asset('/js/datatables/jquery-3.5.1.js') }}"></script>

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


    @if (session('funcionario.eliminar.success'))
    <script>
        Swal.fire(
            'Funcionário Eliminado Com Sucesso! ',
            '',
            'success'
        )
    </script>
    @endif
    @if (session('funcionario.eliminar.error'))
    <script>
        Swal.fire(
            'Erro ao Eliminar Funcionário! ',
            '',
            'error'
        )
    </script>
    @endif
    
    @if (session('funcionario.purgar.success'))
    <script>
        Swal.fire(
            'Funcionário Purgado Com Sucesso! ',
            '',
            'success'
        )
    </script>
    @endif
    @if (session('funcionario.purgar.error'))
    <script>
        Swal.fire(
            'Erro ao Purgar Funcionário! ',
            '',
            'error'
        )
    </script>
    @endif
    
    @if (session('funcionario.recuperar.success'))
    <script>
        Swal.fire(
            'Funcionário Recuperado Com Sucesso! ',
            '',
            'success'
        )
    </script>
    @endif
    @if (session('funcionario.recuperar.error'))
    <script>
        Swal.fire(
            'Erro ao Recuperar Funcionário! ',
            '',
            'error'
        )
    </script>
    @endif

@endsection
