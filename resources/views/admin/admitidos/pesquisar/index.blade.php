@extends('layouts.admin')
@section('titulo', 'Alunos/Listar')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Pesquisar Selecionados à Matrícula</h3>
        </div>
    </div>



    @if (isset($errors) && count($errors) > 0)
        <div class="text-center mt-4 mb-4 alert-danger">
            @foreach ($errors->all() as $erro)
                <h5>{{ $erro }}</h5>
            @endforeach
        </div>
    @endif


    <form action="{{ route('admin.selecionados.recebe_selecionados') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="row d-flex justify-content-center ">
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


                </div>


            </div>
        </div>


        <div class=" d-flex justify-content-center">

            <button class="form-control btn btn-dark">Pesquisar</button>
        </div>
    </form>

    @include('admin.layouts.footer')


@endsection
