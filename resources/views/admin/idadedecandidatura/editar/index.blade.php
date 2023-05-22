@extends('layouts.admin')

@section('titulo', 'Idade Candidatura/Editar')

 @section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Editar  <b>{{ $idadedecandidatura->id }}</b></h3>
        </div>
    </div>



 
    <div class="card">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <form action=" {{ route('admin/idadedecandidatura/atualizar', $idadedecandidatura->id) }}" method="post" class="row">
                @csrf
                @method('PUT')

                <div class="form-group col-sm-2">
                    <label for="" class="form-label">ID</label>
                    <input type="text" class="form-control" value="{{ isset($idadedecandidatura->id) ? $idadedecandidatura->id : '' }}" disabled>
                </div>

                @include('forms._formIdadedeCandidatura.index')
                <div class="form-group col-sm-2">
                    <label for="" class="text-white form-label">.</label>
                    <button class="form-control btn btn-dark">Salvar Alterações</button>
                </div>
            </form>

        </div>
    </div>
    <!-- Footer-->
    @include('admin.layouts.footer')

@endsection

