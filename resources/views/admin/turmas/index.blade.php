@extends('layouts.admin')

@section('titulo', 'Turma/Listar')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Lista de turmas do Ano Lectivo: {{ isset($anolectivo) ? $anolectivo : '' }}</h3>
        </div>
    </div>
    @if (Auth::user()->vc_tipoUtilizador == 'Administrador' ||
            Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
            Auth::user()->vc_tipoUtilizador == 'Cordenação Pedagógica' ||
            Auth::user()->vc_tipoUtilizador == 'Preparador')
        <div class="d-flex justify-content-end mb-3">

         
        </div>
    @endif
    {{-- @dump($turmas ) --}}
   <div class="table-responsive">
    <table id="example" class="display table table-hover">
           <thead class="">
            <tr >
                <th>ID</th>
                <th>TURMA</th>
                <th>CLASSE</th>
                @if (Auth::user()->vc_tipoUtilizador == 'Professor')
                    <th>DISCIPLINA</th>
                @endif
                <th>TURNO</th>
                <th>SALA</th>
                <th>CURSO</th>
                <th>VAGAS RESTANTES</th>
                <th>ALUNOS MATRICULADOS</th>
                <th>TOTAL DE ALUNOS</th>
                <th>ESTADO</th>
                @if (!$anolectivo)
                    <th>ANO LECTIVO</th>
                @endif
                <th>AÇÕES</th>
            </tr>
        </thead>
        <tbody class="">

            @foreach ($turmas as $turma)
                <tr class="">
                    <td>{{ $turma->id_turma ? $turma->id_turma : $turma->id }}</td>
                    <td>{{ $turma->vc_nomedaTurma }}</td>
                    <td>{{ $turma->vc_classe }}ª Classe</td>
                    @if (Auth::user()->vc_tipoUtilizador == 'Professor')
                        <td>{{ $turma->disciplina }}</td>
                    @endif

                    <td>
                      
                        {{ $turma->vc_turnoTurma }}
                       
                    </td>
                    {{-- @dump($turma) --}}
                    <td>{{ $turma->vc_salaTurma }}</td>
                    <td class="text-left">{{ $turma->vc_nomeCurso }}</td>
                    <td>{{ $turma->it_qtdeAlunos - $turma->it_qtMatriculados }}</td>
                    <td>{{ $turma->it_qtMatriculados }}</td>
                    <td>{{ $turma->it_qtdeAlunos }}</td>
                    <td>
                        @if ($turma->it_qtdeAlunos == $turma->it_qtMatriculados)
                            <b class="text-primary">Fechada</b>
                        @else
                            <b class="text-success">Aberta</b>
                        @endif
                    </td>
                    @if (!$anolectivo)
                        <td>{{ $turma->vc_anoLectivo }}</td>
                    @endif
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-clone" aria-hidden="true"></i>
                            </button>

                       
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                    <a href="{{ route('turmas.imprimir_alunos', $turma->slug ) }}"
                                        class="dropdown-item" target="_blank">Lista</a>
                                 
                                    <a href="{{ route('admin.atribuicao.professores', $turma->slug) }}"
                                        class="dropdown-item" target="_blank">Professores</a>
                                        <a href="" class="dropdown-item" data-toggle="modal"
                                        data-target=".bd-example-modal-sm{{ $turma->id }}">Pauta Trimestral</a>
                                    <a href="{{ route('admin.pautaFinal.gerar', $turma->id_turma ? $turma->id_turma : $turma->id) }}"
                                        class="dropdown-item" target="_blank">Pauta final</a>
                                       
                                    @if (Auth::user()->vc_tipoUtilizador != 'Professor')
                                        <a href="{{ route('turmas.editar',  $turma->slug) }}"
                                            class="dropdown-item">Editar</a>
                                            @if (Auth::user()->vc_tipoUtilizador == 'Administrador' ||
                                            Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
                                            Auth::user()->vc_tipoUtilizador == 'Cordenação Pedagógica' 
                                    )
                                        <a href="{{ route('notas-seca.inserir', $turma->id_turma ? $turma->id_turma : $turma->id) }}"
                                            class="dropdown-item">Inserir nota seca</a>
                                            @endif
                                        <a href="{{ route('turmas.eliminar', ['slug' => $turma->slug]) }}"
                                            class="dropdown-item"
                                            data-confirm="Tem certeza que deseja eliminar?">Eliminar</a>
                                
                                    @endif
                                </div>
                        
                        </div>

                    </td>

                    
                    <div class="modal fade bd-example-modal-sm{{ $turma->id }}" tabindex="-1" role="dialog"
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
                                        href="{{ route('admin.pauta.trimestral', ['slug_turma' => $turma->slug, 'trimestre' => 'I']) }}"
                                        class="dropdown-item">Iº TRIMESTRE</a>
                                    <a target="_blank"
                                        href="{{ route('admin.pauta.trimestral', ['slug_turma' => $turma->slug, 'trimestre' => 'II']) }}"
                                        class="dropdown-item">IIº TRIMESTRE</a>
                                    <a target="_blank"
                                        href="{{ route('admin.pauta.trimestral', ['slug_turma' => $turma->slug, 'trimestre' => 'III']) }}"
                                        class="dropdown-item">IIIº TRIMESTRE</a>
                               
                                </div>

                            </div>
                        </div>
                    </div>
                </tr>
            @endforeach
        </tbody>

    </table>
   </div>



    @include('admin.layouts.footer')
    <!-- sweetalert -->
    <script src="{{ asset('/js/datatables/jquery-3.5.1.js') }}"></script>

    {{-- sweetalert --}}
    <script src="{{ asset('/js/sweetalert2.all.min.js') }}"></script>

    @if (session('status'))
        <script>
            Swal.fire(
                'Cadastro Efectuado!',
                'Turma cadastrada com sucesso',
                'success'
            )
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire(
                'Erro ao gerar pauta!',
                'Verifica se a turma tem alunos ou disciplinas',
                'error'
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


@if (session('turma.eliminar.success'))
<script>
    Swal.fire(
        'Turma Eliminada Com Sucesso! ',
        '',
        'success'
    )
</script>
@endif
@if (session('turma.eliminar.error'))
<script>
    Swal.fire(
        'Erro ao Eliminar Turma! ',
        '',
        'error'
    )
</script>
@endif

@if (session('turma.purgar.success'))
<script>
    Swal.fire(
        'Turma Purgada Com Sucesso! ',
        '',
        'success'
    )
</script>
@endif
@if (session('turma.purgar.error'))
<script>
    Swal.fire(
        'Erro ao Purgar Turma! ',
        '',
        'error'
    )
</script>
@endif

@if (session('turma.recuperar.success'))
<script>
    Swal.fire(
        'Turma Recuperada Com Sucesso! ',
        '',
        'success'
    )
</script>
@endif
@if (session('turma.recuperar.error'))
<script>
    Swal.fire(
        'Erro ao Recuperar Turma! ',
        '',
        'error'
    )
</script>
@endif

@endsection
