@extends('layouts.admin')
@section('titulo', 'Filtro de candidatos')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Filtrar Candidatos </h3>
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
            <form action="{{ url('admin/candidatos/filtro_cadidatos') }}" class="row" method="POST">
                @csrf
                <div class="form-group col-md-6">
                    <label for="vc_anolectivo" class="form-label">Ano Lectivo:</label>
                    <select name="vc_anolectivo" id="vc_anolectivo" class="form-control">
                        <option value="Todos">Todos</option>
                        @foreach ($anoslectivos as $anolectivo)
                            <option value="{{ $anolectivo->ya_inicio . '-' . $anolectivo->ya_fim }}">
                                {{ $anolectivo->ya_inicio . '-' . $anolectivo->ya_fim }}
                            </option>
                        @endforeach
                    </select>

                </div>
                <div class="form-group col-md-6">
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

                <div class="card col-sm-12" hidden>
                    <div class="card-body ">






                        {{--  --}}








                        <div class="d-flex justify-content-center " id="">
                            <div class="form-group  w-100  text-center row ">
                                <div class="form-group col-sm-6 ">
                                    <label for="tipo_filtro" class=" form-label text-center ">Idade
                                        inicial:</label>
                                    <input type="text" class="form-control  w-100  " name="idade51" value="14" readonly>
                                </div>
                                <div class="form-group col-sm-6 ">
                                    <label for="tipo_filtro " class=" form-label text-center ">Idade
                                        final:</label>
                                    <input type="text" class="form-control  w-100  " name="idade52" value="30" readonly>
                                </div>
                                <div class="form-group col-sm-6 ">
                                    <label for="tipo_filtro" class=" form-label text-center ">Média inicial:</label>
                                    <input type="text" class="form-control  w-100  " name="nota_unica5" value="10" readonly>
                                </div>

                                <div class="form-group col-sm-6 ">
                                    <label for="tipo_filtro" class=" form-label text-center ">Média final:</label>
                                    <input type="text" class="form-control  w-100  " name="nota_unica6" value="19" readonly>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>


                <div class=" d-flex justify-content-center w-100">
                    <button class="form-control btn btn-dark">Pesquisar</button>
                </div>

            </form>
        </div>
    </div>

    @include('admin.layouts.footer')



@endsection
