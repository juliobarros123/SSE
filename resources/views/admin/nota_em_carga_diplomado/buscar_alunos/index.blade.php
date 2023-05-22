@extends('layouts.admin')

@section('titulo', 'Buscar Alunos')

@section('conteudo')

    <div class="card mt-3">
        <div class="card-body">
            <h3>Buscar Alunos</h3>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" class="row" action="{{ url('/nota_em_carga_diplomado/mostrar_alunos') }}">
                @csrf
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Turma|Disciplina</label>

                        <select name="id_turma_user" class="form-control select-dinamico col-sm-12" required>
                            @foreach ($turmasUser as $turmaUser)
                                <option value="{{ $turmaUser->id_turma_user }}">
                                    {{ $turmaUser->vc_cursoTurma }}||{{ $turmaUser->vc_classe }}
                                    ªClasse||{{ $turmaUser->vc_nomedaTurma }}||{{ $turmaUser->vc_nome }} </option>
                            @endforeach
                        </select>

                    </div>
                </div>




                <div class="col-md-4">
                    <label for="vc_tipodaNota" class="form-label">Trimestre ou Tipo da Nota</label>
                    <select name="vc_tipodaNota" id="vc_tipodaNota" class="form-control border-secondary" required>
                        <option value="" selected disabled>seleciona o trimestre ou tipo da nota</option>
                        <option value="Final">Final</option>
                        {{-- @foreach ($permissoesNota as $permissaoNota)
                            @if ($permissaoNota->vc_trimestre == 'I' && $permissaoNota->estado == 1)
                                <option value="I">Iºtrimestre</option>
                            @endif

                            @if ($permissaoNota->vc_trimestre == 'II' && $permissaoNota->estado == 1)
                                <option value="II">IIºtrimestre</option>
                            @endif

                            @if ($permissaoNota->vc_trimestre == 'III' && $permissaoNota->estado == 1)
                                <option value="III">IIIºtrimestre</option>
                            @endif
                        @endforeach --}}



                        {{-- <option value="EE">Exame Especial</option>
                    <option value="EP" >Exame Provincial</option> --}}

                    </select>
                </div>




                <div class="col-md-4">
                    <label for="id_anoLectivo" class="form-label">Ano Lectivo actual</label>






                        @if (isset($ano_lectivo_publicado))
                        <select name="id_anoLectivo" id="id_anoLectivo" class="form-control border-secondary" readonly required>
                            <option value="{{ $id_anoLectivo_publicado }}">{{ $ano_lectivo_publicado }}</option>
                        </select>
                            <p class="text-danger  "> Atenção: Ano lectivo publicado</p>
                        @else
                            @isset($anoActual->id)
                            <select name="id_anoLectivo" id="id_anoLectivo" class="form-control border-secondary" readonly required>
                                <option value="{{ $anoActual->id }}">{{ $anoActual->ya_inicio . '-' . $anoActual->ya_fim }}
                                </option>
                            </select>
                            @endisset
                        @endif






                </div>

                <div class=" col-md-12 text-center">
                    <input type="submit" class=" col-md-2 text-center btn btn-dark" value="Buscar" id="inserir">
                </div>
            </form>

        </div>
    </div>



    <!-- sweetalert -->
    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
    @if (session('ExisteNota'))
        <script>
            Swal.fire(
                'Falha ao Introduzir a Nota!',
                'Nota do Aluno já foi introduzida',
                'error'
            )
        </script>
    @endif

    @if (session('semNotas'))
        <script>
            Swal.fire(
                'Falha ao Introduzir a Nota!',
                'Não informou nenhuma nota',
                'error'
            )
        </script>
    @endif

    @if (session('notaIncompleta'))
        <script>
            Swal.fire(
                'Aviso ao Introduzir a Nota!',
                'Provavelmente tem alunos que não têm nota',
                'warning'
            )
        </script>
    @endif



    @if (session('status'))
        <script>
            Swal.fire(
                'Nota inserida ',
                '',
                'success'
            )
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire(
                'Falha ao Introduzir a Nota!',
                'Verifica o relacionamento da disciplina com curso',
                'error'
            )
        </script>
    @endif

    <!-- Footer-->
    <script>
        $(document).ready(function() {
    $('.turmas_select').select2();
});

    </script>
    @include('admin.layouts.footer')


@endsection
