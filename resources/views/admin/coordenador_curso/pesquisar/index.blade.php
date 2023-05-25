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
            <form action="{{ route('admin.turmas.ver') }}" class="row" method="POST">
                @csrf
                <div class="form-group col-md-4">
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


