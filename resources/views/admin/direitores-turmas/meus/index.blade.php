@extends('layouts.admin')

@section('titulo', 'Meus Directores de turmas')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Meus Directores de turmas</h3>
        </div>
    </div>




    <div class="table-responsive">
        <table id="example" class="display table table-hover">
            <thead class="">
                <tr class="text-center">
                    <th>ID</th>
                    <th>PROFESSOR</th>
                    <th>TURMA</th>
                    <th>TURNO</th>
                    <th>CURSO</th>
                    <th>CLASSE</th>
                    <th>AÇÕES</th>

                </tr>
            </thead>
            <tbody class="bg-white">
                @if ($directores)
                    @foreach ($directores as $dt)
                        <tr class="text-center">
                            <th>{{ $dt->id }}</th>
                            <th>{{ $dt->director }}</th>
                            <td>{{ $dt->turma }}</td>
                            <td>{{ $dt->turno }}</td>

                            <td>{{ $dt->curso }}</td>
                            <td>{{ $dt->classe }}ª classe</td>
                            <td>

                                <div class="dropdown">
                                    <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-clone" aria-hidden="true"></i>
                                    </button>


                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                        <a href="{{ route('turmas.imprimir_alunos', $dt->slug_turma) }}"
                                            class="dropdown-item" target="_blank">Lista</a>
                                        @if (Auth::User()->id == $dt->id_director)
                                            <a href="{{ route('admin.atribuicao.professores', $dt->slug_turma) }}"
                                                class="dropdown-item" target="_blank">Professores</a>
                                            <a href="" class="dropdown-item" data-toggle="modal"
                                                data-target=".bd-example-modal-sm{{ $dt->id }}">Pauta Trimestral</a>
                                            <a href="{{ route('admin.pautaFinal.gerar', $dt->slug_turma) }}"
                                                class="dropdown-item" target="_blank">Pauta Anual</a>
                                            <a href="{{ route('notas-finais.inserir', $dt->slug_turma) }}"
                                                class="dropdown-item">Inserir Notas Finais</a>
                                        @endif

                                    </div>

                                </div>

                            </td>
                            <div class="modal fade bd-example-modal-sm{{ $dt->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">TRIMESTRES</h5>

                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            <a target="_blank"
                                                href="{{ route('admin.pauta.trimestral', ['slug_turma' => $dt->slug_turma, 'trimestre' => 'I']) }}"
                                                class="dropdown-item">Iº TRIMESTRE</a>
                                            <a target="_blank"
                                                href="{{ route('admin.pauta.trimestral', ['slug_turma' => $dt->slug_turma, 'trimestre' => 'II']) }}"
                                                class="dropdown-item">IIº TRIMESTRE</a>
                                            <a target="_blank"
                                                href="{{ route('admin.pauta.trimestral', ['slug_turma' => $dt->slug_turma, 'trimestre' => 'III']) }}"
                                                class="dropdown-item">IIIº TRIMESTRE</a>

                                        </div>

                                    </div>
                                </div>
                            </div>
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
    @include('admin.layouts.footer')


@endsection
