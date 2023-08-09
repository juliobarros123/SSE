@extends('layouts.admin')

@section('titulo', 'Importar Alunos')

@section('conteudo')

    <div class="card mt-3">
        <div class="card-body">
            <h3>Importar Alunos</h3>
        </div>
    </div>


    <div class="card">
        <div class="card-body">
            <h5>Essa área é para aquelas alunos que já têm processo<br>

            </h5>
            <form method="POST" class="row m-2" action="{{ route('admin.alunos.cadastrar') }}">
                @csrf
                @include('site.forms._formAluno.index')
                <div class="form-group col-sm-12 d-flex justify-content-center">
                    <label for="" class="text-white form-label">.</label>
                    <button class="form-control btn col-md-3 btn-dark">Importar</button>
                </div>
            </form>
        </div>
    </div>



    @include('admin.layouts.footer')
@endsection
