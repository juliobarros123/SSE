@extends('layouts.admin')

@section('titulo', 'Patrimônio/Ver')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Listar Patrimónios</h3>
        </div>
    </div>

    <table id="example" class="display table table-hover">
           <thead class="">
            <tr class="text-center">
                <th>ID</th>
                <th>NOME</th>
                <th>ESTADO</th>
                <th>QUANTIDADE</th>
                <th>Nº FACTURA</th>
                <th>UTILIDADE</th>
                <th>ACÇÕES</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            @foreach ($patrimonios as $patrimonios)
                <tr class="text-center">
                    <td>{{ $patrimonios->id}}</td>
                    <td>{{ $patrimonios->vc_nome }}</td>
                    <td>{{ $patrimonios->vc_estado }}</td>
                    <td>{{ $patrimonios->it_quantidade }}</td>
                    <td>{{ $patrimonios->it_numfactura }}</td>
                    <td>{{ $patrimonios->vc_utilidade }}</td>
                    <td>

                        @if (Auth::user()->vc_tipoUtilizador != 'Visitante')
                        <div class="dropdown">
                            <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-clone" aria-hidden="true"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item"
                                    href="{{ route('admin/patrimonios/visualizar', $patrimonios->id) }}" type="button"
                                    data-toggle="modal" data-backdrop="static"
                                    data-target=".bd-example-modal-lg-{{ $patrimonios->id }}">Expandir</a>
                                <a class="dropdown-item"
                                    href="{{ route('admin/patrimonios/editar', $patrimonios->id) }}">Editar
                                </a>
                                <a class="dropdown-item" href="{{ route('admin/patrimonios/eliminar', $patrimonios->id) }}"
                                    data-confirm="Tem certeza que deseja eliminar?">Abater
                                </a>

                            </div>
                        </div>

                        @endif

                    </td>
                </tr>
                <div class="modal fade bd-example-modal-lg-{{ $patrimonios->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><b>Dados de {{ $patrimonios->vc_nome }}</b></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="col-md-12">
                                    <div class="row">

                                        <div class="col-md-8">

                                            <b>Nome: </b>
                                            {{ $patrimonios->vc_nome }}<br>
                                            <b>Descrição: </b>
                                            {{ $patrimonios->vc_descricao }}<br>
                                            <b>Quantidade: </b>
                                            {{ $patrimonios->it_quantidade }}<br>
                                            <b>Estado: </b>
                                            {{ $patrimonios->vc_estado }}<br>
                                            <b>Valor do Patrimônio: </b>
                                            {{ $patrimonios->it_valor }},00 kz<br>
                                            <b>Nº da Factura: </b>
                                            {{ $patrimonios->it_numfactura }}<br>
                                            <b>Vida útil: </b>
                                            {{ $patrimonios->it_vidaUtil }} anos<br>
                                            <b>Em utilização: </b>
                                            {{ $patrimonios->vc_utilidade }}<br>
                                            <b>Marca: </b>
                                            {{ $patrimonios->vc_marca }}<br>
                                            <b>Modelo: </b>
                                            {{ $patrimonios->vc_modelo }}<br>
                                            <b>Localização: </b>
                                            {{ $patrimonios->vc_localizacao }}<br>

                                        </div>
                                        <div class="col-md-4">
                                            <img class="text-center" src="{{asset('/{{ $patrimonios->vc_foto }}" width="200">
                                        </div>
                                    </div>
                                </div>

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
    <!-- Footer-->
    @include('admin.layouts.footer')
    <script src="{{asset('/js/datatables/jquery-3.5.1.js')}}"></script>
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

@endsection
