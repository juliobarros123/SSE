@extends('layouts.admin')

@section('titulo', 'Lista Notas/Recurso')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Lista notas/Recurso</h3>
        </div>
    </div>

    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>

    @if (session('eliminado'))
        <script>
            Swal.fire(
                'Nota eliminada com sucesso',
                '',
                'success'
            )
        </script>
    @endif

   
    <div class="d-flex justify-content-end mb-3">
        <a class="btn btn-dark" href=" {{ route('admin.notas-recurso.inserir') }}">
            <strong class="text-light">Inserir Notas</strong>
        </a>
    </div>

    <table id="example" class="display table table-hover">
           <thead class="">
            <tr class="text-center">
                <th>ID</th>
                <th>ALUNO</th>
                <th>NOTA</th>
                <th>DISCIPLINA</th>
                <th>ACÇÕES</th>
            </tr>
        </thead>

        <tbody class="bg-white">
            @if ($notas)
                @foreach ($notas as $nota)
                    <tr class="text-center">
                        <th>{{$nota->id_n}}</th>

                        <td>{{ $nota->vc_primeiroNome." ".$nota->vc_nomedoMeio." ".$nota->vc_ultimoaNome }}</td>
                        <td>{{ $nota->nota }}</td>
                        <td>{{ $nota->vc_acronimo }}</td>
                        @csrf
                        @method('delete')
                        <td>

                            @if (Auth::user()->vc_tipoUtilizador != 'Visitante')
                            <div class="dropdown">
                                <button class="btn btn-dark btn-sm dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-clone fa-sm" aria-hidden="true"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    {{-- <a href="{{ route('admin.matriculas.editar', $matricula->id) }}"
                                        class="dropdown-item">Editar</a> --}}
                                        @if (Auth::user()->vc_tipoUtilizador == 'Administrador' || Auth::user()->vc_tipoUtilizador == 'Director Geral')
                                    <a href="{{ route('admin.notas-recurso.eliminar', $nota->id_n) }}"
                                        class="dropdown-item" data-confirm="Tem certeza que deseja eliminar?">Eliminar</a>

                                        {{-- <a href="{{ route('admin.matriculas.purgar', $matricula->id) }}"
                                            class="dropdown-item" data-confirm="Tem certeza que deseja eliminar?">Purgar</a> --}}
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
