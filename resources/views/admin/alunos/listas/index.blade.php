@extends('layouts.admin')
@section('titulo', 'Imprimir Lista de Candidatos Aceitos')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <div class="row col-md-12">
                <div class="col-md-10">
                    <h3>Imprimir Lista de Candidatos Aceitos
                    </h3>
                </div>
              
            </div>

        </div>
    </div>



    @if (isset($errors) && count($errors) > 0)
        <div class="text-center mt-4 mb-4 alert-danger">
            @foreach ($errors->all() as $erro)
                <h5>{{ $erro }}</h5>
            @endforeach
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.ListadSelecionado.recebeSelecionados') }}" class="row" method="POST"
                target="_blank">
                @csrf
                <div class="form-group col-md-4">
                    <label for="vc_anolectivo" class="form-label">Ano Lectivo:</label>


                    @if (isset($ano_lectivo_publicado))
                        <select name="id_ano_lectivo" id="id_ano_lectivo" class="form-control" readonly>
                            <option value="{{ $id_anoLectivo_publicado }}">
                                {{ $ano_lectivo_publicado }}
                            </option>
                        </select>
                        <p class="text-danger  "> Atenção: Ano lectivo publicado</p>
                    @else

                        <select name="id_ano_lectivo" id="id_ano_lectivo" class="form-control">
                            <option value="Todos" >Todos</option>

                            @foreach ($anoslectivos as $anolectivo)
                                <option value="{{ $anolectivo->id }}">
                                    {{ $anolectivo->ya_inicio . '-' . $anolectivo->ya_fim }}
                                </option>
                            @endforeach
                        </select>
                    @endif


                </div>
                <div class="form-group col-md-4">
                    <label for="id_curso" class="form-label">Curso:</label>
                    <select name="id_curso" id="id_curso" class="form-control">
                        <option value="Todos" >Todos</option>

                        @foreach ($cursos as $curso)
                            <option value="{{ $curso->id }}">
                                {{ $curso->vc_nomeCurso }}
                            </option>
                        @endforeach
                    </select>

                </div>
                <div class="form-group col-md-4">
                    <label for="id_classe" class="form-label">Classe:</label>
                    <select name="id_classe" id="id_classe" class="form-control">
                        <option value="Todas" >Todas</option>
                        @foreach ($classes as $classe)
                            <option value="{{ $classe->id }}">
                                {{ $classe->vc_classe }}ª classe
                            </option>
                        @endforeach
                    </select>

                </div>

                <div class="form-group col-md-12 d-flex justify-content-center">

                    <button class="form-control btn btn-dark w-25">Pesquisar</button>
                </div>

            </form>
        </div>
    </div>

    @include('admin.layouts.footer')

@endsection
