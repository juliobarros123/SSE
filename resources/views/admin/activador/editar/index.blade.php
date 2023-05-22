@extends('layouts.admin')

@section('titulo', 'Activador de Candidatura/Editar')

 @section('conteudo')
    <div class="card mt-3" >
        <div class="card-body">
            <h3>Editar Activador de Candidatura <b>{{ $activador->id }}</b></h3>
        </div>
    </div>



 
    <div class="card">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <form action=" {{ route('admin/cadeado_candidatura/atualizar', $activador->id) }}" method="post" class="row">
                @csrf
                @method('PUT')

                <div class="form-group col-sm-2">
                    <label for="" class="form-label">ID do Activador</label>
                    <input type="text" class="form-control" value="{{ isset($activador->id) ? $activador->id : '' }}" disabled>
                </div>

                @include('forms._formActivadordCandidatura.index')
                <div class="form-group col-sm-2">
                    <label for="" class="text-white form-label">.</label>
                    <button class="form-control btn btn-dark">Salvar Alterações</button>
                </div>
            </form>

        </div>
    </div>
    @include('admin.layouts.footer')


    @endsection

