@extends('layouts.admin')
@section('titulo', 'Matricular/Pesquisar')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Pesquisar Matriculados</h3>
        </div>
    </div>





    <div class="card">
        <div class="card-body">
            <form action="{{ url('Admin/recebeMatriculados') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="vc_anolectivo" class="form-label">Ano Lectivo:</label>

                        @if (isset($ano_lectivo_publicado))
                            <select name="vc_anolectivo" id="vc_anolectivo" class="form-control" readonly>
                                <option value="{{ $ano_lectivo_publicado }}">
                                    {{ $ano_lectivo_publicado }}
                                </option>
                            </select>
                            <p class="text-danger  "> Atenção: Ano lectivo publicado</p>
                        @else
                            <select name="vc_anolectivo" id="vc_anolectivo" class="form-control">
                                <option value="Todos">Todos</option>
                                @foreach ($anoslectivos as $anolectivo)
                                    <option value="{{ $anolectivo->ya_inicio . '-' . $anolectivo->ya_fim }}">
                                        {{ $anolectivo->ya_inicio . '-' . $anolectivo->ya_fim }}
                                    </option>
                                @endforeach
                            </select>
                        @endif

                    </div>
                    <div class="form-group col-md-4">
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

                    <div class="form-group col-md-4">
                        <label for="vc_curso" class="form-label">Classe:</label>
                        <select name="vc_classe" id="vc_curso" class="form-control">
                            <option value="Todos">Todos</option>
                            @foreach ($classes as $classe)
                                <option value="{{ $classe->vc_classe }}">
                                    {{ $classe->vc_classe }}
                                </option>
                            @endforeach
                        </select>

                    </div>

                </div>
                <div class="d-flex justify-content-center">

                    <button class=" btn btn-dark ">Pesquisar</button>
                </div>

            </form>
        </div>
    </div>

    @include('admin.layouts.footer')



@endsection
