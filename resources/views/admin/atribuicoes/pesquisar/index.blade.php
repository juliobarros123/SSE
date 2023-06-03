@extends('layouts.admin')
@section('titulo', 'Pesquisar atribuicoes de turmas para professores')

 @section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Pesquisar atribuicoes de turmas para professores</h3>
        </div>
    </div>




    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.atribuicoes') }}" class="row" method="POST">
                @csrf
                <div class="form-group col-md-6">
                    <label for="vc_anolectivo" class="form-label">Ano Lectivo:</label>


                    @if (isset($ano_lectivo_publicado))
                        <select name="id_ano_lectivo" id="id_ano_lectivo" class="form-control" readonly>
                            <option value="{{ $id_anoLectivo_publicado }}">
                                {{ $ano_lectivo_publicado }}
                            </option>
                        </select>
                        <p class="text-danger  "> Atenção: Ano lectivo publicado</p>
                    @else
                    <option value="Todos" >Todos</option>

                        <select name="id_ano_lectivo" id="id_ano_lectivo" class="form-control">
                            <option value="" >Todos</option>
                            @foreach ($anoslectivos as $anolectivo)
                                <option value="{{ $anolectivo->id }}">
                                    {{ $anolectivo->ya_inicio . '-' . $anolectivo->ya_fim }}
                                </option>
                            @endforeach
                        </select>
                    @endif


                </div>
                <div class="form-group col-md-6">
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


                <div class="form-group col-md-12 d-flex justify-content-center">

                    <button class="form-control btn btn-dark w-25">Pesquisar</button>
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


