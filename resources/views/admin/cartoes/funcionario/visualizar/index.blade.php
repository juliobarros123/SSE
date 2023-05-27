@extends('layouts.admin')

@section('titulo', 'Funcionário/Listar')

 @section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Emissão de Cartão dos Funcionários</h3>
        </div>
    </div>




    @if (session('aviso'))
        <h5 class="text-center alert alert-danger">{{ session('aviso') }}</h5>
    @endif

    <table id="example" class="display table table-hover">
           <thead class="">
            <tr class="text-center">
                <th>ID</th>
                <th>FOTO</th>
                <th>NOME</th>
                <th>BILHETE DE IDENTIDADE</th>
                <th>FUNÇÃO</th>
                <th>DATA DE VALIDADE</th>
                <th>ACÇÕES</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            @foreach ($dados as $row)
                <tr class="text-center">
                    <td>{{ $row->id}}</td>
                    <td><img src="{{ asset('/'.$row->vc_foto) }}"
                            alt="{{ $row->vc_primeiroNome . ' ' . $row->vc_ultimoNome }}"
                            width="40"></td>
                    {{-- <img src="{{ asset('/'.$row->vc_foto) }}" id="myImg" alt="" width="50px" > --}}
                    <td>{{ $row->vc_primeiroNome . ' ' . $row->vc_ultimoNome }}</td>
                    <td>{{ $row->vc_bi }}</td>
                    <td>{{ $row->vc_funcao }}</td>
                    <td>{{ $row->ya_anoValidade }}</td>
                    <td>


                        @if (Auth::user()->vc_tipoUtilizador != 'Visitante')
                        <div class="dropdown">
                            <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-clone" aria-hidden="true"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item"
                                    href='{{ url("/admin/funcionario/gerar/cartao/$row->id") }}'
                                    target="_blank">Gerar Cartão
                                </a>
                                <a class="dropdown-item"
                                    href="{{ route('admin/funcionario/editar', $row->id) }}">Editar
                                </a>
                                <a class="dropdown-item"
                                    href="{{ route('admin/funcionario/eliminar', $row->id) }}" data-confirm="Tem certeza que deseja eliminar?">Eliminar
                                </a>

                            </div>
                        </div>

                        @endif


                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


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

    <!-- Footer-->


@endsection


