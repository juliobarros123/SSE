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
            <form class="row" action="{{ route('admin.disciplina_curso_classe.update', $disciplina_curso_classe->slug) }}" method="POST">
                @method('PUT')
                @csrf
               
                @include('forms._formDisciplinaCursoClasse.index')

                <div class="d-flex justify-content-center col-md-12">

                    <button class=" btn btn-dark w-25 ">Editar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer-->
    @include('admin.layouts.footer')
@endsection
