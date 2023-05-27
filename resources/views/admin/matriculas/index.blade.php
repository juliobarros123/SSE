@extends('layouts.admin')

@section('titulo', 'Lista de Matriculados')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body row">
            <div class="col-md-10">
                <h3>Lista de Matriculados</h3>
            </div>


        </div>

    </div>



    <script src="{{ asset('/js/sweetalert2.all.min.js') }}"></script>
    @if (session('status'))
        <script>
            Swal.fire(
                'Aviso',
                'Aluno Matriculado com sucesso!',
                'success'
            )
        </script>
    @endif


    <div class="table-responsive">
        <table id="example" class="display table table-hover">
            <thead class="">
                <tr class="text-center">
                    <th>ID</th>
                    <th>FOTO</th>
                    <th>NOME</th>
                    <th>Nº PROCESSO</th>
                    <th>TURMA</th>
                    <th>CURSO</th>
                    <th>CLASSE</th>
                    <th>ANO LECTIVO</th>
                    <th>ACÇÕES</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @if ($matriculas)
                    @foreach ($matriculas as $matricula)
                        <tr class="text-center">
                            <th>{{ $matricula->id }}</th>
                            <th scope="row"><img src="{{ asset('/' . $matricula->vc_imagem) }}" width="40"></th>

                            <td>{{ $matricula->vc_primeiroNome . ' ' . $matricula->vc_nomedoMeio . ' ' . $matricula->vc_apelido }}
                            </td>
                            <td>{{ $matricula->processo }}</td>
                            <td>{{ $matricula->vc_nomedaTurma }}</td>
                            <td>{{ $matricula->vc_nomeCurso }}</td>
                            <td>{{ $matricula->vc_classe }}ª classe</td>
                            <th>{{ $matricula->ya_inicio }}/{{ $matricula->ya_fim }}</th>
                            @csrf
                            @method('delete')
                            <td>

                                @if (Auth::user()->vc_tipoUtilizador != 'Visitante')
                              
                                        <div class="dropdown">
                                            <button class="btn btn-dark btn-sm dropdown-toggle" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <i class="fa fa-clone fa-sm" aria-hidden="true"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="{{ route('admin.matriculas.ficha', $matricula->slug) }}"
                                                    target="_blank">Ficha</a>
                                                <a href="{{ route('admin.matriculas.editar', $matricula->slug) }}"
                                                    class="dropdown-item">Editar</a>
                                                @if (Auth::user()->vc_tipoUtilizador == 'Administrador' ||
                                                        Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
                                                        Auth::user()->vc_tipoUtilizador == 'Chefe de Departamento Pedagógico')
                                                    <a href="{{ route('admin.matriculas.excluir', $matricula->slug) }}"
                                                        class="dropdown-item"
                                                        data-confirm="Tem certeza que deseja eliminar?">Eliminar</a>
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
    </div>
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
    @if (session('eliminado'))
        <script>
            Swal.fire(
                'Aviso',
                'Matricula eliminada com sucesso!',
                'success'
            )
        </script>
    @endif
    @if (session('duplicidade_limpada'))
        <script>
            Swal.fire(
                'Duplicidade limpada com sucesso',
                '',
                'success'
            )
        </script>
    @endif
    @if (session('nenhuma_duplicidade'))
        <script>
            Swal.fire(
                'Nenhuma duplicidade encontrada!',
                '',
                'warning'
            )
        </script>
    @endif


    @if (session('matricula.eliminar.success'))
        <script>
            Swal.fire(
                'Matricula Eliminada Com Sucesso! ',
                '',
                'success'
            )
        </script>
    @endif
    @if (session('matricula.eliminar.error'))
        <script>
            Swal.fire(
                'Erro ao Eliminar Matricula! ',
                '',
                'error'
            )
        </script>
    @endif

    @if (session('matricula.purgar.success'))
        <script>
            Swal.fire(
                'Matricula Purgada Com Sucesso! ',
                '',
                'success'
            )
        </script>
    @endif
    @if (session('matricula.purgar.error'))
        <script>
            Swal.fire(
                'Erro ao Purgar Matricula! ',
                '',
                'error'
            )
        </script>
    @endif

    @if (session('matricula.recuperar.success'))
        <script>
            Swal.fire(
                'Matricula Recuperada Com Sucesso! ',
                '',
                'success'
            )
        </script>
    @endif
    @if (session('matricula.recuperar.error'))
        <script>
            Swal.fire(
                'Erro ao Recuperar Matricula! ',
                '',
                'error'
            )
        </script>
    @endif

    @include('admin.layouts.footer')


@endsection
