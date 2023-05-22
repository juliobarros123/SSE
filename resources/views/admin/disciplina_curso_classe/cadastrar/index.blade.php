@extends('layouts.admin')

@section('titulo', 'Relacionar Disciplina')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Relacionar Disciplina</h3>
        </div>
    </div>


    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.disciplina_curso_classe.store') }}" method="POST" class="row">
                @csrf

                @include('forms._formDisciplinaCursoClasse.index')
                <div class="form-group col-md-3">
                    <label for="" class="form-label text-white">.</label>
                    <button class="form-control  btn btn-dark">Salvar Relacionamento</button>

                </div>
            </form>
        </div>
    </div>

    <!-- Footer-->
    @include('admin.layouts.footer')
@endsection
