@extends('layouts.admin')

@section('titulo', 'Lista de Fundos de Cartões')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Lista de Fundos de Cartões</h3>
        </div>
    </div>

    @if (Auth::user()->vc_tipoUtilizador == 'Administrador' ||
            Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
            Auth::user()->vc_tipoUtilizador == 'Coordenação Pedagógica' ||
            Auth::user()->vc_tipoUtilizador == 'Preparador')
        <div class="d-flex justify-content-end mb-3">
            <a class="btn btn-dark" href="{{ route('admin.fundos_cartoes.criar') }}">
                <strong class="text-light">Cadastrar</strong>
            </a>
        </div>
    @endif

    <table id="example" class="display table table-hover">
        <thead class="">
            <tr class="text-center">
                <th>ID</th>
                <th>ENTIDADE</th>
                <th>FUNDO</th>
                <th>ACÇÕES</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            @if ($fundos_cartoes)
                @foreach ($fundos_cartoes as $fundo)
                    {{-- @dump($fundo) --}}
                    <tr class="text-center">
                        <th>{{ $fundo->id }}</th>
                        <th>{{ $fundo->entidade }}</th>
                        <td> <img src="{{ asset('/' . $fundo->fundo) }}" id="myImg" alt=""
                            width="20px">
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
                                        <a href="{{ route('admin.fundos_cartoes.editar', $fundo->slug) }}"
                                            class="dropdown-item">Editar</a>
                                        <a href="{{ route('admin.fundos_cartoes.eliminar', $fundo->slug) }}"
                                            class="dropdown-item"
                                            data-confirm="Tem certeza que deseja eliminar?">Eliminar</a>
                                    </div>
                                </div>
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
    <!-- Footer-->
    @include('admin.layouts.footer')


@endsection