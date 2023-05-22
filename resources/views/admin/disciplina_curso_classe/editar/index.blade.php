@extends('layouts.admin')

@section('titulo', 'Relacionamento de Disciplina/Editar')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Editar Relacionamento de Disciplina</h3>
        </div>
    </div>




    <div class="card">
        <div class="card-body">
            <form class="row" action="{{ route('admin.disciplina_curso_classe.update', $resposta->id) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="form-group col-md-1">
                    <label for="id" class="form-label">ID</label>
                    <input class="form-control border-secondary" name="id"
                        value="{{ isset($resposta->id) ? $resposta->id : '' }}" id="id" disabled />
                </div>
                @include('forms._formDisciplinaCursoClasse.index')

                <div class="form-group col-md-2">
                    <label for="" class="form-label text-white">.</label>
                    <button class="form-control btn btn-dark">Salvar Alterações</button>
                </div>

            </form>
        </div>
    </div>

    <!-- Footer-->
    @include('admin.layouts.footer')
@endsection
