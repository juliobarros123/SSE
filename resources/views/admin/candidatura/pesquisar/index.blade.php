@extends('layouts.admin')
@section('titulo', 'Candidatura/Pesquisar')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Pesquisar Candidatos</h3>
        </div>
    </div>
    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
    @if (session('teste'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Candidato Inexistente',
            })
        </script>
    @endif

    @if (isset($errors) && count($errors) > 0)
        <div class="text-center mt-4 mb-4 alert-danger">
            @foreach ($errors->all() as $erro)
                <h5>{{ $erro }}</h5>
            @endforeach
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ url('candidatos/recebecandidaturas') }}" class="row" method="POST">
                @csrf
                <div class="form-group col-md-4">
                    <label for="vc_anolectivo" class="form-label">Ano Lectivo:</label>


                    {{-- @if (isset($ano_lectivo_publicado))
                        <select name="id_ano_lectivo" id="id_ano_lectivo" class="form-control" readonly>
                            <option value="{{ $id_anoLectivo_publicado }}">
                                {{ $ano_lectivo_publicado }}
                            </option>
                        </select>
                        <p class="text-danger  "> Atenção: Ano lectivo publicado</p>
                    @else --}}

                        <select name="id_ano_lectivo" id="id_ano_lectivo" class="form-control">
                            {{-- <option value="Todos" >Todos</option> --}}
                            @foreach ($anoslectivos as $anolectivo)
                                <option value="{{ $anolectivo->id }}">
                                    {{ $anolectivo->ya_inicio . '-' . $anolectivo->ya_fim }}
                                </option>
                            @endforeach
                        </select>
                    {{-- @endif --}}


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
                {{-- <div class="card col-sm-12">
                    <div class="card-body ">
                        <div class="d-flex justify-content-end">
                            <div class="form-group w-25">
                                <label for="tipo_filtro" class="form-label">Tipo filtro:</label>
                                <select name="tipo_filtro" id="tipo_filtro" class="form-control">
                                    <option value="0" disabled selected> Seleciona o filtro</option>
                                    <option value="1"> Somente média</option>
                                    <option value="2"> Somente idade</option>
                                    <option value="3"> Por idade e por média</option>
                                    <option value="4"> Intervalo de idades</option>
                                    <option value="5"> Intervalo de idades com média</option>
                                </select>

                            </div>
                        </div>

                        <div class="d-flex justify-content-center" id="nota_idade">
                            <div class="form-group  w-100  text-center row nota_idade">
                                <div class="form-group col-sm-6">
                                    <label for="tipo_filtro" class=" form-label text-center nota_idade">Média:</label>
                                    <input type="text" class="form-control  w-100  nota_idade " name="nota_unica13">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="tipo_filtro" class=" form-label text-center nota_idade">Idade:</label>
                                    <input type="text" class="form-control  w-100 nota_idade" name="idade_unica13">
                                </div>

                            </div>
                        </div>

                        <div class="d-flex justify-content-center so_nota" id="so_nota">
                            <div class="form-group  w-100  text-center so_nota">
                                <label for="tipo_filtro " class=" form-label text-center so_nota">Média:</label>
                                <input type="number" class="form-control  w-100  so_nota" name="nota_unica11">
                            </div>
                        </div>

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




                        <div class="d-flex justify-content-center intervalo_de_idade_nota" id="intervalo_de_idade_nota">
                            <div class="form-group  w-100  text-center row intervalo_de_idade_nota">
                                <div class="form-group col-sm-4 intervalo_de_idade_nota">
                                    <label for="tipo_filtro" class=" form-label text-center intervalo_de_idade_nota">Idade
                                        inicial:</label>
                                    <input type="text" class="form-control  w-100  intervalo_de_idade_nota" name="idade51">
                                </div>
                                <div class="form-group col-sm-4 intervalo_de_idade_nota">
                                    <label for="tipo_filtro " class=" form-label text-center intervalo_de_idade_nota">Idade
                                        final:</label>
                                    <input type="text" class="form-control  w-100  intervalo_de_idade_nota" name="idade52">
                                </div>
                                <div class="form-group col-sm-4 intervalo_de_idade_nota">
                                    <label for="tipo_filtro"
                                        class=" form-label text-center intervalo_de_idade_nota">Média:</label>
                                    <input type="text" class="form-control  w-100  intervalo_de_idade_nota"
                                        name="nota_unica5">
                                </div>
                            </div>
                        </div>

                    </div>
                </div> --}}


                 <div class="form-group col-sm-12 d-flex justify-content-center">
                    <label for="" class="text-white form-label">.</label>
                    <button class="form-control btn col-md-3 btn-dark">Pesquisar</button>
                </div>

            </form>
        </div>
    </div>

    @include('admin.layouts.footer')



@endsection
