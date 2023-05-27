@extends('layouts.admin')

@section('titulo', 'Turma/Listar')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Lista de turmas do Ano Lectivo: {{ $anolectivo }}</h3>
        </div>
    </div>


    <table id="example" class="display table table-hover">
           <thead class="">
            <tr class="text-center">
                <th>ID</th>
                <th>TURMA</th>
                <th>CLASSE</th>
                {{-- @if (Auth::user()->vc_tipoUtilizador == 'Professor')
                    <th>DISCIPLINA</th>
                @endif --}}
                <th>TURNO</th>
                <th>CURSO</th>
                <th>VAGAS RESTANTES</th>
                <th>ALUNOS MATRICULADOS</th>
                <th>TOTAL DE ALUNOS</th>
                <th>ESTADO</th>
                @if (!$anolectivo)
                    <th>ANO LECTIVO</th>
                @endif
                <th>DIRECTOR</th>
                <th>AÇÕES</th>
            </tr>
        </thead>
        <tbody class="bg-white">

            @foreach ($turmas as $row)

                <tr class="text-center">
                    <td>{{ $row->id }}</td>
                    <td>{{ $row->vc_nomedaTurma }}</td>
                    <td>{{ $row->vc_classeTurma }}ª</td>
                    {{-- @if (Auth::user()->vc_tipoUtilizador == 'Professor')
                    <td>{{ $row->vc_nome }}</td>
                @endif --}}

                    <td>
                        @if ($row->vc_turnoTurma == 'DIURNO')
                            <b class="bg-warning">DIURNO</b>
                        @elseif($row->vc_turnoTurma == "NOITE")
                            <b class="bg-dark">NOITE</b>
                        @elseif($row->vc_turnoTurma == "MANHÃ")
                            <b class="bg-info">MANHÃ</b>
                        @elseif($row->vc_turnoTurma == "TARDE")
                            <b class="bg-primary">TARDE</b>
                        @elseif($row->vc_turnoTurma == "Sabática")
                            <b class="bg-secondary">Sabática</b>
                        @else
                            <b>{{ $row->vc_turnoTurma }}</b>
                        @endif
                    </td>
                    <td class="text-left">{{ $row->vc_cursoTurma }}</td>
                    <td>{{ $row->it_qtdeAlunos - $row->it_qtMatriculados }}</td>
                    <td>{{ $row->it_qtMatriculados }}</td>
                    <td>{{ $row->it_qtdeAlunos }}</td>
                    <td>
                        @if ($row->it_qtdeAlunos == $row->it_qtMatriculados)
                            <b class="text-primary">Fechada</b>
                        @else
                            <b class="text-success">Aberta</b>
                        @endif
                    </td>
                    @if (!$anolectivo)
                        <td>{{ $row->vc_anoLectivo }}</td>
                    @endif

                    <td>{{ $row->vc_primemiroNome}}  {{ $row->vc_apelido}}  </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-clone" aria-hidden="true"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a href="{{ route('turmas.imprimir_alunos', $row->id) }}"
                                    class="dropdown-item" target="_blank">Listas</a>
                                <a href="{{ route('turmas.gerarcadernetaTurmas', $row->id) }}"
                                    class="dropdown-item" target="_blank">Cadernetas</a>
                                    <a href="{{ route('turmas.gerarcadernetaTurmas.xlsx', $row->id) }}"
                                        class="dropdown-item" target="_blank">Gerar xlsx</a>
                                <a href="{{ route('turmas.editar', $row->id) }}"
                                    class="dropdown-item">Editar</a>
                                <a href="{{ route('turmas.eliminar', ['id' => $row->id]) }}"
                                    class="dropdown-item" data-confirm="Tem certeza que deseja eliminar?">Eliminar</a>
                            </div>
                        </div>

                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>



    @include('admin.layouts.footer')
    <!-- sweetalert -->
    <script src="{{asset('/js/datatables/jquery-3.5.1.js')}}"></script>

    {{-- sweetalert --}}
    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>

    @if (session('status'))
        <script>
            Swal.fire(
                'Cadastro Efectuado!',
                'Turma cadastrada com sucesso',
                'success'
            )

        </script>
    @endif

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
