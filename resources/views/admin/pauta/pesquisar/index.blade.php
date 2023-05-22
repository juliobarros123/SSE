@extends('layouts.admin')
@section('titulo', 'Pautas/Pesquisar')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Pesquisar Pautas</h3>
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
            <form action="{{ url('/admin/pauta/recebepautas') }}" class="row" method="POST">
                @csrf
                <div class="form-group col-md-4">
                    <label for="vc_anolectivo" class="form-label">Ano Lectivo:</label>
                    <select name="vc_anolectivo" id="vc_anolectivo" class="form-control border-secondary" required>
                        <option value="" disabled selected>selecione o Ano Lectivo</option>
                        @foreach ($anoslectivos as $anolectivo)
                            <option value="{{ $anolectivo->ya_inicio . '-' . $anolectivo->ya_fim }}">
                                {{ $anolectivo->ya_inicio . '-' . $anolectivo->ya_fim }}
                            </option>
                        @endforeach
                    </select>

                </div>
                <div class="form-group col-md-5">
                    <label for="vc_curso" class="form-label">Curso:</label>
                    <select name="vc_curso" id="vc_curso" class="form-control border-secondary" required>
                        <option value="" disabled selected>selecione o Curso</option>
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



@endsection
