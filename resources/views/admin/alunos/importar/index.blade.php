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
            <form method="POST" class="row m-2" action="{{ route('admin.alunos.cadastrar') }}">
                @csrf
                @include('site.forms._formAluno.index')

                <div class="col-4">
                    <label class="form-label text-white">.</label><br>
                    <button id="btn_consulta" class="form-control col-4 btn btn-dark">Importar</button>
                </div>
            </form>
        </div>
    </div>



    @include('admin.layouts.footer')
@endsection
