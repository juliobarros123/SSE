@extends('layouts.admin')

@section('titulo', 'Disciplina/Editar')

 @section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Editar Disciplinas</h3>
        </div>
    </div>

    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
    @if (session('disciplina'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Disciplina já existe',
            })

        </script>
    @endif

    <div class="card">
        <div class="card-body">
            <form class="row" action="{{ route('admin.disciplinas.editar.index', $disciplina->id) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="form-group col-md-1">
                    <label for="id" class="form-label">Id</label>
                    <input class="form-control border-secondary" name="id"
                        value="{{ isset($disciplina->id) ? $disciplina->id : '' }}" id="id" disabled />
                </div>
                @include('forms._formDisciplina.index')

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



