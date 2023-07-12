@extends('layouts.admin')

@section('titulo', 'Lista de Atribuição de Turmas')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Lista de Atribuição de Turmas</h3>
        </div>
    </div>

    @if (Auth::user()->vc_tipoUtilizador != 'Visitante')
        <div class="d-flex justify-content-end mb-3">
            <a class="btn btn-dark" href="{{ url('/admin/atribuicoes/cadastrar') }}">
                <strong class="text-light">Atribuir Turma</strong>
            </a>

            @if (Auth::user()->vc_tipoUtilizador == 'Administrador' ||
                    Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
                    Auth::user()->vc_tipoUtilizador == 'Coordenação Pedagógica' ||
                    Auth::user()->vc_tipoUtilizador == 'Preparador')
            @endif
        </div>
    @endif
    {{-- @dump($atribuicoes) --}}


    <table id="example" class="display table table-hover">
        <thead class="">
            <tr>
                <th>ID</th>
                <th>PROFESSOR</th>
                <th>CURSO</th>
                <th>ANO LECTIVO</th>
                <th>TURMA</th>
                <th>CLASSE</th>
                <th>ALUNOS</th>
                <th>DISCIPLINA</th>
                <th>ACÇÕES</th>
            </tr>
        </thead>
        <tbody>
            @if ($atribuicoes)
                @foreach ($atribuicoes as $atribuicao)
                    <tr class="">
                        <th>{{ $atribuicao->id }}</th>
                        <th>{{ $atribuicao->vc_primemiroNome }} {{ $atribuicao->vc_apelido }}</th>
                        <td>{{ $atribuicao->vc_nomeCurso }}</td>
                        <td>{{ $atribuicao->ya_inicio }}/{{ $atribuicao->ya_fim }}</td>
                        <td>{{ $atribuicao->vc_nomedaTurma }}</td>
                        <td>{{ $atribuicao->vc_classe }}ª Classe</td>
                        <td>{{ $atribuicao->it_qtMatriculados }} </td>
                        <td>{{ $atribuicao->disciplina }} </td>

                        <td>

                            @if (Auth::user()->vc_tipoUtilizador != 'Visitante')
                                <div class="dropdown">
                                    <button class="btn btn-dark btn-sm dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="fa fa-clone fa-sm" aria-hidden="true"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a href="{{ route('admin.atribuicoes.editar', $atribuicao->slug) }}"
                                            class="dropdown-item">Editar</a>
                                        <a href="{{ route('admin.atribuicoes.excluir', $atribuicao->slug) }}"
                                            class="dropdown-item"
                                            data-confirm="Tem certeza que deseja eliminar?">Eliminar</a>
                                        <a href="" class="dropdown-item" data-toggle="modal"
                                            data-target=".bd-example-modal-sm{{ $atribuicao->id }}">Pauta</a>
                                        <a href="" class="dropdown-item" data-toggle="modal"
                                            data-target=".bd-example-modal-inserir{{ $atribuicao->id }}">Inserir</a>
                                        {{-- <a data-toggle="modal" data-target=".bd-example-modal-lg{{ $atribuicao->ident }}"
                                            class="dropdown-item">Disciplinas</a> --}}
                                    </div>
                                </div>
                            @endif

                        </td>
                    </tr>





                    <div class="modal fade bd-example-modal-sm{{ $atribuicao->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">TRIMESTRES</h5>

                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                @php
                                    $disciplina_curso_classe = fhap_disciplinas_cursos_classes($atribuicao->id_disciplina, $atribuicao->it_idCurso, $atribuicao->it_idClasse);
                                    //    dd(                                $disciplina_curso_classe);
                                @endphp
                               
                                    @if ($disciplina_curso_classe)
                                        <a target="_blank"
                                            href="{{ route('admin.pauta.mini.disciplina', ['slug_turma_user' => $atribuicao->slug, 'trimestre' => 'I', 'slug_disciplina_curso_classe' => $disciplina_curso_classe->slug]) }}"
                                            class="dropdown-item">Iº TRIMESTRE</a>

                                        <a target="_blank"
                                            href="{{ route('admin.pauta.mini.disciplina', ['slug_turma_user' => $atribuicao->slug, 'trimestre' => 'II', 'slug_disciplina_curso_classe' => $disciplina_curso_classe->slug]) }}"
                                            class="dropdown-item">IIº TRIMESTRE</a>

                                        <a target="_blank"
                                            href="{{ route('admin.pauta.mini.disciplina', ['slug_turma_user' => $atribuicao->slug, 'trimestre' => 'III', 'slug_disciplina_curso_classe' => $disciplina_curso_classe->slug]) }}"
                                            class="dropdown-item">IIIº TRIMESTRE</a>
                                    @else
                                        <small class="text-danger w-100">Para inserir nota, configura( Disciplina\Curso\Classe)
                                        </small>
                                    @endif

                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="modal fade bd-example-modal-inserir{{ $atribuicao->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-center" id="exampleModalLabel">INSERIR NOTA <br>
                                        ESCOLHA O TRIMESTRE</h5>
                                    {{-- <small class="text-info">Clica no trimestre</small> --}}
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                @if ($disciplina_curso_classe)
                                    <div class="modal-body">
                                        <a target="_blank"
                                            href="{{ route('nota_em_carga.alunos', ['slug_turma_user' => $atribuicao->slug, 'trimestre' => 'I']) }}"
                                            class="dropdown-item">Iº TRIMESTRE</a>
                                        <a target="_blank"
                                            href="{{ route('nota_em_carga.alunos', ['slug_turma_user' => $atribuicao->slug, 'trimestre' => 'II']) }}"
                                            class="dropdown-item">IIº TRIMESTRE</a>
                                        <a target="_blank"
                                            href="{{ route('nota_em_carga.alunos', ['slug_turma_user' => $atribuicao->slug, 'trimestre' => 'III']) }}"
                                            class="dropdown-item">IIIº TRIMESTRE</a>

                                    </div>
                                    @else
                                    <small class="text-danger">Para inserir nota, configura( Disciplina\Curso\Classe)
                                    </small>
                                @endif
                            </div>
                        </div>
                    </div>
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


    @if (session('atribuicao.eliminar.success'))
        <script>
            Swal.fire(
                'Turma do Professor Eliminada Com Sucesso! ',
                '',
                'success'
            )
        </script>
    @endif
    @if (session('atribuicao.eliminar.error'))
        <script>
            Swal.fire(
                'Erro ao Eliminar Turma do Professor! ',
                '',
                'error'
            )
        </script>
    @endif

    @if (session('atribuicao.purgar.success'))
        <script>
            Swal.fire(
                'Turma do Professor Purgada Com Sucesso! ',
                '',
                'success'
            )
        </script>
    @endif
    @if (session('atribuicao.purgar.error'))
        <script>
            Swal.fire(
                'Erro ao Purgar Turma do Professor! ',
                '',
                'error'
            )
        </script>
    @endif

    @if (session('atribuicao.recuperar.success'))
        <script>
            Swal.fire(
                'Turma do Professor Recuperada Com Sucesso! ',
                '',
                'success'
            )
        </script>
    @endif
    @if (session('atribuicao.recuperar.error'))
        <script>
            Swal.fire(
                'Erro ao Recuperar Turma do Professor! ',
                '',
                'error'
            )
        </script>
    @endif
@endsection
