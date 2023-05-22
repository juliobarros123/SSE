@extends('layouts.admin')
@section('titulo', 'Alunos/Imprimir')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <div class="row col-md-12">
                <div class="col-md-10">
                    <h3>Imprimir lista dos selecionados à Matrícula</h3>
                </div>
                <div class="col-md-2">
                    <a type="submit" href="{{ route('admin.lista_elecionado.recebe_selecionados_pdf') }}"
                        class="btn btn-primary">Atualizar</a>
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
    <form action="{{ route('admin.selecionados.recebe_selecionados2') }}" class="" method="POST"
        target="_blank">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @csrf
                    <div class="form-group col-md-4">
                        <label for="vc_anolectivo" class="form-label">Ano Lectivo:</label>

                        @if (isset($ano_lectivo_publicado))
                            <select name="vc_anolectivo" id="vc_anolectivo" class="form-control" readonly>
                                <option value="{{ $ano_lectivo_publicado }}">
                                    {{ $ano_lectivo_publicado }}
                                </option>
                            </select>

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
                <div class="card">
                    <div class="card-body ">
                        <div class="d-flex justify-content-end">
                            <div class="form-group w-25">
                                <label for="tipo_filtro" class="form-label">Tipo filtro:</label>
                                <select name="tipo_filtro" id="tipo_filtro" class="form-control">
                                    <option value="0" disabled selected> Seleciona o filtro</option>

                                    <option value="2"> Somente idade</option>

                                    <option value="4"> Intervalo de idades</option>

                                </select>

                            </div>
                        </div>

                        <div class="d-flex justify-content-center" id="nota_idade">
                            <div class="form-group  w-100  text-center row nota_idade">

                                <div class="form-group col-sm-6">
                                    <label for="tipo_filtro" class=" form-label text-center nota_idade">Idade:</label>
                                    <input type="text" class="form-control  w-100 nota_idade" name="idade_unica13">
                                </div>

                            </div>
                        </div>


                        {{--  --}}

                        <div class="d-flex justify-content-center w-100 so_idade " id="so_idade">
                            <div class="form-group w-100 text-center so_idade">
                                <label for="tipo_filtro " class=" form-label text-center so_idade">Idade:</label>
                                <input type="number" class="form-control w-100 so_idade" name="idade_unica12">
                            </div>
                        </div>

                        <div class="d-flex justify-content-center intervalo_de_idade" id="intervalo_de_idade">
                            <div class="form-group  w-100  text-center row intervalo_de_idade">
                                <div class="form-group   col-sm-6 intervalo_de_idade">
                                    <label for="tipo_filtro" class=" form-label text-center intervalo_de_idade">Idade
                                        inicial:</label>
                                    <input type="text" class="form-control intervalo_de_idade  w-100 " name="idade1">
                                </div>
                                <div class="form-group col-sm-6 intervalo_de_idade">
                                    <label for="tipo_filtro" class=" form-label text-center intervalo_de_idade">Idade
                                        final</label>
                                    <input type="text" class="form-control intervalo_de_idade  w-100 " name="idade2">
                                </div>

                            </div>
                        </div>






                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <div class="form-group col-md-3 ">
                        <button class="form-control btn btn-dark">Pesquisar</button>
                    </div>

                </div>
            </div>
        </div>
    </form>
    @include('admin.layouts.footer')

@endsection
