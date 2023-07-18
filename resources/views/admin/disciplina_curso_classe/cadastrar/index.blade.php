@extends('layouts.admin')

@section('titulo', 'Cadastrar disciplinas/cursos/classes')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Cadastrar disciplinas/cursos/classes</h3>
        </div>
    </div>


    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.disciplina_curso_classe.store') }}" method="POST" class="row">
                @csrf

                @include('forms._formDisciplinaCursoClasse.index')
                 <div class="form-group col-sm-12 d-flex justify-content-center">
                    <label for="" class="text-white form-label">.</label>
                    <button class="form-control btn col-md-3 btn-dark">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer-->
    @include('admin.layouts.footer')
@endsection
