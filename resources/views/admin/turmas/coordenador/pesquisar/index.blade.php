@extends('layouts.admin')
@section('titulo', 'Turma/Pesquisar')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Pesquisar Turmas</h3>
        </div>
    </div>




    <div class="card">
        <div class="card-body">
            <form action="{{ route('direitor-turma.turmas') }}" class="row" method="POST">
                @csrf
                <div class="form-group col-md-4">
                    <label for="id_anolectivo" class="form-label">Ano Lectivo:</label>
                    @if (isset($ano_lectivo_publicado))
                        <select name="id_anolectivo" id="id_anolectivo" class="form-control" readonly>
                            <option value="{{ $id_anoLectivo_publicado }}">
                                {{ $ano_lectivo_publicado }}
                            </option>
                        </select>
                        <p class="text-danger  "> Atenção: Ano lectivo publicado</p>
                    @else


                        <select name="id_anolectivo" id="id_anolectivo" class="form-control">
                            <option value="Todos">Todos</option>
                            @foreach ($anoslectivos as $anolectivo)
                                <option value="{{ $anolectivo->id }}">
                                    {{ $anolectivo->ya_inicio . '-' . $anolectivo->ya_fim }}
                                </option>
                            @endforeach
                        </select>
                    @endif

                </div>
                <div class="form-group col-md-5">
                    <label for="vc_curso" class="form-label">Curso:</label>
                    <select name="vc_curso" id="vc_curso" class="form-control">
                        <option value="Todos">Todos</option>
                        @foreach ($cursos as $curso)
                            <option value="{{ $curso->vc_nomeCurso }}">
                                {{ $curso->vc_nomeCurso }}
                            </option>
                        @endforeach
                    </select>

                </div>

                <div class="form-group col-md-3">
                    <label for="" class="form-label text-white">.</label>
                    <button class="form-control btn btn-dark">Pesquisar</button>
                </div>

            </form>
        </div>
    </div>

    @include('admin.layouts.footer')
    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>

    @if (session('aviso'))
        <script>
            Swal.fire(
                'Aviso',
                'Não existe nenhum Aluno nesta turma',
                'error'
            )
        </script>
    @endif
@endsection
